<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsFounder
{
    // public function handle(Request $request, Closure $next)
    // {
    //     if (Auth::check() && Auth::user()->is_founder) {
    //         return $next($request);
    //     }

    //     abort(403, 'Unauthorized');
    // }

    public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'founder') {
        return $next($request);
    }
    abort(403, 'Unauthorized access.');
}

}

