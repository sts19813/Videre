<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Provider;
use Illuminate\Support\Facades\Log;
use App\Mail\ProviderWelcomeMail;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }



    public function storeVidere(Request $request)
    {
        $request->validate([
            'provider_type' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
        ]);

        try {
            $password = Str::random(10);

            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => 'provider',
                'is_active' => true,
            ]);

             $provider = Provider::create([
                'user_id' => $user->id,
                'provider_type' => $request->provider_type,
                'clinic_name' => $request->clinic_name,
                'contact_name' => $request->first_name . ' ' . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'is_active' => true,
            ]);

            Mail::to($user->email)->send(
                new ProviderWelcomeMail($user, $provider, $password)
            );

            return redirect()
                ->route('login')
                ->with('success', 'Cuenta creada correctamente. Revisa tu correo.');

        } catch (\Throwable $e) {

            Log::error('Error registro Videre', [
                'error' => $e->getMessage()
            ]);


            return redirect()
                ->route('register')
                ->with('error', 'Ocurrió un error al crear la cuenta. Intenta nuevamente.' . $e->getMessage());
        }
    }
}
