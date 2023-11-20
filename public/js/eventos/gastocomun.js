$(document).ready(function() {

    var loadingEl = document.createElement("div");

    function bloquear(){
        document.body.prepend(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.classList.add("flex-column");
        loadingEl.classList.add("bg-dark");
        loadingEl.classList.add("bg-opacity-25");
        loadingEl.innerHTML = `<span class="spinner-border text-primary" role="status"></span>
                               <span class="text-gray-800 fs-6 fw-semibold mt-5">Cargando...</span>`;

    }

    $("#GastoMesIdInput").on('select2:select', function(e){
        e.preventDefault();
        e.stopPropagation();
        //console.log('select2')
        bloquear();
        let ComunidadId = $("#ComunidadInput").val();
        let GastoMesId = $(this).val(); 

        //console.log(GastoMesId)
        $.ajax({
            type: 'GET',
            url: VerGastosComunes,
            data: { 
                    _token: csrfToken,    
                    data: { ComunidadId,GastoMesId } 
                },
            dataType: "HTML",
            //content: "application/json; charset=utf-8",
            beforeSend: function() {
                KTApp.showPageLoading();
            },
            success: function (data) {
                //console.log(data);
                miTabla.destroy();
                $("#contenedor-1").html(data);
                             
            },
            error: function (e) {
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            },
            complete: function(){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
            
        });

    });

    $(document).on("click", "#tabla-gasto-comun tbody .ver-cobro-invididual", function (e) {

        e.preventDefault();
        e.stopPropagation();
        //console.log("ver cobro invidividual")

        let tr = e.target.closest('tr');
        let row = miTabla.row(tr);
        //$(tr).addClass('miClaseNueva');

        let data = {
            gastoMesId: $("#GastoMesIdInput").val(),
            propiedadId: $(tr).attr("data-info")
        }
        //console.log(data)
        bloquear();
        $.ajax({
            type: 'POST',
            url: VerCobro2,
            data: {
                _token: csrfToken,
                data: data},
            //content: "application/json; charset=utf-8",
            dataType: "html",
            beforeSend: function () {
                KTApp.showPageLoading();
            },
            success: function (data) {
                //console.log(data);
               
                //boton.removeAttr("data-kt-indicator");
                //boton.children().eq(0).show();
                //boton.addClass('active')
                
                row.child(data).show();
                $(tr).next('tr').addClass("detalle-cobro");
                
            },
            error: function () {
                //alert('Error');
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            },
            complete: function(e){
                KTApp.hidePageLoading();
                loadingEl.remove();
            }
        });
    
    });

    $("#tabla-gasto-comun tbody").on("click",'.cerrar-cobro', function (e) {
        e.preventDefault();

        let tr = e.target.closest('tr');
        //let row = miTabla.row(tr);
            $(tr).remove();
            //console.log(tr)
    });


    $(document).on("click", "#tabla-gasto-comun tbody .ver-detalle", function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("ver DETALLE")

        let tr = e.target.closest('tr');
        g= $("#GastoMesIdInput").val();
        p= $(tr).attr("data-info");
        c= $("#ComunidadInput").val();

        var redirectUrl = VerDetalle+"/" + '?g=' + g + '&p=' + p + '&c=' + c;
        window.open(redirectUrl, '_blank');
        //window.location.href = redirectUrl;    
    });

    // Evento de select2 de comunidad
    $('#ComunidadInput').on('select2:select', function(e){
        e.preventDefault();
        e.stopPropagation();
        c= $("#ComunidadInput").val();
        console.log(c)

        var redirectUrl = VerGastosComunes + "/" + '?&c=' + c;
        window.location.href = redirectUrl;

    })

});