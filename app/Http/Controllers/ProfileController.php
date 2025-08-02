<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use A17\Twill\Models\User as TwillUser;

class ProfileController extends Controller
{
    /**
     * Display the profile page
     */
 public function index()
    {
        $user = Auth::guard('twill_users')->user(); // Fetching logged-in Twill user
        return view('vendor.twill.profile.index', compact('user'));
    }
    /**
     * Display profile settings page
     */
    public function settings()
    {
        $user = Auth::user();

        return view('vendor.twill.profile_setting.index', compact('user'));
    }

    /**
     * Store social media data for authenticated user
     */
    public function socialmedia_store(Request $request)
    {
        $validated = $request->validate([
            'github_username' => 'nullable|string|max:255',
            'websiteInput' => 'nullable|string|max:255',
            'dribbble_username' => 'nullable|string|max:255',
            'pinterest_username' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if (!$user) {
            Log::warning('No authenticated user found during social media update');
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        try {
            $user->github_username = $validated['github_username'] ?? null;
            $user->website = $validated['websiteInput'] ?? null;
            $user->dribbble_username = $validated['dribbble_username'] ?? null;
            $user->pinterest_username = $validated['pinterest_username'] ?? null;

            $user->save();

            Log::info("Social media updated for user ID: {$user->id}");

            return redirect()->back()->with('success', 'Social media profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Social media update failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->withErrors(['error' => 'Failed to update social media profile.']);
        }
    }

    /**
     * Store or update profile data
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'firstnameInput' => 'required|string|max:255',
            'lastnameInput' => 'required|string|max:255',
            'phonenumberInput' => 'nullable|string|max:100',
            'emailInput' => 'required|email|unique:twill_users,email,' . $user->id,
            'JoiningdatInput' => 'nullable|date',
            'skillsInput' => 'nullable|array',
            'skillsInput.*' => 'string',
            'designationInput' => 'nullable|string|max:255',
            'websiteInput1' => 'nullable|url|max:255',
            'cityInput' => 'nullable|string|max:255',
            'countryInput' => 'nullable|string|max:255',
            'zipcodeInput' => 'nullable|string|max:10',
            'exampleFormControlTextarea' => 'nullable|string',
        ]);

        // Map validated inputs to user model attributes
        $user->first_name = $validated['firstnameInput'];
        $user->last_name = $validated['lastnameInput'];
        $user->phone = $validated['phonenumberInput'] ?? null;
        $user->email = $validated['emailInput'];
        $user->joining_date = $validated['JoiningdatInput'] ?? null;
        $user->skills = $validated['skillsInput'] ?? null; // assuming 'skills' is cast as array/json
        $user->designation = $validated['designationInput'] ?? null;
        $user->website = $validated['websiteInput1'] ?? null;
        $user->city = $validated['cityInput'] ?? null;
        $user->country = $validated['countryInput'] ?? null;
        $user->zipcode = $validated['zipcodeInput'] ?? null;
        $user->description = $validated['exampleFormControlTextarea'] ?? null;

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
