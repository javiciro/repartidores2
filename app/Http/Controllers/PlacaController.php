<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Placa;

class PlacaController extends Controller {
    
    public function index() {
        $placas = Placa::paginate(10);
        return view('agregarPlaca', compact('placas'));
    }

    public function create() {
        return view('agregarPlaca.create');
    }

    public function store(Request $request) {
        // Validation
        $request->validate([
            'placa' => 'required|string|max:10|unique:placas',
        ]);

        // Crear nueva instancia de Placa y guardar los datos
        try {
            Placa::create([
                'placa' => $request->input('placa'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar la placa. Asegúrate de que la placa sea única.');
        }

        return redirect()->back()->with('success', 'Placa guardada exitosamente.');
    }

    public function edit($id) {
        $placa = Placa::find($id);
        return view('agregarPlaca.edit', compact('placa'));
    }

    public function update(Request $request, $id) {
        // Validation
        $request->validate([
            'placa' => 'required|string|max:10|unique:placas,placa,'.$id,
        ]);

        // Actualizar los datos de la Placa
        try {
            $placa = Placa::find($id);
            $placa->update([
                'placa' => $request->input('placa'),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la placa.');
        }

        return redirect()->back()->with('success', 'Placa actualizada exitosamente.');
    }

    public function destroy($id) {
        $placa = Placa::find($id);

        if (!$placa) {
            return redirect()->back()->with('error', 'Placa no encontrada.');
        }

        try {
            $placa->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la placa.');
        }

        return redirect()->back()->with('success', 'Placa eliminada exitosamente.');
    }
}
