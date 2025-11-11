<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Campos que pueden asignarse masivamente
     */
    protected $fillable = [
        'content',
        'user_id',
        'post_id',
    ];

    /**
     * Relación: un comentario pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: un comentario pertenece a un post
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
