<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Helpers\ActivityLogger;  // Import ActivityLogger
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use A17\Twill\Models\User as TwillUser;
use Illuminate\Support\Facades\Log;



class UserController extends Controller
{
    public function index()
    {
        $users = TwillUser::all();
        $roles = Role::with('permissions')->get();
        return view('vendor.twill.users.list', compact('users','roles'));
    }

    public function create()
    {
        return view('users.create');
    }


public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:twill_users,email',
        // 'phone' => 'required|string|max:20',
        'joining_date' => 'required|date',
        'status' => 'required|in:Active,Block',
        'role_id' => 'required|exists:roles,id',
    ]);

    try {
        $user = TwillUser::create($validated);

        if (class_exists('ActivityLogger')) {
            ActivityLogger::log('created', $user, "User '{$user->name}' created.");
        }

        return redirect()->back()->with('success', 'User added successfully');
    } catch (\Exception $e) {
        Log::error('User creation failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
        ]);
        return redirect()->back()->withErrors(['error' => 'Something went wrong. Check logs.']);
    }
}

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

   
public function update(Request $request, string $id)
{
    $user = TwillUser::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('twill_users')->ignore($user->id)],
        'joining_date' => 'required|date',
        'status' => 'required|in:Active,Block',
        'role_id' => 'required|exists:roles,id',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    try {
        $oldData = $user->getOriginal();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->joining_date = $validated['joining_date'];
        $user->status = $validated['status'];
        $user->role_id = $validated['role_id'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $changes = $user->getChanges();

        if (class_exists('ActivityLogger')) {
            ActivityLogger::log(
                'updated',
                $user,
                "User '{$user->name}' updated.",
                $changes
            );
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    } catch (\Exception $e) {
        Log::error('User update failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
        ]);

        return redirect()->back()->withErrors(['error' => 'Something went wrong. Check logs.']);
    }
}

 
    public function destroy($id)
    {
        $user = TwillUser::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        // Optional: Log activity
        if (class_exists('ActivityLogger')) {
            ActivityLogger::log('deleted', $user, "User '{$userName}' deleted.");
        }

        return redirect()->back()->with('success', 'User deleted successfully.');
    }


}
