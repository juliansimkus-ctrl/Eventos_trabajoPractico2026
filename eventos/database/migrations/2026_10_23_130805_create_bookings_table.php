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
        
    Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_category_id')->constrained();
    $table->string('client_name');
    $table->string('client_email');
    $table->string('client_phone')->nullable();
    $table->date('estimated_date'); // Fecha del cumpleaños/boda
    $table->integer('estimated_guests')->nullable(); // Cantidad de invitados
    $table->text('ideas_or_details')->nullable(); // "Quiero tonos pastel y luces LED"
    $table->enum('status', ['pending', 'contacted', 'budgeted', 'cancelled'])->default('pending');
    $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
