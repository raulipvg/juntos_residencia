<?php

namespace App\Http\Controllers;

use App\Models\AccesoComunidad;
use App\Models\Comunidad;
use App\Models\Usuario;
use App\Models\EstadoUsuario;
use App\Models\Rol;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;





class UserController extends Controller
{
    //
    public function Index(){
        $usuarios = Usuario::with('acceso_comunidades')->get();
        $roles = Rol::select('Id', 'Nombre')->get();
        $estado = EstadoUsuario::select('Id', 'Nombre')->get();
        $comunidades = Comunidad::select('Id', 'Nombre')->get();

        return View('usuario.usuario')->with([
            'Usuarios' => $usuarios,
            'Roles' => $roles,
            'Estados' => $estado,
            'Comunidades' => $comunidades
        ]);
    }


    public function Guardar(Request $request){
              

        $request = $request->input('data');
           // Accede a los atributos del modelo
           $request['Username'] = strtolower($request['Username']);
           $request['Password'] = $request['Password'];
           $request['Nombre'] = strtolower($request['Nombre']);
           $request['Apellido'] = strtolower($request['Apellido']);
           $request['Correo']= strtolower($request['Correo']);
           $request['FechaAcceso'] = Carbon::now();
           $request['Enabled']= 1;
           
        
        try{
            $usuario = new Usuario();
            $usuario->validate($request);
            

            $acessoComunidad = new AccesoComunidad();
            $acessoComunidad->validate([
                'ComunidadId' => $request['ComunidadId'],
                'UsuarioId' => 1,
                'FechaAcceso' =>$request['FechaAcceso'],
                'Enabled' => $request['Enabled']
            ]);
            DB::beginTransaction();
            $usuario= Usuario::create([
                   'Nombre'=> $request['Nombre'],
                   'Apellido' => $request['Apellido'],
                   'Username' => $request['Username'],
                   'Correo' => $request['Correo'],
                   'Password' => $request['Password'],
                   'EstadoId' => $request['EstadoId'],
                   'RolId' => $request['RolId']
            ]);

            $acessoComunidad = AccesoComunidad::create([
                'ComunidadId' => $request['ComunidadId'],
                'UsuarioId' => $usuario->Id,
                'FechaAcceso' =>$request['FechaAcceso'],
                'Enabled' => $request['Enabled']

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

    public function VerId(Request $request){

        $request = $request->input('data');

        try{

            $usuario= Usuario::find($request);
            //$acessoComunidad = AccesoComunidad::
            return response()->json([
                'success' => true,
                'data' => $usuario,
                'acceso' => $usuario->acceso_comunidades ]);
        }catch(Exception $e){

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }

    }

    public function Editar(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo
        $request['Username'] = strtolower($request['Username']);
        $request['Password'] = $request['Password'];
        $request['Nombre'] = strtolower($request['Nombre']);
        $request['Apellido'] = strtolower($request['Apellido']);
        $request['Correo']= strtolower($request['Correo']);
        $request['Enabled'] = $request["EstadoId"];

        try{
            $usuarioEdit = Usuario::find($request['Id']);

            $usuario = new Usuario();
            $usuario->validate($request);
            
            DB::beginTransaction();
            $usuarioEdit->update([
                   'Nombre'=> $request['Nombre'],
                   'Apellido' => $request['Apellido'],
                   'Username' => $request['Username'],
                   'Correo' => $request['Correo'],
                   'Password' => $request['Password'],
                   'EstadoId' => $request['EstadoId'],
                   'RolId' => $request['RolId']
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
