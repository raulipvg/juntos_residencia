<div id="cobro-ctrl" class="card card-flush shadow-sm">
    <div class="card-header min-h-40px px-3">
        <h3 class="card-title m-0 ps-2 fs-3 fw-bold text-primary text-uppercase">Ver Cobros de la Propiedad: {{$propiedad->Numero}}</h3>
        <div class="card-toolbar m-0">
            <a href="#" class="btn btn-icon btn-sm btn-active-color-primary" data-kt-card-action="remove" data-kt-card-confirm="false">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span>
                    <span class="cerrar-gasto path2"></span>
                </i>
            </a>
        </div>
    </div> 
    <div class="card-body py-2 px-4">
        <table id="tabla-cobro" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
                <thead>
                    <tr class="fw-bolder text-uppercase">
                        <th scope="col">Tipo Cobro</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">MontoTotal</th>                        
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cobros as $cobro)
                    <tr class="center-2">
                        <th class="text-capitalize">{{ $cobro->TipoCobro }}</th>
                        <td class="text-capitalize">{{ $cobro->Nombre }}</td>
                        <td>{{ $cobro->Descripcion }}</td>
                        <td>{{ number_format($cobro->MontoTotal, 0, '', '.')  }}</td>
                        <td>{{ $cobro->Fecha->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/cobroindividual.js?id=1') }}"></script>    
</div>