<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || (!$request->user()->isAdmin() && !$request->user()->isOperator())) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
