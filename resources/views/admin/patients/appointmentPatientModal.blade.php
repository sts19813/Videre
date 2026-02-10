<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Agendar cita</h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="appointmentPatientId">

                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" id="appointmentDate" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hora</label>
                    <input type="time" id="appointmentTime" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="saveAppointment">
                    Guardar cita
                </button>
            </div>

        </div>
    </div>
</div>