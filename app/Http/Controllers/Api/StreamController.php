<?php

// app/Http/Controllers/Api/StreamController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SongSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // For logging

class StreamController extends Controller
{
    /**
     * Increment the stream count for a given song submission.
     *
     * @param  \App\Models\SongSubmission  $songSubmission
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function increment(SongSubmission $songSubmission, Request $request)
    {
        // Optional: Basic check to ensure it's an approved song
        if ($songSubmission->status !== 'approved') {
            return response()->json(['message' => 'Song is not approved for public streaming.'], 403);
        }

        try {
            // Increment the streams column
            $songSubmission->increment('streams');

            // Log for debugging (optional)
            Log::info("Streamed: {$songSubmission->song_title} (ID: {$songSubmission->id}) - new count: {$songSubmission->streams}");

            return response()->json(['message' => 'Stream count incremented.', 'streams' => $songSubmission->streams]);
        } catch (\Exception $e) {
            Log::error('Error incrementing stream: ' . $e->getMessage(), ['song_id' => $songSubmission->id, 'exception' => $e]);
            return response()->json(['message' => 'Failed to increment stream count.'], 500);
        }
    }
}