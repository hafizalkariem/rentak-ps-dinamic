<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->integer('amount_paid')->default(0);
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
            
            $table->unique(['event_id', 'user_id']); // Prevent duplicate registration
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};