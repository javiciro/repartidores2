<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Facturacione;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class TesoreriaController extends Controller
{
    public function index(Request $request)
    {
        // Start with an unfiltered query for all registros
        $datos = Facturacione::query();
        
        // Apply filters conditionally
        if ($request->filled('start_date')) {
            // Include records up to the end of the day
            $datos->where('created_at', '>=', $request->input('start_date') . ' 00:00:00')
                ->where('created_at', '<=', $request->input('start_date') . ' 23:59:59');
        }
        
        if ($request->filled('user_id')) {
            $datos->where('user_id', $request->input('user_id'));
        }
        
        if ($request->filled('estado')) {
            // Si el estado es diferente de "Todos", aplicar filtro
            if ($request->input('estado') !== 'todos') {
                $datos->where('estado', $request->input('estado'));
            }
        }
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $datos->where(function ($query) use ($search) {
                $query->where('cliente_nombre', 'like', "%$search%")
                    ->orWhere('observacion', 'like', "%$search%")
                    ->orWhere('numero_factura', 'like', "%$search%")
                    ->orWhere('estado', 'like', "%$search%");
            });
        }
        
        // Sum of Values for filtered registros
        $sumaValores = $datos->sum('valor');
    
        // Order by created_at in descending order to get the latest records first
        $datos->orderBy('created_at', 'desc');
        
        // Get paginated data after applying filters
        $datos = $datos->paginate(7);
        
        // Get all users (modify this based on your application logic)
        $users = User::all(); // Change this to fit your user retrieval logic
        
        // Pass the $users variable to the view along with $sumaValores
        return view('tesoreria', compact('datos', 'sumaValores', 'users'));
    }
    

    public function editarEstado(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'estado' => 'required|in:pendiente,entregado',
        ]);

        try {
            // Find the record by ID
            $dato = Facturacione::findOrFail($id);

            // Update the 'estado' field
            $dato->estado = $request->estado;
            $dato->save();

            return redirect()->back()->with('success', 'Estado actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al editar el estado: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al editar el estado.');
        }
    }
}
