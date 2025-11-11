<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes and Reminders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container">
    <h1 class="text-center mb-4">🗒️ Notes and Reminders</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulario para crear nota --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold bg-primary text-white">
            Formulario para Crear Nota
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('notas.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Seleccionar Usuario</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Título Nota</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej. Estudiar Laravel" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenido</label>
                    <textarea name="contenido" class="form-control" rows="3" placeholder="Describe la nota..." required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Vencimiento</label>
                        <input type="datetime-local" name="fecha_vencimiento" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Añadir Nota</button>
            </form>
        </div>
    </div>

    {{-- Listado de usuarios --}}
    @foreach($users as $user)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                Usuario: {{ $user->name }}
                <span class="badge bg-info float-end">{{ $user->total_notas }} Active Notes</span>
            </div>
            <div class="card-body">
                @if($user->notas->count() > 0)
                    @foreach($user->notas as $nota)
                        <div class="mb-3 border rounded p-3">
                            <h5 class="fw-semibold">{{ $nota->titulo_formateado }}</h5>
                            <p>{{ $nota->contenido }}</p>
                            <span class="badge {{ $nota->recordatorio->completado ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $nota->recordatorio->completado ? 'Completed' : 'Pending' }}
                            </span>
                            <small class="d-block text-muted mt-1">
                                📅 Due: {{ \Carbon\Carbon::parse($nota->recordatorio->fecha_vencimiento)->format('Y-m-d H:i') }}
                            </small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No hay notas activas para este usuario.</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
</body>
</html>
