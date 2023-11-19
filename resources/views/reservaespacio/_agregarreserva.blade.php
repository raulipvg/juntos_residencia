<div id="agregar-reserva-ctrl" class="card card-flush shadow-sm"> 
    <div class="card-header min-h-40px px-3">
        <h3 class="card-title m-0 p-2 fs-3 fw-bold text-primary text-uppercase">Reservar a la Propiedad: {{$propiedad->Numero}}</h3>
        <div class="card-toolbar m-0">
            <a href="#" class="btn btn-icon btn-sm btn-active-color-primary" data-kt-card-action="remove" data-kt-card-confirm="false">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span>
                    <span class="cerrar-gasto path2"></span>
                </i>
            </a>
        </div>
    </div>
    <div class="card-body">
    <form id="Formulario-nuevareserva" action="" method="post">
            <div class="row">
                <div class="col-12 fv-row">
                    <label for="EspacioReservaInput" class="form-label">Espacio a reservar</label>
                    <select id="EspacioReservaInput" name="EspacioReservaId" class="form-select select-1" data-control="select2" data-placeholder="Seleccione Espacio a Reservar" data-hide-search="false">
                        <option></option>
                        @foreach($espacios as $espacio)
                            <option value="{{ $espacio->Id }}">{{ ucwords($espacio->Nombre) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 fv-row">
                    <label for="FechaReservaInput" class="form-label">Fecha de reserva</label>    
                    <input type="date" class="form-control" placeholder="Ingrese la fecha de reserva" id="FechaReservaInput" name="FechaReserva" />
                </div>
            </div>
            <div class="row">
                <div class="col-12 fv-row">
                    <label for="PrecioInput" class="form-label">Monto Total</label>
                    <input type="number" class="form-control" placeholder="" id="PrecioInput" name="MontoTotal" disabled/>
                </div>
                    <input hidden type="number" class="form-control"  id="PropiedadIdInput" name="PropiedadId" value="{{$propiedad->Id}}" />

                <div class="col-12 d-flex align-items-end justify-content-end mt-2">
                        <button id="AgregarReserva" name="AgregarReserva" type="button" class="btn btn-sm btn-primary" style="height: 42.56px;" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="Registrar Reserva" info="{{$propiedad->Id}}">
                            AGREGAR RESERVA  <i class="ki-outline ki-plus fs-2"></i>
                        </button>
                </div>
            
            </div>
        </form>
    </div>
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var VerEspacioComun = "{{ route('VerEspacioComun') }}"
    </script>
    <script id="prueba" src="{{ asset('js/eventos/agregarreserva.js') }}"></script>   

</div>