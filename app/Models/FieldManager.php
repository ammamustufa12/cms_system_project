<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FieldManager extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'field_config',
        'validation_rules',
        'source',
        'version',
        'author',
        'install_instructions',
        'dependencies',
        'is_active',
        'is_installed',
        'install_file_path',
        'sort_order'
    ];

    protected $casts = [
        'field_config' => 'array',
        'validation_rules' => 'array',
        'dependencies' => 'array',
        'is_active' => 'boolean',
        'is_installed' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && empty($model->getOriginal('slug'))) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInstalled($query)
    {
        return $query->where('is_installed', true);
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getSourceBadgeAttribute()
    {
        return match($this->source) {
            'centralized' => 'CENTRALIZED',
            'local' => 'LOCAL',
            'custom' => 'CUSTOM',
            default => 'UNKNOWN'
        };
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->is_installed && $this->is_active) {
            return 'Active';
        } elseif ($this->is_installed && !$this->is_active) {
            return 'Inactive';
        } else {
            return 'Not Installed';
        }
    }
}

