<div class="row g-4">

    {{-- DATOS DEL PACIENTE --}}
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
                    <span class="text-muted">Referido por</span>
                    <div class="fw-semibold">{{ $patient->referrer ?: '—' }}</div>
                </div>

                <div class="mb-2">
                    <span class="text-muted">Tipo de referencia</span>
                    <div class="fw-semibold">{{ $patient->referral_type ?: '—' }}</div>
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


    {{-- PROVEEDOR --}}
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

    @if($patient->insurance || $patient->policy_date)
        <div class="col-md-6">
            <div class="card border h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Seguro / Póliza</h6>

                    <div class="mb-2">
                        <span class="text-muted">Seguro</span>
                        <div class="fw-semibold">{{ $patient->insurance ?: '—' }}</div>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Fecha de póliza</span>
                        <div class="fw-semibold">
                            {{ optional($patient->policy_date)->format('d/m/Y') ?: '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($patient->clinical_data))
        <div class="col-md-6">
            <div class="card border h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Datos clínicos</h6>

                    @foreach($patient->clinical_data as $key => $value)
                        <div class="mb-2">
                            <span class="text-muted">
                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                            </span>
                            <div class="fw-semibold">
                                {{ $value ?: '—' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($patient->appointment_date || $patient->appointment_time)
        <div class="col-md-6">
            <div class="card border h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Cita</h6>

                    <div class="mb-2">
                        <span class="text-muted">Fecha</span>
                        <div class="fw-semibold">
                            {{ optional($patient->appointment_date)->format('d/m/Y') ?: '—' }}
                        </div>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Hora</span>
                        <div class="fw-semibold">
                            {{ $patient->appointment_time ?: '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($patient->attention_date || $patient->procedure)
        <div class="col-md-6">
            <div class="card border h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Atención</h6>

                    <div class="mb-2">
                        <span class="text-muted">Fecha de atención</span>
                        <div class="fw-semibold">
                            {{ optional($patient->attention_date)->format('d/m/Y') ?: '—' }}
                        </div>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Hora</span>
                        <div class="fw-semibold">
                            {{ $patient->attention_time ?: '—' }}
                        </div>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Procedimiento</span>
                        <div class="fw-semibold">
                            {{ $patient->procedure ?: '—' }}
                        </div>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Observaciones</span>
                        <div class="fw-semibold">
                            {{ $patient->attention_observations ?: '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(
            $patient->refraction ||
            $patient->anterior_segment_findings ||
            $patient->posterior_segment_findings
        )
        <div class="col-md-12">
            <div class="card border">
                <div class="card-body">
                    <h6 class="fw-bold mb-4">Evaluación clínica</h6>

                    <div class="row g-4">

                        {{-- Refracción --}}
                        <div class="col-md-4">
                            <span class="text-muted d-block mb-1">
                                Refracción / graduación
                            </span>
                            <div class="fw-semibold">
                                {{ $patient->refraction ?: '—' }}
                            </div>
                        </div>

                        {{-- Segmento anterior --}}
                        <div class="col-md-4">
                            <span class="text-muted d-block mb-1">
                                Hallazgos segmento anterior
                            </span>
                            <div class="fw-semibold">
                                {{ $patient->anterior_segment_findings ?: '—' }}
                            </div>
                        </div>

                        {{-- Segmento posterior --}}
                        <div class="col-md-4">
                            <span class="text-muted d-block mb-1">
                                Hallazgos segmento posterior
                            </span>
                            <div class="fw-semibold">
                                {{ $patient->posterior_segment_findings ?: '—' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

</div>