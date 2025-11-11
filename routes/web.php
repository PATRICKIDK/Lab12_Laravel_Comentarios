<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

// 🔒 Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Notas (Lab13)
    Route::resource('notas', NotaController::class);

    // Publicaciones (Lab12)
    Route::resource('posts', PostController::class);

    // Comentarios (crear, eliminar, editar y actualizar)
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
});

// 🏠 Ruta de inicio y autenticación
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
