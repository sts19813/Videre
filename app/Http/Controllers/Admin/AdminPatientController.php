<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Provider;
use App\Models\Patient;
use Illuminate\Http\Request;

class AdminPatientController extends Controller
{
    public function updateStatus(Request $request, Patient $patient)
    {
        $request->validate([
            'status' => 'required|in:pendiente,cita_agendada,atendido,cancelado'
        ]);

        $patient->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    public function schedule(Request $request, Patient $patient)
    {


        $data = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required'
        ]);

        $patient->update([
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'status' => 'cita_agendada'
        ]);

        return response()->json(['success' => true]);
    }

    public function attend(Request $request, Patient $patient)
    {
        if ($patient->status !== 'cita_agendada') {
            abort(403);
        }

        $data = $request->validate([
            'attention_date' => 'required|date',
            'attention_time' => 'required',
            'procedure' => 'required|string',
            'attention_observations' => 'nullable|string',
        ]);

        $patient->update([
            'attention_date' => $data['attention_date'],
            'attention_time' => $data['attention_time'],
            'procedure' => $data['procedure'],
            'attention_observations' => $data['attention_observations'],
            'status' => 'atendido',
        ]);

        return response()->json(['success' => true]);
    }

    public function cancel(Patient $patient)
    {
        if ($patient->status !== 'pendiente') {
            abort(403);
        }

        $patient->update([
            'status' => 'cancelado'
        ]);

        return response()->json(['success' => true]);
    }



    public function show(Patient $patient)
    {
        // Cargamos relaciones necesarias
        $patient->load([
            'provider.user'
        ]);

        return view('admin.patients.show', compact('patient'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Datos base del paciente
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:50',
            'provider_id' => 'required|exists:providers,id',

            // Referente
            'referrer' => 'required|in:optometrista,oftalmologo,medico_general,otro',

            // Tipo de referido
            'referral_type' => 'required|in:consulta_general,cirugia_refractiva,catarata_cristalino,retina',

            // Seguro
            'insurance' => 'nullable|in:axxa,allianz,gnp,metlife,atlas,inbursa,sura,ve_por_mas,seguros_monterrey,seguros_banorte,mapfre,zurich,otro',
            'policy_date' => 'nullable|date',

            // Información clínica dinámica
            'clinical_data' => 'nullable|array',

            'refraction' => 'nullable|string',
            'anterior_segment_findings' => 'nullable|string',
            'posterior_segment_findings' => 'nullable|string',

            // Observaciones generales
            'observations' => 'nullable|string',
        ]);

        $data['status'] = 'pendiente';

        Patient::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Paciente creado correctamente'
        ]);
    }

}