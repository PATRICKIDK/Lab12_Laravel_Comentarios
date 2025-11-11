<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notas'; // ✅ explícito por si la tabla no sigue convención en migración

    protected $fillable = [
        'user_id',
        'titulo',
        'contenido',
    ];

    /**
     * 🔎 Alcance global: solo notas con recordatorio activo y no completado
     */
    protected static function booted()
    {
        static::addGlobalScope('activa', function (Builder $builder) {
            $builder->whereHas('recordatorio', function ($query) {
                $query->where('fecha_vencimiento', '>=', now())
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
}
