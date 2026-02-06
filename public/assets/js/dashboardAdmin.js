/* =========================================================
   VARIABLES GLOBALES
========================================================= */
let tablePatients = null;
let tableProviders = null;


/* =========================================================
   DATATABLES
========================================================= */
$(document).ready(function () {

    tablePatients = $('#patientsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: true,
        searching: true,
        ordering: true,
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
        lengthChange: false,
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

    const form = $(this);

    $.ajax({
        url: '/admin/patients',
        method: 'POST',
        data: form.serialize(),
        success: function () {

            // Cerrar modal
            bootstrap.Modal.getInstance(
                document.getElementById('patientCreateModal')
            ).hide();

            toastr.success('Paciente creado correctamente');

            // Mantener tab de pacientes
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

    $.ajax({
        url: `/admin/providers/${providerId}/status`,
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        data: {
            is_active: this.value
        }
    });
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


/* =========================================================
   UTILIDADES
========================================================= */
function openAppointmentModal(patientId) {
    $('#appointmentPatientId').val(patientId);
    $('#appointmentDate').val('');
    $('#appointmentTime').val('');
    $('#appointmentModal').modal('show');
}
