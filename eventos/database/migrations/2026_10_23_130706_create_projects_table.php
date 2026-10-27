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
        
    Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_category_id')->constrained()->onDelete('cascade');
    $table->string('title'); // Ejemplo: "Boda de Civil - Ana & Luis"
    $table->string('slug')->unique();
    $table->text('description'); // Detalles de la ambientación, flores usadas, estilo.
    $table->string('location')->nullable(); // Salón de eventos, quinta, etc.
    $table->date('event_date')->nullable();
    $table->boolean('is_featured')->default(false); // Para destacar en la home.
    $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
