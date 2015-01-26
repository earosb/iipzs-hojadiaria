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
  }).error(function() {
    alert("Error al obtener los datos\n Por favor, verifique su conexión a Internet");
  }).done(function(data) {
    $(select).empty();
    $(select).append('<option disabled selected> Seleccione un Block </option>');

    $.each(data.blocks, function(index, blockObj) {
      $(select).append('<option value="' + blockObj.id + '">' + blockObj.estacion + '</option>');
    });

    $.each(data.ramales, function(index, ramalObj) {
      if (index == 0) {$(select).append('<optgroup label="Ramales">');};
      $(select).append('<option value="' + ramalObj.id + '">' + ramalObj.nombre + '</option>');
      if (index == data.blocks.length - 1) {$(select).append('</optgroup>');};
    });
  });
}

/**
 * Consulta ajax para obtener lo que hay en un block (desvios, desviadores, etc), los mete en el select
 * @param {integer} block_id id del block
 * @return {[type]}    [description]
 */
$('#selectblock').on('change', function(e) {
  e.preventDefault();
  var id_block = e.target.value;

  if (id_block == 'empty') {
    $('.selectubicacion').empty();
  } else {
    $.ajax({
      type: 'get',
      url: '/block/ajax-block-todo/' + id_block
    }).error(function() {
      // ERROR
      alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
    }).done(function(data) {
      /** DONE */
      $('.selectubicacion').empty();
      $('.selectubicacion').append('<optgroup label="Vía Principal">');
      $(".selectubicacion").append("<option value=" + "{'tipo':'block','id':" + data.block.id + "}" + ">" + data.block.estacion + "</option>");
      $('.selectubicacion').append('</optgroup>');

      $.each(data.desvios, function(index, desvioObj) {
        if (index == 0) {
          $('.selectubicacion').append('<optgroup label="Desvíos">');
        };
        $(".selectubicacion").append("<option value=" + "{'tipo':'desvio','id':" + desvioObj.id + "}" + ">" + desvioObj.nombre + "</option>");
        if (index == data.desvios.length - 1) { // Esto no funciona
          $('.selectubicacion').append('</optgroup>');
        };
      });

      $.each(data.desviadores, function(index, desviadoresObj) {
        if (index == 0) { // Esto no funciona
          $('.selectubicacion').append('<optgroup label="Desviadores">');
        };
        $(".selectubicacion").append("<option value=" + "{'tipo':'desviador','id':" + desviadoresObj.id + "}" + ">" + desviadoresObj.nombre + "</option>");
      });
    });
  };
});

/**
 * [description]
 * @param  {[type]} e) {             e.preventDefault();  var $form [description]
 * @return {[type]}    [description]
 */
$("#formModalDesviador").submit(function(e) {
  e.preventDefault();

  var $form = $(this),
    data = $form.serialize(),
    url = $form.attr("action");
  $.ajax({
    url: url,
    type: 'post',
    data: data
  }).error(function() {
    alert("Error al enviar datos\n Por favor verifique su conexión a Internet");
  }).done(function(data) {
    if (data.fail) {
      $('#formModalDesviador .form-group').removeClass('required has-error');
      $('#formModalDesviador .help-block').empty();
      $.each(data.errors, function( index, value ) {
        var errorDiv = '#'+index+'_error';
        $(errorDiv).addClass('required');
        $(errorDiv).empty();
        $.each(value, function(index, val) {
           $(errorDiv).append('<p>'+val+'</p>');
        });
        $('#modalDesviador #'+index+'_div').addClass('required has-error')
      });
    } else {
        $('#modalDesviador').modal('hide');
        $('#selectblock').trigger('change');
        document.getElementById("formModalDesviador").reset();
    };
  });
});