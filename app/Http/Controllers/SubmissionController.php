<?php

// app/Http/Controllers/SubmissionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // For date manipulation
use App\Models\SongSubmission; // Import your new Eloquent Model
use Illuminate\Support\Facades\Storage; // For file storage operations
use App\Mail\SubmissionReceived;

class SubmissionController extends Controller
{
    /**
     * Display the song submission form.
     */
   public function create() {
    return view('submit');
}

public function store(Request $request) {
    $request->validate([
        'artist_name' => 'required',
        'song_title' => 'required',
        'composer_name' => 'required',
        'writer_name' => 'required',
        'release_date' => 'required|date|after:6 days',
        'artwork' => 'required|file',
        'music_file' => 'required|file',
        'email' => 'required|email',
        'agreed_terms' => 'accepted',
    ]);

    $artwork = $request->file('artwork')->store('artworks');
    $music = $request->file('music_file')->store('songs');

    Submission::create([
        'artist_name' => $request->artist_name,
        'song_title' => $request->song_title,
        'featured_artists' => $request->featured_artists,
        'genre' => $request->genre,
        'language' => $request->language,
        'composer_name' => $request->composer_name,
        'writer_name' => $request->writer_name,
        'release_date' => $request->release_date,
        'artwork_path' => $artwork,
        'music_file_path' => $music,
        'social_links' => $request->social_links,
        'email' => $request->email,
        'phone' => $request->phone,
        'agreed_terms' => true,
    ]);

    return back()->with('success', 'Submission received successfully!');
}
}