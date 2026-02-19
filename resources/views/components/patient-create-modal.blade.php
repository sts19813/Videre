@props([
    'isAdmin' => false,
    'providers' => [],
    'action' => '',
])

<style>
    #patientCreateModal .modal-body {
        max-height: 65vh;
        overflow-y: auto;
    }
</style>

<div class="modal fade" id="patientCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">Agregar paciente</h5>
                    <small class="text-muted">
                        Completa la información del paciente para enviarlo a Videre
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- FORM --}}
            <form id="createPatientForm" method="POST" action="{{ $action }}">
                @csrf

                <div class="modal-body">
                    <div class="row g-4">

                        {{-- PACIENTE --}}
                        <div class="col-12 ">
                            <b>Información del paciente</b>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Apellido *</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Celular *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        {{-- ADMIN ONLY --}}
                        @if($isAdmin)
                            <div class="col-md-12">
                                <label class="form-label">Proveedor *</label>
                                <select name="provider_id" class="form-select" required>
                                    <option value="">Selecciona proveedor</option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}">
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
                                <option value="axxa">AXXA</option>
                                <option value="allianz">ALLIANZ</option>
                                <option value="gnp">GNP</option>
                                <option value="metlife">METLIFE</option>
                                <option value="atlas">ATLAS</option>
                                <option value="inbursa">INBURSA</option>
                                <option value="sura">SURA</option>
                                <option value="ve_por_mas">VE POR MÁS</option>
                                <option value="seguros_monterrey">SEGUROS MONTERREY</option>
                                <option value="seguros_banorte">BANORTE</option>
                                <option value="mapfre">MAPFRE</option>
                                <option value="zurich">ZURICH</option>
                                <option value="otro">OTRO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de póliza</label>
                            <input type="date" name="policy_date" class="form-control">
                        </div>

                        {{-- REFERENTE --}}
                        <div class="col-12">
                            <b>Información del referente</b>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">¿Quién refiere? *</label>
                            <select name="referrer" class="form-select" required>
                                <option value="">Selecciona</option>
                                <option value="optometrista">Optometrista</option>
                                <option value="oftalmologo">Oftalmólogo</option>
                                <option value="medico_general">Médico general</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipo de referido *</label>
                            <select name="referral_type" id="referralType" class="form-select" required>
                                <option value="">Selecciona</option>
                                <option value="consulta_general">Consulta general</option>
                                <option value="cirugia_refractiva">Cirugía refractiva</option>
                                <option value="catarata_cristalino">Catarata / Cristalino</option>
                                <option value="retina">Retina</option>
                            </select>
                        </div>

                        

                        {{-- CLÍNICO DINÁMICO --}}
                        <div class="col-12" id="dynamicClinicalSection"></div>

                        {{-- DATOS CLÍNICOS (OPCIONAL) --}}
            
                        <b class="mb-0">
                            Datos clínicos
                            <span class="text-muted">(opcional, si se cuenta con ellos)</span>
                        </b>
                    

                        {{-- Refracción / graduación --}}
                        <div class="mb-0">
                            <label class="form-label">Refracción / graduación</label>
                            <textarea
                                class="form-control form-control-solid"
                                name="refraction"
                                rows="2"
                                placeholder="Ej: OD: -2.00 -0.50 x 180, OI: -1.75 -0.25 x 90"
                            ></textarea>
                        </div>

                        {{-- Hallazgos segmento anterior --}}
                        <div class="mb-0">
                            <label class="form-label">Hallazgos segmento anterior</label>
                            <textarea
                                class="form-control form-control-solid"
                                name="anterior_segment_findings"
                                rows="2"
                                placeholder="Describe los hallazgos"
                            ></textarea>
                        </div>

                        {{-- Hallazgos segmento posterior --}}
                        <div class="mb-5">
                            <label class="form-label">Hallazgos segmento posterior</label>
                            <textarea
                                class="form-control form-control-solid"
                                name="posterior_segment_findings"
                                rows="2"
                                placeholder="Describe los hallazgos"
                            ></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Archivos del expediente</label>
                            <div class="dropzone" id="patientDropzone"></div>
                            <small class="text-muted">
                                Máximo 5 archivos (5MB cada uno). JPG, PNG, PDF, DOC, DOCX
                            </small>
                        </div>
                        {{-- OBSERVACIONES --}}
                        <div class="col-12">
                            <b>Observaciones</b>
                            <textarea name="observations" class="form-control" rows="3"></textarea>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Guardar paciente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
