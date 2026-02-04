@extends('layouts.app')

@section('title', 'Dashboard | Videre')

@section('content')

    {{-- Page Header --}}
    <div class="mb-4">
        <h1 class="h4 fw-semibold text-dark mb-1">Portal del Proveedor</h1>
        <p class="text-muted mb-0">Clínica Visual</p>
    </div>

    {{-- Stats --}}
    <div class="row g-4 mb-4">

        {{-- Pacientes enviados --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;">
                        <i class="ki-duotone ki-user-square text-primary fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pacientes enviados</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['sent'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pendientes --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;">
                        <i class="ki-duotone ki-time text-warning fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pendientes</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['pending'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Con cita --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;">
                        <i class="ki-duotone ki-calendar text-info fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Con cita</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['scheduled'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Atendidos --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;">
                        <i class="ki-duotone ki-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Atendidos</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['attended'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Patients --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de pacientes</h5>

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#patientModal"
            >
                Agregar paciente
            </button>
        </div>

        <div class="card-body p-0">
            @include('provider.patients.index')
        </div>
    </div>

    @include('provider.patients.modal')

@endsection
