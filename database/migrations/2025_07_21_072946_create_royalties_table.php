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
        Schema::create('royalties', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('artist_submission_id');
    $table->string('isrc')->nullable();
    $table->string('song_title')->nullable();
    $table->decimal('earnings', 10, 2)->default(0);
    $table->string('platform')->nullable(); // e.g. Spotify, Apple Music
    $table->timestamps();

    $table->foreign('artist_submission_id')->references('id')->on('artist_submissions')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('royalties');
    }
};
