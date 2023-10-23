<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\EspacioComun;
use Illuminate\Http\Request;
use Exception;


class EspacioComunController extends Controller
{

    public function Index(Request $request){
        $IdComunidad = $request->input('data');
        try{
            $espacios_comunes = EspacioComun::where('ComunidadId', $IdComunidad)->get();
            $Comunidad = Comunidad::Select('Id','Nombre')
                                    ->Where('Id', '=', $IdComunidad)->first(); 

            return response()->json([
                'success' => true,
                'data' => $espacios_comunes,
                'comunidad' => $Comunidad]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'comunidad' => $Comunidad]);
        }
       
    }
    public function Guardar(Request $request)
    {
        
        

        $request = $request->input('data');
        $IdComunidad = $request['ComunidadId'];

        $comunidad = Comunidad::findOrFail($IdComunidad);

        $request['Nombre'] =  strtolower($request['Nombre']);
        $request['Descripcion'] = strtolower($request['Descripcion']);

       

        try{
            $espaciocomun = new EspacioComun();
            $espaciocomun->comunidad()->associate($comunidad);
            $espaciocomun->validate($request);
            $espaciocomun->fill($request);
            $espaciocomun->save(); 

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }
    
    public function VerId(Request $request)
    {
        $IdEspacio= $request->input('data');
        
         try{

            $espacioComun = EspacioComun::with('comunidad')->find( $IdEspacio );
            return response()->json([
                'success' => true,
                'data' => $espacioComun ]);
        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }

    public function Editar(Request $request)
    {
        $request = $request->input('data');
        $IdEspacio= $request["Id"];
        try{

            $espacioComun = EspacioComun::findOrFail($IdEspacio);
            $espacioComun->validate($request);
        
            $espacioComun->update([
                    'Nombre' => $request['Nombre'],
                    'Precio' => $request['Precio'],
                    'Descripcion' => $request['Descripcion'],
                    'Garantia' => $request['Garantia'],
                    'Enabled' => $request['Enabled']
             ]);

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }
}
