$('#selectsector').on('change', function(e) {
  e.preventDefault();
  var sector_id = e.target.value;

/*  
  if (sector_id == 'empty') {
    $('#selectblock').empty().selectpicker('refresh');
  } else{
    $.get('/blocks/ajax-blocks/' + sector_id, function(data) {
      $('#selectblock').empty();
      $.each(data, function(index, blockObj){
        $('#selectblock').append('<option value="'+blockObj.id+'">'+blockObj.estacion+'</option>')
        .selectpicker('refresh');
    });
  });    
  };
*/
  if (sector_id == 'empty') {
      $('#selectblock').empty().selectpicker('refresh');
    } else {
      $.ajax({
        url:'/blocks/ajax-blocks/' + sector_id
        }).error(function(){
        // ERROR
          //document.getElementById('msg_error').style.display = 'block';
          alert("Error al obtener los datos\n Por favor verifique su conexión a Internet");
        }).done(function(data){
          // DONE
          $('#selectblock').empty();
            $.each(data, function(index, blockObj){
              $('#selectblock').append('<option value="'+blockObj.id+'">'+blockObj.estacion+'</option>')
              .selectpicker('refresh');
          });
        });
    };
  
});