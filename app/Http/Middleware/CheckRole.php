<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Sometimes Laravel passes comma-separated roles as a single array element if defined a certain way
        $parsedRoles = [];
        foreach ($roles as $roleGroup) {
            $parsedRoles = array_merge($parsedRoles, explode(',', $roleGroup));
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $parsedRoles)) {
            // Redirect based on their actual role if they try to access unauthorized pages
            if (in_array($userRole, ['superadmin', 'apoteker', 'kasir'])) {
                return redirect()->route('superadmin.dashboard');
            } else {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
