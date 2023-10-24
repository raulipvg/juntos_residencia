<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\Propiedad;
use App\Models\TipoPropiedad;
use Illuminate\Http\Request;
use Exception;

class PropiedadController extends Controller
{
    public function Index(){
        $propiedades = Propiedad::all();
        $comunidades = Comunidad::select('Id', 'Nombre')->get();
        $tipopropiedad = TipoPropiedad::select('Id','Nombre')->get();

        return View('propiedad.propiedades')->with([
            'Propiedad' => $propiedades,
            'Comunidad' => $comunidades,
            'TipoPropiedad' => $tipopropiedad]);
    }

    public function Guardar(Request $request){
        
        $request = $request->input('data');

        $request['ComunidadId'] = $request['Comunidad'];
        $request['TipoPropiedad'] = $request['TipoPropiedadId'];
        $request['Numero'] = strtolower($request['Numero']);
        $request['Prorrateo'] = $request['Prorrateo'];
        $request['Descripcion'] = strtolower($request['Descripcion']);
        $request['Enabled'] = $request['Estado'];

        try {
            $propiedad = new Propiedad();
            $propiedad->validate($request);
            $propiedad->fill($request);

            $propiedad->save();
            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        } catch (Exception $e) {

            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()]);
        }
    }

    public function VerId(Request $request){
        
        $request = $request->input('data');

        try {
            
            $propiedad = Propiedad::find($request);
            return response()->json([
                'success' => true,
                'data' => $propiedad]);
        } catch (Exception $e) {

            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()]);
        }
    }

    public function Editar(Request $request){
        
        $request = $request->input('data');

        $request['ComunidadId'] = $request['Comunidad'];
        $request['TipoPropiedad'] = $request['TipoPropiedadId'];
        $request['Numero'] = strtolower($request['Numero']);
        $request['Prorrateo'] = $request['Prorrateo'];
        $request['Descripcion'] = strtolower($request['Descripcion']);
        $request['Enabled'] = $request['Estado'];

        try {
            $propiedad = new Propiedad();
            $propiedad->validate($request);
            $propiedadEdit = Propiedad::find($request['Id']);

            $propiedadEdit->fill($request);

            $propiedadEdit->save();

            return response()->json([
                'success' => true,
                'message' => 'Modelo recibido y procesado']);
        } catch (Exception $e) {

            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()]);
        }
    }
}
