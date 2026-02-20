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