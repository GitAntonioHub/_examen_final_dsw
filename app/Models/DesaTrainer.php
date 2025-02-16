<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesaTrainer extends Model
{
    use HasFactory;

    // Tabla
    protected $table = 'desa_trainers';

    // Campos a rellenar
    protected $fillable = [
        'name',
        'model',
        'description',
        'image',
        'settings',
    ];

    public function buttons()
    {
        // Fíjate en que se llama 'desa_buttons' y la FK 'desa_trainer_id'
        return $this->hasMany(\App\Models\DesaButton::class, 'desa_trainer_id');
    }
    
}
