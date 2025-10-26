<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::ordered()->paginate(10);
        return view('vendor.twill.organize_content.profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('vendor.twill.organize_content.profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links' => 'nullable|array',
            'custom_fields' => 'nullable|array',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('profiles', 'public');
            $data['avatar'] = $avatarPath;
        }

        Profile::create($data);

        return redirect()->route('admin.profiles.index')
            ->with('success', 'Profile created successfully.');
    }

    public function show(Profile $profile)
    {
        return view('vendor.twill.organize_content.profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        return view('vendor.twill.organize_content.profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links' => 'nullable|array',
            'custom_fields' => 'nullable|array',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $data = $request->all();
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($profile->avatar && \Storage::disk('public')->exists($profile->avatar)) {
                \Storage::disk('public')->delete($profile->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('profiles', 'public');
            $data['avatar'] = $avatarPath;
        }

        $profile->update($data);

        return redirect()->route('admin.profiles.show', $profile)
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        try {
            \Log::info('Deleting profile: ' . $profile->id . ' - ' . $profile->name);
            
            // Delete avatar if exists
            if ($profile->avatar && \Storage::disk('public')->exists($profile->avatar)) {
                \Storage::disk('public')->delete($profile->avatar);
            }
            
            $profile->delete();
            \Log::info('Profile deleted successfully: ' . $profile->id);

            return redirect()->route('admin.profiles.index')
                ->with('success', 'Profile deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting profile: ' . $e->getMessage());
            return redirect()->route('admin.profiles.index')
                ->with('error', 'Error deleting profile: ' . $e->getMessage());
        }
    }
}