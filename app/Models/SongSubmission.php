<?php

// app/Models/SongSubmission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // <-- New: Add user_id to fillable
        'artist_name',
        'song_title',
        'genre',
        'release_date',
        'email',
        'audio_path',
        'status',
        'internal_notes',
        'streams', // Make sure 'streams' is also fillable if you ever mass-assign it
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    /**
     * Get the user that owns the song submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}