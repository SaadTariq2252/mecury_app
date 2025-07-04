<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceScopedAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $currentPath = session('current_scoped_path');

        // If user is authenticated, validate path access
        if ($user && $currentPath) {
            if (!$user->hasPathAccess($currentPath)) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();
                
                return redirect()->route('scoped.login', ['path' => $currentPath])
                    ->withErrors(['access' => 'You do not have access to this path.']);
            }

            // Prevent session fixation across different paths
            $sessionPath = session('authenticated_path');
            if ($sessionPath && $sessionPath !== $currentPath) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();
                
                return redirect()->route('scoped.login', ['path' => $currentPath])
                    ->withErrors(['access' => 'Session expired. Please log in again.']);
            }
        }

        return $next($request);
    }
}