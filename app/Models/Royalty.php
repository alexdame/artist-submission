<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Royalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_submission_id', 'isrc', 'song_title', 'earnings', 'platform',
    ];

    public function artist()
    {
        return $this->belongsTo(ArtistSubmission::class, 'artist_submission_id');
    }
}
