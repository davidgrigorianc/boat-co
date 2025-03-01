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
        Schema::create('boat_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boat_id')->constrained();
            $table->boolean('is_primary');
            $table->string('path');
            $table->timestamps();
            $table->index('boat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boat_images');
    }
};
