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
use Illuminate\Support\Facades\Auth;





class UserController extends Controller
{
    //
    public function Index(){
        $usuarios = Usuario::with('acceso_comunidades')->get();
        $comunidadId = 12;
        //Falta las comunidades que el usuario puede dar acceso
        
        $roles = Rol::select('Id', 'Nombre')->get();
        $estado = EstadoUsuario::select('Id', 'Nombre')->get();
        $comunidades = Comunidad::select('Id', 'Nombre')->get();

        return View('usuario.usuario')->with([
            'Usuarios' => $usuarios,
            'Roles' => $roles,
            'Estados' => $estado,
            'Comunidades' => $comunidades,
            'comunidadId' => $comunidadId
        ]);
    }

    public function Guardar(Request $request){
              

        $request = $request->input('data');
           // Accede a los atributos del modelo
           $request['Username'] = strtolower($request['Username']);
           //$request['Password'] = $request['Password'];
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
                   'Password' => bcrypt($request['Password']),
                   'EstadoId' => $request['EstadoId'],
                   'RolId' => $request['RolId']
            ]);
            Auth::login($usuario);

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
        //$request['Password'] = $request['Password'];
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
                   'Password' => bcrypt($request['Password']),
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

    public function CambiarEstado(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo

        try{
            $usuarioEdit = Usuario::find($request);
            DB::beginTransaction();
            $usuarioEdit->update([
                   'EstadoId' => ($usuarioEdit['EstadoId'] == 1)? 2: 1 
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

    public function showLogin(){
        return View('auth.login');
    }

    public function attemptLogin(Request $request){
        try {
        $requestdata = $request->input('data');
        $credentials = ['Username' => $requestdata['Username'], 'password' => $requestdata['password']];

        if(Auth::attempt($credentials)){
            $usuario = Auth::user();
                    if (Auth::user()->EstadoId == 1) {
                        return response()->json(['success' => true, 'message' => 'Inicio de sesión exitoso']);
                    
                    } else {
                        auth()->logout();
                        return response()->json(['success' => false, 'message' => 'Tu cuenta está inactiva. Comunícate con el administrador.']);
                
                    }
                        }else{
                            // dd($credentials);
                            return response()->json(['success' => false, 'message' => 'Credenciales incorrectas']);
                            }
        } catch (Exception $e) {
             // Manejar excepciones, si es necesario
            return response()->json(['success' => false, 'message' => 'Error en el inicio de sesión']);
    }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
