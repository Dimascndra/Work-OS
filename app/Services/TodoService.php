<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

class TodoService
{
    /**
     * Get all todos.
     */
    public function getAll(): Collection
    {
        return Todo::latest()->get();
    }

    /**
     * Create a new todo.
     */
    public function create(array $data): Todo
    {
        return Todo::create($data);
    }

    /**
     * Update a todo.
     */
    public function update(Todo $todo, array $data): Todo
    {
        $todo->update($data);
        return $todo->refresh();
    }

    /**
     * Delete a todo.
     */
    public function delete(Todo $todo): bool
    {
        return $todo->delete();
    }
}
