<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctores';
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'id_especialidad',
        'cedula',
        'telefono',
    ];
}
