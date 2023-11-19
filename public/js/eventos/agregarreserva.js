

    //var ComunidadId = 1;
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
    $('#EspacioReservaInput').select2();
    $('#EspacioReservaInput').on('select2:select', function(e){
        $.ajax({
            type: 'POST',
            url: VerEspacioComun,
            data: {
                _token: csrfToken,
                data: $("#EspacioReservaInput").val()
            },
            success: function(data){
                console.log(data)
                data = data.data;
                $("#PrecioInput").val(data.Precio)
            },
            error: function(data){
                console.log(data);
            }
        })
    })
    //$("#NuevoGasto").tooltip();
    var form = document.getElementById('Formulario-nuevareserva');
    //console.log(form)
    $("#AlertaError").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
  
    var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'EspacioReservaId': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    },
                    'FechaReserva': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
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

    var submitButton = document.getElementById("AgregarReserva");
    submitButton.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();    

        //console.log("Agregar Gasto a la lista")

        //$("#AlertaError").hide();
        //$("#AlertaError").empty();

        if (validator) {
            validator.validate().then(function (status) {
                actualizarValidSelect2();
                //console.log('validated!');
                //status
                if (status == "Valid") {
                 let form1 = $("#Formulario-nuevareserva");
                    var fd = form1.serialize();
                    const pairs = fd.split("&");
                    const keyValueObject = {};

                    for (let i = 0; i < pairs.length; i++) {
                        const pair = pairs[i].split("=");
                        const key = decodeURIComponent(pair[0]);
                        const value = decodeURIComponent(pair[1]);
                        keyValueObject[key] = value;
                    }
                    
                    //let comunidadId= $("#ComunidadInput").val();
                    //let gastoMesId = $("#GastoMesIdInput").val();   

                    bloquear();

                    $.ajax({
                        type: "POST",
                        url: GuardarReserva,
                        data: {
                            _token: csrfToken,
                            data: keyValueObject
                        },
                        dataType: "json",
                        //content: "application/json; charset=utf-8",
                        beforeSend: function () {
                            KTApp.showPageLoading();
                        },
                        success: function (data) {
                            //console.log(data.errors);
                            if (data.success) {
                                //console.log("exito");
                                location.reload();
                            } else {
                                //console.log(data.error);
                                Swal.fire({
                                    text: data.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-danger btn-cerrar",
                                    },
                                });
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
                                    confirmButton: "btn btn-danger btn-cerrar",
                                },
                            });
                        },
                        complete: function(e){
                            KTApp.hidePageLoading();
                            loadingEl.remove();
                        }
                    });
                    // form.submit(); // Submit form
                    
                }else{
                    console.log("no")
                    $("#contenedor-1").removeClass("mb-prueba").addClass("mb-prueba-2");
                }
            });
            }
    });

    $("#cerrar-cobro-2").on('click', function(e) {
        //console.log("rpeuba")
        $("#contenedor-3").removeClass("top-xl top-md")
    });