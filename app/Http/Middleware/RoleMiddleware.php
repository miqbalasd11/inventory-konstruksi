<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            abort(403);
        }

        $currentRole = strtolower(trim($request->user()->role?->name ?? ''));
        $allowedRoles = array_map(
            fn (string $value) => strtolower(trim($value)),
            preg_split('/[|,]/', $role)
        );

        if (! in_array($currentRole, $allowedRoles, true)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
