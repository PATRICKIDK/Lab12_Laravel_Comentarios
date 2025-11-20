@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar actividad</h2>

    <form method="POST" action="{{ route('notas.actividades.update', [$nota->id, $actividad->id]) }}">
        @csrf
        @method('PUT')

        <label>Descripción</label>
        <input class="form-control" type="text" name="descripcion" value="{{ $actividad->descripcion }}">

        <label>Estado</label>
        <select class="form-control" name="estado">
            <option value="pendiente" {{ $actividad->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="completado" {{ $actividad->estado == 'completado' ? 'selected' : '' }}>Completado</option>
        </select>

        <button class="btn btn-primary mt-3">Guardar</button>
    </form>
</div>
@endsection
