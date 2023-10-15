@extends('layout.main')
@section('main-content')

<!--begin::Toolbar-->
<div class="toolbar py-2" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex align-items-center">
        <!--begin::Page title-->
        <div class="flex-grow-1 flex-shrink-0 me-5">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Usuarios
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
                <h3 class="card-title text-uppercase">Usuarios</h3>

                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            <table id="tabla-usuario" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead>
                        <tr class="fw-bolder text-uppercase">
                            <th scope="col">#</th>
                            <th scope="col">Nombre Completo</th>
                            <th scope="col">Username</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Estado</th>
                            <th class="text-center" scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @dd($usuarios)
                        @foreach ($usuarios as $usuario)  
                            <tr class="center-2">
                                <th>{{ $usuario->Id }}</th>
                                <td>{{ $usuario->Nombre }} {{ $usuario->Apellido }}</td>
                                <td>{{ $usuario->Username }}</td>
                                <td>{{ $usuario->Correo }}</td>
                                <td>{{ $usuario->RolId }}</td>
                                <td data-search="Enabled" >										
                                    <span class="badge badge-light-success fs-7 text-uppercase estado justify-content-center">{{ $usuario->EstadoId}}</span>
                                </td>
                                <td  class="text-center p-0">
                                <div class="btn-group btn-group-sm" role="group">
                                            <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Ver</a>
                                            <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="1">Editar</a>
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
<div class="modal fade" tabindex="-1" id="registrar">
<div class="modal-dialog mt-20">
<div class="modal-content" id="div-bloquear">
<div class="modal-header bg-light p-2 ps-5">
<h2 id="modal-titulo" class="modal-title text-uppercase">Registrar Usuario</h2>

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
<form id="Formulario1" action="{{ route('') }}" method="post">
<div class="modal-body">
<div id="AlertaError" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
</div>
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="text" class="form-control" placeholder="Ingrese el username" id="UsernameInput" name="Username" />
            <label for="UsernameInput" class="form-label">Username</label>
            <input hidden type="number" id="IdInput" name="Id" />

        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="password" class="form-control" autocomplete="off" placeholder="Ingrese la password" id="PasswordInput" name="Password" />
            <label for="PasswordInput" class="form-label">Password</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="text" class="form-control" placeholder="Ingrese el nombre" id="NombreInput" name="Nombre" />
            <label for="NombreInput" class="form-label">Nombre</label>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <input type="text" class="form-control" placeholder="Ingrese el apellido" id="ApellidoInput" name="Apellido" />
            <label for="ApellidoInput" class="form-label">Apellido</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-2">
        <div class="form-floating fv-row">
            <input type="email" class="form-control" placeholder="Ingrese el apellido" id="EmailInput" name="Email" />
            <label for="EmailInput" class="form-label">Email</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <select id="RolIdInput" name="Rol" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                <option></option>
                <option value="1">Administrador</option>
                <option value="2">Copropietario</option>
                <option value="3">Residente</option>
                <option value="4">Comite</option>
            </select>
            <label for="RolIdInput" class="form-label">Rol</label>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="form-floating fv-row">
            <select id="EstadoIdInput" name="Estado" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                <option></option>
                <option value="1">Enabled</option>
                <option value="2">Disabled</option>            
            </select>
            <label for="EstadoIdInput" class="form-label">Estado</label>
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