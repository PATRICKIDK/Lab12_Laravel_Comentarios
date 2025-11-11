<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
<div class="container">
    <h1 class="text-center mb-4">📝 Nueva Nota</h1>
    <form method="POST" action="{{ route('notas.store') }}">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario ID</label>
            <input type="number" class="form-control" id="user_id" name="user_id" required>
        </div>
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido" required></textarea>
        </div>
        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento</label>
            <input type="datetime-local" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Guardar Nota</button>
    </form>
</div>
</body>
</html>
