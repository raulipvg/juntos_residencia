@extends('layout.main')
@section('main-content')

@push('css')
<link href='' rel='stylesheet' type="text/css"/>
<style>
.rounded-bottom-1 {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: 20px!important;
    border-bottom-right-radius: 20px!important;
}
.rounded-top-1{
    border-top-left-radius: 20px!important;
    border-top-right-radius: 20px !important;
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
                <h1 class="d-flex align-items-center text-dark fw-bold my-1 fs-3">Gastos Mensuales
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-semibold my-1 ms-1">
                    #XRS-45670
                </small>
                <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Page title-->
        <!--begin::Action group-->
        <div class="d-flex align-items-center flex-wrap" style="width: 200px;" >
            <!--begin::Wrapper-->
            <select id="ComunidadInput" name="Comunidad" class="form-select" data-control="select2" data-placeholder="Seleccione" data-hide-search="false">
                        <option></option>
                        @foreach($comunidades as $comunidad)
                        <option value="{{ $comunidad->Id }}">{{ $comunidad->Nombre }}</option>
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
    <div class="card mx-5 mb-2">
        <div class="card-body p-2">
            <div id="div-adm" class="d-flex flex-row justify-content-between align-items-center">
                <div class="w-md-200px" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Seleccionar Mes">
                    <select id="GastoMesIdInput" name="GastoMesId" class="form-select" data-control="select2" data-placeholder="Seleccione Mes" data-hide-search="false">
                        <option value="0">10-2023</option>
                        <option value="1">09-2023</option>
                        <option value="2">08-2023</option>
                        <option value="3">07-2023</option>
                        <option value="4">06-2023</option>
                    </select>
                </div>
                <div class="col ms-2">
                    <button id="AccionMesInput" type="button" class="btn btn-sm btn-success h-40px abrir-mes">
                        ABRIR MES
                    </button>
                </div>
                <div class="col ms-2 text-end">
                    
                </div>
                
            </div>          
        </div>
    </div>
    <div id="agregar-gasto" class="mx-5">

    </div>

    <div id="gasto-detalle" class="mx-5">
        <div class="card mb-2">
            <div class="card-body px-4 py-2">

            <div class="accordion accordion-icon-toggle" id="accordion-gastos">
                <!--begin::Item-->
                <div class="accordion-item rounded-top-1">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 rounded-top-1" data-bs-toggle="collapse" data-bs-target="#accordion-gastos-adm" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Administración</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">$ 570.750</div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div id="accordion-gastos-adm" class="fs-6 px-5 collapse show" data-bs-parent="#accordion-gastos" >
                        <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="5" class="p-2">Remuneraciones</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    <tr>
                                        <td class="py-0 px-2">Mantencion</td>
                                        <td class="py-0">Ismael Aguilera</td>
                                        <td class="py-0"></td>
                                        <td class="py-0"></td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">320.800</span> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0 px-2">Conserje de Planta</td>
                                        <td class="py-0">Jose Perez</td>
                                        <td class="py-0"></td>
                                        <td class="py-0"></td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">170.750</span>

                                        </td>
                                    </tr>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="4" class="py-0 px-2">TOTAL REMUNERACIONES</th>
                                        <th class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">570.750</span>        
                                        </th>
                                    </tr>
                                </tbody>
                                
                                <thead>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="5" class="p-2">Caja Chica</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    <tr>
                                        <td class="py-0 px-2">Mantencion</td>
                                        <td class="py-0">Ismael Aguilera</td>
                                        <td class="py-0"></td>
                                        <td class="py-0"></td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">320.800</span> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0 px-2">Conserje de Planta</td>
                                        <td class="py-0">Jose Perez</td>
                                        <td class="py-0"></td>
                                        <td class="py-0"></td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">170.750</span> 
                                        </td>
                                    </tr>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="4" class="py-0 px-2">TOTAL CAJA CHICA</th>
                                        <th class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">570.750</span> 
                                        </th>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr class="text-start text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="5" class="p-2">Otros Gastos</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    <tr>
                                        <td class="py-0 px-2">Mantencion</td>
                                        <td class="py-0">Ismael Aguilera</td>
                                        <td class="py-0"></td>
                                        <td class="py-0"></td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">320.800</span> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0 px-2">Conserje de Planta</td>
                                        <td class="py-0">Jose Perez</td>
                                        <td class="py-0"></td>
                                        <td class="py-0"></td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>170.750</td>
                                    </tr>
                                    <tr class="text-gray-800 fw-bold fs-5 text-uppercase gs-0 table-light">
                                        <th colspan="4" class="py-0 px-2">TOTAL OTROS GASTOS</th>
                                        <th class="py-0 pe-2 text-gray-800 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            570.750</th>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                        <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE ADMINISTRACIÓN</th>
                                        <th class="py-0 pe-2">
                                            <div class="d-flex justify-content-between fw-bolder text-white">
                                                <span class="text-start">$</span>570.750
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="accordion-item">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-uso" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Uso o Consumo</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">$ 570.750</div>
                            </div>
                        </div>   
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div id="accordion-gasto-uso" class="fs-6 px-5 collapse" data-bs-parent="#accordion-gastos">
                    <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr>
                                       
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    <tr>
                                        <td class="py-0 px-2">Agua</td>
                                        <td class="py-0">Essbio cliente n 92832</td>
                                        <td class="py-0 text-gray-400">Consumo entre 17.10 y el 16.11</td>
                                        <td class="py-0 text-gray-400">Bol 3213213</td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">320.800</span> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0 px-2">Electricidad</td>
                                        <td class="py-0">CGE cliente n 89457302</td>
                                        <td class="py-0 text-gray-400">Consumo entre 17.10 y el 16.11</td>
                                        <td class="py-0 text-gray-400">Bol 453223</td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">170.750</span>

                                        </td>
                                    </tr>
                                    <thead>
                                        <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                            <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE USO O CONSUMO</th>
                                            <th class="py-0 pe-2">
                                                <div class="d-flex justify-content-between fw-bolder text-white">
                                                    <span class="text-start">$</span>570.750
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                </tbody>                            
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="accordion-item">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-mantencion" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Mantención</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">$ 870.000</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div id="accordion-gasto-mantencion" class="collapse fs-6 px-5" data-bs-parent="#accordion-gastos">
                        <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr></tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    <tr>
                                        <td class="py-0 px-2">Ascensores</td>
                                        <td class="py-0">D y M Ltda</td>
                                        <td class="py-0 text-gray-400">Mantencion Preventiva</td>
                                        <td class="py-0 text-gray-400">Fact 3231213</td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">320.800</span> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0 px-2">Central Termica</td>
                                        <td class="py-0">Ferrosur</td>
                                        <td class="py-0 text-gray-400">Mantencion Preventiva</td>
                                        <td class="py-0 text-gray-400">Fact 234234</td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">170.750</span>

                                        </td>
                                    </tr>
                                    <thead>
                                        <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                            <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE MANTENCION</th>
                                            <th class="py-0 pe-2">
                                                <div class="d-flex justify-content-between fw-bolder text-white">
                                                    <span class="text-start">$</span>870.000
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                </tbody>                            
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="accordion-item">
                    <!--begin::Header-->
                    <div class="accordion-header py-2 d-flex bg-gray-300 collapsed" data-bs-toggle="collapse" data-bs-target="#accordion-gasto-reparacion" aria-expanded="false">
                        <span class="accordion-icon"><i class="ki-duotone ki-arrow-right fs-4"><span class="path1"></span><span class="path2"></span></i></span>
                        <div class="col-12 pe-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fs-3 fw-bold mb-0 text-dark text-uppercase">Gastos de Reparación</h3>
                                <div class="fs-3 fw-bold mb-0 pe-7 text-dark text-uppercase">$ 170.000</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div id="accordion-gasto-reparacion" class="collapse fs-6 px-5" data-bs-parent="#accordion-gastos">
                        <div class="table-responsive">
                            <table class="table table-hover table-row-bordered gy-5">
                                <thead>
                                    <tr></tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 fs-6">
                                    <tr>
                                        <td class="py-0 px-2">Ascensores</td>
                                        <td class="py-0">D y M Ltda</td>
                                        <td class="py-0 text-gray-400">Cagó</td>
                                        <td class="py-0 text-gray-400">Fact 3231213</td>
                                        <td class="py-0 pe-2 fw-bolder d-flex justify-content-between">
                                            <span class="text-start">$</span>
                                            <span class="text-end">320.800</span> 
                                        </td>
                                    </tr>
                                    <thead>
                                        <tr class="text-gray-800 fw-bold fs-3 text-uppercase table-dark">
                                            <th colspan="4" class="py-0 px-2 text-white">TOTAL GASTOS DE REPARACIÓN</th>
                                            <th class="py-0 pe-2">
                                                <div class="d-flex justify-content-between fw-bolder text-white">
                                                <span class="text-start">$</span>
                                                870.000
                                                </div>
                                                
                                            </th>
                                        </tr>
                                    </thead>
                                </tbody>                            
                            </table>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Item-->
            </div>
            <div class="d-flex align-items-end flex-column">
                <div class="d-flex flex-stack bg-gray-300 p-3 rounded-bottom-1">
					<!--begin::Content-->
					<div class="fs-3 fw-bold text-dark">
						<span class="d-block lh-1 mb-2">Total Gastos del Mes</span>
					    <span class="d-block mb-7">Fondo de Reserva 5%</span>
						<span class="d-block fs-2qx lh-1">TOTAL</span>
					</div>
					<!--end::Content-->
					<!--begin::Content-->
					<div class="fs-3 fw-bold text-dark text-end pe-4">
						<span class="d-block lh-1 mb-2" >$2.181.500</span>
						<span class="d-block mb-7">$109.075</span>
						<span class="d-block fs-2qx lh-1">$2.290.575</span>
					</div>
					<!--end::Content-->
				</div>
            </div>

            
            </div>
        </div>
    </div>
    
</div>
<!--end::Content-->



@endsection

@push('Script')
    <script>  
        const VerMeses = "{{ route('VerMeses') }}"; 
        const CerrarMes = "{{ route('CerrarMes') }}";
        const AbrirMes = "{{ route('AbrirMes') }}";
        const NuevoGasto = "{{ route('NuevoGasto') }}";

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    
    <script src="{{ asset('js/datatables/datatables.bundle.js?id=2') }}"></script>
    <script src="{{ asset('js/datatables/contenido/gastodetalle.js?id=1') }}"></script>
    <script src="{{ asset('js/eventos/gastomes.js?id=3') }}"></script>    
@endpush




