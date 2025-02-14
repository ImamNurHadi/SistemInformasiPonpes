<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roleNames): Response
    {
        if (!$request->user() || !$request->user()->role_id) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil role_id user
        $userRoleId = $request->user()->role_id;
        
        // Jika user adalah Santri (9e34da35-0cad-473d-ab84-ebaaed8e47c0), hanya boleh mengakses method GET
        if ($userRoleId === '9e34da35-0cad-473d-ab84-ebaaed8e47c0' && !$request->isMethod('get')) {
            abort(403, 'Santri hanya memiliki akses untuk melihat data.');
        }

        // Jika ada role yang diizinkan
        if (!empty($roleNames)) {
            // Ambil role_id berdasarkan nama role yang diizinkan
            $allowedRoleIds = Role::whereIn('name', $roleNames)->pluck('id')->toArray();
            
            if (!in_array($userRoleId, $allowedRoleIds)) {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
