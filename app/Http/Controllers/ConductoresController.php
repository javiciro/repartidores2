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
            $informes = $query->selectRaw('DATE(created_at) as fecha, SUM(valor) as total')
            ->groupBy('created_at')
            ->get();
        
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

    // ... (other methods)
}
