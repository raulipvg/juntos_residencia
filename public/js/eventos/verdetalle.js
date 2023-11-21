$(document).ready(function() {
    
	 // Evento de select2 de comunidad
     $('#GastoMesIdInput').on('select2:select', function(e){
        e.preventDefault();
        e.stopPropagation();
        c = $("#ComunidadInput").val();
        g = $('#GastoMesIdInput').val();
        p = propiedadId;
        console.log("c = "+ c)
        console.log("g = "+ g)
        console.log("p = "+ p)

        var redirectUrl = VerDetalle + "/" + '?&c=' + c + '&g=' + g + '&p=' + p;
        window.location.href = redirectUrl;

    })
});