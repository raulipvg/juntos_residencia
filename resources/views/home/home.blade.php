@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
<style>
.curved-border-izquierdo {
    border-bottom-left-radius: 20px; /* Curvatura del borde inferior izquierdo */
}
.curved-border-derecho {
    border-bottom-right-radius: 20px; /* Curvatura del borde inferior izquierdo */
}   
.curved-border-top-l {
    border-top-left-radius: 20px!important;
}
.curved-border-top-r {
    border-top-right-radius: 20px !important;
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
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Home
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                </h1>
                <!--end::Title-->
                <div class="w-md-125px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                    <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                        @foreach ($gastosmeses as $gastomes )
                        @if($gastomes->EstadoId==2)
                            <option data-info="{{$gastomes->EstadoId }}" value="{{ $gastomes->Id }}" @if ( $gastomes->Id == $gasto ) selected @endif >{{ $gastomes->Fecha->format('m-Y') }} </option>
                        @endif
                        @endforeach
                    </select>
                </div>
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
    <div class="row m-3">
        <div class="col-xl-2 col-md-3 col-6 mb-2">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-100" style="background-color: #404040;">
            <div class="card-header pt-2 px-5">
                <div class="card-title d-flex flex-column m-0 flex-grow-1 align-self-center">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{$propiedadesActivas}}</span>
                    <span class="text-white opacity-75 fw-semibold fs-6">Propiedades Activas</span>
                </div>
            </div>
            <div class="card-body d-flex align-items-end px-5 pt-0 pb-1">
                <div class="d-flex flex-column content-justify-center flex-row-fluid">
					<div class="d-flex fw-semibold align-items-center">
                        <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                        <div class="text-gray-100 flex-grow-1">Propietarios</div>
                        <div class="fw-bolder text-gray-100 text-xxl-end">{{$propietarios}}</div>
                    </div>
                    <div class="d-flex fw-semibold align-items-center my-3">
                        <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                        <div class="text-gray-100 flex-grow-1">Arrendatarios</div>
                        <div class="fw-bolder text-gray-100 text-xxl-end">{{$arrendatarios}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="col-xl-2 col-md-3 col-6 mb-2">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-100" style="background-color:#50cd89;">
                <div class="card-header pt-2 px-5">
                    <div class="card-title d-flex flex-column m-0 flex-grow-1 align-self-center">
                        <div class="d-flex flex-grow-1 justify-content-between w-100">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Ingresos</span>
                            <i class="ki-duotone ki-arrow-up text-white fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <span class="text-white opacity-75 fw-semibold fs-6">{{ ucwords($fecha->Fecha->formatLocalized('%B')) }}</span>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center flex-column px-5 pt-0 pb-1">
                    <div class="d-flex">
                       <span class="fw-semibold text-gray-100" style="font-size: 2.2vw;">${{number_format($ingresos, 0, '', '.') }}</span>
                    </div>
                </div>
			</div>
        </div>

        <div class="col-xl-2 col-md-3 col-6 mb-2">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-100" style="background-color: #ef6385;">
                <div class="card-header pt-2 px-5">
                    <div class="card-title d-flex flex-column m-0 flex-grow-1 align-self-center">
                        <div class="d-flex flex-grow-1 justify-content-between w-100">
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Egresos</span>
                            <i class="ki-duotone ki-arrow-down text-white fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <span class="text-white opacity-75 fw-semibold fs-6">{{ ucwords($fecha->Fecha->formatLocalized('%B')) }}</span>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center flex-column px-5 pt-0 pb-1">
                    <div class="d-flex">
                        <span class="fw-semibold text-gray-100" style="font-size: 2.2vw;">${{number_format($egresos, 0, '', '.') }}</span>
                    </div>
                </div>
			</div>
        </div>
        <div class="col-xl-2 col-md-3 col-6 mb-2">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-100" style="background-color: #6a6a6a8a;">
                <div class="card-header pt-2 px-5">
                    <div class="card-title d-flex flex-column m-0 flex-grow-1 align-self-center">
                        <div class="d-flex flex-grow-1 justify-content-between w-100">
                            <span class="fs-1 fw-bold text-white me-2 lh-1 ls-n2">Fondo Reserva</span>
                            <i class="ki-duotone ki-save-deposit text-white fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </div>
                        <span class="text-white opacity-75 fw-semibold fs-6">{{ ucwords($fecha->Fecha->formatLocalized('%B')) }}</span>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center flex-column px-5 pt-0 pb-1">
                    <div class="d-flex">
                        <span class="fw-semibold text-gray-100" style="font-size: 2.2vw;">$4.000.000</span>
                    </div>
                </div>
			</div>
        </div>

        <div class="col-xl-2 col-md-3 col-6 mb-2">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-100" style="background-color: #404040;">
                <div class="card-header pt-2 px-5">
                    <div class="card-title d-flex flex-column m-0 flex-grow-1 align-self-center">
                        <span class="fs-1 fw-bold text-white me-2 lh-1 ls-n2">Propiedades Ocupadas</span>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end pt-0 px-5">
                    <div class="d-flex align-items-center flex-column w-100">
                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                            <span>75% Ocupacion</span>
                            <span>40/90</span>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-3">
        <div class="col-md-4 col-12 mb-2">
            <div class="card">
                <div class="card-header pt-2 px-5 min-h-40px">
                    <h3 class="card-title align-items-start flex-row justify-content-between w-100">
                        <span class="card-label fw-bold text-dark">Gastos por Tipo</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ ucwords($fecha->Fecha->formatLocalized('%B')) }}</span>
                    </h3>
                </div>
                <div class="card-body py-3">
                    <canvas id="gastos-tipo" class="mh-400px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12 mb-2">
            <div class="card">
                <div class="card-header pt-2 px-5 min-h-40px">
                    <h3 class="card-title align-items-start flex-row justify-content-between w-100">
                        <span class="card-label fw-bold text-dark">Cobranzas del Mes</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ ucwords($fecha->Fecha->formatLocalized('%B')) }}</span>
                    </h3>
                </div>
                <div class="card-body py-3">
                    <canvas id="grafico-cobranza" class="mh-400px"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12 mb-2">
            <div class="card h-100">
                <div class="card-header pt-2 px-5 min-h-40px">
                    <h3 class="card-title align-items-start flex-row justify-content-between w-100">
                        <span class="card-label fw-bold text-dark">Ranking Morosidad</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ ucwords($fecha->Fecha->formatLocalized('%B')) }}</span>
                    </h3>
                </div>
                <div class="card-body py-2">
                    <table id="tabla-morosidad" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                        <thead>
                            <tr class="fw-bolder text-uppercase table-dark text-white">
                                <th class="curved-border-top-l" scope="col">Nombre</th>
                                <th scope="col">Propiedad</th>
                                <th class="curved-border-top-r" scope="col">Monto</th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr>
                            <td>23432</td>
                            <td class="text-capitalize fw-bold">202-A</td>
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-start">$</span>
                                    <span class="text-end">190.938</span>
                                </div>
                            </td>                                 
                        </tr>
                        <tr>
                            <td>23432</td>
                            <td class="text-capitalize fw-bold">203-A</td>
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-start">$</span>
                                    <span class="text-end">190.938</span>
                                </div>
                            </td>                                 
                        </tr>
                        <tr>
                            <td>23432</td>
                            <td class="text-capitalize fw-bold ">101-A</td>
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-start">$</span>
                                    <span class="text-end">190.938</span>
                                </div>
                            </td>                                 
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold fs-6 text-white">
                            <td></td>
                            <td class="text-end table-dark curved-border-izquierdo">Total Morosidad</td>
                            <td class="table-dark curved-border-derecho">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">143.563</span>
                                    </div>
                            </td>                                 
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>



    </div>

    <div class="row m-3">
        <div class="col-md-6 col-12 mb-2">
            <div class="card">
                <div class="card-header pt-2 px-5 min-h-40px">
                    <h3 class="card-title align-items-start flex-row justify-content-between w-100">
                        <span class="card-label fw-bold text-dark">Evolución Anual Ingresos y Egresos</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">{{ ucwords($fecha->Fecha->formatLocalized('%B')) }}</span>
                    </h3>
                </div>
                <div class="card-body py-3">
                    <canvas id="grafico-ingresos-egresos" class="mh-400px"></canvas>
                </div>
            </div>

        </div>
    </div>
    
</div>
<!--end::Content-->


@endsection

@push('Script')
    <script>
        const Home = '{{ route("Home") }}'
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    </script>
    <!-- Datatables y Configuracion de la Tabla -->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/home.js?id=2') }}"></script>
    <!--- Eventos de la pagina -->
    
    <script>
            
        const dataGastosTipo = @json($egresosTipoGasto);
        const dataCobranzaMes = @json($cobranzaMes);
    
        
    </script>
    <script src="{{ asset('js/eventos/home.js?id=1') }}"></script>
@endpush