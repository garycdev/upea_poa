<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//para la validacion
use Illuminate\Support\Facades\Validator;

//agregamos el modelo Pdes
use App\Models\Pdes\Pdes_articulacion;
//agregamos la gestion
use App\Models\Gestion;

class Controlador_Pdes extends Controller{


    public function pdes_detalle(Request $request){
        if($request->ajax()){
            $id                 = $request->id;
            $gestion            = Gestion::findOrFail($id);
            $pdes_articulacion  = $gestion->relacion_pdes;
            if($pdes_articulacion){
                $data=array(
                    'tipo'          => 'success',
                    'mensaje'       => $pdes_articulacion,
                    'id'            => $id,
                    'gestion_pdes_1'=> $gestion
                );
            }else{
                $data=array(
                    'tipo'          => 'error',
                    'mensaje'       => 'no hay',
                    'id'            => $id,
                    'gestion_pdes_1'=> $gestion
                );
            }
            return response()->json($data, 200);
        }

    }

    //para guardar el pdes
    public function pdes_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(),[
                'codigo_eje'            =>'required',
                'descripcion_eje'       =>'required',
                'codigo_meta'           =>'required',
                'descripcion_meta'      =>'required',
                'codigo_resultado'      =>'required',
                'descripcion_resultado' =>'required',
                'codigo_accion'         =>'required',
                'descripcion_accion'    =>'required'
            ]);

            if($validar->fails()){
                $data=array(
                    'tipo'=>'errores',
                    'mensaje'=>$validar->errors()
                );
            }else{
                if($request->id_pdes != ''){
                    $pdes = Pdes_articulacion::find($request->id_pdes);
                }else{
                    $pdes = new Pdes_articulacion;
                }
                $pdes->codigo_eje               = $request->codigo_eje;
                $pdes->descripcion_eje          = $request->descripcion_eje;
                $pdes->codigo_meta              = $request->codigo_meta;
                $pdes->descripcion_meta         = $request->descripcion_meta;
                $pdes->codigo_resultado         = $request->codigo_resultado;
                $pdes->descripcion_resultado    = $request->descripcion_resultado;
                $pdes->codigo_accion            = $request->codigo_accion;
                $pdes->descripcion_accion       = $request->descripcion_accion;
                $pdes->id_gestion               = $request->id_gestion_pdes;
                if($pdes->save()){
                    $data=array(
                        'tipo'=>'success',
                        'mensaje'=>'Se guardo con éxito la articulacion del PDES!'
                    );
                }else{
                    $data=array(
                        'tipo'=>'error',
                        'mensaje'=>'Ocurrio un error al guardar!'
                    );
                }
            }
            return response()->json($data, 200);
        }
    }
}
