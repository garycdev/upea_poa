<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use Illuminate\Support\Facades\Validator;
use App\Models\Configuracion\UnidadCarreraArea;

class Controlador_carrera extends Controller
{
    public function cua_admin(){
        $data['menu']           = '10';
        $data['listar_tipo_c']  = Tipo_CarreraUnidad::orderBy('id','asc')->get();
        return view('administrador.cua_admin.cua',$data);
    }
    //para guardar el tipo de de carrera unidada o area
    public function cua_adminGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'titulo'=>'required|unique:rl_tipo_carrera,nombre',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $tipo_carrera           = new Tipo_CarreraUnidad;
                $tipo_carrera->nombre   = $request->titulo;
                $tipo_carrera->save();
                if($tipo_carrera->id){
                    $data = mensaje_array('success','Se guardo con éxito el tipo!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al insertar los datos');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para editar el registro
    public function cua_adminEditar(Request $request){
        if($request->ajax()){
            $tipo_carrera = Tipo_CarreraUnidad::find($request->id);
            if($tipo_carrera){
                $data = mensaje_array('success', $tipo_carrera);
            }else{
                $data = mensaje_array('error', 'Ocurrio un error intentar editar');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar el registro editado
    public function cua_adminEguardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'titulo_'=>'required|unique:rl_tipo_carrera,nombre,'.$request->id_tipoCarrera,
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $tipo_carrera           = Tipo_CarreraUnidad::find($request->id_tipoCarrera);
                $tipo_carrera->nombre   = $request->titulo_;
                $tipo_carrera->save();
                if($tipo_carrera->id){
                    $data = mensaje_array('success','Se editó con éxito el tipo!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al editar los datos');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para listar la parte de las carreras y todo
    public function cua_adminlistar($id){
        $id_descript        = desencriptar($id);
        $tipo               = Tipo_CarreraUnidad::find($id_descript);
        $listado = UnidadCarreraArea::where('id_tipo_carrera', $id_descript)
                        ->orderBy('id', 'asc')
                        ->get();
        $data['menu']       = '10';
        $data['tipo']       = $tipo;
        $data['listado']    = $listado;
        return view('administrador.cua_admin.listado_todo', $data);
    }
    //para listar la parte de carreras o unidades administrativas
    public function cua_carrera_adminListar(Request $request){
        if($request->ajax()){
            $data['listado_ca'] = UnidadCarreraArea::where('id_tipo_carrera', $request->id_tipo)
                        ->orderBy('id', 'asc')
                        ->get();
            return response()->json($data, 200);

        }
    }
    //para guardar
    public function cua_carrera_adminGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'nombre_completo'=>'required|unique:rl_unidad_carrera,nombre_completo',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores', $validar->errors());
            }else{
                $unidad_carrera                   = new UnidadCarreraArea;
                $unidad_carrera->nombre_completo  = $request->nombre_completo;
                $unidad_carrera->estado           = 'activo';
                $unidad_carrera->id_tipo_carrera  = $request->id_tipo;
                $unidad_carrera->save();
                if($unidad_carrera->id){
                    $data = mensaje_array('success','Se guardo con éxito');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al guardar');
                }
            }
            return response()->json($data, 200);
        }
    }
    //para cambiar el estado
    public function cua_carrera_adminEstado(Request $request){
        if($request->ajax()){
            $unidad_carrera         = UnidadCarreraArea::find($request->id);
            $estado = $unidad_carrera->estado=='activo'?'inactivo':'activo';
            $unidad_carrera->estado = $estado;
            $unidad_carrera->save();
            if($unidad_carrera->id){
                $data = mensaje_array('success', 'Se cambio el estado con éxito');
            }else{
                $data = mensaje_array('error', 'Ocurrio un error al cambiar el estado');
            }
            return response()->json($data, 200);
        }
    }
    //para editar el registro
    public function cua_carrera_adminEditar(Request $request){
        if($request->ajax()){
            $unidad_carrera = UnidadCarreraArea::find($request->id);
            if($unidad_carrera){
                $data = mensaje_array('success', $unidad_carrera);
            }else{
                $data = mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function cua_carrera_adminEguardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'nombre_completo_'=>'required|unique:rl_unidad_carrera,nombre_completo,'.$request->id_carreraUnidad,
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores', $validar->errors());
            }else{
                $unidad_carrera                   = UnidadCarreraArea::find($request->id_carreraUnidad);
                $unidad_carrera->nombre_completo  = $request->nombre_completo_;
                $unidad_carrera->save();
                if($unidad_carrera->id){
                    $data = mensaje_array('success','Se edito con éxito!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un error al guardar lo editado!');
                }
            }
            return response()->json($data, 200);
        }
    }
}
