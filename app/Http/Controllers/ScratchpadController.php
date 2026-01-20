<?php

namespace App\Http\Controllers;

use App\Models\Scratchpad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScratchpadController extends Controller
{
    public function index()
    {
        $scratchpads = Scratchpad::where('user_id', Auth::id())
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $scratchpads
        ]);
    }

    public function store(Request $request)
    {
        $maxPosition = Scratchpad::where('user_id', Auth::id())->max('position') ?? 0;

        $scratchpad = Scratchpad::create([
            'user_id' => Auth::id(),
            'title' => $request->title ?? 'Untitled Note',
            'content' => '',
            'color' => $request->color ?? 'warning',
            'position' => $maxPosition + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note created',
            'data' => $scratchpad
        ]);
    }

    public function update(Request $request, Scratchpad $scratchpad)
    {
        // Ensure user owns the note
        if ($scratchpad->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $scratchpad->update($request->only(['content', 'title', 'color']));

        return response()->json([
            'success' => true,
            'message' => 'Saved'
        ]);
    }

    public function destroy(Scratchpad $scratchpad)
    {
        if ($scratchpad->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $scratchpad->delete();

        return response()->json(['success' => true, 'message' => 'Deleted']);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array'
        ]);

        foreach ($request->order as $index => $id) {
            Scratchpad::where('id', $id)
                ->where('user_id', Auth::id())
                ->update(['position' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Reordered']);
    }

    public function show()
    {
        return $this->index();
    } // Backward compatibility or alias
}
