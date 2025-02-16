<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transitions', function (Blueprint $table) {
            $table->id(); // ID principal (clave primaria)
            $table->unsignedBigInteger('from_instruction_id'); // FK hacia instructions
            $table->unsignedBigInteger('to_instruction_id');   // FK hacia instructions
            $table->enum('trigger', ['time', 'desaButton', 'loop']); // Tipo de trigger
            $table->integer('time_seconds')->nullable();       // Opcional si el trigger es "time"
            $table->unsignedBigInteger('desa_button_id')->nullable(); // Opcional si el trigger es "user_choice"
            $table->integer('loop_count')->nullable();         // Opcional si el trigger es "loop"
            $table->timestamps(); // Campos created_at y updated_at

            // Claves foráneas
            $table->foreign('from_instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->foreign('to_instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->foreign('desa_button_id')->references('id')->on('desa_buttons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transitions');
    }
};
