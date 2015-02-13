/**
 * Created by earosb on 12-02-15.
 */

$(document).ready(function() {
    /**
     * Lanza calendarios
     */
    $("#desde").datepicker({
        defaultDate: "-2m",
        numberOfMonths: 2,
        showAnim: "slideDown",
        beforeShow: function() {
            $(".ui-datepicker").css('font-size', 12)
        }
    });
    $("#hasta").datepicker({
        defaultDate: "-1m",
        numberOfMonths: 2,
        showAnim: "slideDown",
        beforeShow: function() {
            $(".ui-datepicker").css('font-size', 12)
        }
    });
    /**
     * Carga los blocks en select
     */
    $('#sector').on('change', function(e) {
        e.preventDefault();
        var sector_id = e.target.value;

        $('#selectblock').empty();
        $('.selectubicacion').empty();
        $('.selectubicacion').append('<option disabled selected> Seleccione Sector y Block </option>');

        if (sector_id === 'all') {
            $('#block').empty();
            $('#block').append('<option disabled selected> Seleccione Block o Ramal </option>');
            var km_inicio = document.getElementById('km_inicio');
            var km_termino = document.getElementById('km_termino');
            km_inicio.value = '498800';
            km_inicio.setAttribute("min", '498800');
            km_termino.value = '1066000';
            km_termino.setAttribute("max", '1066000');
            return;
        }

        $.ajax({
            type: 'get',
            url: '/block/ajax-blocks/' + sector_id
        }).error(function () {
            alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
        }).done(function (data) {
            $('#block').empty();
            $('#block').append('<option disabled selected> Seleccione Block o Ramal </option>');

            $.each(data.blocks, function (index, blockObj) {
                if (index < data.blocks.length - 1) {
                    $('#block').append('<option value="' + blockObj.id + '">' + blockObj.estacion + ' - ' + data.blocks[index + 1].estacion + '</option>');
                } else {
                    $('#block').append('<option value="' + blockObj.id + '">' + blockObj.estacion + '</option>');
                }
                var km_inicio = document.getElementById('km_inicio');
                var km_termino = document.getElementById('km_termino');
                km_inicio.value = blockObj.sector_km_inicio;
                km_inicio.setAttribute("min", blockObj.sector_km_inicio);
                km_termino.value = blockObj.sector_km_termino;
                km_termino.setAttribute("max", blockObj.sector_km_termino);
            });

            $.each(data.ramales, function (index, ramalObj) {
                var optGroup = $('<optgroup label="Ramales"></optgroup>');
                var option = $('<option value="ramal-' + ramalObj.id + '">' + ramalObj.nombre + '</option>');
                optGroup.append(option);
                if (index === data.ramales.length - 1) {
                    $('#block').append(optGroup);
                }
            });
        });

    });

    /**
     * Carga los límites del block
     */
    $('#block').on('change', function(e) {
        e.preventDefault();
        var block_id = e.target.value;

        $.ajax({
            url: '/block/ajax-get-limites/block-' + block_id,
            type: 'get'
        })
            .error(function () {
                alert("Error al obtener los datos\nPor favor verifique su conexión a Internet");
            })
            .done(function (data) {
                switch (data.tipo) {
                    case 'block':
                        var km_inicio = document.getElementById('km_inicio');
                        var km_termino = document.getElementById('km_termino');
                        km_inicio.value = data.km_inicio;
                        km_inicio.setAttribute("min", data.km_inicio);
                        km_termino.value = data.km_termino;
                        km_termino.setAttribute("max", data.km_termino);
                        break;
                }

            });
    });
});