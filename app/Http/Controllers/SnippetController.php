<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use Illuminate\Http\Request;

class SnippetController extends Controller
{
    public function index()
    {
        $snippets = Snippet::latest()->get();
        return view('pages.snippets.index', compact('snippets'));
    }

    public function create()
    {
        return view('pages.snippets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code_content' => 'required|string',
            'language' => 'required|string',
            'tags' => 'nullable|string', // Comma separated in UI, convert to json array
        ]);

        if ($request->has('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['tags'] = $tags;
        }

        Snippet::create($validated);

        return redirect()->route('snippets.index')->with('success', 'Snippet created successfully');
    }

    public function edit(Snippet $snippet)
    {
        return view('pages.snippets.edit', compact('snippet'));
    }

    public function update(Request $request, Snippet $snippet)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code_content' => 'required|string',
            'language' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        if ($request->has('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['tags'] = $tags;
        }

        $snippet->update($validated);

        return redirect()->route('snippets.index')->with('success', 'Snippet updated successfully');
    }

    public function destroy(Snippet $snippet)
    {
        $snippet->delete();
        return redirect()->route('snippets.index')->with('success', 'Snippet deleted successfully');
    }
}
