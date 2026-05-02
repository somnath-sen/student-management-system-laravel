<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Must be logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Must have a role assigned
        if (empty($user->role_id)) {
            abort(403, 'Access Denied: No role assigned to this account.');
        }

        // 3. Look up the actual role name from the DB (avoids hardcoded ID mismatch)
        $userRoleName = DB::table('roles')->where('id', $user->role_id)->value('name');

        // 4. Allow if the user's role is in the allowed list
        if ($userRoleName && in_array($userRoleName, $roles)) {
            return $next($request);
        }

        // 5. Block access — wrong role
        abort(403, '403 Forbidden: You do not have the required permissions.');
    }
}