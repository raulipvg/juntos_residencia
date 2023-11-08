// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl

$(document).ready(function() {

    const form = document.getElementById('Formulario1');
    $("#AlertaError").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'Username': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 4,
                                max: 25,
                                message: 'Entre 4 y 25 caracteres'
                            }
                        }
                    },
                    'Password': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 8,
                                max: 100,
                                message: 'Entre 8 y 50 caracteres'
                            }
                        }
                    },
                    'Nombre': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 3,
                                max: 20,
                                message: 'Entre 3 y 20 caracteres'
                            },
                            regexp: {
                                regexp: /^[a-zñáéíóú\s]+$/i,
                                message: 'Solo letras de la A-Z '
                            }
                        }
                    },
                    'Apellido': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 3,
                                max: 20,
                                message: 'Entre 3 y 20 caracteres'
                            },
                            regexp: {
                                regexp: /^[a-zñáéíóú\s]+$/i,
                                message: 'Solo letras de la A-Z '
                            }
                        }
                    },
                    'Correo': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            emailAddress: {
                                message: 'Email inválido'
                            }
                        }
                    },     
                    'ComunidadId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    },       
                    'RolId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    },
                    'EstadoId': {
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

    const form2 = document.getElementById('Formulario-Acceso');
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator2 = FormValidation.formValidation(
            form2,
            {
                fields: {   
                    'ComunidadId': {
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

    const target = document.querySelector("#div-bloquear");
    const blockUI = new KTBlockUI(target)

    function actualizarValidSelect2(){

        $('.form-select').each( function () {
            var valid = $(this).hasClass("is-valid");
            var invalid =$(this).hasClass("is-invalid");

            //console.log("valid: "+valid+" invalid: "+invalid)
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

     // Evento al presionar el Boton de Registrar
    $("#AddBtn").on("click", function (e) {
        //Inicializacion
        //console.log("AddBtn")
        e.preventDefault();
        e.stopPropagation();
        $("#modal-titulo").empty().html("Registrar Usuario");
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);
        //$('#EstadoIdInput').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit").show();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled",true);
        $("#AlertaError").hide();
        $("#AccesoComunidadId").remove();

        $("#ComunidadIdInput").parent().show();
        $("#ComunidadIdInput").prop("disabled",false)

        validator.resetForm();
        actualizarValidSelect2();
    });

    // Manejador al presionar el submit de Registrar
    const submitButton = document.getElementById('AddSubmit');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();

        $("#AlertaError").hide();
        $("#AlertaError").empty();
        
        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                 actualizarValidSelect2();

                //console.log('validated!');
                //status
                if (status == 'Valid') {
                    // Show loading indication                       
                        let form1= $("#Formulario1");
                        var fd = form1.serialize();
                        const pairs = fd.split('&');

                        const keyValueObject = {};
                       
                        for (let i = 0; i < pairs.length; i++) {
                            const pair = pairs[i].split('=');
                            const key = decodeURIComponent(pair[0]);
                            const value = decodeURIComponent(pair[1]);
                            keyValueObject[key] = value;
                        }

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        // Disable button to avoid multiple click
                        submitButton.disabled = true;     
                        // Remove loading indication
                        //submitButton.removeAttribute('data-kt-indicator');
                        // Enable button
                        //submitButton.disabled = true;
                        blockUI.block();
                        $.ajax({
                            type: 'POST',
                            url: GuardarUsuario,
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
                                blockUI.release();
                                if(data.success){
                                    //console.log("exito");
                                     location.reload();
                                }else{
                                    //console.log(data.error);
                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                       $("#AlertaError").append(html);

                                    
                                    $("#AlertaError").show();
                                    
                                   //console.log("error");
                                }
                            },
                            error: function (e) {
                                blockUI.release();
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

    //Evento al presionar el Boton Editar
    $("#tabla-usuario tbody").on("click",'.editar', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //Inicializacion
        $("#modal-titulo").empty().html("Editar Usuario");
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit").hide();
        $("#EditSubmit").show();
        $("#IdInput").prop("disabled",false);
        $("#AlertaError").hide();

        $("#ComunidadIdInput").parent().hide();
        $("#ComunidadIdInput").prop("disabled",true);

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));

        blockUI.block();
        $.ajax({
            type: 'POST',
            url: VerUsuario,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                blockUI.release();
                if(data.success){
                    acceso= data.acceso
                    data=data.data;
                    //console.log("wena");
                    //Agrego los valores al formulario\
                    // Crear un elemento input de tipo number
                    var input = document.createElement("input");
                    input.type = "number";

                    // Establecer los atributos según tus necesidades
                    input.id = "AccesoComunidadId";
                    input.name = "AccesoComunidadId";
                    input.value = acceso[0].Id;  // Valor inicial
                    
                    // Ocultar el elemento
                    input.style.display = "none";

                    // Obtener el formulario por su id
                    var formulario = document.getElementById("Formulario1");

                    // Agregar el elemento al formulario
                    formulario.appendChild(input);

                    $("#IdInput").val(data.Id);
                    $("#UsernameInput").val(data.Username);
                    $("#PasswordInput").val("********");

                    $("#NombreInput").val(data.Nombre);
                    $("#ApellidoInput").val(data.Apellido);
                    $("#CorreoInput").val(data.Correo);
                  
                    $('#RolIdInput').val(data.RolId).trigger("change");
                    $('#EstadoIdInput').val(data.EstadoId).trigger("change");
                    $('#ComunidadIdInput').val(acceso[0].ComunidadId).trigger("change");
                }else{
                    Swal.fire({
                            text: "Error de Carga",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });
                    $(".btn-cerrar").on("click", function () {
                            //console.log("Error");
                            $('#registrar').modal('toggle');
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
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });

                     $(".btn-cerrar").on("click", function () {
                            //console.log("Error");
                            $('#registrar').modal('toggle');
                     });
            }
        });
        
    });

    // Manejador al presionar el submit de Editar
    const submitEditButton = document.getElementById('EditSubmit');
    submitEditButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();
            e.stopPropagation();
            $("#AlertaError").hide();
            $("#AlertaError").empty();
            blockUI.block();
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

                            let form1= $("#Formulario1");
                            var fd = form1.serialize();
                            const pairs = fd.split('&');

                            const keyValueObject = {};

                            for (let i = 0; i < pairs.length; i++) {
                                const pair = pairs[i].split('=');
                                const key = decodeURIComponent(pair[0]);
                                const value = decodeURIComponent(pair[1]);
                                keyValueObject[key] = value;
                            }
                            
                            $.ajax({
                                type: 'POST',
                                url: EditarUsuario,
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
                                        //console.log(data.message)
                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                        $("#AlertaError").append(html);

                                        $("#AlertaError").show();
                                       //console.log("error");
                                    }
                                    blockUI.release();
                                },
                                error: function () {
                                    //alert('Error');
                                    blockUI.release();
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
                            
                            //form.submit(); // Submit form
                        } //endif
                 });
            }
    });

    //Evento al presionar el Boton VER
    $("#tabla-usuario tbody").on("click",'.ver', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //console.log("wena");
        $("#modal-titulo").empty().html("Ver Usuario");
        $("input").val('');
        $('.form-select').val("").trigger("change");
        $("#AddSubmit").hide();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled",false);
        $("#AlertaError").hide();

        $("#ComunidadIdInput").parent().hide();
        $("#ComunidadIdInput").prop("disabled",true);

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));
        blockUI.block();
        $.ajax({
            type: 'POST',
            url: VerUsuario,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);
                if(data){
                    acceso= data.acceso
                    data= data.data
                    //console.log("wena");
                    //Agrego los valores al formulario
                    $("#IdInput").val(data.Id);
                    $("#UsernameInput").val(data.Username).prop("disabled", true);;
                    $("#PasswordInput").val("********").prop("disabled", true);;
                    $("#NombreInput").val(data.Nombre).prop("disabled", true);;
                    $("#ApellidoInput").val(data.Apellido).prop("disabled", true);;
                    $("#CorreoInput").val(data.Correo).prop("disabled", true);;
                  
                    $('#RolIdInput').val(data.RolId).trigger("change").prop("disabled", true);
                    $('#EstadoIdInput').val(data.EstadoId).trigger("change").prop("disabled", true);;
                    $('#ComunidadIdInput').val(acceso[0].ComunidadId).trigger("change").prop("disabled", true);;


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
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });

                     $(".btn-cerrar").on("click", function () {
                            console.log("Error");
                            $('#registrar').modal('toggle');
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
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });

                     $(".btn-cerrar").on("click", function () {
                            console.log("Error");
                            $('#registrar').modal('toggle');
                     });
            }
        });


    });
    
    // Evento al Boton que cambia el estado del usuario
    $("#tabla-usuario tbody").on("click", '.estado-usuario', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //console.log("click");

        var userId =  $(this).closest('td').next().find('a.ver').attr('info');
        var btn = $(this);

        btn.attr("data-kt-indicator", "on");
        $.ajax({
            type: 'POST',
            url: CambiarEstado,
            data: {
                _token: csrfToken,
                data: userId},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                //blockUI2.release();
                if(data.success){
                    //console.log(data.data);               
                    btn.removeAttr("data-kt-indicator");
                    if(btn.hasClass('btn-light-success')){
                        btn.removeClass('btn-light-success').addClass('btn-light-warning');
                        btn.find("span.indicator-label").first().text('INACTIVO')
                    }else{
                        btn.removeClass('btn-light-warning').addClass('btn-light-success');
                        btn.find("span.indicator-label").first().text('ACTIVO')
                    }   
                }else{
                    btn.removeAttr("data-kt-indicator");
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
            error: function () {
                //alert('Error');
                //blockUI2.release();
                btn.removeAttr("data-kt-indicator");
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

    });

    //Evento al presionar el Boton de cambiar estado en la subtabla 
    $("#tabla-usuario tbody").on("click", '.editar-acceso', function(e){
        e.preventDefault();
        e.stopPropagation();
        //console.log("click")
        var accesoId =$(this).attr("info");
        var btn = $(this);
        //console.log(accesoId)
        btn.attr("data-kt-indicator", "on");
        $.ajax({
            type: 'POST',
            url: EditarAcceso,
            data: {
                _token: csrfToken,
                data: accesoId},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data.errors);
                if(data.success){
                    btn.removeAttr("data-kt-indicator");
                    if(btn.hasClass('btn-light-success')){
                        btn.removeClass('btn-light-success').addClass('btn-light-warning');
                        btn.find("span.indicator-label").first().text('Inactivo')
                    }else{
                        btn.removeClass('btn-light-warning').addClass('btn-light-success');
                        btn.find("span.indicator-label").first().text('Activo')
                    }   
                }else{
                    btn.removeAttr("data-kt-indicator");
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
            error: function () {
                //alert('Error');
                btn.removeAttr("data-kt-indicator");
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

    });
    const target2 = document.querySelector("#div-bloquear2");
    const blockUI2 = new KTBlockUI(target2);

    //Evento al presion el boton de Registrar ACCESO en la subtabla
    $("#tabla-usuario tbody").on("click",'.registrar-acceso', function(e) {
        //console.log('click')
        e.preventDefault();
        e.stopPropagation();
        $('.form-select').val("").trigger("change").prop("disabled",false);
        $("#AlertaError2").hide();
        validator2.resetForm();
        actualizarValidSelect2();
        //console.log($(this).attr("data-info"))
        $("#UsuarioIdInput").val($(this).attr("data-info"));
        var userId= $(this).attr("data-info")
        blockUI2.block();
        $.ajax({
            type: 'POST',
            url: ComunidadSinAcceso,
            data: {
                _token: csrfToken,
                data: userId},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                blockUI2.release();
                if(data.success){
                    //console.log(data.data);               
                    data = data.data;
                    var select = $('#ComunidadIdInput2');
                    select.empty();
                    // Agrega las opciones al select
                    var option = new Option('', '');
                    select.append(option);      
                    for (const comunidad in data) {
                            var option = new Option(data[comunidad].Nombre, data[comunidad].Id);
                            select.append(option);                        
                    }
                }else{
                    //console.log(data.message)
                    html = '<ul><li style="">'+data.message+'</li></ul>';
                    $("#AlertaError2").append(html);

                    $("#AlertaError2").show();
                   //console.log("error");
                }
            },
            error: function () {
                //alert('Error');
                blockUI2.release();
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

        



    });
    
    //Evento al presionar el Boton Submit del modal de Registrar NUEVO ACCESO
    const submitButton2 = document.getElementById('AddSubmit-acceso');
    submitButton2.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();
        console.log('guardar')
        $("#AlertaError2").hide();
        $("#AlertaError2").empty();
        
        // Validate form before submit
        if (validator2) {
            validator2.validate().then(function (status) {
                 actualizarValidSelect2();

                //console.log('validated!');
                //status
                if (status == 'Valid') {
                    // Show loading indication                       
                        let form1= $("#Formulario-Acceso");
                        var fd = form1.serialize();
                        const pairs = fd.split('&');

                        const keyValueObject = {};
                       
                        for (let i = 0; i < pairs.length; i++) {
                            const pair = pairs[i].split('=');
                            const key = decodeURIComponent(pair[0]);
                            const value = decodeURIComponent(pair[1]);
                            keyValueObject[key] = value;
                        }

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        // Disable button to avoid multiple click
                        submitButton.disabled = true;     
                        // Remove loading indication
                        //submitButton.removeAttribute('data-kt-indicator');
                        // Enable button
                        //submitButton.disabled = true;
                        blockUI2.block();
                        $.ajax({
                            type: 'POST',
                            url: GuardarAcceso,
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
                                blockUI2.release();
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
                                blockUI2.release();

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



});