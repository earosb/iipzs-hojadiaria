/**
 * Llamada ajax para consultar y seetar los blocks de un sector en un select
 * @param  {int} sector_id          [id del sector]
 * @param  {string} select          [id del select a modificar]
 * @return {type}                   [description]
 */
function ajaxBlocks(sector_id, select) {
    $.ajax({
        type: 'get',
        url: '/block/ajax-blocks/' + sector_id
    }).error(function () {
        alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
    }).done(function (data) {
        $(select).empty();
        $(select).append('<option disabled selected> Seleccione un Block o Ramal </option>');

        $.each(data.blocks, function (index, blockObj) {
            $(select).append('<option value="' + blockObj.id + '">' + blockObj.estacion + '</option>');
        });

        /*$.each(data.ramales, function (index, ramalObj) {
         var optGroup = $('<optgroup label="Ramales"></optgroup>');
         var option = $('<option value="ramal-' + ramalObj.id + '">' + ramalObj.nombre + '</option>');
         optGroup.append(option);
         if ( index === data.ramales.length - 1 ) {
         $(select).append(optGroup);
         }
         });*/
    });
}

/**
 * Consulta ajax para obtener lo que hay en un block (desvios, desviadores, etc), los mete en el selectubicacion[0]
 * @param {integer} block_id id del block
 * @return {[type]}    [description]
 */
$('#selectblock').on('change', function (e) {
    e.preventDefault();
    var id_block = e.target.value;

    if ( id_block == 'empty' || id_block == 'null' ) {
        $('.selectubicacion').empty();
    } else {
        $.ajax({
            url: '/block/ajax-block-todo/' + id_block,
            type: 'GET'
        }).error(function () {
            // ERROR
            alert("Error al obtener los datos\nPor favor verifique su conexión a Internet");
        }).done(function (data) {
            /** DONE */
            var selectUbicacion = $('.selectubicacion');
            selectUbicacion.empty();
            selectUbicacion.append('<option selected="selected" disabled="disabled"> Seleccione vía </option>');
            selectUbicacion.append('<optgroup label="Vía Principal">');
            selectUbicacion.append('<option value=' + 'block-' + data.block.id + '>' + data.block.estacion + '</option>');
            selectUbicacion.append('</optgroup>');

            var kmInicio = $('.km-inicio');
            var kmTermino = $('.km-termino');
            kmInicio.removeAttr('placeholder');
            kmInicio.removeAttr('min');
            kmInicio.removeAttr('max');
            kmTermino.removeAttr('placeholder');
            kmTermino.removeAttr('min');
            kmTermino.removeAttr('max');

            $.each(data.desvios, function (index, desvioObj) {
                if ( index === 0 ) selectUbicacion.append('<optgroup label="Desvíos">');
                selectUbicacion.append('<option value=' + 'desvio-' + desvioObj.id + '>' + desvioObj.nombre + '</option>');
                if ( index == data.desvios.length - 1 ) { // Esto no funciona
                    selectUbicacion.append('</optgroup>');
                }
            });

            $.each(data.desviadores, function (index, desviadoresObj) {
                if ( index === 0 ) selectUbicacion.append('<optgroup label="Desviadores">');
                selectUbicacion.append('<option value=' + 'desviador-' + desviadoresObj.id + '>' + desviadoresObj.nombre + '</option>');
            });

        });
    }
});

function cargarKilometros(id) {
    var obj = document.getElementById("trabajos[" + id + "][ubicacion]");

    $.ajax({
        url: '/block/ajax-get-limites/' + obj.value,
        type: 'get'
    })
        .error(function () {
            alert("Error al obtener los datos\nPor favor verifique su conexión a Internet");
        })
        .done(function (data) {
            document.getElementById("trabajos[0][km_inicio]").setAttribute("placeholder", data.km_inicio);
            document.getElementById("trabajos[0][km_inicio]").setAttribute("min", data.km_inicio);
            document.getElementById("trabajos[0][km_inicio]").setAttribute("max", data.km_termino);
            document.getElementById("trabajos[0][km_termino]").setAttribute("placeholder", data.km_termino);
            document.getElementById("trabajos[0][km_termino]").setAttribute("min", data.km_inicio);
            document.getElementById("trabajos[0][km_termino]").setAttribute("max", data.km_termino);

            if ( data.error ) {
                alertify.log(data.msg);
                return;
            }

            var km_inicio;
            var km_termino;
            switch ( data.tipo ) {
                case 'block':
                    km_inicio = document.getElementById("trabajos[" + id + "][km_inicio]");
                    km_inicio.setAttribute("placeholder", data.km_inicio);
                    km_inicio.setAttribute("min", data.km_inicio);
                    km_inicio.setAttribute("max", data.km_termino);
                    km_termino = document.getElementById("trabajos[" + id + "][km_termino]");
                    km_termino.removeAttribute("disabled");
                    km_termino.setAttribute("placeholder", data.km_termino);
                    km_termino.setAttribute("min", data.km_inicio);
                    km_termino.setAttribute("max", data.km_termino);
                    break;
                case 'desvio':
                    km_inicio = document.getElementById("trabajos[" + id + "][km_inicio]");
                    km_inicio.setAttribute("placeholder", data.km_inicio);
                    km_inicio.setAttribute("min", data.km_inicio);
                    km_inicio.setAttribute("max", data.km_termino);
                    km_termino = document.getElementById("trabajos[" + id + "][km_termino]");
                    km_termino.removeAttribute("disabled");
                    km_termino.setAttribute("placeholder", data.km_termino);
                    km_termino.setAttribute("min", data.km_inicio);
                    km_termino.setAttribute("max", data.km_termino);
                    break;
                case 'desviador':
                    km_inicio = document.getElementById("trabajos[" + id + "][km_inicio]");
                    km_inicio.setAttribute("placeholder", data.km_inicio);
                    km_inicio.setAttribute("min", data.km_inicio);
                    km_inicio.setAttribute("max", data.km_termino);
                    km_termino = document.getElementById("trabajos[" + id + "][km_termino]");
                    km_termino.setAttribute("disabled", 'disabled');
                    break;
            }
        });
}
