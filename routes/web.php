<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/s/{code}', [App\Http\Controllers\ShortUrlController::class, 'redirect'])->name('short.redirect');

Route::get('/vuln-scanner', [App\Http\Controllers\VulnerabilityScannerController::class, 'index'])->name('vuln-scanner.index');
Route::post('/vuln-scanner', [App\Http\Controllers\VulnerabilityScannerController::class, 'scan'])->middleware('throttle:10,1')->name('vuln-scanner.scan');

Route::get('/subdomain-finder', [App\Http\Controllers\SubdomainFinderController::class, 'index'])->name('subdomain-finder.index');
Route::post('/subdomain-finder', [App\Http\Controllers\SubdomainFinderController::class, 'scan'])->middleware('throttle:10,1')->name('subdomain-finder.scan');

Route::get('/dns-checker', [App\Http\Controllers\DnsCheckerController::class, 'index'])->name('dns-checker.index');
Route::post('/dns-checker', [App\Http\Controllers\DnsCheckerController::class, 'check'])->middleware('throttle:10,1')->name('dns-checker.check');

Route::get('/ssl-checker', [App\Http\Controllers\SslCheckerController::class, 'index'])->name('ssl-checker.index');
Route::post('/ssl-checker', [App\Http\Controllers\SslCheckerController::class, 'check'])->middleware('throttle:10,1')->name('ssl-checker.check');

Route::get('/dnssec-analyzer', [App\Http\Controllers\DnsSecAnalyzerController::class, 'index'])->name('dnssec-analyzer.index');
Route::post('/dnssec-analyzer', [App\Http\Controllers\DnsSecAnalyzerController::class, 'analyze'])->middleware('throttle:10,1')->name('dnssec-analyzer.analyze');

Route::get('/domain-checker', [App\Http\Controllers\DomainCheckerController::class, 'index'])->name('domain-checker.index');
Route::post('/domain-checker', [App\Http\Controllers\DomainCheckerController::class, 'check'])->middleware('throttle:10,1')->name('domain-checker.check');

Route::get('/web-analyzer', [App\Http\Controllers\WebAnalyzerController::class, 'index'])->name('web-analyzer.index');
Route::post('/web-analyzer', [App\Http\Controllers\WebAnalyzerController::class, 'analyze'])->middleware('throttle:10,1')->name('web-analyzer.analyze');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Todo List Routes
    Route::prefix('todos')->name('todos.')->group(function () {
        Route::get('/', [App\Http\Controllers\TodoController::class, 'index'])->name('index');
        Route::get('/list', [App\Http\Controllers\TodoController::class, 'getTodos'])->name('list');
        Route::post('/', [App\Http\Controllers\TodoController::class, 'store'])->name('store');
        Route::put('/{todo}', [App\Http\Controllers\TodoController::class, 'update'])->name('update');
        Route::delete('/{todo}', [App\Http\Controllers\TodoController::class, 'destroy'])->name('destroy');

        // Scratchpad
        Route::get('scratchpad', [App\Http\Controllers\ScratchpadController::class, 'index'])->name('scratchpad.index');
        Route::post('scratchpad', [App\Http\Controllers\ScratchpadController::class, 'store'])->name('scratchpad.store');
        Route::put('scratchpad/reorder', [App\Http\Controllers\ScratchpadController::class, 'reorder'])->name('scratchpad.reorder');
        Route::put('scratchpad/{scratchpad}', [App\Http\Controllers\ScratchpadController::class, 'update'])->name('scratchpad.update');
        Route::delete('scratchpad/{scratchpad}', [App\Http\Controllers\ScratchpadController::class, 'destroy'])->name('scratchpad.destroy');
    });

    // User Management Modules
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/list', [App\Http\Controllers\UserController::class, 'getUsers'])->name('list');
        Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::put('/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });

    // Explicit Credentials Routes
    Route::prefix('credentials')->name('credentials.')->group(function () {
        Route::get('/', [App\Http\Controllers\CredentialController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\CredentialController::class, 'create'])->name('create');
        Route::get('/list', [App\Http\Controllers\CredentialController::class, 'getCredentials'])->name('list');
        Route::post('/', [App\Http\Controllers\CredentialController::class, 'store'])->name('store');
        Route::get('/{credential}/edit', [App\Http\Controllers\CredentialController::class, 'edit'])->name('edit');
        Route::put('/{credential}', [App\Http\Controllers\CredentialController::class, 'update'])->name('update');
        Route::delete('/{credential}', [App\Http\Controllers\CredentialController::class, 'destroy'])->name('destroy');
    });

    Route::get('/activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Infrastructure Modules
    Route::prefix('servers')->name('servers.')->group(function () {
        Route::get('/', [App\Http\Controllers\ServerController::class, 'index'])->name('index');
        Route::get('/list', [App\Http\Controllers\ServerController::class, 'getServers'])->name('list');
        Route::post('/', [App\Http\Controllers\ServerController::class, 'store'])->name('store');
        Route::put('/{server}', [App\Http\Controllers\ServerController::class, 'update'])->name('update');
        Route::delete('/{server}', [App\Http\Controllers\ServerController::class, 'destroy'])->name('destroy');
    });

    // Domain Monitors Module
    Route::prefix('domain-monitors')->name('domain-monitors.')->group(function () {
        Route::get('/', [App\Http\Controllers\DomainMonitorController::class, 'index'])->name('index');
        Route::get('/list', [App\Http\Controllers\DomainMonitorController::class, 'getMonitors'])->name('list');
        Route::post('/', [App\Http\Controllers\DomainMonitorController::class, 'store'])->name('store');
        Route::put('/{domainMonitor}', [App\Http\Controllers\DomainMonitorController::class, 'update'])->name('update');
        Route::delete('/{domainMonitor}', [App\Http\Controllers\DomainMonitorController::class, 'destroy'])->name('destroy');
        Route::post('/{domainMonitor}/check', [App\Http\Controllers\DomainMonitorController::class, 'check'])->name('check');
    });

    // Productivity Modules
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
    Route::resource('tasks', App\Http\Controllers\TaskController::class);

    // Snippets Routes
    Route::prefix('snippets')->name('snippets.')->group(function () {
        Route::get('/', [App\Http\Controllers\SnippetController::class, 'index'])->name('index');
        Route::get('/list', [App\Http\Controllers\SnippetController::class, 'getSnippets'])->name('list');
        Route::post('/', [App\Http\Controllers\SnippetController::class, 'store'])->name('store');
        Route::put('/{snippet}', [App\Http\Controllers\SnippetController::class, 'update'])->name('update');
        Route::delete('/{snippet}', [App\Http\Controllers\SnippetController::class, 'destroy'])->name('destroy');
    });

    Route::resource('subscriptions', App\Http\Controllers\SubscriptionController::class);
    Route::resource('subscriptions', App\Http\Controllers\SubscriptionController::class);
    Route::resource('short-urls', App\Http\Controllers\ShortUrlController::class);
    Route::get('/qr-generator', [App\Http\Controllers\QrCodeController::class, 'index'])->name('qr.index');

    Route::get('/productivity', [App\Http\Controllers\TimeEntryController::class, 'index'])->name('productivity.index');
    Route::post('/productivity/start', [App\Http\Controllers\TimeEntryController::class, 'store'])->name('productivity.store');
    Route::patch('/productivity/{timeEntry}/stop', [App\Http\Controllers\TimeEntryController::class, 'update'])->name('productivity.stop');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/dynamic-menus.php';
