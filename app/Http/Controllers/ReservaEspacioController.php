<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\EspacioComun;
use App\Models\GastoComun;
use App\Models\GastoMe;
use App\Models\HistorialPago;
use App\Models\Propiedad;
use App\Models\ReservaEspacio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservaEspacioController extends Controller
{
    public function Index(){
        $comunidadId = 12;
        $comunidades = Comunidad::select('Id','Nombre')
                            ->where('Enabled', 1)
                            ->orderBy('Nombre','asc')
                            ->get();

        $propiedades = Propiedad::select('Propiedad.Id','Propiedad.Numero',
                                         'Persona.Nombre','Persona.Apellido'
                                        )
                            ->where('Propiedad.ComunidadId', $comunidadId)
                            ->where('Propiedad.Enabled', 1) //Propeidad Habilitada
                            ->join('Compone','Compone.PropiedadId','=','Propiedad.Id')
                            ->where('Compone.RolComponeCoReId', 1) //Es propietario
                            ->where('Compone.Enabled', 1) // Es propietario Actual
                            ->join('Persona','Persona.Id','=','Compone.PersonaId')
                            ->get();
        $gastosMeses = GastoMe::select('Id','Fecha','EstadoId')
                            ->where('ComunidadId', $comunidadId)
                            ->latest('Fecha')
                            ->get();
        $gasto =  GastoMe::select('Id')
                            ->where('ComunidadId', $comunidadId)
                            ->latest('Fecha')
                            ->first();
        return view("reservaespacio.reservaespacio")->with([
            "comunidades"=> $comunidades,
            'comunidadId'=> $comunidadId,
            "propiedades"=> $propiedades,
            "gastosmeses"=> $gastosMeses,
            "gasto"=> $gasto
        ]);   
    }

    public function VerReserva(Request $request){
        $request = $request->input('data');
        

        try {
            $propiedad = Propiedad::select('Id','Numero')
                                    ->where('Id', $request['propiedadId'])
                                    ->first();
            $reservas = ReservaEspacio::select('EspacioComun.Nombre as EspacioComun', 'FechaUso', 'Total', 'EstadoReserva.Nombre as Estado')
                                    ->join('EspacioComun', 'EspacioComun.Id', '=', 'ReservaEspacio.EspacioComunId')
                                    ->join('GastoComun', 'GastoComun.Id', '=', 'ReservaEspacio.GastoComunId')
                                    ->join('EstadoReserva', 'EstadoReserva.Id', '=', 'ReservaEspacio.EstadoReservaId')
                                    ->where('ReservaEspacio.PropiedadId', $request['propiedadId'])
                                    ->where('GastoComun.GastoMesId', $request['gastoMesId'])
                                    ->get();
                                
            
                                    /*
            $reservas = ReservaEspacio::select('EspacioComun.Nombre as EspacioComun','FechaUso','Total','EstadoReserva.Nombre as Estado')
                                    ->join('EspacioComun','EspacioComun.Id','=','EspacioComunId')
                                    ->join('EstadoReserva','EstadoReserva.Id','=','EstadoReservaId')
                                    ->join('GastoComun',$request['gastoMesId'],'=','GastoMesId')
                                    ->where('PropiedadId', $request['propiedadId'])
                                    ->where('GastoComunId', 'GastoComun.Id')
                                    ->get();
            */
            return view('reservaespacio._verreserva', compact('reservas', 'propiedad'));
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function AgregarReserva(Request $request){
        $request = $request->input('data');
        
        $deuda = GastoComun::select('HistorialPago.MontoAPagar')
            ->join('HistorialPago','HistorialPago.GastoComunId','=','GastoComun.Id')
            ->where('GastoComun.PropiedadId', $request['propiedadId'])
            ->where('GastoComun.EstadoGastoId',1)
            ->orderBy('HistorialPago.FechaPago','desc')
            ->first();
        
        
        try {
            $propiedad = Propiedad::select('Id','Numero')
                                    ->where('Id', $request['propiedadId'])
                                    ->first();
            if($deuda->MontoAPagar != 0) {
                $message = 'Propietario tiene deuda, no puede reservar espacio.';
                return view('reservaespacio._ErrorDeuda', compact('message','propiedad'));
            }
            $espacios = EspacioComun::select('Id', 'Nombre')
                                    ->where('ComunidadId', $request['comunidadId'])
                                    ->get();
            return view('reservaespacio._agregarreserva', compact('propiedad', 'espacios'));
            
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()]);
        }
    }

    public function GuardarReserva(Request $request){
        $request = $request->input('data');
        $reservaPasada = ReservaEspacio::where('FechaUso', $request['FechaReserva'])
                                        ->where('EspacioComunId', $request['EspacioReservaId']);
        if($reservaPasada != null){
            return response()->json([
                'success' => false,
                'message' => 'El espacio ya está en uso para la fecha indicada']);
        }
        $espacioReservado = EspacioComun::find($request['EspacioReservaId']);
        $gastoComunAbiertoId = GastoComun::select('Id')
                                        ->where('EstadoGastoId', 3)
                                        ->where('PropiedadId', $request['PropiedadId'])
                                        ->first();


        
        try {
            $nuevaReserva = new ReservaEspacio();
            $nuevaReserva->FechaSolicitud = Carbon::now();
            $nuevaReserva->FechaUso = $request['FechaReserva'];
            $nuevaReserva->Cantidad = 1;
            $nuevaReserva->Total = $espacioReservado->Precio;
            $nuevaReserva->TipoCobroId = 1;
            $nuevaReserva->GastoComunId = $gastoComunAbiertoId->Id;
            $nuevaReserva->PropiedadId = $request['PropiedadId'];
            $nuevaReserva->EstadoReservaId = 2;
            $nuevaReserva->EspacioComunId = $request['EspacioReservaId'];


            $nuevaReserva->save();

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }



    public function VerSolicitudes(Request $request){
        $request = $request->input('data');

        

        try {
            $Solicitudes = ReservaEspacio::select('ReservaEspacio.Id as Id',
                                                'Propiedad.Numero as propiedad',
                                                'Persona.Nombre as copNombre',
                                                'Persona.Apellido as copApellido',
                                                'ReservaEspacio.FechaUso',
                                                'EspacioComun.Nombre as espacio', 
                                                'ReservaEspacio.EstadoReservaId as estado')
                                        ->join('EspacioComun','EspacioComunId','=','EspacioComun.Id')
                                        ->join('Compone','ReservaEspacio.PropiedadId','=','Compone.PropiedadId')
                                        ->join('Propiedad','ReservaEspacio.PropiedadId','=','Propiedad.Id')
                                        ->join('Persona','Compone.PersonaId','=','Persona.Id')
                                        ->join('GastoComun','ReservaEspacio.GastoComunId','=','GastoComun.Id')
                                        ->where('EspacioComun.ComunidadId','=', $request['comunidadId'])
                                        ->where('Compone.Enabled','=', 1)
                                        ->where('Compone.RolComponeCoReId','=', 1)
                                        ->where('GastoComun.GastoMesId',$request['gastoMesId'])
                                        ->get();

            return view('reservaespacio._solicitudesreserva', compact('Solicitudes'));
        } catch (Exception $ex) {
            return ([
                'success'=> false,
                'message'=> $ex->getMessage()
            ]);
        }
    }

    public function CambiarEstado(Request $request){
        $request = $request->input('data');
        $reserva = ReservaEspacio::find($request['reservaId']);

        try {
            $reserva->EstadoReservaId = $request['estado'];
            $reserva->save();
            return [
                'success'=> true,
                'message'=> "Estado cambiado"
                ];
        }
        catch (Exception $ex) {
            return [
                'success'=> false,
                'message'=> $ex->getMessage()
                ];
        }
    }
}
