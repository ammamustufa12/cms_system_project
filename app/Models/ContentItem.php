<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentItem extends Model
{
    protected $fillable = [
        'content_type_id',
        'title',
        'slug',
        'field_data',
        'meta_data',
        'status',
        'created_by',
        'published_at'
    ];
    
    protected $casts = [
        'field_data' => 'array',
        'meta_data' => 'array',
        'published_at' => 'datetime'
    ];
    public function contentType(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }
    
    public function relatedFrom(): HasMany
    {
        return $this->hasMany(ContentRelation::class, 'from_item_id');
    }
    
    public function relatedTo(): HasMany
    {
        return $this->hasMany(ContentRelation::class, 'to_item_id');
    }
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
                
                $originalSlug = $model->slug;
                $count = 1;
                
                while (static::where('slug', $model->slug)->exists()) {
                    $model->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('title') && empty($model->getOriginal('slug'))) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

     public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }
    
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
    
    public function scopeOfType($query, $contentTypeSlug)
    {
        return $query->whereHas('contentType', function ($q) use ($contentTypeSlug) {
            $q->where('slug', $contentTypeSlug);
        });
    }
    public function getFieldValue(string $fieldName, $default = null)
    {
        return $this->field_data[$fieldName] ?? $default;
    }
    
    public function setFieldValue(string $fieldName, $value): void
    {
        $fieldData = $this->field_data ?? [];
        $fieldData[$fieldName] = $value;
        $this->field_data = $fieldData;
    }
    
    public function hasField(string $fieldName): bool
    {
        return isset($this->field_data[$fieldName]);
    }
    
    public function getFieldsAsObject(): object
    {
        $data = $this->field_data ?? [];
        $data['id'] = $this->id;
        $data['title'] = $this->title;
        $data['slug'] = $this->slug;
        $data['status'] = $this->status;
        $data['created_at'] = $this->created_at;
        $data['published_at'] = $this->published_at;
        
        return (object) $data;
    }
    
    public function publish(): bool
    {
        $this->status = 'published';
        $this->published_at = now();
        return $this->save();
    }
    
    public function unpublish(): bool
    {
        $this->status = 'draft';
        $this->published_at = null;
        return $this->save();
    }
    public function archive(): bool
    {
        $this->status = 'archived';
        return $this->save();
    }
    public function getRelatedItems($relationType = null): \Illuminate\Support\Collection
    {
        $query = $this->relatedFrom()
                     ->with('toItem.contentType');
                     
        if ($relationType) {
            $query->where('relation_type', $relationType);
        }
        
        return $query->get()->pluck('toItem');
    }
    public function addRelation(ContentItem $item, string $relationType, array $relationData = []): ContentRelation
    {
        return ContentRelation::create([
            'from_item_id' => $this->id,
            'to_item_id' => $item->id,
            'relation_type' => $relationType,
            'relation_data' => $relationData
        ]);
    }
    public function generateMetaData(): array
    {
        $contentType = $this->contentType;
        $fields = $contentType->getFieldsArray();
        
        $meta = [
            'title' => $this->title,
            'description' => '',
            'keywords' => [],
            'og_image' => null,
            'canonical_url' => url("/content/{$contentType->slug}/{$this->slug}")
        ];
        
        foreach ($fields as $fieldName => $field) {
            if ($field['type'] === 'textarea' && $this->hasField($fieldName)) {
                $content = $this->getFieldValue($fieldName);
                $meta['description'] = Str::limit(strip_tags($content), 160);
                break;
            }
        }
        
        foreach ($fields as $fieldName => $field) {
            if ($field['type'] === 'image' && $this->hasField($fieldName)) {
                $meta['og_image'] = $this->getFieldValue($fieldName);
                break;
            }
        }
        
        return $meta;
    }
    public function scopeSearch($query, string $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', "%{$searchTerm}%")
              ->orWhereJsonContains('field_data', $searchTerm);
        });
    }
    
}
