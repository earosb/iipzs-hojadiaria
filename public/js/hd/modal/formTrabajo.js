/**
 * Created by earosb on 11-02-15.
 */

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
        if (data.error) {
            $('#formTrabajo .form-group').removeClass('required has-error');
            $('#formTrabajo .help-block').empty();
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
            $('#modalTrabajo').modal('hide');
            document.getElementById("formTrabajo").reset();
            $('#modalTrabajo .form-group').removeClass('required has-error');
            $('#modalTrabajo .help-block').empty();
            alertify.log(data.msg);
            $('.selecttrabajo').append('<option value="' + data.trabajo.id + '">' + data.trabajo.nombre + '</option>');
            console.log(data);
        }
    });
});