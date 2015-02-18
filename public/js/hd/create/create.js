$(document).ready(function () {
    /**
     * Launch modals
     */
    $('#modalDesviador').on('shown.bs.modal');
    $('#modalDesvio').on('shown.bs.modal');
    $('#modalTrabajo').on('shown.bs.modal');
    $('#modalMaterialCol').on('shown.bs.modal');
    $('#modalMaterialRet').on('shown.bs.modal');

    /**
     * Carga los blocks en modal Form Desviador
     */
    $('#selectsectorDesviador').on('change', function (e) {
        e.preventDefault();
        var sector_id = e.target.value;
        ajaxBlocks(sector_id, '#selectblockDesviador');
    });

    /**
     * Carga los blocks en form principal
     */
    $('#selectsector').on('change', function (e) {
        e.preventDefault();
        var sector_id = e.target.value;
        var selectUbicacion = $('.selectubicacion');
        $('#selectblock').empty();
        selectUbicacion.empty();
        selectUbicacion.append('<option disabled selected value="null"> Seleccione Block </option>');

        ajaxBlocks(sector_id, '#selectblock');

        var kmInicio = $('.km-inicio');
        var kmTermino = $('.km-termino');
        kmInicio.removeAttr('placeholder');
        kmInicio.removeAttr('min');
        kmInicio.removeAttr('max');
        kmTermino.removeAttr('placeholder');
        kmTermino.removeAttr('min');
        kmTermino.removeAttr('max');

    });

    /**
     * Lanza calendario
     */
    $("#fecha").datepicker({
        defaultDate: "-1m",
        numberOfMonths: 2,
        showAnim: "slideDown",
        beforeShow: function () {
            $(".ui-datepicker").css('font-size', 12)
        }
    });

});
