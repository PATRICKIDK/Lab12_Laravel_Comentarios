@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">📚 Publicaciones</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">➕ Nueva publicación</a>
    </div>

    @foreach($posts as $post)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h4 class="card-title">{{ $post->title }}</h4>
                <p class="card-text text-muted">{{ Str::limit($post->content, 100) }}</p>
                <p><small>✍️ Autor: {{ $post->user->name }}</small></p>

                <a href="{{ route('posts.show', $post) }}" class="btn btn-info btn-sm">Ver</a>

                @if($post->user_id === Auth::id())
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar publicación?')">Eliminar</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
