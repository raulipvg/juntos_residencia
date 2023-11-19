@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
<style>
.rounded-bottom-1 {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: 20px!important;
    border-bottom-right-radius: 20px!important;
}
.rounded-top-1{
    border-top-left-radius: 20px!important;
    border-top-right-radius: 20px !important;
}

@media  ( min-width: 768px) {
  .top-md {
    position: relative;
    top: -572px;
  }
  .top-md-2 {
    position: relative;
    top: -665px;
  }
}



</style>
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
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Gastos Mensuales
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap" style="width: 200px;" >
            <!--begin::Wrapper-->
            <select id="ComunidadInput" name="Comunidad" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false">
                        <option></option>
                        @foreach($comunidades as $comunidad)                          
                        <option @if($comunidadId == $comunidad->Id) selected  @endif value="{{ $comunidad->Id }}">{{ Str::title($comunidad->Nombre)  }}</option>
                        @endforeach
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
    <div class="container-fluid">
        <div class="row flex-md-row">

            <div id="contenedor-1" class="col-md-8 col-12  mb-3">
                <div id="botones-ctrl" class="card">                   
                    <div class="card-body p-2">
                        <div id="div-adm" class="d-flex flex-row justify-content-between align-items-center">
                            <div class="sa">
                                <div class="row align-items-center">
                                    <div class="w-md-150px w-150px my-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                                        <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                                            @foreach ($gastosmeses as $gastomes )
                                                <option value="{{ $gastomes->Id }}" @if ( $gastomes->Id == $gasto->Id ) selected @endif >{{ $gastomes->Fecha->format('m-Y') }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto ms-md-2 ms-0 my-1 ps-3 ps-md-1">
                                        
                                        @if ($gasto == null )
                                            <button id="AbrirNuevoMes" type="button" class="btn btn-sm btn-success h-40px abrir-mes" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Abrir Nuevo Mes">
                                                ABRIR MES
                                            </button>
                                        @else
                                            @if ($gasto->EstadoId == 1)
                                                <button id="AccionMesInput" type="button" class="btn btn-sm btn-warning h-40px cerrar-mes my-2 my-md-0" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Cerrar y Publicar Gasto Mensual">
                                                    CERRAR MES
                                                </button>
                                            @elseif ($gasto->EstadoId == 2)
                                                <button id="AccionMesInput" type="button" class="btn btn-sm btn-dark h-40px disabled my-2 my-md-0">
                                                    MES CERRADO
                                                </button>
                                            @endif
                                        @endif
                                        <button id="AbrirNuevoMes" type="button" class="btn btn-sm btn-success h-40px abrir-mes" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Abrir Nuevo Mes">
                                            ABRIR MES
                                        </button>
                                        <!--
                                        <button id="AccionMesInput" type="button" class="btn btn-sm btn-success h-40px abrir-mes">
                                            ABRIR MES
                                        </button>
                                        -->
                                    </div>
                                </div>
                            </div>
                            <div id="btn-nuevo" class="col ms-2 my-1 text-end">
                                @if($gasto != null && $gasto->EstadoId == 1)
                                    <button id="NuevoGasto" type="button" class="btn btn-sm btn-nuevo-gasto btn-primary h-40px hover-scale" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Agregar Gasto">
                                    GASTO<i class="ki-outline ki-plus fs-2"></i>
                                    </button>
                                @endif
                            </div>
                            
                        </div>          
                    </div>
                </div>
            </div>

            <div id="contenedor-2" class="col-md-4 col-12 mb-3">
                <div id="agregar-gasto" class="">

                </div>
            </div>
       
            <div id="contenedor-3" class="col-md-8 col-12 mb-3">
                @if(count($gastosmeses) != 0 )
                <div id="gasto-detalle" class="">
                    <div class="card mb-2">
                        <div class="card-body p-2">
                        
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
                </div>
                @endif
            </div>
       
        </div>
    </div>
</div>

<!--end::Content-->



@endsection

@push('Script')
    <script> 
        const Index = "{{route('GastoMes') }}"; 
        const VerMeses = "{{ route('VerMeses') }}"; 
        const CerrarMes = "{{ route('CerrarMes') }}";
        const AbrirMes = "{{ route('AbrirMes') }}";
        const NuevoGasto = "{{ route('NuevoGasto') }}";
        const GuardarGastoDetalle = "{{ route('GuardarGastoDetalle') }}";

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/gastodetalle.js?id=1') }}"></script>
    <script src="{{ asset('js/eventos/gastomes.js?id=3') }}"></script>    
@endpush




