<?php

namespace App\Exports;

use App\Models\ArtistSubmission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubmissionsExport implements FromView
{
    protected $filteredData;

    public function __construct($filteredData)
    {
        $this->filteredData = $filteredData;
    }

    public function view(): View
    {
        return view('founder.exports.submissions', [
            'submissions' => $this->filteredData
        ]);
    }
}
