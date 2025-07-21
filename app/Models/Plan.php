<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'max_artists', 'royalty_percentage',
        'allow_lyrics', 'allow_video', 'allow_splits', 'full_reports',
        'marketing_page', 'distribution_time_hours'
    ];
}

