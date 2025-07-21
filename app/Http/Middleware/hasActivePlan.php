<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class hasActivePlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and if their role is 'admin'
        if (!auth()->user()->hasActivePlan()) {
    return redirect()->route('plans.select')->with('error', 'Please select and pay for a plan before submitting.');
}


        // If not an admin, redirect them.
        // You can redirect to '/dashboard', '/' or a specific error page.
        return redirect('/dashboard')->with('error', 'Access Denied! You do not have an active plan.');
    }
}