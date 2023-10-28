<?php

namespace App\Http\Controllers;

use App\Models\AccesoComunidad;
use App\Models\Comunidad;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AccesoComunidadController extends Controller
{
    public function Guardar(Request $request){
        $request = $request->input('data');

        try{
            DB::beginTransaction();
            $acessoComunidad = AccesoComunidad::create([
                'ComunidadId' => $request['ComunidadId'],
                'UsuarioId' => $request['UsuarioId'],
                'FechaAcceso' => Carbon::now(),
                'Enabled' => 1

            ]);

            //$usuario->save();
            DB::commit(); 
            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }


    }

    public function VerAccesoPorUsuario(Request $request){

        $request = $request->input('data');

        try{
            
            $usuario= AccesoComunidad::select('Comunidad.Nombre','AccesoComunidad.Id','AccesoComunidad.FechaAcceso', 'AccesoComunidad.Enabled','AccesoComunidad.UsuarioId')
                                    ->where('AccesoComunidad.UsuarioId','=',$request)
                                    ->join('Comunidad', 'AccesoComunidad.ComunidadId', '=', 'Comunidad.Id')
                                    ->get();

                                   
            $comunidadesConAcceso = AccesoComunidad::select('Comunidad.Id','Comunidad.Nombre')       
                                        ->where('AccesoComunidad.UsuarioId','=', $request)
                                        ->join('Comunidad', 'AccesoComunidad.ComunidadId', '=', 'Comunidad.Id')
                                        ->get();
            
            $comunidadesSinAcceso = Comunidad::select('Id', 'Nombre')
                                        ->whereNotIn('Id', $comunidadesConAcceso->pluck('Id'))
                                        ->get();

            //$acessoComunidad = AccesoComunidad::
            return response()->json([
                'success' => true,
                'data' => $usuario,
                'data2' =>  $comunidadesSinAcceso]);
        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }

    }

    public function getComunidadSinAcceso(Request $request){
        $request = $request->input('data');

        try{
            $comunidadesConAcceso = AccesoComunidad::select('Comunidad.Id','Comunidad.Nombre')       
                                        ->where('AccesoComunidad.UsuarioId','=', $request)
                                        ->join('Comunidad', 'AccesoComunidad.ComunidadId', '=', 'Comunidad.Id')
                                        ->get();
            
            $comunidadesSinAcceso = Comunidad::select('Id', 'Nombre')
                                        ->whereNotIn('Id', $comunidadesConAcceso->pluck('Id'))
                                        ->get();

            //$acessoComunidad = AccesoComunidad::
            return response()->json([
                'success' => true,
                'data' => $comunidadesSinAcceso]);
        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }


    public function Editar(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo

        try{
            $AccesoEdit = AccesoComunidad::find($request);
            DB::beginTransaction();
            $AccesoEdit->update([
                   'Enabled' => ($AccesoEdit['Enabled'] == 1)? 2: 1 
            ]);
            //$usuario->save();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
    }


}
