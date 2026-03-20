<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Provider;
use App\Models\Patient;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'providers' => Provider::count(),

            // NUEVOS KPIs
            'pending' => Patient::where('status', 'pendiente')->count(),

            'scheduled' => Patient::where('status', 'cita_agendada')->count(),

            'counter_ref' => Patient::where('status', 'contrarreferencia')->count(),

            // ATENDIDOS = todos los que ya pasaron por consulta real
            'attended' => Patient::whereIn('status', [
                'en_consulta',
                'propuesta_cirugia',
                'propuesta_tratamiento',
                'estudios_complementarios',
                'en_seguimiento'
            ])->count(),
        ];

        $patients = Patient::with('provider.user')
            ->orderBy('updated_at', 'desc')
            ->get();

        $providers = Provider::with('user')->get();

        $users = User::where('role', 'admin')->get();

        return view('admin.dashboard', compact(
            'stats',
            'patients',
            'providers',
            'users'
        ));
    }
}
