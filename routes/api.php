<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StreamController; // <-- New: Import StreamController

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// New API route for incrementing streams
// Using a rate limit to prevent abuse (e.g., 60 requests per minute per IP)
Route::post('/songs/{songSubmission}/stream', [StreamController::class, 'increment'])
     ->middleware('throttle:60,1') // Limits to 60 requests per minute
     ->name('api.songs.stream.increment');