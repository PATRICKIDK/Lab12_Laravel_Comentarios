<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notas';

    protected $fillable = [
        'user_id',
        'titulo',
        'contenido',
    ];

    /**
     * 🔎 Alcance global: solo notas con recordatorio activo y no completado
     * ⚠ Importante: no aplica cuando hacemos búsquedas específicas (edit, update, delete)
     */
    protected static function booted()
    {
        static::addGlobalScope('activa', function (Builder $builder) {
            $builder->whereHas('recordatorio', function ($q) {
                $q->where('fecha_vencimiento', '>=', now())
                  ->where('completado', false);
            });
        });
    }

    /**
     * 🧠 Atributo virtual para mostrar el título formateado
     */
    public function getTituloFormateadoAttribute()
    {
        if ($this->recordatorio && $this->recordatorio->completado) {
            return "[Completado] {$this->titulo}";
        }
        return $this->titulo;
    }

    /**
     * 👤 Relación: una nota pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ⏰ Relación: una nota tiene un recordatorio
     */
    public function recordatorio()
    {
        return $this->hasOne(Recordatorio::class);
    }

    /**
     * 📝 Relación: una nota tiene muchas actividades (1 → ∞)
     */
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'nota_id');
    }

    /**
     * 🔢 Cantidad de actividades pendientes (opcional para mostrar en UI)
     */
    public function getPendientesCountAttribute()
    {
        return $this->actividades()->where('estado', 'pendiente')->count();
    }
}
