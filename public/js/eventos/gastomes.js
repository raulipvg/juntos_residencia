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

    
    $('#GastoMesIdInput').on('select2:select', function(e) {
        e.preventDefault();
        e.stopPropagation();
        //console.log("click Mes");   
 
        bloquear();
        let ComunidadId = $("#ComunidadInput").val();
        let GastoMesId = $(this).val(); 
        console.log(GastoMesId)
        $.ajax({
            type: 'POST',
            url: VerMeses,
            data: { 
                    _token: csrfToken,    
                    data: ComunidadId 
                },
            dataType: "json",
            //content: "application/json; charset=utf-8",
            beforeSend: function() {
                KTApp.showPageLoading();
            },
            success: function (data) {
                //console.log(data);
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

    const abrirMes = document.getElementById('AccionMesInput');
    //EVENTO QUE MANEJA EL SUBMIT PARA ABRIR O CERRAR UN MES DE GASTO MES
    abrirMes.addEventListener('click', function (e) { 
        e.preventDefault();
        e.stopPropagation();  
        bloquear();
        let ComunidadId = $("#ComunidadInput").val();
        if(abrirMes.classList.contains('abrir-mes')){
            abrirMes.classList.remove('abrir-mes','btn-success');
            abrirMes.classList.add('cerrar-mes','btn-warning');
            abrirMes.textContent = 'CERRAR MES'
            //console.log("Abrir Mes")
            //console.log(comunidadInputValue);
            //console.log(gastoMesIdInputValue);   

            // Encuentra el elemento contenedor <div class="col ms-2 text-end">
            var tag= $(this).parent().next('.col.ms-2.text-end');
           
            //console.log(ComunidadId)
            $.ajax({
                type: 'POST',
                url: AbrirMes,
                data: { 
                        _token: csrfToken,    
                        data: ComunidadId,
                    },
                dataType: "json",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    //console.log(data);
                    if(data.success){
                         location.reload();
                    }else{
                        Swal.fire({
                            text: "Error: "+data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });                        
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

        }else if(abrirMes.classList.contains('cerrar-mes')){
            //console.log("Cerrar Mes")
            var gastoMesId = $("#GastoMesIdInput").val();
            $.ajax({
                type: 'POST',
                url: CerrarMes,
                data:{ 
                        _token: csrfToken,    
                        data: {ComunidadId, gastoMesId} 
                    },
                dataType: "json",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    //console.log(data);
                    if(data.success){
                        abrirMes.classList.remove('cerrar-mes','btn-warning');
                        abrirMes.classList.add('btn-dark','disabled');
                        abrirMes.textContent =  'MES CERRADO';
                        $("#NuevoGasto").remove();
                        $("#agregar-gasto").empty();                
                         //location.reload();
                    }else{
                        Swal.fire({
                            text: "Error",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });                        
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

        }
    
    });
    
    const abrirMes2 = document.getElementById('AbrirMesInput2');
    abrirMes2.addEventListener('click', function (e) { 
        e.preventDefault();
        e.stopPropagation();  
        bloquear();
        let ComunidadId = $("#ComunidadInput").val();
            //console.log("Abrir Mes")
            //console.log(comunidadInputValue);
            //console.log(gastoMesIdInputValue);   

            // Encuentra el elemento contenedor <div class="col ms-2 text-end">
            var tag= $(this).parent().next('.col.ms-2.text-end');
           
            //console.log(ComunidadId)
            $.ajax({
                type: 'POST',
                url: AbrirMes,
                data: { 
                        _token: csrfToken,    
                        data: ComunidadId,
                    },
                dataType: "json",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    //console.log(data);
                    if(data.success){
                         location.reload();
                    }else{
                        Swal.fire({
                            text: "Error: "+data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });                        
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
    let flag=true;
    //EVENTO que agrega un Gasto Detalle
    $("#div-adm").on("click",'#NuevoGasto', function(e) {
        e.preventDefault();
        e.stopPropagation();    
        //console.log("Agregar Gasto")
        let comunidadId = $("#ComunidadInput").val();
        //let gastoMesId = $("#GastoMesIdInput").val();
        if(flag){
            flag= false;
            bloquear();
            $.ajax({
                type: 'POST',
                url: NuevoGasto,
                data: { 
                        _token: csrfToken,    
                        data: {comunidadId } 
                    },
                dataType: "html",
                //content: "application/json; charset=utf-8",
                beforeSend: function() {
                    KTApp.showPageLoading();
                },
                success: function (data) {
                    //console.log(data);
                    $("#agregar-gasto").append(data)
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
        }
    });
    $("#agregar-gasto").on("click", '.cerrar-gasto', function (e) {
        //console.log("cerrar")
        var script = document.getElementById('prueba');
        script.parentNode.removeChild(script);
        e.preventDefault();
        if(!flag){flag=true;}       
    });

});