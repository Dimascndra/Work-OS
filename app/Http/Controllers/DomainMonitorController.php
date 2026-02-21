<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainMonitorRequest;
use App\Http\Requests\UpdateDomainMonitorRequest;
use App\Models\DomainMonitor;
use App\Services\DomainMonitorService;
use Illuminate\Http\Request;

class DomainMonitorController extends Controller
{
    protected $domainMonitorService;

    public function __construct(DomainMonitorService $domainMonitorService)
    {
        $this->domainMonitorService = $domainMonitorService;
    }

    public function index()
    {
        return view('pages.domain-monitors.index');
    }

    public function getMonitors()
    {
        $monitors = $this->domainMonitorService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Monitors retrieved successfully',
            'data'    => $monitors
        ]);
    }

    public function store(StoreDomainMonitorRequest $request)
    {
        $monitor = $this->domainMonitorService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Monitor created successfully',
            'data'    => $monitor
        ], 201);
    }

    public function update(UpdateDomainMonitorRequest $request, DomainMonitor $domainMonitor)
    {
        $monitor = $this->domainMonitorService->update($domainMonitor, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Monitor updated successfully',
            'data'    => $monitor
        ]);
    }

    public function destroy(DomainMonitor $domainMonitor)
    {
        $this->domainMonitorService->delete($domainMonitor);

        return response()->json([
            'success' => true,
            'message' => 'Monitor deleted successfully',
            'data'    => null
        ]);
    }

    public function check(DomainMonitor $domainMonitor)
    {
        $monitor = $this->domainMonitorService->checkDomain($domainMonitor);

        return response()->json([
            'success' => true,
            'message' => 'Domain checked successfully',
            'data'    => $monitor
        ]);
    }
}
