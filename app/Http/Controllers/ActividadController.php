<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /** 
     * Mostrar actividades de una nota 
     */
    public function index(Nota $nota)
    {
        $actividades = $nota->actividades;
        return view('actividades.index', compact('nota', 'actividades'));
    }

    /**
     * Formulario crear actividad
     */
    public function create(Nota $nota)
    {
        return view('actividades.create', compact('nota'));
    }

    /**
     * Guardar actividad
     */
    public function store(Request $request, Nota $nota)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $nota->actividades()->create($request->all());

        return redirect()
            ->route('notas.actividades.index', $nota->id)
            ->with('success', 'Actividad creada correctamente');
    }

    /**
     * Formulario editar actividad
     */
    public function edit(Nota $nota, Actividad $actividad)
    {
        return view('actividades.edit', compact('nota', 'actividad'));
    }

    /**
     * Actualizar actividad
     */
    public function update(Request $request, Nota $nota, Actividad $actividad)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        $actividad->update($request->all());

        return redirect()
            ->route('notas.actividades.index', $nota->id)
            ->with('success', 'Actividad actualizada');
    }

    /**
     * Eliminar actividad
     */
    public function destroy(Nota $nota, Actividad $actividad)
    {
        $actividad->delete();

        return redirect()
            ->route('notas.actividades.index', $nota->id)
            ->with('success', 'Actividad eliminada');
    }
}
