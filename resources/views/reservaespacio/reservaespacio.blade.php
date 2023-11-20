@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
<style>
.col-md-6.mb-3.order-md-last {
  align-self: flex-start;
}
.btn-plus{
    top: 4px;
    left: 77px;
    z-index: 50;
}
.btn-group-sm>.btn.btn-icon, .btn.btn-icon.btn-sm {
    height: calc(1em + 1.1rem + 2px)!important;
    width: calc(1em + 1.1rem + 2px)!important;
}
@media  ( min-width: 2371px) {
  .top-xl {
    position: relative;
    top: -305px;
  }
}
@media  ( min-width: 768px) and (max-width:2370px) {
  .top-md {
    position: relative;
    top: -75px;
  }
}
</style>
@endpush

<!--begin::Toolbar-->
<div class="toolbar py-2" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
        <!--begin::Page title-->
        <div class="flex-grow-1 d-flex flex-row flex-shrink-0 me-5">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Reservar Espacio Común
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <div class="w-md-125px me-2" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                    @foreach ($gastosmeses as $gastomes )
                        <option data-info="{{$gastomes->EstadoId }}" value="{{ $gastomes->Id }}" @if ( $gastomes->Id == $gasto->Id ) selected @endif >{{ $gastomes->Fecha->format('m-Y') }} </option>
                    @endforeach
                </select>
            </div>
            <div id="Solicitudes">
                <button id="VerSolicitudes" name="VerSolicitudes" type="button" class="btn btn-sm btn-primary ps-2 pe-1" style="height: 42.56px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver solicitudes">
                    VER SOLICITUDES  <i class="ki-outline ki-eye fs-2"></i>
                </button>
            </div>
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
            <div class="col-md-8 col-12  mb-3">
                <div id="propiedades-ctrl" class="card">
                
                    <div class="card-body card-scroll p-2" style="max-height: 290px;">
                        <ul class="nav nav-pills d-flex justify-content-between nav-pills-custom gap-3" role="tablist">
                            
                            @foreach ($propiedades as $propiedad )
                            <!--begin::Item-->
                            <li class="nav-item position-relative me-0" role="presentation">
                                <button type="button" class="btn-plus btn btn-sm agregar-reserva btn-icon  btn-color-danger btn-active-light btn-active-color-primary position-absolute">
									<i class="ki-outline ki-plus-square fs-2"></i>
								</button>
                                <!--begin::Nav link-->
                                <div data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="bottom" title="Ver Cobros" >
                                    <a class="nav-link nav-link-border-solid ver-reserva btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack p-1 page-bg"
                                        data-info="{{$propiedad->Id}}" data-bs-toggle="pill" href="#kt_pos_food_content_1" style="width: 110px;height: 132px" aria-selected="true" role="tab">
                                        <!--begin::Icon-->
                                        <div class="nav-icon">
                                            <i class="ki-duotone ki-home pt-6 pt-md-1 fs-4x"></i>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Info-->
                                        <div class="">
                                            <span class="text-gray-800 fw-bold fs-4 d-block text-uppercase">{{$propiedad->Numero}}</span>
                                            <span class="text-gray-400 fw-semibold fs-7 text-capitalize">{{$propiedad->Nombre}} {{$propiedad->Apellido}}</span>
                                        </div>
                                        <!--end::Info-->
                                    </a>
                                    <!--end::Nav link-->
                                </div>
                            </li>
                            <!--end::Item-->
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div id="contenedor-2" class="col-md-4 col-12 mb-3">
                                     
            </div>

            <div id="contenedor-3" class="col-md-8 col-12 mb-3 order-md-last">
                
            </div>
        </div>
    </div>
    
</div>
<!--end::Content-->

<!--begin::Modal pago -->
<div class="modal fade" tabindex="-1" id="modal-ver-solicitudes" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20 modal-lg">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Solicitudes Espacios Comunes</h2>

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
                    <div id=tabla-solicitudes>

                    </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!--end::modal-->


@endsection

@push('Script')
    <script>
        const ReservaEspacio = "{{ route('ReservaEspacio') }}"
        const VerReserva = "{{ route('VerReserva') }}"; 
        const AgregarReserva = "{{ route('AgregarReserva') }}";
        const GuardarReserva = "{{ route('GuardarReserva') }}";
        const VerSolicitudes = "{{ route('VerSolicitudes') }}";
        const CambiarEstado = "{{ route('CambiarEstado') }}"

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <script src="{{ asset('js/eventos/reservaespacio.js') }}"></script>     
    
@endpush