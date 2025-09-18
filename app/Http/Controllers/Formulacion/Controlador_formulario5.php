<?php
namespace App\Http\Controllers\Formulacion;

use App\Http\Controllers\Controller;
use App\Models\Areas_estrategicas;
use App\Models\Clasificador\Detalle_cuartoClasificador;
use App\Models\Clasificador\Detalle_quintoClasificador;
use App\Models\Clasificador\Detalle_tercerClasificador;
use App\Models\Configuracion\Formulado_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestiones;
use App\Models\Poa\Asignacion_montof4;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Formulario5;
use App\Models\Poa\Historial_asignacion_monto;
use App\Models\Poa\Medida;
use App\Models\Poa\Medida_bienservicio;
use App\Models\Poa\Operacion;
use App\Models\Poa\Tipo_operacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class Controlador_formulario5 extends Controller
{
    /**
     * INICION DEL FORMULARIO Nº5
     */
    public function formulario5($formulario4_id, $tipo_formulado_id, $area_estrategica_id)
    {
        $id_formulario4      = desencriptar($formulario4_id);
        $id_tipo_formulado   = desencriptar($tipo_formulado_id);
        $id_area_estrategica = desencriptar($area_estrategica_id);
        $formulario4         = Formulario4::with(['formulario5_f4' => function ($q1) {
            $q1->with(['operacion' => function ($q2) {
                $q2->with('tipo_operacion');
            }]);
        }], ['asignacion_monto_f4' => function ($q) {
            $q->with('financiamiento_tipo');
        }])
            ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->find($id_formulario4);
        $gestiones        = Gestiones::find($formulario4->gestion_id);
        $tipo_formulado   = Formulado_tipo::find($id_tipo_formulado);
        $carrera_unidad   = UnidadCarreraArea::find(Auth::user()->id_unidad_carrera);
        $area_estrategica = Areas_estrategicas::find($id_area_estrategica);
        //operaciones de acuerdo al area estrategica
        $operaciones = $area_estrategica->operaciones;
        //listar tipo de operacion
        $tipo_operacion = Tipo_operacion::get();

        //para todo lo de demas indicadores y formulario 2
        $formulario2 = Formulario2::with('formulario1', 'indicador', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional')->find($formulario4->formulario2_id);

        $resultado = Detalle_tercerClasificador::select('id', 'titulo', DB::raw("'tercerD' as origen"))
            ->union(Detalle_cuartoClasificador::select('id', 'titulo', DB::raw("'cuartoD' as origen")))
            ->union(Detalle_quintoClasificador::select('id', 'titulo', DB::raw("'quintoD' as origen")))
            ->get();

        //para ver la medida
        $medida = Medida::get();

        $data['tipo_formulado']      = $tipo_formulado;
        $data['gestiones']           = $gestiones;
        $data['carrera_unidad']      = $carrera_unidad;
        $data['areas_estrategicas']  = $area_estrategica;
        $data['formulario4']         = $formulario4;
        $data['formulario2_detalle'] = $formulario2;
        $data['operaciones']         = $operaciones;
        $data['tipo_operacion']      = $tipo_operacion;

        $data['union_tres'] = $resultado;
        $data['medida']     = $medida;

        $data['menu'] = 13;
        return view('formulacion.formulaciones.primer_formulado.formulario5', $data);
    }
    //para guardar el fomrulario 5
    public function guardar_formulario5(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'tipo'             => 'required',
                'primer_semestre'  => 'required',
                'segundo_semestre' => 'required',
                'total'            => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                $id_operacion = '';
                if ($request->tipo == 'seleccione') {
                    $id_operacion = $request->operacion;
                } else if ($request->tipo == 'ingrese') {
                    $nuevo_operacion                      = new Operacion;
                    $nuevo_operacion->descripcion         = $request->descripcion_operacion;
                    $nuevo_operacion->area_estrategica_id = $request->area_estrategica;
                    $nuevo_operacion->tipo_operacion_id   = $request->tipo_operacion;
                    $nuevo_operacion->save();
                    $id_operacion = $nuevo_operacion->id;
                }
                //para ver la gestion
                $gestiones = Gestiones::find($request->gestiones_id);

                //ahora si para guardar el formulario 5
                $new_formulario5                     = new Formulario5;
                $new_formulario5->formulario4_id     = $request->formulario4_id;
                $new_formulario5->operacion_id       = $id_operacion;
                $new_formulario5->configFormulado_id = $request->configFormulado;
                $new_formulario5->unidadCarrera_id   = Auth::user()->id_unidad_carrera;
                $new_formulario5->areaestrategica_id = $request->area_estrategica;
                $new_formulario5->gestion_id         = $request->gestiones_id;
                $new_formulario5->primer_semestre    = $request->primer_semestre;
                $new_formulario5->segundo_semestre   = $request->segundo_semestre;
                $new_formulario5->total              = $request->total;
                $new_formulario5->desde              = date($gestiones->gestion . '-01-01');
                $new_formulario5->hasta              = date($gestiones->gestion . '-12-31');
                $new_formulario5->save();
                if ($new_formulario5->id) {
                    $data = mensaje_array('success', 'Se inserto con exito la operación del formulario Nº 5');
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al insertar');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para mostrar los datos a editar del formulario N5
    public function editar_formulario5(Request $request)
    {
        if ($request->ajax()) {
            $formulario5 = Formulario5::with(['operacion' => function ($q) {
                $q->with('tipo_operacion');
            }])
                ->find($request->id);
            if ($formulario5) {
                $data = mensaje_array('success', $formulario5);
            } else {
                $data = mensaje_array('error', 'Ocurrio un error al obtener los datos!');
            }
            return response()->json($data, 200);
        }
    }
    //para guardar lo editado en el formulario 5
    public function editar_guardar_formulario5(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'operacion_'        => 'required',
                'tipo_operacion_'   => 'required',
                'primer_semestre_'  => 'required',
                'segundo_semestre_' => 'required',
                'total_'            => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                //primero cambiamos la operación
                $operaciones                    = Operacion::find($request->operacion_);
                $operaciones->tipo_operacion_id = $request->tipo_operacion_;
                $operaciones->save();
                //ahora guardamos lo que es del formulario5
                $formulario5                   = Formulario5::find($request->formulario5_id);
                $formulario5->operacion_id     = $request->operacion_;
                $formulario5->primer_semestre  = $request->primer_semestre_;
                $formulario5->segundo_semestre = $request->segundo_semestre_;
                $formulario5->total            = $request->total_;
                $formulario5->save();
                if ($formulario5->id) {
                    $data = mensaje_array('success', 'Se édito con exito el registro!');
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error al editar');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para los clasificadores
    public function f5_buscar_clasificador(Request $request)
    {
        if ($request->ajax()) {
            $valorSeleccionado = $request->valor;
            $valoresSeparados  = explode('_', $valorSeleccionado);
            $valor1            = $valoresSeparados[0];
            $valor2            = $valoresSeparados[1];

            switch ($valor2) {
                case 'tercerD':
                    $detalle_tercerClasificador = Detalle_tercerClasificador::with(['clasificador_tercero'])->find($valor1);
                    $data                       = [
                        'tipo'          => 'success',
                        'valor_deinido' => 3,
                        'mensaje'       => $detalle_tercerClasificador,
                    ];
                    break;

                case 'cuartoD':
                    $detalle_cuarto_clasificador = Detalle_cuartoClasificador::with(['clasificador_cuarto'])->find($valor1);
                    $data                        = [
                        'tipo'          => 'success',
                        'valor_deinido' => 4,
                        'mensaje'       => $detalle_cuarto_clasificador,
                    ];
                    break;

                case 'quintoD':
                    $detalle_quinto_clasificador = Detalle_quintoClasificador::with(['clasificador_quinto'])->find($valor1);
                    $data                        = [
                        'tipo'          => 'success',
                        'valor_deinido' => 5,
                        'mensaje'       => $detalle_quinto_clasificador,
                    ];
                    break;

                default:
                    $data = mensaje_array('error', 'Ocurrio un error');
                    break;
            }
            return response()->json($data);
        }
    }

    //para la parte de listar la asignacion de montos
    public function listar_financiamientof4(Request $request)
    {
        if ($request->ajax()) {
            $formulario4 = Formulario4::with(['asignacion_monto_f4' => function ($q) {
                $q->with('financiamiento_tipo');
            }])
                ->find($request->formulario4_idf5);
            $formulario5 = Formulario5::find($request->id);

            if ($formulario4) {
                $data = [
                    'tipo'        => 'success',
                    'formulario4' => $formulario4,
                    'formulario5' => $formulario5,
                ];
            } else {
                $data = mensaje_array('error', 'Ocurrio un error!');
            }
            return response()->json($data);
        }
    }

    //para litsar la parte de los requerimnientos
    public function listar_requerimientos(Request $request)
    {
        if ($request->ajax()) {
            $data['listar_requerimiento'] = Formulario5::with(['medida_bien_serviciof5' => function ($q) {
                $q->with(['medida', 'tipo_financiamiento', 'detalle_tercer_clasificador' => function ($q1) {
                    $q1->with('clasificador_tercero');
                },
                    'detalle_cuarto_clasificador' => function ($q2) {
                        $q2->with('clasificador_cuarto');
                    },
                    'detalle_quinto_clasificador' => function ($q3) {
                        $q3->with('clasificador_quinto');
                    }]);
            }])->find($request->id);

            return view('formulacion.formulaciones.primer_formulado.operacionesFormulario.requerimientos_form5', $data);
        }
    }

    //para ver el monto asignado al indicador del form4
    public function mostrar_monto_actualAf4(Request $request)
    {
        if ($request->ajax()) {
            $asignacion_f4 = Asignacion_montof4::with('financiamiento_tipo')->find($request->id_asignacion);
            if ($asignacion_f4) {
                $data = [
                    'tipo'             => 'success',
                    'monto_asignado_c' => con_separador_comas($asignacion_f4->monto_asignado),
                    'monto_asignado_n' => $asignacion_f4->monto_asignado,
                    'financiamiento_t' => $asignacion_f4->financiamiento_tipo,
                ];
            } else {
                $data = mensaje_array('error', 'Ocurrio un error');
            }
            return response()->json($data, 200);
        }
    }

    //par alistar medida
    public function listar_medida(Request $request)
    {
        if ($request->ajax()) {
            $medida = Medida::find($request->valor);
            if ($medida) {
                $data = mensaje_array('success', $medida);
            } else {
                $data = mensaje_array('error', 'Ocurrio un error');
            }
            return response()->json($data, 200);
        }
    }
    //para vlidar montos
    public function validar_montoIngresado(Request $request)
    {
        if ($request->ajax()) {
            $monto_actual   = sin_separador_comas($request->monto_seleccionado);
            $monto_asginar  = sin_separador_comas($request->monto_validado);
            $monto_sobrante = $monto_actual - $monto_asginar;

            if ($monto_asginar > $monto_actual) {
                $data = [
                    'tipo'                 => 'error',
                    'mensaje'              => 'No puede ser mayor al monto actual de : ' . $request->monto_seleccionado . ' Bs',
                    'monto_sobrante_comas' => '',
                ];
            } else if ($monto_asginar <= $monto_actual) {
                $data = [
                    'tipo'                    => 'success',
                    'mensaje'                 => 'Puede',
                    'monto_sobrante_comas'    => con_separador_comas($monto_sobrante),
                    'monto_sobrante_sinComas' => sin_separador_comas($monto_sobrante),
                ];
            }
            return response()->json($data, 200);
        }
    }
    //para validar monto 2
    public function validar_montoIngresadoMulti(Request $request)
    {
        if ($request->ajax()) {
            $monto_seleccionado = sin_separador_comas($request->monto_seleccionado);
            $monto_validado     = sin_separador_comas($request->monto_validado);
            $inp_cantidad       = $request->inp_cantidad;

            $mutiplicado = $inp_cantidad * $monto_validado;

            $monto_sobrante = $monto_seleccionado - $mutiplicado;

            $data = [];
            if ($mutiplicado > $monto_seleccionado) {
                $data = [
                    'tipo'                 => 'error',
                    'mensaje'              => 'No puede ser mayor al monto actual de : ' . con_separador_comas($monto_seleccionado) . ' Bs',
                    'monto_sobrante_comas' => '',
                ];
            } else if ($mutiplicado <= $monto_seleccionado) {
                $data = [
                    'tipo'                    => 'success',
                    'mensaje'                 => 'Puede',
                    'multiplicado'            => con_separador_comas($mutiplicado),
                    'monto_sobrante_comas'    => con_separador_comas($monto_sobrante),
                    'monto_sobrante_sinComas' => sin_separador_comas($monto_sobrante),
                ];
            }

            return response()->json($data, 200);
        }
    }
    //para guardar los requerimientos
    public function guardar_requerimientosf5(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'tipo_financiamiento_'        => 'required',
                'clasificador_presupuestario' => 'required',
                'medida'                      => 'required',
                'mes'                         => 'required',
                'dia'                         => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {

                if ($request->monto_sobrante_presupuesto != '') {
                    //primero guardamos la signacion de monto editamos y guardamos
                    $asignacion_montof4                 = Asignacion_montof4::find($request->tipo_financiamiento_);
                    $asignacion_montof4->monto_asignado = sin_separador_comas($request->monto_sobrante_presupuesto);
                    $asignacion_montof4->save();
                    //como segundo paso tenemos que guardar en historial
                    $historia_asignacion                       = new Historial_asignacion_monto;
                    $historia_asignacion->asignacionMontof4_id = $asignacion_montof4->id;
                    $historia_asignacion->monto                = sin_separador_comas($request->monto_sobrante_presupuesto);
                    $historia_asignacion->fecha                = date('Y-m-d');
                    $historia_asignacion->save();
                }

                //guardamoes medicda bien servicio
                $medida_bien_servicio                  = new Medida_bienservicio;
                $medida_bien_servicio->formulario5_id  = $request->formulario5_id_requerimientos;
                $medida_bien_servicio->medida_id       = $request->medida;
                $medida_bien_servicio->cantidad        = $request->cantidad;
                $medida_bien_servicio->precio_unitario = $request->precio_unitario;
                if ($request->total_presupuesto_env != '') {
                    $medida_bien_servicio->total_presupuesto = sin_separador_comas($request->total_presupuesto_env);
                } else {
                    $medida_bien_servicio->total_presupuesto = 0;
                }
                $medida_bien_servicio->tipo_financiamiento_id = $request->tipo_fina_id;
                $medida_bien_servicio->fecha_requerida        = date($request->gestion . '-' . $request->mes . '-' . $request->dia);
                $medida_bien_servicio->save();

                $valorSeleccionado = $request->clasificador_presupuestario;
                $valoresSeparados  = explode('_', $valorSeleccionado);
                $valor1            = $valoresSeparados[0];
                $valor2            = $valoresSeparados[1];

                switch ($valor2) {
                    case 'tercerD':
                        $medida_bien_servicio->detalle_tercer_clasificador()->attach($valor1);
                        break;

                    case 'cuartoD':
                        $medida_bien_servicio->detalle_cuarto_clasificador()->attach($valor1);
                        break;

                    case 'quintoD':
                        $medida_bien_servicio->detalle_quinto_clasificador()->attach($valor1);
                        break;
                }

                if ($medida_bien_servicio->id) {
                    $data = [
                        'tipo'    => 'success',
                        'mensaje' => 'Se inserto con éxito',
                        'form5'   => $request->formulario5_id_requerimientos,
                    ];
                } else {
                    $data = [
                        'tipo'    => 'error',
                        'mensaje' => 'Ocurrio un error al insertar',
                        'form5'   => $request->formulario5_id_requerimientos,
                    ];
                }

            }
            return response()->json($data, 200);
        }
    }

    //listar los requerimientos de la gestion actual en el que esta
    public function listar_requerimientos_formilario5($id)
    {
        $id_formulario5  = desencriptar($id);
        $formulario5_lis = Formulario5::with('operacion', 'medida_bien_serviciof5')
            ->find($id_formulario5);
        $clasificadores_presupuestarios = Detalle_tercerClasificador::select('id', 'titulo', DB::raw("'tercerD' as origen"))
            ->union(Detalle_cuartoClasificador::select('id', 'titulo', DB::raw("'cuartoD' as origen")))
            ->union(Detalle_quintoClasificador::select('id', 'titulo', DB::raw("'quintoD' as origen")))
            ->get();
        $data['menu']         = 13;
        $data['listar_form5'] = $formulario5_lis;
        $data['union_tres']   = $clasificadores_presupuestarios;
        return view('formulacion.formulaciones.primer_formulado.operacionesFormulario.listar_requerimientos', $data);
    }
    /**
     * FIN DEL FORMULARIO Nº5
     */

    public function req_eliminar(Request $request)
    {
        if ($request->ajax()) {
            $requerimiento       = Medida_bienservicio::find($request->id_requerimiento);
            $tipo_financiamiento = $requerimiento->tipo_financiamiento_id;
            $formulario5         = Formulario5::with(['formulario4' => function ($q) use ($tipo_financiamiento) {
                $q->with(['asignacion_monto_f4' => function ($q1) use ($tipo_financiamiento) {
                    $q1->where('financiamiento_tipo_id', $tipo_financiamiento);
                }]);
            }])->find($request->id_form5);
            //para editar la parte de asignacion de monto del formulario 4
            $asignacion_montof4                 = Asignacion_montof4::find($formulario5->formulario4->asignacion_monto_f4[0]->id);
            $nuevo_saldo                        = $requerimiento->total_presupuesto + $asignacion_montof4->monto_asignado;
            $asignacion_montof4->monto_asignado = sin_separador_comas($nuevo_saldo);
            $asignacion_montof4->save();
            //para registrar el historial del monto de asignacion
            $historial_asignacion                       = new Historial_asignacion_monto;
            $historial_asignacion->asignacionMontof4_id = $asignacion_montof4->id;
            $historial_asignacion->monto                = sin_separador_comas($nuevo_saldo);
            $historial_asignacion->fecha                = date('Y-m-d');
            $historial_asignacion->save();

            //ahora eliminamos finalmento el requerimiento
            if ($requerimiento->delete()) {
                $data = mensaje_array('success', 'Se removio el requerimiento con exito!');
            } else {
                $data = mensaje_array('error', 'Ocurrio un error');
            }
            return response()->json($data, 200);
        }
    }

    //para editar registro
    public function req_editar(Request $request)
    {
        if ($request->ajax()) {
            $requerimiento = Medida_bienservicio::with(['medida', 'detalle_tercer_clasificador' => function ($q1) {
                $q1->with('clasificador_tercero');
            }], ['detalle_cuarto_clasificador' => function ($q2) {
                $q2->with('clasificador_cuarto');
            }], ['detalle_quinto_clasificador' => function ($q3) {
                $q3->with('clasificador_quinto');
            }], 'tipo_financiamiento')->find($request->id_requerimiento);
            $tipo_financiamiento = $requerimiento->tipo_financiamiento_id;
            $formulario5         = Formulario5::with(['formulario4' => function ($q) use ($tipo_financiamiento) {
                $q->with(['asignacion_monto_f4' => function ($q1) use ($tipo_financiamiento) {
                    $q1->where('financiamiento_tipo_id', $tipo_financiamiento);
                }]);
            }])->find($request->id_form5);

            $asignacion_montof4 = Asignacion_montof4::with('financiamiento_tipo')->find($formulario5->formulario4->asignacion_monto_f4[0]->id);

            $monto_asignacion_actual = $asignacion_montof4->monto_asignado;

            $data['requerimiento']           = $requerimiento;
            $data['formulario5']             = $formulario5;
            $data['asignacion_monto_f4']     = $asignacion_montof4;
            $data['monto_asignacion_actual'] = con_separador_comas($monto_asignacion_actual);
            $data['preacio_unitario']        = con_separador_comas($requerimiento->precio_unitario);
            $data['total_presupuesto']       = con_separador_comas($requerimiento->total_presupuesto);
            return response()->json($data, 200);
        }
    }

    //para validar
    public function req_validar(Request $request)
    {
        if ($request->ajax()) {

            $cantida_precio_uni = $request->valor * $request->precio_unitario;

            $total         = sin_separador_comas($cantida_precio_uni);
            $asignacion_f4 = Asignacion_montof4::find($request->id_monto_asignacion_f4);

            $monto_total = $request->total_presupuesto_ant + $asignacion_f4->monto_asignado;
            if ($total <= $monto_total) {
                $nuevo_saldo = $monto_total - $total;
                $data        = [
                    'tipo'                => 'success',
                    'total_presupuesto_n' => con_separador_comas($total),
                    'nuevo_saldo_n'       => con_separador_comas($nuevo_saldo),
                ];
            } else {
                $nuevo_saldo = $asignacion_f4->monto_asignado;
                $data        = [
                    'tipo'                => 'error',
                    'total_presupuesto_n' => con_separador_comas($request->total_presupuesto_ant),
                    'nuevo_saldo_n'       => con_separador_comas($nuevo_saldo),
                ];
            }
            return response()->json($data);
        }
    }

    //para validar1
    public function req_validar1(Request $request)
    {
        if ($request->ajax()) {

            $cantida_precio_uni = sin_separador_comas($request->monto_validado) * $request->cantidad;
            $total              = sin_separador_comas($cantida_precio_uni);

            $asignacion_f4 = Asignacion_montof4::find($request->id_monto_asignacion_f4);

            $monto_total = $request->total_presupuesto_ant + $asignacion_f4->monto_asignado;
            if ($total <= $monto_total) {
                $nuevo_saldo = $monto_total - $total;
                $data        = [
                    'tipo'                 => 'success',
                    'total_presupuesto_n1' => con_separador_comas($total),
                    'nuevo_saldo_n1'       => con_separador_comas($nuevo_saldo),
                ];
            } else {
                $nuevo_saldo = $asignacion_f4->monto_asignado;
                $data        = [
                    'tipo'                 => 'error',
                    'total_presupuesto_n1' => con_separador_comas($request->total_presupuesto_ant),
                    'nuevo_saldo_n1'       => con_separador_comas($nuevo_saldo),
                ];
            }
            return response()->json($data);
        }
    }

    //para guardar requerimiento
    public function req_guardar_requerimiento_editado(Request $request)
    {
        if ($request->ajax()) {
            //primero a editar el fuente de financiamiento
            $asignacion_monto_f4                 = Asignacion_montof4::find($request->monto_asignaion_monto_f4);
            $asignacion_monto_f4->monto_asignado = sin_separador_comas($request->nuevo_asignacion_monto);
            $asignacion_monto_f4->save();

            $historial_montos                       = new Historial_asignacion_monto;
            $historial_montos->asignacionMontof4_id = $asignacion_monto_f4->id;
            $historial_montos->monto                = sin_separador_comas($request->nuevo_asignacion_monto);
            $historial_montos->fecha                = date('Y-m-d');
            $historial_montos->save();

            $medida_bn_servicio = Medida_bienservicio::find($request->medida_bn_servicio);
            if ($request->cantidad != null) {
                $medida_bn_servicio->cantidad = $request->cantidad;
            }
            if ($request->precio_unitario != null) {
                $medida_bn_servicio->precio_unitario = $request->precio_unitario;
            }
            $medida_bn_servicio->total_presupuesto = sin_separador_comas($request->total_presupuesto_nuevo);
            $medida_bn_servicio->save();

            if ($medida_bn_servicio->id) {
                $data = mensaje_array('success', 'Se editó con éxito');
            } else {
                $data = mensaje_array('error', 'Ocurrio un error');
            }
            return response()->json($data, 200);
        }
    }

}
