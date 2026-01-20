<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServerRequest;
use App\Http\Requests\UpdateServerRequest;
use App\Models\Server;
use App\Services\ServerService;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    protected $serverService;

    public function __construct(ServerService $serverService)
    {
        $this->serverService = $serverService;
    }

    public function index()
    {
        return view('pages.servers.index');
    }

    public function getServers()
    {
        $servers = $this->serverService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Servers retrieved successfully',
            'data' => $servers
        ]);
    }

    public function store(StoreServerRequest $request)
    {
        $server = $this->serverService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Server created successfully',
            'data' => $server
        ], 201);
    }

    public function update(UpdateServerRequest $request, Server $server)
    {
        $server = $this->serverService->update($server, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Server updated successfully',
            'data' => $server
        ]);
    }

    public function destroy(Server $server)
    {
        $this->serverService->delete($server);

        return response()->json([
            'success' => true,
            'message' => 'Server deleted successfully',
            'data' => null
        ]);
    }
}
