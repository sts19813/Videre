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

                                    <small class="text-muted mt-1">
                                        {{ $patient->status_date_time }}
                                    </small>

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
                                        <button class="btn btn-sm btn-light-danger btn-cancel-patient">
                                            <i class="ki-outline ki-cross fs-5"></i>
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