<div id="cobro-ctrl" class="card card-flush shadow-sm">
    <div class="card-header min-h-40px px-3">
        <h3 class="card-title m-0 ps-2 fs-3 fw-bold text-primary text-uppercase">Ver Reservas de la Propiedad: {{$propiedad->Numero}}</h3>
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
                        <th scope="col">Espacio Común</th>
                        <th scope="col">Fecha de reserva</th>
                        <th scope="col">Monto Total</th>
                        <th scope="col">Estado</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                    <tr class="center-2">
                        <td class="text-capitalize">{{ $reserva->EspacioComun }}</td>
                        <td>{{ $reserva->FechaUso->format('d-m-Y') }}</td>
                        <td>$ {{ number_format($reserva->Total, 0, '', '.')  }}</td>
                        <td class="text-capitalize">{{ $reserva->Estado }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/cobroindividual.js?id=1') }}"></script>    
</div>