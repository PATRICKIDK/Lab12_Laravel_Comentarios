<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaController extends Controller
{
    /**
     * Mostrar listado de notas por usuario
     */
    public function index()
    {
        $users = User::with(['notas', 'notas.recordatorio'])
            ->addSelect([
                'total_notas' => Nota::selectRaw('count(*)')
                    ->whereColumn('user_id', 'users.id')
                    ->whereHas('recordatorio', fn($query) =>
                        $query->where('fecha_vencimiento', '>=', now())
                    )
            ])
            ->get();

        return view('notas.index', compact('users'));
    }

    /**
     * Guardar una nueva nota
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vencimiento' => 'required|date|after:now',
        ]);

        $note = Nota::create([
            'user_id' => $validated['user_id'],
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
        ]);

        $note->recordatorio()->create([
            'fecha_vencimiento' => $validated['fecha_vencimiento'],
        ]);

        return redirect()->route('notas.index')->with('success', 'Nota creada!');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Nota $nota)
    {
        // Validar acceso
        if ($nota->user_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        return view('notas.edit', compact('nota'));
    }

    /**
     * Actualizar una nota existente
     */
    public function update(Request $request, Nota $nota)
    {
        // Validar acceso
        if ($nota->user_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vencimiento' => 'required|date|after:now',
        ]);

        // Actualizar nota
        $nota->update([
            'titulo' => $validated['titulo'],
            'contenido' => $validated['contenido'],
        ]);

        // Actualizar recordatorio
        $nota->recordatorio()->update([
            'fecha_vencimiento' => $validated['fecha_vencimiento'],
        ]);

        return redirect()->route('notas.index')->with('success', 'Nota actualizada!');
    }

    /**
     * Eliminar una nota
     */
    public function destroy(Nota $nota)
    {
        // Validar acceso
        if ($nota->user_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        // Eliminar recordatorio primero (si aplica)
        if ($nota->recordatorio) {
            $nota->recordatorio->delete();
        }

        // Eliminar nota
        $nota->delete();

        return redirect()->route('notas.index')->with('success', 'Nota eliminada correctamente!');
    }
}
