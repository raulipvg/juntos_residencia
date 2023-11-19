<div class="card-body">
    <table id="tabla-solicitudes" class="table table-row-dashed table-hover rounded gy-2 gs-md-3 nowrap">
        <thead class="fw-bolder text-uppercase">
            <th scope="col">#</th>
            <th scope="col">Propiedad</th>
            <th scope="col">Copropietario</th>
            <th scope="col">Espacio</th>
            <th scope="col">Fecha Reserva</th>
            <th scope="col">Acción</th>
        </thead>
        <tbody>
            @foreach($Solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->Id }}</td>
                <td class="text-uppercase">{{ $solicitud->propiedad }}</td>
                <td class="text-uppercase">{{ $solicitud->copNombre }} {{ $solicitud->copApellido }}</td>
                <td class="text-capitalize">{{ $solicitud->espacio }}</td>
                <td>{{ $solicitud->FechaUso->format('d-m-Y') }}</td>
                <td>
                    <div class="acciones" info="{{ $solicitud->Id }}">
                    @if( $solicitud->estado == 1)
                        <button type="button" class="btn btn-sm btn-success h-30px w-45px cambiarEstado" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Aprobar" state="{{ $solicitud->Id }}" ><i class="ki-outline ki-check fs-2"></i></button>
                        <button type="button" class="btn btn-sm btn-danger h-30px w-45px cambiarEstado" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Rechazar" state="{{ $solicitud->Id }}" >X<i class="ki-outline ki-close fs-2"></i></button>
                    @elseif( $solicitud->estado == 2 )
                        <span class="badge badge-success w-95px justify-content-center"> APROBADO </span>
                    @else
                        <span class="badge badge-danger w-95px justify-content-center"> RECHAZADO </span>
                    @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>