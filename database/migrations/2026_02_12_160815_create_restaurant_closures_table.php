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
        Schema::create('restaurant_closures', function (Blueprint $table) {

            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->date('closed_date');
            $table->string('reason')->nullable(); // Ex: "Travaux", "Congés annuels"
            $table->timestamps();
            
            // Sécurité : Un restaurant ne peut pas avoir deux entrées pour la même date
            $table->unique(['restaurant_id', 'closed_date']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_closures');
    }
};
