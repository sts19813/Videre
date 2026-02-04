<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class AdminProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::latest()->get();

        return view('admin.providers.index', compact('providers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:providers,email',
            'phone' => 'nullable|string|max:20',
        ]);

        Provider::create($validated);

        return redirect()
            ->route('admin.providers.index')
            ->with('success', 'Proveedor creado correctamente');
    }
}
