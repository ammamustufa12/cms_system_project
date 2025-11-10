<?php

namespace App\Helpers;

use App\Models\MenuItem;

class MenuHelper
{
    /**
     * Render menu items recursively for sidebar
     */
    public static function renderSidebarMenu($menuType = 'sidebar-left', $menuItems = null)
    {
        if ($menuItems === null) {
            $menuItems = MenuItem::getTreeFor($menuType);
        }

        $html = '';
        foreach ($menuItems as $item) {
            $hasChildren = $item->activeChildren->count() > 0;
            $isActive = request()->routeIs($item->url) || request()->url() === $item->url;
            
            $html .= self::renderMenuItem($item, $hasChildren, $isActive);
        }

        return $html;
    }

    /**
     * Render a single menu item
     */
    private static function renderMenuItem($item, $hasChildren = false, $isActive = false)
    {
        $icon = $item->icon ? '<i class="' . e($item->icon) . '"></i>' : '';
        $target = $item->target_window === '_blank' ? ' target="_blank"' : '';
        $url = self::getMenuItemUrl($item);
        
        $activeClass = $isActive ? ' active' : '';
        $menuItemId = 'menu-item-' . $item->id;
        
        $html = '<li class="nav-item' . $activeClass . '" id="' . $menuItemId . '">';
        
        if ($hasChildren) {
            $collapseId = 'sidebar' . ucfirst(str_replace('-', '', $item->title)) . $item->id;
            $html .= '<a class="nav-link menu-link' . $activeClass . '" href="#' . $collapseId . '" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="' . $collapseId . '">';
            $html .= $icon . ' <span>' . e($item->title) . '</span>';
            $html .= '</a>';
            
            $html .= '<div class="collapse menu-dropdown' . ($isActive ? ' show' : '') . '" id="' . $collapseId . '">';
            $html .= '<ul class="nav nav-sm flex-column">';
            
            foreach ($item->activeChildren as $child) {
                $childUrl = self::getMenuItemUrl($child);
                $childActive = request()->routeIs($childUrl) || request()->url() === $childUrl;
                $childActiveClass = $childActive ? ' active' : '';
                
                $html .= '<li class="nav-item">';
                $html .= '<a href="' . e($childUrl) . '" class="nav-link' . $childActiveClass . '"' . $target . '>' . e($child->title) . '</a>';
                $html .= '</li>';
            }
            
            $html .= '</ul>';
            $html .= '</div>';
        } else {
            $html .= '<a class="nav-link menu-link' . $activeClass . '" href="' . e($url) . '"' . $target . '>';
            $html .= $icon . ' <span>' . e($item->title) . '</span>';
            $html .= '</a>';
        }
        
        $html .= '</li>';
        
        return $html;
    }

    /**
     * Get URL for menu item based on type (Public helper)
     */
    public static function getMenuItemUrl($item)
    {
        switch ($item->menu_item_type) {
            case 'url':
                return $item->url ?? '#';
            case 'page':
                return route('pages.show', ['page' => $item->url ?? '']);
            case 'category':
                return route('blog.category', ['slug' => $item->url ?? '']);
            case 'product':
                return route('products.show', ['product' => $item->url ?? '']);
            case 'custom':
                return '#';
            default:
                return $item->url ?? '#';
        }
    }
}


