<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    use HasFactory;

    // Tabla
    protected $table = 'scenarios';

    // Campos a rellenar
    protected $fillable = [
        'desa_trainer_id',
        'title',
        'description',
        'is_active',
        'is_simulable',
    ];
    public function desaTrainer()
    {
        return $this->belongsTo(DesaTrainer::class, 'desa_trainer_id');
    }

    // Relación hasMany con Instructions (Un escenario -> muchos instrucciones)
    public function instructions() {
        return $this -> hasMany(Instruction::class);
    }

    // Relación belongsTo con desa_trainers
    public function desa_trainer() {
        return $this -> belongsTo(DesaTrainer::class, 'desa_trainer_id');
    }
}
