@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>✏️ Editar comentario</h4>
            <p class="text-muted">Modifica tu comentario y guarda los cambios.</p>

            <!-- Mensaje de éxito si existe -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Formulario de edición -->
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">Contenido</label>
                    <textarea name="content" id="content" class="form-control" rows="4" required>{{ $comment->content }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">💾 Guardar cambios</button>
                <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-secondary">⬅️ Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
