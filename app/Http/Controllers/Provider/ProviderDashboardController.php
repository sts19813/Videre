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

        // Seguridad: solo afilieados
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
                ->whereIn('status', ['cita_agendada', 'reagendada'])
                ->count(),

            'attended' => Patient::where('provider_id', $providerId)
                ->whereIn('status', [
                    'en_consulta',
                    'propuesta_cirugia',
                    'propuesta_tratamiento',
                    'estudios_complementarios',
                    'en_seguimiento'
                ])
                ->count(),
        ];

        // Listado
        $patients = Patient::where('provider_id', $providerId)
            ->latest()
            ->get();

        return view('provider.dashboard', compact('stats', 'patients'));
    }

}
