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
    public function edit(Patient $patient)
    {
        // seguridad: que solo pueda editar sus pacientes
        if ($patient->provider_id !== auth()->user()->provider->id) {
            abort(403);
        }

        return response()->json($patient->load('files'));
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

        return response()->json([
            'success' => true,
            'message' => 'Paciente agregado correctamente'
        ]);
    }

    public function show(Patient $patient)
    {
        // Seguridad: validar que el paciente pertenece al provider
        if ($patient->provider_id !== auth()->user()->provider->id) {
            abort(403);
        }

        $patient->load([
            'provider.user'
        ]);

        return view('admin.patients.show', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        if ($patient->provider_id !== auth()->user()->provider->id) {
            abort(403);
        }

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:50',

            'referrer' => 'required|in:optometrista,oftalmologo,medico_general,otro',
            'referral_type' => 'required|in:consulta_general,cirugia_refractiva,catarata_cristalino,retina',

            'insurance' => 'nullable|in:axxa,allianz,gnp,metlife,atlas,inbursa,sura,ve_por_mas,seguros_monterrey,seguros_banorte,mapfre,zurich,otro',
            'policy_date' => 'nullable|date',

            'clinical_data' => 'nullable|array',

            'refraction' => 'nullable|string',
            'anterior_segment_findings' => 'nullable|string',
            'posterior_segment_findings' => 'nullable|string',

            'files.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',

            'observations' => 'nullable|string',
        ]);

        $patient->update($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('patients/' . $patient->id, 'public');

                $patient->files()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => round($file->getSize() / 1024),
                ]);
            }
        }

        return response()->json([
            'success' => true
        ]);
    }
}
