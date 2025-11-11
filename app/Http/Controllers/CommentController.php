<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        // Asegura que solo usuarios autenticados puedan usar este controlador
        $this->middleware('auth');
    }

    /**
     * Guarda un nuevo comentario en una publicación.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'post_id' => $validated['post_id'],
        ]);

        return back()->with('success', '💬 Comentario agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un comentario.
     */
    public function edit(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado para editar este comentario.');
        }

        return view('comments.edit', compact('comment'));
    }

    /**
     * Actualiza un comentario existente.
     */
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado para modificar este comentario.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update(['content' => $validated['content']]);

        return redirect()
            ->route('posts.show', $comment->post_id)
            ->with('success', '✏️ Comentario actualizado correctamente.');
    }

    /**
     * Elimina un comentario si pertenece al usuario autenticado.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado para eliminar este comentario.');
        }

        $comment->delete();

        return back()->with('success', '🗑️ Comentario eliminado correctamente.');
    }
}
