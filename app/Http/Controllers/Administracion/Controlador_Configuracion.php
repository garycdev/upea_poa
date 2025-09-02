<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\Formulado_tipo;
use App\Models\Configuracion\Partida_tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class Controlador_Configuracion extends Controller{
    /**
     * FUENTE DE FINANCIAMIENTO
     */
    public function fuente_de_financiamiento(){
        $data['menu'] = 6;
        return view('administrador.configuracion.financiamiento', $data);
    }
    //listar el fuente de fiananciamiento
    public function listar_fuente_de_financiamiento(){
        $data['fuente_financimiento'] = Financiamiento_tipo::orderBy('codigo', 'asc')->get();
        return response()->json($data, 200);
    }
    //para cambiar el estado de fuente de financiamiento
    public function fdfinanciamiento_estado(Request $request){
        if($request->ajax()){
            $fuente_financiamiento          = Financiamiento_tipo::find($request->id);
            $estado = $fuente_financiamiento->estado =='activo' ? 'inactivo':'activo';
            $fuente_financiamiento->estado  = $estado;
            $fuente_financiamiento->save();
            if($fuente_financiamiento->id){
                $data=mensaje_array('success', 'Se cambio el estado con éxito!');
            }else{
                $data=mensaje_array('error', 'Ocurrio un error al cambiar el estado!');
            }
            return response()->json($data, 200);
        }
    }
    //para crear nueva fuente de financiamiento
    public function fdfinanciamiento_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'sigla'         => 'required|unique:rl_financiamiento_tipo,sigla',
                'codigo'        => 'required|unique:rl_financiamiento_tipo,codigo',
                'descripcion'   => 'required'
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $fuente_financiamiento              = new Financiamiento_tipo;
                $fuente_financiamiento->sigla       = $request->sigla;
                $fuente_financiamiento->codigo      = $request->codigo;
                $fuente_financiamiento->descripcion = $request->descripcion;
                $fuente_financiamiento->estado      = 'activo';
                $fuente_financiamiento->save();
                if($fuente_financiamiento->id){
                    $data = mensaje_array('success', 'Se guardo con éxito el fuente de financiamiento');
                }else{
                    $data = mensaje_array('error', 'Se produjo un error al guardar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para editar el fuente de financiamiento
    public function fdfinanciamiento_editar(Request $request){
        if($request->ajax()){
            $fuente_financiamiento = Financiamiento_tipo::find($request->id);
            if($fuente_financiamiento){
                $data=mensaje_array('success', $fuente_financiamiento);
            }else{
                $data=mensaje_array('success', 'No se pudo procesar la solicitud');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function fdfinanciamiento_editar_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'sigla_' => 'required|unique:rl_financiamiento_tipo,sigla,'.$request->id_financiamiento,
                'codigo_'=>'required|unique:rl_financiamiento_tipo,codigo,'.$request->id_financiamiento,
                'descripcion_'=>'required'
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $fuente_financiamiento              = Financiamiento_tipo::find($request->id_financiamiento);
                $fuente_financiamiento->sigla       = $request->sigla_;
                $fuente_financiamiento->codigo      = $request->codigo_;
                $fuente_financiamiento->descripcion = $request->descripcion_;
                $fuente_financiamiento->save();
                if($fuente_financiamiento->id){
                    $data = mensaje_array('success', 'Se editó con éxito el fuente de financiamiento');
                }else{
                    $data = mensaje_array('error', 'Se produjo un error al editar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el registro
    public function fdfinanciamiento_eliminar(Request $request){
        if($request->ajax()){
            try {
                $fuente_financiamiento = Financiamiento_tipo::find($request->id);
                if($fuente_financiamiento->delete()){
                    $data=mensaje_array('success', 'Se eliminó el fuente de financiamiento con éxito!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
                }
            } catch (Exception $e) {
                $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
            }
            return response()->json($data, 200);
        }
    }
    /**
     * FIN DE FUENTE DE FINANCIAMIENTO
    */

    /**
     * TIPO DE FORMULADO
    */
    public function tipo_formulado(){
        $data['menu']=7;
        return view('administrador.configuracion.formulado', $data);
    }
    //para listar el formulado
    public function tipo_formulado_listar(){
        $data['listar_formulado'] = Formulado_tipo::orderBy('id', 'asc')->get();
        return response()->json($data, 200);
    }
    //para cambiar el estado de formulado
    public function tipo_formulado_estado(Request $request){
        if($request->ajax()){
            $formulado = Formulado_tipo::find($request->id);
            $estado = $formulado->estado=='activo'? 'inactivo':'activo';
            $formulado->estado = $estado;
            $formulado->save();
            if($formulado->id){
                $data= mensaje_array('success', 'Se cambio el estado con éxito!');
            }else{
                $data= mensaje_array('error', 'Ocurrio un error al cambiar el estado!');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el tipo de formulado
    public function tipo_formulado_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'descripcion'=>'required|max:100|unique:rl_formulado_tipo,descripcion'
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulado              = new Formulado_tipo;
                $formulado->descripcion = $request->descripcion;
                $formulado->estado      = 'activo';
                $formulado->save();
                if($formulado->id){
                    $data=mensaje_array('success', 'Se inserto el tipo de formulado con éxito!');
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error al guardar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para editar el formulado
    public function tipo_formulado_editar(Request $request){
        if($request->ajax()){
            $formulado = Formulado_tipo::find($request->id);
            if($formulado){
                $data = mensaje_array('success', $formulado);
            }else{
                $data = mensaje_array('error', 'No se pudo encontrar el registro!');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function tipo_formulado_editar_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'descripcion_'=>'required|max:100|unique:rl_formulado_tipo,descripcion,'.$request->id_formulado,
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulado              = Formulado_tipo::find($request->id_formulado);
                $formulado->descripcion = $request->descripcion_;
                $formulado->save();
                if($formulado->id){
                    $data=mensaje_array('success', 'Se editó el tipo de formulado con éxito!');
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error al editar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el tipo de formulado
    public function tipo_formulado_eliminar(Request $request){
        if($request->ajax()){
            try {
                $formulado = Formulado_tipo::find($request->id);
                if($formulado->delete()){
                    $data = mensaje_array('success', 'Se elimino el formulado con éxito!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al eliminar!');
                }
            } catch (Exception $e) {
                $data = mensaje_array('error', 'Ocurrio un problema al eliminar! ');
            }
            return response()->json($data);
        }
    }
    /**
     * FIN DE TIPO DE FORMULADO
    */

    /**
     * PARA EL TIPO DE PARTIDA
    */
    public function tipo_partida(){
        $data['menu'] = 8;
        return view('administrador.configuracion.partida', $data);
    }
    //para listar tipos de partidas
    public function tipo_partida_listar(){
        $data['tipos_partidas'] = Partida_tipo::orderBy('id','asc')->get();
        return response()->json($data, 200);
    }
    //para guardar tipo de partida
    public function tipo_partida_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'descripcion'=>'required|max:100|unique:rl_partida_tipo,descripcion'
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $formulado              = new Partida_tipo;
                $formulado->descripcion = $request->descripcion;
                $formulado->estado      = 'activo';
                $formulado->save();
                if($formulado->id){
                    $data=mensaje_array('success', 'Se inserto el tipo de partida con éxito!');
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error al guardar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para cambiar el estado
    public function tipo_partida_estado(Request $request){
        if($request->ajax()){
            $tipo_partida = Partida_tipo::find($request->id);
            $estado = $tipo_partida->estado=='activo'? 'inactivo':'activo';
            $tipo_partida->estado = $estado;
            $tipo_partida->save();
            if($tipo_partida->id){
                $data= mensaje_array('success', 'Se cambio el estado con éxito!');
            }else{
                $data= mensaje_array('error', 'Ocurrio un error al cambiar el estado!');
            }
            return response()->json($data, 200);
        }
    }
    //para editar el tipo de partida
    public function tipo_partida_editar(Request $request){
        if($request->ajax()){
            $tipo_partida = Partida_tipo::find($request->id);
            if($tipo_partida){
                $data = mensaje_array('success', $tipo_partida);
            }else{
                $data = mensaje_array('error', 'No se pudo encontrar el registro!');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function tipo_partida_editar_guardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'descripcion_'=>'required|max:100|unique:rl_partida_tipo,descripcion,'.$request->id_partida_tipo,
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $tipo_partida              = Partida_tipo::find($request->id_partida_tipo);
                $tipo_partida->descripcion = $request->descripcion_;
                $tipo_partida->save();
                if($tipo_partida->id){
                    $data=mensaje_array('success', 'Se editó el tipo de partida con éxito!');
                }else{
                    $data=mensaje_array('error', 'Ocurrio un error al editar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para eliminar el tipo de partida
    public function tipo_partida_eliminar(Request $request){
        if($request->ajax()){
            try {
                $partida = Partida_tipo::find($request->id);
                if($partida->delete()){
                    $data = mensaje_array('success', 'Se elimino la partida con éxito!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al eliminar!');
                }
            } catch (Exception $e) {
                $data = mensaje_array('error', 'Ocurrio un problema al eliminar! ');
            }
            return response()->json($data);
        }
    }
    /**
     * FIN PARA EL TIPO DE PARTIDA
    */
}
