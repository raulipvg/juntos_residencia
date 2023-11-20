@extends('layout.main')
@section('main-content')

@push('css')
<link href='{{ asset('css/datatables/datatables.bundle.css?id=2') }}' rel='stylesheet' type="text/css" />
<style>
    .modal-custom {
        z-index: 1100 !important;
    }

    .swal-custom {
        z-index: 1110 !important;
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
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Propiedades
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
        <div class="d-flex align-items-center flex-wrap" style="width: 200px;" >
            <!--begin::Wrapper-->
            <select id="ComunidadInput1" name="Comunidad" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false">
                <option></option>
                @foreach($Comunidad as $comunidad)                          
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

    <div class="card mx-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3 class="card-title text-uppercase">Propiedades</h3>

                <button id="AddBtn" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#registrar">
                    Registrar
                </button>
            </div>
            <table id="tabla-propiedad" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">#</th>
                        <th scope="col">Comunidad</th>
                        <th scope="col">Nombre Propiedad</th>
                        <th scope="col">Prorrateo</th>
                        <th scope="col">Tipo de propiedad</th>
                        <th scope="col">Estado</th>
                        <th class="text-center" scope="col">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Propiedad as $propiedad)
                    <tr class="center-2">
                        <td>{{ $propiedad->Id }}</td>
                        <td class="text-capitalize">{{ $propiedad->comunidad->Nombre }}</td>
                        <td>{{ $propiedad->Numero }}</td>
                        <td>{{ $propiedad->Prorrateo }}</td>
                        <td class="text-capitalize">{{ $propiedad->tipo_propiedad->Nombre }}</td>
                        @if ($propiedad->Enabled == 1 )
                        <td data-search="Enabled">
                            <button class="btn btn-sm btn-light-success estado-propiedad fs-7 text-uppercase estado justify-content-center p-1 w-65px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Deshabilitar Propiedad">
                                <span class="indicator-label">Activo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        @else
                        <td data-search="Disabled">
                            <button class="btn btn-sm btn-light-warning estado-propiedad fs-7 text-uppercase estado justify-content-center p-1 w-65px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Habilitar Propiedad">
                                <span class="indicator-label">Inactivo</span>
                                <span class="indicator-progress">
                                    <span class="spinner-border spinner-border-sm align-middle"></span>
                                </span>
                            </button>
                        </td>
                        @endif
                        <td class="text-center p-0">
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="ver btn btn-success" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $propiedad->Id }}">Ver</a>
                                <a class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#registrar" info="{{ $propiedad->Id }}">Editar</a>
                                <a class="ver-residentes btn btn-success" data-bs-toggle="modal" data-bs-target="#residentes" info="{{ $propiedad->Id }}" >Residentes</a>
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
<div class="modal fade" tabindex="-1" id="registrar" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo" class="modal-title text-uppercase">Registrar Propiedad</h2>

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
                                <input type="text" class="form-control" placeholder="Ingrese el número de la comunidad" id="NumeroInput" name="Numero" />
                                <label for="NumeroInput" class="form-label">Nombre Propiedad</label>
                                <input hidden type="number" id="IdInput" name="Id" />

                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="ComunidadInput" name="Comunidad" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    @foreach($Comunidad as $comunidad)
                                    <option value="{{ $comunidad->Id }}">{{ $comunidad->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="ComunidadInput" class="form-label">Comunidad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <input type="text" class="form-control" placeholder="Descripción de la comunidad" id="DescripcionInput" name="Descripcion" />
                                <label for="DescripcionInput" class="form-label">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <input type="number" step="0.01" class="form-control" placeholder="Ingrese el prorrateo de la propiedad" id="ProrrateoInput" name="Prorrateo" />
                                <label for="ProrrateoInput" class="form-label">Prorrateo</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="TipoPropiedadIdInput" name="TipoPropiedadId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    @foreach($TipoPropiedad as $tipo)
                                    <option value="{{ $tipo->Id }}">{{ $tipo->Nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="TipoPropiedadIdInput" class="form-label">Tipo Propiedad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-floating fv-row">
                                <select id="EstadoInput" name="Estado" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true">
                                    <option></option>
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                                <label for="EstadoInput" class="form-label">Estado</label>
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
<div class="modal modal-z fade  modal-xl" tabindex="-1" id="residentes" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear-residente">
            <div class="modal-header bg-light p-2 ps-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 id="modal-titulo-residente" class="modal-title text-uppercase"> </h2>
                    <button id="AddBtn-Residente" type="button" class="btn btn-sm btn-success ms-5 abrir-modal" data-bs-stacked-modal="#editar-residente">
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
                            <th scope="col">RUT</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">ROL</th>
                            <th scope="col">Fecha Inicio</th>
                            <th scope="col">Fecha Fin</th>
                            <th class="text-center" scope="col">Estado</th>
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
<div class="modal modal-custom fade" tabindex="-1" id="editar-residente" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog mt-20">
        <div class="modal-content" id="div-bloquear-residente-editar">
            <div class="modal-header bg-light p-2 ps-5">
                <h2 id="modal-titulo-residente-registrar" class="modal-title text-uppercase">Registrar un Residente</h2>

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
            <form id="Formulario-Residente" action="" method="post">
                <div class="modal-body">
                    <div id="AlertaError2" class="alert alert-warning hidden validation-summary-valid" data-valmsg-summary="true">
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <select id="PersonaIdInput" name="PersonaId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false" data-dropdown-parent="#editar-residente">
                                    <option></option>
                                </select>
                                <label for="PersonaIdInput" class="form-label">Nombre</label>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-floating fv-row">
                                <select id="RolComponeCoReIdInput" name="RolComponeCoReId" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="true" data-dropdown-parent="#editar-residente">
                                    <option></option>
                                </select>
                                <label for="RolComponeCoReIdInput" class="form-label">Rol</label>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light p-2">
                    <button type="button" class="btn btn-light-dark cerrar-modal" data-bs-dismiss="modal">Cerrar</button>
                    <button id="AddSubmit-residente" type="submit" class="btn btn-success">
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
    const Index = "{{ route('Propiedad') }}"
    const GuardarPropiedad = "{{ route('GuardarPropiedad') }}";
    const VerPropiedad = "{{ route('VerPropiedad') }}";
    const EditarPropiedad = "{{ route('EditarPropiedad') }}";
    const CambiarEstado = "{{ route('CambiarEstadoPropiedad') }}";

    const VerPorPropiedad = "{{ route('VerPorPropiedad') }}";
    const VerPersonaDisponible = "{{ route('VerPersonaDisponible') }}";

    const GuardarCompone2 ="{{ route('GuardarCompone2') }}";
    const CambioEstadoCompone ="{{ route('CambioEstadoCompone') }}";

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<!-- Datatables y Configuracion de la Tabla -->
<script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
<script src="{{ asset('js/datatables/contenido/propiedad.js?id=2') }}"></script>
<script src="{{ asset('js/datatables/contenido/espaciocomun.js?id=2') }}"></script>

<!--- Eventos de la pagina -->
<script src="{{ asset('js/eventos/propiedad.js?id=2') }}"></script>
<!--end::Javascript-->

@endpush