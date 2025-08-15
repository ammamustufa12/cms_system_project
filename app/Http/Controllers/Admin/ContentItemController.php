<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentType;
use App\Models\ContentItem;
use App\Services\FieldTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentItemController extends Controller
{
    // public function index($contentTypeSlug)
    // {
    //     $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();
    //     $items = ContentItem::where('content_type_id', $contentType->id)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(12);

    //     return view('vendor.twill.content-items.index', compact('contentType', 'items'));
    // }

    public function index(Request $request, $contentTypeSlug)
{
    $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();

    $query = ContentItem::where('content_type_id', $contentType->id);

    // Only search if search button was clicked (check for search_submitted parameter)
    if ($request->filled('search') && $request->get('search_submitted') == '1') {
        $searchTerm = $request->get('search');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('slug', 'like', '%' . $searchTerm . '%');
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->get('status'));
    }

    $allowedSortFields = ['created_at', 'updated_at', 'title', 'published_at'];
    $sortField = in_array($request->get('sort'), $allowedSortFields) ? $request->get('sort') : 'created_at';
    $sortOrder = in_array($request->get('order'), ['asc', 'desc']) ? $request->get('order') : 'desc';

    if ($sortField === 'published_at') {
        $query->orderByRaw('published_at IS NULL')->orderBy('published_at', $sortOrder);
    } else {
        $query->orderBy($sortField, $sortOrder);
    }

    $items = $query->paginate(12)->appends($request->query());

    return view('vendor.twill.content-items.index', compact('contentType', 'items'));
}




    public function create($contentTypeSlug)
    {
        $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();

        if (empty($contentType->fields_schema)) {
            return redirect()->route('content-types.manage-fields', $contentTypeSlug)
                ->with('error', 'Please add fields to this content type first.');
        }

        $fieldsSchema = is_array($contentType->fields_schema) ? $contentType->fields_schema : json_decode($contentType->fields_schema, true);

        // Sort fields by order
        uasort($fieldsSchema, function ($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });

        return view('vendor.twill.content-items.create', compact('contentType', 'fieldsSchema'));
    }

    public function store(Request $request, $contentTypeSlug)
    {
        $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();
        $fieldsSchema = $contentType->fields_schema;
        //  $fieldData = $this->processFieldData($request, $fieldsSchema, null);

        $rules = $this->buildValidationRules($fieldsSchema);

        $rules['title'] = 'required|string|max:255';
        $rules['slug'] = 'nullable|string|max:255|unique:content_items,slug';

        $rules['published_at'] = 'nullable|boolean';

        $validated = $request->validate($rules);


        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (ContentItem::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }
        $status = $request->has('published_at') && $request->input('published_at') == '1'
            ? 'published'
            : 'draft';

        $fieldData = $this->processFieldData($request, $fieldsSchema);

        $contentItem = ContentItem::create([
            'content_type_id' => $contentType->id,
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'field_data' => $fieldData,
            'meta_data' => [
                'created_via' => 'admin',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ],
            'status' => $status,
            'created_by' => auth('twill_users')->id(),
            'published_at' => $status === 'published' ? now() : null,
        ]);

        return redirect()->route('content-types.content-items.index', [$contentTypeSlug, $contentItem->id])
            ->with('success', 'Content item created successfully!');
    }


    public function show($contentTypeSlug, $id)
    {
        $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();
        $item = ContentItem::where('content_type_id', $contentType->id)
            ->findOrFail($id);

        return view('vendor.twill.content-items.index', compact('contentType', 'item'));
    }

    public function edit($contentTypeSlug, $id)
    {
        $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();
        $contentItem = ContentItem::where('content_type_id', $contentType->id)
            ->where('id', $id)
            ->firstOrFail();

        if (empty($contentType->fields_schema)) {
            return redirect()->route('content-types.manage-fields', $contentTypeSlug)
                ->with('error', 'Please add fields to this content type first.');
        }

        $fieldsSchema = is_array($contentType->fields_schema)
            ? $contentType->fields_schema
            : json_decode($contentType->fields_schema, true);

        // Sort fields by order
        uasort($fieldsSchema, function ($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });

        return view('vendor.twill.content-items.edit', compact('contentType', 'fieldsSchema', 'contentItem'));
    }

public function update(Request $request, $contentTypeSlug, $id)
{
    $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();
    $contentItem = ContentItem::where('content_type_id', $contentType->id)
        ->where('id', $id)
        ->firstOrFail();

    $fieldsSchema = $contentType->fields_schema;

    $rules = $this->buildValidationRules($fieldsSchema);
    $rules['title'] = 'required|string|max:255';
    $rules['slug'] = 'nullable|string|max:255|unique:content_items,slug,' . $contentItem->id;
    $rules['published_at'] = 'nullable|boolean';

    $validated = $request->validate($rules);

    // Generate slug if empty
    if (empty($validated['slug'])) {
        $validated['slug'] = Str::slug($validated['title']);
        $counter = 1;
        $originalSlug = $validated['slug'];
        while (ContentItem::where('slug', $validated['slug'])
            ->where('id', '!=', $contentItem->id)
            ->exists()
        ) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }
    }

    // Determine status
    $status = $request->has('published_at') && $request->input('published_at') == '1'
        ? 'published'
        : 'draft';

    // Process field data - IMPORTANT: Pass $contentItem parameter
    $fieldData = $this->processFieldData($request, $fieldsSchema, $contentItem);

    // Update the content item
    $contentItem->update([
        'title' => $validated['title'],
        'slug' => $validated['slug'],
        'field_data' => $fieldData,
        'status' => $status,
        'updated_by' => auth('twill_users')->id(),
        'published_at' => $status === 'published' ? ($contentItem->published_at ?? now()) : null,
    ]);

    // Handle auto-save requests
    if ($request->ajax() && $request->input('auto_save')) {
        return response()->json(['success' => true, 'message' => 'Draft saved automatically']);
    }

    return redirect()->route('content-types.content-items.index', [$contentTypeSlug])
        ->with('success', 'Content item updated successfully!');
}

    public function destroy($contentTypeSlug, $id)
    {
        $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();
        $item = ContentItem::where('content_type_id', $contentType->id)
            ->findOrFail($id);

        // Delete associated files
        $this->deleteAssociatedFiles($item);

        $item->delete();

        return redirect()->route('content-types.content-items.index', $contentTypeSlug)
            ->with('success', 'Content item deleted successfully!');
    }

    public function duplicate($contentTypeSlug, $id)
    {
        $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();
        $item = ContentItem::where('content_type_id', $contentType->id)
            ->findOrFail($id);

        // Create duplicate
        $duplicate = $item->replicate();
        $duplicate->title = $item->title . ' (Copy)';
        $duplicate->slug = $item->slug . '-copy-' . time();
        $duplicate->status = 'draft';
        $duplicate->published_at = null;
        $duplicate->created_by = Auth::id();
        $duplicate->save();

        return redirect()->route('content-types.content-items.edit', [$contentTypeSlug, $duplicate->id])
            ->with('success', 'Content item duplicated successfully!');
    }

    public function bulkAction(Request $request, $contentTypeSlug)
    {
        $contentType = ContentType::where('slug', $contentTypeSlug)->firstOrFail();

        $validated = $request->validate([
            'action' => 'required|in:publish,unpublish,archive,delete',
            'items' => 'required|array|min:1',
            'items.*' => 'exists:content_items,id'
        ]);

        $items = ContentItem::where('content_type_id', $contentType->id)
            ->whereIn('id', $validated['items']);

        switch ($validated['action']) {
            case 'publish':
                $items->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                $message = 'Items published successfully!';
                break;

            case 'unpublish':
                $items->update([
                    'status' => 'draft',
                    'published_at' => null
                ]);
                $message = 'Items unpublished successfully!';
                break;

            case 'archive':
                $items->update(['status' => 'archived']);
                $message = 'Items archived successfully!';
                break;

            case 'delete':
                $itemsToDelete = $items->get();
                foreach ($itemsToDelete as $item) {
                    $this->deleteAssociatedFiles($item);
                }
                $items->delete();
                $message = 'Items deleted successfully!';
                break;
        }

        return redirect()->route('content-types.content-items.index', $contentTypeSlug)
            ->with('success', $message);
    }

    private function buildValidationRules($fieldsSchema)
    {

        if (is_string($fieldsSchema)) {
            $fieldsSchema = json_decode($fieldsSchema, true) ?? [];
        }

        if (!is_array($fieldsSchema)) {
            $fieldsSchema = [];
        }

        $rules = [];

        foreach ($fieldsSchema as $fieldKey => $field) {
            $fieldRules = [];

            // Required validation
            if ($field['required'] ?? false) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            // Type-specific validation
            switch ($field['type']) {
                case 'text':
                case 'textarea':
                    $fieldRules[] = 'string';
                    if (isset($field['options']['max_length'])) {
                        $fieldRules[] = 'max:' . $field['options']['max_length'];
                    }
                    break;

                case 'email':
                    $fieldRules[] = 'email';
                    break;

                case 'number':
                    $fieldRules[] = 'numeric';
                    if (isset($field['options']['min'])) {
                        $fieldRules[] = 'min:' . $field['options']['min'];
                    }
                    if (isset($field['options']['max'])) {
                        $fieldRules[] = 'max:' . $field['options']['max'];
                    }
                    break;

                case 'boolean':
                    $fieldRules[] = 'boolean';
                    break;

                case 'date':
                    $fieldRules[] = 'date';
                    break;

                case 'datetime':
                    $fieldRules[] = 'date';
                    break;

                case 'file':
                case 'image':
                    $fieldRules[] = 'file';
                    if (isset($field['options']['max_size'])) {
                        $fieldRules[] = 'max:' . ($field['options']['max_size'] * 1024); // Convert MB to KB
                    }
                    if ($field['type'] === 'image') {
                        $fieldRules[] = 'image';
                    }
                    break;

                case 'select':
                case 'checkbox':
                case 'radio':
                    if (isset($field['options']['options_list'])) {
                        $validOptions = array_keys($field['options']['options_list']);
                        if ($field['type'] === 'checkbox' && ($field['options']['multiple'] ?? false)) {
                            $fieldRules[] = 'array';
                            $rules[$fieldKey . '.*'] = ['in:' . implode(',', $validOptions)];
                        } else {
                            $fieldRules[] = 'in:' . implode(',', $validOptions);
                        }
                    }
                    break;

                case 'gallery':
                    $fieldRules[] = 'array';
                    $rules[$fieldKey . '.*'] = ['file', 'image'];
                    if (isset($field['options']['max_images'])) {
                        $fieldRules[] = 'max:' . $field['options']['max_images'];
                    }
                    break;

                case 'repeater':
                    $fieldRules[] = 'array';
                    if (isset($field['options']['min_items'])) {
                        $fieldRules[] = 'min:' . $field['options']['min_items'];
                    }
                    if (isset($field['options']['max_items'])) {
                        $fieldRules[] = 'max:' . $field['options']['max_items'];
                    }
                    break;
            }

            $rules[$fieldKey] = $fieldRules;
        }

        return $rules;
    }

    // private function processFieldData(Request $request, $fieldsSchema)
    // {

    //     // Decode JSON if it's a string
    //     if (is_string($fieldsSchema)) {
    //         $fieldsSchema = json_decode($fieldsSchema, true) ?? [];
    //     }

    //     // Safety net
    //     if (!is_array($fieldsSchema)) {
    //         $fieldsSchema = [];
    //     }

    //     $fieldData = [];

    //     foreach ($fieldsSchema as $fieldKey => $field) {
    //         $value = $request->input($fieldKey);

    //         switch ($field['type']) {
    //             case 'file':
    //             case 'image':
    //                 if ($request->hasFile($fieldKey)) {
    //                     $file = $request->file($fieldKey);
    //                     $path = $file->store('content-files/' . date('Y/m'), 'public');
    //                     $fieldData[$fieldKey] = [
    //                         'path' => $path,
    //                         'original_name' => $file->getClientOriginalName(),
    //                         'size' => $file->getSize(),
    //                         'mime_type' => $file->getMimeType()
    //                     ];
    //                 } else {
    //                     $fieldData[$fieldKey] = null;
    //                 }
    //                 break;

    //             case 'gallery':
    //                 $galleryFiles = [];
    //                 if ($request->hasFile($fieldKey)) {
    //                     foreach ($request->file($fieldKey) as $file) {
    //                         $path = $file->store('content-gallery/' . date('Y/m'), 'public');
    //                         $galleryFiles[] = [
    //                             'path' => $path,
    //                             'original_name' => $file->getClientOriginalName(),
    //                             'size' => $file->getSize(),
    //                             'mime_type' => $file->getMimeType()
    //                         ];
    //                     }
    //                 }
    //                 $fieldData[$fieldKey] = $galleryFiles;
    //                 break;

    //             case 'checkbox':
    //                 if ($field['options']['multiple'] ?? false) {
    //                     $fieldData[$fieldKey] = $value ?? [];
    //                 } else {
    //                     $fieldData[$fieldKey] = $value ? true : false;
    //                 }
    //                 break;

    //             case 'boolean':
    //                 $fieldData[$fieldKey] = $value ? true : false;
    //                 break;

    //             case 'number':
    //                 $fieldData[$fieldKey] = $value ? (float) $value : null;
    //                 break;

    //             case 'repeater':
    //                 $fieldData[$fieldKey] = $value ?? [];
    //                 break;

    //             default:
    //                 $fieldData[$fieldKey] = $value;
    //         }
    //     }

    //     return $fieldData;
    // }

private function processFieldData(Request $request, $fieldsSchema, $contentItem = null)
{
    // Decode JSON if it's a string
    if (is_string($fieldsSchema)) {
        $fieldsSchema = json_decode($fieldsSchema, true) ?? [];
    }

    // Safety net
    if (!is_array($fieldsSchema)) {
        $fieldsSchema = [];
    }

    $fieldData = [];

    foreach ($fieldsSchema as $fieldKey => $field) {
        $fieldType = $field['type'];
        $value = $request->input($fieldKey);

        switch ($fieldType) {
            case 'file':
            case 'image':
                if ($request->hasFile($fieldKey)) {
                    // Delete old file if updating existing content
                    if ($contentItem && isset($contentItem->field_data[$fieldKey]['path'])) {
                        Storage::disk('public')->delete($contentItem->field_data[$fieldKey]['path']);
                    }

                    // Store new file
                    $file = $request->file($fieldKey);
                    $path = $file->store('content-files/' . date('Y/m'), 'public');
                    
                    $fieldData[$fieldKey] = [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'uploaded_at' => now()->toISOString()
                    ];
                } else {
                    // Keep old file if no new file uploaded and updating
                    if ($contentItem && isset($contentItem->field_data[$fieldKey])) {
                        $fieldData[$fieldKey] = $contentItem->field_data[$fieldKey];
                    } else {
                        // No file for new content
                        $fieldData[$fieldKey] = null;
                    }
                }
                break;

            case 'gallery':
                $galleryFiles = [];
                
                if ($request->hasFile($fieldKey)) {
                    // Delete old gallery files if updating
                    if ($contentItem && isset($contentItem->field_data[$fieldKey]) && is_array($contentItem->field_data[$fieldKey])) {
                        foreach ($contentItem->field_data[$fieldKey] as $oldFile) {
                            if (isset($oldFile['path'])) {
                                Storage::disk('public')->delete($oldFile['path']);
                            }
                        }
                    }

                    // Store new gallery files
                    foreach ($request->file($fieldKey) as $file) {
                        $path = $file->store('content-gallery/' . date('Y/m'), 'public');
                        $galleryFiles[] = [
                            'path' => $path,
                            'original_name' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                            'uploaded_at' => now()->toISOString()
                        ];
                    }
                    $fieldData[$fieldKey] = $galleryFiles;
                } else {
                    // Keep old gallery if no new files uploaded
                    if ($contentItem && isset($contentItem->field_data[$fieldKey])) {
                        $fieldData[$fieldKey] = $contentItem->field_data[$fieldKey];
                    } else {
                        $fieldData[$fieldKey] = [];
                    }
                }
                break;

            case 'checkbox':
                if ($field['options']['multiple'] ?? false) {
                    $fieldData[$fieldKey] = $value ?? [];
                } else {
                    $fieldData[$fieldKey] = $value ? true : false;
                }
                break;

            case 'boolean':
                $fieldData[$fieldKey] = $value ? true : false;
                break;

            case 'number':
                $fieldData[$fieldKey] = $value ? (float) $value : null;
                break;

            case 'date':
                $fieldData[$fieldKey] = $value ? $value : null;
                break;

            case 'datetime':
                $fieldData[$fieldKey] = $value ? $value : null;
                break;

            case 'repeater':
                $fieldData[$fieldKey] = $value ?? [];
                break;

            default:
                // For text, textarea, email, select, radio etc.
                $fieldData[$fieldKey] = $value;
        }
    }

    return $fieldData;
}


    private function deleteAssociatedFiles(ContentItem $item)
    {
        $fieldData = $item->field_data ?? [];

        foreach ($fieldData as $fieldKey => $value) {
            if (is_array($value)) {
                // Handle gallery or file arrays
                if (isset($value[0]['path'])) {
                    // Gallery
                    foreach ($value as $file) {
                        if (isset($file['path'])) {
                            Storage::disk('public')->delete($file['path']);
                        }
                    }
                } elseif (isset($value['path'])) {
                    // Single file
                    Storage::disk('public')->delete($value['path']);
                }
            }
        }
    }
}
