$('#formHojaDiaria').submit(function(e) {
  e.preventDefault();

  var $form = $(this),
    data = $form.serialize(),
    url = $form.attr("action");

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
        if (index.substring(0, 8) == 'trabajos') {
          document.getElementById(index).setAttribute("class", "form-group required has-error");
        }else if(index.substring(0, 6) == 'matCol'){
          document.getElementById(index).setAttribute("class", "form-group required has-error");
        }else if(index.substring(0, 6) == 'matRet'){
          document.getElementById(index).setAttribute("class", "form-group required has-error");
        }else{
          var errorDiv = '#'+index+'_error';
          $(errorDiv).addClass('required');
          $(errorDiv).empty();
          $.each(value, function(index, val) {
             $(errorDiv).append('<p>'+val+'</p>');
          });
          $('#formHojaDiaria #'+index+'_div').addClass('required has-error');
        }
      });
    } else {
        // todo bene
        $('#formHojaDiaria .form-group').removeClass('required has-error');
        $('#formHojaDiaria .help-block').empty();
    }
  });

});
