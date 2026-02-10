/* =========================================================
   PROVIDER – VER PACIENTE
========================================================= */
$(document).on('click', '.btn-view-patient', function () {
    const patientId = $(this).closest('tr').data('id');

    $('#patientDetailModal').modal('show');
    $('#patientDetailContent').html(
        '<div class="text-center py-10">Cargando...</div>'
    );

    $.get(`/provider/patients/${patientId}`, function (html) {
        $('#patientDetailContent').html(html);
    });
});
