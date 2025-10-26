<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'label',
        'alias',
        'type',
        'field_group_id',
        'description',
        'field_config',
        'validation_rules',
        'viewable',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'field_config' => 'array',
        'validation_rules' => 'array',
        'is_active' => 'boolean'
    ];

    public function fieldGroup()
    {
        return $this->belongsTo(FieldGroup::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('label');
    }

    public function getStatusDotAttribute()
    {
        return $this->is_active ? 'green' : 'red';
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
}

