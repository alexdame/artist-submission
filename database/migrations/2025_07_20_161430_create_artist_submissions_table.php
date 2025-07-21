<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artist_submissions', function (Blueprint $table) {
            $table->id();

            $table->string('artist_name');
            $table->string('song_title');
            $table->string('featured_artists')->nullable();
            $table->string('genre')->nullable();
            $table->string('language')->nullable();
            $table->string('composer_name');
            $table->string('writer_name');
            $table->date('release_date');
            $table->string('artwork_path');
            $table->string('music_file_path');
            $table->text('social_media_links')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->boolean('agreed_to_terms')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_submissions');
    }
}
