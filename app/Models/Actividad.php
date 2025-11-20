<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades'; // 👈 SOLUCIÓN

    protected $fillable = [
        'nota_id',
        'descripcion',
        'estado',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }
}
