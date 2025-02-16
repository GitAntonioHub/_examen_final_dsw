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
        Schema::create('instructions', function (Blueprint $table)
        {
            $table->id();

            // FK
            $table->unsignedBigInteger('scenario_id');
            
            $table->string('title');
            $table->text('content');
            $table->string('audio_file')->nullable();
            $table->timestamps();

            // Restricción FK
            $table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructions');
    }
};