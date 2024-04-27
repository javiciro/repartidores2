<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facturacione;
use App\Models\Placa;
use Illuminate\Support\Facades\Mail;
use App\Mail\enviarCorreo;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Str;
use App\Models\User;

class ConductoresController extends Controller
{

    public function create()
    {
        $placas = Placa::all();

        $numFactura = 'FACT-' . strtoupper(Str::random(8));

        while (Facturacione::where('num_factura', $numFactura)->exists()) {
            $numFactura = 'FACT-' . strtoupper(Str::random(8));
        }

        $valor = 0;

        return view('entregas.create', compact('numFactura', 'valor', 'placas'));
    }

    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
    
            $query = Facturacione::where('user_id', $user->id);
    
            // Aplicar filtro por fecha
            if ($request->filled('fecha_creacion')) {
                $fechaCreacion = $request->input('fecha_creacion');
                $query->whereDate('created_at', $fechaCreacion);
            }
    
            // Aplicar filtro por estado
            if ($request->filled('estado')) {
                // Si el estado es diferente de "Todos", aplicar filtro
                if ($request->input('estado') !== 'todos') {
                    $query->where('estado', $request->input('estado'));
                }
            }
    
            // Aplicar filtro general del cliente
            if ($request->filled('cliente_filtro')) {
                $clienteFiltro = '%' . $request->input('cliente_filtro') . '%';
                $query->where(function ($query) use ($clienteFiltro) {
                    $query->where('cliente_nombre', 'like', $clienteFiltro)
                        ->orWhere('observacion', 'like', $clienteFiltro)
                        ->orWhere('correo_cliente', 'like', $clienteFiltro)
                        ->orWhere('direccion_cliente', 'like', $clienteFiltro)
                        ->orWhere('telefono_cliente', 'like', $clienteFiltro)
                        ->orWhere('numero_factura', 'like', $clienteFiltro)
                        ->orWhere('num_factura', 'like', $clienteFiltro)
                        ->orWhere('estado', 'like', $clienteFiltro)
                        ->orWhere('num_placa', 'like', $clienteFiltro);
                });
            }
    
            // Otros filtros similares para los demás campos...
    
            $clientes = $query->orderBy('created_at', 'desc')->paginate(7);
    
            // Consulta para obtener informes
            $informesQuery = Facturacione::selectRaw('DATE(created_at) as fecha, SUM(valor) as total')
                ->where('user_id', $user->id);
    
            // Aplicar filtro por fecha en la consulta de informes
            if ($request->filled('fecha_creacion')) {
                $fechaCreacion = $request->input('fecha_creacion');
                $informesQuery->whereDate('created_at', $fechaCreacion);
            }
    
            // Aplicar filtro por estado en la consulta de informes
            if ($request->filled('estado')) {
                // Si el estado es diferente de "Todos", aplicar filtro
                if ($request->input('estado') !== 'todos') {
                    $informesQuery->where('estado', $request->input('estado'));
                }
            }
    
            $informes = $informesQuery->groupBy('fecha')->orderBy('fecha', 'desc')->get();
    
            $totalValor = $informes->sum('total');
    
            return view('conductores', compact('clientes', 'user', 'informes', 'totalValor'));
        } else {
            return redirect()->route('login');
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'num_placa' => 'required',
            'cliente_nombre' => 'required|string|max:255',
            'observacion' => 'nullable|string',
            'correo_cliente' => 'required|email',
            'direccion_cliente' => 'nullable|string',
            'numero_factura' => 'nullable|string',
        ]);

        $user = Auth::user();

        if ($user) {
            $observacion = $request->input('observacion', 'Ninguna');
            $request->merge(['observacion' => $observacion]);

            $request->merge(['valor' => (int)str_replace(['.', ','], '', $request->input('valor'))]);

            $numFactura = 'ORDEN-' . strtoupper(Str::random(8));

            while (Facturacione::where('num_factura', $numFactura)->exists()) {
                $numFactura = 'ORDEN-' . strtoupper(Str::random(8));
            }
           
            $request->merge(['num_factura' => $numFactura, 'user_id' => $user->id]);

            try {
                $cliente = Facturacione::create($request->all());
                $cliente->estado = 'pendiente'; // Asignar el valor 'pendiente' al campo 'estado'
                $cliente->correo_enviado = false;
                $cliente->save();
            
                $pdf = PDF::loadView('entregas.envio-correo', ['cliente' => $cliente]);
                $pdfContent = $pdf->output();
                $pdfPath = storage_path('app/public/') . 'factura.pdf';
                $pdf->save($pdfPath);
            
                Mail::to($cliente->correo_cliente)
                    ->send(new enviarCorreo($cliente, $pdfContent));
            
                \Storage::delete($pdfPath);
                
            
                return redirect()->route('conductores.index')->with('success', 'Cliente creado correctamente y correo enviado.');
            } catch (\Exception $e) {
                return redirect()->route('conductores.create')->with('error', 'Error al crear el cliente: ' . $e->getMessage());
            }
        }
    }

    public function getClientes($userId)
    {
        $clientes = Facturacione::where('user_id', $userId)->get();
        return $clientes;
    }
    public function limpiarFiltros(Request $request)
    {
        // Aquí puedes manejar la lógica para limpiar los filtros, por ejemplo, borrar los datos de sesión.
        // Por ejemplo, si estás usando datos de sesión para almacenar los filtros, podrías hacer algo como esto:
        $request->session()->forget(['fecha_creacion', 'estado', 'cliente_filtro']);

        // Luego redirige de nuevo a la página actual
        return redirect()->back();
    }
    public function crud(Request $request)
    {
        try {
            // Comenzar con una consulta sin filtrar
            $datos = Facturacione::query();
        
            // Aplicar filtros condicionalmente
            if ($request->filled('start_date')) {
                // Incluir registros hasta el final del día
                $datos->whereBetween('created_at', [
                    $request->input('start_date') . ' 00:00:00',
                    $request->input('start_date') . ' 23:59:59'
                ]);
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
        
            // Obtener datos paginados después de aplicar filtros
            $clientes = $datos->orderBy('created_at', 'desc')->paginate(10);
        
            // Obtener todos los usuarios (modificar según la lógica de tu aplicación)
            $users = User::all();
        
            // Pasar datos adicionales a la vista según sea necesario
            return view('crudConductores.crud', compact('clientes', 'users'))
                ->with('success', 'Filtros aplicados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            $cliente = Facturacione::findOrFail($id);
            return view('crudConductores.edit', compact('cliente'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo encontrar el cliente: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'cliente_nombre' => 'required|string|max:255',
                'observacion' => 'nullable|string',
                'valor' => 'nullable|string',
                'correo_cliente' => 'nullable|email',
                'direccion_cliente' => 'nullable|string',
                'telefono_cliente' => 'nullable|string',
                'numero_factura' => 'nullable|string',
                'cc' => 'nullable|string'
            ]);
        
            $cliente = Facturacione::findOrFail($id);
            $cliente->update($request->all());
        
            return redirect()->route('conductores.crud')->with('success', 'Registro actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el registro: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $cliente = Facturacione::findOrFail($id);
            $cliente->delete();
        
            return redirect()->back()->with('success', 'Registro eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }
    
}