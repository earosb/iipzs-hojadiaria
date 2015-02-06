/**
 * Created by earosb on 05-02-15.
 */

function verHojaDiaria(id) {

    $.ajax({
        url: '/hd/'+id,
        type: 'GET'
    })
        .success(function (data) {
            console.log(data);
            if(data.error){

            }else{
                $.each(data.hojaDiaria.detalle_hoja_diaria, function(index, value){

                });
                if(data.hojaDiaria.observaciones){
                    $('#modalHojaDiaria #obs').append('<p>' + data.hojaDiaria.observaciones + '</p>');
                }
            }

        })
        .error(function () {
            console.log("error");
        })
        .always(function () {
            $('#modalHojaDiaria').modal('show');
        });
}
function editarHojaDiaria(id) {
    console.log('editar() ID ' + id);
}
function borrarHojaDiaria(id) {
    console.log('editar() ID ' + id);
}
