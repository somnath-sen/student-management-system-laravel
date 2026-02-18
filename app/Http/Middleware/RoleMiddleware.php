<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Safely check if the user has a role_id assigned in the database
        if (empty($user->role_id)) {
            abort(403, 'Access Denied: Role ID is not assigned to this user account.');
        }

        // 3. Map the database integer to the string role names used in web.php
        $roleMap = [
            1 => 'admin',
            2 => 'teacher',
            3 => 'student',
        ];

        $userRoleName = $roleMap[$user->role_id] ?? null;

        // 4. Check if the user's mapped role exists in the allowed $roles array
        if ($userRoleName && in_array($userRoleName, $roles)) {
            return $next($request);
        }

        // 5. If they don't match, block access
        abort(403, '403 Forbidden: You do not have the required permissions.');
    }
}