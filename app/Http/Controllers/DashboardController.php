<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Snippet;
use App\Models\Server;
use App\Models\DomainMonitor;
use App\Models\User;
use App\Models\Credential;

class DashboardController extends Controller
{
    public function index()
    {
        // Todo Statistics
        $todosCount = Todo::count();
        $recentTodos = Todo::latest()->take(5)->get();

        // Snippet Statistics
        $snippetsCount = Snippet::count();
        $recentSnippets = Snippet::latest()->take(5)->get();

        // Server Statistics
        $serversCount = Server::count();
        $serversActive = Server::where('is_active', true)->count();
        $recentServers = Server::latest()->take(5)->get();

        // Domain Monitor Statistics
        $monitorsCount = DomainMonitor::count();
        $recentMonitors = DomainMonitor::latest()->take(5)->get();

        // User Statistics
        $usersCount = User::count();
        $recentUsers = User::latest()->take(5)->get();

        // Credential Statistics
        $credentialsCount = Credential::count();
        $recentCredentials = Credential::latest()->take(5)->get();

        return view('dashboard', compact(
            'todosCount',
            'recentTodos',
            'snippetsCount',
            'recentSnippets',
            'serversCount',
            'serversActive',
            'recentServers',
            'monitorsCount',
            'recentMonitors',
            'usersCount',
            'recentUsers',
            'credentialsCount',
            'recentCredentials'
        ));
    }
}
