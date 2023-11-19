            <div class="card">
                <div class="card-body">
                    <table id="tabla-pagos" class="table table-row-dashed table-hover align-middle table rounded gy-2 gs-md-3 nowrap">
                        <thead>
                            <tr class="fw-bolder text-uppercase">
                                <th scope="col">#</th>
                                <th scope="col" class=" table-active">Propiedad</th>
                                <th scope="col">Propietario</th>
                                <th scope="col">Monto a pagar</th>
                                <th scope="col" class="text-center">Estado</th>
                                <th scope="col" class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($GastosComunes as $gastoComun)
                                <tr class="center-2 text-uppercase">
                                    <td class="p-0">
                                        {{ $gastoComun->Id }}
                                    </td>
                                    <td class="text-capitalize fw-bold p-0 table-active ps-2">
                                        {{ $gastoComun->propiedad->Numero }}
                                    </td>
                                    @php
                                        $personaFiltrada = $gastoComun->propiedad->compones->filter(function($compone) {
                                            return $compone->Enabled == 1 && $compone->RolComponeCoReId == 1;
                                        })->first()->persona;
                                    @endphp
                                    <td class="text-capitalize fw-bold p-0 ps-3">
                                        {{$personaFiltrada->Nombre}} {{$personaFiltrada->Apellido}}
                                    </td>
                                    <td class="p-0 ps-4 text-gray-600 fw-bold">
                                        $ {{ number_format($gastoComun->TotalCobroMes, 0, '', '.')  }}
                                    </td>
                                        @php
                                            $estadoPagoActual = $HistorialesPagos->filter(function($historial) use ($gastoComun){
                                                return $historial->GastoComunId == $gastoComun->Id;
                                            })->last();
                                        @endphp
                                    <td class="p-0 text-center">
                                        @if($estadoPagoActual->EstadoPagoId == 1) 
                                            <span class="badge badge-light-danger w-95px h-25px justify-content-center"> 
                                        @elseif($estadoPagoActual->EstadoPagoId == 2) 
                                            <span class="badge badge-light-warning w-95px h-25px justify-content-center">
                                        @else 
                                            <span class="badge badge-light-success w-95px h-25px justify-content-center">
                                        @endif
                                        {{ $estadoPagoActual->Nombre }}</span>
                                    </td>
                                    <td class="p-0 text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-sm btn-success VerRegistro" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Registro" info="{{ $gastoComun->Id }}" state="{{$estadoPagoActual->EstadoPagoId}}">Ver</button>
                                            @if($estadoPagoActual->EstadoPagoId < 3)
                                                <button type="button" class="btn btn-sm btn-primary  NuevoPago" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar Pago" info="{{ $gastoComun->Id }}" > <i class="ki-outline ki-plus fs-2" ></i></button>
                                            @endif    
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <script src="{{ asset('js/datatables/contenido/historial.js') }}"></script>