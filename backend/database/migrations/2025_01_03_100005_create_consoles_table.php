<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consoles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['ps3', 'ps4', 'ps5']);
            $table->integer('hourly_rate');
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->json('specifications')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consoles');
    }
};