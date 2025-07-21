<?php

namespace App\Http\Controllers;

use App\Models\ArtistSubmission;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubmissionsExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FounderController extends Controller
{
    public function index(Request $request)
    {
        $query = ArtistSubmission::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('stage_name', 'like', "%$search%");
        }

        $submissions = $query->latest()->paginate(10);

        return view('founder.dashboard', compact('submissions'));
    }

    public function downloadArtwork($id): BinaryFileResponse
    {
        $submission = ArtistSubmission::findOrFail($id);
        return response()->download(storage_path("app/public/" . $submission->artwork));
    }

    public function downloadMusic($id): BinaryFileResponse
    {
        $submission = ArtistSubmission::findOrFail($id);
        return response()->download(storage_path("app/public/" . $submission->music));
    }

    public function exportCSV()
    {
        return Excel::download(new SubmissionsExport, 'submissions.csv');
    }

    public function exportExcel()
    {
        return Excel::download(new SubmissionsExport, 'submissions.xlsx');
    }

    public function exportXLSX()
    {
        return Excel::download(new SubmissionsExport, 'submissions.xlsx');
    }
}
