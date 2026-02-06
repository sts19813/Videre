<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class ProviderPatientController extends Controller
{
    /**
     * Mostrar formulario de alta
     */
    public function create()
    {
        return view('provider.patients.create');
    }

    /**
     * Guardar paciente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'observations' => 'nullable|string',
            // Referente
            'referrer' => 'required|in:optometrista,oftalmologo,medico_general,otro',

            // Tipo de referido
            'referral_type' => 'required|in:consulta_general,cirugia_refractiva,catarata_cristalino,retina',

            // Seguro
            'insurance' => 'nullable|in:axxa,allianz,gnp,metlife,atlas,inbursa,sura,ve_por_mas,seguros_monterrey,seguros_banorte,mapfre,zurich,otro',
            'policy_date' => 'nullable|date',

            // Información clínica dinámica
            'clinical_data' => 'nullable|array',

            // Observaciones generales
        ]);



        Patient::create([
            'provider_id' => auth()->user()->provider->id ?? 1, // temporal
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'observations' => $validated['observations'],
            'status' => 'pendiente',
            'referrer' => $validated['referrer'],
            'referral_type' => $validated['referral_type'],
            'insurance' => $validated['insurance'],
            'policy_date' => $validated['policy_date'],
            'clinical_data' => $validated['clinical_data'] ?? [],
        ]);

        return redirect()
            ->route('provider.dashboard')
            ->with('success', 'Paciente agregado correctamente');
    }
}
