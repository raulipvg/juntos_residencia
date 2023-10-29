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
    const target2 = document.querySelector("#div-bloquear-compone");
    const blockUI2 = new KTBlockUI(target2);

    //EVENTO DE LA SUBTABLA DE COMPONE Y SE INICIALIZA EL MODAL PARA REGISTRAR UNA NUEVA RESIDENCIA
    $("#tabla-residente").on("click",'.registrar-residencia', function(e) {
        e.preventDefault();
        e.stopPropagation();
        //console.log('click')
        $('.form-select').val("").trigger("change").prop("disabled",false);
        $("#AlertaError2").hide();
        validator2.resetForm();
        actualizarValidSelect2();
        //console.log($(this).attr("data-info"))
        $("#PersonaIdInputCom").val($(this).attr("data-info"));
        var personaId= $(this).attr("data-info");
        blockUI2.block();
        $("#modal-titulo-compone").empty();
        $.ajax({
            type: 'POST',
            url: VerComunidadDisponible,
            data: {
                _token: csrfToken,
                data: personaId},
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                var persona = data.persona;
                if(data.success){
                    //console.log(data.data);               
                    data = data.data;
                    $("#modal-titulo-compone").text("REGISTRAR RESIDENCIA PARA "+persona.Nombre+" "+persona.Apellido);
                    var select = $('#ComunidadIdInputCom');
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
                blockUI2.release();
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

    $('#ComunidadIdInputCom').on('select2:select', function(e) {
        const idComunidad = $(this).val();
        //console.log(idComunidad)
        blockUI2.block();
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
                //console.log(data);
                if(data.success){
                    data= data.data;
                    var select = $('#PropiedadIdInputCom');
                    select.empty();
                    var option = new Option('', '');
                    select.append(option);
                    if(data.length != 0 ){
                        for (const propiedad in data) {
                                var option = new Option(data[propiedad].Numero, data[propiedad].Id);
                                select.append(option);
                        }
                    }else{
                        Swal.fire({
                            text: "Error - No existen Propiedades Disponibles",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger btn-cerrar"
                            }
                        });
                    }
                     //location.reload();
                }else{
                        html = '<ul><li style="">'+data.message+'</li></ul>';
                       $("#AlertaError2").append(html);
                       $("#AlertaError2").show();
                    
                }
                blockUI2.release();
            },
            error: function (e) {
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
    
    const target = document.querySelector("#div-bloquear");
    const blockUI = new KTBlockUI(target);


    const submitButton2 = document.getElementById('AddSubmitCom');
    //EVENTO QUE MANEJA EL SUBMIT DE REGISTRAR UNA RESIDENCIA PARA UN USUARIO EN ESPECIFICO
    submitButton2.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();
        //console.log('guardar')
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
                        blockUI2.block();
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
                                    console.log(data)
                                        html = '<ul class="m-0"><li style="">'+data.message+'</li></ul>';
                                    $("#AlertaError3").append(html);
                                    $("#AlertaError3").show();
                                    
                                   //console.log("error");
                                }
                                blockUI2.release();
                            },
                            error: function (e) {
                                console.log(e)
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
                  
                }
            });
        }
    });

    //EVENTO QUE MANEJA EL CAMBIO DE ESTADO PARA LA RESIDENCIA QUE COMPONE
    $("#tabla-residente tbody").on("click", '.editar-residente', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log("click");

        var userId =  $(this).attr('info');
        var btn = $(this);

        btn.attr("data-kt-indicator", "on");
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
                    btn.removeAttr("data-kt-indicator");
                    if(btn.hasClass('btn-light-success')){
                        btn.removeClass('btn-light-success').addClass('btn-light-warning');
                        btn.find("span.indicator-label").first().text('INACTIVO');
                        btn.prop("disabled", true);
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
});