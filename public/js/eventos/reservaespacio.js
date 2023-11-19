$(document).ready(function() {
    //let ComunidadId = 1;
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
    const btnAgregar='<button type="button" class="btn-plus btn btn-sm agregar-reserva btn-icon  btn-color-danger btn-active-light btn-active-color-primary position-absolute">'+
                        '<i class="ki-outline ki-plus-square fs-2"></i>'+
                    '</button>';
    const btnVerSoli =  '<button id="VerSolicitudes" name="VerSolicitudes" type="button" class="btn btn-sm btn-primary" style="height: 42.56px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver solicitudes">'+
                            'VER SOLICITUDES  <i class="ki-outline ki-eye fs-2"></i>'+
                        '</button>'
    //EVENTO SELECT2 PARA CAPTURAR EL ESTADO DEL GASTO MES
    $('#GastoMesIdInput').on('select2:select', function(e) {
        e.preventDefault();
        e.stopPropagation();

        //CAPTURO EL VALOR DE DATA-INFO
        var dataInfo = e.params.data.element.dataset.info; 

        if (dataInfo == 2){
            $(".agregar-reserva").remove()
        }else{
            $(".nav-item.position-relative.me-0").prepend(btnAgregar)
        }
        $("#contenedor-2").empty();
        $("#contenedor-3").empty();
        $("#contenedor-3").removeClass("top-xl top-md");
        $(".ver-cobro").removeClass("active");
    });

    var modal = new bootstrap.Modal(document.getElementById("modal-ver-solicitudes"));

    $('#VerSolicitudes').click(function(e){
        e.preventDefault();
        e.stopPropagation();  
        let comunidadId = $("#ComunidadInput").val();
        let gastoMesId = $("#GastoMesIdInput").val();
        $('#tabla-solicitudes').empty()
        $.ajax({
            type: 'POST',
            url : VerSolicitudes,
            data: {
                _token: csrfToken,    
                data: { comunidadId, gastoMesId } 
            },
            dataType: 'html',
            success: function(data){
                
                $('#tabla-solicitudes').html(data)
                agregarAccionesSoli()
            },
            complete: function(e){
                modal.show()
            }
            
        })

    })

    $("#propiedades-ctrl").on('click', '.ver-reserva', function(e){
        //console.log("ver COBRO")
        e.preventDefault();
        e.stopPropagation();    
        //console.log("Agregar Gasto")
        let comunidadId = $("#ComunidadInput").val();
        let propiedadId = $(this).attr("data-info");
        let gastoMesId = $("#GastoMesIdInput").val();
        //console.log(comunidadId)
        //console.log(propiedadId)
            bloquear();
            $.ajax({
                type: 'POST',
                url: VerReserva,
                data: { 
                        _token: csrfToken,    
                        data: { comunidadId, propiedadId,gastoMesId } 
                    },
                dataType: "html",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    //console.log(data);
                    $("#contenedor-3").html(data)
                   
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

    $("#propiedades-ctrl").on('click', '.agregar-reserva', function(e){
        
        e.preventDefault();
        e.stopPropagation();    
        
        let comunidadId = $("#ComunidadInput").val();
        let propiedadId = $(this).next().children().attr("data-info");;
        let gastoMesId = $("#GastoMesIdInput").val()

        
            flag= false;
            bloquear();
            $.ajax({
                type: 'POST',
                url: AgregarReserva,
                data: { 
                        _token: csrfToken,    
                        data: { comunidadId, propiedadId, gastoMesId } 
                    },
                dataType: "html",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    console.log(data);
                    $("#contenedor-3").addClass("top-xl top-md")
                    $("#contenedor-2").html(data)
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

    function agregarAccionesSoli(){
        
        $("#tabla-solicitudes tbody").on('click', '.cambiarEstado', function(e){
            let reservaId = $(this).attr('state')
            let estado;
            if($(this).attr('title')=='Aprobar'){
                estado = 2;
            }else{
                estado = 3;
            }
            var boton = $(this);
            $.ajax({
                type: 'POST',
                url: CambiarEstado,
                data: { 
                        _token: csrfToken,    
                        data: { reservaId, estado } 
                    },
                dataType: "json",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    if(data.success){
                        var divPadre = boton.parent();
                        divPadre.children().remove();
                        if(estado == 2){
                            divPadre.html('<span class="badge badge-success w-95px justify-content-center"> APROBADO </span>')
                        }
                        else{
                            divPadre.html('<span class="badge badge-danger w-95px justify-content-center"> RECHAZADO </span>')
                        }
                    }else{             
                        if(data.codigo == 1)
                        Swal.fire({
                            text: data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        })
                        else{
                            Swal.fire({
                                text: "Error",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: "btn btn-danger btn-cerrar"
                                }
                            })
                        }
                    }
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
        })
    }

});