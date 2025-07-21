<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtistSubmission;
use App\Models\Plan;
use Illuminate\Support\Facades\Session;

class ArtistSubmissionController extends Controller
{
    public function create()
    {
        $planId = Session::get('selected_plan_id');
        $reference = Session::get('paystack_reference');

        if (!$planId) {
            return redirect()->route('plans')->with('error', 'Please select a plan first.');
        }

        return view('artist.submission_form', compact('planId', 'reference'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'artist_name' => 'required|string|max:255',
            'song_title' => 'required|string|max:255',
            'composer_name' => 'required|string|max:255',
            'writer_name' => 'required|string|max:255',
            'release_date' => 'required|date',
            'artwork' => 'required|image',
            'music_file' => 'required|file|mimes:mp3,wav',
            'email' => 'required|email',
            'agreed_to_terms' => 'required|accepted',
        ]);

        // Handle file uploads
        $artworkPath = $request->file('artwork')->store('uploads/artworks', 'public');
        $musicPath = $request->file('music_file')->store('uploads/music', 'public');

        $submission = new ArtistSubmission();
        $submission->artist_name = $request->artist_name;
        $submission->song_title = $request->song_title;
        $submission->featured_artists = $request->featured_artists;
        $submission->genre = $request->genre;
        $submission->language = $request->language;
        $submission->composer_name = $request->composer_name;
        $submission->writer_name = $request->writer_name;
        $submission->release_date = $request->release_date;
        $submission->artwork_path = $artworkPath;
        $submission->music_file_path = $musicPath;
        $submission->social_media_links = $request->social_media_links;
        $submission->email = $request->email;
        $submission->phone_number = $request->phone_number;
        $submission->agreed_to_terms = true;
        $submission->plan_id = Session::get('selected_plan_id');
        $submission->paystack_reference = Session::get('paystack_reference');
        $submission->payment_verified = Session::get('payment_verified') ?? false;
        $submission->created_at = now();

        $submission->save();

        return redirect()->route('submission.success')->with('success', 'Submission received!');
    }

    public function success()
    {
        return view('artist.submission_success');
    }
}
