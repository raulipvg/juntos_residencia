$(document).ready(function() {
    const form2 = document.getElementById('Formulario-Compone');
    $("#AlertaError").hide();

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
                },
                'PropiedadId': {
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
                'FechaInicio': {
                    validators: {
                        notEmpty: {
                            message: 'Requerido'
                        }
                    }
                },
                'FechaFin': {
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
                        }
                    },
                    digits: {
                        message: 'Digitos'
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

    $("#tabla-compone").on("click",'#registrar-compone', function(e) {
        //console.log('click')
        $('.form-select').val("").trigger("change").prop("disabled",false);
        $("#AlertaError2").hide();
        validator.resetForm();
        actualizarValidSelect2();
        //console.log($(this).attr("data-info"))
        $("#PersonaIdInput").val($(this).attr("data-info"));

    });

    $('#ComunidadIdInputCom').on('select2:select', function(e) {
        const idComunidad = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: VerPropiedades,
            data: { 
                    _token: csrfToken,    
                    data: idComunidad 
                },
            dataType: "json",
            //content: "application/json; charset=utf-8",
            beforeSend: function() {
                
            },
            success: function (data) {
                console.log(data);
                var select = $('#PropiedadIdInputCom');
                    select.empty();
                    // Agrega las opciones al select
                    var option = new Option('', '');
                    select.append(option);
                    for (const propiedad in data) {
                            var option = new Option(data[propiedad].Numero, data[propiedad].Id);
                            select.append(option);
                    }
                if(data.success){
                    
                     location.reload();
                }else{
                        html = '<ul><li style="">'+data.message+'</li></ul>';
                       $("#AlertaError").append(html);

                    
                    $("#AlertaError").show();
                    
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
            }
        });
    });
    
    const target = document.querySelector("#div-bloquear");
    const blockUI = new KTBlockUI(target);
    const submitButton2 = document.getElementById('AddSubmitCom');
    submitButton2.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();
        //console.log('guardar')
        $("#AlertaError2").hide();
        $("#AlertaError2").empty();
        $('.form-select').val("").trigger("change").prop("disabled",false);

        // Validate form before submit
        if (validator2) {
            validator2.validate().then(function (status) {
                 actualizarValidSelect2();

                //console.log('validated!');
                //status
                if (status == 'Valid') {
                    // Show loading indication                       
                        let form1= $("#Formulario-Compone");
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
                        submitButton.disabled = true;
                        blockUI.block();
                        $.ajax({
                            type: 'POST',
                            url: GuardarCompone,
                            data: { 
                                    _token: csrfToken,    
                                    data: keyValueObject 
                                },
                            dataType: "json",
                            beforeSend: function() {
                                
                            },
                            success: function (data) {
                                if(data.success){
                                    location.reload();
                                }else{
                                        html = '<ul><li style="">'+data.message+'</li></ul>';
                                       $("#AlertaError").append(html);

                                    
                                    $("#AlertaError").show();
                                    
                                   //console.log("error");
                                }
                                blockUI.release();
                            },
                            error: function (e) {
                                //console.log(e)
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
                    // form.submit(); // Submit form
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        }
    });

    $("#tabla-residente tbody").on("click", '.editar-residente', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("click");

        var userId =  $(this).attr('info');
        $.ajax({
            type: 'POST',
            url: CambioEstadoCompone,
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
                    location.reload();
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
            error: function () {
                //alert('Error');
                //blockUI2.release();
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
});