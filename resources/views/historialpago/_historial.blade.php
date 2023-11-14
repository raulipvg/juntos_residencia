<div class="card-body">
                <table id="tabla-pagos" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead>
                        <tr class="fw-bolder text-uppercase">
                            <th scope="col">#</th>
                            <th scope="col">Propiedad</th>
                            <th scope="col">Propietario</th>
                            <th scope="col">Monto a pagar</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($GastosComunes as $gastoComun)
                            <tr class="center-2 text-uppercase">
                                <td>{{ $gastoComun->Id }}</td>
                                <td>{{ $gastoComun->propiedad->Numero }}</td>
                                @php
                                    $personaFiltrada = $gastoComun->propiedad->compones->filter(function($compone) {
                                        return $compone->Enabled == 1 && $compone->RolComponeCoReId == 1;
                                    })->first()->persona;
                                @endphp
                                <td>{{$personaFiltrada->Nombre}} {{$personaFiltrada->Apellido}}</td>
                                <td>$ {{ number_format($gastoComun->TotalCobroMes, 0, '', '.')  }}</td>
                                @php
                                    $estadoPagoActual = $HistorialesPagos->filter(function($historial) use ($gastoComun){
                                        return $historial->GastoComunId == $gastoComun->Id;
                                    })->last();
                                @endphp
                                <td>
                                @if($estadoPagoActual->EstadoPagoId == 1) 
                                    <span class="badge badge-danger w-95px justify-content-center"> 
                                @elseif($estadoPagoActual->EstadoPagoId == 2) 
                                    <span class="badge badge-warning w-95px justify-content-center">
                                @else 
                                    <span class="badge badge-success w-95px justify-content-center">
                                @endif
                                {{ $estadoPagoActual->Nombre }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success h-40px VerRegistro" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Registro" info="{{ $gastoComun->Id }}" state="{{$estadoPagoActual->EstadoPagoId}}">Ver</i>
                                    </button>
                                    @if($estadoPagoActual->EstadoPagoId < 3)
                                    <button type="button" class="btn btn-sm btn-primary h-40px NuevoPago" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar Pago" info="{{ $gastoComun->Id }}" > <i class="ki-outline ki-plus fs-2" ></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
