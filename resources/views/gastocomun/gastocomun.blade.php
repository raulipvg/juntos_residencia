@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
<style>
.th-line {
    display: block;
    width: 100%;
    box-sizing: border-box; /* Para incluir el padding y el borde en el ancho total */
}
.rounded-top-1 {
border-top-left-radius: 20px!important;
border-top-right-radius: 20px !important;
}
.ver-cobro-invididual {
    cursor: pointer;
}
.ver-detalle {
    cursor: pointer;
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
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Gastos Comunes
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <div class="w-md-125px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                                    <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                                        @foreach ($gastosmeses as $gastomes )
                                            <option value="{{ $gastomes->Id }}" @if ( $gastomes->Id == $gasto->Id ) selected @endif >{{ $gastomes->Fecha->format('m-Y') }} </option>
                                        @endforeach
                                    </select>
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
    <div  class="card mx-5 mb-2">                   
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center mb-1">
               
            </div>
            <div id="contenedor-1" class="table-responsive">
                
                <table id="tabla-gasto-comun" class="table table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 px-7">
                            <th rowspan="2" colspan="3"  class="align-middle border-bottom ps-0">
                                
                            </th>
                            <th id="titulo" rowspan="1" colspan="6" class="text-center text-uppercase fs-3 table-dark text-white rounded-top-1">{{ $gasto->Fecha->formatLocalized('%B %Y') }}</th>
                        </tr>
                        <tr class="fw-bold fs-6 text-gray-800 px-7"> 
                            <th rowspan="1" colspan="1" class="border-bottom table-dark text-white p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($gasto->TotalMes, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th rowspan="1" colspan="1" class="border-bottom table-dark text-white p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($gasto->FondoReserva, 0, '', '.') }}</span>
                                </div> 
                            </th>
                            <th rowspan="1" colspan="1" class="border-bottom table-dark text-white p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($gasto->Total, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th rowspan="1" colspan="1" class="border-bottom text-center fw-bolder table-dark p-1"></th>
                            <th rowspan="1" colspan="2" class="border-bottom text-end table-dark text-white p-1">Fecha Apertura: {{ $gasto->Fecha->format('d-m-Y')}}</th>
                        </tr>
                        <tr class="fw-bolder text-uppercase fw-bolder text-gray-700">
                            <th class="table-active fs-5 p-1" scope="col">Nombre</th>
                            <th scope="col p-1">Propiedad</th>
                            <th scope="col p-1">%</th>
                            <th scope="col" class="text-end p-1">Cobro GC</th>
                            <th scope="col" class="text-end p-1">Fondo de Reserva</th>
                            <th class="table-active fs-5 text-end p-1" scope="col">Total GC</th>
                            <th scope="col" class="text-end p-1">Cobro Individual</th>
                            <th scope="col" class="text-end p-1">Saldo Anterior</th>
                            <th class="table-active fs-5 text-end p-1" scope="col">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $prorateo =0;
                            $cobroGC=0;
                            $fondo=0;
                            $totalGC=0;
                            $saldoAnterior=0;
                            $TotalMes=0;
                            $cobrosIndividuales=0
                        @endphp
                        @foreach ( $gastoscomunes as $detalle )
                            <tr data-info = "{{$detalle->Id }}">
                                <td class="text-capitalize fw-bold table-active p-1">{{ $detalle->Nombre }} {{ $detalle->Apellido }}</td>
                                <td class="text-capitalize fw-bold  p-1 ver-detalle">{{ $detalle->Numero }}</td>
                                <td class="p-1">{{ $detalle->Prorrateo }}%</td>
                                <td class="p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->CobroGC, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->FondoReserva, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="table-active fs-5 p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->TotalGC, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="p-1 ver-cobro-invididual" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Detalle del Cobro">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->CobroIndividual, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->SaldoMesAnterior, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="table-active fs-5 p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->TotalCobroMes, 0, '', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $prorateo = $prorateo+$detalle->Prorrateo;
                                $cobroGC = $cobroGC +$detalle->CobroGC;
                                $fondo = $fondo + $detalle->FondoReserva;
                                $totalGC = $totalGC+ $detalle->TotalGC;
                                $saldoAnterior= $saldoAnterior+ $detalle->SaldoMesAnterior;
                                $TotalMes = $TotalMes+$detalle->TotalCobroMes;
                                $cobrosIndividuales = $cobrosIndividuales + $detalle->CobroIndividual;
                            @endphp          
                        @endforeach                    
                
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold fs-6 text-white">
                            <th colspan="2"></th>
                            <th colspan="1" class="border-bottom table-dark p-1">{{$prorateo}}%</th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($cobroGC, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($fondo, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($totalGC, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($cobrosIndividuales, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($saldoAnterior, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($TotalMes, 0, '', '.') }}</span>
                                </div>
                            </th>
                        </tr>
                    </tfoot>
                </table>

            </div>      
        </div>
    </div>
   
    
</div>
<!--end::Content-->



@endsection

@push('Script')
    <script>
        const VerGastosComunes = "{{ route('VerGastosComunes') }}"
        const VerCobro2 = "{{ route('VerCobro2') }}";
        const VerDetalle = "{{ route('VerDetalle')}}";
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/gastocomun.js?id=1') }}"></script>
    <script src="{{ asset('js/eventos/gastocomun.js?id=3') }}"></script>    
@endpush




