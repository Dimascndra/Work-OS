<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;

class CredentialController extends Controller
{
    public function index()
    {
        $credentials = Credential::all();
        return view('pages.credentials.index', compact('credentials'));
    }

    public function create()
    {
        return view('pages.credentials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'service_name' => 'required|string',
            'url' => 'nullable|url',
            'username' => 'required|string',
            'password' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Credential::create($validated);

        return redirect()->route('credentials.index')->with('success', 'Credential created successfully');
    }

    public function edit(Credential $credential)
    {
        return view('pages.credentials.edit', compact('credential'));
    }

    public function update(Request $request, Credential $credential)
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'service_name' => 'required|string',
            'url' => 'nullable|url',
            'username' => 'required|string',
            'password' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $credential->update($validated);

        return redirect()->route('credentials.index')->with('success', 'Credential updated successfully');
    }
}
