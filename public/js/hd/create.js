$(document).ready(function() {
  /**
   * Consulta ajax para obtener los blocks de un sector, los mete en el select
   * @param  {[type]} e) {e.preventDefault();  var sector_id [description]
   * @return {[type]}    [description]
   */
  $('#selectsector').on('change', function(e) {
    e.preventDefault();
    var sector_id = e.target.value;
    // console.log(sector_id);
    if (sector_id == 'empty') {
      $('#selectblock').empty().selectpicker('refresh');
      $('.selectubicacion').empty();
      $('.selectubicacion').append('<option value="">Seleccione Sector y Block</option>');
    } else {
      $.ajax({
        url: '/block/ajax-blocks/' + sector_id
      }).error(function() {
        // ERROR
        alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
      }).done(function(data) {
        // DONE
        $('#selectblock').empty();
        $('#selectblock').append('<option value="">Seleccione un Block</option>');
        $('.selectubicacion').empty();
        $('.selectubicacion').append('<option value="">Seleccione un Block</option>');

        $.each(data.blocks, function(index, blockObj) {
          $('#selectblock').append('<option value="' + blockObj.id + '">' + blockObj.estacion + '</option>').selectpicker('refresh');
        });

        $.each(data.ramales, function(index, ramalObj) {
          $('#selectblock').append('<option value="' + ramalObj.id + '">' + ramalObj.nombre + '</option>').selectpicker('refresh');
        });

      });
    };

  });

  /**
   * Consulta ajax para obtener lo que hay en un block (desvios, desviadores, etc), los mete en el select
   * @param  {[type]} e) {             e.preventDefault();  var id_block [description]
   * @return {[type]}    [description]
   */
  $('#selectblock').on('change', function(e) {
    e.preventDefault();
    var id_block = e.target.value;

    if (id_block == 'empty') {
      $('.selectubicacion').empty();
    } else {
      $.ajax({
        url: '/block/ajax-block-todo/' + id_block
      }).error(function() {
        // ERROR
        alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
      }).done(function(data) {
        /** DONE */
        $('.selectubicacion').empty();

        $('.selectubicacion').append('<option value="' + data.block.id + '">' + data.block.estacion + '</option>');

        $.each(data.desvios, function(index, desvioObj) {
          if (index == 0) { // Esto no funciona
            $('.selectubicacion').append('<optgroup label="Desvíos">');
          };
          $('.selectubicacion').append('<option value="' + desvioObj.id + '">' + desvioObj.nombre + '</option>');
          if (index == data.desvios.length - 1) { // Esto no funciona
            $('.selectubicacion').append('</optgroup>');
          };
        });

        $.each(data.desviadores, function(index, desviadoresObj) {
          if (index == 0) { // Esto no funciona
            $('.selectubicacion').append('<optgroup label="Desviadores">');
          };
          $('.selectubicacion').append('<option value="' + desviadoresObj.id + '">' + desviadoresObj.nombre + '</option>');
        });

      });
    };
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
              id: "addr"+newid + "]",
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
                  id: "addrMatCol"+newid,
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
});

