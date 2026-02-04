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
        /**
         * ⚠️ SIN AUTH:
         * Provider fijo temporal
         * Luego se reemplaza por auth()->user()->provider->id
         */
        $providerId = 1;

        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'observations' => 'nullable|string',
        ]);

        Patient::create([
            'provider_id'  => $providerId,
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'phone'        => $validated['phone'],
            'email'        => $validated['email'] ?? null,
            'observations' => $validated['observations'] ?? null,
            'status'       => 'pendiente',
        ]);

        return redirect()
            ->route('provider.dashboard')
            ->with('success', 'Paciente agregado correctamente');
    }
}
