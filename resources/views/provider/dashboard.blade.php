@extends('layouts.app')

@section('title', 'Dashboard | Videre')

@section('content')

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900">Portal del Proveedor</h1>
        <p class="text-sm text-gray-500">Clínica Visual</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-10">

        <div class="card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <div class="text-sm text-muted">Pacientes enviados</div>
                    <div class="text-2xl font-bold">{{ $stats['sent'] ?? 0 }}</div>
                </div>
                <i class="ki-duotone ki-user-square text-primary text-3xl"></i>
            </div>
        </div>

        <div class="card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <div class="text-sm text-muted">Pendientes</div>
                    <div class="text-2xl font-bold">{{ $stats['pending'] ?? 0 }}</div>
                </div>
                <i class="ki-duotone ki-time text-warning text-3xl"></i>
            </div>
        </div>

        <div class="card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <div class="text-sm text-muted">Con cita</div>
                    <div class="text-2xl font-bold">{{ $stats['scheduled'] ?? 0 }}</div>
                </div>
                <i class="ki-duotone ki-calendar text-info text-3xl"></i>
            </div>
        </div>

        <div class="card">
            <div class="card-body flex justify-between items-center">
                <div>
                    <div class="text-sm text-muted">Atendidos</div>
                    <div class="text-2xl font-bold">{{ $stats['attended'] ?? 0 }}</div>
                </div>
                <i class="ki-duotone ki-check-circle text-success text-3xl"></i>
            </div>
        </div>

    </div>

    {{-- Patients --}}
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h3 class="card-title">Listado de pacientes</h3>

            <button class="kt-btn kt-btn-primary" data-kt-modal-toggle="#patientModal">
                Agregar paciente
            </button>


        </div>

        <div class="card-body p-0">
            @include('provider.patients.index')
        </div>
    </div>



    <!-- Modal -->
    <div class="kt-modal" data-kt-modal="true" id="patientModal">
        <div class="kt-modal-content
                   max-w-[500px]
                   max-h-[calc(100vh-120px)]
                   overflow-y-auto
                   top-[10%]">

            <!-- Header -->
            <div class="kt-modal-header">
                <h3 class="kt-modal-title">Agregar paciente</h3>
                <button type="button" class="kt-modal-close" data-kt-modal-dismiss="#patientModal" aria-label="Cerrar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="kt-modal-body">

                <form class="kt-form" method="POST" action="{{ route('provider.patients.store') }}" novalidate>
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="kt-form-item">
                            <label class="kt-form-label">Nombre</label>
                            <div class="kt-form-control">
                                <input type="text" name="first_name" class="kt-input" placeholder="Nombre" required />
                            </div>
                        </div>

                        <div class="kt-form-item">
                            <label class="kt-form-label">Apellido</label>
                            <div class="kt-form-control">
                                <input type="text" name="last_name" class="kt-input" placeholder="Apellido" required />
                            </div>
                        </div>

                        <div class="kt-form-item">
                            <label class="kt-form-label">Celular</label>
                            <div class="kt-form-control">
                                <input type="text" name="phone" class="kt-input" placeholder="Celular" required />
                            </div>
                        </div>

                        <div class="kt-form-item">
                            <label class="kt-form-label">Correo</label>
                            <div class="kt-form-control">
                                <input type="email" name="email" class="kt-input" placeholder="Correo electrónico" />
                            </div>
                        </div>

                        <div class="kt-form-item md:col-span-2">
                            <label class="kt-form-label">Observaciones</label>
                            <div class="kt-form-control">
                                <textarea name="observations" class="kt-input" rows="3"
                                    placeholder="Observaciones"></textarea>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" class="kt-btn kt-btn-light" data-kt-modal-dismiss="#patientModal">
                            Cancelar
                        </button>

                        <button type="submit" class="kt-btn kt-btn-primary">
                            Guardar paciente
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection