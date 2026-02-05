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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'provider_id' => 'required|exists:providers,id',
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