<?php

// database/migrations/YYYY_MM_DD_XXXXXX_create_plans_table.php

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., 'Free', 'Artist', 'Label'
            $table->string('slug')->unique(); // For URL friendly names, e.g., 'artist-plan'
            $table->decimal('price', 10, 2)->default(0); // Price in Naira
            $table->text('description')->nullable(); // Short description
            $table->integer('max_artists')->nullable(); // Max artists (null for unlimited or 1 for Artist Plan)
            $table->boolean('lyrics_distribution')->default(false);
            $table->boolean('music_video_distribution')->default(false);
            $table->boolean('royalty_splits_supported')->default(false);
            $table->integer('distribution_time_days')->nullable(); // e.g., 7 or 1-2 (will store as int days)
            $table->text('features')->nullable(); // JSON or text list of other features
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};