/**
 * Created by earosb on 05-02-15.
 */

function verHojaDiaria(id) {

    $.ajax({
        url: '/hd/' + id,
        type: 'GET'
    }).success(function (data) {
        escribirDetalle(data);
        //$('#modalHojaDiaria').modal('show');
    }).error(function () {
        alert("Error al descargar datos\nPor favor verifique su conexión a Internet");
    });
}

function editarHojaDiaria(id) {
    alertify.log("Función editar no disponible");
    //console.log('editar() ID ' + id);
}
function borrarHojaDiaria(id) {
    setTimeout(function () {
        if ( confirm("¿Borrar Hoja Diaria?") == true ) {
            $.ajax({
                url: '/hd/' + id,
                type: 'DELETE'
            }).success(function (data) {
                if ( data.error ) {
                    alert(data.msg);
                } else {
                    window.location.reload();
                }
            }).error(function () {
                console.log("error");
            });
        }
    }, 3000);

}

function escribirDetalle(data) {
    if ( data.error ) {
        document.getElementById('dt_legend').innerHTML = data.msg;
        return;
    }

    var div = $("#div_detalle");
    div.empty();

    var legend = $("<legend></legend>");

    var title = $("<h4></h4>", {
        html: "Grupo: <b>" + data.hojaDiaria.grupo_trabajo.base + "</b>" + " Fecha: <b>" + data.hojaDiaria.fecha + "</b>"
    });
    var btn_div = $("<div></div>", {
        class: "pull-right"
    });

    var btn_borrar = $("<a></a>", {
        class: "glyphicon glyphicon-trash",
        title: "Borrar",
        href: "#",
        onClick: "borrarHojaDiaria( " + data.hojaDiaria.id + " );return false;"
    });
    var btn_editar = $("<a></a>", {
        class: "glyphicon glyphicon-pencil",
        title: "Editar",
        href: "#",
        onClick: "editarHojaDiaria( " + data.hojaDiaria.id + " );return false;"
    });

    btn_div.append(btn_editar);
    btn_div.append(btn_borrar);
    legend.append(btn_div);
    legend.append(title);

    div.append(legend);

    /**
     * Tabla de trabajos realizados
     */
    if ( typeof data.hojaDiaria.detalle_hoja_diaria[0] !== 'undefined' && data.hojaDiaria.detalle_hoja_diaria[0] !== null ) {
        var tbl_trabajos = $("<table></table>", {
            class: "table table-bordered table-striped"
        });
        var tbl_tbjs_thead = $("<thead></thead>");
        var tbl_tbjs_tr = $("<tr></tr>");

        tbl_tbjs_tr.append("<th>#</th>");
        tbl_tbjs_tr.append("<th>Trabajo</th>");
        tbl_tbjs_tr.append("<th>Block: " + data.hojaDiaria.detalle_hoja_diaria[0].block.estacion + "</th>");
        //tbl_tbjs_tr.append("<th>Vía/Desvio/Desviador</th>");
        tbl_tbjs_tr.append("<th>Km Inicio</th>");
        tbl_tbjs_tr.append("<th>Km Termino</th>");
        tbl_tbjs_tr.append("<th>Cantidad</th>");

        tbl_tbjs_thead.append(tbl_tbjs_tr);
        tbl_trabajos.append(tbl_tbjs_thead);

        div.append("<h4>Trabajos Realizados </h4>");
        div.append(tbl_trabajos);

        var tbl_tbjs_tbody = $("<tbody></tbody>");

        $.each(data.hojaDiaria.detalle_hoja_diaria, function (index, value) {

            var tbl_tbjs_tr = $("<tr></tr>");
            tbl_tbjs_tr.append("<td>" + (index + 1) + "</td>");
            tbl_tbjs_tr.append("<td>" + value.trabajo.nombre + "</td>");
            //tbl_tbjs_tr.append("<td>" + value.block.estacion + "</td>");

            if ( value['desvio'] != null ) {
                tbl_tbjs_tr.append("<td>" + value.desvio.nombre + "</td>");
            }
            else if ( value['desviador'] != null ) {
                tbl_tbjs_tr.append("<td>" + value.desviador.nombre + "</td>");
            }
            else {
                tbl_tbjs_tr.append("<td> Vía Principal</td>");
            }

            tbl_tbjs_tr.append("<td>" + value.km_inicio + "</td>");
            tbl_tbjs_tr.append("<td>" + value.km_termino + "</td>");
            tbl_tbjs_tr.append("<td>" + value.cantidad + "</td>");
            tbl_tbjs_tbody.append(tbl_tbjs_tr);
        });
        tbl_trabajos.append(tbl_tbjs_tbody);
    }

    /**
     * Tabla de materiales colocados
     */
    if ( typeof data.hojaDiaria.detalle_material_colocado[0] !== 'undefined' && data.hojaDiaria.detalle_material_colocado[0] !== null ) {
        var tbl_matCol = $("<table></table>", {
            class: "table table-bordered table-striped"
        });
        var tbl_thead = $("<thead></thead>");
        var tbl_tr = $("<tr></tr>");

        tbl_tr.append("<th>#</th>");
        tbl_tr.append("<th>Material</th>");
        tbl_tr.append("<th>Reempleo</th>");
        tbl_tr.append("<th>Cantidad</th>");
        tbl_tr.append("<th>Unidad</th>");

        tbl_thead.append(tbl_tr);
        tbl_matCol.append(tbl_thead);

        var tbl_tbody = $("<tbody></tbody>");

        $.each(data.hojaDiaria.detalle_material_colocado, function (index, value) {
            var tbl_tr = $("<tr></tr>");
            var reempleo = value.reempleo === '1' ? 'Si' : 'No';

            tbl_tr.append("<td>" + (index + 1) + "</td>");
            tbl_tr.append("<td>" + value.material.nombre + "</td>");
            tbl_tr.append("<td>" + reempleo + "</td>");
            tbl_tr.append("<td>" + value.cantidad + "</td>");
            tbl_tr.append("<td>" + value.material.unidad + "</td>");
            tbl_tbody.append(tbl_tr);
        });
        tbl_matCol.append(tbl_tbody);
        div.append("<h4>Materiales Colocados</h4>");
        div.append(tbl_matCol);
    }

    /**
     * Tabla de materiales Retirados
     */
    if ( typeof data.hojaDiaria.detalle_material_retirado[0] !== 'undefined' && data.hojaDiaria.detalle_material_retirado[0] !== null ) {
        var tbl_matCol = $("<table></table>", {
            class: "table table-bordered table-striped"
        });
        var tbl_thead = $("<thead></thead>");
        var tbl_tr = $("<tr></tr>");

        tbl_tr.append("<th>#</th>");
        tbl_tr.append("<th>Material</th>");
        tbl_tr.append("<th>Cantidad</th>");

        tbl_thead.append(tbl_tr);
        tbl_matCol.append(tbl_thead);

        var tbl_tbody = $("<tbody></tbody>");

        $.each(data.hojaDiaria.detalle_material_retirado, function (index, value) {
            var tbl_tr = $("<tr></tr>");
            tbl_tr.append("<td>" + (index + 1) + "</td>");
            tbl_tr.append("<td>" + value.material_retirado.nombre + "</td>");
            tbl_tr.append("<td>" + value.cantidad + "</td>");
            tbl_tbody.append(tbl_tr);
        });
        tbl_matCol.append(tbl_tbody);
        div.append("<h4>Materiales Retirados</h4>");
        div.append(tbl_matCol);
    }

    if ( data.hojaDiaria.observaciones ) {
        div.append("<h4>Observaciones</h4>");
        div.append("<p>" + data.hojaDiaria.observaciones + "</p>");
    }

    //$('#modalHojaDiaria').modal('show');
}