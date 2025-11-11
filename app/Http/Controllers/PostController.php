<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Middleware para requerir autenticación en todas las rutas
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar todas las publicaciones
     */
    public function index()
    {
        // Cargar todas las publicaciones junto con los datos del usuario creador
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Mostrar el formulario de creación
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Guardar una nueva publicación
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Crear el nuevo post con el ID del usuario logueado
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('posts.index')->with('success', 'Publicación creada exitosamente.');
    }

    /**
     * Mostrar una publicación específica
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Post $post)
    {
        // Solo el dueño puede editar su publicación
        if ($post->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta publicación.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Actualizar la publicación
     */
    public function update(Request $request, Post $post)
    {
        // Validar datos
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Verificar propietario
        if ($post->user_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        // Actualizar datos
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Publicación actualizada correctamente.');
    }

    /**
     * Eliminar publicación
     */
    public function destroy(Post $post)
    {
        // Solo el dueño puede eliminar su publicación
        if ($post->user_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Publicación eliminada exitosamente.');
    }
}
