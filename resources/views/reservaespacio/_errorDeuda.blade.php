<div id="agregar-cobro-ctrl" class="card card-flush shadow-sm">
    <div class="card-header min-h-40px px-3">
        <h3 class="card-title m-0 p-2 fs-3 fw-bold text-primary text-uppercase">ERROR: {{ $propiedad->Numero }}</h3>
            <div class="card-toolbar m-0">
                <a id="cerrar-cobro-2" href="#" class="btn btn-icon btn-sm btn-active-color-primary" data-kt-card-action="remove" data-kt-card-confirm="false">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span>
                        <span class="cerrar-gasto-1 path2"></span>
                    </i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <p> {{ $message }}</p>
        </div>
    </div>
</div>