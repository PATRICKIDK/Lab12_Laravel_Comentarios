@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">📝 Crear nueva publicación</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Ej: Mi primera publicación" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea name="content" id="content" class="form-control" rows="5" placeholder="Escribe aquí tu contenido..." required></textarea>
        </div>

        <div class="text-center">
            <button class="btn btn-success px-4">Guardar</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary px-4">Cancelar</a>
        </div>
    </form>
</div>
@endsection
