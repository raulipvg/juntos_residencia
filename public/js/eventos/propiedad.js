$(document).ready(function() {

    // Obtenemos la fecha actual en el formato "YYYY-MM-DD".

    
    const form = document.getElementById('Formulario1');
    $("#AlertaError").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'Numero': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                min: 1,
                                max: 1000,
                                message: 'Digitos'
                            }
                        }
                    },
                    'Comunidad': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    },
                    'Descripcion': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            stringLength: {
                                min: 3,
                                max: 50,
                                message: 'Entre 3 y 50 caracteres'
                            }
                        }
                    },
                    'Prorrateo': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                min: 1,
                                max: 100,
                                message: 'Digitos'
                            }
                        }
                    },
                    'TipoPropiedadId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    },
                    'Estado': {
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
        $("#modal-titulo").empty().html("Registrar Propiedad");
        $("input").val('').prop("disabled",false);
        $(".form-select").val("").trigger("change").prop("disabled",false);
        

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

                        $.ajax({
                            type: 'POST',
                            url: GuardarPropiedad,
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
    $("#tabla-propiedad tbody").on("click",'.editar', function (e) {
        e.preventDefault();
        //Inicializacion
        $("#modal-titulo").empty().html("Editar Propiedad");
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
            url: VerPropiedad,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);
                
                if(data.success){
                    data=data.data;
                    console.log("wena");
                    //Agrego los valores al formulario
                    $("#IdInput").val(data.Id);
                    $("#NumeroInput").val(data.Numero);
                    $("#ComunidadInput").val(data.ComunidadId).trigger("change");

                    $("#DescripcionInput").val(data.Descripcion);
                    $("#ProrrateoInput").val(data.Prorrateo);
                    $("#TipoPropiedadIdInput").val(data.TipoPropiedad).trigger("change");
                    $("#EstadoInput").val(data.Enabled).trigger("change");;
                    
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
                                url: EditarPropiedad,
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

    $("#tabla-propiedad tbody").on("click",'.ver', function () {
        //console.log("wena");
        $("#modal-titulo").empty().html("Ver Propiedad");
        $("input").val('');
        $('#TipoPropiedadIdInput').val("").trigger("change");
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
            url: VerPropiedad,
            data: {
                _token: csrfToken,
                data: id},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);
                if(data){

                    data= data.data
                    var fechaFormateada = moment.utc(data.FechaRegistro).format('YYYY-MM-DD');
                    //console.log("wena");
                    //Agrego los valores al formulario
                    $("#IdInput").val(data.Id);
                    $("#NombreInput").val(data.Nombre).prop("disabled", true);
                    $("#RUTInput").val(data.RUT).prop("disabled", true);
                    $("#CorreoInput").val(data.Correo).prop("disabled", true);
                    $("#NumeroCuentaInput").val(data.NumeroCuenta).prop("disabled", true);
                    $("#TipoCuentaInput").val(data.TipoCuenta).prop("disabled", true);
                    $("#BancoInput").val(data.Banco).prop("disabled", true);
                    $("#CantPropiedadesInput").val(data.CantPropiedades).prop("disabled", true);
                    $("#FechaRegistroInput").val(fechaFormateada).prop("disabled", true);
                    
                    $('#EnabledInput').val(data.Enabled).trigger("change").prop("disabled", true);
                    $('#TipoPropiedadIdInput').val(data.TipoPropiedadId).trigger("change").prop("disabled", true);
                    
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