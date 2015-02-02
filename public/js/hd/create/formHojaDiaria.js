$('#formHojaDiaria').submit(function(e) {
  e.preventDefault();

  var $form = $(this),
    data = $form.serialize(),
    url = $form.attr("action");
    console.log(url);
    console.log(data);
  $.ajax({
    url: url,
    type: 'post',
    dataType: 'json',
    data: data
  }).fail(function() {
    alert("Error al enviar datos\nPor favor verifique su conexión a Internet");
  }).done(function(data) {
    if (data.fail) {
      $('#formHojaDiaria .form-group').removeClass('required has-error');
      $('#formHojaDiaria .help-block').empty();
      $.each(data.errors, function( index, value ) {
        var errorDiv = '#'+index+'_error';
        $(errorDiv).addClass('required');
        $(errorDiv).empty();
        $.each(value, function(index, val) {
           $(errorDiv).append('<p>'+val+'</p>');
        });
        $('#formHojaDiaria #'+index+'_div').addClass('required has-error');
      });
    } else {
        // todo bene
        $('#formHojaDiaria .form-group').removeClass('required has-error');
        $('#formHojaDiaria .help-block').empty();
        console.log(data);
    }
  });

});
