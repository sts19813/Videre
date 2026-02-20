<div class="col-12">


    {{-- ================= HEADER GLOBAL ================= --}}
    <div class="card-header border-0 pt-6">

        <div class="card-toolbar mb-6">
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_detalles">
                        Detalles del paciente
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab_historico">
                        Histórico de cambios
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="card-body">

        <div class="tab-content">

            {{-- ===================================================== --}}
            {{-- TAB 1: DETALLES COMPLETOS --}}
            {{-- ===================================================== --}}
            <div class="tab-pane fade show active" id="tab_detalles">

                <div class="row g-6">

                    {{-- ===================== --}}
                    {{-- 1️⃣ PACIENTE + EXPEDIENTE --}}
                    {{-- ===================== --}}
                    <div class="col-xl-8">
                        <div class="card shadow-sm">
                            <div class="card-header border-0">
                                <h3 class="card-title fw-bold text-dark">
                                    Información del Paciente
                                </h3>
                            </div>

                            <div class="card-body pt-0">

                                <div class="row g-6">

                                    {{-- Datos básicos --}}
                                    <div class="col-md-6">
                                        <div class="mb-5">
                                            <label class="text-muted fw-semibold fs-7">Nombre completo</label>
                                            <div class="fw-bold fs-6">
                                                {{ $patient->first_name }} {{ $patient->last_name }}
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <label class="text-muted fw-semibold fs-7">Teléfono</label>
                                            <div class="fw-bold fs-6">{{ $patient->phone ?: '—' }}</div>
                                        </div>

                                        <div class="mb-5">
                                            <label class="text-muted fw-semibold fs-7">Correo</label>
                                            <div class="fw-bold fs-6">{{ $patient->email ?: '—' }}</div>
                                        </div>
                                    </div>

                                    {{-- Seguro --}}
                                    <div class="col-md-6">
                                        <div class="mb-5">
                                            <label class="text-muted fw-semibold fs-7">Seguro</label>
                                            <div class="fw-bold fs-6">
                                                {{ $patient->insurance ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <label class="text-muted fw-semibold fs-7">Fecha de póliza</label>
                                            <div class="fw-bold fs-6">
                                                {{ optional($patient->policy_date)->format('d/m/Y') ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="mb-5">
                                            <label class="text-muted fw-semibold fs-7">Registrado el</label>
                                            <div class="fw-bold fs-6">
                                                {{ optional($patient->created_at)->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Datos clínicos dinámicos --}}
                                @if(!empty($patient->clinical_data))
                                    <div class="separator my-6"></div>

                                    <h5 class="fw-bold mb-4">Datos Clínicos</h5>

                                    <div class="row g-4">
                                        @foreach($patient->clinical_data as $key => $value)
                                            <div class="col-md-4">
                                                <label class="text-muted fw-semibold fs-7">
                                                    {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                </label>
                                                <div class="fw-bold fs-6">
                                                    {{ $value ?: '—' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Evaluación clínica --}}
                                @if(
                                        $patient->refraction ||
                                        $patient->anterior_segment_findings ||
                                        $patient->posterior_segment_findings
                                    )
                                    <div class="separator my-6"></div>

                                    <h5 class="fw-bold mb-4">Evaluación Clínica</h5>

                                    <div class="row g-6">

                                        <div class="col-md-4">
                                            <label class="text-muted fw-semibold fs-7">
                                                Refracción / Graduación
                                            </label>
                                            <div class="fw-bold fs-6">
                                                {{ $patient->refraction ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted fw-semibold fs-7">
                                                Segmento anterior
                                            </label>
                                            <div class="fw-bold fs-6">
                                                {{ $patient->anterior_segment_findings ?: '—' }}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-muted fw-semibold fs-7">
                                                Segmento posterior
                                            </label>
                                            <div class="fw-bold fs-6">
                                                {{ $patient->posterior_segment_findings ?: '—' }}
                                            </div>
                                        </div>

                                    </div>
                                @endif

                            </div>
                        </div>

                        {{-- ===================== --}}
                        {{-- 2️⃣ EXPEDIENTE --}}
                        {{-- ===================== --}}
                        <div class="card shadow-sm mt-6">
                            <div class="card-header border-0">
                                <h3 class="card-title fw-bold text-dark">
                                    Expediente Clínico
                                </h3>
                            </div>

                            <div class="card-body pt-0">
                                @if($patient->files->count())
                                    <div class="row g-4">
                                        @foreach($patient->files as $file)
                                            <div class="col-md-4">
                                                <div class="border rounded p-4 text-center">
                                                    <i class="ki-duotone ki-file fs-2x text-primary mb-2"></i>
                                                    <div class="fw-semibold">
                                                        {{ $file->file_name }}
                                                    </div>
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                        class="btn btn-sm btn-light-primary mt-3">
                                                        Ver archivo
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-muted">No hay archivos cargados.</div>
                                @endif
                            </div>
                        </div>

                    </div>


                    {{-- ===================== --}}
                    {{-- LADO DERECHO --}}
                    {{-- ===================== --}}
                    <div class="col-xl-4">

                        {{-- 3️⃣ PROVEEDOR --}}
                        <div class="card shadow-sm mb-6">
                            <div class="card-header border-0">
                                <h3 class="card-title fw-bold text-dark">
                                    Referido por
                                </h3>
                            </div>

                            <div class="card-body pt-0">

                                <div class="mb-4">
                                    <label class="text-muted fw-semibold fs-7">Afiliado</label>
                                    <div class="fw-bold fs-6">
                                        {{ $patient->provider->user->name ?? '—' }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="text-muted fw-semibold fs-7">Correo</label>
                                    <div class="fw-bold fs-6">
                                        {{ $patient->provider->user->email ?? '—' }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="text-muted fw-semibold fs-7">Clínica</label>
                                    <div class="fw-bold fs-6">
                                        {{ $patient->provider->clinic_name ?? '—' }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="text-muted fw-semibold fs-7">Tipo de referencia</label>
                                    <div class="fw-bold fs-6">
                                        {{ $patient->referral_type ?: '—' }}
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="card shadow-sm">
                            <div class="card-header border-0">
                                <h3 class="card-title fw-bold text-dark">
                                    Seguimiento clínico
                                </h3>
                            </div>

                            <div class="card-body pt-4">

                                {{-- CITA --}}
                                <div class="mb-5">
                                    <label class="text-muted fw-semibold fs-7">
                                        Cita
                                    </label>
                                    <div class="fw-bold fs-6">
                                        @if($patient->appointment_date)
                                            {{ $patient->appointment_date->format('d/m/Y') }}

                                            @if($patient->appointment_time)
                                                {{ \Carbon\Carbon::parse($patient->appointment_time)->format('h:i A') }}
                                            @endif
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>

                                {{-- FECHA DE ATENCIÓN --}}
                                <div class="mb-5">
                                    <label class="text-muted fw-semibold fs-7">
                                        Fecha de atención
                                    </label>
                                    <div class="fw-bold fs-6">
                                        @if($patient->attention_date)
                                            {{ $patient->attention_date->format('d/m/Y') }}

                                            @if($patient->attention_time)
                                                {{ \Carbon\Carbon::parse($patient->attention_time)->format('h:i A') }}
                                            @endif
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                                {{-- DECISIÓN CLÍNICA --}}
                                @if($patient->procedure || $patient->attention_observations)
                                    <div class="separator my-5"></div>

                                    <h5 class="fw-bold mb-4">
                                        Decisión Clínica
                                    </h5>

                                    @if($patient->procedure)
                                        <div class="mb-4">
                                            <label class="text-muted fw-semibold fs-7">
                                                Procedimiento / Plan
                                            </label>
                                            <div class="fw-bold fs-6 text-dark">
                                                {{ $patient->procedure }}
                                            </div>
                                        </div>
                                    @endif

                                    @if($patient->attention_observations)
                                        <div>
                                            <label class="text-muted fw-semibold fs-7">
                                                Observaciones médicas
                                            </label>
                                            <div class="fw-semibold fs-7 text-gray-700">
                                                {{ $patient->attention_observations }}
                                            </div>
                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===================================================== --}}
            {{-- TAB 2: HISTÓRICO GLOBAL --}}
            {{-- ===================================================== --}}
            <div class="tab-pane fade" id="tab_historico">

                <div style="max-height: 650px; overflow-y: auto; padding-right: 15px;">

                    @forelse($patient->histories as $history)

                        <div class="d-flex mb-6">

                            <div class="me-4 mt-1">
                                <span class="bullet bullet-dot bg-primary h-12px w-12px"></span>
                            </div>

                            <div>

                                <div class="fw-bold text-dark mb-1">
                                    {{ $history->field_label }}
                                </div>

                                <div class="text-muted fs-7 mb-1">
                                    De:
                                    <span class="text-dark">
                                        {!! $history->old_value_formatted !!}

                                    </span>
                                    →
                                    <span class="text-dark fw-semibold">
                                        {!! $history->new_value_formatted !!}
                                    </span>
                                </div>

                                <div class="text-muted fs-8">
                                    {{ $history->created_at->format('d/m/Y H:i') }}
                                    @if($history->user)
                                        · {{ $history->user->name }}
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="separator my-4"></div>

                    @empty

                        <div class="text-muted">
                            No hay movimientos registrados.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>


</div>