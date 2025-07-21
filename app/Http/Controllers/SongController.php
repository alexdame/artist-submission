<?php

// app/Http/Controllers/SongController.php

namespace App\Http\Controllers;

use App\Models\SongSubmission;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of publicly viewable (approved) songs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch only songs with 'approved' status, ordered by latest approval or submission date
        $approvedSongs = SongSubmission::where('status', 'approved')
                                        ->latest('updated_at') // Or 'created_at' if you prefer
                                        ->paginate(12); // Paginate, e.g., 12 songs per page

        return view('public.songs.index', compact('approvedSongs'));
    }
}