@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
<style>
</style>
@endpush                            
   
<!--begin::Toolbar-->
<div class="toolbar py-2" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
        <!--begin::Page title-->
        <div class="flex-grow-1 flex-shrink-0 me-5">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Home
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-semibold my-1 ms-1">#Comunidad EL Teto</small>
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
			<div class="w-md-125px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                    @foreach ($gastosmeses as $gastomes )
                        <option data-info="{{$gastomes->EstadoId }}" value="{{ $gastomes->Id }}" @if ( $gastomes->Id == $gasto->Id ) selected @endif >{{ $gastomes->Fecha->format('m-Y') }} </option>
                    @endforeach
                </select>
            </div> 
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap" style="width: 200px;" >
			<select id="ComunidadInput" name="Comunidad" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false">
                <option></option>
                @foreach($comunidades as $comunidad)                          
                	<option @if($comunidadId == $comunidad->Id) selected  @endif value="{{ $comunidad->Id }}">{{ Str::title($comunidad->Nombre)  }}</option>
                @endforeach
            </select>
        </div>
        <!--end::Action group-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">
    
    <!--begin::Container-->
    <div  class="container-xxl">
							<!-- begin::Invoice 3-->
							<div class="card mb-6">
								<!-- begin::Body-->
								<div id="gasto-comun" class="card-body p-2">
									<!-- begin::Wrapper-->
									<div class="mx-2">
										<!-- begin::Header-->
										<div class="d-flex justify-content-between flex-column flex-sm-row mb-1 d-flex align-items-center">
											<div class="flex-fill">
												<h4 class="fw-bolder text-gray-800 fs-2qx">GASTOS COMUNES SEPTIEMBRE 2023</h4>
												<div class="d-flex flex-row gap-7 gap-md-10 fw-bold mb-2 ps-2">
														<div class="flex-root d-flex flex-column">
															<span class="text-muted">Folio N</span>
															<span class="fs-5">#14534</span>
														</div>
														<div class="flex-root d-flex flex-column">
															<span class="text-muted">Mes de Cobro</span>
															<span class="fs-5">Septiembre 2023</span>
														</div>
														<div class="flex-root d-flex flex-column">
															<span class="text-muted">Desde</span>
															<span class="fs-5">31-07-2023</span>
														</div>
														<div class="flex-root d-flex flex-column">
															<span class="text-muted">Hasta</span>
															<span class="fs-5">31-08-2023</span>
														</div>
													</div>
											</div>
											<!--end::Logo-->
											<div class="text-sm-end">
												<!--begin::Text-->
												<div class="text-sm-end fw-semibold fs-6 text-muted border border-2 border-dashed p-2 rounded">
													<div>Comunidad de Copropietarios del Edificio el Teto</div>
                                                    <div>23.234.231-2</div>
                                                    <div>Maipu #1223</div>
													<div>Telefono +569 99665015</div>
												</div>
												<!--end::Text-->
											</div>
										</div>
										<!--end::Header-->
                                        
												<!--begin::Billing & shipping-->
												<div class="d-flex flex-column flex-sm-row fw-bold">
													<div class="d-flex flex-grow-1">
													<div class="flex-root d-flex flex-column align-self-center">
															<div class="d-flex flex-row flex-wrap justify-content-between">
															<span class="text-muted">Copropietario: </span>
															<span class="text-dark"> Joselito Vaca (22.342.343-0)</span>
														</div>
														<div class="d-flex  flex-row flex-wrap justify-content-between">
                                                        	<span class="text-muted">Residente: </span>
															<span class="text-dark"> Miguel de Cervantes (23.342.232-K)</span>
														</div>
														<div class="d-flex flex-row flex-wrap justify-content-between">
															<span class="text-muted">Unidad Copropiedad: </span>
															<span class="text-dark"> Departamento 202-C</span>
														</div>
														<div class="d-flex flex-row flex-wrap justify-content-between">
															<span class="text-muted">Prorrateo: </span>
															<span class="text-dark">1.23123 %</span>
														</div>
													</div>
													</div>
													<div class="d-flex flex-grow-1">
													<div class="flex-root d-flex align-self-center justify-content-center">
														<canvas id="kt_chartjs_1" class="mh-150px mw-400px"></canvas>
													</div>
													</div>
													<div class="d-flex flex-grow-1">
													<div class="flex-root d-flex align-self-center justify-content-center">
                                                    	<div class="d-flex justify-content-center" data-bs-theme="light">
															<div class="rounded p-2" style="background-color: #1c2d98d9;">
																<div class="d-flex flex-column position-relative fs-1 fw-bold text-white">
																	<div class="d-flex flex-row flex-wrap justify-content-center">
																		<span class="me-2 text-center">TOTAL A PAGAR</span>
																		<span  class="text-warning opacity-75-hover">$135.543</span>
																				
																	</div>
																	<div class="d-flex flex-row flex-wrap justify-content-center">
																		<span class="me-2 text-center">VENCIMIENTO</span>
																		<span  class="text-warning opacity-75-hover">30/09/2023</span>
																	</div>

																			
                                                            	</div>                                                                        
                                                            </div>
                                                                    
                                                                
                                                        </div>
													</div>
													</div>
												</div>
												<!--end::Billing & shipping-->
										<!--begin::Body-->
										<div class="pb-12">
											<!--begin::Wrapper-->
											<div class="d-flex flex-column">
												<div class="d-flex justify-content-between flex-column">
													<!--begin::Table-->
													<div class="table-responsive border-bottom mb-9 mt-2">
														<table class="table table-hover align-middle table-row-dashed fs-6 gy-5 mb-0">
															<thead>
																<tr class="bg-gray-400 border-bottom fs-6 fw-bold ">
																	<th colspan="3" class="min-w-175px p-2">DETALLE</th>
																</tr>
															</thead>
															<tbody class="fw-semibold text-gray-600">
																<tr >
																	<td colspan="3" class="p-1">
																		<div class="ms-5">
																				<div class="fw-bold">Total Gasto Común: $ <span>6.342.323</span></div>
																		</div>																	
																	</td>
																</tr>
															</tbody>
															<thead>
																<tr class="bg-gray-300 border-bottom fs-6 fw-bold">
																	<th class="col-8 min-w-175px p-1"></th>
																	<th class="col-2 min-w-175px p-1 text-end">COBRO</th>
																	<th class="col-2 min-w-175px p-1 text-end">TOTALES</th>
																</tr>
															</thead>
															<tbody class="fw-semibold text-gray-600">
																<tr>
																	<td class="p-1">
																		<div class="d-flex align-items-center">
																			<div class="fw-bold text-dark">Gatos Comunes Generales</div>
																		</div>
																	</td>
																	<td class="p-1"></td>
																	<td class="p-1 ps-5 ">
																		<div class="d-flex justify-content-between text-end text-dark">
																			$ <span>240.000</span>
																		</div>																
																	</td>
																</tr>
																<tr>
																	<td class="p-1">
																		<div class="d-flex align-items-center">
																			<div class="ms-5">
																				<div class="fw-bold">Gasto Comun</div>
																			</div>
																		</div>
																	</td>
																	<td class="p-1">
																		<div class="d-flex justify-content-between fw-bold">	
																			$ <span>112.231</span>
																		</div>
																	</td>
																	<td class="p-1 text-end"></td>
																</tr>
																<tr>
																	<td class="p-1">
																		<div class="d-flex align-items-center">
																			<div class="ms-5">
																				<div class="fw-bold">Fondo Reserva</div>
																			</div>
																		</div>
																	</td>
																	<td class="p-1">
																		<div class="d-flex justify-content-between fw-bold">
																			$ <span>12.231</span>
																		</div>	
																	</td>
																	<td class="p-1 text-end"></td>
																</tr>
																<!-- BEGIN::Cobros Individuales -->
																<tr>
																	<td class="p-1">
																		<div class="d-flex align-items-center">
																			<div class="ms-5">
																				<div class="fw-bold">Cobros Individuales</div>
																			</div>
																		</div>
																	</td>
																	<td class="p-1">
																		<div class="d-flex justify-content-between fw-bold">
																			$ <span>12.231</span>
																		</div>
																	</td>
																	<td class="p-1 text-end"></td>
																</tr>
																<tr>
																	<td class="p-1">
																		<div class="d-flex align-items-center">
																			<div class="ms-7">
																				<div class="fs-7 ps-2 text-muted">Agua culia 45m3</div>
																			</div>
																		</div>
																	</td>
																	<td class="p-1">
																		<div class="d-flex justify-content-between fw-bold fs-7 text-muted">
																			$ <span>12.231</span>
																		</div>
																	</td>
																	<td class="p-1 text-end"></td>
																</tr>
																<!--- END::COBROS INDIVIDUALES -->
																
																<!-- BEGIN::Reserva de Espacios -->
																<tr>
																	<td class="p-1">
																		<div class="d-flex align-items-center">
																			<div class="ms-5">
																				<div class="fw-bold">Reserva de Espacios</div>
																			</div>
																		</div>
																	</td>
																	<td class="p-1">
																		<div class="d-flex justify-content-between fw-bold">
																		$ <span>12.231</span>
																		</div>	
																	
																	</td>
																	<td class="p-1 text-end"></td>
																</tr>
																<tr>
																	<td class="p-1">
																		<div class="d-flex align-items-center">
																			<div class="ms-7">
																				<div class="fs-7 ps-2 text-muted">Quincho</div>
																			</div>
																		</div>
																	</td>
																	<td class="p-1">
																		<div class="d-flex justify-content-between fw-bold fs-7 text-muted">
																			$ <span>12.231</span>
																		</div>
																	</td>
																	<td class="p-1 text-end"></td>
																</tr>
																<!--- END::Reserva de Espacios --> 

																<tr class="bg-gray-300">
																	<td colspan="2" class="p-1 text-end text-uppercase text-dark">Total Gastos del Mes</td>
																	<td class="p-1 ps-5 ">
																		<div class="d-flex justify-content-between fw-bold">
																			$ <span>264.000</span>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td colspan="2" class="p-1 text-end text-uppercase text-dark">Total Gastos Atrasados</td>
																	<td class="p-1 ps-5">
																		<div class="d-flex justify-content-between">
																			$ <span>0</span>
																		</div>
																	</td>
																</tr>
																<tr class="bg-gray-400">
																	<td colspan="2" class="p-3 pe-1 fs-3 text-dark fw-bold text-end text-uppercase">Total a Pagar</td>
																	<td class="p-3 ps-5 pe-1">
																		<div class="text-dark fs-3 fw-bolder d-flex justify-content-between">
																			$ <span>264.000<span>
																		</div>		
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<!--end::Table-->
												</div>
												<div class="row">
													<div class="col-6">
														<div class="border border-dashed border-gray-300 card-rounded p-3 bg-lighten">
															<h6 class="mb-3 fw-bolder text-gray-600 text-hover-dark text-uppercase">Datos de Transferencia</h6>
															<div class="row mb-1">
																<div class="col">
																	<div class="fw-semibold text-gray-600 fs-7">Nombre:</div>
																	<div class="fw-bold text-gray-800 fs-6">Comunidad el Teto</div>
																</div>
																<div class="col">
																	<div class="fw-semibold text-gray-600 fs-7">Rut:</div>
																	<div class="fw-bold text-gray-800 fs-6">12.322.321-2</div>
																</div>
															</div>
															<div class="row mb-1">
																<div class="col">
																	<div class="fw-semibold text-gray-600 fs-7">Cuenta:</div>
																	<div class="fw-bold text-gray-800 fs-6">112312312</div>
																</div>
																<div class="col">
																	<div class="fw-semibold text-gray-600 fs-7">Tipo:</div>
																	<div class="fw-bold text-gray-800 fs-6">Cuenta Corriente</div>
																</div>
															</div>
															<div class="row mb-1">
																<div class="col">
																	<div class="fw-semibold text-gray-600 fs-7">Banco:</div>
																	<div class="fw-bold text-gray-800 fs-6">Banco el Teto</div>
																</div>
																<div class="col">
																	<div class="fw-semibold text-gray-600 fs-7">Email:</div>
																	<div class="fw-bold text-gray-800 fs-6">elteto@gmail.com</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-6">
														<div class="border border-dashed border-gray-300 card-rounded p-3 bg-lighten">
															<div class="table-responsive border-bottom mb-9 mt-2">
																<table class="table  fs-6 gy-5 mb-0">
																	<thead>
																		<tr class="bg-gray-400 border-bottom fs-6 fw-bold ">
																			<th class="p-1">Boleta</th>
																			<th class="p-1">Tipo</th>
																			<th class="p-1 text-center">Fecha</th>
																			<th class="p-1 text-end">Monto</th>
																		</tr>
																	</thead>
																	<tbody class="fw-semibold text-gray-600">
																		<tr>
																			<td class="p-1">12312321</td>
																			<td class="p-1">Transferencia</td>
																			<td class="p-1">12-08-2023</td>
																			<td class="p-1">
																				<div class="d-flex justify-content-between fw-bold">
																				$ <span>12.231</span>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td class="p-1">12312321</td>
																			<td class="p-1">Transferencia</td>
																			<td class="p-1">12-08-2023</td>
																			<td class="p-1">
																				<div class="d-flex justify-content-between fw-bold">
																				$ <span>12.231</span>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td class="p-1">12312321</td>
																			<td class="p-1">Transferencia</td>
																			<td class="p-1">12-08-2023</td>
																			<td class="p-1">
																				<div class="d-flex justify-content-between fw-bold">
																				$ <span>12.231</span>
																				</div>
																			</td>
																		</tr>
																	
																	</tbody>
																</table>
															</div>
														</div>
														
													</div>
												</div>
												


												<div class="d-flex justify-content-end">
													<div class="col-3 text-end mt-6">
														<br />
														<div class="separator"></div>
														<span class="fw-bold text-muted fs-5">Administrador</span></div>
													</div>

												</div>
												
												
												
											</div>
											<!--end::Wrapper-->
										</div>
										<!--end::Body-->
										<!-- begin::Footer-->
										
										<!-- end::Footer-->
									</div>
									<!-- end::Wrapper-->
								</div>
								<div class="d-flex justify-content-end p-1">
									<div class="me-1">
										<button id="imprimir-gasto" type="button" class="btn btn-success">Imprimir</button>
									</div>
								</div>							
							</div>
							<!-- end::Invoice 3-->
						</div>
						<!--end::Container-->

    
</div>
<!--end::Content-->


@endsection
@push('Script')
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

    <script>
$(document).ready(function() {

	$("#imprimir-gasto").click( function (e){
			imprimirGastoComun();
	});

		function imprimirGastoComun() {
            const divToPrint = document.getElementById('gasto-comun');
            
            html2canvas(divToPrint, { scale: 4 }).then(canvas => {
                var newWin = window.open('', '_blank');
                newWin.document.write('<html><head><title>GC_Deptartamento 202-C</title></head><body>');
                newWin.document.write('<img src="' + canvas.toDataURL() + '" style="width:100%;"/>');
                newWin.document.write('</body></html>');
                newWin.document.close();

				setTimeout(function() {
					newWin.print();
					}, 1000);
				});        
        }

		var ctx = document.getElementById('kt_chartjs_1');

		// Define colors
		var primaryColor = KTUtil.getCssVariableValue('--kt-primary');
		var dangerColor = KTUtil.getCssVariableValue('--kt-danger');
		var successColor = KTUtil.getCssVariableValue('--kt-success');

		// Define fonts
		var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');

		// Chart labels
		const labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene'];


		// Chart data
		const data = {
		labels: labels,
		datasets: [{
			label: 'Gastos',
			data: [65000, 59000, 80000, 81000, 56000, 55000, 40000, 80000, 81000, 56000, 55000, 40000, 34875],
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
			borderWidth: 2
		}]
		};

		// Chart config
		const config = {
			type: 'bar',
			data: data,
			options: {
				plugins: {
					title: {
						display: false,
					},
					legend: {
						display: false, // Esto ocultará la leyenda del gráfico
					}
				},
				responsive: true,
				interaction: {
					intersect: false,
				},
				scales: {
					x: {
						stacked: true,
						grid: {
							display: false, // Oculta las líneas verticales (eje x)
						},
					},
					y: {
						stacked: true
					}
				}
			},
			defaults:{
				global: {
					defaultFont: fontFamily
				}
			}
		};

		// Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
		var myChart = new Chart(ctx, config);
});

	</script>    
@endpush