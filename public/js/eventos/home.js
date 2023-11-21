$(document).ready(function() {
    graficoGastosTipo(dataGastosTipo);
    graficoCobranza(dataCobranzaMes);
    graficoIngresosEgresos();



    function graficoGastosTipo(dataGastosTipo){
        //console.log(dataGastosTipo)

        var ctx = document.getElementById('gastos-tipo');
        // Define fonts
        var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

        // Chart labels
        //const labels = ['Administracion', 'Uso o Consumo', 'Mantencion', 'Reparacion'];
        
        let labels = [];
		let data2 = [];

		for(let clave in dataGastosTipo){
			if(dataGastosTipo.hasOwnProperty(clave)){
				labels.push(dataGastosTipo[clave].Nombre)
				data2.push(dataGastosTipo[clave].total)
			}
		}
        // Chart data
        const data = {
            labels: labels,
            datasets: [{
                data: data2,
                backgroundColor: [
				'rgba(0, 0, 0, 0.6)',// NEGRO
				'rgba(255, 99, 132, 0.6)', //ROJO
				'rgba(255, 159, 64, 0.6)', //NARANJA
				'rgba(0, 204, 153, 0.6)',
				'rgba(255, 205, 86, 0.6)', //AMARILLO
				'rgba(75, 192, 192, 0.6)', // CALIPSO
				'rgba(54, 162, 235, 0.6)', //CELESTE
				'rgba(153, 102, 255, 0.6)', // LILA
				'rgba(201, 203, 207, 0.6)', //GRIS
				'rgba(0, 0, 255, 0.4)', //AZUL
				'rgba(0, 128, 0, 0.4)',       // Verde oscuro
				'rgba(128, 0, 128, 0.4)'
			],
			borderColor: [
				'rgb(0, 0, 0)', //NEGRO
				'rgb(255, 99, 132)',
				'rgb(255, 159, 64)',
				'rgba(0, 204, 153)',
				'rgb(255, 205, 86)',
				'rgb(75, 192, 192)',
				'rgb(54, 162, 235)',
				'rgb(153, 102, 255)',
				'rgb(201, 203, 207)',
				'rgb(0, 0, 255, 0.7)',           // AZUL
				'rgb(0, 128, 0, 0.7)',             // Verde oscuro
				'rgba(128, 0, 128, 0.7)'
			],
			borderWidth: 2,
                hoverOffset: 4
            }]
            };

        // Chart config
        const config = {
            type: 'pie',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.chart.data.datasets[0].data.reduce((acc, curr) => acc + curr, 0);
                                let percentage = ((value / total) * 100).toFixed(2);
                                return `$${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            defaults:{
                global: {
                    defaultFont: fontFamily
                }
            }
        };

        // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
        var myChart = new Chart(ctx, config);
    }

    function graficoCobranza(dataCobranzaMes){
        console.log(dataCobranzaMes)
        var ctx = document.getElementById('grafico-cobranza');
        // Define fonts
        var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');
        // Chart labels
        //const labels = ['Pagado', 'Abonado', 'Impago'];

        let labels = [];
		let data2 = [];

		for(let clave in dataCobranzaMes){
			if(dataCobranzaMes.hasOwnProperty(clave)){
				labels.push(dataCobranzaMes[clave].Estado)
				data2.push(dataCobranzaMes[clave].total)
			}
		}


        // Chart data
        const data = {
            labels: labels,
            datasets: [{
                data: data2,
                backgroundColor: [
				'rgba(75, 192, 192, 0.6)', // CALIPSO
				'rgba(54, 162, 235, 0.6)', //CELESTE
				'rgba(153, 102, 255, 0.6)', // LILA
				'rgba(201, 203, 207, 0.6)', //GRIS
				'rgba(0, 0, 255, 0.4)', //AZUL
				'rgba(0, 128, 0, 0.4)',       // Verde oscuro
				'rgba(128, 0, 128, 0.4)'
			],
			borderColor: [
				'rgb(75, 192, 192)',
				'rgb(54, 162, 235)',
				'rgb(153, 102, 255)',
				'rgb(201, 203, 207)',
				'rgb(0, 0, 255, 0.7)',           // AZUL
				'rgb(0, 128, 0, 0.7)',             // Verde oscuro
				'rgba(128, 0, 128, 0.7)'
			],
			borderWidth: 2,
                hoverOffset: 4
            }]
            };
        // Chart config
        const config = {
            type: 'doughnut',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = context.chart.data.datasets[0].data.reduce((acc, curr) => acc + curr, 0);
                                let percentage = ((value / total) * 100).toFixed(2);
                                return `${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            },
            defaults:{
                global: {
                    defaultFont: fontFamily
                }
            }
        };
        // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
        var myChart = new Chart(ctx, config);
    }

    function graficoIngresosEgresos(){
        
        var ctx = document.getElementById('grafico-ingresos-egresos');
        var primaryColor = KTUtil.getCssVariableValue('--kt-primary');
        var dangerColor = KTUtil.getCssVariableValue('--kt-danger');
        // Define fonts
        var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');
        // Chart labels
        const labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Noviembre','Diciembre'];
        // Chart data
        const data = {
            labels: labels,
            datasets: [{
                label: 'Ingresos',
                data: [30, 50, 100, 75, 45, 60, 80, 90, 110, 95, 70, 85],
                backgroundColor: 'rgba(80, 205, 137, 0.6)', // Color de fondo para ingresos
                borderColor: 'rgb(80, 205, 137)', // Color del borde para ingresos
                borderWidth: 2,
                hoverOffset: 4,
            }, {
                label: 'Egresos',
                data: [20, 40, 80, 55, 35, 50, 70, 80, 100, 85, 60, 75], // Datos de egresos
                backgroundColor: 'rgba(239, 99, 133, 0.6)', // Color de fondo para egresos
                borderColor: 'rgb(239, 99, 133)', // Color del borde para egresos
                borderWidth: 2,
                hoverOffset: 4
            }
            ]};
        // Chart config
        const config = {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: false,
                    },
                },
                responsive: true
            },
            defaults:{
                global: {
                    defaultFont: fontFamily
                }
            }
        };
        // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
        var myChart = new Chart(ctx, config);
    }

});