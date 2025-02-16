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
        Schema::create('desa_buttons', function (Blueprint $table) {
            $table->id();

            // FK
            $table->unsignedBigInteger('desa_trainer_id');
            
            $table->string('label');
            $table->text('area');
            $table->string('color');
            $table->boolean('is_blinking');
            $table->timestamps();

            // Restricción FK
            $table->foreign('desa_trainer_id')->references('id')->on('desa_trainers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desa_buttons');
    }
};
