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
    const btnAgregar='<button type="button" class="btn-plus btn btn-sm agregar-cobro btn-icon  btn-color-danger btn-active-light btn-active-color-primary position-absolute">'+
                        '<i class="ki-outline ki-plus-square fs-2"></i>'+
                    '</button>';
    
    //EVENTO SELECT2 PARA CAPTURAR EL ESTADO DEL GASTO MES
    $('#GastoMesIdInput').on('select2:select', function(e) {
        e.preventDefault();
        e.stopPropagation();

        //CAPTURO EL VALOR DE DATA-INFO
        var dataInfo = e.params.data.element.dataset.info; 

        if (dataInfo == 2){
            $(".agregar-cobro").remove()
        }else{
            $(".nav-item.position-relative.me-0").prepend(btnAgregar)
        }
        $("#contenedor-2").empty();
        $("#contenedor-3").empty();
        $("#contenedor-3").removeClass("top-xl top-md");
        $(".ver-cobro").removeClass("active");
        //console.log(dataInfo)
    });

    $("#propiedades-ctrl").on('click', '.ver-cobro', function(e){
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
                url: VerCobro,
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

    $("#propiedades-ctrl").on('click', '.agregar-cobro', function(e){
        console.log("Agregar Cobro")
        e.preventDefault();
        e.stopPropagation();    
        //console.log("Agregar Gasto")
        let comunidadId = $("#ComunidadInput").val();
        let propiedadId = $(this).next().children().attr("data-info");
        //console.log(comunidadId)
        //console.log(propiedadId)

        
            //flag= false;
            bloquear();
            $.ajax({
                type: 'POST',
                url: AgregarCobro,
                data: { 
                        _token: csrfToken,    
                        data: { comunidadId, propiedadId } 
                    },
                dataType: "html",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    //console.log(data);
                    $("#contenedor-3").addClass("top-xl top-md")
                    $("#contenedor-2").html(data)
                    //("#contenedor-1").addClass("mb-prueba")
                    if(data.success){
                        //location.reload();
                    }else{             
                        
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
        
    
    });


});