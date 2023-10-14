// Realizado por Raul Muñoz raul.munoz@virginiogomez.cl

const loading = '<div id="loading">' +
                    '<div class="text-center m-7 p-7">' +
                        '<div class="spinner-grow text-info me-2" role = "status">' +
                        '</div>' +
                        '<div class="spinner-grow text-info me-2" role = "status">' +
                        '</div>' +
                        '<div class="spinner-grow text-info" role="status">' +
                        '</div>' +
                    '</div></div>';

let AjaxCertificadoEmitido = () => {
    
    $(".div-loading").hide();
    $("#titulo-certificado").html("Certificados Emitidos")
    $('#grafico').after(loading)

    $.ajax({
        type: "POST",
        url: "../controller/locallib_general.php",
        data: { accion: 1},
        dataType: "json",
        success: function (data) {
            
            $("#loading").remove();
            //console.log(data);
            if (data) {
                $(".div-loading").show();
            } else {
                
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            console.log("Error: " + status + " - " + error);
            $("#loading").remove();
            Swal.fire({
                text: "Error",
                icon: "error",
                buttonsStyling: false,
                allowOutsideClick: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-danger btn-cerrar"
                }
            });
        },           
    });   
}

let AjaxCertificadoPendiente = () => {
    
    $(".div-loading").hide()
    $("#titulo-certificado").html("Certificados Pendientes")
    $('#grafico').after(loading)

    $.ajax({
        type: "POST",
        url: "../controller/locallib_general.php",
        data: { accion: 2},
        dataType: "json",
        success: function (data) {
            
            $("#loading").remove();
            //console.log(data);
            if (data) {
                $(".div-loading").show();
            } else {
                
                Swal.fire({
                    text: "Error",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: "btn btn-danger btn-cerrar"
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            console.log("Error: " + status + " - " + error);
            $("#loading").remove();
            Swal.fire({
                text: "Error",
                icon: "error",
                buttonsStyling: false,
                allowOutsideClick: false,
                confirmButtonText: "OK",
                customClass: {
                    confirmButton: "btn btn-danger btn-cerrar"
                }
            });
        },           
    });   
}


var KTChartsWidget17 = {
    init: function() {
        if ("undefined" !== typeof am5) {
            var e = document.getElementById("kt_charts");
            if (e) {
                var t, a = function() {
                    t = am5.Root.new(e);
                    t.setThemes([am5themes_Animated.new(t)]);
                    var chart = t.container.children.push(am5percent.PieChart.new(t, {
                        startAngle: 180,
                        endAngle: 360,
                        layout: t.verticalLayout,
                        innerRadius: am5.percent(50)
                    }));

                    var series = chart.series.push(am5percent.PieSeries.new(t, {
                        startAngle: 180,
                        endAngle: 360,
                        valueField: "value",
                        categoryField: "category",
                        alignLabels: false
                    }));

                    // Añadir un evento de clic a los segmentos del gráfico
                    series.slices.template.events.on("click", function(ev) {
                        console.log("Segmento clickeado:", ev.target.dataItem.dataContext.category);
                        var seccion = ev.target.dataItem.dataContext.category; 
                        if( seccion == "Emitidos" ){
                            AjaxCertificadoEmitido();           
                        }else if( seccion == "Pendientes"){
                            AjaxCertificadoPendiente();
                            //$(".div-loading").show();
                        }
                        // Agrega aquí la lógica que deseas ejecutar al hacer clic en un segmento
                    });

                    series.labels.template.setAll({
                        fontWeight: "400",
                        fontSize: 13,
                        fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500"))
                    });

                    series.slices.template.setAll({
                        cornerRadius: 5
                    });

                    series.data.setAll([{
                        value: 50,
                        category: "Emitidos",
                        fill: am5.color(KTUtil.getCssVariableValue("--bs-primary"))
                    }, {
                        value: 100,
                        category: "Pendientes",
                        fill: am5.color("#000000")
                    }]);
                    


                    chart.appear(1000, 100);
                };
                am5.ready(function() {
                    a();
                });
                KTThemeMode.on("kt.thememode.change", function() {
                    t.dispose(), a();
                });
                
            }
        }
    }
};


"undefined" != typeof module && (module.exports = KTChartsWidget17),
KTUtil.onDOMContentLoaded((function() {
    KTChartsWidget17.init()
}));