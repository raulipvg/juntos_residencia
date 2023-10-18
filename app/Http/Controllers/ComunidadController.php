<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\TipoComunidad;
use Illuminate\Http\Request;
use Exception;

class ComunidadController extends Controller
{
    public function Index(){
        $comunidades = Comunidad::all();
        $tipocomunidad = TipoComunidad::select('Id', 'Nombre')->get();
        return View('Comunidad.comunidades')->with([
            'Comunidades' => $comunidades,
            'TipoComunidad' => $tipocomunidad,
        ]);
    }
    public function Guardar(Request $request){
        
        $request = $request->input('data');
        // Accede a los atributos del modelo
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['RUT'] = strtolower($request['RUT']);
        $request['Correo'] = strtolower($request['Correo']);
        $request['NumeroCuenta'] = strtolower($request['NumeroCuenta']);
        $request['TipoCuenta']= $request['TipoCuenta'];
        $request['Banco']= strtolower($request['Banco']);
        $request['CantPropiedades']= strtolower($request['CantPropiedades']);
        $request['FechaRegistro']= $request['FechaRegistro']= now();
        $request['Enabled']= $request['Enabled'];

        
     
     try{
         $comunidad = new Comunidad();
         $comunidad->validate($request);
         $comunidad->fill($request);

         
         $comunidad->save(); 
         return response()->json([
             'success' => true,
             'message' => 'Modelo recibido y procesado']);
     }catch(Exception $e){
             
         return response()->json([
             'success' => false,
             'message' => $e->getMessage()]);
     }
    }
    public function VerId(Request $request){
        
        $request = $request->input('data');

        try{

            $comunidad= Comunidad::find($request);
            return response()->json([
                'success' => true,
                'data' => $comunidad ]);
        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }
    public function Editar(Request $request){

        $request = $request->input('data');
        // Accede a los atributos del modelo
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['RUT'] = strtolower($request['RUT']);
        $request['Correo'] = strtolower($request['Correo']);
        $request['NumeroCuenta'] = strtolower($request['NumeroCuenta']);
        $request['TipoCuenta']= $request['TipoCuenta'];
        $request['Banco']= strtolower($request['Banco']);
        $request['CantPropiedades']= strtolower($request['CantPropiedades']);
        $request['FechaRegistro']= $request['FechaRegistro'];
        $request['Enabled']= $request['Enabled'];

         try{
            $comunidad = new Comunidad();
            $comunidad->validate($request);

            $comunidadEdit = Comunidad::find($request['Id']);
            //$userEdit->Username
            $comunidadEdit->fill($request);

            $comunidadEdit->save();

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
