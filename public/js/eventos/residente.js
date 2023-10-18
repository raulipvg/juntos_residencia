$(document).ready(function() {

    
    const form = document.getElementById('Formulario1');
    $("#AlertaError").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator = FormValidation.formValidation(
            form,
            {
                fields: {
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
                    'Rut': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 9,
                                max: 10,
                                message: 'Entre 3 y 20 caracteres'
                            },
                            regexp: {
                                regexp: /^[0-9kK-\s]+$/i,
                                message: 'Solo caracteres de la 0-9 y K '
                            }
                        }
                    },            
                    'SexoId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        }
                    },          
                    'NacionalidadId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        }
                    },
                    'Telefono': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        },
                        numeric: {
                          message: 'Ingrese solo números'
                        }
                    },                      
                    'PropiedadId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        }
                    },
                    'RolId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        }
                    },
                    'FechaInicio': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        },
                        date: {
                            format: 'DD/MM/YYYY',
                            message: 'Ingrese una fecha válida en el formato dd/mm/aaaa'
                          }
                    },
                    'FechaFin': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            }
                        },
                        date: {
                            format: 'DD/MM/YYYY',
                            message: 'Ingrese una fecha válida en el formato dd/mm/aaaa'
                          }
                    },   
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
    $("#AddBtn").on("click", function (e ) {
        //Inicializacion
        //console.log("AddBtn")
        e.preventDefault();
        $("#modal-titulo").empty().html("Registrar Residente");
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit").show();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled",true);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();
    });
    // Manejador al presionar el submit de Registrar
    const submitButton = document.getElementById('AddSubmit');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();

        $("#AlertaError").hide();
        $("#AlertaError").empty();

        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                 actualizarValidSelect2();

                console.log('validated!');
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

                        $.ajax({
                            type: 'POST',
                            url: GuardarResidente,
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
                                       $("#AlertaError").append(html);

                                    
                                    $("#AlertaError").show();
                                    
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

    const target = document.querySelector("#div-bloquear");
    const blockUI = new KTBlockUI(target);

    //Evento al presionar el Boton Editar
    $("#tabla-residente tbody").on("click",'.editar', function (e) {
        e.preventDefault();
        //Inicializacion
        $("#modal-titulo").empty().html("Editar Residente");
        $("input").val('').prop("disabled",false);
        $('.form-select').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit").hide();
        $("#EditSubmit").show();
        $("#IdInput").prop("disabled",false);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));

        blockUI.block();

        $.ajax({
            type: 'POST',
            url: VerResidente,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                
                if(data.success){
                    data=data.data;
                    var fechaFormateada = moment.utc(data[0].FechaInicio).format('YYYY-MM-DD');
                    var fechaFormateada2 = moment.utc(data[0].FechaFin).format('YYYY-MM-DD');
                    //console.log("wena");
                    //Agrego los valores al formulario
                    $("#IdInput").val(data[0].Id);
                    $("#NombreInput").val(data[1].Nombre)
                    $("#ApellidoInput").val(data[1].Apellido)
                    $("#RutInput").val(data[1].RUT)

                    $("#SexoIdInput").val(data[1].Sexo).trigger("change");
                    $("#NacionalidadInput").val(data[1].NacionalidadId).trigger("change");
                    $("#TelefonoInput").val(data[1].Telefono)

                    $("#PropiedadIdInput").val(data[0].PropiedadId).trigger("change");                   
                    $("#RolIdInput").val(data[0].RolId).trigger("change");

                    $("#FechaInicioInput").val(fechaFormateada);
                    $("#FechaFinInput").val(fechaFormateada2);

                    $("#EnabledInput").val(data[1].Enabled).trigger("change");


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
                                url: EditarResidente,
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
                                        $("#AlertaError").append(html);

                                        $("#AlertaError").show();
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

    $("#tabla-residente tbody").on("click",'.ver', function () {
        //console.log("wena");
        $("#modal-titulo").empty().html("Ver Comunidad");
        $("input").val('');
        $('#PersonaIdInput').val("").trigger("change");
        $('#PropiedadIdInput').val("").trigger("change");
        $('#RolIdInput').val("").trigger("change");
        $("#AddSubmit").hide();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled",false);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));
        blockUI.block();

        $.ajax({
            type: 'POST',
            url: VerResidente,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);
                if(data){

                    data=data.data;
                    var fechaFormateada = moment.utc(data[0].FechaInicio).format('YYYY-MM-DD');
                    var fechaFormateada2 = moment.utc(data[0].FechaFin).format('YYYY-MM-DD');
                    //console.log("wena");
                    //Agrego los valores al formulario
                    $("#IdInput").val(data[0].Id);
                    $("#NombreInput").val(data[1].Nombre)
                    $("#ApellidoInput").val(data[1].Apellido)
                    $("#RutInput").val(data[1].RUT)

                    $("#SexoIdInput").val(data[1].Sexo).trigger("change");
                    $("#NacionalidadInput").val(data[1].NacionalidadId).trigger("change");
                    $("#TelefonoInput").val(data[1].Telefono)

                    $("#PropiedadIdInput").val(data[0].PropiedadId).trigger("change");                   
                    $("#RolIdInput").val(data[0].RolId).trigger("change");

                    $("#FechaInicioInput").val(fechaFormateada);
                    $("#FechaFinInput").val(fechaFormateada2);

                    $("#EnabledInput").val(data[1].Enabled).trigger("change");
                                    
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

});