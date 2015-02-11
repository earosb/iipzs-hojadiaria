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
        alert("Error al obtener los datos\n Por favor, verifique su conexión a Internet");
    }).done(function (data) {
        $(select).empty();
        $(select).append('<option disabled selected> Seleccione un Block o Ramal </option>');

        $.each(data.blocks, function (index, blockObj) {
            if (index < data.blocks.length - 1) {
                $(select).append('<option value="' + blockObj.id + '">' + blockObj.estacion + ' - ' + data.blocks[index + 1].estacion + '</option>');
            } else {
                $(select).append('<option value="' + blockObj.id + '">' + blockObj.estacion + '</option>');
            }
        });

        $.each(data.ramales, function (index, ramalObj) {
            var optGroup = $('<optgroup label="Ramales"></optgroup>');
            var option = $('<option value="ramal-' + ramalObj.id + '">' + ramalObj.nombre + '</option>');
            optGroup.append(option);
            if (index === data.ramales.length - 1) {
                $(select).append(optGroup);
            }
        });
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

    if (id_block == 'empty') {
        $('.selectubicacion').empty();
    } else {
        $.ajax({
            url: '/block/ajax-block-todo/' + id_block,
            type: 'GET'
        }).error(function () {
            // ERROR
            alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
        }).done(function (data) {
            /** DONE */
            $('.selectubicacion').empty();
            $('.selectubicacion').append('<option selected="selected" disabled="disabled"> Seleccione vía </option>');
            $('.selectubicacion').append('<optgroup label="Vía Principal">');
            //$(".selectubicacion").append("<option value=" + "{'tipo':'block','id':" + data.block.id + "}" + ">" + data.block.estacion + "</option>");
            $(".selectubicacion").append('<option value=' + 'block-' + data.block.id + '>' + data.block.estacion + '</option>');
            $('.selectubicacion').append('</optgroup>');

            $.each(data.desvios, function (index, desvioObj) {
                if (index === 0) {
                    $('.selectubicacion').append('<optgroup label="Desvíos">');
                }

                $(".selectubicacion").append('<option value=' + 'desvio-' + desvioObj.id + '>' + desvioObj.nombre + '</option>');
                if (index == data.desvios.length - 1) { // Esto no funciona
                    $('.selectubicacion').append('</optgroup>');
                }
            });

            $.each(data.desviadores, function (index, desviadoresObj) {
                if (index === 0) { // Esto no funciona
                    $('.selectubicacion').append('<optgroup label="Desviadores">');
                }
                $(".selectubicacion").append('<option value=' + 'desviador-' + desviadoresObj.id + '>' + desviadoresObj.nombre + '</option>');
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
            alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
        })
        .done(function (data) {
            switch (data.tipo) {
                case 'block':
                    var km_inicio = document.getElementById("trabajos[" + id + "][km_inicio]");
                    km_inicio.setAttribute("placeholder", data.km_inicio);
                    var km_termino = document.getElementById("trabajos[" + id + "][km_termino]");
                    km_termino.removeAttribute("disabled");
                    km_termino.setAttribute("placeholder", data.km_termino);
                    break;
                case 'desvio':
                    var km_inicio = document.getElementById("trabajos[" + id + "][km_inicio]");
                    km_inicio.setAttribute("placeholder", data.km_inicio);
                    var km_termino = document.getElementById("trabajos[" + id + "][km_termino]");
                    km_termino.removeAttribute("disabled");
                    km_termino.setAttribute("placeholder", data.km_termino);
                    break;
                case 'desviador':
                    var km_inicio = document.getElementById("trabajos[" + id + "][km_inicio]");
                    km_inicio.setAttribute("placeholder", data.km_inicio);
                    var km_termino = document.getElementById("trabajos[" + id + "][km_termino]");
                    km_termino.setAttribute("disabled", 'disabled');
                    break;
            }

        });

}