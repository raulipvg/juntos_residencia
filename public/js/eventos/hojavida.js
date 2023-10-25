$(document).ready(function() {
    const form = document.getElementById('Formulario-HojaVida');
    $("#AlertaError2").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'Titulo': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 3,
                                max: 100,
                                message: 'Entre 3 y 100 caracteres'
                            }
                        }
                    },
                    'Descripcion': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 9,
                                max: 500,
                                message: 'Entre 9 y 500 caracteres'
                            }
                            
                        }
                    },
                    'Fecha': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        }
                    },
                    'Enabled': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: 'is-valid'
                    })
                }
            }
    );

    function actualizarValidSelect2(){

        $('.form-select').each( function () {
            var valid = $(this).hasClass("is-valid");
            var invalid =$(this).hasClass("is-invalid");
            if(valid){
                $(this).next().children().children().removeClass("is-invalid").addClass("is-valid");
            }
            if(invalid){
                $(this).next().children().children().removeClass("is-valid").addClass("is-invalid");
            }
            if(!valid && !invalid){
                $(this).next().children().children().removeClass("is-valid");
                 $(this).next().children().children().removeClass("is-invalid");
            }

        });
    }

    const target2 = document.querySelector("#div-bloquear-espacio");
    const blockUI2 = new KTBlockUI(target2)
    let comunidadId;
    let comunidadNombre;
    //Evento al presionar el Boton de Espacios
    $("#tabla-residente tbody").on('click','.ver-hojavida', function (e) {
        e.preventDefault();
        console.log('click')
        blockUI2.block();
        let id = Number($(this).attr("info"));
        miTablaEspacio.clear().draw();
        $.ajax({
            type: 'POST',
            url: HojaVida,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                
                if(data.success){
                    
                    comunidadNombre= data.persona.Nombre;
                    $("#modal-titulo-acceso").empty().html(data.persona.Nombre +" "+ data.persona.Apellido +" - Hoja de Vida ");
                    console.log(data.persona.Id);
                    $("#ComunidadIdInput").prop('disabled', false);
                    comunidadId = data.persona.Id;

                    if(data.data){
                        data=data.data;
                        console.log(data); 

                        for(let row in data){
                            if(data[row].Enabled == 1){
                            var enabled =  '<span class="badge badge-light-success fs-7 text-uppercase estado justify-content-center">Enabled</span>';
                            }else{
                            var enabled = '<span class="badge badge-light-warning fs-7 text-uppercase estado justify-content-center">Disabled</span>';  
                            }

                            var accion = '<div class="btn-group btn-group-sm" role="group">'+
                                            '<a class="ver-espacio btn abrir-modal btn-success" data-bs-stacked-modal="#editar-espacio" info="'+data[row].Id+'">Ver</a>'+
                                            '<a class="editar-espacio abrir-modal btn btn-warning" data-bs-stacked-modal="#editar-espacio" info="'+data[row].Id+'">Editar</a>'+
                                         '</div>';
                                //console.log(rec.estacion.nombreEstacion+` `+datos.momento)
                                var fecha = new Date(data[row].Fecha);

                                // Obtener el día, mes y año
                                var dia = fecha.getDate();
                                var mes = fecha.getMonth() + 1; // Nota: Los meses en JavaScript comienzan en 0
                                var anio = fecha.getFullYear();

                                // Formatear la fecha como "DD-MM-YYYY"
                                var fechaFormateada = dia + "-" + (mes < 10 ? "0" : "") + mes + "-" + anio;

                                var rowNode =  miTablaEspacio.row.add({
                                                    "0": data[row].Id,
                                                    "1": data[row].Titulo,
                                                    "2": fechaFormateada,
                                                    "3": enabled,
                                                    "4": accion    
                                                });
                                var fila = miTablaEspacio.row(rowNode).node();
                                $(fila).find('td').eq(4).addClass('text-center p-0');
                        }
                        miTablaEspacio.draw();
                        
                    }
                    
                    

                    blockUI2.release();
                }else{
                    //console.log("Sin data");
                    blockUI2.release();

                    
                }
            },
            error: function () {
                //alert('Error en editar el usuario');
                blockUI2.release();
                Swal.fire({
                            text: "Error de Carga",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });

                     $(".btn-cerrar22").on("click", function () {
                            //console.log("Error");
                            $('#editar-espacio').modal('toggle');
                     });
            }
        });
    });

    // WEA PARA COLOCAR EL FONDO OSCURO AL MODAL DE ATRAS
    var modal = new bootstrap.Modal(document.getElementById("editar-espacio"));
    $(document).on("click", ".abrir-modal", function () {
        modal.show();
        $("#espaciocomun").css("z-index", 1000);
    });
    $(document).on("click", ".cerrar-modal", function () {
        modal.hide();
        $("#espaciocomun").css("z-index", 1055); 
    });


     // Evento al presionar el Boton de Registrar
     $("#AddBtn-Acceso").on("click", function (e ) {
        //Inicializacion
        //console.log("AddBtn-Acceso")
        e.preventDefault();

        $("#modal-titulo-acceso-registrar").empty().html(comunidadNombre+" - Registrar Hoja de Vida");
        
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit-espacio").show();
        $("#EditSubmit-espacio").hide();
        $("#IdInput-espacio").prop("disabled",true);
        $("#AlertaError2").hide();

        validator.resetForm();
        actualizarValidSelect2();
    });

    const submitButton = document.getElementById('AddSubmit-espacio');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();

        $("#AlertaError2").hide();
        $("#AlertaError2").empty();

        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                 actualizarValidSelect2();

                //console.log('validated!');
                //status
                if (status == 'Valid') {
                    // Show loading indication
                        
                        let form1= $("#Formulario-HojaVida");
                        var fd = form1.serialize();
                        const pairs = fd.split('&');

                        const keyValueObject = {};

                        for (let i = 0; i < pairs.length; i++) {
                            const pair = pairs[i].split('=');
                            const key = decodeURIComponent(pair[0]);
                            const value = decodeURIComponent(pair[1]);
                            keyValueObject[key] = value;
                        }

                        keyValueObject.PersonaId = comunidadId;



                        submitButton.setAttribute('data-kt-indicator', 'on');
                        // Disable button to avoid multiple click
                        submitButton.disabled = true;     
                        // Remove loading indication
                        //submitButton.removeAttribute('data-kt-indicator');
                        // Enable button
                        //submitButton.disabled = true;

                        $.ajax({
                            type: 'POST',
                            url: GuardarHojaVida,
                            data: { 
                                    _token: csrfToken,    
                                    data: keyValueObject 
                                },
                            dataType: "json",
                            //content: "application/json; charset=utf-8",
                            beforeSend: function() {
                                
                            },
                            success: function (data) {
                                //console.log(data.errors);
                                if(data.success){
                                    //console.log("exito");
                                     location.reload();
                                }else{
                                    //console.log(data.error);
                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                       $("#AlertaError2").append(html);

                                    
                                    $("#AlertaError2").show();
                                    
                                   //console.log("error");
                                }
                            },
                            error: function (e) {
                                //console.log(e)
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
                            }
                        });
                    // form.submit(); // Submit form
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        }
    });

    const target = document.querySelector("#div-bloquear-espacio-registrar");
    const blockUI = new KTBlockUI(target);

    //Evento al presionar el Boton Editar
    $("#tabla-espacios tbody").on("click",'.editar-espacio', function (e) {
        e.preventDefault();
        //Inicializacion
        $("#modal-titulo-acceso-registrar").empty().html(comunidadNombre+" - Editar Hoja de Vida");
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit-espacio").hide();
        $("#EditSubmit-espacio").show();
        $("#IdInput-espacio").prop("disabled",false);
        $("#AlertaError2").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));

        blockUI.block();

        $.ajax({
            type: 'POST',
            url: VerHojaVida,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                
                if(data.success){
                    data=data.data;
                    console.log(data);

                    var fechaFormateada = moment.utc(data.Fecha).format('YYYY-MM-DD');

                    //Agrego los valores al formulario
                    $("#IdInput-espacio").val(data.Id);
                    $("#NombreInput2").val(data.Titulo);
                    $("#DescripcionInput").val(data.Descripcion);

                    $("#GarantiaInput").val(fechaFormateada);
                  
                    $("#EnabledInput2").val(data.Enabled).trigger("change");
                    comunidadId =  data.PersonaId;
                    console.log(comunidadId)
                    blockUI.release();
                }else{
                    //console.log("error");
                    blockUI.release();

                    Swal.fire({
                            text: "Error de Carga",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                container: "swal-custom",
                                confirmButton: "btn btn-danger btn-cerrar swal-custom"
                            }
                        });
                    $(".btn-cerrar").on("click", function () {
                            //console.log("Error");
                            $('#editar-espacio').modal('toggle');
                            $("#espaciocomun").css("z-index", 1055);
                    });
                }
            },
            error: function () {
                //alert('Error en editar el usuario');
                blockUI.release();
                Swal.fire({
                            text: "Error de Carga",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                container: "swal-custom",
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });

                     $(".btn-cerrar").on("click", function () {
                            //console.log("Error");
                            $('#editar-espacio').modal('toggle');
                            $("#espaciocomun").css("z-index", 1055);
                     });
            }
        });
    });

    // Manejador al presionar el submit de Editar
    const submitEditButton = document.getElementById('EditSubmit-espacio');
    submitEditButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();
            $("#AlertaError2").hide();
             $("#AlertaError2").empty();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    actualizarValidSelect2();
                    //console.log('validated!');
                    //status
                    if (status == 'Valid') {
                        // Show loading indication
                        submitEditButton.setAttribute('data-kt-indicator', 'on');
                        // Disable button to avoid multiple click
                        submitEditButton.disabled = true;
                        // Remove loading indication
                            submitEditButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitEditButton.disabled = false;

                            

                            let form1= $("#Formulario-HojaVida");
                            var fd = form1.serialize();
                            const pairs = fd.split('&');

                            const keyValueObject = {};

                            for (let i = 0; i < pairs.length; i++) {
                                const pair = pairs[i].split('=');
                                const key = decodeURIComponent(pair[0]);
                                const value = decodeURIComponent(pair[1]);
                                keyValueObject[key] = value;
                            }
                            console.log(comunidadId)
                            keyValueObject.PersonaId = comunidadId;

                             $.ajax({
                                type: 'POST',
                                url: EditarHojaVida,
                                data: {
                                    _token: csrfToken,
                                    data: keyValueObject},
                                //content: "application/json; charset=utf-8",
                                dataType: "json",
                                success: function (data) {
                                    //console.log(data.errors);
                                    if(data.success){
                                        //console.log("exito");
                                         location.reload();
                                    }else{
                                        console.log(data.message)

                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                        $("#AlertaError2").append(html);

                                        $("#AlertaError2").show();
                                       //console.log("error");
                                    }
                                },
                                error: function () {
                                    //alert('Error');
                                    Swal.fire({
                                        text: "Error",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        customClass: {
                                            container: "swal-custom",
                                            confirmButton: "btn btn-danger btn-cerrar"
                                        }
                                    });
                                }
                            });
                            //form.submit(); // Submit form
                        } //endif
                 });
            }
    });

    $("#tabla-espacios tbody").on("click",'.ver-espacio', function () {
        //console.log("wena");
        $("#modal-titulo-acceso-registrar").empty().html(comunidadNombre+" - Ver Hoja de Vida");
        $("input").val('');
        $('.form-select').val("").trigger("change");
        $("#AddSubmit-espacio").hide();
        $("#EditSubmit-espacio").hide();
        $("#IdInput-espacio").prop("disabled",false);
        $("#AlertaError2").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));
        blockUI.block();

        $.ajax({
            type: 'POST',
            url: VerHojaVida,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);
                if(data){

                    data= data.data
                    //console.log("wena");
                    //Agrego los valores al formulario

                    var fechaFormateada = moment.utc(data.Fecha).format('YYYY-MM-DD');

                    $("#IdInput-espacio").val(data.Id).prop("disabled", true);
                    $("#NombreInput2").val(data.Titulo).prop("disabled", true);
                    $("#DescripcionInput").val(data.Descripcion).prop("disabled", true);

                    $("#GarantiaInput").val(fechaFormateada).trigger("change").prop("disabled", true);
                  
                    $("#EnabledInput2").val(data.Enabled).trigger("change").prop("disabled", true);
                    
                    blockUI.release();

                }else{
                    //console.log("error");
                    blockUI.release();

                    Swal.fire({
                            text: "Error de Carga",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                container: "swal-custom",
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });

                     $(".btn-cerrar").on("click", function () {
                        $('#editar-espacio').modal('toggle');
                        $("#espaciocomun").css("z-index", 1055);
                     });

                }


            },
            error: function () {
                //alert('Error en editar el usuario');
                blockUI.release();

                Swal.fire({
                            text: "Error de Carga",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                container: "swal-custom",
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });

                    $(".btn-cerrar").on("click", function () {
                        $('#editar-espacio').modal('toggle');
                        $("#espaciocomun").css("z-index", 1055);
                    });
            }
        });
    });
});