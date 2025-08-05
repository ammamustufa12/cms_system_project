<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('vendor.twill.page-builder.index', compact('pages'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages',
        ]);

        Page::create($request->only('title', 'slug'));

        return redirect()->route('vendor.twill.page-builder.index')->with('success', 'Page created.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.builder', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->update([
            'html_content' => $request->input('html_content'),
            'css_content' => $request->input('css_content'),
        ]);

        return redirect()->route('pages.index')->with('success', 'Page updated.');
    }

    public function destroy($id)
    {
        Page::destroy($id);
        return redirect()->route('pages.index')->with('success', 'Page deleted.');
    }
}
