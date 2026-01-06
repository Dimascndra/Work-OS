<?php

namespace App\Http\Controllers;

use App\Models\DomainMonitor;
use Illuminate\Http\Request;

class DomainMonitorController extends Controller
{
    public function index()
    {
        $monitors = DomainMonitor::with('server')->get();
        return view('pages.domain-monitors.index', compact('monitors'));
    }

    public function create()
    {
        $servers = \App\Models\Server::all();
        return view('pages.domain-monitors.create', compact('servers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'server_id' => 'nullable|exists:servers,id',
            'domain_url' => 'required|url',
            'status' => 'required|in:healthy,down,warning',
        ]);

        DomainMonitor::create($validated);

        return redirect()->route('domain-monitors.index')->with('success', 'Monitor created successfully');
    }

    public function edit(DomainMonitor $domainMonitor)
    {
        $servers = \App\Models\Server::all();
        return view('pages.domain-monitors.edit', compact('domainMonitor', 'servers'));
    }

    public function update(Request $request, DomainMonitor $domainMonitor)
    {
        $validated = $request->validate([
            'server_id' => 'nullable|exists:servers,id',
            'domain_url' => 'required|url',
            'status' => 'required|in:healthy,down,warning',
        ]);

        $domainMonitor->update($validated);

        return redirect()->route('domain-monitors.index')->with('success', 'Monitor updated successfully');
    }

    public function destroy(DomainMonitor $domainMonitor)
    {
        $domainMonitor->delete();
        return redirect()->route('domain-monitors.index')->with('success', 'Monitor deleted successfully');
    }
}
