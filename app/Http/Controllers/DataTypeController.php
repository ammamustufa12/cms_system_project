<?php

namespace App\Http\Controllers;

use App\Models\DataType;
use Illuminate\Http\Request;

class DataTypeController extends Controller
{
    public function index()
    {
        $dataTypes = DataType::ordered()->paginate(10);
        return view('vendor.twill.organize_content.data_types.index', compact('dataTypes'));
    }

    public function create()
    {
        return view('vendor.twill.organize_content.data_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:text,number,date,boolean,email,select,textarea,file,image',
            'validation_rules' => 'nullable|array',
            'options' => 'nullable|array',
            'is_required' => 'boolean',
            'default_value' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        DataType::create($request->all());

        return redirect()->route('admin.data-types.index')
            ->with('success', 'Data Type created successfully.');
    }

    public function show(DataType $dataType)
    {
        return view('vendor.twill.organize_content.data_types.show', compact('dataType'));
    }

    public function edit(DataType $dataType)
    {
        return view('vendor.twill.organize_content.data_types.edit', compact('dataType'));
    }

    public function update(Request $request, DataType $dataType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:text,number,date,boolean,email,select,textarea,file,image',
            'validation_rules' => 'nullable|array',
            'options' => 'nullable|array',
            'is_required' => 'boolean',
            'default_value' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        $dataType->update($request->all());

        return redirect()->route('admin.data-types.index')
            ->with('success', 'Data Type updated successfully.');
    }

    public function destroy(DataType $dataType)
    {
        try {
            \Log::info('Deleting data type: ' . $dataType->id . ' - ' . $dataType->name);
            $dataType->delete();
            \Log::info('Data type deleted successfully: ' . $dataType->id);

            return redirect()->route('admin.data-types.index')
                ->with('success', 'Data Type deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting data type: ' . $e->getMessage());
            return redirect()->route('admin.data-types.index')
                ->with('error', 'Error deleting data type: ' . $e->getMessage());
        }
    }
}
