@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="fw-bold mb-4">Editar Nota</h2>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('notas.update', $nota->id) }}">
        @csrf
        @method('PUT')

        {{-- TÍTULO --}}
        <label class="form-label">Título</label>
        <input type="text"
               name="titulo"
               class="form-control mb-3"
               value="{{ old('titulo', $nota->titulo) }}"
               required>

        {{-- CONTENIDO --}}
        <label class="form-label">Contenido</label>
        <textarea name="contenido"
                  class="form-control mb-4"
                  rows="3"
                  required>{{ old('contenido', $nota->contenido) }}</textarea>

        {{-- FECHA DE VENCIMIENTO --}}
        @php
            // Convertir la fecha a formato compatible con datetime-local
            $fecha = $nota->recordatorio && $nota->recordatorio->fecha_vencimiento
                ? \Carbon\Carbon::parse($nota->recordatorio->fecha_vencimiento)->format('Y-m-d\TH:i')
                : '';
        @endphp

        <label class="form-label">Fecha de Vencimiento</label>
        <input type="datetime-local"
               name="fecha_vencimiento"
               class="form-control mb-4"
               value="{{ old('fecha_vencimiento', $fecha) }}"
               required>

        {{-- BOTÓN --}}
        <button type="submit" class="btn btn-primary w-100 mt-3">
            Actualizar Nota
        </button>

    </form>

</div>
@endsection
