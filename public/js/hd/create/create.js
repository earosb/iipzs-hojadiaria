$(document).ready(function() {
/**
 * Launch modals
 */
  $('#modalDesviador').on('shown.bs.modal');
  $('#modalDesvio').on('shown.bs.modal', function(){
    //document.getElementById("selectdesvio_norte").disabled = true;
    //document.getElementById("selectdesvio_sur").disabled = true;
  });
  $('#modalTrabajo').on('shown.bs.modal');
  $('#modalMaterial').on('shown.bs.modal');

/**
 * Carga los blocks en modal Form Desviador
 */
  $('#selectsectorDesviador').on('change', function(e) {
    e.preventDefault();
    var sector_id = e.target.value;
    ajaxBlocks(sector_id, '#selectblockDesviador');
  });

/**
 * Carga los blocks en form principal
 */
  $('#selectsector').on('change', function(e) {
    e.preventDefault();
    var sector_id = e.target.value;

      $('#selectblock').empty();
      $('.selectubicacion').empty();
      $('.selectubicacion').append('<option disabled selected> Seleccione Sector y Block </option>');

      ajaxBlocks(sector_id, '#selectblock');

  });

/**
 * Carga los blocks en modal desvío
 */
  $('#selectsectorDesvio').on('change', function(e) {
    e.preventDefault();
    var sector_id = e.target.value;
    console.log(sector_id);
    $('#selectblockDesvio').empty();

    ajaxBlocks(sector_id, '#selectblockDesvio');
  });
  
});
