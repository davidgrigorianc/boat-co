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
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boat_id')->constrained()->onDelete('cascade');
            $table->string('make');
            $table->string('model');
            $table->string('type');
            $table->integer('hours');
            $table->integer('power');
            $table->string('fuel_type')->nullable();
            $table->string('drive_type')->nullable();
            $table->timestamps();

            $table->index('boat_id');
            $table->index('make');
            $table->index('model');
            $table->index('type');
            $table->index('hours');
            $table->index('power');
            $table->index('fuel_type');
            $table->index('drive_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
