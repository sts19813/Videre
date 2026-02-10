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
use Illuminate\Support\Str;
use App\Mail\AdminWelcomeMail;
class AdminUserController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $password = Str::random(10);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($password),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 📧 Enviar correo de bienvenida
        Mail::to($user->email)->send(
            new AdminWelcomeMail($user, $password)
        );

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function disable(User $user)
    {
        // Seguridad básica
        abort_if($user->role !== 'admin', 403);

        $user->update([
            'is_active' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario deshabilitado correctamente',
        ]);
    }

}
