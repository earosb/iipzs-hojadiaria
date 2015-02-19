/**
 * Created by earosb on 12-02-15.
 */

$(document).ready(function () {
    /**
     * Lanza calendarios
     */
    $("#fecha_desde").datepicker({
        defaultDate: "-2m",
        numberOfMonths: 2,
        showAnim: "slideDown",
        beforeShow: function () {
            $(".ui-datepicker").css('font-size', 12)
        }
    });
    $("#fecha_hasta").datepicker({
        defaultDate: "-1m",
        numberOfMonths: 2,
        showAnim: "slideDown",
        beforeShow: function () {
            $(".ui-datepicker").css('font-size', 12)
        }
    });
    /**
     * Carga los blocks en select
     */
    $('#sector').on('change', function (e) {
        e.preventDefault();
        var sector_id = e.target.value;

        $('#selectblock').empty();
        var ubicacion = $('.selectubicacion');
        ubicacion.empty();
        ubicacion.append('<option disabled selected> Seleccione Sector y Block </option>');

        var block = $('#block');
        if ( sector_id === 'all' ) {
            block.empty();
            block.append('<option disabled selected> Seleccione Block o Ramal </option>');
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
            url: '/r/block/ajax-blocks/' + sector_id
        }).error(function () {
            alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
        }).done(function (data) {
            block.empty();
            block.append('<option disabled selected> Seleccione Block </option>');

            $.each(data.blocks, function (index, blockObj) {

                $('#block').append('<option value="' + blockObj.id + '">' + blockObj.estacion + '</option>');

                var km_inicio = document.getElementById('km_inicio');
                var km_termino = document.getElementById('km_termino');
                km_inicio.value = blockObj.sector_km_inicio;
                km_inicio.setAttribute("min", blockObj.sector_km_inicio);
                km_termino.value = blockObj.sector_km_termino;
                km_termino.setAttribute("max", blockObj.sector_km_termino);
            });

        });

    });

    /**
     * Carga los límites del block
     */
    $('#block').on('change', function (e) {
        e.preventDefault();
        var block_id = e.target.value;

        $.ajax({
            url: '/r/block/ajax-get-limites/block-' + block_id,
            type: 'get'
        })
            .error(function () {
                alert("Error al obtener los datos\nPor favor verifique su conexión a Internet");
            })
            .done(function (data) {
                switch ( data.tipo ) {
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