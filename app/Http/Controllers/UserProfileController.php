<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwillUser; // or your user model

class UserProfileController extends Controller
{
    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'firstnameInput' => 'required|string|max:255',
            'lastnameInput' => 'required|string|max:255',
            'phonenumberInput' => 'nullable|string|max:100',
            'emailInput' => 'required|email|max:255|unique:twill_users,email,' . auth()->id(),
            'JoiningdatInput' => 'nullable|date_format:d M, Y',
            'skillsInput' => 'nullable|array',
            'skillsInput.*' => 'string',
            'designationInput' => 'nullable|string|max:255',
            'websiteInput1' => 'nullable|string|max:255',
            'cityInput' => 'nullable|string|max:255',
            'countryInput' => 'nullable|string|max:255',
            'zipcodeInput' => 'nullable|string|min:5|max:6',
            'exampleFormControlTextarea' => 'nullable|string',
        ]);

        // Find authenticated user or create new
        $user = auth()->user() ?? new TwillUser();

        // Map validated data to model fields
        $user->first_name = $validated['firstnameInput'];
        $user->last_name = $validated['lastnameInput'];
        $user->phone = $validated['phonenumberInput'] ?? null;
        $user->email = $validated['emailInput'];
        
        if (!empty($validated['JoiningdatInput'])) {
            // Parse date from "d M, Y" format
            $user->joining_date = \DateTime::createFromFormat('d M, Y', $validated['JoiningdatInput']);
        } else {
            $user->joining_date = null;
        }

        $user->skills = !empty($validated['skillsInput']) ? json_encode($validated['skillsInput']) : null;
        $user->designation = $validated['designationInput'] ?? null;
        $user->website = $validated['websiteInput1'] ?? null;
        $user->city = $validated['cityInput'] ?? null;
        $user->country = $validated['countryInput'] ?? null;
        $user->zipcode = $validated['zipcodeInput'] ?? null;
        $user->description = $validated['exampleFormControlTextarea'] ?? null;

        // Save user
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
