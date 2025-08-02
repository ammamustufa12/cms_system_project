<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class RoleController extends Controller
{
     /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('vendor.twill.roles.list', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:roles,name',
        'slug' => 'required|string|unique:roles,slug',
        'permissions' => 'array',
    ]);

    $role = Role::create([
        'name' => $request->name,
        'slug' => $request->slug,
    ]);

    // Convert permission slugs to IDs
    $permissionIds = Permission::whereIn('slug', $request->permissions)->pluck('id')->toArray();

    $role->permissions()->sync($permissionIds);

    return redirect()->route('roles.index')->with('success', 'Role created successfully.');
}

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load('permissions');
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'slug' => 'required|string|unique:roles,slug,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
