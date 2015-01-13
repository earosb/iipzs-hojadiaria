$('#selectsector').on('change', function(e) {
  e.preventDefault();
  var id_sector = e.target.value;

  if (id_sector == 'empty') {
      $('#selectblock').empty().selectpicker('refresh');
    } else {
      $.ajax({
        url:'/block/ajax-blocks/' + id_sector
        }).error(function(){
          // ERROR
          alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
        }).done(function(data){
            // DONE
            $('#selectblock').empty();
            $('#selectblock').append('<option value="">Seleccione un Block</option>');
            $.each(data, function(index, blockObj){
              $('#selectblock').append('<option value="'+blockObj.id+'">'+blockObj.estacion+'</option>')
              .selectpicker('refresh');
          });
        });
    };
  
});

$('#selectblock').on('change', function(e) {
  e.preventDefault();
  var id_block = e.target.value;

  if (id_block == 'empty') {
      $('#selectubicacion').empty().selectpicker('refresh');
    } else {
      $.ajax({
        url:'/block/ajax-block-todo' + id_block
        }).error(function(){
          // ERROR
          alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
        }).done(function(data){
          // DONE
          $('#selectubicacion').empty();
            $.each(data, function(index, blockObj){
              $('#selectubicacion').append('<option value="'+blockObj.id+'">'+blockObj.estacion+'</option>')
              .selectpicker('refresh');
          });
        });
    };
  
});