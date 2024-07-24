<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Medicamento extends Model
{
    use HasFactory;
    protected $table = 'medicamentos';
    protected $fillable = [
        'codigo',
        'descripcion',
        'precio',
        'existencia',
        'fecha_caducidad',
        'estado',
    ];
    public function setFechaCaducidadAttribute($value)
    {
        $this->attributes['fecha_caducidad'] = $value;
        $this->attributes['estado'] = Carbon::parse($value)->isPast() ? false : true;
    }
}
