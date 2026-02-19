<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource (View).
     */
    public function index()
    {
        return view('pages.todos.index');
    }

    /**
     * Get listing of resource (JSON).
     */
    public function getTodos()
    {
        $todos = $this->todoService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Todos retrieved successfully',
            'data' => $todos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $todo = $this->todoService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Todo created successfully',
            'data' => $todo
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo = $this->todoService->update($todo, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Todo updated successfully',
            'data' => $todo
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $this->todoService->delete($todo);

        return response()->json([
            'success' => true,
            'message' => 'Todo deleted successfully',
            'data' => null
        ]);
    }
}
