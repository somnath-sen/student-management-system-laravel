<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthenticated');
        }

        $user = auth()->user();

        // Map role names to role_id
        $roleMap = [
            'admin'   => 1,
            'teacher' => 2,
            'student' => 3,
        ];

        foreach ($roles as $role) {
            if (
                isset($roleMap[$role]) &&
                (int) $user->role_id === (int) $roleMap[$role]
            ) {
                return $next($request);
            }
        }

        abort(403, 'Forbidden');
    }
}
