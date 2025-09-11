<?php
namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Areas_estrategicas;
use App\Models\Configuracion\Categoria;
use App\Models\Configuracion\Programa_proyecto_accion_e;
use App\Models\Configuracion\Resultado_producto;
use App\Models\Configuracion\Tipo;
use App\Models\Configuracion\Tipo_programa_acc;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestion;
use App\Models\Pdes\Pdes_articulacion;
use App\Models\Pdu\Objetivo_estrategico;
use App\Models\Pdu\Politica_desarrollo;
use App\Models\Pei\Indicador;
use App\Models\Pei\Matriz_planificacion;
use App\Models\Pei\Objetivo_estrategico_sub;
use App\Models\Pei\Objetivo_institucional;
use App\Models\Pei\Tipo_foda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Controlador_Pei extends Controller
{
    //para el PEI //num 2
    public $tipo_plan = 2;

    public $tipo_pdu = 1;
    public $tipo_pei = 2;

    //id tipo carrera o unidad o area
    public $id_tipo_unidad = 2;

    public function pei($id)
    {
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
        return view('administrador.pei.pei', $data);
    }

    /**
     * PARTE DE POLITICAS INSITITUCIONALES
     */
    public function listar_politica_institucional(Request $request)
    {
        if ($request->ajax()) {
            $areas_estrategicas  = Areas_estrategicas::find($request->id);
            $politica_desarrollo = $areas_estrategicas->relacion_politica_desarrollo()->where('id_tipo_plan', $this->tipo_plan)->get();
            if ($politica_desarrollo) {
                $data = mensaje_array('success', $politica_desarrollo);
            } else {
                $data = mensaje_array('error', 'No existe registros aun');
            }
            return response()->json($data, 200);
        }
    }

    //para guardar la politica_institucional
    public function politica_institucional_guardar(Request $request)
    {
        $validar = Validator::make($request->all(), [
            'codigo'      => 'required',
            'descripcion' => 'required',
        ]);
        if ($validar->fails()) {
            $data = mensaje_array('errores', $validar->errors());
        } else {
            if ($request->id_politica_institucional != '') {
                $politica_desarrollo              = Politica_desarrollo::find($request->id_politica_institucional);
                $politica_desarrollo->codigo      = $request->codigo;
                $politica_desarrollo->descripcion = $request->descripcion;
                if ($politica_desarrollo->save()) {
                    $data = [
                        'tipo'                => 'success',
                        'mensaje'             => 'Se editó con éxito!',
                        'id_area_estrategica' => $request->id_area_estrategica,
                    ];
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al editar');
                }
            } else {
                $politica_desarrollo                      = new Politica_desarrollo;
                $politica_desarrollo->codigo              = $request->codigo;
                $politica_desarrollo->descripcion         = $request->descripcion;
                $politica_desarrollo->id_area_estrategica = $request->id_area_estrategica;
                $politica_desarrollo->id_tipo_plan        = $this->tipo_plan;
                if ($politica_desarrollo->save()) {
                    $data = [
                        'tipo'                => 'success',
                        'mensaje'             => 'Se guardo con éxito!',
                        'id_area_estrategica' => $request->id_area_estrategica,
                    ];
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al guardar');
                }
            }
        }
        return response()->json($data, 200);
    }

    //para eliminar la politica instituciales
    public function politica_institucional_eliminar(Request $request)
    {
        if ($request->ajax()) {
            try {
                $politica_desarrollo = Politica_desarrollo::find($request->id);
                if ($politica_desarrollo->delete()) {
                    $data = mensaje_array('success', 'Se eliminó con éxito!');
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
                }
            } catch (\Throwable $th) {
                $data = mensaje_array('error', 'Ocurrio un error al eliminar!');
            }
            return response()->json($data, 200);
        }
    }

    //par aeditar la politica institucional
    public function politica_institucional_editar(Request $request)
    {
        if ($request->ajax()) {
            $politica_desarrollo = Politica_desarrollo::find($request->id);
            if ($politica_desarrollo) {
                $data = mensaje_array('success', $politica_desarrollo);
            } else {
                $data = mensaje_array('error', 'No se encontro el registro');
            }
            return response()->json($data, 200);
        }
    }
    /**
     * FIN PARTE DE POLITICAS INSITITUCIONALES
     */

    /**
     * OBJETIVO ESTRATEGICO SUB
     */
    public function objetivo_estrategico_sub($id)
    {
        $id_desencriptado           = desencriptar($id);
        $areas_estrategica          = Areas_estrategicas::find($id_desencriptado);
        $gestion                    = $areas_estrategica->reversa_relacion_areas_estrategicas;
        $data['areas_estrategicas'] = $areas_estrategica;
        $data['gestion']            = $gestion;

        $politica_institucional = $areas_estrategica->relacion_politica_desarrollo()
            ->where('id_tipo_plan', $this->tipo_plan)
            ->get();

        $politica_desar = Politica_desarrollo::with('relacion_objetivo_estrategico_sub')
            ->where('id_tipo_plan', $this->tipo_plan)
            ->where('id_area_estrategica', $areas_estrategica->id)
            ->get();
        /* $resultados = Areas_estrategicas::with(['relacion_politica_desarrollo' => function($query1) {
            $query1->where('id_tipo_plan', $this->tipo_plan)
                    ->with('relacion_objetivo_estrategico');
        }])->find($id_desencriptado); */

        $relacion_pol_institucional = Politica_desarrollo::with('relacion_objetivo_estrategico_sub.relacion_objetivo_institucional')
            ->where('id_tipo_plan', $this->tipo_plan)
            ->where('id_area_estrategica', $areas_estrategica->id)
            ->get();

        $data['listar']                        = $politica_desar;
        $data['menu']                          = "5";
        $data['politica_institucional']        = $politica_institucional;
        $data['listar_politica_institucional'] = $relacion_pol_institucional;
        return view('administrador.pei.objetivo_sub_institucional', $data);
    }

    //guardar los objetivos institucionales sub
    public function obj_estrategico_sub_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'politica_institucional' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                $descripcion_repetidor = json_decode(json_encode($request->repetir_obj_estrategicos_sub));
                if ($descripcion_repetidor != null) {
                    $contar_array = count($descripcion_repetidor);
                    if ($contar_array >= minimo_agregar()) {
                        if ($contar_array <= maximo_agregar()) {
                            foreach ($descripcion_repetidor as $listar) {
                                if ($listar->descripcion != '') {
                                    $objetivos_estrategicos                         = new Objetivo_estrategico_sub;
                                    $objetivos_estrategicos->id_politica_desarrollo = $request->politica_institucional;
                                    $objetivos_estrategicos->codigo                 = $listar->codigo;
                                    $objetivos_estrategicos->descripcion            = $listar->descripcion;
                                    $objetivos_estrategicos->save();
                                }
                                $data = mensaje_array('success', 'Se guardo con exito');
                            }
                        } else {
                            $data = mensaje_array('error', 'Solo puede guardar ' . maximo_agregar() . ' de registros');
                        }
                    } else {
                        $data = mensaje_array('error', 'Debe contener al menos' . minimo_agregar() . ' registro');
                    }
                } else {
                    $data = mensaje_array('error', 'No se encontro ningun registro');
                }
            }
            return response()->json($data, 200);
        }
    }

    //eliminar objetivo estrategico de la SUB
    public function obj_estrategico_sub_eliminar(Request $request)
    {
        if ($request->ajax()) {
            try {
                $objetivos_estrategicos_sub = Objetivo_estrategico_sub::find($request->id);
                if ($objetivos_estrategicos_sub->delete()) {
                    $data = mensaje_array('success', 'Se elimino con éxito');
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al eliminar');
                }
            } catch (\Exception $e) {
                $data = mensaje_array('error', 'Ocurrio un error al eliminar, ' . $e->getMessage());
            }
            return response()->json($data, 200);
        }
    }

    //para editar objetivo estrategico de la SUB
    public function obj_estrategico_sub_editar(Request $request)
    {
        if ($request->ajax()) {
            $objetivos_estrategicos = Objetivo_estrategico_sub::find($request->id);
            $objetivos_estrategicos->reversa_politica_desarrollo;
            if ($objetivos_estrategicos) {
                $data = mensaje_array('success', $objetivos_estrategicos);
            } else {
                $data = mensaje_array('error', 'Ocurrio un error al editar!');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar objetivo estrategico de la SUB
    public function obj_estrategico_sub_editar_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'codigo_'      => 'required',
                'descripcion_' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                $objetivos_estrategicos              = Objetivo_estrategico_sub::find($request->id_obj_estrategico_sub);
                $objetivos_estrategicos->codigo      = $request->codigo_;
                $objetivos_estrategicos->descripcion = $request->descripcion_;
                $objetivos_estrategicos->save();
                if ($objetivos_estrategicos->id) {
                    $data = mensaje_array('success', 'Se edito con éxito!');
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al editar!');
                }
            }
            return response()->json($data, 200);
        }
    }

    //Mostrar todos los de sub del la politica institucional
    public function obj_estrategico_sub_mostrar(Request $request)
    {
        if ($request->ajax()) {
            $politica_desarrollo = Politica_desarrollo::with('relacion_objetivo_estrategico_sub')->find($request->id);
            if ($politica_desarrollo) {
                $data = mensaje_array('success', $politica_desarrollo);
            } else {
                $data = mensaje_array('error', 'No existe ningun registro');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar los objetivos institucionales
    public function obj_institucionales_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'politica_institucional_'  => 'required',
                'objetivo_estrategico_sub' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                $descripcion_repetidor = json_decode(json_encode($request->repetir_obj_institucionales));
                if ($descripcion_repetidor != null) {
                    $contar_array = count($descripcion_repetidor);
                    if ($contar_array >= minimo_agregar()) {
                        if ($contar_array <= maximo_agregar()) {
                            foreach ($descripcion_repetidor as $listar) {
                                if ($listar->descripcion != '') {
                                    $objetivo_institucional                              = new Objetivo_institucional;
                                    $objetivo_institucional->codigo                      = $listar->codigo;
                                    $objetivo_institucional->descripcion                 = $listar->descripcion;
                                    $objetivo_institucional->id_objetivo_estrategico_sub = $request->objetivo_estrategico_sub;
                                    $objetivo_institucional->save();
                                }
                                $data = mensaje_array('success', 'Se guardo con exito');
                            }
                        } else {
                            $data = mensaje_array('error', 'Solo puede guardar ' . maximo_agregar() . ' de registros');
                        }
                    } else {
                        $data = mensaje_array('error', 'Debe contener al menos' . minimo_agregar() . ' registro');
                    }
                } else {
                    $data = mensaje_array('error', 'No se encontro ningun registro');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para eliminar un objetivo institucional
    public function obj_institucionales_eliminar(Request $request)
    {
        if ($request->ajax()) {
            try {
                $objetivos_institucional = Objetivo_institucional::find($request->id);
                if ($objetivos_institucional->delete()) {
                    $data = mensaje_array('success', 'Se elimino con éxito');
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al eliminar');
                }
            } catch (\Exception $e) {
                $data = mensaje_array('error', 'Ocurrio un error al eliminar, ' . $e->getMessage());
            }
            return response()->json($data, 200);
        }
    }

    //para editar el objetivo institucional
    public function obj_institucionales_editar(Request $request)
    {
        if ($request->ajax()) {
            $objetivos_institucional = Objetivo_institucional::with('reversa_objetivo_estrategico_sub.reversa_politica_desarrollo')->find($request->id);
            if ($objetivos_institucional) {
                $data = mensaje_array('success', $objetivos_institucional);
            } else {
                $data = mensaje_array('error', 'Ocurrio un error al editar!');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado
    public function obj_institucionales_editar_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'codigo_i'      => 'required',
                'descripcion_i' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                $objetivo_institucional              = Objetivo_institucional::find($request->id_obj_institucional);
                $objetivo_institucional->codigo      = $request->codigo_i;
                $objetivo_institucional->descripcion = $request->descripcion_i;
                $objetivo_institucional->save();
                if ($objetivo_institucional->id) {
                    $data = mensaje_array('success', 'Se edito con éxito!');
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al editar!');
                }
            }
            return response()->json($data, 200);
        }
    }
    /**
     *
     */

    /**
     * MATRIZ DE PLANIFICACION
     */

    public function matriz($id)
    {
        $id_desencriptado            = desencriptar($id);
        $areas_estrategica           = Areas_estrategicas::find($id_desencriptado);
        $gestion                     = $areas_estrategica->reversa_relacion_areas_estrategicas;
        $gestion_id                  = $gestion->id;
        $pdes                        = Pdes_articulacion::where('id_gestion', '=', $gestion_id)->get();
        $data['areas_estrategicas']  = $areas_estrategica;
        $data['gestion']             = $gestion;
        $data['menu']                = 5;
        $data['pdes']                = $pdes;
        $data['gestion_id']          = $gestion_id;
        $data['id_area_estrategica'] = $id_desencriptado;

        //para listar PDU
        $data['politica_desarrollo'] = $areas_estrategica->relacion_politica_desarrollo()
            ->where('id_tipo_plan', $this->tipo_pdu)
            ->get();
        $data['objetivos_estrategicos'] = Objetivo_estrategico::join('rl_politica_de_desarrollo as pdd', 'pdd.id', '=', 'rl_objetivo_estrategico.id_politica_desarrollo')
            ->where('pdd.id_tipo_plan', $this->tipo_pdu)
            ->where('pdd.id_area_estrategica', $id_desencriptado)
            ->select('rl_objetivo_estrategico.*', 'pdd.descripcion as politica_desarrollo_descripcion', 'pdd.id as politica_desarrollo_id')
            ->get();

        //para listar PDU
        $data['politica_institucional'] = $areas_estrategica->relacion_politica_desarrollo()
            ->where('id_tipo_plan', $this->tipo_pei)
            ->get();
        $data['objetivos_estrategicos_institucionales'] = Objetivo_institucional::join('rl_objetivo_estrategico_sub as oes', 'oes.id', '=', 'rl_objetivo_institucional.id_objetivo_estrategico_sub')
            ->join('rl_politica_de_desarrollo as pdd', 'pdd.id', '=', 'oes.id_politica_desarrollo')
            ->where('pdd.id_tipo_plan', $this->tipo_pei)
            ->where('pdd.id_area_estrategica', $id_desencriptado)
            ->select('rl_objetivo_institucional.*', 'oes.id as oes_id', 'oes.descripcion as oes_descripcion', 'pdd.id as pdd_id', 'pdd.descripcion as pdd_descripcion')
            ->get();
        // dd($data['objetivos_estrategicos_institucionales']);





        

        //para listar los indicadores estrategicos
        $gestion_lis         = Gestion::find($gestion_id);
        $indicadores         = $gestion_lis->relacion_indicador()->where('estado', 'inactivo')->get();
        $indicador_e         = $gestion_lis->relacion_indicador()->get();
        $gestiones           = $gestion_lis->relacion_gestiones;
        $data['indicador']   = $indicadores;
        $data['indicador_e'] = $indicador_e;
        $data['tipo']        = Tipo::get();
        $data['categoria']   = Categoria::get();
        $data['gestiones']   = $gestiones;

        $data['porgrama_proy_acc'] = Tipo_programa_acc::get();
        $data['unidades']          = UnidadCarreraArea::where('estado', 'like', 'activo')
            ->where('id_tipo_carrera', $this->id_tipo_unidad)
            ->get();

        //para listar la matriz
        $data['matriz_p'] = Matriz_planificacion::with('unidades_administrativas_inv', 'unidades_administrativas_res', 'objetivo_estrategico', 'objetivo_estrategico_sub', 'objetivo_institucional', 'politica_desarrollo_pei', 'politica_desarrollo_pdu', 'indicador_pei', 'tipo', 'categoria', 'resultado_producto', 'programa_proyecto_accion')
            ->where('id_area_estrategica', $id_desencriptado)
            ->orderBy('codigo', 'asc')
            ->get();

        return view('administrador.pei.matriz', $data);
    }

    //para listar los objetivo estrategicos
    public function matriz_obj_estrategico(Request $request)
    {
        if ($request->ajax()) {
            $politica_desarrollo  = Politica_desarrollo::find($request->id);
            $obj_estrategicos_pdu = $politica_desarrollo->relacion_objetivo_estrategico;
            if ($obj_estrategicos_pdu) {
                $data = mensaje_array('success', $obj_estrategicos_pdu);
            } else {
                $data = mensaje_array('error', 'Ocurrio un error');
            }
            return response()->json($data, 200);
        }
    }

    //para listar los objetivos estrategicos de la SUB
    public function matriz_obj_estrategico_sub(Request $request)
    {
        if ($request->ajax()) {
            $politica_desarrollo        = Politica_desarrollo::find($request->id);
            $objetivos_estrategicos_sub = $politica_desarrollo->relacion_objetivo_estrategico_sub;
            if ($objetivos_estrategicos_sub) {
                $data = mensaje_array('success', $objetivos_estrategicos_sub);
            } else {
                $data = mensaje_array('error', 'No se encontro los datos');
            }
            return response()->json($data, 200);
        }
    }

    //para lisatr los objetivos institucionales
    public function matriz_obj_estrategico_institucional(Request $request)
    {
        if ($request->ajax()) {
            $objetivos_estrategicos_sub = Objetivo_estrategico_sub::find($request->id);
            $objetivos_institucionales  = $objetivos_estrategicos_sub->relacion_objetivo_institucional;
            if ($objetivos_institucionales) {
                $data = mensaje_array('success', $objetivos_institucionales);
            } else {
                $data = mensaje_array('error', 'No se encontro los datos');
            }
            return response()->json($data, 200);
        }
    }

    //parea guardar la matriz de planificacion
    public function matriz_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'codigo_matriz'                          => 'required',
                'politica_desarrollo_pdu'                => 'required',
                'objetivo_estrategico_pdu'               => 'required',
                'politica_institucional_pei'             => 'required',
                'objetivo_estrategico_sub'               => 'required',
                //'objetivo_estrategico_institucional'=>'required',
                'indicador_estrategico'                  => 'required',
                'tipo'                                   => 'required',
                'categoria'                              => 'required',
                'codigo_resultado_producto'              => 'required',
                'descripcion_resultado_producto'         => 'required',
                'linea_base'                             => 'required',
                // 'gestion_1'                              => 'required',
                // 'gestion_2'                              => 'required',
                // 'gestion_3'                              => 'required',
                // 'gestion_4'                              => 'required',
                // 'gestion_5'                              => 'required',
                'meta_mediano_plazo'                     => 'required',
                // 'programa_accion_estrategica'            => 'required',
                // 'descripcion_progrma_accion_estrategica' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                $resultado_producto              = new Resultado_producto;
                $resultado_producto->codigo      = $request->codigo_resultado_producto;
                $resultado_producto->descripcion = $request->descripcion_resultado_producto;
                $resultado_producto->save();

                $programa_proy_accion_estrategica                   = new Programa_proyecto_accion_e;
                $programa_proy_accion_estrategica->descripcion      = $request->descripcion_progrma_accion_estrategica ?? '-';
                $programa_proy_accion_estrategica->id_tipo_prog_acc = $request->programa_accion_estrategica ?? 1;
                $programa_proy_accion_estrategica->save();

                $indicador         = Indicador::find($request->indicador_estrategico);
                $indicador->estado = 'activo';
                $indicador->save();

                $matriz_plan                        = new Matriz_planificacion;
                $matriz_plan->codigo                = $request->codigo_matriz;
                $matriz_plan->id_area_estrategica   = $request->id_area_estrategica;
                $matriz_plan->id_indicador          = $request->indicador_estrategico;
                $matriz_plan->id_tipo               = $request->tipo;
                $matriz_plan->id_categoria          = $request->categoria;
                $matriz_plan->id_resultado_producto = $resultado_producto->id;
                $matriz_plan->linea_base            = $request->linea_base;
                $matriz_plan->gestion_1             = $request->gestion_1 ?? '-';
                $matriz_plan->gestion_2             = $request->gestion_2 ?? '-';
                $matriz_plan->gestion_3             = $request->gestion_3 ?? '-';
                $matriz_plan->gestion_4             = $request->gestion_4 ?? '-';
                $matriz_plan->gestion_5             = $request->gestion_5 ?? '-';
                $matriz_plan->meta_mediano_plazo    = $request->meta_mediano_plazo;
                $matriz_plan->id_programa_proy      = $programa_proy_accion_estrategica->id;
                $matriz_plan->save();

                $matriz = Matriz_planificacion::find($matriz_plan->id);
                $matriz->unidades_administrativas_inv()->attach($request->unidades_involucradas);
                $matriz->unidades_administrativas_res()->attach($request->unidades_responsables);
                $matriz->objetivo_estrategico()->attach($request->objetivo_estrategico_pdu);
                $matriz->objetivo_estrategico_sub()->attach($request->objetivo_estrategico_sub);
                $matriz->objetivo_institucional()->attach($request->objetivo_estrategico_institucional);
                $matriz->politica_desarrollo_pei()->attach($request->politica_institucional_pei);
                $matriz->politica_desarrollo_pdu()->attach($request->politica_desarrollo_pdu);
                $data = mensaje_array('success', 'Se guardo con exito');
            }

            return response()->json($data, 200);
        }
    }

    //para editar matriz de planificacion
    public function matriz_editar(Request $request)
    {
        if ($request->ajax()) {
            $matriz           = Matriz_planificacion::with('unidades_administrativas_inv', 'unidades_administrativas_res', 'objetivo_estrategico', 'objetivo_estrategico_sub', 'objetivo_institucional', 'politica_desarrollo_pei', 'politica_desarrollo_pdu', 'indicador_pei', 'tipo', 'categoria', 'resultado_producto', 'programa_proyecto_accion')->find($request->id);
            $data['matriz_e'] = $matriz;
            //para el objetivo estrategico del PDU
            $data['objetivo_estrategico_e'] = Objetivo_estrategico::where('id_politica_desarrollo', $matriz->politica_desarrollo_pdu[0]->id)->get();
            //pra el objetivo estrategico de SUB
            $data['objetivo_estrategico_sub_e'] = Objetivo_estrategico_sub::where('id_politica_desarrollo', $matriz->politica_desarrollo_pei[0]->id)->get();
            //prra el objetivo institucional
            $data['objetivo_institucional_e'] = Objetivo_institucional::where('id_objetivo_estrategico_sub', $matriz->objetivo_estrategico_sub[0]->id)->get();

            $id_get      = $matriz->indicador_pei->id;
            $gestion_lis = Gestion::find($request->id_ges);
            $indicador_e = $gestion_lis->relacion_indicador()->where('estado', 'like', 'inactivo')
                ->orWhere(function ($query) use ($id_get) {
                    $query->where('estado', 'like', 'activo')
                        ->where('id', '=', $id_get);
                })->orderBy('codigo', 'desc')->get();
            $data['indicador_e'] = $indicador_e;
            if ($matriz) {
                $data = mensaje_array('success', $data);
            } else {
                $data = mensaje_array('eror', 'No se econtro el registro');
            }
            return response()->json($data, 200);
        }
    }

    //para guardar lo editado de la matriz de planificacion
    public function matriz_editar_guardar(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'codigo_matriz_e'                          => 'required',
                'politica_desarrollo_pdu_e'                => 'required',
                'objetivo_estrategico_pdu_e'               => 'required',
                'politica_institucional_pei_e'             => 'required',
                'objetivo_estrategico_sub_e'               => 'required',
                //'objetivo_estrategico_institucional_e'=>'required',
                'indicador_estrategico_e'                  => 'required',
                'tipo_e'                                   => 'required',
                'categoria_e'                              => 'required',
                'codigo_resultado_producto_e'              => 'required',
                'descripcion_resultado_producto_e'         => 'required',
                'linea_base_e'                             => 'required',
                'gestion_1_e'                              => 'required',
                'gestion_2_e'                              => 'required',
                'gestion_3_e'                              => 'required',
                'gestion_4_e'                              => 'required',
                'gestion_5_e'                              => 'required',
                'meta_mediano_plazo_e'                     => 'required',
                'programa_accion_estrategica_e'            => 'required',
                'descripcion_progrma_accion_estrategica_e' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                //primero cambiamos el estado del indicador del anterior
                $indicador_ant         = Indicador::find($request->indicador_ant);
                $indicador_ant->estado = 'inactivo';
                $indicador_ant->save();
                //ahora el nuevo indicador le cambiamos el estado
                $indicador_new         = Indicador::find($request->indicador_estrategico_e);
                $indicador_new->estado = 'activo';
                $indicador_new->save();
                //ahora editamos lo que es el resultado producto
                $resultado_producto              = Resultado_producto::find($request->edi_id_resultado_producto);
                $resultado_producto->codigo      = $request->codigo_resultado_producto_e;
                $resultado_producto->descripcion = $request->descripcion_resultado_producto_e;
                $resultado_producto->save();
                //realizamos la edicion de programa proyecto actividad estrategica
                $programa_proy_acc                   = Programa_proyecto_accion_e::find($request->edi_inv_programa_proyecto_accion_estrategica);
                $programa_proy_acc->id_tipo_prog_acc = $request->programa_accion_estrategica_e;
                $programa_proy_acc->descripcion      = $request->descripcion_progrma_accion_estrategica_e;
                $programa_proy_acc->save();

                $matriz                     = Matriz_planificacion::find($request->id_matriz_plan);
                $matriz->codigo             = $request->codigo_matriz_e;
                $matriz->id_indicador       = $request->indicador_estrategico_e;
                $matriz->id_tipo            = $request->tipo_e;
                $matriz->id_categoria       = $request->categoria_e;
                $matriz->linea_base         = $request->linea_base_e;
                $matriz->gestion_1          = $request->gestion_1_e;
                $matriz->gestion_2          = $request->gestion_2_e;
                $matriz->gestion_3          = $request->gestion_3_e;
                $matriz->gestion_4          = $request->gestion_4_e;
                $matriz->gestion_5          = $request->gestion_5_e;
                $matriz->meta_mediano_plazo = $request->meta_mediano_plazo_e;
                $matriz->save();

                $matriz = Matriz_planificacion::find($request->id_matriz_plan);

                $matriz->unidades_administrativas_inv()->sync($request->unidades_involucradas_e);
                $matriz->unidades_administrativas_res()->sync($request->unidades_responsables_e);

                $matriz->objetivo_estrategico()->sync($request->objetivo_estrategico_pdu_e);
                $matriz->objetivo_estrategico_sub()->sync($request->objetivo_estrategico_sub_e);
                $matriz->objetivo_institucional()->sync($request->objetivo_estrategico_institucional_e);
                $matriz->politica_desarrollo_pei()->sync($request->politica_institucional_pei_e);
                $matriz->politica_desarrollo_pdu()->sync($request->politica_desarrollo_pdu_e);
                $data = mensaje_array('success', 'Se editó con éxito!');

            }
            return response()->json($data, 200);
        }
    }
    /**
     * FIN DE MATRIZ DE PLANIFICACIÓN
     */
}
