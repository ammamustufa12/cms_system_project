<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\companies;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = companies::all();
        return view('vendor.twill.setup.company.index', compact('companies'));
    }

    public function create()
    {
        return view('vendor.twill.setup.company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'status' => 'nullable|in:active,inactive',
        ]);

        companies::create($request->all());

        return redirect()->route('setup.company.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(companies $company)
    {
        // Check if request is AJAX
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'company' => $company
            ]);
        }
        
        return view('vendor.twill.setup.company.show', compact('company'));
    }

    public function edit(companies $company)
    {
        return view('vendor.twill.setup.company.edit', compact('company'));
    }

    public function update(Request $request, companies $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'status' => 'nullable|in:active,inactive',
        ]);

        $company->update($request->all());

        return redirect()->route('setup.company.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(companies $company)
    {
        $company->delete();

        return redirect()->route('setup.company.index')
            ->with('success', 'Company deleted successfully.');
    }
}
