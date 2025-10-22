<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBackButtonCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only apply cache control headers to authenticated users on protected pages
        if (Auth::check() && $this->isProtectedPage($request)) {
            // Set headers to prevent caching of protected pages
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            
            // Additional security headers
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            
            // Add a unique timestamp to prevent browser caching
            $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');
            $response->headers->set('ETag', '"' . md5(time() . $request->url()) . '"');
        }

        return $response;
    }

    /**
     * Check if the current page is a protected page that should not be cached
     */
    private function isProtectedPage(Request $request): bool
    {
        $protectedPaths = [
            '/dashboard',
            '/profile',
            '/speech-conversion',
            '/sign-language'
        ];

        $currentPath = $request->path();
        
        foreach ($protectedPaths as $protectedPath) {
            if (str_starts_with($currentPath, ltrim($protectedPath, '/'))) {
                return true;
            }
        }

        return false;
    }
}
