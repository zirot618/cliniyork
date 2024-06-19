<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'paciente_id',
        'fechaInicio',
        'fechaFin',
        'antecedentes_medicos',
        'historial_medicamentos',
    ];

    protected $casts = [
        'fechaInicio' => 'date',
        'fechaFin' => 'date',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
