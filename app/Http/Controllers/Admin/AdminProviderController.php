<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::latest()->get();

        return view('admin.providers.index', compact('providers'));
    }


    public function updateStatus(Request $request, Provider $provider)
    {
        $provider->update([
            'is_active' => $request->boolean('is_active')
        ]);

        $provider->user->update([
            'is_active' => $request->boolean('is_active')
        ]);

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'clinic_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'password' => 'required|string|min:10',
        ]);

        DB::beginTransaction();

        try {

            
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'provider',
                'is_active' => true,
            ]);

            
            $provider = Provider::create([
                'user_id' => $user->id,
                'clinic_name' => $data['clinic_name'],
                'contact_name' => $data['name'], // obligatorio en DB
                'phone' => $data['phone'],
                'is_active' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'provider' => [
                    'id' => $provider->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $provider->is_active,
                ],
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al crear proveedor',
            ], 500);
        }
    }
}
