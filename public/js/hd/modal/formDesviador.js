/**
 * [description]
 * @param  {[type]} e) {             e.preventDefault();  var $form [description]
 * @return {[type]}    [description]
 */
$("#formModalDesviador").submit(function (e) {
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
        if (data.fail) {
            $('#formModalDesviador .form-group').removeClass('required has-error');
            $('#formModalDesviador .help-block').empty();
            $.each(data.errors, function (index, value) {
                var errorDiv = '#' + index + '_error';
                $(errorDiv).addClass('required');
                $(errorDiv).empty();
                $.each(value, function (index, val) {
                    $(errorDiv).append('<p>' + val + '</p>');
                });
                $('#modalDesviador #' + index + '_div').addClass('required has-error');
            });
        } else {
            $('#modalDesviador').modal('hide');
            $('#selectblock').trigger('change');
            document.getElementById("formModalDesviador").reset();
        }
    });
});
