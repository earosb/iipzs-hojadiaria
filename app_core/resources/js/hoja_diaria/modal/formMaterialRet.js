/**
 * Created by earosb on 04-02-15.
 */

/**
 *
 */
$("#formMaterialRetirado").submit(function (e) {
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
        if (data.error) {
            var form = $('#formMaterialRetirado');
            var formGroup = form.find('.form-group');
            var helpBlock = form.find('.help-block');
            formGroup.removeClass('required has-error');
            helpBlock.empty();
            $.each(data.msg, function (index, value) {
                var errorDiv = '#formMaterialRetirado #' + index + '_error';
                $(errorDiv).addClass('required');
                $(errorDiv).empty();
                $.each(value, function (index, val) {
                    $(errorDiv).append('<p>' + val + '</p>');
                });
                $('#modalMaterialRet #' + index + '_div').addClass('required has-error');
            });
        } else {
            var modal = $('#modalMaterialRet');
            modal.modal('hide');
            document.getElementById("formMaterialRetirado").reset();
            var modalFormGroup = modal.find('.form-group');
            var modalHelpBlock = modal.find('.help-block');
            modalFormGroup.removeClass('required has-error');
            modalHelpBlock.empty();
            alertify.log(data.msg);
            $('.matRet').append('<option value="' + data.nuevoMatRet.id + '">' + data.nuevoMatRet.nombre + '</option>');
        }
    });
});