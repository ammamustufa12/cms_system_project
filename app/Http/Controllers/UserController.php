<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;
   use App\Helpers\ActivityLogger;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('vendor.twill.users.list', compact('users', 'roles'));
    }



public function store(Request $request)
{
    $data = $request->validate([
        'first_name' => 'required|string',
        'last_name'  => 'required|string',
        'username'   => 'required|unique:twill_users',
        'email'      => 'required|email|unique:twill_users',
        'password'   => 'nullable|string|min:6',
        'phone'      => 'nullable|string',
        'address'    => 'nullable|string',
        'photo'      => 'nullable|string',
        'role_id'    => 'nullable|exists:roles,id',
    ]);

    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    }

    $user = User::create($data);

    // Log the creation activity
    ActivityLogger::log(
        'created',
        $user,
        "Created user {$user->username}"
    );

    return redirect()->back()->with('success', 'User created successfully.');
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $data = $request->validate([
        'first_name' => 'required|string',
        'last_name'  => 'required|string',
        'username'   => 'required|unique:twill_users,username,' . $user->id,
        'email'      => 'required|email|unique:twill_users,email,' . $user->id,
        'password'   => 'nullable|string|min:6',
        'phone'      => 'nullable|string',
        'address'    => 'nullable|string',
        'photo'      => 'nullable|string',
        'role_id'    => 'nullable|exists:roles,id',
    ]);

    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    $originalData = $user->getOriginal();

    $user->update($data);

    // Calculate changes:
    $changes = array_diff_assoc($user->getAttributes(), $originalData);

    ActivityLogger::log(
        'updated',
        $user,
        "Updated user {$user->username}",
        $changes
    );

    return redirect()->back()->with('success', 'User updated successfully.');
}

public function destroy($id)
{
    $user = User::findOrFail($id);

    ActivityLogger::log(
        'deleted',
        $user,
        "Deleted user {$user->username}"
    );

    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}
}
