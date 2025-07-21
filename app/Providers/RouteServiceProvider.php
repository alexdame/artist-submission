<?php
// app/Providers/RouteServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    // Change this line:
    public const HOME = '/admin/submissions'; // Changed from '/dashboard'

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // ... (rest of the code) ...
    }

    // ... (map method) ...
}