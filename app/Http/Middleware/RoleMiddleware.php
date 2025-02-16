<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized action.');
        }

        // Jika tidak ada role yang ditentukan, hanya cek apakah user adalah admin
        if (!$role) {
            if (!$request->user()->isAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        }

        // Cek negasi role
        if (str_starts_with($role, '!')) {
            $role = substr($role, 1);
            if ($request->user()->hasRole($role)) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        }

        // Cek role normal
        if (!$request->user()->hasRole($role)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
