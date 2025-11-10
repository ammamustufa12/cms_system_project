<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $routePrefix = $this->getMenuType($request);
        // Create route-specific menu type: sidebar-left-config, sidebar-left-setup, sidebar-left-active-area
        $menuType = 'sidebar-left-' . $routePrefix;
        
        // Load ALL menu items (both active and inactive) for management page
        $menuItems = MenuItem::ofType($menuType)
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
        
        return view("admin.menu-management.sidebar-left", [
            'menuItems' => $menuItems,
            'menuType' => $menuType,
            'routePrefix' => $routePrefix
        ]);
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
     * Save menu item
     */
    public function saveItem(Request $request)
    {
        try {
            \Log::info('Menu Item Save Request:', $request->all());
            
            $validated = $request->validate([
                'menu_type' => 'required|string',
                'title' => 'required|string|max:255',
                'alias' => 'nullable|string|max:255',
                'menu_item_type' => 'required|string',
                'url' => 'nullable|string',
                'icon' => 'nullable|string',
                'parent_id' => 'nullable|integer|exists:menu_items,id',
                'sort_order' => 'nullable|integer',
                'is_active' => 'sometimes|boolean',
                'is_visible' => 'sometimes|boolean',
                'target_window' => 'nullable|string',
                'access_level' => 'nullable|string',
                'styling' => 'nullable|array',
                'advanced' => 'nullable|array',
                'mega_menu_settings' => 'nullable|array',
            ]);
            
            // Convert empty string to null for parent_id
            if (isset($validated['parent_id']) && $validated['parent_id'] === '') {
                $validated['parent_id'] = null;
            }
            
            // Convert parent_id to integer if it's a string
            if (isset($validated['parent_id']) && $validated['parent_id'] !== null) {
                $validated['parent_id'] = (int) $validated['parent_id'];
            }

            if (empty($validated['alias'])) {
                $validated['alias'] = Str::slug($validated['title']);
            }
            
            // Set default values if not provided
            if (!isset($validated['is_active'])) {
                $validated['is_active'] = true;
            }
            if (!isset($validated['is_visible'])) {
                $validated['is_visible'] = true;
            }
            if (empty($validated['url'])) {
                $validated['url'] = '#';
            }

            \Log::info('Creating menu item with data:', $validated);
            \Log::info('Parent ID value:', ['parent_id' => $validated['parent_id'] ?? null, 'type' => gettype($validated['parent_id'] ?? null)]);
            
            $menuItem = MenuItem::create($validated);
            
            // Reload with relationships for proper response
            $menuItem->load('children');
            
            \Log::info('Menu item created successfully:', [
                'id' => $menuItem->id, 
                'title' => $menuItem->title,
                'parent_id' => $menuItem->parent_id,
                'menu_type' => $menuItem->menu_type
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Menu item saved successfully!',
                'menu_item' => $menuItem
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error saving menu item: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error saving menu item: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update menu item
     */
    public function updateItem(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        // Allow partial updates - only validate fields that are present
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'alias' => 'nullable|string|max:255',
            'menu_item_type' => 'sometimes|required|string',
            'url' => 'nullable|string',
            'icon' => 'nullable|string',
            'parent_id' => 'nullable|exists:menu_items,id',
            'sort_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
            'is_visible' => 'sometimes|boolean',
            'target_window' => 'nullable|string',
            'access_level' => 'nullable|string',
            'styling' => 'nullable|array',
            'advanced' => 'nullable|array',
            'mega_menu_settings' => 'nullable|array',
        ]);

        $menuItem->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu item updated successfully!',
            'menu_item' => $menuItem
        ]);
    }

    /**
     * Delete menu item
     */
    public function deleteItem($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu item deleted successfully!'
        ]);
    }

    /**
     * Save multiple menu items (for drag and drop reordering)
     */
    public function saveItems(Request $request)
    {
        $items = $request->input('items', []);
        $updatedIds = [];

        // First, delete all existing items for this menu type
        $menuType = $items[0]['menu_type'] ?? 'sidebar-left';
        MenuItem::ofType($menuType)->delete();

        foreach ($items as $itemData) {
            $newItem = MenuItem::create([
                'menu_type' => $itemData['menu_type'] ?? $menuType,
                'title' => $itemData['title'],
                'alias' => $itemData['alias'] ?? Str::slug($itemData['title']),
                'menu_item_type' => $itemData['menu_item_type'] ?? 'url',
                'url' => $itemData['url'] ?? '#',
                'icon' => $itemData['icon'] ?? null,
                'parent_id' => $itemData['parent_id'] ?? null,
                'sort_order' => $itemData['sort_order'] ?? 0,
                'is_active' => $itemData['is_active'] ?? true,
                'is_visible' => $itemData['is_visible'] ?? true,
                'target_window' => $itemData['target_window'] ?? '_self',
                'access_level' => $itemData['access_level'] ?? 'public',
                'styling' => $itemData['styling'] ?? null,
                'advanced' => $itemData['advanced'] ?? null,
                'mega_menu_settings' => $itemData['mega_menu_settings'] ?? null,
            ]);

            if (isset($itemData['id']) && $itemData['id'] !== null) {
                $updatedIds[] = [
                    'old_id' => $itemData['id'],
                    'new_id' => $newItem->id
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Menu items saved successfully!',
            'updated_ids' => $updatedIds
        ]);
    }

    /**
     * Get menu items for a specific menu type
     */
    public function getItems(Request $request, $menuType)
    {
        $items = MenuItem::ofType($menuType)
            ->root()
            ->with('activeChildren')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'menu_type' => $menuType,
            'items' => $items
        ]);
    }

    /**
     * Save menu configuration
     */
    public function save(Request $request)
    {
        $menuType = $this->getMenuType($request);
        $menuData = $request->all();
        
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
        
        return response()->json([
            'success' => true,
            'menu_type' => $menuType,
            'config' => []
        ]);
    }
}
