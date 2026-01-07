<?php

namespace App\Http\Controllers;

use App\Models\SshKey;
use Illuminate\Http\Request;

class SshKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sshKeys = SshKey::all();
        return view('pages.ssh-keys.index', compact('sshKeys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.ssh-keys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ip_server' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'port' => 'required|integer',
            'public_key' => 'nullable|string',
        ]);

        SshKey::create($validated);

        return redirect()->route('ssh-keys.index')->with('success', 'SSH Key created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SshKey $sshKey)
    {
        return view('pages.ssh-keys.edit', compact('sshKey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SshKey $sshKey)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ip_server' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'port' => 'required|integer',
            'public_key' => 'nullable|string',
        ]);

        $sshKey->update($validated);

        return redirect()->route('ssh-keys.index')->with('success', 'SSH Key updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SshKey $sshKey)
    {
        $sshKey->delete();
        return redirect()->route('ssh-keys.index')->with('success', 'SSH Key deleted successfully');
    }
}
