@extends('layouts.app')

@section('title', 'Admin | Dashboard')

@section('content')

    {{-- HEADER --}}
    <div class="mb-4">
        <h1 class="h4 fw-semibold text-dark mb-1">Portal Videre</h1>
        <p class="text-muted mb-0">Panel de administración</p>
    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-5">

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-people fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Proveedores</div>
                        <div class="fs-4 fw-semibold">{{ $stats['providers'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-user fs-3 text-info"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pacientes enviados</div>
                        <div class="fs-4 fw-semibold">{{ $stats['patients_sent'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-check-circle fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pacientes atendidos</div>
                        <div class="fs-4 fw-semibold">{{ $stats['patients_attended'] }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TABS --}}
    <ul class="nav nav-pills d-flex mb-4 gap-2" role="tablist">

        <li class="nav-item flex-fill">
            <button class="nav-link active w-100 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-patients">
                <i class="ki-outline ki-user me-2"></i> Pacientes
            </button>
        </li>

        <li class="nav-item flex-fill">
            <button class="nav-link w-100 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-providers">
                <i class="ki-outline ki-people me-2"></i> Proveedores
            </button>
        </li>

        <li class="nav-item flex-fill">
            <button class="nav-link w-100 fw-semibold" data-bs-toggle="pill" data-bs-target="#tab-users">
                <i class="ki-outline ki-shield-user me-2"></i> Usuarios Videre
            </button>
        </li>

    </ul>


    <div class="tab-content">

        {{-- ===================== PACIENTES ===================== --}}
        <div class="tab-pane fade show active" id="tab-patients">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pacientes</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#patientCreateModal">
                        <i class="ki-outline ki-plus me-1"></i> Agregar paciente
                    </button>

                </div>

                <div class="card-body p-0">
                    <div class="px-6 py-4">
                        <table id="patientsTable" class="table table-row-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fw-bold text-muted">
                                    <th>Nombre</th>
                                    <th>Proveedor</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th class="text-center">Estatus</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $patient)
                                    <tr data-id="{{ $patient->id }}">
                                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                        <td>{{ $patient->provider->user->name ?? '-' }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>{{ $patient->email }}</td>

                                        <td class="text-center">
                                            <select class="form-select form-select-sm patient-status">
                                                <option value="pendiente" @selected($patient->status === 'pendiente')>Pendiente
                                                </option>
                                                <option value="cita_agendada" @selected($patient->status === 'cita_agendada')>Con
                                                    cita</option>
                                                <option value="atendido" @selected($patient->status === 'atendido')>Atendido
                                                </option>
                                                <option value="cancelado" @selected($patient->status === 'cancelado')>Cancelado
                                                </option>
                                            </select>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light-primary btn-view-patient">
                                                <i class="ki-outline ki-eye fs-5"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-6">
                                            No hay pacientes registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== PROVEEDORES ===================== --}}
        <div class="tab-pane fade" id="tab-providers">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Proveedores</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#providerCreateModal">
                        <i class="ki-outline ki-plus me-1"></i> Agregar proveedor
                    </button>

                </div>

                <div class="card-body p-0">
                    <div class="px-6 py-4">
                        <table id="providersTable" class="table table-row-bordered align-middle gy-4">
                            <thead class="table-light">
                                <tr class="fw-bold text-muted">
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th class="text-center">Estatus</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($providers as $provider)
                                    <tr data-id="{{ $provider->id }}">
                                        <td class="fw-semibold">
                                            {{ $provider->user->name }}
                                        </td>

                                        <td>{{ $provider->user->email }}</td>

                                        {{-- ESTATUS --}}
                                        <td class="text-center">
                                            <select class="form-select form-select-sm provider-status w-auto mx-auto">
                                                <option value="1" @selected($provider->is_active)>Activo</option>
                                                <option value="0" @selected(!$provider->is_active)>Inactivo</option>
                                            </select>
                                        </td>

                                        {{-- ACCIONES --}}
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light-primary btn-view-provider">
                                                <i class="ki-outline ki-eye fs-5"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- ===================== USUARIOS ===================== --}}
        <div class="tab-pane fade" id="tab-users">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Usuarios Videre</h5>
                    <button class="btn btn-primary btn-sm">
                        <i class="ki-outline ki-plus me-1"></i> Agregar usuario
                    </button>
                </div>

                <div class="card-body p-0">
                    <table id="usersTable" class="table table-row-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr class="fw-bold text-muted">
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th class="text-center">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-light-primary">
                                            Administrador
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="patientDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle del paciente</h5>
                    <button class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-2"></i>
                    </button>
                </div>
                <div class="modal-body" id="patientDetailContent">
                    <div class="text-center text-muted py-10">Cargando...</div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.patients.modal-create')


    <div class="modal fade" id="providerCreateModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form id="createProviderForm" method="POST" action="{{ route('admin.providers.store') }}">
                    @csrf
                    <input type="hidden" name="password" id="passwordField">

                    <div class="modal-header">
                        <h5 class="modal-title">Agregar proveedor</h5>
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label">Nombre del usuario</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Clínica</label>
                                <input type="text" name="clinic_name" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Contraseña generada</label>
                                <div class="input-group">
                                    <input type="text" id="generatedPassword" class="form-control" readonly>
                                    <button type="button" class="btn btn-light" id="copyPassword">
                                        <i class="ki-outline ki-copy"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Crear proveedor</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let table2 = null;

        $(document).ready(function () {

            let table = $('#patientsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                language: { url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json' },
                dom: "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
            });

            table2 = $('#providersTable').DataTable({
                responsive: true,
                pageLength: 10,
                searching: true,
                ordering: true,
                lengthChange: false,
                language: { url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json' },
                dom: "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
            });
        });
        //cambio de estatus
        $(document).on('change', '.patient-status', function () {
            let row = $(this).closest('tr');
            let patientId = row.data('id');
            let status = $(this).val();

            $.ajax({
                url: `/admin/patients/${patientId}/status`,
                method: 'PUT',
                data: {
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    toastr.success('Estatus actualizado');
                },
                error: function () {
                    toastr.error('Error al actualizar');
                }
            });
        });

        //vista detalle paciente
        $(document).on('click', '.btn-view-patient', function () {
            let patientId = $(this).closest('tr').data('id');

            $('#patientDetailModal').modal('show');
            $('#patientDetailContent').html('<div class="text-center py-10">Cargando...</div>');

            $.get(`/admin/patients/${patientId}`, function (html) {
                $('#patientDetailContent').html(html);
            });
        });


        //crear paciente
        $('#createPatientForm').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);

            $.post("{{ route('admin.patients.store') }}", form.serialize())
                .done(() => {
                    bootstrap.Modal.getInstance(
                        document.getElementById('patientCreateModal')
                    ).hide();

                    location.reload(); // o DataTable ajax.reload()
                })
                .fail(err => {
                    alert('Error al guardar paciente');
                });
        });

        //cambiar estatus al provedor
        $(document).on('change', '.provider-status', function () {
            let row = $(this).closest('tr');
            let providerId = row.data('id');

            $.ajax({
                url: `/admin/providers/${providerId}/status`,
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_active: this.value
                }
            });
        });
        //crea el proveedor desde el admin
        $('#createProviderForm').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {

                        // Guardar tab activo
                        localStorage.setItem('adminActiveTab', 'tab-providers');

                        // Cerrar modal
                        const modal = bootstrap.Modal.getInstance(
                            document.getElementById('providerCreateModal')
                        );
                        modal.hide();

                        toastr.success('Proveedor creado correctamente');

                        // Recargar página completa
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                },
                error: function (xhr) {
                    let msg = 'Error al crear proveedor';

                    if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    }

                    toastr.error(msg);
                }
            });
        });


        //para generar contraseña aleatoria
        function generatePassword(length = 14) {
            const chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%^&*";
            let password = "";
            for (let i = 0; i < length; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }

        $('#providerCreateModal').on('shown.bs.modal', function () {
            let pwd = generatePassword();

            // Mostrarla
            $('#generatedPassword').val(pwd);

            // Enviarla al backend
            $('#passwordField').val(pwd);
        });


        $('#copyPassword').on('click', function () {
            let input = document.getElementById('generatedPassword');
            let password = input.value;

            if (!password) {
                toastr.error('No hay contraseña para copiar');
                return;
            }

            // Seleccionar texto
            input.removeAttribute('readonly');
            input.select();
            input.setSelectionRange(0, 99999);
            input.setAttribute('readonly', true);

            // Clipboard moderno
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(password).then(() => {
                    toastr.success('Contraseña copiada');
                }).catch(() => {
                    fallbackCopy();
                });
            } else {
                fallbackCopy();
            }

            function fallbackCopy() {
                try {
                    document.execCommand('copy');
                    toastr.success('Contraseña copiada');
                } catch (e) {
                    toastr.error('No se pudo copiar la contraseña');
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function () {

            const savedTab = localStorage.getItem('adminActiveTab');

            if (savedTab) {
                const trigger = document.querySelector(
                    `button[data-bs-target="#${savedTab}"]`
                );

                if (trigger) {
                    new bootstrap.Tab(trigger).show();
                }

                localStorage.removeItem('adminActiveTab');
            }
        });
    </script>
@endpush