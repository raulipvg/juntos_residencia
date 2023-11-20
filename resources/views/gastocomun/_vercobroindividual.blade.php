
        <div class="d-flex justify-content-center">
            <div class="card card card-flush shadow-sm hover-elevate-up shadow-sm parent-hover" style=" width: 70%;">
                <div class="card-header min-h-40px px-3">
                    <h3 class="card-title m-0 ps-2 fs-3 fw-bold text-primary text-uppercase"></h3>
                    <div class="card-toolbar m-0">
                        <a href="#" class="btn btn-icon btn-sm btn-active-color-primary" data-kt-card-action="remove" data-kt-card-confirm="false">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span>
                                <span class="cerrar-cobro path2"></span>
                            </i>
                        </a>
                    </div>
                </div>
                
                    <table id="services_table" class="table table-row-dashed mb-0">
                        <thead class="services-info">
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="p-0 ps-3">Tipo Cobro</th>
                                <th class="p-0 ps-3">Nombre</th>
                                <th class="p-0 ps-3">Descripcion</th>
                                <th class="p-0 ps-3">Monto Total</th>
                                <th class="p-0 ps-3">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            @foreach($cobros as $cobro)
                                <tr>
                                    <th class="text-gray-700 text-capitalize">{{ $cobro->TipoCobro }}</th>
                                    <td class="text-capitalize">{{ $cobro->Nombre }}</td>
                                    <td>{{ $cobro->Descripcion }}</td>
                                    <td>{{ number_format($cobro->MontoTotal, 0, '', '.')  }}</td>
                                    <td>{{ $cobro->Fecha->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach

                            @foreach ($reservas as $reserva)
                                <tr>
                                    <th class="text-gray-700 text-capitalize">Reserva de Espacio</th>
                                    <td class="text-capitalize">{{ $reserva->Nombre }}</td>
                                    <td>{{ $reserva->Descripcion }}</td>
                                    <td>{{ number_format($reserva->Total, 0, '', '.')  }}</td>
                                    <td>{{ $reserva->FechaUso->format('d-m-Y') }}</td>
                                </tr>                                
                            @endforeach
                            
                        </tbody>
                    </table>
                
        </div>
        <script>
             $("#tabla-gasto-comun tbody").on("click",'.cerrar-cobro', function (e) {
                e.preventDefault();
                let tr = e.target.closest('tr');
                //let row = miTabla.row(tr);
                $(tr).remove();
            });
        </script>



