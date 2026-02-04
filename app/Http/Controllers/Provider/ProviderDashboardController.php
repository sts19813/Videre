<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class ProviderDashboardController extends Controller
{
    public function index()
    {
        /**
         * ⚠️ SIN AUTH:
         * Usamos provider_id fijo temporal
         * Cuando implementes auth:
         * $providerId = auth()->user()->provider->id;
         */
        $providerId = 1;

        // Métricas
        $stats = [
            'sent' => Patient::where('provider_id', $providerId)->count(),

            'pending' => Patient::where('provider_id', $providerId)
                ->where('status', 'pendiente')
                ->count(),

            'scheduled' => Patient::where('provider_id', $providerId)
                ->where('status', 'cita_agendada')
                ->count(),

            'attended' => Patient::where('provider_id', $providerId)
                ->where('status', 'atendido')
                ->count(),
        ];

        // Listado de pacientes
        $patients = Patient::where('provider_id', $providerId)
            ->latest()
            ->get();

        return view('provider.dashboard', compact('stats', 'patients'));
    }
}
