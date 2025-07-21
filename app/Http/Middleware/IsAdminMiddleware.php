<?php

// app/Http/Middleware/IsAdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated AND if the authenticated user is an admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // If not an admin, redirect or abort
        // You can choose to redirect to home, login, or abort with a 403 Forbidden
        return redirect('/dashboard')->with('error', 'You do not have admin access.');
        // Or: abort(403, 'Unauthorized action.');
    }
}