<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">

    <h1 class="text-center mb-4">📌 Actividades de la Nota</h1>

    {{-- Info de la nota --}}
    <div class="alert alert-info">
        <strong>Nota:</strong> {{ $nota->titulo }} <br>
        <strong>Contenido:</strong> {{ $nota->contenido }}
    </div>

    {{-- Botón crear actividad --}}
    <a href="{{ route('notas.actividades.create', $nota->id) }}" class="btn btn-primary mb-3">
        ➕ Nueva Actividad
    </a>

    {{-- Lista de actividades --}}
    <div class="card shadow-sm">
        <div class="card-body">

            @if($actividades->count())
                @foreach($actividades as $actividad)
                    <div class="border rounded p-3 mb-3 bg-white">

                        <h5 class="fw-semibold">{{ $actividad->descripcion }}</h5>

                        <p class="text-muted">
                            Estado: <strong>{{ $actividad->estado }}</strong>
                        </p>

                        @if($actividad->fecha_inicio)
                            <p class="text-muted">
                                🕒 Inicio: {{ $actividad->fecha_inicio }}
                            </p>
                        @endif

                        @if($actividad->fecha_fin)
                            <p class="text-muted">
                                🏁 Fin: {{ $actividad->fecha_fin }}
                            </p>
                        @endif

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('notas.actividades.edit', [$nota->id, $actividad->id]) }}"
                               class="btn btn-warning btn-sm">✏️ Editar</a>

                            <form method="POST"
                                  action="{{ route('notas.actividades.destroy', [$nota->id, $actividad->id]) }}"
                                  onsubmit="return confirm('¿Eliminar actividad?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑️ Eliminar</button>
                            </form>
                        </div>

                    </div>
                @endforeach
            @else
                <p class="text-muted text-center">No hay actividades registradas.</p>
            @endif

        </div>
    </div>

</div>

</body>
</html>
