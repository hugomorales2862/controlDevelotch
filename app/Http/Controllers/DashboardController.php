<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Pago;
use App\Models\Transaccion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clientes' => Cliente::count(),
            'clientes_activos' => Cliente::where('estado', 'activo')->count(),
            'servicios_activos' => Servicio::where('estado', 'activo')->count(),
            'pagos_pendientes' => Pago::where('estado', 'pendiente')->count(),
            'pagos_vencidos' => Pago::where('estado', 'vencido')->count(),
            'ingresos_mes' => Transaccion::where('tipo', 'ingreso')
                ->whereMonth('fecha', now()->month)
                ->sum('monto'),
            'egresos_mes' => Transaccion::where('tipo', 'egreso')
                ->whereMonth('fecha', now()->month)
                ->sum('monto'),
        ];

        return view('dashboard', compact('stats'));
    }
}
