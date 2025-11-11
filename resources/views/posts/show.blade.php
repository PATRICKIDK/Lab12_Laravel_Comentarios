@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
            <p class="text-muted">Autor: {{ $post->user->name }}</p>
        </div>
    </div>

    <hr>
    <h4>💬 Comentarios</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Lista de comentarios -->
    @if($post->comments && $post->comments->count() > 0)
        @foreach($post->comments as $comment)
            <div class="border rounded p-3 mb-3 bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                        <br>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>

                    @if($comment->user_id === Auth::id())
                        <div>
                            <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-warning">
                                ✏️ Editar
                            </a>

                            <form action="{{ route('comments.destroy', $comment) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este comentario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <p class="text-muted">No hay comentarios aún. ¡Sé el primero en comentar!</p>
    @endif

    <hr>

    <!-- Formulario para agregar comentario -->
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="mb-3">
            <label for="content" class="form-label fw-bold">Agregar comentario:</label>
            <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
        </div>
        <button class="btn btn-primary">💬 Publicar comentario</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">⬅️ Volver</a>
    </div>
</div>
@endsection
