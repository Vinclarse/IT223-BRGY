<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Check if user is logged in
        if (!session()->has('user')) {
            return redirect('/profile_guest')->with('error', 'Please log in first.');
        }

        // Check if the user's role matches the required role
        if ($role && session('user.role') !== $role) {
            return redirect('/profile_guest')->with('error', 'Unauthorized access for this role.');
        }

        // Continue request
        return $next($request);
    }
}
