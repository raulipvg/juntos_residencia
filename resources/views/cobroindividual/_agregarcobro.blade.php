<div id="agregar-cobro-ctrl" class="card card-flush shadow-sm"> 
    <div class="card-header min-h-40px px-3">
        <h3 class="card-title m-0 p-2 fs-3 fw-bold text-primary text-uppercase">Agregar Cobro a la Propiedad: {{$propiedad->Numero}}</h3>
        <div class="card-toolbar m-0">
            <a href="#" class="btn btn-icon btn-sm btn-active-color-primary" data-kt-card-action="remove" data-kt-card-confirm="false">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span>
                    <span class="cerrar-gasto path2"></span>
                </i>
            </a>
        </div>
    </div>
    <div class="card-body">
    <form id="Formulario-nuevocobro" action="" method="post">
            <div class="row">
                <div class="col-12 fv-row">
                    <label for="TipoCobroInput" class="form-label">Tipo de Cobro</label>
                    <select id="TipoCobroInput" name="TipoCobroId" class="form-select select-1" data-control="select2" data-placeholder="Seleccione Tipo de Cobro" data-hide-search="false">
                        <option></option>
                        @foreach($tipoCobros as $tipo)
                            <option value="{{ $tipo->Id }}">{{ ucwords($tipo->Nombre) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fv-row">
                    <label for="NombreInput" class="form-label">Nombre</label>
                    <input type="text" class="form-control" placeholder="Ingrese el nombre" id="NombreInput" name="Nombre" />
                </div>
            </div>
            <div class="row">
                <div class="col-12 fv-row">
                    <label for="DetalleInput" class="form-label">Detalle</label>
                    <input type="text" class="form-control" placeholder="Ingrese el detalle" id="DetalleInput" name="Descripcion" />
                </div>
            </div>
            <div class="row">
                <div class="col-12 fv-row">
                    <label for="PrecioInput" class="form-label">Monto Total</label>
                    <input type="number" class="form-control" placeholder="Ingrese el monto gastado" id="PrecioInput" name="MontoTotal" />
                </div>
                    <input hidden type="number" class="form-control"  id="PropiedadIdInput" name="PropiedadId" value="{{$propiedad->Id}}" />

                <div class="col-12 d-flex align-items-end justify-content-end mt-2">
                        <button id="AgregarCobro" name="AgregarGasto" type="button" class="btn btn-sm btn-primary" style="height: 42.56px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar Gasto">
                            AGREGAR COBRO  <i class="ki-outline ki-plus fs-2"></i>
                        </button>
                </div>
            
            </div>
        </form>
    </div>
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <script id="prueba" src="{{ asset('js/eventos/agregarcobroindividual.js?id=9') }}"></script>   

</div>