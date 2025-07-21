<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('submissions', function (Blueprint $table) {
    $table->id();
    $table->string('artist_name');
    $table->string('song_title');
    $table->string('featured_artists')->nullable();
    $table->string('genre');
    $table->string('language');
    $table->string('composer_name');
    $table->string('writer_name');
    $table->date('release_date');
    $table->string('artwork_path');
    $table->string('music_file_path');
    $table->text('social_links')->nullable();
    $table->string('email');
    $table->string('phone')->nullable();
    $table->boolean('agreed_terms')->default(false);
    $table->string('status')->default('pending'); // pending, approved, rejected, in_progress
    $table->text('admin_notes')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
