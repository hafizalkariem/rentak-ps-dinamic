<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->enum('console_type', ['ps3', 'ps4', 'ps5']);
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->integer('max_players')->default(1);
            $table->string('estimated_duration')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_new')->default(false);
            $table->date('release_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};