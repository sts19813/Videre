<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProviderWelcomeMail;
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
        $request->validate([
            'provider_type' => 'required|in:doctor,optica',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:10',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'provider',
                'is_active' => true,
            ]);

            $provider = Provider::create([
                'user_id' => $user->id,
                'provider_type' => $request->provider_type,
                'clinic_name' => $request->clinic_name,
                'contact_name' => $user->name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'is_active' => true,
            ]);

            Mail::to($user->email)->send(
                new ProviderWelcomeMail($user, $provider, $request->password)
            );

            
            DB::commit();

            return response()->json([
                'success' => true,
                'provider' => [
                    'id' => $provider->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error('Error crear proveedor admin', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al crear proveedor',
            ], 500);
        }
    }


    //mostrar el provedor en el modal ver en el registro de tablas de los provedores en el dashboard de admin.
    public function show(Provider $provider)
    {
        $provider->load('user');

        return response()->json([
            'id' => $provider->id,
            'provider_type' => $provider->provider_type,
            'clinic_name' => $provider->clinic_name,
            'contact_name' => $provider->contact_name,
            'first_name' => $provider->first_name,
            'last_name' => $provider->last_name,
            'phone' => $provider->phone,
            'email' => $provider->email,
            'is_active' => $provider->is_active,

            'user' => [
                'name' => $provider->user->name,
                'email' => $provider->user->email,
            ],
        ]);
    }


}
