<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::all();
        return view('pages.servers.index', compact('servers'));
    }

    public function create()
    {
        return view('pages.servers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'ip_address' => 'required|string', // Changed from 'ip' to 'string' to allow domains
            'port' => 'required|integer',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'private_key' => 'nullable|string',
            'public_key' => 'nullable|string',
            'os_type' => 'required|string',
            'server_type' => 'required|in:Physical,VPS,Cloud,Container,Other',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        // checkbox handling for boolean
        $validated['is_active'] = $request->has('is_active');

        Server::create($validated);

        return redirect()->route('servers.index')->with('success', 'Server created successfully');
    }

    public function edit(Server $server)
    {
        return view('pages.servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'ip_address' => 'required|string', // Changed from 'ip' to 'string' to allow domains
            'port' => 'required|integer',
            'username' => 'required|string',
            'password' => 'nullable|string',
            'private_key' => 'nullable|string',
            'public_key' => 'nullable|string',
            'os_type' => 'required|string',
            'server_type' => 'required|in:Physical,VPS,Cloud,Container,Other',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // If password field is empty, don't update it (preserve existing password)
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $server->update($validated);

        return redirect()->route('servers.index')->with('success', 'Server updated successfully');
    }

    public function destroy(Server $server)
    {
        $server->delete();
        return redirect()->route('servers.index')->with('success', 'Server deleted successfully');
    }
}
