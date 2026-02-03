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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            // owner_id pointe vers la table users
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('city');
            $table->string('cuisine_type');
            $table->integer('capacity');
            $table->json('opening_hours')->nullable(); // Important pour vos User Stories
            $table->text('description')->nullable();
            $table->softDeletes(); // Ajout pour votre diagramme
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
