<script>
    $('#referralType').on('change', function () {
        renderClinicalForm(this.value);
    });


    function renderClinicalForm(type) {
        let html = '';

        /* =====================================================
           CONSULTA GENERAL
        ===================================================== */
        if (type === 'consulta_general') {
            html = `
                    <div class="card border-warning p-4">
                        <h6 class="fw-bold mb-3">Información específica - Consulta general</h6>

                        <div class="mb-3">
                            <label class="form-label">Motivo de consulta / síntomas *</label>
                            <textarea name="clinical_data[motivo_consulta]" 
                                      class="form-control" 
                                      rows="3" 
                                      required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Presión intraocular (mmHg)</label>
                            <input type="text" 
                                   name="clinical_data[presion_intraocular]" 
                                   class="form-control" 
                                   placeholder="Ej: 15 mmHg">
                        </div>
                    </div>`;
        }

        /* =====================================================
           CIRUGÍA REFRACTIVA
        ===================================================== */
        if (type === 'cirugia_refractiva') {
            html = `
                    <div class="card border-primary p-4">
                        <h6 class="fw-bold mb-3">Información específica - Cirugía refractiva</h6>

                        <div class="mb-3">
                            <label class="form-label">¿Usa lentes de contacto?</label><br>
                            <label><input type="radio" name="clinical_data[usa_lentes]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[usa_lentes]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Antecedentes familiares de queratocono?</label><br>
                            <label><input type="radio" name="clinical_data[queratocono]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[queratocono]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Embarazo o lactancia activa?</label><br>
                            <label><input type="radio" name="clinical_data[embarazo]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[embarazo]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Uso de isotretinoína en los últimos 6 meses?</label><br>
                            <label><input type="radio" name="clinical_data[isotretinoina]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[isotretinoina]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Padecimiento actual / síntomas</label>
                            <textarea name="clinical_data[padecimiento_actual]" 
                                      class="form-control" 
                                      rows="3"></textarea>
                        </div>
                    </div>`;
        }

        /* =====================================================
           CATARATA / CRISTALINO
        ===================================================== */
        if (type === 'catarata_cristalino') {
            html = `
                    <div class="card border-info p-4">
                        <h6 class="fw-bold mb-3">Información específica - Catarata / Cristalino</h6>

                        <div class="mb-3">
                            <label class="form-label">¿Diabetes, hipertensión o glaucoma?</label><br>
                            <label><input type="radio" name="clinical_data[enfermedades]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[enfermedades]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Cirugías oculares previas?</label><br>
                            <label><input type="radio" name="clinical_data[cirugias_previas]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[cirugias_previas]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Síntomas o padecimiento actual</label>
                            <textarea name="clinical_data[sintomas]" 
                                      class="form-control" 
                                      rows="3"></textarea>
                        </div>
                    </div>`;
        }

        /* =====================================================
           RETINA
        ===================================================== */
        if (type === 'retina') {
            html = `
                    <div class="card border-success p-4">
                        <h6 class="fw-bold mb-3">Información específica - Retina</h6>

                        <div class="mb-3">
                            <label class="form-label">¿Diabetes o hipertensión?</label><br>
                            <label><input type="radio" name="clinical_data[diabetes_hipertension]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[diabetes_hipertension]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Cirugías oculares previas?</label><br>
                            <label><input type="radio" name="clinical_data[cirugias_previas]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[cirugias_previas]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Traumatismo ocular reciente?</label><br>
                            <label><input type="radio" name="clinical_data[traumatismo]" value="si"> Sí</label>
                            <label class="ms-3"><input type="radio" name="clinical_data[traumatismo]" value="no"> No</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Síntomas o padecimiento actual</label>
                            <textarea name="clinical_data[sintomas]" 
                                      class="form-control" 
                                      rows="3"></textarea>
                        </div>
                    </div>`;
        }

        $('#dynamicClinicalSection').html(html);
    }


</script>