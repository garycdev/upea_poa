<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Areas_estrategicas;
use App\Models\Pei\Foda_descripcion;
use App\Models\Pei\Tipo_foda;
use App\Models\Pei\Tipo_plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Controlador_Foda extends Controller{

    public function listar_foda($area_estrategica, $tipo_plan){
        $id_area_estrategica            = desencriptar($area_estrategica);
        $id_tipo_plan                   = desencriptar($tipo_plan);
        $area_estrategica               = Areas_estrategicas::find($id_area_estrategica);
        $gestion                        = $area_estrategica->reversa_relacion_areas_estrategicas;
        $data['tipo_plan']              = Tipo_plan::find($id_tipo_plan);
        $data['id_area_estrategica']    = $id_area_estrategica;
        $data['id_tipo_plan']           = $id_tipo_plan;
        $data['area_estrategica']       = $area_estrategica;
        $data['gestion']                = $gestion;
        $data['foda']                   = Tipo_foda::orderBy('id', 'asc')->get();
        $data['menu']                   = '5';
        return view('administrador.foda.foda',$data);
    }

    //para listar la fortaleza
    public function foda_listar(Request $request){
        if($request->ajax()){
            $id_area_estrategica    = $request->area_estrategica;
            $id_tipo_plan           = $request->tipo_plan;
            $id_tipo_foda           = $request->tipo_foda;
            $foda = Foda_descripcion::with('reversa_relacion_foda_descripcion')
                            ->where([
                                ['id_area_estrategica','=',$id_area_estrategica],
                                ['id_tipo_plan', '=', $id_tipo_plan],
                                ['id_tipo_foda', '=', $id_tipo_foda],
                            ])
                            ->orderBy('id','asc')
                            ->get();
            $data   = array(
                'foda'  => $foda,
            );
            return response()->json($data, 200);
        }
    }
    //para guardar el foda
    public function foda_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'tipo_foda' => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $descripcion_repetidor = json_decode(json_encode($request->repetir_foda));
                if($descripcion_repetidor != NULL){
                    $contar_array = count($descripcion_repetidor);
                    if($contar_array >= minimo_agregar()){
                        if($contar_array <= maximo_agregar()){
                            foreach($descripcion_repetidor as $listar){
                                if($listar->descripcion != ''){
                                    $guardar_foda                       = new Foda_descripcion;
                                    $guardar_foda->descripcion          = $listar->descripcion;
                                    $guardar_foda->id_tipo_plan         = $request->tipo_plan;
                                    $guardar_foda->id_tipo_foda         = $request->tipo_foda;
                                    $guardar_foda->id_area_estrategica  = $request->area_estrategica;
                                    $guardar_foda->save();
                                }
                                $data= mensaje_array('success', 'Se guardo con exito');
                            }
                        }else{
                            $data=mensaje_array('error', 'Solo puede guardar '. maximo_agregar() .' de registros');
                        }
                    }else{
                        $data=mensaje_array('error', 'Debe contener al menos'. minimo_agregar(). ' registro');
                    }
                }else{
                    $data=mensaje_array('error', 'No se encontro ningun registro');
                }
            }
            return response()->json($data, 200);
        }
    }



    //para eliminar el foda
    public function foda_eliminar(Request $request){
        if($request->ajax()){
            try {
                $eliminar_foda = Foda_descripcion::find($request->id);
                $eliminar_foda->delete();
                $data   =   mensaje_array('success','Se elimino con éxito');
            } catch (\Throwable $th) {
                $data   =   mensaje_array('error', 'Ocurrio un problema al eliminar');
            }
            return response()->json($data, 200);
        }
    }

    //para editar foda
    public function foda_editar(Request $request){
        if($request->ajax()){
            $editar_foda = Foda_descripcion::find($request->id);
            $editar_foda->reversa_relacion_tipo_foda_foda_descripcion;
            if($editar_foda){
                $data   =   mensaje_array('success', $editar_foda);
            }else{
                $data   =   mensaje_array('success', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }

    //para guardar lo editado
    public function foda_editar_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'descripcion_' => 'required',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $foda_editado = Foda_descripcion::find($request->id_foda);
                $foda_editado->descripcion = $request->descripcion_;
                if($foda_editado->save()){
                    $data=mensaje_array('success','Se édito con éxito!');
                }else{
                    $data = mensaje_array('error','Ocurrio un error al editar!');
                }
            }
            return response()->json($data, 200);
        }
    }
}
