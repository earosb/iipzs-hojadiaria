$(document).ready(function () {
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

    /**
     * Launch modals
     */
    $('#modalDesviador').on('shown.bs.modal');
    $('#modalDesvio').on('shown.bs.modal');
    $('#modalTrabajo').on('shown.bs.modal');
    $('#modalMaterialCol').on('shown.bs.modal');
    $('#modalMaterialRet').on('shown.bs.modal');

    /**
     * Carga los blocks en form principal
     */
    $('#selectsector').on('change', function (e) {
        e.preventDefault();
        var sector_id = e.target.value;
        var selectUbicacion = $('.selectubicacion');
        $('#selectblock').empty();
        selectUbicacion.empty();
        selectUbicacion.append('<option disabled selected value="" style="display:none;"> Seleccione Block </option>');

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

});

/**
 * Consulta ajax para obtener lo que hay en un block (desvios, desviadores, etc),
 * los mete en el selectubicacion[0]
 */
$('#selectblock').on('change', function (e) {
    e.preventDefault();
    var id_block = e.target.value;

    if (id_block == 'empty' || id_block == 'null') {
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
            selectUbicacion.append('<option selected="selected" disabled="disabled" value="" style="display:none;"> Seleccione vía </option>');
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
                if (index === 0) selectUbicacion.append('<optgroup label="Desvíos">');
                selectUbicacion.append('<option value=' + 'desvio-' + desvioObj.id + '>' + desvioObj.nombre + '</option>');
                if (index == data.desvios.length - 1) { // Esto no funciona
                    selectUbicacion.append('</optgroup>');
                }
            });

            $.each(data.desviadores, function (index, desviadoresObj) {
                if (index === 0) selectUbicacion.append('<optgroup label="Desviadores">');
                selectUbicacion.append('<option value=' + 'desviador-' + desviadoresObj.id + '>' + desviadoresObj.nombre + '</option>');
            });

        });
    }
});

/**
 * Carga los kms posibles para un trabajo
 * @param id
 */
function cargarKilometros(id) {
    var obj = document.getElementById("trabajos[" + id + "][ubicacion]");

    $.ajax({
        url: '/block/ajax-get-limites/' + obj.value,
        type: 'get'
    }).error(function () {
        alert("Error al obtener los datos\nPor favor verifique su conexión a Internet");
    }).done(function (data) {

        if (data.error) {
            alertify.log(data.msg);
            return;
        }

        document.getElementById("trabajos[0][km_inicio]").setAttribute("placeholder", data.km_inicio);
        document.getElementById("trabajos[0][km_inicio]").setAttribute("min", data.km_inicio);
        document.getElementById("trabajos[0][km_inicio]").setAttribute("max", data.km_termino);
        document.getElementById("trabajos[0][km_termino]").setAttribute("placeholder", data.km_termino);
        document.getElementById("trabajos[0][km_termino]").setAttribute("min", data.km_inicio);
        document.getElementById("trabajos[0][km_termino]").setAttribute("max", data.km_termino);

        var km_inicio;
        var km_termino;
        switch (data.tipo) {
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
                km_termino.value = '';
                km_termino.setAttribute("disabled", 'disabled');
                break;
        }
    });
}

/**
 * Envía formulario hoja diaria
 */
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
        if (data.error) {
            formGroup.removeClass('required has-error');
            helpBlock.empty();
            $.each(data.msg, function (index, value) {
                if (index.substring(0, 8) == 'trabajos') {
                    document.getElementById(index).setAttribute("class", "form-group required has-error");
                } else if (index.substring(0, 6) == 'matCol') {
                    document.getElementById(index).setAttribute("class", "form-group required has-error");
                } else if (index.substring(0, 6) == 'matRet') {
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
            if (data.edit) {
                window.history.back(-1);
            }
            alertify.log(data.msg);
            formGroup.removeClass('required has-error');
            helpBlock.empty();
            document.getElementById("formHojaDiaria").reset();
        }
    });

});

/**
 * Cambia el valor en km termino al perder el foco en km inicio
 * copia el valor +100 y el atributo min
 * @param obj input
 */
function onblurKmTermino(obj) {
    var id = (obj.id).split(/[[\]]{1,2}/);
    id.length--;
    var km_termino = document.getElementById("trabajos[" + id[1] + "][km_termino]");
    km_termino.value = parseInt(obj.value) + 100;
    km_termino.setAttribute("min", obj.value);
}

/**
 * Trae los materiales de cada trabajo y los agrega a la tabla de materiales colocados
 * @param obj
 */
function getMateriales(obj) {

    $.ajax({
        url: '/trabajo/' + obj.value + '/materiales',
        type: 'get',
        dataType: 'json'
    }).done(function (data) {

        $.each(data.materiales, function (index, value) {

            var chao = false; // No agrega el material si ya está seleccionado en la tabla
            var newid = 0;

            $.each($("#tab_material_colocado tr"), function () {
                if (parseInt($(this).data("id")) > newid) {
                    newid = parseInt($(this).data("id"));
                    if ($(this).find('td').find('select').val() == value.id){
                        chao = true;
                    }
                }
            });

            if (chao) return false;

            newid++;
            // tr principal
            var tr = $("<tr></tr>", {
                id: "addrMatCol" + newid,
                "data-id": newid
            });
            // td select
            var tdSelect = $("<td></td>", {
                "data-name": "matCol",
                id: "matCol." + newid + ".id",
                name: "matCol." + newid + ".id"
            });

            var select = $("<select></select>", {
                class: "form-control matCol",
                name: "matCol[" + newid + "][id]",
                id: "matCol[" + newid + "][id]"
            });

            var option = $("<option value=" + value.id + ">" + value.nombre + "</option>");
            // td reempleo
            var tdReempleo = $("<td></td>", {
                "data-name": "matCol",
                id: "matCol." + newid + ".reempleo",
                name: "matCol." + newid + ".reempleo"
            });

            var inputReempleo = $("<input>", {
                class: "form-control",
                name: "matCol[" + newid + "][reempleo]",
                type: "checkbox",
                value: "",
                id: "matCol[" + newid + "][reempleo]"
            });
            // td cantidad
            var tdCantidad = $("<td></td>", {
                "data-name": "matCol",
                id: "matCol." + newid + ".cant",
                name: "matCol." + newid + ".cant"
            });

            var inputCantidad = $("<input>", {
                class: "form-control",
                min: "0",
                step: "any",
                name: "matCol[" + newid + "][cant]",
                type: "number",
                id: "matCol[" + newid + "][cant]"
            });

            var tdBtnDelete = $("<td></td>").append(
                $("<button class='btn btn-xs btn-danger glyphicon glyphicon-remove row-remove center-btn'></button>")
                    .click(function () {
                        $(this).closest("tr").remove();
                    }));

            select.append(option);
            tdSelect.append(select);
            tdReempleo.append(inputReempleo);
            tdCantidad.append(inputCantidad);
            tr.append(tdSelect);
            tr.append(tdReempleo);
            tr.append(tdCantidad);
            tr.append(tdBtnDelete);
            $('#tab_material_colocado').append(tr);
        });

    });
}

