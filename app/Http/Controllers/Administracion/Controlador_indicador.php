<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Gestion;
use App\Models\Pei\Indicador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Controlador_indicador extends Controller
{
    public function indicador($id){
        $id_descript = desencriptar($id);
        $gestion = Gestion::find($id_descript);
        $contar_indicador = $gestion->relacion_indicador()->count();
        $indicador = $gestion->relacion_indicador()->get();
        $data['id_gestion']=$id_descript;
        $data['menu']=5;
        $data['indicador']=$indicador;
        $data['gestion']=$gestion;
        $data['contador_indicador']=$contar_indicador;
        return view('administrador.pei.indicador', $data);
    }
    //para guardar nuevo indicador
    public function indicador_guardar(Request $request){
        if($request->ajax()){
            $descripcion_repetidor = json_decode(json_encode($request->repetir_indicadores));
            if($descripcion_repetidor != NULL){
                $contar_array = count($descripcion_repetidor);
                if($contar_array >= minimo_agregar()){
                    if($contar_array <= maximo_agregar()){
                        foreach($descripcion_repetidor as $listar){
                            if($listar->descripcion != ''){
                                $indicador                  = new Indicador;
                                $indicador->codigo          = $listar->codigo;
                                $indicador->descripcion     = $listar->descripcion;
                                $indicador->id_gestion      = $request->gestion_id;
                                $indicador->estado          = 'inactivo';
                                $indicador->save();
                            }
                            $data= mensaje_array('success', 'Se guardo con éxito');
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

    //para editar registro
    public function indicador_editar(Request $request){
        if($request->ajax()){
            $indicador= Indicador::find($request->id);
            if($indicador){
                $data=mensaje_array('success', $indicador);
            }else{
                $data=mensaje_array('error', 'Ocurrio un error inesperado');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function indicador_editar_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(),[
                'codigo'=>'required',
                'descripcion'=>'required',
            ]);
            if($validar->fails()){
                $data=mensaje_array('errores', $validar->errors());
            }else{
                $indicador              = Indicador::find($request->id_indicador);
                $indicador->codigo      = $request->codigo;
                $indicador->descripcion = $request->descripcion;
                if($indicador->save()){
                    $data=mensaje_array('success', 'Se edito con éxito');
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error inesperado');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el indicador
    public function indicador_eliminar(Request $request){
        if($request->ajax()){
            try {
                $indicador= Indicador::find($request->id);
                if($indicador->estado == 'activo'){
                    $data=mensaje_array('error', 'Lo siento, no puede eliminar por que esta en uso!');
                }else{
                    if($indicador->delete()){
                        $data=mensaje_array('success', 'Se eliminó con éxito');
                    }else{
                        $data=mensaje_array('error', 'Ocurrio un error al eliminar');
                    }
                }
            } catch (\Exception $e) {
                $data=mensaje_array('error', 'Ocurrio un error al eliminar '.$e);
            }
            return response()->json($data, 200);
        }
    }
}
