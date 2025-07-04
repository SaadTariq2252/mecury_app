<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ScopedPath;
use Symfony\Component\HttpFoundation\Response;

class ValidateScopedPath
{
    public function handle(Request $request, Closure $next): Response
    {
        $pathSegments = $request->segments();
        
        // Skip validation for admin routes and API routes
        if ($this->shouldSkipValidation($request)) {
            return $next($request);
        }

        // Extract path identifier from URL
        $pathIdentifier = $pathSegments[0] ?? null;

        // Block root access for scoped users
        if (!$pathIdentifier) {
            return $this->blockRootAccess($request);
        }

        // Validate path exists and is active
        $scopedPath = ScopedPath::findByPath($pathIdentifier);
        if (!$scopedPath) {
            abort(404, 'Path not found');
        }

        // Store path context in session and request
        session(['current_scoped_path' => $pathIdentifier]);
        $request->attributes->set('scoped_path', $scopedPath);

        return $next($request);
    }

    private function shouldSkipValidation(Request $request): bool
    {
        $skipPaths = [
            'admin',
            'api',
            '_debugbar',
            'telescope',
            'storage'
        ];

        $firstSegment = $request->segment(1);
        return in_array($firstSegment, $skipPaths) || $request->is('admin/*');
    }

    private function blockRootAccess(Request $request): Response
    {
        return response()->view('errors.scoped-access-required', [], 403);
    }
}