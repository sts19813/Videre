@extends('layouts.auth')

@section('title', 'Crear cuenta | Videre')

@section('content')
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">

        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">

            <form method="POST" action="{{ route('register') }}" class="form w-100">
                @csrf

                {{-- Heading --}}
                <div class="text-center mb-11">
                    <h1 class="text-gray-900 fw-bolder mb-3">
                        Crear cuenta
                    </h1>
                    <div class="text-gray-500 fw-semibold fs-6">
                        Únete a la red de proveedores Videre
                    </div>
                </div>

                {{-- Tipo proveedor --}}
                <div class="fv-row mb-8">
                    <select name="provider_type" class="form-select form-select-lg bg-transparent" required>
                        <option value="">Selecciona el tipo</option>
                        <option value="doctor">Doctor</option>
                        <option value="optica">Óptica</option>
                    </select>
                </div>

                {{-- Nombre --}}
                <div class="fv-row mb-8">
                    <input type="text" name="first_name" class="form-control form-control-lg bg-transparent"
                        placeholder="Nombre" required />
                </div>

                {{-- Apellido --}}
                <div class="fv-row mb-8">
                    <input type="text" name="last_name" class="form-control form-control-lg bg-transparent"
                        placeholder="Apellido" required />
                </div>

                {{-- Empresa --}}
                <div class="fv-row mb-8">
                    <input type="text" name="clinic_name" class="form-control form-control-lg bg-transparent"
                        placeholder="Empresa / Consultorio" required />
                </div>

                {{-- Teléfono --}}
                <div class="fv-row mb-8">
                    <input type="tel" name="phone" class="form-control form-control-lg bg-transparent"
                        placeholder="Teléfono" required />
                </div>

                {{-- Email --}}
                <div class="fv-row mb-10">
                    <input type="email" name="email" class="form-control form-control-lg bg-transparent"
                        placeholder="Correo electrónico" required />
                </div>

                {{-- Submit --}}
                <div class="d-grid mb-10">
                    <button type="submit" class="btn btn-primary">
                        Crear cuenta
                    </button>
                </div>

                <div class="text-gray-500 text-center fw-semibold fs-6">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="link-primary">Inicia sesión</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
