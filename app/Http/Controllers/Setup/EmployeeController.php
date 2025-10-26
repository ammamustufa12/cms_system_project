<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\companies;
use App\Models\Department;
use App\Models\Location;
use App\Models\Employee;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['company', 'department', 'location'])->get();
        return view('vendor.twill.setup.employee.index', compact('employees'));
    }

    public function create()
    {
        $companies = companies::all();
        $departments = Department::all();
        $locations = Location::all();
        return view('vendor.twill.setup.employee.create', compact('companies', 'departments', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'location_id' => 'nullable|exists:locations,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string',
            'position' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'hire_date' => 'required|date',
        ]);

        Employee::create($request->all());

        return redirect()->route('setup.employee.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load('company', 'department', 'location', 'user');
        return view('vendor.twill.setup.employee.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $companies = companies::all();
        $departments = Department::all();
        $locations = Location::all();
        return view('vendor.twill.setup.employee.edit', compact('employee', 'companies', 'departments', 'locations'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'location_id' => 'nullable|exists:locations,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string',
            'position' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'hire_date' => 'required|date',
        ]);

        $employee->update($request->all());

        return redirect()->route('setup.employee.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('setup.employee.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
