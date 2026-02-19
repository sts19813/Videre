<div class="modal fade" id="studiesModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Solicitar estudios complementarios</h5>
            </div>

            <div class="modal-body">
                <input type="hidden" id="studiesPatientId">

                <div class="mb-4">
                    <label class="form-label">Estudios solicitados *</label>
                    <textarea id="studiesRequested" class="form-control"></textarea>
                </div>

                <div>
                    <label class="form-label">Observaciones</label>
                    <textarea id="studiesNotes" class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-warning" id="saveStudies">
                    Solicitar estudios
                </button>
            </div>

        </div>
    </div>
</div>
