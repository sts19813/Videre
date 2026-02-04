@extends('layouts.app')

@section('title', 'Admin | Dashboard')

@section('content')

{{-- HEADER --}}
<div class="mb-4">
    <h1 class="h3 fw-bold">Portal Videre</h1>
    <p class="text-muted">Panel de administración</p>
</div>

{{-- STATS --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total de proveedores</div>
                    <div class="fs-3 fw-bold">{{ $stats['providers'] }}</div>
                </div>
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="ki-duotone ki-people fs-3 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Pacientes enviados</div>
                    <div class="fs-3 fw-bold">{{ $stats['patients_sent'] }}</div>
                </div>
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="ki-duotone ki-pulse fs-3 text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Pacientes atendidos</div>
                    <div class="fs-3 fw-bold">{{ $stats['patients_attended'] }}</div>
                </div>
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="ki-duotone ki-user-check fs-3 text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABS --}}
<ul class="nav nav-pills mb-4" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-patients">
            Pacientes
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-providers">
            Proveedores
        </button>
    </li>
    <li class="nav-item flex-grow-1">
        <button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#tab-users">
            Usuarios Videre
        </button>
    </li>
</ul>

<div class="tab-content">

    {{-- PACIENTES --}}
    <div class="tab-pane fade show active" id="tab-patients">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Pacientes</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Proveedor</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estatus</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td>{{ $patient->provider->user->name ?? '-' }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->email }}</td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning">
                                        {{ ucfirst($patient->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        Ver detalle
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay pacientes registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PROVEEDORES --}}
    <div class="tab-pane fade" id="tab-providers">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Proveedores</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($providers as $provider)
                            <tr>
                                <td>{{ $provider->user->name }}</td>
                                <td>{{ $provider->user->email }}</td>
                                <td>
                                    <span class="badge {{ $provider->active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $provider->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- USUARIOS --}}
    <div class="tab-pane fade" id="tab-users">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Usuarios Videre</h5>
                <button class="btn btn-primary">
                    <i class="ki-duotone ki-plus me-1"></i> Agregar usuario
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
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

@endsection
