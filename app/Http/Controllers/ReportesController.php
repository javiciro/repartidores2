<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facturacione;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    private $conductoresController;

    public function __construct(ConductoresController $conductoresController)
    {
        $this->middleware('auth');
        $this->conductoresController = $conductoresController;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $dateFilter = $request->input('date_filter');
        $clientes = $this->conductoresController->getClientes($user->id);

        $informes = $this->getInformes($user->id, $dateFilter);
        $totalValor = $informes->sum('total');

        // Datos para gráfico diario
        $dailyChartData = $this->getChartData($user->id, 'day', 'rgba(75, 192, 192, 0.7)');

        // Datos para gráfico semanal
        $weeklyChartData = $this->getChartData($user->id, 'week', 'rgba(255, 99, 132, 0.7)');

        // Datos para gráfico mensual
        $monthlyChartData = $this->getChartData($user->id, 'month', 'rgba(54, 162, 235, 0.7)');

        // Datos para gráfico anual
        $yearlyChartData = $this->getChartData($user->id, 'year', 'rgba(255, 206, 86, 0.7)');

        return view('reportes', compact('informes', 'totalValor', 'clientes', 'dailyChartData', 'weeklyChartData', 'monthlyChartData', 'yearlyChartData'));
    }

    private function getInformes($userId, $dateFilter)
    {
        $query = Facturacione::where('user_id', $userId);
    
        if ($dateFilter) {
            // Asegúrate de que solo se incluyan los informes del mes actual
            $query->whereMonth('created_at', now()->month);
            $query->whereYear('created_at', now()->year);
        }
    
        return $query->selectRaw('DATE(created_at) as fecha, SUM(valor) as total, MIN(created_at) as created_at')
            ->groupBy('fecha') // Solo agrupar por fecha
            ->orderBy('fecha', 'asc') // Ordenar por fecha ascendente
            ->paginate(7);
    }
    
    private function getChartData($userId, $interval, $color)
    {
        $query = Facturacione::where('user_id', $userId);
    
        switch ($interval) {
            case 'day':
                // Asegúrate de que solo se incluyan los registros de los últimos 7 días
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, SUM(valor) as total");
                $query->groupBy(\DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'));
                $query->orderBy('date', 'asc');
                break;
            
            case 'week':
                // Asegúrate de que solo se incluyan las semanas del mes actual
                $query->whereMonth('created_at', now()->month);
                $query->whereYear('created_at', now()->year);
            
                $query->selectRaw("CONCAT(YEAR(created_at), ' - Semana ', WEEK(created_at)) as date, SUM(valor) as total");
                $query->groupBy(\DB::raw('YEAR(created_at), WEEK(created_at), CONCAT(YEAR(created_at), " - Semana ", WEEK(created_at))'));
                break;
            case 'month':
                    // Asegúrate de que solo se incluyan los meses del año actual
                $query->whereYear('created_at', now()->year);
            
                $query->selectRaw("DATE_FORMAT(MIN(created_at), '%M %Y') as date, SUM(valor) as total");
                $query->groupBy(\DB::raw('DATE_FORMAT(created_at, "%Y-%m")'));
                break;
                
            case 'year':
                $query->selectRaw("DATE_FORMAT(MIN(created_at), '%Y') as date, SUM(valor) as total");
                $query->groupBy(\DB::raw('DATE_FORMAT(created_at, "%Y")'));
                break;
        }
    
        $query->orderBy('date', 'asc');
    
        $data = $query->get();
        $labels = $data->pluck('date');
        $values = $data->pluck('total');
    
       // Agregar el color al arreglo de datos
        $chartData = [
            'labels' => $labels,
            'values' => $values,
            'color' => $color,
        ];
    
        return $chartData;
    }
}
