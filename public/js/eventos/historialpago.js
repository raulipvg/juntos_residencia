$(document).ready(function() {
    let ComunidadId = 1;
    const target = document.querySelector("#div-bloquear");
    const blockUI = new KTBlockUI(target);
    const form = document.getElementById('formulario-pago');
    $("#AlertaError").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'MontoPagar': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            },
                            between:{
                                inclusive: true,
                                min:0,
                                max: 1000000,
                                message: 'Entre 0 y 1.000.000'
                            
                            }
                        }
                    },
                    'MontoPago': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            },
                            between:{
                                inclusive: true,
                                min:0,
                                max: 1000000,
                                message: 'Entre 0 y 1.000.000'
                            },
                            customValidator: {
                                message: 'El mensaje de error personalizado',
                                method: function(value, validator, $field) {
                                    let montoPagar = $('#MontoPagarInput').val();
                                    var otherFieldValue = validator.getFieldElements('MontoPagarInput').val();
                                    console.log(otherFieldValue + " " + montoPagar)
                                    return (montoPagar <= value);
                                }
                            }
                        }
                    },
                    'TipoPago': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            }
                        }
                    },
                    'NumDoc': {
                        validators: {
                            notEmpty: {
                                message: 'Requerido'
                            },
                            digits: {
                                message: 'Digitos'
                            },
                            between:{
                                inclusive: true,
                                min:0,
                                max: 1000000,
                                message: 'Entre 0 y 1.000.000'
                            
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

    function actualizarValidSelect2() {
        $(".form-select").each(function () {
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

    $("#historiales-pagos tbody").on('click','.NuevoPago', function (e) {
        var modal = new bootstrap.Modal(document.getElementById("modal-nuevo-pago"));
        e.preventDefault();
        e.stopPropagation();

        let gcId = Number($(this).attr("info"));                                    //obtiene el Id del gasto común
        $('#gastoComunIdInput').val(Number($(this).attr("info")))
        $('.form-select').val("").trigger("change").prop("disabled",false);
        validator.resetForm();
        $("#AlertaError").hide();
        $("#AlertaError").empty();

        $.ajax({
            type: 'POST',
                url: UltimoPago,
                data: {
                        _token : csrfToken,
                        data: gcId
                },
                dataType: 'json',
                success: function(data){
                    $('#MontoPagarInput').val(data.data.MontoAPagar);
                }
        })

        $('#MontoPagoInput').val("");
        $('#NumDocInput').val("");
        modal.show();
    })

    const submitButton = document.getElementById('RegistrarPagoButton');
    //Evento al presionar registrar pago
    submitButton.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();


        $("#AlertaError").hide();
        $("#AlertaError").empty();

        if(validator){
            validator.validate().then(function(status){
                actualizarValidSelect2();
                if(status=='Valid'){
                    let form1= $("#formulario-pago");
                    var fd = form1.serialize();
                    const pairs = fd.split('&');

                    const keyValueObject = {};

                    for (let i = 0; i < pairs.length; i++) {
                        const pair = pairs[i].split('=');
                        const key = decodeURIComponent(pair[0]);
                        const value = decodeURIComponent(pair[1]);
                        keyValueObject[key] = value;
                    }


                    
                        // Disable button to avoid multiple click
                    submitButton.disabled = true;
                    blockUI.block();
                    $.ajax({
                        type: 'POST',
                        url: GuardarPago,
                        data: {
                            _token : csrfToken,
                            data: keyValueObject
                        },
                        dataType: 'json',
                        success: function(data){
                            blockUI.release()
                            submitButton.disabled = false;
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
                        error: function(e){
                            submitButton.disabled = false;
                            blockUI.release();
                        // Disable button to avoid multiple click
                            //submitButton.disabled = false;
                            Swal.fire({
                                text: "Error",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "OK",
                                customClass: {
                                    container: "swal-custom",
                                    confirmButton: "btn btn-danger btn-cerrar",
                                },
                            });
                            
                        },
                        then: function(e){
                            modal.modal("toggle");
                            
                        }
                    })
                }
            })
        }
    })
    
    $("#historiales-pagos tbody").on('click','.VerRegistro', function (e) {
        var modal2 = new bootstrap.Modal(document.getElementById("modal-ver-registro"));
        const tabla = document.getElementById('historial-pagos');
        const tbody = tabla.querySelector('tbody');

        tbody.innerHTML = '';

        e.preventDefault();
        e.stopPropagation();

        $("#AlertaError2").hide();
        $("#AlertaError2").empty();
        modal2.show();

        const fila = this.closest('tr');
        const celdas = fila.getElementsByTagName('td');

        $('#PropiedadInput').val(celdas[1].textContent);
        $('#CopropietarioInput').val(celdas[2].textContent);
        $('#MontoTotalInput').val(celdas[3].textContent);

        $('#EstadoPagoInput').val(Number($(this).attr("state"))).trigger("change").prop('disabled',true);
        

        let gcId = Number($(this).attr("info"));                            // Obtiene el id del gasto común

        $.ajax({
            type: 'POST',
            url: VerHistorial,
            data: {
                    _token : csrfToken,
                    data: gcId
                },
                dataType: 'json',
                success: function(data){
                    if(data.success){
                        data=data.data;
                        const fila = document.createElement('tr');
                        data.forEach(historial => {
                            const fila = document.createElement('tr');
                            const id = document.createElement('td');
                            id.textContent=historial.Id;
                            const fecha = document.createElement('td');
                            fecha.textContent=new Date(historial.FechaPago).toLocaleDateString('es-CL', {
                                day: 'numeric',
                                month: 'numeric',
                                year: 'numeric'
                              });
                            const montoPagado = document.createElement('td');
                            montoPagado.textContent=historial.MontoPagado.toLocaleString('es-CL', {style: 'currency', currency: 'CLP'});
                            const medioPago = document.createElement('td');
                            medioPago.textContent=historial.TipoPago;
                            const numDoc = document.createElement('td');
                            numDoc.textContent=historial.NroDoc;
                            
                            fila.appendChild(id);
                            fila.appendChild(fecha);
                            fila.appendChild(montoPagado);
                            fila.appendChild(medioPago);
                            fila.appendChild(numDoc);

                            tbody.appendChild(fila);
                        });

                    }else{
                        html = '<ul><li style="">'+data.message+'</li></ul>';
                        $("#AlertaError").append(html);                                    
                        $("#AlertaError").show();
                    }
                },
                error: function(e) {
                    Swal.fire({
                        text: "Error",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        customClass: {
                            container: "swal-custom",
                            confirmButton: "btn btn-danger btn-cerrar",
                        },
                    });
                }
        })
    })
})