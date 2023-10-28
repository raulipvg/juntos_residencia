@extends('layout.main')
@section('main-content')

{{-- obtener la fecha actualizada --}}
@php
$today = date('Y-m-d');
@endphp

@push('css')
<link href='{{ asset('css/datatables/datatables.bundle.css?id=2') }}' rel='stylesheet' type="text/css"/>
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
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Residentes
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-semibold my-1 ms-1">#XRS-45670</small>
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap">
            <!--begin::Wrapper-->
            <div class="flex-shrink-0 me-2">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-color-muted btn-active-color-primary btn-active-light active fw-semibold fs-7 px-4 me-1" data-bs-toggle="tab" href="#">Day</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-color-muted btn-active-color-primary btn-active-light fw-semibold fs-7 px-4 me-1" data-bs-toggle="tab" href="">Week</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-color-muted btn-active-color-primary btn-active-light fw-semibold fs-7 px-4" data-bs-toggle="tab" href="#">Year</a>
                    </li>
                </ul>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Action group-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">
    
    <div class="card mx-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3 class="card-title text-uppercase">Residentes</h3>
                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            <table id="tabla-residente" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead>
                        <tr class="fw-bolder text-uppercase">
                            <th scope="col">#</th>
                            <th scope="col">RUT</th>
                            <th scope="col">Nombre Completo</th>
                            <th scope="col">Estado</th>
                            <th class="text-center" scope="col">Acción</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($Personas as $persona)  
                            <tr class="center-2">
                                <td>{{ $persona->Id }}</td>
                                <td>{{ $persona->RUT }}</td>
                                <td>{{ $persona->Nombre }} {{ $persona->Apellido }}</td>
                                @if ($persona->Enabled == 1 )
                                    <td data-search="Enabled">
                                        <span class="badge badge-light-success fs-7 text-uppercase estado justify-content-center">Habilitado </span>
                                    </td>
                                @else
                                    <td data-search="Disabled">
                                        <span class="badge badge-light-warning fs-7 text-uppercase estado justify-content-center">Deshabilitado </span>
                                    </td>
                                @endif
                                <td  class="text-center p-0">
                                <div class="btn-group btn-group-sm" role="group">
                                            <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $persona->Id }}">Ver</a>
                                            <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $persona->Id }}">Editar</a>
                                            <a class="ver-hojavida btn btn-success" data-bs-toggle="modal" data-bs-target="#espaciocomun" info="{{ $persona->Id }}">Hoja de Vida</a>
                                        </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-docs-datatable-subtable="expand_row" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Propiedades">
                                        <i class="ki-duotone ki-plus fs-3 m-0 toggle-off"></i>
                                        <i class="ki-duotone ki-minus fs-3 m-0 toggle-on"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
            </table>
        </div>
    </div>

</div>
<!--end::Content-->

<!--begin::modal-->
<div class="modal fade" tabindex="-1" id="registrar" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Registrar Residente</h2>
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
            <form id="Formulario1" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese el nombre" id="NombreInput" name="Nombre" />
                                <label for="NombreInput" class="form-label">Nombre</label>
                            </div>
                            <input hidden type="number" id="IdInput" name="Id" />
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese el apellido" id="ApellidoInput" name="Apellido" />
                                <label for="ApellidoInput" class="form-label">Apellido</label>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese el rut" id="RutInput" name="RUT" />
                                <label for="RutInput" class="form-label">RUT</label>
                            </div>
                        </div> 
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="SexoIdInput" name="Sexo" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">FEMENINO</option>
                                    <option value="2">MASCULINO</option>
                                </select>
                                <label for="SexoIdInput" class="form-label">Sexo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="NacionalidadInput" name="NacionalidadId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true" >
                                    <option></option>
                                    @foreach($Nacionalidades as $nacionalidad)
                                        <option value="{{ $nacionalidad->Id }}">{{ $nacionalidad->Nombre }}</option>
                                    @endforeach          
                                </select>
                                <label for="NacionalidadIdInput" class="form-label">Nacionalidad</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese el teléfono" id="TelefonoInput" name="Telefono" />
                                <label for="TelefonoInput" class="form-label">Teléfono</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <input type="email" class="form-control" placeholder="Ingrese el correo" id="CorreoInput" name="Email" />
                                <label for="EmailInput" class="form-label">Correo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EnabledInput3" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Habilitado</option>
                                    <option value="2">Deshabilitado</option>                                   
                                </select>
                                <label for="EnabledInput" class="form-label">Estado</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmit" type="submit" class="btn btn-success">
                        <div class="indicator-label">Registrar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                    <button id="EditSubmit" type="submit" class="btn btn-success">
                        <div class="indicator-label">Actualizar</div>
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

<!--begin::modal-->
<div class="modal modal-z fade  modal-xl" tabindex="-1" id="espaciocomun" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear-espacio">
            <div class="modal-header bg-light p-2 ps-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 id="modal-titulo-acceso" class="modal-title text-uppercase">Hoja de Vida - Comunidad 1</h2>
                    <button id="AddBtn-Acceso" type="button" class="btn btn-sm btn-success ms-5 abrir-modal" data-bs-stacked-modal="#editar-espacio">
                        Registrar
                    </button>
                </div>
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
            <div class="modal-body">
                <table id="tabla-espacios" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead>
                        <tr class="fw-bolder text-uppercase">
                            <th scope="col">#</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Estado</th>
                            <th class="text-center" scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-light p-2">
                <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!--end::modal-->

<!--begin::modal-->
<div class="modal modal-xl modal-custom fade" tabindex="-1" id="editar-espacio" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear-espacio-registrar">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo-acceso-registrar" class="modal-title text-uppercase">Registrar Hoja de Vida</h2>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-secondary ms-2 cerrar-modal" data-bs-dismiss="modal" aria-label="Close">
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
            <form id="Formulario-HojaVida" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError2" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese el titulo" id="NombreInput2" name="Titulo" />
                                <label for="NombreInput2" class="form-label">Titulo</label>
                                <input hidden type="number" id="IdInput-espacio" name="Id" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Ingrese la descripción" id="DescripcionInput" name="Descripcion" />
                                <label for="DescripcionInput" class="form-label">Descripcion</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="date" class="form-control" placeholder="Ingrese la fecha" id="GarantiaInput" name="Fecha" />
                                <label for="GarantiaInput" class="form-label">Fecha</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EnabledInput2" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true" data-dropdown-parent="#editar-espacio">
                                    <option></option>
                                    <option value="1">Habilitado</option>
                                    <option value="2">Deshabilitado</option>
                                </select>
                                <label for="TipoComunidadIdInput" class="form-label">Estado</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark cerrar-modal" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmit-espacio" type="submit" class="btn btn-success">
                        <div class="indicator-label">Registrar</div>
                        <div class="indicator-progress">Espere...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </div>
                    </button>
                    <button id="EditSubmit-espacio" type="submit" class="btn btn-success">
                        <div class="indicator-label">Actualizar</div>
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


<!--begin::modal-->
<div class="modal fade" tabindex="-1" id="registrar-compone" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Registrar Propiedad de Usuario</h2>

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
            <form id="Formulario-Compone" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError2" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <select id="ComunidadIdInput" name="ComunidadId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    @foreach($Comunidades as $comunidad)
                                    <option value="{{ $comunidad->Id }}">{{ $comunidad->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="ComunidadIdInput" class="form-label">Comunidad</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <select id="PropiedadIdInput" name="PropiedadId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    @foreach($Propiedades as $propiedad)
                                    <option value="{{ $propiedad->Id }}">{{ $propiedad->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="PropiedadInput" class="form-label">Propiedad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="RolIdInput" name="RolId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    @foreach($RolesComponenCoRe as $rol)
                                    <option value="{{ $rol->Id }}">{{ $rol->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="RolIdInput" class="form-label">Rol</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="date" class="form-control" placeholder="Ingrese la fecha de inicio" value="{{ now()->format('Y-m-d') }}" id="FechaInicioInput" name="FechaInicio" max="" />
                                <label for="FechaInicioInput" class="form-label">Fecha Inicio</label>
                        
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="date" class="form-control" placeholder="Ingrese la fecha final" value="{{ now()->format('Y-m-d') }}" id="FechaInicioInput" name="FechaFin" max="" />
                                <label for="FechaFinInput" class="form-label">Fecha Fin</label>
                            
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EnabledInput" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Habilitado</option>
                                    <option value="2">Deshabilitado</option>
                                </select>
                                <label for="EnabledInput" class="form-label">Estado</label>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmit-acceso" type="submit" class="btn btn-success">
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


@endsection

@push('Script')
    <script>
        const GuardarPersona = "{{ route('GuardarPersona') }}";
        const VerPersona = "{{ route('VerPersona') }}";
        const EditarPersona = "{{ route('EditarPersona') }}";

        const HojaVida = "{{ route('HojaVida') }}";
        const GuardarHojaVida= "{{ route('GuardarHojaVida') }}";
        const VerHojaVida= "{{ route('VerHojaVida') }}";
        const EditarHojaVida= "{{ route('EditarHojaVida') }}";

        const VerCompone = "{{ route('VerCompone') }}"
        
        //const VerPropiedades = "{{ route('Propiedad') }}";
        
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    </script>
    <!-- Datatables y Configuracion de la Tabla -->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/compone.js') }}"></script>
    <script src="{{ asset('js/datatables/contenido/hojavida.js?id=2') }}"></script>
    <!--- Eventos de la pagina -->
    <script src="{{ asset('js/eventos/persona.js?id=3') }}"></script>
    <script src="{{ asset('js/eventos/hojavida.js?id=2') }}"></script>
	<!--end::Javascript-->
    
@endpush