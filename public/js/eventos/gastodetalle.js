
var ComunidadId = 1;
var loadingEl = document.createElement("div");


    const form = document.getElementById('Formulario-nuevogasto');
    console.log(form);
    $("#AlertaError").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
  
        const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'TipoGasto': {
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



    function bloquear(){
        document.body.prepend(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.classList.add("flex-column");
        loadingEl.classList.add("bg-dark");
        loadingEl.classList.add("bg-opacity-25");
        loadingEl.innerHTML = `<span class="spinner-border text-primary" role="status"></span>
                            <span class="text-gray-800 fs-6 fw-semibold mt-5">Cargando...</span>`;
    }
    $('.select-1').select2();
    //$("#NuevoGasto").tooltip();
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

    $("#AgregarGasto").click( function (e) {
        e.preventDefault();
        e.stopPropagation();    
        console.log("Agregar Gasto a la lista")
        if (validator) {
            validator.validate().then(function (status) {
                actualizarValidSelect2();

                //console.log('validated!');
                //status
                if (status == "Valid") {
                console.log("wena");
                }
            });
            }
    });

    // const submitButton = document.getElementById('AgregarGasto');
    // submitButton.addEventListener('click', function (e) {
    //     // Prevent default button action
    //     e.preventDefault();

    //     $("#AlertaError").hide();
    //     $("#AlertaError").empty();

    //     // Validate form before submit
    //     if (validator) {
    //         validator.validate().then(function (status) {
    //              actualizarValidSelect2();

    //             console.log('validated!');
    //             //status
    //             if (status == 'Valid') {
    //                 // Show loading indication
                        
    //                     let form1= $("#Formulario-nuevogasto");
    //                     var fd = form1.serialize();
    //                     const pairs = fd.split('&');

    //                     const keyValueObject = {};

    //                     for (let i = 0; i < pairs.length; i++) {
    //                         const pair = pairs[i].split('=');
    //                         const key = decodeURIComponent(pair[0]);
    //                         const value = decodeURIComponent(pair[1]);
    //                         keyValueObject[key] = value;
    //                     }


    //                     submitButton.setAttribute('data-kt-indicator', 'on');
    //                     // Disable button to avoid multiple click
    //                     submitButton.disabled = true;     
    //                     // Remove loading indication
    //                     //submitButton.removeAttribute('data-kt-indicator');
    //                     // Enable button
    //                     //submitButton.disabled = true;

    //                     $.ajax({
    //                         type: 'POST',
    //                         url: NuevoGasto,
    //                         data: { 
    //                                 _token: csrfToken,    
    //                                 data: ComunidadId
    //                             },
    //                         dataType: "json",
    //                         //content: "application/json; charset=utf-8",
    //                         beforeSend: function() {
                                
    //                         },
    //                         success: function (data) {
    //                             //console.log(data.errors);
    //                             if(data.success){
    //                                 //console.log("exito");
    //                                  location.reload();
    //                             }else{
    //                                 //console.log(data.error);
    //                                     html = '<ul><li style="">'+data.message+'</li></ul>';
    //                                    $("#AlertaError").append(html);

                                    
    //                                 $("#AlertaError").show();
                                    
    //                                //console.log("error");
    //                             }
    //                         },
    //                         error: function (e) {
    //                             //console.log(e)
    //                             //alert('Error');
    //                             Swal.fire({
    //                                 text: "Error",
    //                                 icon: "error",
    //                                 buttonsStyling: false,
    //                                 confirmButtonText: "OK",
    //                                 customClass: {
    //                                     confirmButton: "btn btn-danger btn-cerrar"
    //                                 }
    //                             });
    //                         }
    //                     });
    //                 // form.submit(); // Submit form
    //                 submitButton.removeAttribute('data-kt-indicator');
    //                 submitButton.disabled = false;
    //             }
    //         });
    //     }
    // });



