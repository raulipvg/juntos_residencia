// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl

$(document).ready(function() {

    $(".div-loading").hide();

    $(".modal-close").click(function() {
        destruirTabla()
        //console.log('destruida')
    });
    
   // Función para manejar el clic en el botón
    $("#lista-usuario").click(function(e) {
        e.preventDefault();
        inicializarTabla(1)
       //$("#tabla-usuario").width('100%')
        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
    });

    // Función para manejar el clic en el botón
    $("#lista-curso").click(function() {
        inicializarTabla(2)
        //$("#tabla-curso").width('100%')
        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
    });


    // Función para manejar el clic en el botón
    $("#lista-certificado").click(function() {
        inicializarTabla(3)
        //$("#tabla-certificado").width('100%')
        $('.flex-wrap').each(function () {
            $(this).removeClass('flex-wrap')
        });
    });


     //EVENTO SELECT2 DE IMAGEN
     $('#criterio-curso').on("select2:selecting", function(e) {
        let criterio =  e.params.args.data.id;

        console.log(criterio)
        //$("#tabla-body").append(loading);
        $.ajax({
            type: "POST",
            url: "../controller/locallib_general.php",
            data: { accion: 3},
            dataType: "json",
            beforeSend: function() {

            },
            success: function (data) {
                //$("#loading").remove();
                //console.log(data);
                if (data) {
                    


                } else {
                    
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar"
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log("Error: " + status + " - " + error);
                $("#loading").remove();
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            },           
        });
    });


});