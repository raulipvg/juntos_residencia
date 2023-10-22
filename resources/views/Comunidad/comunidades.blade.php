@extends('layout.main')
@section('main-content')

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
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Comunidades
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
                <h3 class="card-title text-uppercase">Comunidades</h3>

                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            <table id="tabla-comunidad" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead>
                        <tr class="fw-bolder text-uppercase">
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">RUT</th>
                            <th scope="col">Cantidad Propiedades</th>
                            <th scope="col">Fecha Registro</th>
                            <th scope="col">Enabled</th>
                            <th scope="col">Tipo Comunidad</th>
                            <th class="text-center" scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($Comunidades as $comunidad)  
                            <tr class="center-2">
                                <th>{{ $comunidad->Id }}</th>
                                <td>{{ $comunidad->Nombre }}</td>
                                <td>{{ $comunidad->RUT }}</td>
                                <td>{{ $comunidad->CantPropiedades }}</td>
                                <td>{{\Carbon\Carbon::parse($comunidad->FechaRegistro)->format('d-m-Y')}}</td>
                                @if ($comunidad->Enabled == 1 )
                                <td data-search="Enabled" >										
                                    <span class="badge badge-light-success fs-7 text-uppercase estado justify-content-center">Enabled</span>
                                </td>
                                @else
                                <td data-search="Disabled" >										
                                    <span class="badge badge-light-warning fs-7 text-uppercase estado justify-content-center">Disabled</span>
                                </td>
                                @endif
                                <td>{{ $comunidad->tipo_comunidad->Nombre }}</td>          
                                <td  class="text-center p-0">
                                <div class="btn-group btn-group-sm" role="group">
                                            <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $comunidad->Id }}">Ver</a>
                                            <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $comunidad->Id }}">Editar</a>
                                        </div>
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
<div class="modal fade" tabindex="-1" id="registrar"  data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
<div class="modal-dialog mt-20">
<div class="modal-content" id="div-bloquear">
<div class="modal-header bg-light p-2 ps-5">
<h2 id="modal-titulo" class="modal-title text-uppercase">Registrar Comunidad</h2>

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
            <input hidden type="number" id="IdInput" name="Id" />

        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="text" class="form-control"  placeholder="Ingrese el RUT" id="RUTInput" name="RUT" />
            <label for="RUTInput" class="form-label">RUT</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-2">
        <div class="form-floating fv-row">
            <input type="email" class="form-control" placeholder="Ingrese el correo" id="CorreoInput" name="Correo" />
            <label for="CorreoInput" class="form-label">Correo</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="number" class="form-control" placeholder="Ingrese el Numero Cuenta" id="NumeroCuentaInput" name="NumeroCuenta" />
            <label for="NumeroCuentaInput" class="form-label">Numero Cuenta</label>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="text" class="form-control" placeholder="Ingrese el Tipo cuenta" id="TipoCuentaInput" name="TipoCuenta" />
            <label for="TipoCuentaInput" class="form-label">Tipo Cuenta</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="text" class="form-control" placeholder="Ingrese el Banco" id="BancoInput" name="Banco" />
            <label for="BancoInput" class="form-label">Banco</label>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="number" class="form-control" placeholder="Ingrese la cantidad de propiedades" id="CantPropiedadesInput" name="CantPropiedades" />
            <label for="CantPropiedadesInput" class="form-label">Cantidad Propiedades</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="date" class="form-control" placeholder="Ingrese la fecha registro" value="{{ now()->format('Y-m-d') }}" id="FechaRegistroInput" name="FechaRegistro" max="" />
            <label for="FechaRegistroInput" class="form-label">Fecha Registro</label>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <select id="EnabledInput" name="Enabled" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                <option></option>
                    <option value="1">Enabled</option>
                    <option value="2">Disabled</option>
            </select>
            <label for="TipoComunidadIdInput" class="form-label">Estado</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <select id="TipoComunidadIdInput" name="TipoComunidadId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                <option></option>
                @foreach($TipoComunidad as $tipo)
                    <option value="{{ $tipo->Id }}">{{ $tipo->Nombre }}</option>
                @endforeach
            </select>
            <label for="TipoComunidadIdInput" class="form-label">Tipo Comunidad</label>
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

@endsection

@push('Script')
    <script>
        const GuardarComunidad = "{{ route('GuardarComunidad') }}";
        const VerComunidad = "{{ route('VerComunidad') }}";
        const EditarComunidad = "{{ route('EditarComunidad') }}";
        
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    </script>
    <!-- Datatables y Configuracion de la Tabla -->
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/comunidad.js?id=2') }}"></script>
    <!--- Eventos de la pagina -->
    <script src="{{ asset('js/eventos/comunidad.js?id=2') }}"></script>
	<!--end::Javascript-->
    
@endpush