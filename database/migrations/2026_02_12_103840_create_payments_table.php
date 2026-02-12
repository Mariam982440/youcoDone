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
        Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reservation_id')->unique()->constrained()->onDelete('cascade');
        $table->decimal('amount', 8, 2);
        $table->string('currency')->default('EUR');
        $table->string('status'); // s_succeded, s_failed
        $table->string('transaction_id')->nullable(); // ID Stripe
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
