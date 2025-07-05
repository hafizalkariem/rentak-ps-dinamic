<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('event_type', ['tournament', 'casual', 'special'])->default('casual');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_participants')->nullable();
            $table->integer('entry_fee')->default(0);
            $table->integer('prize_pool')->default(0);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->string('image_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};