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
        Schema::create('scenarios', function (Blueprint $table) {
            $table->id();
            
            // FK
            $table->unsignedBigInteger('desa_trainer_id')->nullable();
            
            $table->string('title'); 
            $table->text('description')->nullable();
            $table->timestamps();

            // Restricciones FK
            $table->foreign('desa_trainer_id')->references('id')->on('desa_trainers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scenarios');
    }
};
