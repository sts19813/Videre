<div class="modal fade" id="counterReferenceModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Contrarreferencia</h5>
            </div>

            <div class="modal-body">
                <input type="hidden" id="counterReferencePatientId">

                <div>
                    <label class="form-label">Motivo clínico *</label>
                    <textarea id="counterReferenceNotes"
                              class="form-control"
                              rows="4"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">Cancelar</button>

                <button class="btn btn-dark"
                        id="saveCounterReference">
                    Confirmar
                </button>
            </div>

        </div>
    </div>
</div>
