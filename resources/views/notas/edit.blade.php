@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Notes and Reminders</h2>
        <a href="{{ route('notas.create') }}" class="btn btn-primary">
            + Crear Nota
        </a>
    </div>

    {{-- Si NO hay notas --}}
    @if($notas->isEmpty())
        <div class="alert alert-info text-center">
            No hay notas registradas aún.
        </div>
    @else

        @foreach ($notas as $nota)
            <div class="card mb-3 shadow-sm">

                <div class="card-body">
                    <h4 class="card-title fw-bold">{{ $nota->titulo }}</h4>

                    <p class="text-muted">
                        {{ $nota->contenido }}
                    </p>

                    {{-- Estado --}}
                    @if($nota->estado == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-success">Completed</span>
                    @endif

                    <br><br>

                    {{-- Fecha --}}
                    <p class="mb-1">
                        <i class="bi bi-calendar-event"></i>
                        <strong>Vence:</strong> {{ $nota->fecha_vencimiento }}
                    </p>

                    {{-- Acciones --}}
                    <div class="mt-3 d-flex gap-2">

                        <a href="{{ route('notas.edit', $nota->id) }}" class="btn btn-sm btn-info text-white">
                            ✏ Editar
                        </a>

                        <form action="{{ route('notas.destroy', $nota->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta nota?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑 Eliminar</button>
                        </form>

                    </div>

                </div>
            </div>
        @endforeach

    @endif

</div>
@endsection
