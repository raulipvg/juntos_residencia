        <div class="card mb-2">
            <div class="card-body px-4 py-2">
            <input id="gastoEstado" hidden type="numer" value="{{ $gasto->EstadoId }}">
            <div class="accordion accordion-icon-toggle" id="accordion-gastos">
                <!--begin::Item-->
                <div class="accordion-item rounded-top-1">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 rounded-top-1" data-bs-toggle="collapse" data-bs-target="#accordion-gastos-adm" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Administración</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">
                                    $ {{ number_format($gasto->TotalAdm, 0, '', '.')}}                                    
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div id="accordion-gastos-adm" class="fs-6 px-5 collapse show" data-bs-parent="#accordion-gastos" >
                        <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="5" class="p-2">Remuneraciones</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    
                                    @foreach ( $gasto->gastos_detalles as $indice => $detalle )
                                        @if ( $detalle->TipoGastoId == 1)
                                            <tr>
                                                <td class="py-0 px-2 text-capitalize">{{ $detalle->Nombre }}</td> <!--Nombre -->
                                                <td class="py-0 text-capitalize">{{ $detalle->Responsable}}</td> <!--Responsable-->
                                                <td class="py-0 text-gray-400">{{ $detalle->Detalle }}</td> <!-- Detalle, Descripcion -->
                                                <td class="py-0 text-gray-400"> {{ $detalle->NroDocumento }}</td> <!-- Tipo + Nro Documento -->
                                                <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                    <span class="text-start">$</span>
                                                    <span class="text-end">{{ number_format($detalle->Precio, 0, '', '.') }}</span>  <!--Monto,Precio -->
                                                </td>
                                            </tr>
                                            @php
                                                $gasto->gastos_detalles->forget($indice) 
                                            @endphp
                                        @endif
                                    @endforeach                                                       
                                    
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="4" class="py-0 px-2">TOTAL REMUNERACIONES</th>
                                        <th class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">{{ number_format($gasto->TotalRemuneracion, 0, '', '.')}} </span>        
                                        </th>
                                    </tr>
                                </tbody>
                                
                                <thead>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="5" class="p-2">Caja Chica</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    @foreach ( $gasto->gastos_detalles as $indice => $detalle )
                                        @if ( $detalle->TipoGastoId == 2)
                                            <tr>
                                                <td class="py-0 px-2 text-capitalize">{{ $detalle->Nombre }}</td> <!--Nombre -->
                                                <td class="py-0 text-capitalize">{{ $detalle->Responsable}}</td> <!--Responsable-->
                                                <td class="py-0 text-gray-400">{{ $detalle->Detalle }}</td> <!-- Detalle, Descripcion -->
                                                <td class="py-0 text-gray-400"> {{ $detalle->NroDocumento }}</td> <!-- Tipo + Nro Documento -->
                                                <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                    <span class="text-start">$</span>
                                                    <span class="text-end">{{ number_format($detalle->Precio, 0, '', '.') }}</span>  <!--Monto,Precio -->
                                                </td>
                                            </tr>
                                            @php
                                                $gasto->gastos_detalles->forget($indice) 
                                            @endphp
                                        @endif
                                    @endforeach
                                    <tr class="text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="4" class="py-0 px-2">TOTAL CAJA CHICA</th>
                                        <th class="py-0 pe-2 text-gray-800 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            {{ number_format($gasto->TotalCajaChica, 0, '', '.')  }}</th>
                                    </tr>  

                                    
                                </tbody>
                                <thead>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="5" class="p-2">Otros Gastos</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    @foreach ( $gasto->gastos_detalles as $indice => $detalle )
                                        @if ( $detalle->TipoGastoId == 6)
                                            <tr>
                                                <td class="py-0 px-2 text-capitalize">{{ $detalle->Nombre }}</td> <!--Nombre -->
                                                <td class="py-0 text-capitalize">{{ $detalle->Responsable}}</td> <!--Responsable-->
                                                <td class="py-0 text-gray-400">{{ $detalle->Detalle }}</td> <!-- Detalle, Descripcion -->
                                                <td class="py-0 text-gray-400"> {{ $detalle->NroDocumento }}</td> <!-- Tipo + Nro Documento -->
                                                <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                    <span class="text-start">$</span>
                                                    <span class="text-end">{{ number_format($detalle->Precio, 0, '', '.') }}</span>  <!--Monto,Precio -->
                                                </td>
                                            </tr>
                                            @php
                                                $gasto->gastos_detalles->forget($indice) 
                                            @endphp
                                        @endif
                                    @endforeach
                                    
                                    <tr class="text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="4" class="py-0 px-2">TOTAL OTROS GASTOS</th>
                                        <th class="py-0 pe-2 text-gray-800 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            {{ number_format($gasto->TotasOtros, 0, '', '.')  }}</th>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                        <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE ADMINISTRACIÓN</th>
                                        <th class="py-0 pe-2">
                                            <div class="d-flex justify-content-between fw-bolder text-white">
                                                <span class="text-start">$</span>
                                                {{ number_format($gasto->TotalAdm, 0, '', '.') }}
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="accordion-item">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-uso" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Uso o Consumo</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">$ {{ number_format($gasto->TotalConsumo, 0, '', '.') }}</div>
                            </div>
                        </div>   
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div id="accordion-gasto-uso" class="fs-6 px-5 collapse" data-bs-parent="#accordion-gastos">
                    <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr>
                                       
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    @foreach ( $gasto->gastos_detalles as $indice => $detalle )
                                        @if ( $detalle->TipoGastoId == 3)
                                            <tr>
                                                <td class="py-0 px-2 text-capitalize">{{ $detalle->Nombre }}</td> <!--Nombre -->
                                                <td class="py-0 text-capitalize">{{ $detalle->Responsable}}</td> <!--Responsable-->
                                                <td class="py-0 text-gray-400">{{ $detalle->Detalle }}</td> <!-- Detalle, Descripcion -->
                                                <td class="py-0 text-gray-400"> {{ $detalle->NroDocumento }}</td> <!-- Tipo + Nro Documento -->
                                                <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                    <span class="text-start">$</span>
                                                    <span class="text-end">{{ number_format($detalle->Precio, 0, '', '.') }}</span>  <!--Monto,Precio -->
                                                </td>
                                            </tr>
                                            @php
                                                $gasto->gastos_detalles->forget($indice) 
                                            @endphp
                                        @endif
                                    @endforeach
                                    
                                    <thead>
                                        <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                            <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE USO O CONSUMO</th>
                                            <th class="py-0 pe-2">
                                                <div class="d-flex justify-content-between fw-bolder text-white">
                                                    <span class="text-start">$</span>{{ number_format($gasto->TotalConsumo, 0, '', '.') }}
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                </tbody>                            
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="accordion-item">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-mantencion" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Mantención</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">$ {{ number_format($gasto->TotalMantencion, 0, '', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div id="accordion-gasto-mantencion" class="collapse fs-6 px-5" data-bs-parent="#accordion-gastos">
                        <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr></tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    @foreach ( $gasto->gastos_detalles as $indice => $detalle )
                                        @if ( $detalle->TipoGastoId == 4)
                                            <tr>
                                                <td class="py-0 px-2 text-capitalize">{{ $detalle->Nombre }}</td> <!--Nombre -->
                                                <td class="py-0 text-capitalize">{{ $detalle->Responsable}}</td> <!--Responsable-->
                                                <td class="py-0 text-gray-400">{{ $detalle->Detalle }}</td> <!-- Detalle, Descripcion -->
                                                <td class="py-0 text-gray-400"> {{ $detalle->NroDocumento }}</td> <!-- Tipo + Nro Documento -->
                                                <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                    <span class="text-start">$</span>
                                                    <span class="text-end">{{ number_format($detalle->Precio, 0, '', '.') }}</span>  <!--Monto,Precio -->
                                                </td>
                                            </tr>
                                            @php
                                                $gasto->gastos_detalles->forget($indice) 
                                            @endphp
                                        @endif
                                    @endforeach
                                    <thead>
                                        <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                            <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE MANTENCION</th>
                                            <th class="py-0 pe-2">
                                                <div class="d-flex justify-content-between fw-bolder text-white">
                                                    <span class="text-start">$</span>{{ number_format($gasto->TotalMantencion, 0, '', '.') }}
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                </tbody>                            
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="accordion-item">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-reparacion" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Reparación</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">$ {{ number_format($gasto->TotalReparacion, 0, '', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div id="accordion-gasto-reparacion" class="collapse fs-6 px-5" data-bs-parent="#accordion-gastos">
                        <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr></tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    @foreach ( $gasto->gastos_detalles as $indice => $detalle )
                                        @if ( $detalle->TipoGastoId == 5)
                                            <tr>
                                                <td class="py-0 px-2 text-capitalize">{{ $detalle->Nombre }}</td> <!--Nombre -->
                                                <td class="py-0 text-capitalize">{{ $detalle->Responsable}}</td> <!--Responsable-->
                                                <td class="py-0 text-gray-400">{{ $detalle->Detalle }}</td> <!-- Detalle, Descripcion -->
                                                <td class="py-0 text-gray-400"> {{ $detalle->NroDocumento }}</td> <!-- Tipo + Nro Documento -->
                                                <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                                    <span class="text-start">$</span>
                                                    <span class="text-end">{{ number_format($detalle->Precio, 0, '', '.') }}</span>  <!--Monto,Precio -->
                                                </td>
                                            </tr>
                                            @php
                                                $gasto->gastos_detalles->forget($indice) 
                                            @endphp
                                        @endif
                                    @endforeach
                                    
                                    <thead>
                                        <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                            <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE REPARACIÓN</th>
                                            <th class="py-0 pe-2">
                                                <div class="d-flex justify-content-between fw-bolder text-white">
                                                <span class="text-start">$</span>{{ number_format($gasto->TotalReparacion, 0, '', '.') }}
                                                </div>
                                                
                                            </th>
                                        </tr>
                                    </thead>
                                </tbody>                            
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->
            </div>
            <div class="d-flex align-items-end flex-column">
                <div class="d-flex flex-stack bg-gray-300 p-3 rounded-bottom-1">
					<!--begin::Content-->
					<div class="fs-3 fw-bold text-dark">
						<span class="d-block lh-1 mb-2">Total Gastos del Mes</span>
					    <span class="d-block mb-7">Fondo de Reserva 5%</span>
						<span class="d-block fs-2qx lh-1">TOTAL</span>
					</div>
					<!--end::Content-->
					<!--begin::Content-->
					<div class="fs-3 fw-bold text-dark text-end pe-4">
						<span class="d-block lh-1 mb-2" >$ {{ number_format($gasto->TotalMes, 0, '', '.') }}</span>
						<span class="d-block mb-7">$ {{ number_format($gasto->FondoReserva, 0, '', '.') }}</span>
						<span class="d-block fs-2qx lh-1">$ {{ number_format($gasto->Total, 0, '', '.') }}</span>
					</div>
					<!--end::Content-->
				</div>
            </div>

            
            </div>
        </div>