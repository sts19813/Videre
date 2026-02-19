/* =========================================================
   VARIABLES GLOBALES
========================================================= */
let tablePatients = null;
let tableProviders = null;
let tableUsers = null;
Dropzone.autoDiscover = false;

let uploadedFiles = [];

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
            uploadedFiles.push(file);
        });

        this.on("removedfile", function (file) {
            uploadedFiles = uploadedFiles.filter(f => f !== file);
        });
    }
});

/* =========================================================
   DATATABLES
========================================================= */
$(document).ready(function () {

    tablePatients = $('#patientsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json'
        },
        dom:
            "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
            "<'row'<'col-12'tr>>" +
            "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
    });

    tableProviders = $('#providersTable').DataTable({
        responsive: true,
        pageLength: 10,
        searching: true,
        ordering: true,
        lengthChange: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json'
        },
        dom:
            "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
            "<'row'<'col-12'tr>>" +
            "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
    });

    tableUsers = $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        searching: true,
        ordering: true,
        lengthChange: true,
        info: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json'
        },
        dom:
            "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
            "<'row'<'col-12'tr>>" +
            "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
    });


});

/* =========================================================
   PACIENTES – reagendar cita desde con cita
========================================================= */
$(document).on('click', '.btn-reschedule-appointment', function () {
    const row = $(this).closest('tr');
    openAppointmentModal(row.data('id'));
});


/* =========================================================
   PACIENTES – cancelar desde pendiente
========================================================= */
$(document).on('click', '.btn-cancel-patient', function () {

    const patientId = $(this).closest('tr').data('id');

    Swal.fire({
        title: '¿Cancelar paciente?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'No'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $.ajax({
            url: `/admin/patients/${patientId}/cancel`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            success: function () {
                toastr.success('Paciente cancelado');
                localStorage.setItem('adminActiveTab', 'tab-patients');
                location.reload();
            },
            error: function () {
                toastr.error('Error al cancelar paciente');
            }
        });
    });
});


/* =========================================================
   PACIENTES – AGENDAR CITA
========================================================= */
$(document).on('click', '.btn-schedule-appointment', function () {
    const row = $(this).closest('tr');
    openAppointmentModal(row.data('id'));
});

$('#saveAppointment').on('click', function () {

    const patientId = $('#appointmentPatientId').val();
    const date = $('#appointmentDate').val();
    const time = $('#appointmentTime').val();

    if (!date || !time) {
        toastr.error('Fecha y hora son obligatorias');
        return;
    }

    $.ajax({
        url: `/admin/patients/${patientId}/schedule`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        data: {
            appointment_date: date,
            appointment_time: time
        },
        success: function () {
            toastr.success('Cita agendada');

            localStorage.setItem('adminActiveTab', 'tab-patients');
            location.reload();
        },
        error: function () {
            toastr.error('Error al agendar cita');
        }
    });
});


/* =========================================================
   PACIENTES – DETALLE
========================================================= */
$(document).on('click', '.btn-view-patient', function () {
    const patientId = $(this).closest('tr').data('id');

    $('#patientDetailModal').modal('show');
    $('#patientDetailContent').html(
        '<div class="text-center py-10">Cargando...</div>'
    );

    $.get(`/admin/patients/${patientId}`, function (html) {
        $('#patientDetailContent').html(html);
    });
});


/* =========================================================
   PACIENTES – CREAR
========================================================= */
$('#createPatientForm').on('submit', function (e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    uploadedFiles.forEach((file) => {
        formData.append("files[]", file);
    });

    $.ajax({
        url: '/admin/patients',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function () {

            bootstrap.Modal.getInstance(
                document.getElementById('patientCreateModal')
            ).hide();

            toastr.success('Paciente creado correctamente');

            localStorage.setItem('adminActiveTab', 'tab-patients');

            setTimeout(() => {
                location.reload();
            }, 400);
        },
        error: function (xhr) {

            let msg = 'Error al guardar paciente';

            if (xhr.responseJSON?.message) {
                msg = xhr.responseJSON.message;
            }

            toastr.error(msg);
        }
    });
});


/* =========================================================
   PROVEEDORES – CAMBIAR ESTATUS
========================================================= */
$(document).on('change', '.provider-status', function () {
    const row = $(this).closest('tr');
    const providerId = row.data('id');
    const select = this;

    $.ajax({
        url: `/admin/providers/${providerId}/status`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        data: {
            is_active: select.value
        },
        success: function () {
            toastr.success('Estatus actualizado correctamente');
        },
        error: function () {
            toastr.error('No se pudo actualizar el estatus');

            // opcional: regresar el select a su valor anterior
            select.value = select.dataset.previous;
        }
    });
});

/* Guardar valor previo por si falla */
$(document).on('focus', '.provider-status', function () {
    this.dataset.previous = this.value;
});



/* =========================================================
   paciente – pasar de con cita a atendido
========================================================= */
// Abrir modal de atención
$(document).on('click', '.btn-attend-patient', function () {
    const patientId = $(this).closest('tr').data('id');

    $('#attendPatientId').val(patientId);
    $('#attentionDate').val('');
    $('#attentionTime').val('');
    $('#procedure').val('');
    $('#attentionObservations').val('');

    $('#attendPatientModal').modal('show');
});

// Guardar atención
$('#saveAttention').on('click', function () {

    const patientId = $('#attendPatientId').val();
    const date = $('#attentionDate').val();
    const time = $('#attentionTime').val();
    const procedure = $('#procedure').val();
    const observations = $('#attentionObservations').val();

    if (!date || !time || !procedure) {
        toastr.error('Completa todos los campos obligatorios');
        return;
    }

    $.ajax({
        url: `/admin/patients/${patientId}/attend`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        data: {
            attention_date: date,
            attention_time: time,
            procedure: procedure,
            attention_observations: observations
        },
        success: function () {
            toastr.success('Paciente atendido correctamente');

            localStorage.setItem('adminActiveTab', 'tab-patients');
            location.reload();
        },
        error: function () {
            toastr.error('Error al registrar atención');
        }
    });
});


/* =========================================================
   PROVEEDORES – CREAR
========================================================= */
$('#createProviderForm').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (response) {
            if (response.success) {

                localStorage.setItem('adminActiveTab', 'tab-providers');

                bootstrap.Modal.getInstance(
                    document.getElementById('providerCreateModal')
                ).hide();

                toastr.success('Proveedor creado correctamente');

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


/* =========================================================
   CONTRASEÑA ALEATORIA PROVEEDOR
========================================================= */
function generatePassword(length = 14) {
    const chars =
        'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%^&*';
    let password = '';

    for (let i = 0; i < length; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    return password;
}

$('#providerCreateModal').on('shown.bs.modal', function () {
    const pwd = generatePassword();

    $('#generatedPassword').val(pwd);
    $('#passwordField').val(pwd);
});

$('#copyPassword').on('click', function () {

    const input = document.getElementById('generatedPassword');
    const password = input.value;

    if (!password) {
        toastr.error('No hay contraseña para copiar');
        return;
    }

    input.removeAttribute('readonly');
    input.select();
    input.setSelectionRange(0, 99999);
    input.setAttribute('readonly', true);

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(password)
            .then(() => toastr.success('Contraseña copiada'))
            .catch(() => fallbackCopy());
    } else {
        fallbackCopy();
    }

    function fallbackCopy() {
        try {
            document.execCommand('copy');
            toastr.success('Contraseña copiada');
        } catch {
            toastr.error('No se pudo copiar la contraseña');
        }
    }
});


/* =========================================================
   TABS – RECORDAR TAB ACTIVO
========================================================= */
document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('[data-bs-toggle="pill"]')
        .forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (e) {
                const target = e.target.getAttribute('data-bs-target');
                if (target) {
                    localStorage.setItem(
                        'adminActiveTab',
                        target.replace('#', '')
                    );
                }
            });
        });

    const savedTab = localStorage.getItem('adminActiveTab');

    if (savedTab) {
        const trigger = document.querySelector(
            `button[data-bs-target="#${savedTab}"]`
        );

        if (trigger) {
            new bootstrap.Tab(trigger).show();
        }
    }
});

//mostrar un provedor al hacer clic en ver en la tabla de proveedores desde el dashboard de admin.
$('.btn-view-provider').on('click', function () {

    const row = $(this).closest('tr');
    const providerId = row.data('id');

    $.get(`/admin/providers/${providerId}`, function (provider) {

        $('#view_name').text(provider.user.name);
        $('#view_email').text(provider.user.email);

        $('#view_provider_type').text(
            provider.provider_type === 'doctor' ? 'Doctor' : 'Óptica'
        );

        $('#view_clinic').text(provider.clinic_name ?? '—');
        $('#view_phone').text(provider.phone ?? '—');

        $('#view_status').html(
            provider.is_active
                ? '<span class="badge badge-light-success">Activo</span>'
                : '<span class="badge badge-light-danger">Inactivo</span>'
        );

        new bootstrap.Modal(
            document.getElementById('providerViewModal')
        ).show();
    })
        .fail(() => {
            toastr.error('No se pudo cargar el proveedor');
        });
});


// Crear usuario administrador desde el dashboard de admin
$(document).on('submit', '#createUserForm', function (e) {
    e.preventDefault();

    const form = $(this);

    $.ajax({
        url: '/admin/users',
        method: 'POST',
        data: form.serialize(),
        success: function (res) {
            toastr.success('Administrador creado correctamente');

            tableUsers.row.add([
                res.user.name,
                res.user.email,
                `<span class="badge badge-light-primary">Administrador</span>`
            ]).draw(false);

            $('#userCreateModal').modal('hide');
            form[0].reset();
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                Object.values(xhr.responseJSON.errors).forEach(messages => {
                    messages.forEach(msg => toastr.error(msg));
                });
            } else {
                toastr.error('Error al crear usuario');
            }
        }
    });
});


//deshabilitar usuario administrador desde el dashboard de admin
$(document).on('click', '#disableUserBtn', function () {

    if (!selectedUserId) return;

    if (!confirm('¿Estás seguro de deshabilitar este usuario?')) return;

    $.ajax({
        url: `/admin/users/${selectedUserId}/disable`,
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            toastr.success(res.message);

            // actualizar badge en DataTable
            const row = $(`#usersTable tr[data-id="${selectedUserId}"]`);
            row.find('td:eq(2)').html(
                '<span class="badge badge-light-danger">Inactivo</span>'
            );

            $('#userViewModal').modal('hide');
        },
        error: function () {
            toastr.error('No se pudo deshabilitar el usuario');
        }
    });
});


// Ver detalles de usuario al hacer clic en la tabla de usuarios desde el dashboard de admin.
let selectedUserId = null;

$('#usersTable tbody').on('click', 'tr', function () {
    selectedUserId = $(this).data('id');

    const data = tableUsers.row(this).data();

    $('#viewUserName').text(data[0]);
    $('#viewUserEmail').text(data[1]);

    $('#userViewModal').modal('show');
});



$(document).on('click', '.btn-counter-reference', function () {
    const patientId = $(this).closest('tr').data('id');

    $('#counterReferencePatientId').val(patientId);
    $('#counterReferenceNotes').val('');

    $('#counterReferenceModal').modal('show');
});

$(document).on('click', '.btn-propose-surgery', function () {
    const patientId = $(this).closest('tr').data('id');
    $('#surgeryPatientId').val(patientId);
    $('#surgeryModal').modal('show');
});


$(document).on('click', '.btn-propose-treatment', function () {
    const patientId = $(this).closest('tr').data('id');

    $('#treatmentPatientId').val(patientId);
    $('#treatmentPlan').val('');
    $('#treatmentNotes').val('');

    $('#treatmentModal').modal('show');
});
$(document).on('click', '.btn-request-studies', function () {
    const patientId = $(this).closest('tr').data('id');

    $('#studiesPatientId').val(patientId);
    $('#studiesRequested').val('');
    $('#studiesNotes').val('');

    $('#studiesModal').modal('show');
});


$('#saveSurgeryProposal').on('click', function () {

    const patientId = $('#surgeryPatientId').val();
    const type = $('#surgeryType').val();
    const notes = $('#surgeryNotes').val();

    if (!type) {
        toastr.error('Selecciona el tipo de cirugía');
        return;
    }

    $.ajax({
        url: `/admin/patients/${patientId}/propose-surgery`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            surgery_type: type,
            surgery_notes: notes
        },
        success: function () {
            toastr.success('Cirugía propuesta');
            location.reload();
        },
        error: function () {
            toastr.error('No se pudo registrar');
        }
    });
});




$('#saveCounterReference').on('click', function () {

    const patientId = $('#counterReferencePatientId').val();
    const notes = $('#counterReferenceNotes').val();

    if (!notes) {
        toastr.error('Debes agregar una nota de contrarreferencia');
        return;
    }

    $.ajax({
        url: `/admin/patients/${patientId}/counter-reference`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            counter_reference_notes: notes
        },
        success: function () {

            toastr.success('Paciente enviado a contrarreferencia');

            localStorage.setItem('adminActiveTab', 'tab-patients');
            location.reload();
        },
        error: function () {
            toastr.error('Error al registrar contrarreferencia');
        }
    });
});

$(document).on('click', '#saveStudies', function () {

    const patientId = $('#studiesPatientId').val();
    const studies = $('#studiesRequested').val();
    const notes = $('#studiesNotes').val();

    if (!studies) {
        toastr.error('Debes indicar los estudios solicitados');
        return;
    }

    $.ajax({
        url: `/admin/patients/${patientId}/request-studies`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            studies_requested: studies,
            studies_notes: notes
        },
        success: function () {
            toastr.success('Estudios solicitados correctamente');
            location.reload();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            toastr.error('Error al solicitar estudios');
        }
    });
});


$(document).on('click', '#saveTreatment', function () {

    const patientId = $('#treatmentPatientId').val();
    const plan = $('#treatmentPlan').val();
    const notes = $('#treatmentNotes').val();

    if (!plan) {
        toastr.error('Debes escribir el plan terapéutico');
        return;
    }

    $.ajax({
        url: `/admin/patients/${patientId}/propose-treatment`,
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            treatment_plan: plan,
            treatment_notes: notes
        },
        success: function () {
            toastr.success('Tratamiento registrado correctamente');
            location.reload();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            toastr.error('Error al guardar tratamiento');
        }
    });
});



/* =========================================================
   UTILIDADES
========================================================= */
function openAppointmentModal(patientId) {
    $('#appointmentPatientId').val(patientId);
    $('#appointmentDate').val('');
    $('#appointmentTime').val('');
    $('#appointmentModal').modal('show');
}
