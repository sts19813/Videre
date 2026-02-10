<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class ProviderDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Seguridad: solo proveedores
        if (!$user->provider) {
            abort(403, 'No autorizado');
        }

        $providerId = $user->provider->id;

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

        // Listado
        $patients = Patient::where('provider_id', $providerId)
            ->latest()
            ->get();

        return view('provider.dashboard', compact('stats', 'patients'));
    }

}
