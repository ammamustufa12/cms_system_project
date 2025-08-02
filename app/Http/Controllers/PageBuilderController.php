<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
      public function index()
    {
        return view('vendor.twill.page-builder.index');
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
    
}
