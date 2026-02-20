@props([
    'isAdmin' => false,
    'providers' => [],
    'action' => '',
    'patient' => null,
])

<style>
    #patientCreateModal .modal-body {
        max-height: 65vh;
        overflow-y: auto;
    }
</style>

<div class="modal fade" id="patientCreateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <div>
                    <h5 id="patientModalTitle" class="modal-title mb-0"></h5>
                    <small class="text-muted">
                        Completa la información del paciente
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="patientForm"
                  method="POST"
                  action="{{ $patient ? route('admin.patients.update', $patient) : $action }}"
                  enctype="multipart/form-data">

                @csrf
                @if($patient)
                    @method('PUT')
                @endif

                <div class="modal-body">
                    <div class="row g-4">

                        {{-- PACIENTE --}}
                        <div class="col-12">
                            <b>Información del paciente</b>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ old('first_name', $patient->first_name ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Apellido *</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ old('last_name', $patient->last_name ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Celular *</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $patient->phone ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $patient->email ?? '') }}">
                        </div>

                        {{-- ADMIN --}}
                        @if($isAdmin)
                            <div class="col-md-12">
                                <label class="form-label">Proveedor *</label>
                                <select name="provider_id" class="form-select" required>
                                    <option value="">Selecciona proveedor</option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}"
                                            {{ old('provider_id', $patient->provider_id ?? '') == $provider->id ? 'selected' : '' }}>
                                            {{ $provider->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        {{-- SEGURO --}}
                        <div class="col-md-6">
                            <label class="form-label">Seguro</label>
                            <select name="insurance" class="form-select">
                                <option value="">Selecciona</option>
                                @foreach(['axxa','allianz','gnp','metlife','atlas','inbursa','sura','ve_por_mas','seguros_monterrey','seguros_banorte','mapfre','zurich','otro'] as $insurance)
                                    <option value="{{ $insurance }}"
                                        {{ old('insurance', $patient->insurance ?? '') == $insurance ? 'selected' : '' }}>
                                        {{ strtoupper(str_replace('_',' ',$insurance)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de póliza</label>
                            <input type="date" name="policy_date" class="form-control"
                                   value="{{ old('policy_date', optional($patient->policy_date ?? null)->format('Y-m-d')) }}">
                        </div>

                        {{-- REFERENTE --}}
                        <div class="col-12">
                            <b>Información del referente</b>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">¿Quién refiere? *</label>
                            <select name="referrer" class="form-select" required>
                                <option value="">Selecciona</option>
                                @foreach(['optometrista','oftalmologo','medico_general','otro'] as $ref)
                                    <option value="{{ $ref }}"
                                        {{ old('referrer', $patient->referrer ?? '') == $ref ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ',$ref)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipo de referido *</label>
                            <select name="referral_type" id="referralType" class="form-select" required>
                                @foreach(['consulta_general','cirugia_refractiva','catarata_cristalino','retina'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('referral_type', $patient->referral_type ?? '') == $type ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ',$type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- CLÍNICO DINÁMICO --}}
                        <div class="col-12" id="dynamicClinicalSection"></div>

                        {{-- DATOS CLÍNICOS --}}
                         <b class="mb-0">
                            Datos clínicos
                            <span class="text-muted">(opcional, si se cuenta con ellos)</span>
                        </b>

                        <div class="col-12">
                            <label class="form-label">Refracción / graduación</label>
                            <textarea name="refraction" class="form-control form-control-solid" rows="2">
{{ old('refraction', $patient->refraction ?? '') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Segmento anterior</label>
                            <textarea name="anterior_segment_findings" class="form-control form-control-solid" rows="2">
{{ old('anterior_segment_findings', $patient->anterior_segment_findings ?? '') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Segmento posterior</label>
                            <textarea name="posterior_segment_findings" class="form-control form-control-solid" rows="2">
{{ old('posterior_segment_findings', $patient->posterior_segment_findings ?? '') }}</textarea>
                        </div>

                        {{-- ARCHIVOS EXISTENTES --}}
                        @if($patient && $patient->files->count())
                            <div class="col-12">
                                <b>Archivos actuales</b>
                            </div>

                            @foreach($patient->files as $file)
                                <div class="col-12 d-flex justify-content-between align-items-center border p-2 rounded">
                                    <div>{{ $file->file_name }}</div>
                                    <div>
                                        <a href="{{ asset('storage/'.$file->file_path) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-light-primary">
                                            Ver
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-light-danger btn-delete-file"
                                                data-id="{{ $file->id }}">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- DROPZONE --}}
                        <div class="col-12">
                            <label class="form-label">Archivos del expediente</label>
                            <div class="dropzone" id="patientDropzone"></div>
                            <small class="text-muted">
                                Máximo 5 archivos (5MB cada uno)
                            </small>
                        </div>
                        {{-- OBSERVACIONES --}}
                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observations" class="form-control" rows="3">
{{ old('observations', $patient->observations ?? '') }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $patient ? 'Actualizar paciente' : 'Guardar paciente' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>