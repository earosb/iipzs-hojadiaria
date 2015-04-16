/**
 * Created by earosb on 04-02-15.
 */

/**
 * Carga los blocks en modal desvío
 */
$('#selectsectorDesvio').on('change', function (e) {
    e.preventDefault();
    var sector_id = e.target.value;
    $('#selectblockDesvio').empty();
    ajaxBlocks(sector_id, '#selectblockDesvio');
});

/**
 * Carga el desviador norte modal desvío
 */
$('#selectblockDesvio').on('change', function (e) {
    e.preventDefault();
    var id = e.target.value;
    $.ajax({
        url: '/block/' + id + '/desviadores/',
        type: 'get'
    }).error(function () {
        alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
    }).done(function (data) {
        var form = $('#formModalDesvio');
        var formGroup = form.find('.form-group');
        var helpBlock = form.find('.help-block');
        formGroup.removeClass('required has-error');
        helpBlock.empty();
        var selectDesviadorNorte = $('#selectdesviador_norte');
        var selectDesviadorSur = $('#selectdesviador_sur');
        if (data.error) {
            $('#selectblockDesvio_error').append('<p class="text-warning">' + data.msg + '</p>');
            selectDesviadorNorte.empty();
            selectDesviadorNorte.prop("disabled", true);
            selectDesviadorSur.empty();
            selectDesviadorSur.prop("disabled", true);
        }
        else {
            selectDesviadorNorte.empty();
            selectDesviadorNorte.prop("disabled", false);
            selectDesviadorNorte.append('<option disabled selected> Seleccione un Desviador </option>');
            $.each(data.desviadores, function (index, value) {
                selectDesviadorNorte.append('<option value="' + value.id + '">' + value.nombre + '  [Km inicio: ' + value.km_inicio + ']' + '</option>');
            });
        }
    });
});

/**
 * Carga los desviadores al Sur del seleccionado como norte
 */
$("#selectdesviador_norte").on('change', function (e) {
    e.preventDefault();
    var id = e.target.value;
    $.ajax({
        url: '/desviador/get-desviadores-sur/' + id,
        type: 'get'
    }).error(function () {
        alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
    }).done(function (data) {
        var form = $('#formModalDesvio');
        var formGroup = form.find('.form-group');
        var helpBlock = form.find('.help-block');
        formGroup.removeClass('required has-error');
        helpBlock.empty();
        var selectDesviadorSur = $('#selectdesviador_sur');
        if (data.error) {
            $('#selectdesviador_norte_error').append('<p class="text-warning">' + data.msg + '</p>');
            selectDesviadorSur.empty();
            selectDesviadorSur.prop("disabled", true);
        }
        else {
            selectDesviadorSur.empty();
            selectDesviadorSur.prop("disabled", false);
            selectDesviadorSur.append('<option disabled selected> Seleccione un Desviador </option>');
            $.each(data.desviadores, function (index, value) {
                selectDesviadorSur.append('<option value="' + value.id + '">' + value.nombre + '  [Km inicio: ' + value.km_inicio + ']' + '</option>');
            });
        }
    });
});

/**
 *
 */
$("#formModalDesvio").submit(function (e) {
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
            var form = $('#formModalDesvio');
            var formGroup = form.find('.form-group');
            var helpBlock = form.find('.help-block');
            formGroup.removeClass('required has-error');
            helpBlock.empty();
            $.each(data.msg, function (index, value) {
                var errorDiv = '#formModalDesvio #' + index + '_error';
                $(errorDiv).addClass('required');
                $(errorDiv).empty();
                $.each(value, function (index, val) {
                    $(errorDiv).append('<p>' + val + '</p>');
                });
                $('#modalDesvio #' + index + '_div').addClass('required has-error');
            });
        } else {
            var modal = $('#modalDesvio');
            $('#selectblock').trigger('change');
            modal.modal('hide');
            document.getElementById("formModalDesvio").reset();
            var modalFormGroup = modal.find('.form-group');
            var modalHelpBlock = modal.find('.help-block');
            modalFormGroup.removeClass('required has-error');
            modalHelpBlock.empty();
            alertify.log(data.msg);
        }
    });
});