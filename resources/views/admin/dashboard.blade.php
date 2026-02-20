@extends('layouts.app')

@section('title', 'Admin | Dashboard')

@section('content')

    {{-- HEADER --}}
    <div class="mb-4">
        <h1 class="h4 fw-semibold text-dark mb-1">Portal Videre</h1>
        <p class="text-muted mb-0">Panel de administración</p>
    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-5">

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-people fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Afiliados</div>
                        <div class="fs-4 fw-semibold">{{ $stats['providers'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-user fs-3 text-info"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pacientes enviados</div>
                        <div class="fs-4 fw-semibold">{{ $stats['patients_sent'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-check-circle fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pacientes atendidos</div>
                        <div class="fs-4 fw-semibold">{{ $stats['patients_attended'] }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABS --}}
    <ul class="nav nav-pills d-flex mb-4 gap-2" role="tablist">

        <li class="nav-item flex-fill">
            <button class="nav-link active w-100 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-patients">
                <i class="ki-outline ki-user me-2"></i> Pacientes
            </button>
        </li>

        <li class="nav-item flex-fill">
            <button class="nav-link w-100 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-providers">
                <i class="ki-outline ki-people me-2"></i> Afiliados videre
            </button>
        </li>

        <li class="nav-item flex-fill">
            <button class="nav-link w-100 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-users">
                <i class="ki-outline ki-shield-user me-2"></i> Usuarios Videre
            </button>
        </li>

    </ul>


    <div class="tab-content">

        {{-- ===================== PACIENTES ===================== --}}
        @include('admin.patients.index')

        {{-- ===================== PROVEEDORES ===================== --}}
        @include('admin.providers.index')

        {{-- ===================== USUARIOS ===================== --}}
        @include('admin.users.index')
    </div>
    <div class="modal fade" id="patientDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle del paciente</h5>
                    <button class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-2"></i>
                    </button>
                </div>
                <div class="modal-body pt-0" id="patientDetailContent">
                    <div class="text-center text-muted py-10">Cargando...</div>
                </div>
            </div>
        </div>
    </div>

    <x-patient-create-modal :is-admin="true" :providers="$providers" action="{{ route('admin.patients.store') }}" />

    @include('admin.providers.modal')

    @include('admin.patients.appointmentPatientModal')

    @include('admin.patients.attendPatientModal')

    @include('admin.patients.studiesModal')

    @include('admin.patients.surgeryModal')

    @include('admin.patients.treatmentModal')
    @include('admin.patients.counterReferenceModal')

@endsection
@push('scripts')
    <script src="/assets/js/dashboardAdmin.js"></script>
    @include('components.tipo-de-referido')
@endpush