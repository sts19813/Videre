<div class="modal fade" id="patientCreateModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="createPatientForm">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Agregar paciente</h5>
                    <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control">
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

                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observations" class="form-control" rows="3"></textarea>
                        </div>

                    </div>
                </div>

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
