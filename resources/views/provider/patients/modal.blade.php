<div class="modal fade" id="patientCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title">Agregar paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('provider.patients.store') }}">
                @csrf

                <div class="modal-body">
                    <div class="row g-4">

                        {{-- REFERENTE --}}
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

                        {{-- TIPO REFERIDO --}}
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

                        {{-- PACIENTE --}}
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

                        {{-- CLÍNICO DINÁMICO --}}
                        <div class="col-12" id="dynamicClinicalSection"></div>

                        {{-- OBSERVACIONES --}}
                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
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