$(document).ready(function () {
    // Obtenemos la fecha actual en el formato "YYYY-MM-DD".

    const form = document.getElementById("Formulario1");
    $("#AlertaError").hide();
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator = FormValidation.formValidation(form, {
        fields: {
            Numero: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    stringLength: {
                        min: 1,
                        max: 20,
                        message: "Entre 1 y 20 caracteres",
                    },
                    regexp: {
                        regexp: /^[a-z0-9ñáéíóú-\s]+$/i,
                        message: "Solo letras y numeros de la A-Z y 0-9",
                    },
                },
            },
            Comunidad: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    digits: {
                        message: "Digitos",
                    },
                },
            },
            Descripcion: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    stringLength: {
                        min: 3,
                        max: 50,
                        message: "Entre 3 y 50 caracteres",
                    },
                },
            },
            Prorrateo: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    between: {
                        min: 0.01,
                        max: 100,
                        message: "El valor debe estar entre 0.01 y 100",
                    },
                },
            },
            TipoPropiedadId: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    digits: {
                        message: "Digitos",
                    },
                },
            },
            Estado: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    digits: {
                        message: "Digitos",
                    },
                },
            },
        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "is-invalid",
                eleValidClass: "is-valid",
            }),
        },
    });

    const form2 = document.getElementById("Formulario-Residente");
    $("#AlertaError").hide();
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator2 = FormValidation.formValidation(form2, {
        fields: {
            PersonaId: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    digits: {
                        message: "Digitos",
                    },
                },
            },            
            RolComponeCoReId: {
                validators: {
                    notEmpty: {
                        message: "Requerido",
                    },
                    digits: {
                        message: "Digitos",
                    },
                },
            },
        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "is-invalid",
                eleValidClass: "is-valid",
            }),
        },
    });
    function actualizarValidSelect2() {
        $(".form-select").not('#ComunidadInput1').each(function () {
            var valid = $(this).hasClass("is-valid");
            var invalid = $(this).hasClass("is-invalid");

            //console.log("valid: "+valid+" invalid: "+invalid)
            if (valid) {
                $(this)
                    .next()
                    .children()
                    .children()
                    .removeClass("is-invalid")
                    .addClass("is-valid");
            }
            if (invalid) {
                $(this)
                    .next()
                    .children()
                    .children()
                    .removeClass("is-valid")
                    .addClass("is-invalid");
            }
            if (!valid && !invalid) {
                $(this).next().children().children().removeClass("is-valid");
                $(this).next().children().children().removeClass("is-invalid");
            }
        });
    }
     // COLOCAR EL FONDO OSCURO AL MODAL DE ATRAS
     var modal = new bootstrap.Modal(document.getElementById("editar-residente"));
    
     $(document).on("click", ".cerrar-modal", function () {
        //console.log("Cerrar")
         modal.hide();
         $("#residentes").css("z-index", 1055); 
     });

    const target = document.querySelector("#div-bloquear");
    const blockUI = new KTBlockUI(target);

    // Evento al presionar el Boton de Registrar
    $("#AddBtn").on("click", function (e) {
        //Inicializacion
        //console.log("AddBtn")
        e.preventDefault();
        e.stopPropagation();
        $("#modal-titulo").empty().html("Registrar Propiedad");
        $("input").val("").prop("disabled", false);
        $(".form-select").not('#ComunidadInput1').val("").trigger("change").prop("disabled", false);

        $("#AddSubmit").show();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled", true);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();
    });
    // Manejador al presionar el submit de Registrar
    const submitButton = document.getElementById("AddSubmit");
    submitButton.addEventListener("click", function (e) {
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
                if (status == "Valid") {
                    // Show loading indication

                    let form1 = $("#Formulario1");
                    var fd = form1.serialize();
                    const pairs = fd.split("&");

                    const keyValueObject = {};

                    for (let i = 0; i < pairs.length; i++) {
                        const pair = pairs[i].split("=");
                        const key = decodeURIComponent(pair[0]);
                        const value = decodeURIComponent(pair[1]);
                        keyValueObject[key] = value;
                    }

                    submitButton.setAttribute("data-kt-indicator", "on");
                    // Disable button to avoid multiple click
                    submitButton.disabled = true;
                    // Remove loading indication
                    //submitButton.removeAttribute('data-kt-indicator');
                    // Enable button
                    //submitButton.disabled = true;
                    blockUI.block();
                    $.ajax({
                        type: "POST",
                        url: GuardarPropiedad,
                        data: {
                            _token: csrfToken,
                            data: keyValueObject,
                        },
                        dataType: "json",
                        //content: "application/json; charset=utf-8",
                        beforeSend: function () {},
                        success: function (data) {
                            //console.log(data.errors);
                            blockUI.release();
                            if (data.success) {
                                //console.log("exito");
                                location.reload();
                            } else {
                                //console.log(data.error);
                                html =
                                    '<ul><li style="">' +
                                    data.message +
                                    "</li></ul>";
                                $("#AlertaError").append(html);

                                $("#AlertaError").show();

                                //console.log("error");
                            }
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
                                    confirmButton: "btn btn-danger btn-cerrar",
                                },
                            });
                        },
                    });
                    // form.submit(); // Submit form
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;
                }
            });
        }
    });

    //Evento al presionar el Boton Editar
    $("#tabla-propiedad tbody").on("click", ".editar", function (e) {
        e.preventDefault();
        e.stopPropagation();
        //Inicializacion
        $("#modal-titulo").empty().html("Editar Propiedad");
        $("input").val("").prop("disabled", false);
        $(".form-select").not('#ComunidadInput1').val("").trigger("change").prop("disabled", false);
        console.log('here')
        $("#AddSubmit").hide();
        $("#EditSubmit").show();
        $("#IdInput").prop("disabled", false);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));

        blockUI.block();

        $.ajax({
            type: "POST",
            url: VerPropiedad,
            data: {
                _token: csrfToken,
                data: id,
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);

                if (data.success) {
                    data = data.data;
                    console.log("wena");
                    //Agrego los valores al formulario
                    $("#IdInput").val(data.Id);
                    $("#NumeroInput").val(data.Numero);
                    $("#ComunidadInput")
                        .val(data.ComunidadId)
                        .trigger("change")
                        .prop("disabled", true);

                    $("#DescripcionInput").val(data.Descripcion);
                    $("#ProrrateoInput").val(data.Prorrateo);
                    $("#TipoPropiedadIdInput")
                        .val(data.TipoPropiedad)
                        .trigger("change");
                    $("#EstadoInput").val(data.Enabled).trigger("change");

                    blockUI.release();
                } else {
                    //console.log("error");
                    blockUI.release();

                    Swal.fire({
                        text: "Error de Carga",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar",
                        },
                    });
                    $(".btn-cerrar").on("click", function () {
                        //console.log("Error");
                        $("#registrar").modal("toggle");
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
                        confirmButton: "btn btn-danger btn-cerrar",
                    },
                });

                $(".btn-cerrar").on("click", function () {
                    //console.log("Error");
                    $("#registrar").modal("toggle");
                });
            },
        });
    });

    // Manejador al presionar el submit de Editar
    const submitEditButton = document.getElementById("EditSubmit");
    submitEditButton.addEventListener("click", function (e) {
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
                if (status == "Valid") {
                    // Show loading indication
                    submitEditButton.setAttribute("data-kt-indicator", "on");
                    // Disable button to avoid multiple click
                    submitEditButton.disabled = true;
                    // Remove loading indication
                    submitEditButton.removeAttribute("data-kt-indicator");

                    // Enable button
                    submitEditButton.disabled = false;

                    let form1 = $("#Formulario1");
                    var fd = form1.serialize();
                    const pairs = fd.split("&");

                    const keyValueObject = {};

                    for (let i = 0; i < pairs.length; i++) {
                        const pair = pairs[i].split("=");
                        const key = decodeURIComponent(pair[0]);
                        const value = decodeURIComponent(pair[1]);
                        keyValueObject[key] = value;
                    }

                    $.ajax({
                        type: "POST",
                        url: EditarPropiedad,
                        data: {
                            _token: csrfToken,
                            data: keyValueObject,
                        },
                        //content: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function (data) {
                            //console.log(data.errors);
                            if (data.success) {
                                //console.log("exito");
                                location.reload();
                            } else {
                                console.log(data.message);

                                html =
                                    '<ul><li style="">' +
                                    data.message +
                                    "</li></ul>";
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
                                    confirmButton: "btn btn-danger btn-cerrar",
                                },
                            });
                        },
                    });
                    //form.submit(); // Submit form
                } //endif
            });
        }
    });

    //Evento al presion el boton VER
    $("#tabla-propiedad tbody").on("click", ".ver", function (e) {
        e.preventDefault();
        e.stopPropagation();

        //console.log("wena");
        $("#modal-titulo").empty().html("Ver Propiedad");
        $("input").val("");
        $(".form-select").not('#ComunidadInput1').val("").trigger("change");
        $("#AddSubmit").hide();
        $("#EditSubmit").hide();
        $("#IdInput").prop("disabled", false);
        $("#AlertaError").hide();

        validator.resetForm();
        actualizarValidSelect2();

        let id = Number($(this).attr("info"));
        blockUI.block();

        $.ajax({
            type: "POST",
            url: VerPropiedad,
            data: {
                _token: csrfToken,
                data: id,
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log(data);
                if (data) {
                    data = data.data;
                    var fechaFormateada = moment
                        .utc(data.FechaRegistro)
                        .format("YYYY-MM-DD");
                    //console.log("wena");
                    //Agrego los valores al formulario
                    $("#IdInput").val(data.Id);
                    $("#NumeroInput").val(data.Numero).prop("disabled", true);
                    $("#ComunidadInput")
                        .val(data.ComunidadId)
                        .trigger("change")
                        .prop("disabled", true);

                    $("#DescripcionInput")
                        .val(data.Descripcion)
                        .prop("disabled", true);
                    $("#ProrrateoInput")
                        .val(data.Prorrateo)
                        .prop("disabled", true);
                    $("#TipoPropiedadIdInput")
                        .val(data.TipoPropiedad)
                        .trigger("change")
                        .prop("disabled", true);
                    $("#EstadoInput")
                        .val(data.Enabled)
                        .trigger("change")
                        .prop("disabled", true);

                    blockUI.release();
                } else {
                    //console.log("error");
                    blockUI.release();

                    Swal.fire({
                        text: "Error de Carga",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar",
                        },
                    });

                    $(".btn-cerrar").on("click", function () {
                        console.log("Error");
                        $("#registrar").modal("toggle");
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
                        confirmButton: "btn btn-danger btn-cerrar",
                    },
                });

                $(".btn-cerrar").on("click", function () {
                    console.log("Error");
                    $("#registrar").modal("toggle");
                });
            },
        });
    });

    // Evento al Boton que cambia el estado del usuario
    $("#tabla-propiedad tbody").on("click", ".estado-propiedad", function (e) {
        e.preventDefault();
        e.stopPropagation();
        //console.log("click");

        var userId = $(this).closest("td").next().find("a.ver").attr("info");
        var btn = $(this);

        btn.attr("data-kt-indicator", "on");
        $.ajax({
            type: "POST",
            url: CambiarEstado,
            data: {
                _token: csrfToken,
                data: userId,
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                //blockUI2.release();
                if (data.success) {
                    //console.log(data.data);
                    btn.removeAttr("data-kt-indicator");
                    if(btn.hasClass('btn-light-success')){
                        btn.removeClass('btn-light-success').addClass('btn-light-warning');
                        btn.find("span.indicator-label").first().text('INACTIVO')
                    }else{
                        btn.removeClass('btn-light-warning').addClass('btn-light-success');
                        btn.find("span.indicator-label").first().text('ACTIVO')
                    }   
                } else {
                    btn.removeAttr("data-kt-indicator");
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar",
                        },
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
                        confirmButton: "btn btn-danger btn-cerrar",
                    },
                });
            },
        });
    });

    //// RESIDENTES DE UNA PROPIEDAD
    const target2 = document.querySelector("#div-bloquear-residente");
    const blockUI2 = new KTBlockUI(target2);
    let PropiedadId;
    let nombreComundiad;
    let NombrePropiedad;
    //Evento al presionar el Boton de Espacios
    $("#tabla-propiedad tbody").on("click", ".ver-residentes", function (e) {
        e.preventDefault();
        e.stopPropagation();
        blockUI2.block();
        let id = Number($(this).attr("info"));
        miTablaEspacio.clear().draw();

        nombreComundiad = $(this).closest("tr").find("td.sorting_1").text();
        NombrePropiedad = $(this).closest("tr").find("td.sorting_1").next().text();
        PropiedadId = $(this).closest("tr").find("td.dtr-control").text();
        $.ajax({
            type: "POST",
            url: VerPorPropiedad,
            data: {
                _token: csrfToken,
                data: id,
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);

                if (data.success) {
                    //comunidadNombre= data.comunidad.Nombre;
                    $("#modal-titulo-residente").empty().html("Residentes de la " +nombreComundiad+" - " +NombrePropiedad);
                    //console.log(data.comunidad.Id);
                    //$("#ComunidadIdInput").prop('disabled', false);
                    //comunidadId = data.comunidad.Id;

                    if (data.data) {
                        data = data.data;
                        //console.log(data);

                        for (let row in data) {
                            if (data[row].Enabled == 1) {
                                var enabled =
                                    '<button class="btn btn-sm btn-light-success estado-residente fs-7 text-uppercase justify-content-center p-1 w-65px" data-info="'+data[row].Id+'" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Residencia">'+
                                    '<span class="indicator-label">Activo</span>'+
                                    '<span class="indicator-progress">'+
                                        '<span class="spinner-border spinner-border-sm align-middle"></span>'+
                                    '</span>'+
                                    '</button>';
                            } else {
                                var enabled =
                                    '<button class="btn btn-sm btn-light-warning fs-7 text-uppercase justify-content-center p-1 w-65px disabled">INACTIVO</button>';
                            }

                            var fechaInicio = new Date(data[row].FechaInicio);
                            var fechaFin= new Date(data[row].FechaFin);
                            // Obtener el día, mes y año
                            var dia = fechaInicio.getDate();
                            var mes = fechaInicio.getMonth() + 1; // Nota: Los meses en JavaScript comienzan en 0
                            var anio = fechaInicio.getFullYear();

                            // Formatear la fecha como "DD-MM-YYYY"
                            var fechaInicioFormateada = dia+"-"+(mes < 10 ? "0" : "")+mes+"-"+anio;

                            // Obtener el día, mes y año
                            var dia = fechaFin.getDate();
                            var mes = fechaFin.getMonth() + 1; // Nota: Los meses en JavaScript comienzan en 0
                            var anio = fechaFin.getFullYear();
                            var fechaFinFormateada = dia+"-"+(mes < 10 ? "0" : "")+mes+"-"+anio;
                            //console.log(rec.estacion.nombreEstacion+` `+datos.momento)
                            var rowNode = miTablaEspacio.row.add({
                                0: data[row].RUT,
                                1: data[row].Nombre + " " + data[row].Apellido,
                                2: data[row].Rol,
                                3: fechaInicioFormateada,
                                4: fechaFinFormateada,
                                5: enabled,
                            });
                            var fila = miTablaEspacio.row(rowNode).node();
                            $(fila).find("td").eq(5).addClass("text-center p-0");
                        }
                        miTablaEspacio.draw();
                        $(".estado-residente").tooltip();
                    }
                    blockUI2.release();
                } else {
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
                        confirmButton: "btn btn-danger btn-cerrar",
                    },
                });

                $(".btn-cerrar").on("click", function () {
                    //console.log("Error");
                    $("#residentes").modal("toggle");
                });
            },
        });
    });
    const target3 = document.querySelector("#div-bloquear-residente-editar");
    const blockUI3 = new KTBlockUI(target3);
    // Evento al presionar el Boton de Registrar
    $("#AddBtn-Residente").on("click", function (e) {
        //Inicializacion
        console.log("AddBtn-Residente")
        e.preventDefault();
        e.stopPropagation();
        $("#residentes").css("z-index", 1000);

        $("#modal-titulo-residente-registrar").empty().html("Registrar Residente de la " +nombreComundiad+" - " +NombrePropiedad);
        
        $("input").val('').prop("disabled",false);
        $('.form-select').not('#ComunidadInput1').val("").trigger("change").prop("disabled",false);

        $("#AddSubmit-residente").show();
        $("#IdInput-espacio").prop("disabled",true);
        $("#AlertaError2").hide();

        validator2.resetForm();
        actualizarValidSelect2();
        blockUI3.block();
        $.ajax({
            type: "POST",
            url: VerPersonaDisponible,
            data: {
                _token: csrfToken,
                data: PropiedadId,
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);

                if (data.success) {
                    
                    if (data.data) {
                        roles= data.roles;
                        data = data.data;
                        //console.log(data);
                        var select = $('#PersonaIdInput');
                        select.empty();
                        // Agrega las opciones al select
                        var option = new Option('', '');
                        select.append(option);
                        for (const persona in data) {
                                var option = new Option(data[persona].Nombre+' '+ data[persona].Apellido, data[persona].Id);
                                select.append(option);
                        }

                        var select = $('#RolComponeCoReIdInput');
                        select.empty();
                        // Agrega las opciones al select
                        var option = new Option('', '');
                        select.append(option);
                        for (const key in roles) {
                                var option = new Option(roles[key].Nombre, roles[key].Id);
                                select.append(option);
                        }
                       
                    }
                    blockUI3.release();
                } else {
                    //console.log("Sin data");
                    blockUI3.release();
                }
            },
            error: function () {
                //alert('Error en editar el usuario');
                blockUI3.release();
                Swal.fire({
                    text: "Error de Carga",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar",
                    },
                });

                $(".btn-cerrar").on("click", function () {
                    //console.log("Error");
                    $("#residentes").modal("toggle");
                });
            },
        });



        
    });

    const submitButton2 = document.getElementById('AddSubmit-residente');
    submitButton2.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();
        e.stopPropagation();

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
                        
                        let form1= $("#Formulario-Residente");
                        var fd = form1.serialize();
                        const pairs = fd.split('&');

                        const keyValueObject = {};

                        for (let i = 0; i < pairs.length; i++) {
                            const pair = pairs[i].split('=');
                            const key = decodeURIComponent(pair[0]);
                            const value = decodeURIComponent(pair[1]);
                            keyValueObject[key] = value;
                        }

                        keyValueObject.PropiedadId = PropiedadId;



                        submitButton.setAttribute('data-kt-indicator', 'on');
                        // Disable button to avoid multiple click
                        submitButton.disabled = true;     
                        // Remove loading indication
                        //submitButton.removeAttribute('data-kt-indicator');
                        // Enable button
                        //submitButton.disabled = true;
                        blockUI3.block();
                        $.ajax({
                            type: 'POST',
                            url: GuardarCompone2,
                            data: { 
                                    _token: csrfToken,    
                                    data: keyValueObject 
                                },
                            dataType: "json",
                            //content: "application/json; charset=utf-8",
                            beforeSend: function() {
                                
                            },
                            success: function (data) {
                                blockUI3.release();
                                console.log(data);
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
                                blockUI3.release();
                                //console.log(e)
                                //alert('Error');
                                Swal.fire({
                                    text: "Error",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        container: "swal-custom",
                                        confirmButton: "btn btn-danger btn-cerrar swal-custom"
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

    $("#tabla-espacios tbody").on('click','.estado-residente', function(e) {
        //console.log("cambio-estado")
        componeId = $(this).attr("data-info");

        var btn = $(this);

        btn.attr("data-kt-indicator", "on");
        $.ajax({
            type: "POST",
            url: CambioEstadoCompone,
            data: {
                _token: csrfToken,
                data: componeId,
            },
            //content: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                //console.log(data);
                //blockUI2.release();
                if (data.success) {
                    //console.log(data.data);
                    btn.removeAttr("data-kt-indicator");
                    if(btn.hasClass('btn-light-success')){
                        btn.removeClass('btn-light-success').addClass('btn-light-warning');
                        btn.find("span.indicator-label").first().text('INACTIVO');
                        btn.prop("disabled", true);
                    }
                } else {
                    btn.removeAttr("data-kt-indicator");
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger btn-cerrar",
                        },
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
                        confirmButton: "btn btn-danger btn-cerrar",
                    },
                });
            },
        });
    });
    $('#ComunidadInpu1').select2();
    // Evento de select2 de comunidad
    $('#ComunidadInput1').on('select2:select', function(e){
        e.preventDefault();
        e.stopPropagation();
        c= $("#ComunidadInput1").val();

        var redirectUrl = Index + "/" + '?&c=' + c;
        console.log(redirectUrl)
        window.location.href = redirectUrl;

    })

});
