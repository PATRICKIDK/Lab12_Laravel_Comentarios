@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">➕ Crear Actividad</h2>

    <div class="card mb-4 p-3">
        <strong>Nota:</strong> {{ $nota->titulo }} <br>
        <strong>Contenido:</strong> {{ $nota->contenido }}
    </div>

    <div class="card shadow-sm p-4">

        <form method="POST" action="{{ route('notas.actividades.store', $nota->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" name="descripcion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="pendiente">Pendiente</option>
                    <option value="en_progreso">En Progreso</option>
                    <option value="completo">Completo</option>
                </select>
            </div>

            <button class="btn btn-primary w-100">Guardar Actividad</button>
        </form>

    </div>

</div>
@endsection
