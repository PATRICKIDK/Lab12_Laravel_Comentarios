@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">✏️ Editar publicación</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
        </div>

        <div class="text-center">
            <button class="btn btn-primary px-4">Actualizar</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary px-4">Volver</a>
        </div>
    </form>
</div>
@endsection
