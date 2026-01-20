<?php

namespace App\Http\Controllers;

use App\Models\Scratchpad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScratchpadController extends Controller
{
    public function show()
    {
        $scratchpad = Scratchpad::firstOrCreate(
            ['user_id' => Auth::id()],
            ['content' => '']
        );

        return response()->json([
            'success' => true,
            'data' => $scratchpad
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string'
        ]);

        $scratchpad = Scratchpad::updateOrCreate(
            ['user_id' => Auth::id()],
            ['content' => $request->content]
        );

        return response()->json([
            'success' => true,
            'message' => 'Saved',
            'data' => $scratchpad
        ]);
    }
}
