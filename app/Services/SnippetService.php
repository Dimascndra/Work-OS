<?php

namespace App\Services;

use App\Models\Snippet;
use Illuminate\Database\Eloquent\Collection;

class SnippetService
{
    /**
     * Get all snippets.
     */
    public function getAll(): Collection
    {
        return Snippet::latest()->get();
    }

    /**
     * Create a new snippet.
     */
    public function create(array $data): Snippet
    {
        // Tag handling
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        return Snippet::create($data);
    }

    /**
     * Update a snippet.
     */
    public function update(Snippet $snippet, array $data): Snippet
    {
        // Tag handling
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        }

        $snippet->update($data);
        return $snippet->refresh();
    }

    /**
     * Delete a snippet.
     */
    public function delete(Snippet $snippet): bool
    {
        return $snippet->delete();
    }
}
