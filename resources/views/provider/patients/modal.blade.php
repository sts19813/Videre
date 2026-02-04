<div class="dialog" id="patientDialog">
    <div class="dialog-overlay"></div>

    <div class="dialog-content max-w-3xl">
        <div class="card">

            <form method="POST" action="{{ route('provider.patients.store') }}">
                @csrf

                {{-- Header --}}
                <div class="card-header">
                    <h3 class="card-title">Agregar paciente</h3>

                    <button type="button"
                        class="btn btn-sm btn-icon btn-light"
                        data-kt-dialog-dismiss>
                        <i class="ki-duotone ki-cross"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="card-body grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="form-label">Nombre</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>

                    <div>
                        <label class="form-label">Apellido</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>

                    <div>
                        <label class="form-label">Celular</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div>
                        <label class="form-label">Correo</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="md:col-span-2">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observations" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="card-footer flex justify-end gap-3">
                    <button type="button"
                        class="btn btn-light"
                        data-kt-dialog-dismiss>
                        Cancelar
                    </button>

                    <button class="btn btn-primary">
                        Guardar paciente
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
