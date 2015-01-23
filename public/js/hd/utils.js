/**
 * DatePicker basado en JQueryUI
 */
  $.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
  };
  $.datepicker.setDefaults($.datepicker.regional['es']);

  $("#fecha").datepicker({
    defaultDate: "-1m",
    numberOfMonths: 2,
    showAnim: "slideDown",
    beforeShow: function() {
      $(".ui-datepicker").css('font-size', 12)
    }
  });


/**
 * Magia encargada de añadir nuevas filas a la tabla de trabajos realizados
 * @param  {[type]} ) {var newid [description]
 * @return {[type]}   [description]
 */
  $("#add_row_trabajos").on("click", function() {
    // Dynamic Rows Code

    // Get max row id and set new id
    var newid = 0;
    $.each($("#tab_trabajados tr"), function() {
      if (parseInt($(this).data("id")) > newid) {
        newid = parseInt($(this).data("id"));
      }
    });
    newid++;

    var tr = $("<tr></tr>", {
      id: "addr" + newid + "]",
      "data-id": newid + "]"
    });

    // loop through each td and create new elements with name of newid
    $.each($("#tab_trabajados tbody tr:nth(0) td"), function() {
      var cur_td = $(this);

      var children = cur_td.children();

      // add new td and element if it has a nane
      if ($(this).data("name") != undefined) {
        var td = $("<td></td>", {
          "data-name": $(cur_td).data("name")
        });

        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
        c.attr("name", $(cur_td).data("name") + newid + "]");
        c.appendTo($(td));
        td.appendTo($(tr));
      } else {
        var td = $("<td></td>", {
          'text': $('#tab_trabajados tr').length
        }).appendTo($(tr));
      }
    });

    /* add delete button and td
    $("<td></td>").append(
        $("<button class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>")
            .click(function() {
                $(this).closest("tr").remove();
            })
    ).appendTo($(tr)); */


    // add the new row
    $(tr).appendTo($('#tab_trabajados'));

    $(tr).find("td button.row-remove").on("click", function() {
      $(this).closest("tr").remove();
    });
  });

  // Sortable Code
  var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();

    $helper.children().each(function(index) {
      $(this).width($originals.eq(index).width())
    });

    return $helper;
  };

  $(".table-sortable tbody").sortable({
    helper: fixHelperModified
  }).disableSelection();

  $(".table-sortable thead").disableSelection();

  $("#add_row_trabajos").trigger("click");

/**
 * Magia encargada de añadir nuevas filas a la tabla de trabajos realizados
 * @param  {[type]} ) {var newid [description]
 * @return {[type]}   [description]
 */
  $("#add_row_matCol").on("click", function() {
    // Dynamic Rows Code

    // Get max row id and set new id
    var newid = 0;
    $.each($("#tab_material_colocado tr"), function() {
      if (parseInt($(this).data("id")) > newid) {
        newid = parseInt($(this).data("id"));
      }
    });
    newid++;

    var tr = $("<tr></tr>", {
      id: "addrMatCol" + newid,
      "data-id": newid
    });

    // loop through each td and create new elements with name of newid
    $.each($("#tab_material_colocado tbody tr:nth(0) td"), function() {
      var cur_td = $(this);

      var children = cur_td.children();

      // add new td and element if it has a nane
      if ($(this).data("name") != undefined) {
        var td = $("<td></td>", {
          "data-name": $(cur_td).data("name")
        });

        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
        c.attr("name", $(cur_td).data("name") + newid);
        c.appendTo($(td));
        td.appendTo($(tr));
      } else {
        var td = $("<td></td>", {
          'text': $('#tab_material_colocado tr').length
        }).appendTo($(tr));
      }
    });

    // add the new row
    $(tr).appendTo($('#tab_material_colocado'));

    $(tr).find("td button.row-remove").on("click", function() {
      $(this).closest("tr").remove();
    });
  });
  // Sortable Code
  var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();

    $helper.children().each(function(index) {
      $(this).width($originals.eq(index).width())
    });

    return $helper;
  };
  $(".table-sortable tbody").sortable({
    helper: fixHelperModified
  }).disableSelection();
  $(".table-sortable thead").disableSelection();
  $("#add_row_matCol").trigger("click");
