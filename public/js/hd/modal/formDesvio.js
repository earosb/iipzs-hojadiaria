/**
 * Created by earosb on 04-02-15.
 */

/**
 * Carga los blocks en modal desvío
 */
$('#selectsectorDesvio').on('change', function(e) {
    e.preventDefault();
    var sector_id = e.target.value;
    $('#selectblockDesvio').empty();
    ajaxBlocks(sector_id, '#selectblockDesvio');
});

/**
 * Carga el desviador norte modal desvío
 */
$('#selectblockDesvio').on('change', function(e){
    e.preventDefault();
    var id = e.target.value;
    $.ajax({
        url: '/block/' + id + '/desviadores/',
        type: 'get'
    }).error(function () {
        alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
    }).done(function (data) {
        $('#formModalDesvio .form-group').removeClass('required has-error');
        $('#formModalDesvio .help-block').empty();
        if(data.error){
            $('#selectblockDesvio_error').append('<p class="text-warning">' + data.msg + '</p>');
            $('#selectdesviador_norte').empty();
            $('#selectdesviador_norte').prop("disabled", true);
            $('#selectdesviador_sur').empty();
            $('#selectdesviador_sur').prop("disabled", true);
        }
        else{
            $('#selectdesviador_norte').empty();
            $('#selectdesviador_norte').prop("disabled", false);
            $('#selectdesviador_norte').append('<option disabled selected> Seleccione un Desviador </option>');
            $.each(data.desviadores, function (index, value) {
                $('#selectdesviador_norte').append('<option value="' + value.id + '">' + value.nombre + '  [Km inicio: '+ value.km_inicio +']' +'</option>');
            });
        }
    });
});

/**
 * Carga los desviadores al Sur del seleccionado como norte
 */
$("#selectdesviador_norte").on('change', function(e){
    e.preventDefault();
    var id = e.target.value;
    $.ajax({
        url: '/desviador/get-desviadores-sur/' + id,
        type: 'get'
    }).error(function () {
        alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
    }).done(function (data) {
        $('#formModalDesvio .form-group').removeClass('required has-error');
        $('#formModalDesvio .help-block').empty();
        if(data.error){
            $('#selectdesviador_norte_error').append('<p class="text-warning">' + data.msg + '</p>');
            $('#selectdesviador_sur').empty();
            $('#selectdesviador_sur').prop("disabled", true);
        }
        else{
            $('#selectdesviador_sur').empty();
            $('#selectdesviador_sur').prop("disabled", false);
            $('#selectdesviador_sur').append('<option disabled selected> Seleccione un Desviador </option>');
            $.each(data.desviadores, function (index, value) {
                $('#selectdesviador_sur').append('<option value="' + value.id + '">' + value.nombre + '  [Km inicio: '+ value.km_inicio +']' +'</option>');
            });
        }
    });
});

/**
 *
 */
$("#formModalDesvio").submit(function(e) {
    e.preventDefault();
    var $form = $(this),
        data = $form.serialize(),
        url = $form.attr("action"),
        method = $form.attr("method");
    $.ajax({
        url: url,
        type: method,
        data: data
    }).error(function() {
        alert("Error al enviar datos\nPor favor verifique su conexión a Internet");
    }).done(function(data) {
        if (data.error) {
            $('#formModalDesvio .form-group').removeClass('required has-error');
            $('#formModalDesvio .help-block').empty();
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
            $('#selectblock').trigger('change');
            $('#modalDesvio').modal('hide');
            document.getElementById("formModalDesvio").reset();
            $('#formModalDesvio .form-group').removeClass('required has-error');
            $('#formModalDesvio .help-block').empty();
            alertify.log(data.msg);
        }
    });
});