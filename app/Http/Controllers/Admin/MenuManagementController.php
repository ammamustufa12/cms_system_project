<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuManagementController extends Controller
{
    /**
     * Display toolbar menu management
     */
    public function toolbar(Request $request)
    {
        $menuType = $this->getMenuType($request);
        return view("admin.menu.{$menuType}.toolbar");
    }

    /**
     * Display top menu management
     */
    public function topMenu(Request $request)
    {
        $menuType = $this->getMenuType($request);
        return view("admin.menu.{$menuType}.top-menu");
    }

    /**
     * Display breadcrumbs management
     */
    public function breadcrumbs(Request $request)
    {
        $menuType = $this->getMenuType($request);
        return view("admin.menu.{$menuType}.breadcrumbs");
    }

    /**
     * Display sidebar left management
     */
    public function sidebarLeft(Request $request)
    {
        $menuType = $this->getMenuType($request);
        return view("admin.menu.{$menuType}.sidebar-left");
    }

    /**
     * Display sidebar right management
     */
    public function sidebarRight(Request $request)
    {
        $menuType = $this->getMenuType($request);
        return view("admin.menu.{$menuType}.sidebar-right");
    }

    /**
     * Display bottom menu management
     */
    public function bottomMenu(Request $request)
    {
        $menuType = $this->getMenuType($request);
        return view("admin.menu.{$menuType}.bottom-menu");
    }

    /**
     * Determine menu type based on route
     */
    private function getMenuType(Request $request)
    {
        $route = $request->route()->getName();
        
        if (str_contains($route, 'config.menu-management')) {
            return 'config';
        } elseif (str_contains($route, 'setup.menu-management')) {
            return 'setup';
        } elseif (str_contains($route, 'active-area.menu-management')) {
            return 'active-area';
        }
        
        return 'config'; // default
    }

    /**
     * Save menu configuration
     */
    public function save(Request $request)
    {
        // Add your save logic here
        $menuType = $this->getMenuType($request);
        $menuData = $request->all();
        
        // You can save to database, file, or cache here
        // Example: MenuConfig::updateOrCreate(['type' => $menuType], $menuData);
        
        return response()->json([
            'success' => true,
            'message' => 'Menu configuration saved successfully!',
            'menu_type' => $menuType
        ]);
    }

    /**
     * Get menu configuration
     */
    public function get(Request $request)
    {
        $menuType = $this->getMenuType($request);
        
        // You can fetch from database, file, or cache here
        // Example: $config = MenuConfig::where('type', $menuType)->first();
        
        return response()->json([
            'success' => true,
            'menu_type' => $menuType,
            'config' => [] // Add your config data here
        ]);
    }
}
