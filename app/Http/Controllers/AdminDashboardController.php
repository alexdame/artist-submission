<?php

namespace App\Http\Controllers;

use App\Models\ArtistSubmission;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FilteredSubmissionsExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = ArtistSubmission::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('genre')) {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }

        $submissions = $query->latest()->paginate(10);

        return view('admin.dashboard', compact('submissions'));
    }

    public function downloadFile($id, $type)
    {
        $submission = ArtistSubmission::findOrFail($id);

        $filePath = $type === 'artwork' ? $submission->artwork_path : $submission->music_path;
        $filePath = storage_path('app/' . $filePath);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    }

    public function exportCsv(Request $request): BinaryFileResponse
    {
        return Excel::download(new FilteredSubmissionsExport($request), 'submissions.csv');
    }

    public function exportXlsx(Request $request): BinaryFileResponse
    {
        return Excel::download(new FilteredSubmissionsExport($request), 'submissions.xlsx');
    }
}
