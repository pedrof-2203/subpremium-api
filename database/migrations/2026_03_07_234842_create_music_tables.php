<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Bands
        Schema::create('bands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->jsonb('genres')->nullable();
            $table->date('formed_at');
            $table->date('disbanded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Artists
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->date('birthday');
            // Fixed: Foreign key must reference a table and define the column
            $table->foreignId('band_id')->nullable()->constrained()->nullOnDelete();
            $table->jsonb('genres')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('band_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable(); // Changed to text for longer content
            $table->jsonb('genres')->nullable();
            $table->date('release_date');
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Songs
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('band_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable(); 
            $table->jsonb('genres')->nullable();
            $table->date('release_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order to avoid foreign key constraint violations
        Schema::dropIfExists('songs');
        Schema::dropIfExists('albums');
        Schema::dropIfExists('artists');
        Schema::dropIfExists('bands');
    }
};