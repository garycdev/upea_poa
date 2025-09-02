<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Areas_estrategicas;
use Illuminate\Http\Request;
use App\Models\Gestion;
use App\Models\Pdu\Objetivo_estrategico;
use App\Models\Pdu\Politica_desarrollo;
use App\Models\Pei\Tipo_foda;
use Illuminate\Support\Facades\Validator;

class Controlador_Pdu extends Controller
{
    //para el DU //num 2
    public $tipo_plan = 1;

    public function pdu($id){
        $id_gestion         = desencriptar($id);
        $data['gestion_id'] = $id_gestion;
        $data['menu']       = '5';
        $gestion            = Gestion::find($id_gestion);
        $areas_estrategicas = $gestion->relacion_areas_estrategicas()
                                ->where('estado', 'activo')
                                ->get();
        $data['gestion']            = $gestion;
        $data['areas_estrategicas'] = $areas_estrategicas;
        $data['tipo_plan']          = $this->tipo_plan;
        $data['tipo_foda']          = Tipo_foda::get();
        return view('administrador.pdu.pdu', $data);
    }


    //para listar las politicas de desarrollo
    public function listar_politica_desarrollo(Request $request){
        if($request->ajax()){
            $areas_estrategicas     = Areas_estrategicas::find($request->id);
            $politica_desarrollo    = $areas_estrategicas->relacion_politica_desarrollo()->where('id_tipo_plan', $this->tipo_plan)->get();
            if($politica_desarrollo){
                $data = mensaje_array('success', $politica_desarrollo);
            }else{
                $data = mensaje_array('error', 'No existe registros aun');
            }
            return response()->json($data, 200);
        }
    }

    //para guardar la politica de desarrollo
    public function politica_desarrollo_guardar(Request $request){
        $validar = Validator::make($request->all(),[
            'codigo'=>'required',
            'descripcion'=>'required'
        ]);
        if($validar->fails()){
            $data=mensaje_array('errores', $validar->errors());
        }else{
            if($request->id_politica_desarrollo != ''){
                $politica_desarrollo                = Politica_desarrollo::find($request->id_politica_desarrollo);
                $politica_desarrollo->codigo        = $request->codigo;
                $politica_desarrollo->descripcion   = $request->descripcion;
                if($politica_desarrollo->save()){
                    $data=array(
                        'tipo'                  => 'success',
                        'mensaje'               => 'Se editó con éxito!',
                        'id_area_estrategica'   => $request->id_area_estrategica
                    );
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error al editar');
                }
            }else{
                $politica_desarrollo                        = new Politica_desarrollo;
                $politica_desarrollo->codigo                = $request->codigo;
                $politica_desarrollo->descripcion           = $request->descripcion;
                $politica_desarrollo->id_area_estrategica   = $request->id_area_estrategica;
                $politica_desarrollo->id_tipo_plan          = $this->tipo_plan;
                if($politica_desarrollo->save()){
                    $data=array(
                        'tipo'                  => 'success',
                        'mensaje'               => 'Se guardo con éxito!',
                        'id_area_estrategica'   => $request->id_area_estrategica
                    );
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error al guardar');
                }
            }
        }
        return response()->json($data, 200);
    }

    //par aeditar la politica de desarrollo
    public function politica_desarrollo_editar(Request $request){
        if($request->ajax()){
            $politica_desarrollo = Politica_desarrollo::find($request->id);
            if($politica_desarrollo){
                $data=mensaje_array('success', $politica_desarrollo);
            }else{
                $data=mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }

    //para eliminar la politica de desarrollo
    public function politica_desarrollo_eliminar(Request $request){
        if($request->ajax()){
            try {
                $politica_desarrollo = Politica_desarrollo::find($request->id);
                if($politica_desarrollo->delete()){
                    $data = mensaje_array('success','Se eliminó con éxito!');
                }else{
                    $data = mensaje_array('error','Ocurrio un error al eliminar!');
                }
            } catch (\Throwable $th) {
                $data = mensaje_array('error','Ocurrio un error al eliminar!');
            }
            return response()->json($data, 200);
        }
    }


    /**
     * OBJETIVO ESTRATEGICO
    */
    public function objetivo_estrategico($id){
        $id_descript            = desencriptar($id);
        $areas_estrategica      = Areas_estrategicas::find($id_descript);
        $gestion                = $areas_estrategica->reversa_relacion_areas_estrategicas;

        $politica_desarrollo    = $areas_estrategica->relacion_politica_desarrollo()
                                        ->where('id_tipo_plan', $this->tipo_plan)
                                        ->get();
        $politica_desar         = Politica_desarrollo::with('relacion_objetivo_estrategico_sub')
                                        ->where('id_tipo_plan', $this->tipo_plan)
                                        ->where('id_area_estrategica', $areas_estrategica->id)
                                        ->get();

        /* $resultados = Areas_estrategicas::with(['relacion_politica_desarrollo' => function($query1) {
            $query1->where('id_tipo_plan', $this->tipo_plan)
                    ->with('relacion_objetivo_estrategico');
        }])->find($id_descript); */

        $data['menu']                   = '5';
        $data['areas_estrategicas']     = $areas_estrategica;
        $data['gestion']                = $gestion;
        $data['politica_desarrollo']    = $politica_desarrollo;
        $data['listar']                 = $politica_desar;

        return view('administrador.pdu.objetivos_estrategicos',$data);
    }

    //guardar objetivos estrategicos
    public function obj_estrategico_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(),[
                'politica_desarrollo'=>'required',
            ]);
            if($validar->fails()){
                $data=mensaje_array('errores', $validar->errors());
            }else{
                $descripcion_repetidor = json_decode(json_encode($request->repetir_obj_estrategicos));
                if($descripcion_repetidor != NULL){
                    $contar_array = count($descripcion_repetidor);
                    if($contar_array >= minimo_agregar()){
                        if($contar_array <= maximo_agregar()){
                            foreach($descripcion_repetidor as $listar){
                                if($listar->descripcion != ''){
                                    $objetivos_estrategicos                         = new Objetivo_estrategico;
                                    $objetivos_estrategicos->id_politica_desarrollo = $request->politica_desarrollo;
                                    $objetivos_estrategicos->codigo                 = $listar->codigo;
                                    $objetivos_estrategicos->descripcion            = $listar->descripcion;
                                    $objetivos_estrategicos->save();
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

    //eliminar objetivo estrategico
    public function obj_estrategico_eliminar(Request $request){
        if($request->ajax()){
            try {
                $objetivos_estrategicos = Objetivo_estrategico::find($request->id);
                if($objetivos_estrategicos->delete()){
                    $data = mensaje_array('success','Se elimino con éxito');
                }else{
                    $data = mensaje_array('success','Ocurrio un error al eliminar');
                }
            } catch (\Exception $e) {
                $data = mensaje_array('success','Ocurrio un error al eliminar, '.$e->getMessage());
            }
            return response()->json($data, 200);
        }
    }

    //para editar el objetivo estrategico
    public function obj_estrategico_editar(Request $request){
        if($request->ajax()){
            $objetivos_estrategicos = Objetivo_estrategico::find($request->id);
            $objetivos_estrategicos->relacion_inversa_objetivo_estrategico_pol_desarrollo;
            if($objetivos_estrategicos){
                $data=mensaje_array('success',$objetivos_estrategicos);
            }else{
                $data=mensaje_array('error','Ocurrio un error al editar!');
            }
            return response()->json($data, 200);
        }
    }

    //para guardar el objetivo estrategoico editado
    public function obj_estrategico_editar_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(),[
                'codigo_'       => 'required',
                'descripcion_'  => 'required',
            ]);
            if($validar->fails()){
                $data=mensaje_array('errores', $validar->errors());
            }else{
                $objetivos_estrategicos              = Objetivo_estrategico::find($request->id_obj_estrategico);
                $objetivos_estrategicos->codigo      = $request->codigo_;
                $objetivos_estrategicos->descripcion = $request->descripcion_;
                $objetivos_estrategicos->save();
                if($objetivos_estrategicos->id){
                    $data=mensaje_array('success','Se edito con éxito!');
                }else{
                    $data=mensaje_array('error','Ocurrio un error al editar!');
                }
            }
            return response()->json($data, 200);
        }
    }
    /**
     * OBJETIVO ESTRATEGICO
    */
}
