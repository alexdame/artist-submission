<?php

namespace App\Http\Controllers;

use App\Models\ArtistSubmission;
use App\Models\Royalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoyaltyController extends Controller
{
    public function showUploadForm()
    {
        return view('admin.upload-royalty');
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $path = $request->file('csv_file')->getRealPath();
        $rows = array_map('str_getcsv', file($path));
        $header = array_map('strtolower', $rows[0]);
        unset($rows[0]);

        foreach ($rows as $row) {
            $data = array_combine($header, $row);

            // Try to match by email or stage_name
            $artist = ArtistSubmission::where('email', $data['email'] ?? '')
                        ->orWhere('stage_name', 'like', '%' . ($data['artist'] ?? '') . '%')
                        ->first();

            if ($artist) {
                Royalty::create([
                    'artist_submission_id' => $artist->id,
                    'isrc' => $data['isrc'] ?? null,
                    'song_title' => $data['title'] ?? null,
                    'earnings' => $data['earnings'] ?? 0,
                    'platform' => $data['platform'] ?? 'Unknown',
                ]);
            }
        }

        return back()->with('success', 'Royalty data uploaded and matched successfully.');
    }
}
