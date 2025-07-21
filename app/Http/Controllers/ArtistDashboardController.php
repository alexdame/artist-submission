<?php

// app/Http/Controllers/ArtistDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SongSubmission; // Import the SongSubmission model

class ArtistDashboardController extends Controller
{
    /**
     * Display the artist's dashboard with their submissions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the currently authenticated user's ID
        $userId = Auth::id();

        // Fetch only the submissions belonging to the logged-in user
        $submissions = SongSubmission::where('user_id', $userId)
                                     ->latest() // Order by latest submission
                                     ->paginate(10); // Paginate the results

        // Define the hypothetical royalty rate (same as in AdminSubmissionController for consistency)
        $royaltyRatePerStream = 0.003;

        return view('artist.dashboard', compact('submissions', 'royaltyRatePerStream'));
    }
}