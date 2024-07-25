<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicamentosRecetados extends Model
{
    use HasFactory;
    protected $table = 'medicamento_recetado';
    
    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento');
    }
}
