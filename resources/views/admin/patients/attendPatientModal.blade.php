<div class="modal fade" id="attendPatientModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Atender paciente</h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="attendPatientId">

                <div class="mb-4">
                    <label class="form-label">Fecha de atención *</label>
                    <input type="date" id="attentionDate" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Hora de atención *</label>
                    <input type="time" id="attentionTime" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Procedimiento / Estudio ocular *</label>
                    <select id="procedure" class="form-select" required>
                        <option value="">Selecciona un procedimiento</option>
                        <option>Examen visual completo</option>
                        <option>Agudeza visual</option>
                        <option>Fondo de ojo</option>
                        <option>Tonometría</option>
                        <option>Retinografía</option>
                        <option>OCT</option>
                        <option>Campimetría visual</option>
                        <option>Topografía corneal</option>
                        <option>Adaptación de lentes de contacto</option>
                        <option>Evaluación preoperatoria</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Observaciones</label>
                    <textarea id="attentionObservations" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-success" id="saveAttention">
                    Guardar atención
                </button>
            </div>

        </div>
    </div>
</div>