@extends('layouts.auth')

@section('title', 'Registro | Videre')

@section('content')
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
        <!--begin::Card-->
        <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">

            <!--begin::Wrapper-->
            <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">

                <!--begin::Form-->
                <form method="POST" action="{{ route('register') }}" class="form w-100" novalidate id="kt_sign_up_form">

                    @csrf

                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <h1 class="text-gray-900 fw-bolder mb-3">Crear cuenta</h1>
                        <div class="text-gray-500 fw-semibold fs-6">
                            Registro de usuario
                        </div>
                    </div>
                    <!--end::Heading-->

                    <!--begin::Separator-->
                    <div class="separator separator-content my-14">
                        <span class="w-125px text-gray-500 fw-semibold fs-7">Datos del usuario</span>
                    </div>

                    <!--begin::Name-->
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Nombre completo" name="name" value="{{ old('name') }}"
                            class="form-control bg-transparent" required />

                        @error('name')
                            <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Name-->

                    <!--begin::Email-->
                    <div class="fv-row mb-8">
                        <input type="email" placeholder="Correo electrónico" name="email" value="{{ old('email') }}"
                            class="form-control bg-transparent" required />

                        @error('email')
                            <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Email-->

                    <!--begin::Password-->
                    <div class="fv-row mb-8" data-kt-password-meter="true">
                        <div class="position-relative mb-3">
                            <input type="password" placeholder="Contraseña" name="password"
                                class="form-control bg-transparent" required />

                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                data-kt-password-meter-control="visibility">
                                <i class="ki-outline ki-eye-slash fs-2"></i>
                                <i class="ki-outline ki-eye fs-2 d-none"></i>
                            </span>
                        </div>

                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>

                        <div class="text-muted fs-7">
                            Usa al menos 8 caracteres
                        </div>

                        @error('password')
                            <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Password-->

                    <!--begin::Confirm Password-->
                    <div class="fv-row mb-8">
                        <input type="password" placeholder="Confirmar contraseña" name="password_confirmation"
                            class="form-control bg-transparent" required />

                        @error('password_confirmation')
                            <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Confirm Password-->

                    <!--begin::Submit-->
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Registrarme</span>
                            <span class="indicator-progress">
                                Procesando...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Submit-->

                    <!--begin::Login link-->
                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="link-primary fw-semibold">
                            Inicia sesión
                        </a>
                    </div>
                    <!--end::Login link-->

                </form>
                <!--end::Form-->

            </div>
            <!--end::Wrapper-->

        </div>
        <!--end::Card-->
    </div>
@endsection