<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContentType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'fields_schema',
        'layout_config',
        'style_config',
        'field_groups',
        'visibility_rules',
        'icon',
        'color',
        'status',
        'created_by'
    ];

    protected $casts = [
        'fields_schema' => 'array',
        'layout_config' => 'array',
        'style_config' => 'array',
        'field_groups' => 'array',
        'visibility_rules' => 'array'
    ];
    public function contentItems(): HasMany
    {
        return $this->hasMany(ContentItem::class);
    }

    // Get fields in proper order
    public function getFieldsAttribute()
    {
        $fields = $this->fields_schema ?? [];
        
        // Sort by order
        uasort($fields, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });

        return $fields;
    }
    
    public function publishedItems(): HasMany
    {
        return $this->hasMany(ContentItem::class)->where('status', 'published');
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
            
            // Set created_by only if user is authenticated
            if (auth('twill_users')->check()) {
                $model->created_by = auth('twill_users')->user()->id;
            } else {
                $model->created_by = 1; // Default admin user ID
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && empty($model->getOriginal('slug'))) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
    public function getFieldsArray(): array
    {
        return $this->fields_schema ?? [];
    }

    public function getFieldByName(string $fieldName): ?array
    {
        $fields = $this->getFieldsArray();
        return $fields[$fieldName] ?? null;
    }

    public function hasField(string $fieldName): bool
    {
        return isset($this->fields_schema[$fieldName]);
    }

    public function getRequiredFields(): array
    {
        $fields = $this->getFieldsArray();
        return array_filter($fields, function ($field) {
            return $field['required'] ?? false;
        });
    }

    public function getFieldTypes(): array
    {
        $fields = $this->getFieldsArray();
        $types = [];

        foreach ($fields as $name => $field) {
            $types[$name] = $field['type'] ?? 'text';
        }

        return $types;
    }

    public function getValidationRules(): array
    {
        $rules = [];
        $fields = $this->getFieldsArray();

        foreach ($fields as $fieldName => $field) {
            $fieldRules = [];

            // Required validation
            if ($field['required'] ?? false) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            // Type-specific validation
            switch ($field['type']) {
                case 'text':
                    $fieldRules[] = 'string';
                    if (isset($field['max_length'])) {
                        $fieldRules[] = 'max:' . $field['max_length'];
                    }
                    break;

                case 'textarea':
                    $fieldRules[] = 'string';
                    break;

                case 'number':
                    $fieldRules[] = 'numeric';
                    if (isset($field['min'])) {
                        $fieldRules[] = 'min:' . $field['min'];
                    }
                    if (isset($field['max'])) {
                        $fieldRules[] = 'max:' . $field['max'];
                    }
                    break;

                case 'email':
                    $fieldRules[] = 'email';
                    break;

                case 'date':
                    $fieldRules[] = 'date';
                    break;

                case 'image':
                    $fieldRules[] = 'image';
                    if (isset($field['max_size'])) {
                        $fieldRules[] = 'max:' . $field['max_size'];
                    }
                    break;

                case 'file':
                    $fieldRules[] = 'file';
                    if (isset($field['allowed_types'])) {
                        $fieldRules[] = 'mimes:' . implode(',', $field['allowed_types']);
                    }
                    break;

                case 'select':
                    if (isset($field['options'])) {
                        $fieldRules[] = 'in:' . implode(',', array_keys($field['options']));
                    }
                    break;
            }

            $rules["field_data.{$fieldName}"] = implode('|', $fieldRules);
        }

        return $rules;
    }

    public function generateSampleData(int $count = 3): array
    {
        $sampleData = [];
        $fields = $this->getFieldsArray();

        for ($i = 1; $i <= $count; $i++) {
            $item = ['id' => $i];

            foreach ($fields as $fieldName => $field) {
                switch ($field['type']) {
                    case 'text':
                        $item[$fieldName] = "Sample " . ucfirst($fieldName) . " {$i}";
                        break;
                    case 'textarea':
                        $item[$fieldName] = "This is sample content for {$fieldName}. Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
                        break;
                    case 'number':
                        $item[$fieldName] = rand(10, 1000);
                        break;
                    case 'email':
                        $item[$fieldName] = "sample{$i}@example.com";
                        break;
                    case 'date':
                        $item[$fieldName] = now()->subDays(rand(1, 30))->format('Y-m-d');
                        break;
                    case 'image':
                        $item[$fieldName] = "https://via.placeholder.com/300x200/3498db/ffffff?text=Sample+Image+{$i}";
                        break;
                    case 'select':
                        if (isset($field['options'])) {
                            $options = array_keys($field['options']);
                            $item[$fieldName] = $options[array_rand($options)];
                        }
                        break;
                    default:
                        $item[$fieldName] = "Sample {$fieldName} value {$i}";
                }
            }

            $sampleData[] = (object) $item;
        }

        return $sampleData;
    }
}
