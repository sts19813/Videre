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

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#patientModal">
                Agregar paciente
            </button>
        </div>

        <div class="card-body pt-0">
            <table id="patientsTable" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Observaciones</th>
                        <th class="text-center">Estatus</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ki-duotone ki-user fs-3 text-primary"></i>
                                    <span class="fw-semibold">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </span>
                                </div>
                            </td>

                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->email }}</td>
                            <td class="text-muted">{{ $patient->observations }}</td>

                            <td class="text-center">
                                @php
                                    $statusMap = [
                                        'pendiente' => ['warning', 'Pendiente'],
                                        'cita_agendada' => ['info', 'Con cita'],
                                        'atendido' => ['success', 'Atendido'],
                                        'cancelado' => ['danger', 'Cancelado'],
                                    ];
                                    [$color, $label] = $statusMap[$patient->status] ?? ['secondary', 'Desconocido'];
                                @endphp

                                <span class="badge badge-light-{{ $color }} fw-bold px-4 py-2">
                                    {{ $label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-10">
                                <i class="ki-duotone ki-information fs-2 mb-2 d-block"></i>
                                No hay pacientes registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    @include('provider.patients.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            let table = $('#patientsTable').DataTable({
                responsive: true,
                pageLength: 10,
                paging: true,
                lengthChange: true,
                ordering: true,
                info: true,
                searching: true,
                "language": { url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json' },
                dom: "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
            });

            $('#patientsSearch').on('keyup', function () {
                table.search(this.value).draw();
            });

        });
    </script>
@endpush