<div class="modal fade" id="surgeryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Propuesta quirúrgica</h5>
            </div>

            <div class="modal-body">
                <input type="hidden" id="surgeryPatientId">

                <div class="mb-4">
                    <label class="form-label">Tipo de cirugía *</label>
                    <select id="surgeryType" class="form-select">
                        <option value="">Selecciona</option>
                        <option>Cirugía refractiva LASIK</option>
                        <option>Facoemulsificación</option>
                        <option>Implante de lente intraocular</option>
                        <option>Vitrectomía</option>
                        <option>Cirugía de retina</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Justificación clínica</label>
                    <textarea id="surgeryNotes" class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-danger" id="saveSurgeryProposal">
                    Confirmar propuesta
                </button>
            </div>
        </div>
    </div>
</div>
