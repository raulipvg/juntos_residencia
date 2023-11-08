
var form = document.getElementById('Formulario-login');
//console.log(form)
$("#AlertaError").hide();
    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

var validator = FormValidation.formValidation(
        form,
        {
            fields: {
                'Username': {
                    validators: {
                        notEmpty: {
                            message: 'Requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 25,
                            message: 'Entre 3 y 25 caracteres'
                        },
                    }
                },
                'password': {
                    validators: {
                        notEmpty: {
                            message: 'Requerido'
                        },
                        stringLength: {
                            min: 8,
                            max: 30,
                            message: 'Minimo 8 caracteres'
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

var submitButton = document.getElementById("login");
submitButton.addEventListener("click", function (e) {
    e.preventDefault();
    e.stopPropagation();    

    //console.log("Agregar Gasto a la lista")

    $("#AlertaError").hide();
    $("#AlertaError").empty();

    if (validator) {
        validator.validate().then(function (status) {
            actualizarValidSelect2();
            //console.log('validated!');
            //status
            if (status == "Valid") {
             let form1 = $("#Formulario-login");
                var fd = form1.serialize();
                const pairs = fd.split("&");
                const keyValueObject = {};

                for (let i = 0; i < pairs.length; i++) {
                    const pair = pairs[i].split("=");
                    const key = decodeURIComponent(pair[0]);
                    const value = decodeURIComponent(pair[1]);
                    keyValueObject[key] = value;
                }

                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;

                $.ajax({
                    type: "POST",
                    url: login,
                    data: {
                        _token: csrfToken,
                        data: keyValueObject
                    },
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            window.location.href = '/jr/public/';
                        } else {
                            html = '<ul><li style="">'+data.message+'</li></ul>';
                                       $("#AlertaError").append(html);

                                    
                                    $("#AlertaError").show();

                                    
                        }
                    },
                    error: function (e) {
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
                    complete: function () {
                        // Habilitar el botón y restaurar su contenido después de completar la solicitud
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    }
                });  
            }
        });
        }
});