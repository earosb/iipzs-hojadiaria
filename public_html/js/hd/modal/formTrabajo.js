/**
 *
 */
$("#formTrabajo").submit(function (e) {
    e.preventDefault();

    var $form = $(this),
        data = $form.serialize(),
        url = $form.attr("action"),
        method = $form.attr("method");
    $.ajax({
        url: url,
        type: method,
        data: data
    }).error(function () {
        alert("Error al enviar datos\nPor favor verifique su conexión a Internet");
    }).done(function (data) {
        if ( data.error ) {
            var form = $('#formTrabajo');
            var formGroup = form.find('.form-group');
            var helpBlock = form.find('.help-block');
            formGroup.removeClass('required has-error');
            helpBlock.empty();
            $.each(data.msg, function (index, value) {
                var errorDiv = '#formTrabajo #' + index + '_error';
                $(errorDiv).addClass('required');
                $(errorDiv).empty();
                $.each(value, function (index, val) {
                    $(errorDiv).append('<p>' + val + '</p>');
                });
                $('#modalTrabajo #' + index + '_div').addClass('required has-error');
            });
        } else {
            var modal = $('#modalTrabajo');
            modal.modal('hide');
            document.getElementById("formTrabajo").reset();
            var modalFormGroup = modal.find('.form-group');
            var modalHelpBlock = modal.find('.help-block');
            modalFormGroup.removeClass('required has-error');
            modalHelpBlock.empty();
            alertify.log(data.msg);
            $('.selecttrabajo').append('<option value="' + data.trabajo.id + '">' + data.trabajo.nombre + ' ['+ data.trabajo.unidad + ']' + '</option>');
        }
    });
});