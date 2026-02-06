<div class="modal fade" id="patientCreateModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="createPatientForm">
                @csrf

                <div class="modal-body">
                    <div class="row g-4">

                        {{-- REFERENTE --}}
                        <div class="col-md-6">
                            <label class="form-label">¿Quién refiere? *</label>
                            <select name="referrer" class="form-select" required>
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
                                <option value="gnp">GNP</option>
                                <option value="metlife">METLIFE</option>
                                <option value="mapfre">MAPFRE</option>
                                <option value="otro">OTRO</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Proveedor</label>
                            <select name="provider_id" class="form-select" required>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}">
                                        {{ $provider->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Fecha de póliza</label>
                            <input type="date" name="policy_date" class="form-control">
                        </div>

                        {{-- CONTENEDOR DINÁMICO --}}
                        <div class="col-12" id="dynamicClinicalSection"></div>

                        <div class="col-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observations" class="form-control"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>


        </div>
    </div>
</div>