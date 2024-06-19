<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'medico';
    protected $fillable = ['user_id', 'especialidad'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad');
    }
}
