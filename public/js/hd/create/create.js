$(document).ready(function() {
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
   * Lanza calendario
   */
  $("#fecha").datepicker({
    defaultDate: "-1m",
    numberOfMonths: 2,
    showAnim: "slideDown",
    beforeShow: function() {
      $(".ui-datepicker").css('font-size', 12)
    }
  });
  
});
