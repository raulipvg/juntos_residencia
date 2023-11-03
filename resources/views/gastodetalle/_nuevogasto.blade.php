<div class="card card-flush hover-elevate-up shadow-sm parent-hover pb-2 mb-2">
    <div class="card-header min-h-40px px-3">
        <h3 class="card-title m-0 ps-2 fs-3 fw-bold text-primary text-uppercase">Agregar Gasto</h3>
        <div class="card-toolbar m-0">
            <a href="#" class="btn btn-icon btn-sm btn-active-color-primary" data-kt-card-action="remove" data-kt-card-confirm="false">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span>
                    <span class="cerrar-gasto path2"></span>
                </i>
            </a>
        </div>
    </div>
<<<<<<< Updated upstream
    <div class="card-body pt-0 pb-2 px-4">
        <form id="Formulario-nuevogasto">
=======
    <div class="card-body py-0 px-4 " id="div-bloquear">
        <form id="Formulario-nuevogasto" action="" method="post">
>>>>>>> Stashed changes
        <div class="row">
            <div class="col-md-3 col-12 fv-row">
                <label for="TipoGastoInput" class="form-label">Tipo de Gasto</label>
                <select id="TipoGastoInput" name="TipoGasto" class="form-select select-1" data-control="select2" data-placeholder="Seleccione Tipo de Gasto" data-hide-search="false">
                    <option></option>
                    @foreach($tipogastos as $tipo)
                        <option value="{{ $tipo->Id }}">{{ $tipo->Nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-12 fv-row">
                <label for="NombreInput" class="form-label">Nombre</label>
                <input type="text" class="form-control" placeholder="Ingrese la descripción" id="NombreInput" name="Nombre" />
            </div>
            <div class="col-md-3 col-12 fv-row">
                <label for="DescripcionInput" class="form-label">Detalle</label>
                <input type="text" class="form-control" placeholder="Ingrese el detalle" id="DescripcionInput" name="Descripcion" />
            </div>
            <div class="col-md-3 col-12 fv-row">
                <label for="ResponsableInput" class="form-label">Responsable</label>
                <input type="text" class="form-control" placeholder="Ingrese el responsable" id="ResponsableInput" name="Responsable" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-12 fv-row">
                <label for="TipoDocumentoInput" class="form-label">Tipo de Documento</label>
                <select id="TipoDocumentoInput" name="TipoDocumentoId" class="form-select select-1" data-control="select2" data-placeholder="Seleccione Documento" data-hide-search="true">
                    <option></option>
                    @foreach($tipodco as $tipo)
                        <option value="{{ $tipo->Id }}">{{ $tipo->Nombre }}</option>
                    @endforeach
                </select>    
            </div>
            <div class="col-md-3 col-12 fv-row">
                <label for="NroDocumentoInput" class="form-label">Nro Documento</label>
                <input type="text" class="form-control" placeholder="Ingrese el nro documento" id="NroDocumentoInput" name="NroDocumento" />
            </div>
            <div class="col-md-3 col-12 fv-row">
                <label for="PrecioInput" class="form-label">Monto</label>
                <input type="number" class="form-control" placeholder="Ingrese el monto gastado" id="PrecioInput" name="Precio" />
            </div>
            <div class="col-md-3 col-12 d-flex align-items-end justify-content-end mt-md-0 mt-2">
<<<<<<< Updated upstream
                     <button id="AgregarGasto" type="button" class="btn btn-sm btn-primary hover-rotate-end" style="height: 42.56px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar Gasto">
=======
                     <button id="AgregarGasto" name="AgregarGasto" type="button" class="btn btn-sm btn-primary" style="height: 42.56px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar Gasto">
>>>>>>> Stashed changes
                        AGREGAR GASTO  <i class="ki-outline ki-plus fs-2"></i>
                    </button>
            </div>
        
        </div>
<<<<<<< Updated upstream
</form>
    </div>
</div>

<script src="{{ asset('js/eventos/gastodetalle.js?id=6') }}"></script>   



=======
    </form>
    </div>
</div>

<script>
const GuardarGastoDetalle = "{{ route('GuardarGastoDetalle') }}";

var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>

<script src="{{ asset('js/eventos/gastodetalle.js?id=3') }}"></script>
>>>>>>> Stashed changes
