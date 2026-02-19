<div class="modal fade" id="treatmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Propuesta de tratamiento</h5>
            </div>

            <div class="modal-body">
                <input type="hidden" id="treatmentPatientId">

                <div class="mb-4">
                    <label class="form-label">Plan terapéutico *</label>
                    <textarea id="treatmentPlan" class="form-control"></textarea>
                </div>

                <div>
                    <label class="form-label">Indicaciones adicionales</label>
                    <textarea id="treatmentNotes" class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="saveTreatment">
                    Guardar tratamiento
                </button>
            </div>

        </div>
    </div>
</div>
