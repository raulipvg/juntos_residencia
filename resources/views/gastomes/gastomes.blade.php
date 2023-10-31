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
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Gastos Mensuales
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-semibold my-1 ms-1">
                    #XRS-45670
                </small>
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap" style="width: 200px;" >
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
    <div class="card mx-5 mb-2">
        <div class="card-body p-2">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <div class="w-md-200px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                    <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                        <option value="0" selected>10-2023</option>
                        <option value="1">09-2023</option>
                        <option value="2">08-2023</option>
                        <option value="3">07-2023</option>
                        <option value="4">06-2023</option>
                    </select>
                </div>
                <div class="col ms-2">
                    <button id="AccionMesInput" type="button" class="btn btn-sm btn-success h-40px abrir-mes">
                        ABRIR MES
                    </button>
                </div>
                <div class="col ms-2 text-end">
                    <button id="NuevoGasto" type="button" class="btn btn-sm btn-primary h-40px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Agregar Gasto">
                        GASTO<i class="ki-outline ki-plus fs-2"></i>
                    </button>
                </div>
                
            </div>          
        </div>
    </div>
    <div id="agregar-gasto" class="mx-5">

    </div>

    <div id="gasto-detalle" class="mx-5">
        <div class="card mb-2">
            <div class="card-body">
            <table id="tabla-gasto-detalle" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Username</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    
                    <tr class="center-2">
                        <th>1</th>
                        <td class="text-capitalize">2</td>
                        <td>3</td>
                        <td>3</td>
                        <td>4</td>
                        <td data-search="Enabled">
                            <button class="btn btn-sm btn-light-success estado-usuario fs-7 text-uppercase estado justify-content-center p-1 w-65px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Usuario">
                                <span class="indicator-label">Activo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                      
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Editar</a>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px"  data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Acceso">
                                <i class="ki-duotone ki-plus fs-3 m-0 toggle-off"></i>
                                <i class="ki-duotone ki-minus fs-3 m-0 toggle-on"></i>
                                <span class="indicator-label"></span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            </div>
        </div>
    </div>
    
</div>
<!--end::Content-->



@endsection

@push('Script')
    <script>  
        const VerMeses = "{{ route('VerMeses') }}"; 
        const CerrarMes = "{{ route('CerrarMes') }}";
        const AbrirMes = "{{ route('AbrirMes') }}";
        const NuevoGasto = "{{ route('NuevoGasto') }}";

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/gastodetalle.js?id=1') }}"></script>
    <script src="{{ asset('js/eventos/gastomes.js?id=2') }}"></script>    
@endpush




