<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\EstadoUsuario;
use App\Models\Rol;
use Exception;
use Illuminate\Http\Request;




class UserController extends Controller
{
    //
    public function Index(){
        $usuarios = Usuario::all();
        $roles = Rol::select('Id', 'Nombre')->get();
        $estado = EstadoUsuario::select('Id', 'Nombre')->get();

        return View('home.usuarios')->with([
            'Usuarios' => $usuarios,
            'Roles' => $roles,
            'Estados' => $estado
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
           
        
        try{
            $usuario = new Usuario();
            $usuario->validate($request);
            $usuario->fill($request);

            
            $usuario->save(); 
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

            $usuario= Usuario::find($request);
            return response()->json([
                'success' => true,
                'data' => $usuario ]);
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

        try{
            $usuario = new Usuario();
            $usuario->validate($request);

            $userEdit = Usuario::find($request['Id']);
            //$userEdit->Username
            $userEdit->fill($request);

            $userEdit->save();

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
