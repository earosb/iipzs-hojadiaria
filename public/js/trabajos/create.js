$('#selectsector').on('change', function(e) {
  e.preventDefault();
  var sector_id = e.target.value;
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
  
});