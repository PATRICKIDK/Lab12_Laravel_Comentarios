<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\HomeController;

// Página principal
Route::get('/', function () {
    return view('welcome');
});

// Autenticación (login / registro)
Auth::routes();

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    /** -------------------------
     *   CRUD NOTAS
     * ------------------------- */
    Route::resource('notas', NotaController::class)->names('notas');

    /** -------------------------
     *   CRUD POSTS
     * ------------------------- */
    Route::resource('posts', PostController::class)->names('posts');

    /** -------------------------
     *   CRUD COMENTARIOS
     * ------------------------- */
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    /** -------------------------
     *   CRUD ACTIVIDADES (LAB 14)
     * ------------------------- */
    Route::prefix('notas/{nota}')->group(function () {

        // 👉 Ver actividades de una nota
        Route::get('/actividades', [ActividadController::class, 'index'])
            ->name('notas.actividades.index');

        // 👉 Formulario para crear actividad
        Route::get('/actividades/create', [ActividadController::class, 'create'])
            ->name('notas.actividades.create');

        // 👉 Guardar actividad
        Route::post('/actividades', [ActividadController::class, 'store'])
            ->name('notas.actividades.store');

        // 👉 Editar actividad
        Route::get('/actividades/{actividad}/edit', [ActividadController::class, 'edit'])
            ->name('notas.actividades.edit');

        // 👉 Actualizar actividad
        Route::put('/actividades/{actividad}', [ActividadController::class, 'update'])
            ->name('notas.actividades.update');

        // 👉 Eliminar actividad
        Route::delete('/actividades/{actividad}', [ActividadController::class, 'destroy'])
            ->name('notas.actividades.destroy');
    });

});

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');
