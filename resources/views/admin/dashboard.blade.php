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
                        <div class="text-muted small">Proveedores</div>
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
                <i class="ki-outline ki-people me-2"></i> Proveedores
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
        <div class="tab-pane fade show active" id="tab-patients">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pacientes</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#patientCreateModal">
                        <i class="ki-outline ki-plus me-1"></i> Agregar paciente
                    </button>

                </div>

                <div class="card-body p-0">
                    <div class="px-6 py-4">
                        <table id="patientsTable" class="table table-row-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fw-bold text-muted">
                                    <th>Nombre</th>
                                    <th>Proveedor</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th class="text-center">Estatus</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $patient)
                                    <tr data-id="{{ $patient->id }}">
                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                        <td>{{ $patient->provider->user->name ?? '-' }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->email }}</td>

                                        <td class="text-center">
                                            @php
                                                $badges = [
                                                    'pendiente' => 'badge-light-warning',
                                                    'cita_agendada' => 'badge-light-primary',
                                                    'atendido' => 'badge-light-success',
                                                    'cancelado' => 'badge-light-danger',
                                                ];
                                            @endphp

                                            <span class="badge {{ $badges[$patient->status] }}">
                                                {{ ucfirst(str_replace('_', ' ', $patient->status)) }}
                                            </span>
                                        </td>


                                        <td class="text-center">

                                            {{-- VER REGISTRO (SIEMPRE) --}}
                                            <button class="btn btn-sm btn-light-primary btn-view-patient" title="Ver registro">
                                                <i class="ki-outline ki-eye fs-5"></i>
                                            </button>

                                            {{-- PENDIENTE --}}
                                            @if ($patient->status === 'pendiente')
                                                <button class="btn btn-sm btn-primary btn-schedule-appointment">
                                                    <i class="ki-outline ki-calendar fs-5"></i>
                                                    Agendar cita
                                                </button>

                                                <button class="btn btn-sm btn-light-danger btn-cancel-patient">
                                                    <i class="ki-outline ki-cross fs-5"></i>
                                                    Cancelar
                                                </button>
                                            @endif

                                            {{-- CITA AGENDADA --}}
                                            @if ($patient->status === 'cita_agendada')
                                                <button class="btn btn-sm btn-warning btn-reschedule-appointment">
                                                    <i class="ki-outline ki-refresh fs-5"></i>
                                                    Reagendar
                                                </button>

                                                <button class="btn btn-sm btn-success btn-attend-patient">
                                                    <i class="ki-outline ki-check fs-5"></i>
                                                    Atender
                                                </button>
                                            @endif

                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-6">
                                            No hay pacientes registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== PROVEEDORES ===================== --}}
        <div class="tab-pane fade" id="tab-providers">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Proveedores</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#providerCreateModal">
                        <i class="ki-outline ki-plus me-1"></i> Agregar proveedor
                    </button>

                </div>

                <div class="card-body p-0">
                    <div class="px-6 py-4">
                        <table id="providersTable" class="table table-row-bordered align-middle gy-4">
                            <thead class="table-light">
                                <tr class="fw-bold text-muted">
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th class="text-center">Estatus</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($providers as $provider)
                                    <tr data-id="{{ $provider->id }}">
                                        <td class="fw-semibold">
                                            {{ $provider->user->name }}
                                        </td>

                                        <td>{{ $provider->user->email }}</td>

                                        {{-- ESTATUS --}}
                                        <td class="text-center">
                                            <select class="form-select form-select-sm provider-status w-auto mx-auto">
                                                <option value="1" @selected($provider->is_active)>Activo</option>
                                                <option value="0" @selected(!$provider->is_active)>Inactivo</option>
                                            </select>
                                        </td>

                                        {{-- ACCIONES --}}
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light-primary btn-view-provider">
                                                <i class="ki-outline ki-eye fs-5"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- ===================== USUARIOS ===================== --}}
        <div class="tab-pane fade" id="tab-users">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Usuarios Videre</h5>
                    <button class="btn btn-primary btn-sm">
                        <i class="ki-outline ki-plus me-1"></i> Agregar usuario
                    </button>
                </div>

                <div class="card-body p-0">
                    <table id="usersTable" class="table table-row-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fw-bold text-muted">
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th class="text-center">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-light-primary">
                                            Administrador
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                <div class="modal-body" id="patientDetailContent">
                    <div class="text-center text-muted py-10">Cargando...</div>
                </div>
            </div>
        </div>
    </div>

    <x-patient-create-modal :is-admin="true" :providers="$providers" action="{{ route('admin.patients.store') }}" />

    <div class="modal fade" id="providerCreateModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form id="createProviderForm" method="POST" action="{{ route('admin.providers.store') }}">
                    @csrf
                    <input type="hidden" name="password" id="passwordField">

                    <div class="modal-header">
                        <h5 class="modal-title">Agregar proveedor</h5>
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label">Nombre del usuario</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Clínica</label>
                                <input type="text" name="clinic_name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Contraseña generada</label>
                                <div class="input-group">
                                    <input type="text" id="generatedPassword" class="form-control" readonly>
                                    <button type="button" class="btn btn-light" id="copyPassword">
                                        <i class="ki-outline ki-copy"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Crear proveedor</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="appointmentModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Agendar cita</h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="appointmentPatientId">

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" id="appointmentDate" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hora</label>
                        <input type="time" id="appointmentTime" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="saveAppointment">
                        Guardar cita
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="attendPatientModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Atender paciente</h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="attendPatientId">

                    <div class="mb-4">
                        <label class="form-label">Fecha de atención *</label>
                        <input type="date" id="attentionDate" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Hora de atención *</label>
                        <input type="time" id="attentionTime" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Procedimiento / Estudio ocular *</label>
                        <select id="procedure" class="form-select" required>
                            <option value="">Selecciona un procedimiento</option>
                            <option>Examen visual completo</option>
                            <option>Agudeza visual</option>
                            <option>Fondo de ojo</option>
                            <option>Tonometría</option>
                            <option>Retinografía</option>
                            <option>OCT</option>
                            <option>Campimetría visual</option>
                            <option>Topografía corneal</option>
                            <option>Adaptación de lentes de contacto</option>
                            <option>Evaluación preoperatoria</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Observaciones</label>
                        <textarea id="attentionObservations" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" id="saveAttention">
                        Guardar atención
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="/assets/js/dashboardAdmin.js"></script>
    @include('components.tipo-de-referido')
@endpush