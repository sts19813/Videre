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
                                            'en_consulta' => 'badge-light-info',
                                            'propuesta_cirugia' => 'badge-light-danger',
                                            'propuesta_tratamiento' => 'badge-light-success',
                                            'estudios_complementarios' => 'badge-light-warning',
                                            'en_seguimiento' => 'badge-light-dark',
                                            'contrarreferencia' => 'badge-light-success',
                                            'cancelado' => 'badge-light-danger',
                                        ];

                                        $labels = [
                                            'pendiente' => 'Pendiente',
                                            'cita_agendada' => 'Cita agendada',
                                            'en_consulta' => 'En consulta',
                                            'propuesta_cirugia' => 'Cirugía propuesta',
                                            'propuesta_tratamiento' => 'Tratamiento propuesto',
                                            'estudios_complementarios' => 'Estudios solicitados',
                                            'en_seguimiento' => 'En seguimiento',
                                            'contrarreferencia' => 'Contrarreferencia',
                                            'cancelado' => 'Cancelado',
                                        ];

                                        $badgeClass = $badges[$patient->status] ?? 'badge-light';
                                        $label = $labels[$patient->status] ?? ucfirst(str_replace('_', ' ', $patient->status));
                                    @endphp

                                    <span class="badge {{ $badgeClass }} fw-semibold">
                                        {{ $label }}
                                    </span>

                                    <div class="text-muted fs-8 mt-1">
                                        {{ $patient->status_date_time ?? '' }}
                                    </div>
                                </td>




                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light btn-active-light-primary"
                                            data-bs-toggle="dropdown">
                                            Acciones
                                            <i class="ki-outline ki-down fs-6 ms-1"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-end min-w-200px">

                                            {{-- EDITAR --}}
                                            <a href="#"  class="dropdown-item btn-edit-patient"
                                                data-id="{{ $patient->id }}">
                                                <i class="ki-outline ki-pencil me-2"></i>
                                                Editar
                                            </a>

                                            {{-- Siempre disponible --}}
                                            <a class="dropdown-item btn-view-patient">
                                                <i class="ki-outline ki-eye me-2"></i>
                                                Ver registro
                                            </a>

                                            {{-- ========================= --}}
                                            {{-- PENDIENTE --}}
                                            {{-- ========================= --}}
                                            @if($patient->status === 'pendiente')
                                                <a class="dropdown-item btn-schedule-appointment">
                                                    <i class="ki-outline ki-calendar me-2"></i>
                                                    Agendar cita
                                                </a>

                                                <a class="dropdown-item text-danger btn-cancel-patient">
                                                    <i class="ki-outline ki-cross me-2"></i>
                                                    Cancelar
                                                </a>
                                            @endif


                                            {{-- ========================= --}}
                                            {{-- CITA AGENDADA --}}
                                            {{-- ========================= --}}
                                            @if($patient->status === 'cita_agendada')
                                                <a class="dropdown-item btn-attend-patient">
                                                    <i class="ki-outline ki-check me-2"></i>
                                                    Iniciar consulta
                                                </a>

                                                <a class="dropdown-item btn-reschedule-appointment">
                                                    <i class="ki-outline ki-refresh me-2"></i>
                                                    Reagendar
                                                </a>
                                            @endif


                                            {{-- ========================= --}}
                                            {{-- EN CONSULTA (DECISIÓN) --}}
                                            {{-- ========================= --}}
                                            @if($patient->status === 'en_consulta')
                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item btn-propose-surgery">
                                                    <i class="ki-outline ki-plus-square me-2"></i>
                                                    Proponer cirugía
                                                </a>

                                                <a class="dropdown-item btn-propose-treatment">
                                                    <i class="ki-outline ki-capsule me-2"></i>
                                                    Proponer tratamiento
                                                </a>

                                                <a class="dropdown-item btn-request-studies">
                                                    <i class="ki-outline ki-file-added me-2"></i>
                                                    Solicitar estudios
                                                </a>
                                            @endif


                                            {{-- ========================= --}}
                                            {{-- TRATAMIENTO / ESTUDIOS → PUEDEN ESCALAR --}}
                                            {{-- ========================= --}}
                                            @if(in_array($patient->status, ['propuesta_tratamiento', 'estudios_complementarios']))
                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item btn-propose-surgery">
                                                    <i class="ki-outline ki-arrow-up me-2"></i>
                                                    Escalar a cirugía
                                                </a>
                                            @endif


                                            {{-- ========================= --}}
                                            {{-- CIERRE CLÍNICO --}}
                                            {{-- ========================= --}}
                                            @if(
                                                    in_array($patient->status, [
                                                        'propuesta_cirugia',
                                                        'propuesta_tratamiento',
                                                        'estudios_complementarios',
                                                        'en_seguimiento'
                                                    ])
                                                )
                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item text-primary fw-semibold btn-counter-reference">
                                                    <i class="ki-outline ki-abstract-26 me-2"></i>
                                                    Cerrar en contrarreferencia
                                                </a>
                                            @endif

                                        </div>
                                    </div>
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