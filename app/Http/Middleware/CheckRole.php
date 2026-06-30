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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== $role) {
            // Redirect based on their actual role if they try to access unauthorized pages
            $userRole = Auth::user()->role;
            if ($userRole === 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            } elseif ($userRole === 'pegawai') {
                return redirect('/dashboard'); // placeholder
            } elseif ($userRole === 'pasien') {
                return redirect('/dashboard'); // placeholder
            }
            return redirect('/');
        }

        return $next($request);
    }
}
