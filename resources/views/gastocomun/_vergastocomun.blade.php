                <table id="tabla-gasto-comun" class="table table-hover rounded gy-2 gs-md-3 nowrap">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 px-7">
                            <th rowspan="2" colspan="3"  class="align-middle border-bottom ps-0">
                                
                            </th>
                            <th id="titulo" rowspan="1" colspan="6" class="text-center text-uppercase fs-3 table-dark text-white rounded-top-1">{{ $gasto->Fecha->formatLocalized('%B %Y') }}</th>
                        </tr>
                        <tr class="fw-bold fs-6 text-gray-800 px-7"> 
                            <th rowspan="1" colspan="1" class="border-bottom table-dark text-white p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($gasto->TotalMes, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th rowspan="1" colspan="1" class="border-bottom table-dark text-white p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($gasto->FondoReserva, 0, '', '.') }}</span>
                                </div> 
                            </th>
                            <th rowspan="1" colspan="1" class="border-bottom table-dark text-white p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($gasto->Total, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th rowspan="1" colspan="1" class="border-bottom text-center fw-bolder table-dark p-1"></th>
                            <th rowspan="1" colspan="2" class="border-bottom text-end table-dark text-white p-1">Fecha Apertura: {{ $gasto->Fecha->format('d-m-Y')}}</th>
                        </tr>
                        <tr class="fw-bolder text-uppercase fw-bolder text-gray-700">
                            <th class="table-active fs-5 p-1" scope="col">Nombre</th>
                            <th scope="col p-1">Propiedad</th>
                            <th scope="col p-1">%</th>
                            <th scope="col" class="text-end p-1">Cobro GC</th>
                            <th scope="col" class="text-end p-1">Fondo de Reserva</th>
                            <th class="table-active fs-5 text-end p-1" scope="col">Total GC</th>
                            <th scope="col" class="text-end p-1">Cobro Individual</th>
                            <th scope="col" class="text-end p-1">Saldo Anterior</th>
                            <th class="table-active fs-5 text-end p-1" scope="col">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $prorateo =0;
                            $cobroGC=0;
                            $fondo=0;
                            $totalGC=0;
                            $saldoAnterior=0;
                            $TotalMes=0;
                            $cobrosIndividuales=0
                        @endphp
                        @foreach ( $gastoscomunes as $detalle )
                            <tr data-info = "{{$detalle->Id }}">
                                <td class="text-capitalize fw-bold table-active p-1">{{ $detalle->Nombre }} {{ $detalle->Apellido }}</td>
                                <td class="text-capitalize fw-bold  p-1 ver-detalle">{{ $detalle->Numero }}</td>
                                <td class="p-1">{{ $detalle->Prorrateo }}%</td>
                                <td class="p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->CobroGC, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->FondoReserva, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="table-active fs-5 p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->TotalGC, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="p-1 ver-cobro-invididual" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Ver Detalle del Cobro">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->CobroIndividual, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->SaldoMesAnterior, 0, '', '.') }}</span>
                                    </div>
                                </td>
                                <td class="table-active fs-5 p-1">
                                    <div class="d-flex justify-content-between align-items-center ps-md-7">
                                        <span class="text-start">$</span>
                                        <span class="text-end">{{ number_format($detalle->TotalCobroMes, 0, '', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $prorateo = $prorateo+$detalle->Prorrateo;
                                $cobroGC = $cobroGC +$detalle->CobroGC;
                                $fondo = $fondo + $detalle->FondoReserva;
                                $totalGC = $totalGC+ $detalle->TotalGC;
                                $saldoAnterior= $saldoAnterior+ $detalle->SaldoMesAnterior;
                                $TotalMes = $TotalMes+$detalle->TotalCobroMes;
                                $cobrosIndividuales = $cobrosIndividuales + $detalle->CobroIndividual;
                            @endphp          
                        @endforeach                    
                
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold fs-6 text-white">
                            <th colspan="2"></th>
                            <th colspan="1" class="border-bottom table-dark p-1">{{$prorateo}}%</th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($cobroGC, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($fondo, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($totalGC, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($cobrosIndividuales, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($saldoAnterior, 0, '', '.') }}</span>
                                </div>
                            </th>
                            <th colspan="1" class="border-bottom table-dark p-1">
                                <div class="d-flex justify-content-between align-items-center ps-md-7">
                                    <span class="text-start">$</span>
                                    <span class="text-end">{{ number_format($TotalMes, 0, '', '.') }}</span>
                                </div>
                            </th>
                        </tr>
                    </tfoot>
                </table>
                <script src="{{ asset('js/datatables/contenido/gastocomun.js?id=2') }}"></script>

                