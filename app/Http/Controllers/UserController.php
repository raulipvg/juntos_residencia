<?php

namespace App\Http\Controllers;

use App\Models\EstadoUsuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use App\Models\Usuario;
use \Exception;

class UserController extends Controller
{
    //
    public function index(){
        $usuarios = Usuario::all();
        $roles = Rol::select('Id', 'Nombre')->get();
        $estado = EstadoUsuario::select('Id', 'Nombre')->get();

        return View('home.usuarios')->with([
            'Usuarios' => $usuarios,
            'Roles' => $roles,
            'Estados' => $estado
        ]);
    }


    public function Save(Request $request){
              
        


        $modelo = $request->input('data');
           // Accede a los atributos del modelo
        $usuario = new Usuario();
        $usuario->Username = strtolower($modelo['Username']);
        $usuario->Password = $modelo['Password'];
        $usuario->Nombre = strtolower($modelo['Nombre']);
        $usuario->Apellido = strtolower($modelo['Apellido']);
        $usuario->Correo = strtolower($modelo['Email']);
        $usuario->RolId = $modelo['Rol'];
        $usuario->EstadoId = $modelo['Estado'];

        

        try{
            $modelo->validate([
                'Nombre' => 'required|string',
                'Apellido' => 'required|string|max:255',
                'Username' => 'required|string|max:255',
                'Correo' => 'required|email|max:255',
                'Pasword' => 'required|string|min:8|max:12',
                'EstadoId' => 'required|int|max:255',
                'RolId' => 'required|int'
            ],[
                'Nombre.required' => 'Nombre es campo obligatorio.',
                'Apellido.required' => 'Apellido es campo obligatorio.',
                'Username.required' => 'Username Paterno es campo obligatorio.',
                'Correo.required' => 'Correo Materno es campo obligatorio.',
                'Pasword.required' => 'Pasword es campo obligatorio.',
                'EstadoId.required' => 'EstadoId es campo obligatorio.',
                'RolId.required' => 'RolId Arriendo es campo obligatorio.',
            ]);

            $usuario->save(); 
            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        }catch(\Exception $e){
                
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()]);
        }
          

    }
}
