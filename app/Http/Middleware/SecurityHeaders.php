<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Remove X-Powered-By
        // Note: For some server configs, this might need php.ini change, but we try here.
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        // Add Security Headers
        $headers = [
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            // Permissive CSP to start with (allows inline scripts/styles for Metronic)
            'Content-Security-Policy' => "default-src 'self' http: https: data: blob: 'unsafe-inline' 'unsafe-eval';",
            'X-XSS-Protection' => '1; mode=block',
            // Add Permissions-Policy (Camera, Mic, Geolocation disabled by default)
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ];

        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        // Remove 'Server' header if possible (often managed by web server)
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
