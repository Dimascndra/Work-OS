<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSnippetRequest;
use App\Http\Requests\UpdateSnippetRequest;
use App\Models\Snippet;
use App\Services\SnippetService;
use Illuminate\Http\Request;

class SnippetController extends Controller
{
    protected $snippetService;

    public function __construct(SnippetService $snippetService)
    {
        $this->snippetService = $snippetService;
    }

    public function index()
    {
        return view('pages.snippets.index');
    }

    public function getSnippets()
    {
        $snippets = $this->snippetService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Snippets retrieved successfully',
            'data' => $snippets
        ]);
    }

    public function store(StoreSnippetRequest $request)
    {
        $snippet = $this->snippetService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Snippet created successfully',
            'data' => $snippet
        ], 201);
    }

    public function update(UpdateSnippetRequest $request, Snippet $snippet)
    {
        $snippet = $this->snippetService->update($snippet, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Snippet updated successfully',
            'data' => $snippet
        ]);
    }

    public function destroy(Snippet $snippet)
    {
        $this->snippetService->delete($snippet);

        return response()->json([
            'success' => true,
            'message' => 'Snippet deleted successfully',
            'data' => null
        ]);
    }
}
