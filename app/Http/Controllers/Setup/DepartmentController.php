<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\companies;
use App\Models\Department;
use App\Models\User;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with(['company', 'manager', 'employees'])->get();
        return view('vendor.twill.setup.department.index', compact('departments'));
    }

    public function create()
    {
        $companies = companies::all();
        $users = User::all();
        return view('vendor.twill.setup.department.create', compact('companies', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
            'budget' => 'nullable|numeric',
        ]);

        Department::create($request->all());

        return redirect()->route('setup.department.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load('company', 'manager', 'employees');
        return view('vendor.twill.setup.department.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $companies = companies::all();
        $users = User::all();
        return view('vendor.twill.setup.department.edit', compact('department', 'companies', 'users'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'nullable|exists:users,id',
            'budget' => 'nullable|numeric',
        ]);

        $department->update($request->all());

        return redirect()->route('setup.department.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('setup.department.index')
            ->with('success', 'Department deleted successfully.');
    }
}
