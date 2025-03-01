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
        Schema::create('boats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boat_model_id')->constrained();
            $table->foreignId('location_id')->constrained();
            $table->boolean('is_new')->nullable();
            $table->text('description');
            $table->enum('boat_type', ['sailing', 'motor']);
            $table->integer('engine_number');
            $table->unsignedBigInteger('price');
            $table->integer('year');
            $table->decimal('length', 8, 2);
            $table->enum('status', ['available', 'sold', 'pending'])->default('available')->index();

            $table->timestamps();

            $table->index('boat_type');
            $table->index('boat_model_id');
            $table->index('location_id');
            $table->index('is_new');
            $table->index('length');
            $table->index('year');
            $table->index('price');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boats');
    }
};
