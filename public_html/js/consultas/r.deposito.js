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
        var selectBlock = $('#block');
        if (sector_id === 'all') {
            selectBlock.empty();
            selectBlock.append('<option value="all">Todos</option>');
            return;
        }
        selectBlock.empty();
        selectBlock.append('<option disabled selected>Cargando...</option>');
        $.ajax({
            type: 'get',
            url: '/r/block/ajax-blocks/' + sector_id
        }).error(function () {
            alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
        }).done(function (data) {
            selectBlock.empty();
            selectBlock.append('<option value="all">Seleccione Block</option>');

            $.each(data.blocks, function (index, blockObj) {
                selectBlock.append('<option value="' + blockObj.id + '">' + blockObj.estacion + '</option>');
            });

        });

    });
});