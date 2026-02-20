@extends('layouts.app')

@section('title', 'Dashboard | Videre')

@section('content')

    {{-- Page Header --}}
    <div class="mb-4">
        <h1 class="h4 fw-semibold text-dark mb-1">Portal de Afiliados</h1>
        <p class="text-muted mb-0">Clínica Visual</p>
    </div>

    {{-- Stats --}}
    <div class="row g-4 mb-4">

        {{-- Pacientes enviados --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">

                        <i class="ki-outline ki-user fs-3 text-primary"></i>

                    </div>
                    <div>
                        <div class="text-muted small">Pacientes enviados</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['sent'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pendientes --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-time text-warning fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pendientes</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['pending'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Con cita --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-calendar text-info fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Con cita</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['scheduled'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Atendidos --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Atendidos</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['attended'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Patients --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de pacientes</h5>

            <button type="button" class="btn btn-primary btn-add-patient" data-bs-toggle="modal"
                data-bs-target="#patientCreateModal">
                Agregar paciente
            </button>
        </div>

        <div class="card-body pt-0">
            <table id="patientsTable" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Observaciones</th>
                        <th class="text-center">Estatus</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($patients as $patient)
                        <tr data-id="{{ $patient->id }}">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ki-duotone ki-user fs-3 text-primary"></i>
                                    <span class="fw-semibold">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </span>
                                </div>
                            </td>

                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->email }}</td>
                            <td class="text-muted">{{ $patient->observations }}</td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-light-warning btn-edit-patient" data-id="{{ $patient->id }}"
                                    title="Editar">
                                    <i class="ki-outline ki-pencil fs-5"></i>
                                </button>

                                <button class="btn btn-sm btn-light-primary btn-view-patient" data-id="{{ $patient->id }}"
                                    title="Ver registro">
                                    <i class="ki-outline ki-eye fs-5"></i>
                                </button>
                                @php
                                    $statusMap = [
                                        'pendiente' => ['warning', 'Pendiente'],
                                        'cita_agendada' => ['info', 'Con cita'],
                                        'atendido' => ['success', 'Atendido'],
                                        'cancelado' => ['danger', 'Cancelado'],
                                    ];
                                    [$color, $label] = $statusMap[$patient->status] ?? ['secondary', 'Desconocido'];
                                @endphp

                                <span class="badge badge-light-{{ $color }} fw-bold px-4 py-2">
                                    {{ $label }}
                                </span>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    <x-patient-create-modal :is-admin="false" action="{{ route('provider.patients.store') }}" />

    <div class="modal fade" id="patientDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle del paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body pt-0" id="patientDetailContent">
                    <div class="text-center py-10">Cargando...</div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        let uploadedFiles = [];
        Dropzone.autoDiscover = false;

        let myDropzone = new Dropzone("#patientDropzone", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 5,
            maxFiles: 5,
            maxFilesize: 5,
            addRemoveLinks: true,
            acceptedFiles: ".jpg,.jpeg,.png,.pdf,.doc,.docx",

            init: function () {

                this.on("addedfile", function (file) {
                    if (!file.existing) {
                        uploadedFiles.push(file);
                    }
                });

                this.on("removedfile", function (file) {
                    uploadedFiles = uploadedFiles.filter(f => f !== file);
                });
            }
        });

        $(document).ready(function () {

            $('#patientsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json',
                    emptyTable: 'No hay pacientes registrados'
                },
                dom:
                    "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
            });

        });

        /* ===============================
           SUBMIT CREAR / EDITAR
        =============================== */
        $(document).on('submit', '#patientForm', function (e) {

            e.preventDefault();

            let form = this;
            let actionUrl = $(form).attr('action');
            let formData = new FormData(form);

            uploadedFiles.forEach((file) => {
                formData.append("files[]", file);
            });

            $.ajax({
                url: actionUrl,
                method: 'POST', // Laravel detecta _method si es PUT
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {

                    bootstrap.Modal.getInstance(
                        document.getElementById('patientCreateModal')
                    ).hide();

                    toastr.success('Paciente guardado correctamente');

                    setTimeout(() => location.reload(), 400);
                },
                error: function (xhr) {

                    if (xhr.status === 422) {

                        Object.values(xhr.responseJSON.errors).forEach(messages => {
                            messages.forEach(msg => toastr.error(msg));
                        });

                    } else {
                        toastr.error('Error al guardar paciente');
                    }
                }
            });
        });


        /* ===============================
           EDITAR PACIENTE
        =============================== */
        $(document).on('click', '.btn-edit-patient', function () {

            const patientId = $(this).data('id');

            resetPatientModal();

            $.get(`/provider/patients/${patientId}/edit`, function (data) {

                const form = $('#patientForm');

                $('#patientModalTitle').text('Editar paciente');

                form.attr('action', `/provider/patients/${patientId}`);

                if (!form.find('input[name="_method"]').length) {
                    form.append('<input type="hidden" name="_method" value="PUT">');
                }

                form.find('[name="first_name"]').val(data.first_name);
                form.find('[name="last_name"]').val(data.last_name);
                form.find('[name="phone"]').val(data.phone);
                form.find('[name="email"]').val(data.email);
                form.find('[name="provider_id"]').val(data.provider_id);
                form.find('[name="insurance"]').val(data.insurance);
                form.find('[name="referrer"]').val(data.referrer);
                if (data.policy_date) {
                    const date = data.policy_date.split('T')[0];
                    form.find('[name="policy_date"]').val(date);
                }

                form.find('[name="referral_type"]').val(data.referral_type);

                renderClinicalForm(data.referral_type);

                if (data.clinical_data) {
                    Object.keys(data.clinical_data).forEach(key => {

                        const value = data.clinical_data[key];
                        const field = form.find(`[name="clinical_data[${key}]"]`);

                        if (field.attr('type') === 'radio') {
                            form.find(`[name="clinical_data[${key}]"][value="${value}"]`)
                                .prop('checked', true);
                        } else {
                            field.val(value);
                        }

                    });
                }

                form.find('[name="refraction"]').val(data.refraction);
                form.find('[name="anterior_segment_findings"]').val(data.anterior_segment_findings);
                form.find('[name="posterior_segment_findings"]').val(data.posterior_segment_findings);
                form.find('[name="observations"]').val(data.observations);

                // Limpiar Dropzone antes de cargar archivos
                if (myDropzone) {
                    myDropzone.removeAllFiles(true);
                    uploadedFiles = [];

                    if (data.files) {
                        data.files.forEach(file => {

                            let mockFile = {
                                name: file.file_name,
                                size: file.file_size * 1024,
                                existing: true
                            };

                            mockFile.accepted = true;
                            mockFile.status = Dropzone.SUCCESS;

                            myDropzone.emit("addedfile", mockFile);
                            myDropzone.emit("thumbnail", mockFile, "/storage/" + file.file_path);
                            myDropzone.emit("complete", mockFile);

                            // MUY IMPORTANTE:
                            myDropzone.files.push(mockFile);



                            mockFile.previewElement.classList.add("dz-success");
                            mockFile.previewElement.classList.add("dz-complete");
                        });
                    }
                }

                $('#patientCreateModal').modal('show');

            });
        });

        $(document).on('click', '.btn-add-patient', function () {
            resetPatientModal();
        });

        /* ===============================
           RESET MODAL
        =============================== */
        function resetPatientModal() {

            const form = $('#patientForm');

            form.trigger('reset');
            form.find('input[name="_method"]').remove();

            form.attr('action', "{{ route('provider.patients.store') }}");

            $('#patientModalTitle').text('Agregar paciente');

            $('#dynamicClinicalSection').html('');

            uploadedFiles = [];

            if (myDropzone) {
                myDropzone.removeAllFiles(true);
            }
        }
         $(document).on('click', '.btn-view-patient', function () {

            const patientId = $(this).data('id');

            console.log(patientId); // verifica

            $('#patientDetailModal').modal('show');
            $('#patientDetailContent').html(
                '<div class="text-center py-10">Cargando...</div>'
            );

            $.get(`/provider/patients/${patientId}`, function (html) {
                $('#patientDetailContent').html(html);
            });

        });

    </script>

    @include('components.tipo-de-referido')
@endpush