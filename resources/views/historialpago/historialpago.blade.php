@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css" />
@endpush

<!--begin::Toolbar-->
<div class="toolbar py-2" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
        <!--begin::Page title-->
        <div class="flex-grow-1 flex-shrink-0 me-5">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Historial de Pagos
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-semibold my-1 ms-1">#XRS-45670</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap" style="width: 200px;">
            <!--begin::Wrapper-->
            <select id="ComunidadInput" name="Comunidad" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                <option value="0" selected>TODAS</option>
                <option value="1">Comunidad 1</option>
                <option value="2">Comunidad 2</option>
                <option value="3">Comunidad 3</option>
                <option value="4">Comunidad 4</option>
            </select>

            <!--end::Wrapper-->
        </div>
        <!--end::Action group-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">
    <!-- begin::Div de fecha -->
    <div class="d-flex flex-column flex-column-fluid">
        <div class="card mx-5 mb-2">
            <div class="card-body p-2">
                <div class="d-flex flex-row justify-content-between align-items-center">
                <div class="w-md-200px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                    <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                    @foreach ($gastosmeses as $gastomes )
                        <option value="{{ $gastomes->Id }}">{{ $gastomes->Fecha->format('m-Y') }} </option>
                        @endforeach
                    </select>
                </div>

                </div>
            </div>
        </div>
        <div id="historiales-pagos" class="mx-5">
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
                                <td>{{ $gastoComun->TotalCobroMes }}</td>
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

        </div>

    </div>
    <!--end::Content-->
<!--begin::Modal pago -->
    <div class="modal fade" tabindex="-1" id="modal-nuevo-pago" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Registrar Pago</h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-3x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="1" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <form id="formulario-pago" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="number" class="form-control" placeholder="Monto a Pagar" id="MontoPagarInput" name="MontoPagar" value="500000" disabled/>
                                <label for="MontoPagarInput" class="form-label">Monto a pagar:</label>
                                <input hidden type="number" id="gastoComunIdInput" name="gastoComunId" />

                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="number" class="form-control" autocomplete="off" placeholder="Ingrese el monto del pago" id="MontoPagoInput" name="MontoPago" />
                                <label for="MontoPagoInput" class="form-label">Monto del pago</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="TipoPagoInput" name="TipoPago" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    @foreach($TiposPagos as $tipopago)
                                        <option value="{{ $tipopago->Id }}">{{ $tipopago->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="TipoPagoInput" class="form-label">Medio de pago</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="number" class="form-control" autocomplete="off" placeholder="Ingrese el número de documento" id="NumDocInput" name="NumDoc" />
                                <label for="NumDocInput" class="form-label">Numero de documento</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="RegistrarPagoButton" type="submit" class="btn btn-success">
                        <div class="indicator-label">Registrar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>

                </div>
            </form>


        </div>
    </div>
</div>
<!--end::modal-->

<!--begin::Modal pago -->
<div class="modal fade" tabindex="-1" id="modal-ver-registro" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Pago de gasto común</h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-secondary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-3x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="1" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <form id="FormularioVer" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError2" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control text-uppercase" placeholder="Propiedad" id="PropiedadInput" name="Propiedad" disabled/>
                                <label for="PropiedadInput" class="form-label">Propiedad:</label>
                                <input hidden type="number" id="IdInput" name="Id" />

                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control text-uppercase" autocomplete="off" placeholder="Ingrese el monto del pago" id="CopropietarioInput" name="Copropietario" disabled/>
                                <label for="CopropietarioInput" class="form-label">Copropietario</label>
                            </div>
                        </div>
                    </div><div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="number" class="form-control" placeholder="Monto a Pagar" id="MontoTotalInput" name="MontoPagar" disabled/>
                                <label for="MontoPagarInput" class="form-label">Monto a pagar:</label>

                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EstadoPagoInput" name="EstadoPago" class="form-select text-uppercase" data-control="select2" data-placeholder="Seleccione" data-hide-search="true" disabled >                                    <option></option>
                                    @foreach($Estados as $estado)
                                        <option value="{{ $estado->Id }}">{{ $estado->Nombre }}</option>
                                    @endforeach
                                    
                                </select>
                                <label for="EstadoPagoInput" class="form-label">Estado del pago</label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                <table id="historial-pagos" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Fecha del pago</th>
                        <th scope="col">Monto pagado</th>
                        <th scope="col">Medio de pago</th>
                        <th scope="col">N° Documento</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
<!--end::modal-->

    @endsection

    @push('Script')
    <script>
        var NuevoPago = "{{ route('NuevoPago') }}"
        var GuardarPago = "{{ route('GuardarPago') }}"
        var UltimoPago = "{{ route('UltimoRegistro') }}"
        var VerHistorial = "{{ route('VerHistorial') }}"
        
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>

    <script src="{{ asset('js/eventos/historialpago.js') }}"></script>

    @endpush