<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Get the authenticated user
        $user = Auth::user();

        // If no roles specified, just check if user is authenticated
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user's role matches any of the allowed roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // User doesn't have required role - abort with 403
        abort(403, 'You do not have permission to access this page. Required role: ' . implode(', ', $roles));
    }
}