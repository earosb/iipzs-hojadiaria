/*global $*/
/**
 * Llamada ajax para consultar y seetar los blocks de un sector en un select
 * @param sector_id
 * @param select
 */
function ajaxBlocks(sector_id, select) {
    $.ajax({
        type: 'get',
        url: '/block/ajax-blocks/' + sector_id
    }).error(function () {
        alert("Error al obtener los datos\nPor favor, verifique su conexión a Internet");
    }).done(function (data) {
        $(select).empty();
        $(select).append('<option disabled selected> Seleccione un Block </option>');

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