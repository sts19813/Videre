<div class="row g-4">

    {{-- Datos del paciente --}}
    <div class="col-md-6">
        <div class="card border h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Información del paciente</h6>

                <div class="mb-2">
                    <span class="text-muted">Nombre</span>
                    <div class="fw-semibold">
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </div>
                </div>

                <div class="mb-2">
                    <span class="text-muted">Teléfono</span>
                    <div class="fw-semibold">{{ $patient->phone }}</div>
                </div>

                <div class="mb-2">
                    <span class="text-muted">Correo</span>
                    <div class="fw-semibold">{{ $patient->email }}</div>
                </div>

                <div class="mb-2">
                    <span class="text-muted">Observaciones</span>
                    <div class="fw-semibold">
                        {{ $patient->observations ?: '—' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Proveedor --}}
    <div class="col-md-6">
        <div class="card border h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Proveedor</h6>

                <div class="mb-2">
                    <span class="text-muted">Nombre</span>
                    <div class="fw-semibold">
                        {{ $patient->provider->user->name ?? '—' }}
                    </div>
                </div>

                <div class="mb-2">
                    <span class="text-muted">Correo</span>
                    <div class="fw-semibold">
                        {{ $patient->provider->user->email ?? '—' }}
                    </div>
                </div>

                <div class="mb-2">
                    <span class="text-muted">Estatus</span>
                    <div>
                        @php
                            $statusMap = [
                                'pendiente' => 'warning',
                                'cita_agendada' => 'info',
                                'atendido' => 'success',
                                'cancelado' => 'danger',
                            ];
                        @endphp

                        <span class="badge badge-light-{{ $statusMap[$patient->status] ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_', ' ', $patient->status)) }}
                        </span>
                    </div>
                </div>

                <div class="mb-2">
                    <span class="text-muted">Registrado</span>
                    <div class="fw-semibold">
                        {{ $patient->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
