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
            'status' => 'en_consulta',
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


            'files.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
            // Observaciones generales
            'observations' => 'nullable|string',
        ]);

        $data['status'] = 'pendiente';

        $patient = Patient::create($data);


        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $file) {

                $path = $file->store('patients/' . $patient->id, 'public');

                $patient->files()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => round($file->getSize() / 1024), // KB
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Paciente creado correctamente'
        ]);
    }

    public function proposeSurgery(Request $request, Patient $patient)
    {
        if (
            $patient->status !== 'en_consulta' &&
            $patient->status !== 'estudios_complementarios' &&
            $patient->status !== 'propuesta_tratamiento'
        ) {
            abort(403);
        }

        $data = $request->validate([
            'surgery_type' => 'required|string',
            'surgery_notes' => 'nullable|string',
        ]);

        $patient->update([
            'procedure' => $data['surgery_type'],
            'attention_observations' => $data['surgery_notes'],
            'status' => 'propuesta_cirugia',
        ]);

        return response()->json(['success' => true]);
    }

    public function proposeTreatment(Request $request, Patient $patient)
    {
        if ($patient->status !== 'en_consulta') {
            abort(403);
        }

        $data = $request->validate([
            'treatment_plan' => 'required|string',
            'treatment_notes' => 'nullable|string',
        ]);

        $patient->update([
            'attention_observations' => $data['treatment_notes'],
            'procedure' => $data['treatment_plan'],
            'status' => 'propuesta_tratamiento',
        ]);

        return response()->json(['success' => true]);
    }

    public function requestStudies(Request $request, Patient $patient)
    {
        if ($patient->status !== 'en_consulta') {
            abort(403);
        }

        $data = $request->validate([
            'studies_requested' => 'required|string',
            'studies_notes' => 'nullable|string',
        ]);

        $patient->update([
            'attention_observations' => $data['studies_notes'],
            'procedure' => $data['studies_requested'],
            'status' => 'estudios_complementarios',
        ]);

        return response()->json(['success' => true]);
    }


    public function counterReference(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'counter_reference_notes' => 'required|string',
        ]);

        $patient->update([
            'attention_observations' => $data['counter_reference_notes'],
            'status' => 'contrarreferencia',
        ]);

        return response()->json(['success' => true]);
    }



}