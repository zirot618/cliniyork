<?php

namespace App\Http\Controllers;
use App\Models\Cita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $patientsCount = User::where('rol', 'paciente')->count();
        $doctorsCount = User::where('rol', 'medico')->count();
        $adminsCount = User::where('rol', 'administrador')->count();

        $data = [
            'patientsCount' => $patientsCount,
            'doctorsCount' => $doctorsCount,
            'adminsCount' => $adminsCount,
        ];

        return response()->json($data);
    }


    public function index2()
    {
        // Consulta para obtener los motivos de cita más recurrentes
        $motivosCita = Cita::select('motivo', DB::raw('COUNT(*) as total'))
                            ->groupBy('motivo')
                            ->orderByDesc('total')
                            ->limit(5) // Limitar a los 5 motivos más frecuentes
                            ->get();

        // Preparar los datos para el gráfico
        $labels = $motivosCita->pluck('motivo');
        $counts = $motivosCita->pluck('total');

        $data = [
            'labels' => $labels,
            'counts' => $counts,
        ];

        return response()->json($data);
    }

    public function index3()
    {
        $citas = Cita::selectRaw('MONTH(fechaHora) as month, COUNT(*) as count')
            ->whereYear('fechaHora', Carbon::now()->year) // Filtrar por el año actual
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $citasmeses = array_fill(1, 12, 0);

        foreach ($citas as $cita) {
            $citasmeses[$cita->month] = $cita->count;
        }

        return response()->json([
            'labels' => array_keys($citasmeses),
            'data' => array_values($citasmeses)
        ]);
    }


    public function index4()
    {
        $citas = Cita::selectRaw('MONTH(fechaHora) as month, COUNT(*) as count, estado')
                     ->whereYear('fechaHora', Carbon::now()->year)
                     ->groupBy('month', 'estado')
                     ->orderBy('month')
                     ->get();

        // Inicializar un array para almacenar los datos en el formato adecuado para Chart.js
        $datasets = [];

        // Crear un array vacío para contar las citas por estado por cada mes
        $citasPorEstado = [
            'pendiente' => array_fill(1, 12, 0),
            'aprobada' => array_fill(1, 12, 0),
            'finalizada' => array_fill(1, 12, 0),
        ];

        // Llenar el array $citasPorEstado con los datos de la consulta
        foreach ($citas as $cita) {
            $citasPorEstado[$cita->estado][$cita->month] = $cita->count;
        }

        // Preparar los datasets para el gráfico
        foreach ($citasPorEstado as $estado => $data) {
            $datasets[] = [
                'label' => ucfirst($estado), // Convertir la primera letra en mayúscula
                'data' => array_values($data), // Obtener solo los valores de conteo de citas
                'backgroundColor' => $this->getBackgroundColor($estado), // Función para obtener colores de fondo
                'borderColor' => $this->getBorderColor($estado), // Función para obtener colores de borde
            ];
        }

            // Devolver los datos en formato JSON
            return response()->json([
                'labels' => range(1, 12), // Etiquetas para los meses del año
                'datasets' => $datasets,
            ]);
        }

        // Función para obtener colores de fondo según el estado
        private function getBackgroundColor($estado)
        {
            switch ($estado) {
                case 'pendiente':
                    return 'rgba(255, 99, 132, 0.6)';
                case 'aprobada':
                    return 'rgba(54, 162, 235, 0.6)';
                case 'finalizada':
                    return 'rgba(106, 90, 205, 0.6)';
                default:
                    return 'rgba(255, 206, 86, 0.6)';
            }
        }

        // Función para obtener colores de borde según el estado
        private function getBorderColor($estado)
        {
            switch ($estado) {
                case 'pendiente':
                    return 'rgba(255, 99, 132, 1)';
                case 'aprobada':
                    return 'rgba(54, 162, 235, 1)';
                case 'finalizada':
                    return 'rgba(106, 90, 205, 1)';
                default:
                    return 'rgba(255, 206, 86, 1)';
            }
        }
   }
    
?>