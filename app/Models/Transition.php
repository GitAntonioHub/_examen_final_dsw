<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    use HasFactory;

    // Tabla
    protected $table = 'transitions';

    // Campos a rellenar
    protected $fillable = [
        'from_instruction_id',
        'to_instruction_id',
        'trigger',
        'time_seconds', // opcional (si el trigger es time)
        'desa_button_id', // opcional (si el trigger es user_choice)
        'loop_count', // opcional (si el trigger es loop)
    ];

    // Relación belongsTo con Instruction
    public function instruction() {
        return $this -> belongsTo(Instruction::class);
    }

    public function fromInstruction() {
        return $this -> belongsTo(Instruction::class, 'from_instruction_id');
    }

    public function toInstruction() {
        return $this -> belongsTo(Instruction::class, 'to_instruction_id');
    }

    // Relación belongsTo con desa_buttons
    public function desa_button() {
        return $this -> belongsTo(DesaButton::class);
    }
}
