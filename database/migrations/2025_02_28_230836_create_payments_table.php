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
            $table->unsignedBigInteger('boat_id');
            $table->string('transaction_id')->nullable()->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_provider')->default('stripe');
            $table->timestamps();

            $table->foreign('boat_id')->references('id')->on('boats')->onDelete('cascade');
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
