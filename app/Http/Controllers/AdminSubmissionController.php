<?php

// app/Http/Controllers/AdminSubmissionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SongSubmission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail; // Used for email notifications (even if skipped for now)
use App\Mail\SubmissionStatusUpdated; // Used for email notifications (even if skipped for now)
use Illuminate\Support\Facades\Log; // Added for logging potential errors

class AdminSubmissionController extends Controller
{
    /**
     * Display a listing of the song submissions with search and filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $statusFilter = $request->query('status_filter', 'all'); // Default to 'all'

        $query = SongSubmission::query();

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('artist_name', 'like', '%' . $search . '%')
                  ->orWhere('song_title', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $submissions = $query->latest()->paginate(10); // Order by latest and paginate

        return view('admin.submissions.index', compact('submissions', 'search', 'statusFilter'));
    }

    /**
     * Display the specified song submission.
     *
     * @param  \App\Models\SongSubmission  $songSubmission
     * @return \Illuminate\View\View
     */
    public function show(SongSubmission $songSubmission)
    {
        // Define your hypothetical royalty rate per stream (e.g., $0.003 per stream)
        // This can be made configurable in a real application.
        $royaltyRatePerStream = 0.003;

        // Calculate the hypothetical royalty
        $hypotheticalRoyalty = $songSubmission->streams * $royaltyRatePerStream;

        return view('admin.submissions.show', compact('songSubmission', 'hypotheticalRoyalty', 'royaltyRatePerStream'));
    }

    /**
     * Show the form for editing the specified song submission.
     *
     * @param  \App\Models\SongSubmission  $songSubmission
     * @return \Illuminate\View\View
     */
    public function edit(SongSubmission $songSubmission)
    {
        return view('admin.submissions.edit', compact('songSubmission'));
    }

    /**
     * Update the specified song submission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SongSubmission  $songSubmission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SongSubmission $songSubmission)
    {
        $validatedData = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'approved', 'rejected'])],
            'internal_notes' => 'nullable|string|max:1000',
        ]);

        // Capture old status to check if it changed
        $oldStatus = $songSubmission->status;

        $songSubmission->update($validatedData);

        // Send status update email ONLY if status has changed
        // This section for email notification was added previously.
        // If you truly skipped it, ensure your .env is configured for mail.
        if ($songSubmission->status !== $oldStatus) {
            try {
                Mail::to($songSubmission->email)->send(new SubmissionStatusUpdated($songSubmission));
            } catch (\Exception $e) {
                Log::error('Failed to send status update email for submission ID ' . $songSubmission->id . ': ' . $e->getMessage());
                // Optionally, add a flash message to admin indicating email send failure
                session()->flash('error', 'Submission updated, but failed to send status update email.');
            }
        }

        return redirect()->route('admin.submissions.show', $songSubmission->id)
                         ->with('success', 'Submission updated successfully!');
    }

    /**
     * Remove the specified song submission from storage.
     *
     * @param  \App\Models\SongSubmission  $songSubmission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SongSubmission $songSubmission)
    {
        // Optional: Delete associated audio file from storage
        if ($songSubmission->audio_path && Storage::disk('public')->exists($songSubmission->audio_path)) {
            Storage::disk('public')->delete($songSubmission->audio_path);
        }

        $songSubmission->delete();

        return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted successfully!');
    }
}