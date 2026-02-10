<div class="modal fade" id="providerCreateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Agregar proveedor</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="createProviderForm" method="POST" action="{{ route('admin.providers.store') }}">
                @csrf

                <div class="modal-body">

                    {{-- Tipo proveedor --}}
                    <div class="mb-3">
                        <label class="form-label">Tipo de proveedor</label>
                        <select name="provider_type" class="form-select" required>
                            <option value="">Selecciona</option>
                            <option value="doctor">Doctor</option>
                            <option value="optica">Óptica</option>
                        </select>
                    </div>

                    {{-- Nombre --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>

                    {{-- Empresa --}}
                    <div class="mb-3">
                        <label class="form-label">Empresa / Consultorio</label>
                        <input type="text" name="clinic_name" class="form-control" required>
                    </div>

                    {{-- Teléfono --}}
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    {{-- Password generado --}}
                    <div class="mb-3">
                        <label class="form-label">Contraseña generada</label>
                        <div class="input-group">
                            <input type="text" id="generatedPassword" class="form-control" readonly>
                            <button type="button" id="copyPassword" class="btn btn-light">
                                Copiar
                            </button>
                        </div>
                        <input type="hidden" name="password" id="passwordField">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button class="btn btn-primary">
                        Crear proveedor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>