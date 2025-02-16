<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;
    
    // Tabla
    protected $table = 'instructions';

    // Campos a rellenar
    protected $fillable = [
        'scenario_id',
        'title',
        'content',
        'audio_file'
    ];

    // Relación belongsTo con Scenario
    public function scenario()
    {
        return $this -> belongsTo(Scenario::class);
    }

    // Relación hasMany con Transition
    public function transitions()
    {
        return $this -> hasMany(Transition::class);
    }
}
