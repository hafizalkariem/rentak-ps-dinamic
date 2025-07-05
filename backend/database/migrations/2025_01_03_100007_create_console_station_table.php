<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('console_station', function (Blueprint $table) {
            $table->id();
            $table->foreignId('console_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['console_id', 'station_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('console_station');
    }
};