/**
 * Created by earosb on 10-02-15.
 */

/**
 *
 */
$("#formMaterialColocado").submit(function (e) {
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
            $('#formMaterialColocado .form-group').removeClass('required has-error');
            $('#formMaterialColocado .help-block').empty();
            $.each(data.msg, function (index, value) {
                var errorDiv = '#formMaterialColocado #' + index + '_error';
                $(errorDiv).addClass('required');
                $(errorDiv).empty();
                $.each(value, function (index, val) {
                    $(errorDiv).append('<p>' + val + '</p>');
                });
                $('#modalMaterialCol #' + index + '_div').addClass('required has-error');
            });
        } else {
            $('#modalMaterialCol').modal('hide');
            document.getElementById("formMaterialColocado").reset();
            $('#modalMaterialCol .form-group').removeClass('required has-error');
            $('#modalMaterialCol .help-block').empty();
            alertify.log(data.msg);
            $('.matCol').append('<option value="' + data.nuevoMatCol.id + '">' + data.nuevoMatCol.nombre + '</option>');
        }
    });
});