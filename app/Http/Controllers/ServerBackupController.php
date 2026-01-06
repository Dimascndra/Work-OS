<?php

namespace App\Http\Controllers;

use App\Models\ServerBackup;
use Illuminate\Http\Request;

class ServerBackupController extends Controller
{
    public function index()
    {
        $backups = ServerBackup::with('server')->latest()->get();
        return view('pages.server-backups.index', compact('backups'));
    }

    public function create()
    {
        $servers = \App\Models\Server::all();
        return view('pages.server-backups.create', compact('servers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'server_id' => 'required|exists:servers,id',
            'file_name' => 'required|string',
            'size_mb' => 'required|numeric',
            'storage_path' => 'required|string',
            'status' => 'required|in:success,failed',
        ]);

        ServerBackup::create($validated);

        return redirect()->route('server-backups.index')->with('success', 'Backup record created successfully');
    }

    public function destroy(ServerBackup $serverBackup)
    {
        $serverBackup->delete();
        return redirect()->route('server-backups.index')->with('success', 'Backup record deleted successfully');
    }
}
