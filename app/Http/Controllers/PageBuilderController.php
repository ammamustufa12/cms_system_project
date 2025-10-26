<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentType;

class PageBuilderController extends Controller
{
    public function index()
    {
        // Get all content types for the page builder
        $contentTypes = ContentType::where('status', 'active')->get();
        
        // Variables required by the form layout
        $saveUrl = route('page.builder.save');
        $moduleName = 'page-builder';
        $customForm = false;
        
        return view('vendor.twill.pages.page-builder', compact('contentTypes', 'saveUrl', 'moduleName', 'customForm'));
    }
    
    public function save(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'content' => 'required|string',
            'page_id' => 'nullable|integer'
        ]);
        
        // Add your save logic here
        // Example:
        // $page = Page::findOrNew($request->page_id);
        // $page->content = $request->content;
        // $page->save();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Redirect to GrapesJS builder for specific content type
     */
    public function builder($slug)
    {
        $contentType = ContentType::where('slug', $slug)->firstOrFail();
        return redirect()->route('content-types.grapes-builder', $slug);
    }
}
