$('#formHojaDiaria').submit(function (e) {
    e.preventDefault();

    var $form = $(this),
        data = $form.serialize(),
        url = $form.attr("action");

    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: data
    }).fail(function () {
        alert("Error al enviar datos\nPor favor verifique su conexión a Internet");
    }).done(function (data) {
        var form = $('#formHojaDiaria');
        var formGroup = form.find('.form-group');
        var helpBlock = form.find('.help-block');
        if ( data.error ) {
            formGroup.removeClass('required has-error');
            helpBlock.empty();
            $.each(data.msg, function (index, value) {
                if ( index.substring(0, 8) == 'trabajos' ) {
                    document.getElementById(index).setAttribute("class", "form-group required has-error");
                } else if ( index.substring(0, 6) == 'matCol' ) {
                    document.getElementById(index).setAttribute("class", "form-group required has-error");
                } else if ( index.substring(0, 6) == 'matRet' ) {
                    document.getElementById(index).setAttribute("class", "form-group required has-error");
                } else {
                    var errorDiv = '#' + index + '_error';
                    $(errorDiv).addClass('required');
                    $(errorDiv).empty();
                    $.each(value, function (index, val) {
                        $(errorDiv).append('<p>' + val + '</p>');
                    });
                    $('#formHojaDiaria #' + index + '_div').addClass('required has-error');
                }
            });
        } else {
            alertify.log(data.msg);
            formGroup.removeClass('required has-error');
            helpBlock.empty();
            document.getElementById("formHojaDiaria").reset();
        }
    });

});