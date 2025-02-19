<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOperator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->role || $request->user()->role->name !== 'Operator') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 