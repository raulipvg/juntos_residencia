<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\Propiedad;
use App\Models\TipoPropiedad;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;


class PropiedadController extends Controller
{
    public function Index()
    {
        $propiedades = Propiedad::all();
        $comunidades = Comunidad::select('Id', 'Nombre')->get();
        $tipopropiedad = TipoPropiedad::select('Id', 'Nombre')->get();

        return View('propiedad.propiedades')->with([
            'Propiedad' => $propiedades,
            'Comunidad' => $comunidades,
            'TipoPropiedad' => $tipopropiedad
        ]);
    }

    public function Guardar(Request $request)
    {

        $request = $request->input('data');

        $request['ComunidadId'] = $request['Comunidad'];
        $request['TipoPropiedad'] = $request['TipoPropiedadId'];
        $request['Numero'] = strtolower($request['Numero']);
        $request['Descripcion'] = strtolower($request['Descripcion']);
        $request['Enabled'] = $request['Estado'];

        try {
            $nPropiedades = Comunidad::select('CantPropiedades')
                ->where('Id', '=', $request['ComunidadId'])
                ->first();

            if ($nPropiedades) {
                $numeroDePropiedades = $nPropiedades->CantPropiedades;
            } else {
                // Manejar el caso en el que no se encuentra la comunidad
                $numeroDePropiedades = 0; // o cualquier otro valor predeterminado
            }
            $countPropiedades = Propiedad::where('ComunidadId', '=', $request['ComunidadId'])
                ->count();
            if ($countPropiedades < $numeroDePropiedades) {

                $sumaProrateo = Propiedad::where('ComunidadId', '=', $request['ComunidadId'])
                    ->sum('Prorrateo');
                if (($sumaProrateo + $request['Prorrateo']) <= 100) {

                    $propiedad = new Propiedad();
                    $propiedad->validate($request);
                    $propiedad->fill($request);

                    $propiedad->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Modelo recibido y procesado'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'El prorrateo supera el 100%'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'La comunidad ha alcanzado el número máximo de propiedades'
                ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function VerId(Request $request)
    {

        $request = $request->input('data');

        try {
            $propiedad = Propiedad::find($request);
            return response()->json([
                'success' => true,
                'data' => $propiedad
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function Editar(Request $request)
    {

        $request = $request->input('data');

        $propiedadEdit = Propiedad::find($request['Id']);
        $request['TipoPropiedad'] = $request['TipoPropiedadId'];
        $request['Numero'] = strtolower($request['Numero']);
        $request['Descripcion'] = strtolower($request['Descripcion']);
        $request['Enabled'] = $request['Estado'];
        $request['ComunidadId'] = $propiedadEdit->ComunidadId;

        try {
            $nPropiedades = Comunidad::select('CantPropiedades')
                ->where('Id', '=', $propiedadEdit->ComunidadId)
                ->first();

            if ($nPropiedades) {
                $numeroDePropiedades = $nPropiedades->CantPropiedades;
            } else {
                // Manejar el caso en el que no se encuentra la comunidad
                $numeroDePropiedades = 0; // o cualquier otro valor predeterminado
            }
            $countPropiedades = Propiedad::where('ComunidadId', '=', $propiedadEdit->ComunidadId)
                                            ->count();
            if ($countPropiedades <= $numeroDePropiedades) {

                $sumaProrateo = Propiedad::where('ComunidadId', '=', $propiedadEdit->ComunidadId)
                                            ->sum('Prorrateo');
                if (($sumaProrateo + ($request['Prorrateo'] - $propiedadEdit->Prorrateo) ) <= 100) {

                    $propiedad = new Propiedad();
                    $propiedad->validate($request);
                    $propiedadEdit->fill($request);
                    $propiedadEdit->save();  

                    return response()->json([
                        'success' => true,
                        'message' => 'Modelo recibido y procesado'
                    ]);

                } else {
                    $restante= 100- (float)$sumaProrateo + $propiedadEdit->Prorrateo;
                    return response()->json([
                        'success' => false,
                        'message' => 'El prorrateo supera el 100%, quedan '.$restante.'%'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'La comunidad ha alcanzado el número máximo de propiedades'
                ]);
            }
            
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function CambiarEstado(Request $request){
        $request = $request->input('data');
        // Accede a los atributos del modelo
        try{
            $propiedadEdit = Propiedad::find($request);
            DB::beginTransaction();
            $propiedadEdit->update([
                   'Enabled' => ($propiedadEdit['Enabled'] == 1)? 2: 1 
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
