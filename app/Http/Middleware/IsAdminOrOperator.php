<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminOrOperator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !($request->user()->hasRole('Admin') || $request->user()->hasRole('Operator'))) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 