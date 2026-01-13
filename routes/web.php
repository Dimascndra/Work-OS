<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/s/{code}', [App\Http\Controllers\ShortUrlController::class, 'redirect'])->name('short.redirect');

Route::get('/vuln-scanner', [App\Http\Controllers\VulnerabilityScannerController::class, 'index'])->name('vuln-scanner.index');
Route::post('/vuln-scanner', [App\Http\Controllers\VulnerabilityScannerController::class, 'scan'])->middleware('throttle:10,1')->name('vuln-scanner.scan');

Route::get('/subdomain-finder', [App\Http\Controllers\SubdomainFinderController::class, 'index'])->name('subdomain-finder.index');
Route::post('/subdomain-finder', [App\Http\Controllers\SubdomainFinderController::class, 'scan'])->middleware('throttle:10,1')->name('subdomain-finder.scan');

Route::get('/subdomain-finder', [App\Http\Controllers\SubdomainFinderController::class, 'index'])->name('subdomain-finder.index');
Route::post('/subdomain-finder', [App\Http\Controllers\SubdomainFinderController::class, 'scan'])->middleware('throttle:10,1')->name('subdomain-finder.scan');

Route::get('/dns-checker', [App\Http\Controllers\DnsCheckerController::class, 'index'])->name('dns-checker.index');
Route::post('/dns-checker', [App\Http\Controllers\DnsCheckerController::class, 'check'])->middleware('throttle:10,1')->name('dns-checker.check');

Route::get('/ssl-checker', [App\Http\Controllers\SslCheckerController::class, 'index'])->name('ssl-checker.index');
Route::post('/ssl-checker', [App\Http\Controllers\SslCheckerController::class, 'check'])->middleware('throttle:10,1')->name('ssl-checker.check');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Security Modules
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('/credentials', [App\Http\Controllers\CredentialController::class, 'index'])->name('credentials.index');
    Route::get('/credentials/create', [App\Http\Controllers\CredentialController::class, 'create'])->name('credentials.create');
    Route::post('/credentials', [App\Http\Controllers\CredentialController::class, 'store'])->name('credentials.store');
    Route::get('/credentials/{credential}/edit', [App\Http\Controllers\CredentialController::class, 'edit'])->name('credentials.edit');
    Route::put('/credentials/{credential}', [App\Http\Controllers\CredentialController::class, 'update'])->name('credentials.update');

    Route::get('/activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');

    // Infrastructure Modules
    Route::resource('servers', App\Http\Controllers\ServerController::class);
    Route::resource('domain-monitors', App\Http\Controllers\DomainMonitorController::class);

    // Productivity Modules
    Route::resource('tasks', App\Http\Controllers\TaskController::class);
    Route::resource('snippets', App\Http\Controllers\SnippetController::class);
    Route::resource('subscriptions', App\Http\Controllers\SubscriptionController::class);
    Route::resource('short-urls', App\Http\Controllers\ShortUrlController::class);
    Route::get('/qr-generator', [App\Http\Controllers\QrCodeController::class, 'index'])->name('qr.index');
    Route::get('/domain-checker', [App\Http\Controllers\DomainCheckerController::class, 'index'])->name('domain-checker.index');
    Route::post('/domain-checker', [App\Http\Controllers\DomainCheckerController::class, 'check'])->name('domain-checker.check');


    Route::get('/productivity', [App\Http\Controllers\TimeEntryController::class, 'index'])->name('productivity.index');
    Route::post('/productivity/start', [App\Http\Controllers\TimeEntryController::class, 'store'])->name('productivity.store');
    Route::patch('/productivity/{timeEntry}/stop', [App\Http\Controllers\TimeEntryController::class, 'update'])->name('productivity.stop');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/dynamic-menus.php';
