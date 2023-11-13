$(document).ready(function() {

    $("#tabla-gasto-comun").on('select2:select', '#GastoMesIdInput', function(e){
        e.preventDefault();
        e.stopPropagation();
        console.log('select2')

        let ComunidadId = $("#ComunidadInput").val();
        let GastoMesId = $(this).val(); 
    });


});