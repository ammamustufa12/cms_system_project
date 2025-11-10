<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'title',
        'alias',
        'menu_type',
        'menu_item_type',
        'url',
        'icon',
        'parent_id',
        'sort_order',
        'is_active',
        'is_visible',
        'target_window',
        'access_level',
        'styling',
        'advanced',
        'mega_menu_settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_visible' => 'boolean',
        'styling' => 'array',
        'advanced' => 'array',
        'mega_menu_settings' => 'array',
        'sort_order' => 'integer',
    ];

    /**
     * Get the parent menu item
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get child menu items
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get active children only
     */
    public function activeChildren()
    {
        return $this->children()->where('is_active', true)->where('is_visible', true)->orderBy('sort_order');
    }

    /**
     * Scope for menu type
     */
    public function scopeOfType($query, string $menuType)
    {
        return $query->where('menu_type', $menuType);
    }

    /**
     * Scope for active items
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_visible', true);
    }

    /**
     * Scope for root items (no parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get menu items tree for a specific menu type
     */
    public static function getTreeFor(string $menuType)
    {
        return static::ofType($menuType)
            ->root()
            ->active()
            ->with(['activeChildren' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
    }
}

