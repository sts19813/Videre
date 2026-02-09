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
            'patients_sent' => Patient::count(),
            'patients_attended' => Patient::where('status', 'atendido')->count(),
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
