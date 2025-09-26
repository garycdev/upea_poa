<?php
namespace App\Http\Controllers\Formulacion;

use App\Http\Controllers\Controller;
use App\Models\Admin_caja\Caja;
use App\Models\Admin_caja\Historial_caja;
use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\Formulado_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Gestiones;
use App\Models\Poa\Asignacion_montof4;
use App\Models\Poa\Formulario1;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Formulario5;
use App\Models\Poa\Historial_asignacion_monto;
use App\Models\Poa\Medida_bienservicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Controlador_formulario2 extends Controller
{
    public function formulario2($formulario1_id, $formuladoTipo_id)
    {
        $id_formulario1    = desencriptar($formulario1_id);
        $id_formuladoTipo  = desencriptar($formuladoTipo_id);
        $data['menu']      = 13;
        $formulario1       = Formulario1::find($id_formulario1);
        $formulario2Existe = Formulario2::where('formulario1_id', $id_formulario1)
            ->where('unidadCarrera_id', $formulario1->unidadCarrera_id)
            ->where('configFormulado_id', $formulario1->configFormulado_id)
            ->where('gestion_id', $formulario1->gestion_id)
            ->orderBy('id', 'asc')
            ->limit(1)
            ->get();
        if (count($formulario2Existe) == 0) {
            $data['resultado'] = 0;

            //con esto sacamos la anteior
            $configuracion_formuladoPOA = Configuracion_formulado::where('gestiones_id', $formulario1->gestion_id)->orderBy('id', 'asc')->limit($id_formuladoTipo)->get();
            $sacar_unaAnterior          = $configuracion_formuladoPOA[count($configuracion_formuladoPOA) - 2];
            $formulario1_ant            = $sacar_unaAnterior->formulario1()->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)->get();
            $formulario2_ant            = Formulario2::with('formulario4')->where('formulario1_id', $formulario1_ant[0]->id)
                ->where('unidadCarrera_id', Auth::user()->id_unidad_carrera)
                ->get();
            foreach ($formulario2_ant as $lis) {
                $newFormulario2                     = new Formulario2;
                $newFormulario2->codigo             = $lis->codigo;
                $newFormulario2->formulario1_id     = $id_formulario1;
                $newFormulario2->configFormulado_id = $formulario1->configFormulado_id;
                $newFormulario2->indicador_id       = $lis->indicador_id;
                $newFormulario2->gestion_id         = $lis->gestion_id;
                $newFormulario2->areaestrategica_id = $lis->areaestrategica_id;
                $newFormulario2->unidadCarrera_id   = $lis->unidadCarrera_id;
                $newFormulario2->save();

                //relacion anterior de muchos a muchos con politica de desarrollo PDU
                $politica_deDesarrrolloPDU = $lis->politica_desarrollo_pdu;
                //para guardar la politica de desarrollo PDU como nuevo
                $newFormulario2->politica_desarrollo_pdu()->sync($politica_deDesarrrolloPDU->pluck('id'));
                //relacion anterior de muchos objetivo estrategico PDU
                $obj_estrategicoPDU = $lis->objetivo_estrategico;
                //para guardar el objetivo estrategico PDU como nuevo
                $newFormulario2->objetivo_estrategico()->sync($obj_estrategicoPDU->pluck('id'));

                //relacion anterior de muchos a muchos politica de desarrollo PEI
                $politica_deDesarrolloPEI = $lis->politica_desarrollo_pei;
                //para guardar la politica de desarrollo PEI como nuevo
                $newFormulario2->politica_desarrollo_pei()->sync($politica_deDesarrolloPEI->pluck('id'));

                //relacion de muchos a muchos con objetivo de la SUB
                $objetivo_estrategicoSUB = $lis->objetivo_estrategico_sub;
                //para guardar objetivo de la SUB
                $newFormulario2->objetivo_estrategico_sub()->sync($objetivo_estrategicoSUB->pluck('id'));
                //relacion de muchos a muchos con objetivo institucional
                $objetivo_institucional = $lis->objetivo_institucional;
                //para guardar la politica institiucional
                $newFormulario2->objetivo_institucional()->sync($objetivo_institucional->pluck('id'));

                //para guardar el formulario 4
                foreach ($lis->formulario4 as $lis2) {
                    $formulario4                     = new Formulario4;
                    $formulario4->codigo             = $lis2->codigo;
                    $formulario4->formulario2_id     = $newFormulario2->id;
                    $formulario4->configFormulado_id = $formulario1->configFormulado_id;
                    $formulario4->unidadCarrera_id   = $lis2->unidadCarrera_id;
                    $formulario4->areaestrategica_id = $lis2->areaestrategica_id;
                    $formulario4->gestion_id         = $lis2->gestion_id;
                    $formulario4->tipo_id            = $lis2->tipo_id;
                    $formulario4->categoria_id       = $lis2->categoria_id;
                    $formulario4->bnservicio_id      = $lis2->bnservicio_id;
                    $formulario4->primer_semestre    = $lis2->primer_semestre;
                    $formulario4->segundo_semestre   = $lis2->segundo_semestre;
                    $formulario4->meta_anual         = $lis2->meta_anual;
                    $formulario4->save();

                    //para agregar las unidades responsables de meta
                    $unidad_res = $lis2->unidad_responsable;
                    $formulario4->unidad_responsable()->sync($unidad_res->pluck('id'));

                    //agarramos la asignacion de montos
                    $nuevo_asignacion_monto = $lis2->asignacion_monto_f4;
                    foreach ($nuevo_asignacion_monto as $new_asignacion_monto) {
                        $asignacion_new                         = new Asignacion_montof4;
                        $asignacion_new->formulario4_id         = $formulario4->id;
                        $asignacion_new->monto_asignado         = $new_asignacion_monto->monto_asignado;
                        $asignacion_new->financiamiento_tipo_id = $new_asignacion_monto->financiamiento_tipo_id;
                        $asignacion_new->fecha                  = $new_asignacion_monto->fecha;
                        $asignacion_new->save();

                        //vamos a copiar el historial del formulario 4
                        $historial_asignacion_monto = $new_asignacion_monto->historial_asignacion_monto;
                        foreach ($historial_asignacion_monto as $his_asignacion) {
                            $historial_asig_new                       = new Historial_asignacion_monto;
                            $historial_asig_new->asignacionMontof4_id = $asignacion_new->id;
                            $historial_asig_new->monto                = $his_asignacion->monto;
                            $historial_asig_new->fecha                = $his_asignacion->fecha;
                            $historial_asig_new->save();
                        }
                    }

                    //para agregar el formulario Nº5
                    $formulario5_ant = $lis2->formulario5_f4;
                    foreach ($formulario5_ant as $listar5) {
                        $new_formulario5                     = new Formulario5;
                        $new_formulario5->formulario4_id     = $formulario4->id;
                        $new_formulario5->operacion_id       = $listar5->operacion_id;
                        $new_formulario5->configFormulado_id = $formulario1->configFormulado_id;
                        $new_formulario5->unidadCarrera_id   = $listar5->unidadCarrera_id;
                        $new_formulario5->areaestrategica_id = $listar5->areaestrategica_id;
                        $new_formulario5->gestion_id         = $listar5->gestion_id;
                        $new_formulario5->primer_semestre    = $listar5->primer_semestre;
                        $new_formulario5->segundo_semestre   = $listar5->segundo_semestre;
                        $new_formulario5->total              = $listar5->total;
                        $new_formulario5->desde              = $listar5->desde;
                        $new_formulario5->hasta              = $listar5->hasta;
                        $new_formulario5->save();

                        //listaremos medida_bienservicio
                        $medida_bienservicio_ant = $listar5->medida_bien_serviciof5;
                        foreach ($medida_bienservicio_ant as $bn_lis) {
                            $new_medida_bienservicio                         = new Medida_bienservicio;
                            $new_medida_bienservicio->formulario5_id         = $new_formulario5->id;
                            $new_medida_bienservicio->medida_id              = $bn_lis->medida_id;
                            $new_medida_bienservicio->cantidad               = $bn_lis->cantidad;
                            $new_medida_bienservicio->precio_unitario        = $bn_lis->precio_unitario;
                            $new_medida_bienservicio->total_presupuesto      = $bn_lis->total_presupuesto;
                            $new_medida_bienservicio->total_monto            = $bn_lis->total_monto;
                            $new_medida_bienservicio->tipo_financiamiento_id = $bn_lis->tipo_financiamiento_id;
                            $new_medida_bienservicio->fecha_requerida        = $bn_lis->fecha_requerida;
                            $new_medida_bienservicio->save();

                            //para agregar los clasificadores del tercer clasificador
                            $clasificador_ant_tercero = $bn_lis->detalle_tercer_clasificador;
                            $new_medida_bienservicio->detalle_tercer_clasificador()->sync($clasificador_ant_tercero->pluck('id'));

                            //para agregar los clasificadores del cuarto clasificador
                            $clasificador_ant_cuarto = $bn_lis->detalle_cuarto_clasificador;
                            $new_medida_bienservicio->detalle_cuarto_clasificador()->sync($clasificador_ant_cuarto->pluck('id'));

                            //para agregar los clasificadores del quinto clasificador
                            $clasificador_ant_quinto = $bn_lis->detalle_quinto_clasificador;
                            $new_medida_bienservicio->detalle_quinto_clasificador()->sync($clasificador_ant_quinto->pluck('id'));
                        }
                    }

                }
            }
        } else {
            $data['resultado']                     = 1;
            $formulado_tipo                        = Formulado_tipo::find($id_formuladoTipo);
            $carrera_unidad                        = UnidadCarreraArea::find($formulario1->unidadCarrera_id);
            $gestiones                             = Gestiones::find($formulario1->gestion_id);
            $formulario1_areasEstrategicas         = $formulario1->relacion_areasEstrategicas;
            $configuracion_formulado               = Configuracion_formulado::find($formulario1->configFormulado_id);
            $data['formulario1']                   = $formulario1;
            $data['formulado_tipo']                = $formulado_tipo;
            $data['carrera_unidad']                = $carrera_unidad;
            $data['gestiones']                     = $gestiones;
            $data['formulario1_areasEstrategicas'] = $formulario1_areasEstrategicas;
            $data['configuracion_formulado']       = $configuracion_formulado;
        }
        return view('formulacion.formulaciones.segundo_formulado.formulario2', $data);
    }

    /**
     * para la asignacion de financiamiento
     */
    public function asigarPresupuestoIndicador(Request $request)
    {
        if ($request->ajax()) {
            $formulario4_asignacion = Formulario4::with(['asignacion_monto_f4' => function ($q) {
                $q->with('financiamiento_tipo');
            }])
                ->find($request->id);
            $formualario4_id = $request->id;
            $caja            = Caja::with(['financiamiento_tipo' => function ($q) use ($formualario4_id) {
                $q->with(['asignacion_monto_formulario4' => function ($q1) use ($formualario4_id) {
                    $q1->where('formulario4_id', $formualario4_id);
                }]);
            }])
                ->where('gestiones_id', $request->id_gestiones)
                ->where('unidad_carrera_id', Auth::user()->id_unidad_carrera)
                ->get();
            $suma_total = Caja::selectRaw('SUM(saldo) as total')
                ->where('gestiones_id', $request->id_gestiones)
                ->where('unidad_carrera_id', Auth::user()->id_unidad_carrera)
                ->get();
            $data['caja']                   = $caja;
            $data['formulario4_asignacion'] = $formulario4_asignacion;
            $data['suma_total']             = con_separador_comas($suma_total[0]->total);
            return response()->json($data);
        }
    }
    //consultamos cuanto tengo en caja
    public function verificar_cuanto_en_caja(Request $request)
    {
        if ($request->ajax()) {
            $caja_valor = Caja::where('gestiones_id', $request->id_gestiones)
                ->where('unidad_carrera_id', Auth::user()->id_unidad_carrera)
                ->where('financiamiento_tipo_id', $request->id)
                ->get();
            if ($caja_valor) {
                $data = [
                    'tipo'         => 'success',
                    'id_caja'      => $caja_valor[0]->id,
                    'monto_comas'  => con_separador_comas($caja_valor[0]->saldo),
                    'monto_normal' => $caja_valor[0]->saldo,
                ];
            } else {
                $data = mensaje_array('error', 'Ocurrio un error!');
            }
            return response()->json($data, 200);
        }
    }
    //para validar montos en caja a niver del controlador
    public function validar_montos_asignar(Request $request)
    {
        if ($request->ajax()) {
            $monto_actual   = $request->monto_actual;
            $monto_asginar  = sin_separador_comas($request->monto_ingresado_validado);
            $monto_sobrante = $monto_actual - $monto_asginar;
            if ($monto_asginar > $monto_actual) {
                $data = [
                    'tipo'                 => 'error',
                    'mensaje'              => 'No puede ser mayor al monto actual',
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

    //para listar del formulario 4 sus asignaciones
    public function listar_asignacion_monto(Request $request)
    {
        if ($request->ajax()) {
            $formulario4_asignacion = Formulario4::with(['asignacion_monto_f4' => function ($q) {
                $q->with('financiamiento_tipo');
            }])
                ->find($request->id);
            $data['formulario4_asignacion'] = $formulario4_asignacion;
            return view('formulacion.formulaciones.primer_formulado.asignacion_form4.asignacion_montoformulario4', $data);
        }
    }
    //para guardar la asignacion del monto
    public function guardar_asignacion_monto(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'tipo_financiamiento' => 'required',
                'monto_asignar'       => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                //primero editamos la rl_caja
                $caja_editar        = Caja::find($request->caja_id);
                $caja_editar->saldo = sin_separador_comas($request->monto_sobrante);
                $caja_editar->save();
                //ahora guardamos en su historial
                $caja_historial           = new Historial_caja;
                $caja_historial->fecha    = date('Y-m-d');
                $caja_historial->hora     = date('H:i:s');
                $caja_historial->concepto = 'Asignacion al indicador del formulario 4, guardand el monto actual que tiene';
                $caja_historial->saldo    = sin_separador_comas($request->monto_sobrante);
                //$caja_historial->monto_asignado = sin_separador_comas($request->monto_asignar);
                $caja_historial->usuario_id = Auth::user()->id;
                $caja_historial->caja_id    = $caja_editar->id;
                $caja_historial->save();

                //guardar el financiamiento a la formulario 4
                $financiamiento_f4                         = new Asignacion_montof4;
                $financiamiento_f4->formulario4_id         = $request->formulario4_id_asignar;
                $financiamiento_f4->monto_asignado         = sin_separador_comas($request->monto_asignar);
                $financiamiento_f4->financiamiento_tipo_id = $request->tipo_financiamiento;
                $financiamiento_f4->fecha                  = date('Y-m-d');
                $financiamiento_f4->save();

                //guadamos su historial
                $historial_financiamiento_f4                       = new Historial_asignacion_monto;
                $historial_financiamiento_f4->asignacionMontof4_id = $financiamiento_f4->id;
                $historial_financiamiento_f4->monto                = sin_separador_comas($request->monto_asignar);
                //$historial_financiamiento_f4->usuario_id = Auth::user()->id;
                $historial_financiamiento_f4->fecha = date('Y-m-d');
                $historial_financiamiento_f4->save();

                if ($historial_financiamiento_f4->id) {
                    $data = [
                        'tipo'                      => 'success',
                        'mensaje'                   => 'Se asigno con éxito',
                        'id_formulario4_recuperado' => $request->formulario4_id_asignar,
                    ];
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error!');
                }
            }
            return response()->json($data, 200);
        }
    }

    //para editar la parte de financiamiento
    public function editar_financiamientoMonto(Request $request)
    {
        if ($request->ajax()) {
            $asignacion_formulario4 = Asignacion_montof4::with('financiamiento_tipo')->find($request->id_asignacion_f4);
            $caja_actual            = Caja::where('gestiones_id', $request->id_gestiones)
                ->where('unidad_carrera_id', Auth::user()->id_unidad_carrera)
                ->where('financiamiento_tipo_id', $asignacion_formulario4->financiamiento_tipo->id)
                ->get();
            $data['asignacion_formulario4'] = $asignacion_formulario4;
            $data['caja_actual']            = $caja_actual;
            $data['id_formulario4_enviado'] = $request->id_form4;
            return view('formulacion.formulaciones.primer_formulado.asignacion_form4.asignacion_editar', $data);
        }
    }
    /**
     * fin de asignacion de financiamiento
     * //return view('formulacion.formulaciones.primer_formulado.asignacion_form4.asignacion_form4',$data);
     */

    //para sumar el financiamiento asignar_financiamiento_sumar
    public function asignar_financiamiento_sumar(Request $request)
    {
        if ($request->ajax()) {
            $asignacionf4_id     = $request->asignacionf4_id;
            $monto_actual        = sin_separador_comas($request->monto_actual);
            $monto_nuevo_asignar = sin_separador_comas($request->monto_nuevo_asignar);
            $monto_asignado_f4   = sin_separador_comas($request->monto_asignado_f4);

            $monto_nuevo_asignado = $monto_asignado_f4 + $monto_nuevo_asignar;

            $monto_sobrante = $monto_actual - $monto_nuevo_asignar;
            if ($monto_nuevo_asignar <= $monto_actual) {
                $data = [
                    'tipo'                   => 'success',
                    'mensaje'                => 'puede',
                    'monto_asignar'          => con_separador_comas($monto_nuevo_asignar),
                    'monto_sobrante'         => con_separador_comas($monto_sobrante),
                    'monto_asignacion_nuevo' => con_separador_comas($monto_nuevo_asignado),
                ];
            } else if ($monto_nuevo_asignar > $monto_actual) {
                $data = [
                    'tipo'                   => 'error',
                    'mensaje'                => 'No puede ingresar un monto mayor que de lo asignado!',
                    'monto_asignar'          => '',
                    'monto_sobrante'         => '',
                    'monto_asignacion_nuevo' => '',
                ];
            }
            return response()->json($data, 200);
        }
    }
    //para restar
    public function asignar_financiamiento_restar(Request $request)
    {
        if ($request->ajax()) {
            $asignacionf4_id     = $request->asignacionf4_id;
            $monto_actual        = sin_separador_comas($request->monto_actual);
            $monto_nuevo_asignar = sin_separador_comas($request->monto_nuevo_asignar);
            $monto_asignado_f4   = sin_separador_comas($request->monto_asignado_f4);

            $nuevo_monto_asignado = $monto_asignado_f4 - $monto_nuevo_asignar;
            $nuevo_monto_caja     = $monto_nuevo_asignar + $monto_actual;

            if ($monto_nuevo_asignar <= $monto_asignado_f4) {
                $data = [
                    'tipo'                   => 'success',
                    'mensaje'                => 'puede',
                    'monto_asignar'          => con_separador_comas($nuevo_monto_asignado),
                    'monto_sobrante'         => con_separador_comas($nuevo_monto_caja),
                    'monto_asignacion_nuevo' => con_separador_comas($nuevo_monto_asignado),
                ];
            } else if ($monto_nuevo_asignar > $monto_asignado_f4) {
                $data = [
                    'tipo'                   => 'error',
                    'mensaje'                => 'No puede ingresar un monto mayor que de lo asignado!',
                    'monto_asignar'          => '',
                    'monto_sobrante'         => '',
                    'monto_asignacion_nuevo' => '',
                ];
            }
            return response()->json($data, 200);
        }
    }

    //para guardar  lo editado asignadcion financiado
    public function guardar_datos_editados_financiamiento(Request $request)
    {
        if ($request->ajax()) {
            $validar = Validator::make($request->all(), [
                'accion_'         => 'required',
                'monto_asignar__' => 'required',
            ]);
            if ($validar->fails()) {
                $data = mensaje_array('errores', $validar->errors());
            } else {
                //editamos primero la caja
                $caja_editar        = Caja::find($request->id_caja);
                $caja_editar->saldo = sin_separador_comas($request->monto_sobrante_env__);
                $caja_editar->save();

                //ahora guardamos el historial
                $historial_caja             = new Historial_caja;
                $historial_caja->fecha      = date('Y-m-d');
                $historial_caja->hora       = date('H:m:s');
                $historial_caja->concepto   = 'restado o sumado';
                $historial_caja->saldo      = sin_separador_comas($request->monto_sobrante_env__);
                $historial_caja->usuario_id = Auth::user()->id;
                $historial_caja->caja_id    = $caja_editar->id;

                //editamos la asignacion de monto del formulario 4
                $asignacion_monto_f4_editar                 = Asignacion_montof4::find($request->asignacionf4_id);
                $asignacion_monto_f4_editar->monto_asignado = sin_separador_comas($request->monto_asignar_env__);
                $asignacion_monto_f4_editar->save();

                //ahora guardamos el historial de asignacion de formulario 4
                $historial_asignacion_monto                       = new Historial_asignacion_monto;
                $historial_asignacion_monto->asignacionMontof4_id = $asignacion_monto_f4_editar->id;
                $historial_asignacion_monto->monto                = sin_separador_comas($request->monto_asignar_env__);
                $historial_asignacion_monto->fecha                = date('Y-m-d');
                $historial_asignacion_monto->save();

                if ($historial_asignacion_monto->id) {
                    $data = [
                        'tipo'             => 'success',
                        'mensaje'          => 'Se modifico los montos con éxito',
                        'id_formulario_f4' => $request->id_formulario4_enviado,
                    ];
                } else {
                    $data = mensaje_array('error', 'Ocurrio un error');
                }

            }
            return response()->json($data, 200);
        }
    }
}
