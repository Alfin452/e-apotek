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

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
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
