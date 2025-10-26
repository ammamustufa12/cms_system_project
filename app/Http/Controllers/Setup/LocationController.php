<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\companies;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('company')->get();
        return view('vendor.twill.setup.location.index', compact('locations'));
    }

    public function create()
    {
        $companies = companies::all();
        return view('vendor.twill.setup.location.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        Location::create($request->all());

        return redirect()->route('setup.location.index')
            ->with('success', 'Location created successfully.');
    }

    public function show(Location $location)
    {
        $location->load('company', 'employees');
        return view('vendor.twill.setup.location.show', compact('location'));
    }

    public function edit(Location $location)
    {
        $companies = companies::all();
        return view('vendor.twill.setup.location.edit', compact('location', 'companies'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $location->update($request->all());

        return redirect()->route('setup.location.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('setup.location.index')
            ->with('success', 'Location deleted successfully.');
    }
}
