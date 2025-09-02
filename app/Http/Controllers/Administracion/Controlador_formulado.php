<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Clasificador\Clasificador_primero;
use App\Models\Configuracion\Formulado_tipo;
use App\Models\Configuracion\Partida_tipo;
use App\Models\Configuracion_poa\Configuracion_formulado;
use Illuminate\Http\Request;
use App\Models\Gestion;
use Illuminate\Support\Facades\Validator;

class Controlador_formulado extends Controller
{
    public function habilitar_formulado(){
        $data['menu']       = 12;
        $data['gestion']    = Gestion::where('estado', 'activo')->get();
        return view('administrador.configuracion_poa.habilitar_formulado', $data);
    }
    //para verificar el tipo de formulado y el tipo de partida
    public function verificar_formuladoPartida(Request $request){
        if($request->ajax()){
            $id_gestiones       = $request->id;
            $data['formulado']  = Formulado_tipo::with(['configuracion_formulado'=>function($query) use ($id_gestiones){
                $query->where('gestiones_id', $id_gestiones );
            }])
            ->where('estado', 'like','activo')
            ->get();

            $data['partida_tipo'] = Partida_tipo::with(['configuracion_formulado'=> function($query) use ($id_gestiones){
                $query->where('gestiones_id', $id_gestiones );
            }])
            ->where('estado', 'like','activo')
            ->get();

            return response()->json($data);
        }
    }
    //para mostrar los anteriores formulados segun la gestion especifica
    public function mostrar_formulado_anterior(Request $request){
        if($request->ajax()){
            $id_gestiones                           = $request->id;
            $data['configuracion_formulado_lis']    = Configuracion_formulado::with('formulado_tipo','partida_tipo', 'clasificador_primero')
                                                    ->where('gestiones_id', $id_gestiones)
                                                    ->get();
            return view('administrador.configuracion_poa.formulado.listar_formuladoAnt', $data);
        }
    }
    //para mostrar el clasificador
    public function mostrar_clasificador(Request $request){
        if($request->ajax()){
            $id_gestiones           = $request->id_gestiones;
            $data['clasificadores'] = Clasificador_primero::with(['configuracion_formulado'=> function($query) use ($id_gestiones){
                $query->where('gestiones_id', $id_gestiones);
            }])
            ->where('estado', 'activo')
            ->get();
            return view('administrador.configuracion_poa.formulado.listar_clasificadores', $data);
        }
    }
    //para guardar el habilitar reformulado
    public function guardar_conFormulado(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'gestion'               => 'required',
                'gestion_especifica'    => 'required',
                'tipo_formulado'        => 'required',
                'tipo_partida'          => 'required',
                'fecha_inicial'         => 'required',
                'fecha_final'           => 'required',
                'codigo'                => 'required|numeric|min:4',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                //aqui guardamos configuracion formulado
                $configuracion_formulado                = new Configuracion_formulado;
                $configuracion_formulado->fecha_inicial = $request->fecha_inicial;
                $configuracion_formulado->fecha_final   = $request->fecha_final;
                $configuracion_formulado->gestiones_id  = $request->gestion_especifica;
                $configuracion_formulado->formulado_id  = $request->tipo_formulado;
                $configuracion_formulado->codigo        = $request->codigo;
                $configuracion_formulado->save();
                //para guardar en conform_clasprim_partipo

                //$partida_tipo = Partida_tipo::find($request->tipo_partida);
                $configuracion_formulado->clasificador_primero()->attach($request->clasificadores, ['partida_tid' => $request->tipo_partida]);

                $data=mensaje_array('success', 'Se guardo con éxito');

            }
            return response()->json($data, 200);
        }
    }

    //para editar el formulado
    public function editarFormulado(Request $request){
        if($request->ajax()){
            $configuracion_formulado = Configuracion_formulado::find($request->id);
            if($configuracion_formulado){
                $data = mensaje_array('success', $configuracion_formulado);
            }else{
                $data = mensaje_array('error', 'No se econtro el registro');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar la configuracion lo editado
    public function editarFormuladoGuardar(Request $request){
        if($request->ajax()){
            $validar = Validator::make($request->all(), [
                'fecha_inicial_'         => 'required',
                'fecha_final_'           => 'required',
                'codigo_'                => 'required|numeric|min:4',
            ]);
            if($validar->fails()){
                $data = mensaje_array('errores',$validar->errors());
            }else{
                $configuracion_formulado                = Configuracion_formulado::find($request->id_configForm);
                $configuracion_formulado->fecha_inicial = $request->fecha_inicial_;
                $configuracion_formulado->fecha_final   = $request->fecha_final_;
                $configuracion_formulado->codigo        = $request->codigo_;
                $configuracion_formulado->save();
                if($configuracion_formulado->id){
                    $data = mensaje_array('success', 'Se edito con éxito!');
                }else{
                    $data = mensaje_array('error', 'Ocurrio un problema al editar ');
                }
            }
            return response()->json($data);
        }
    }

}
