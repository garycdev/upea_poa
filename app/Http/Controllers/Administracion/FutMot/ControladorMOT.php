<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Mail\NotificacionGeneral;
use App\Models\Clasificador\Clasificador_cuarto;
use App\Models\Clasificador\Clasificador_quinto;
use App\Models\Clasificador\Clasificador_tercero;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\FutMot\Mot;
use App\Models\FutMot\MotMov;
use App\Models\Gestiones;
use App\Models\Poa\Medida_bienservicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ControladorMOT extends Controller
{
    // Vista inicio (Lleva a validar seguimiento solo admins y tecnicos)
    public function inicio()
    {
        $data['menu'] = 20;
        if (Auth::user()->id_unidad_carrera != null) {
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['unidades']       = UnidadCarreraArea::get();
            $data['gestiones']      = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->get();

            return view('administrador.mot.inicio', $data);
        } else {
            $data['unidades']  = UnidadCarreraArea::get();
            $data['gestiones'] = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->get();

            return view('administrador.mot.inicio', $data);
        }
    }

    // Vista para inhabilitar partidas (rl_clasificador_tercero, rl_clasificador_cuarto y rl_clasificador_quinto)
    public function partidasHabilitadas()
    {
        $partidas3            = Clasificador_tercero::where('modificacion', false)->where('codigo', 'not like', '1%')->get();
        $partidas31           = Clasificador_tercero::where('modificacion', false)->get();
        $partidasHabilitadas3 = Clasificador_tercero::where('modificacion', true)->get();

        $partidas4            = Clasificador_cuarto::where('modificacion', false)->where('codigo', 'not like', '1%')->get();
        $partidas41           = Clasificador_cuarto::where('modificacion', false)->get();
        $partidasHabilitadas4 = Clasificador_cuarto::where('modificacion', true)->get();

        $partidas5            = Clasificador_quinto::where('modificacion', false)->where('codigo', 'not like', '1%')->get();
        $partidas51           = Clasificador_quinto::where('modificacion', false)->get();
        $partidasHabilitadas5 = Clasificador_quinto::where('modificacion', true)->get();

        $data['menu']                 = 23;
        $data['partidas3']            = $partidas3;
        $data['partidas31']           = $partidas31;
        $data['partidasHabilitadas3'] = $partidasHabilitadas3;
        $data['partidas4']            = $partidas4;
        $data['partidas41']           = $partidas41;
        $data['partidasHabilitadas4'] = $partidasHabilitadas4;
        $data['partidas5']            = $partidas5;
        $data['partidas51']           = $partidas51;
        $data['partidasHabilitadas5'] = $partidasHabilitadas5;

        return view('administrador.mot.partidas', $data);
    }

    // PUT inhabilitar partida
    public function inhabilitarPartida(Request $req)
    {
        // dd($req);
        $grupo = $req->grupo;

        switch ($grupo) {
            case 3:
                Clasificador_tercero::where('id', $req->id_partida)
                    ->update(['modificacion' => false]);
                break;
            case 4:
                Clasificador_cuarto::where('id', $req->id_partida)
                    ->update(['modificacion' => false]);
                break;
            case 5:
                Clasificador_quinto::where('id', $req->id_partida)
                    ->update(['modificacion' => false]);
                break;
            default:
                break;
        }

        session()->flash('mensaje', 'Partida inhabilitada correctamente');
        return redirect()->back();
    }

    // PUT habilitar partida
    public function habilitarPartida(Request $req)
    {
        $grupo = $req->grupo;

        switch ($grupo) {
            case 3:
                Clasificador_tercero::where('id', $req->id)
                    ->update(['modificacion' => true]);
                break;
            case 4:
                Clasificador_cuarto::where('id', $req->id_partida)
                    ->update(['modificacion' => true]);
                break;
            case 5:
                Clasificador_quinto::where('id', $req->id_partida)
                    ->update(['modificacion' => true]);
                break;
            default:
                break;
        }

        session()->flash('mensaje', 'Partida habilitada correctamente');
        return response()->json([
            'success' => true,
        ], 200);
    }

    // Obtener formulados por gestiones
    public function getFormulados(Request $req)
    {
        $id_gestion        = $req->input('id_gestion');
        $id_unidad_carrera = $req->input('id_unidad_carrera');

        $formulados = Configuracion_formulado::join('rl_formulado_tipo as rft', 'rl_configuracion_formulado.formulado_id', '=', 'rft.id')
            ->join('rl_formulario1 as f1', 'f1.configFormulado_id', '=', 'rl_configuracion_formulado.id')
            ->select('rl_configuracion_formulado.*', 'rft.descripcion')
            ->where('gestiones_id', '=', $id_gestion)
            ->where('f1.unidadCarrera_id', '=', $id_unidad_carrera)
            ->orderBy('formulado_id', 'asc')
            ->get();

        $formulados->transform(function ($item) {
            $item->id_encriptado = encriptar($item->id);
            return $item;
        });

        return $formulados;
    }

    // Aprobar/rechazar/verificar fomulario MOT (tecnicos de planificacion y presupuestos)
    public function validarFormulario(Request $req)
    {
        $mot                   = Mot::find($req->id_mot);
        $mot->respaldo_tramite = $req->respaldo_tramite;
        $mot->fecha_tramite    = $req->fecha_actual . ' ' . $req->hora_actual;
        $mot->observacion      = $req->observacion;
        $mot->estado           = $req->estado;

        // Devuelve todos los montos a medida bien servicio
        if ($req->estado == 'rechazado') {
            $mot->importe = 0;

            $movs = MotMov::join('mot_partidas_presupuestarias as pp', 'pp.id_mot_pp', '=', 'mot_movimiento.id_mot_pp')
                ->where('pp.id_mot', $mot->id_mot)
                ->select('mot_movimiento.*')
                ->get();

            foreach ($movs as $mov) {
                if ($mov->motpp->accion == 'DE') {
                    $mbs                    = Medida_bienservicio::find($mov->id_mbs);
                    $mbs->total_presupuesto = $mbs->total_presupuesto + $mov->partida_monto;
                    $mbs->total_monto       = $mbs->total_monto + $mov->partida_monto;
                    $mbs->descripcion       = null; // null para valido
                    $mbs->save();

                    $mov->descripcion = 'revertido';
                } else { // A
                    $mbs = Medida_bienservicio::find($mov->id_mbs);

                    $ceros = strlen($mov->partida_codigo) - strlen(rtrim($mov->partida_codigo, '0'));
                    if ($ceros === 2) {
                        DB::table('detalleTercerClasi_medida_bn')->where('medidabn_id', $mbs->id)->delete();
                    } elseif ($ceros === 1) {
                        DB::table('detalleCuartoClasi_medida_bn')->where('medidabn_id', $mbs->id)->delete();
                    } else {
                        DB::table('detalleQuintoClasi_medida_bn')->where('medidabn_id', $mbs->id)->delete();
                    }

                    $mbs->delete();

                    $mov->descripcion = 'eliminado';
                }

                $mov->save();
            }

            Mail::to($mot->usuario->email)->send(new NotificacionGeneral(
                "Formulario MOT N°" . formatear_con_ceros($mot->nro) . " rechazado.",
                "Su formulario de modificación MOT N°" . formatear_con_ceros($mot->nro) . " ha sido rechazado, puede revisarlo dando click al siguiente enlace.",
                route('mot.detalle', encriptar($mot->id_mot)),
                'text-danger'
            ));

        } elseif ($req->estado == 'verificado') {
            $movs = MotMov::join('mot_partidas_presupuestarias as pp', 'pp.id_mot_pp', '=', 'mot_movimiento.id_mot_pp')
                ->where('pp.id_mot', $mot->id_mot)
                ->select('mot_movimiento.*')
                ->get();

            foreach ($movs as $mov) {
                $mbs              = Medida_bienservicio::find($mov->id_mbs);
                $mbs->descripcion = 'verificado';
                $mbs->save();

                $mov->descripcion = 'verificado';
                $mov->save();
            }

            Mail::to($mot->usuario->email)->send(new NotificacionGeneral(
                "Formulario MOT N°" . formatear_con_ceros($mot->nro) . " verificado.",
                "Su formulario de modificación MOT N°" . formatear_con_ceros($mot->nro) . " ya ha sido verificado por planificación, puede revisarlo dando click al siguiente enlace.",
                route('mot.detalle', encriptar($mot->id_mot)),
                'text-primary'
            ));

            $mot->id_unidad_verifica = Auth::user()->id;

            Mail::to(Auth::user()->email)->send(new NotificacionGeneral(
                "Formulario MOT N°" . formatear_con_ceros($mot->nro) . " verificado.",
                "A verificado la modificación MOT N°" . formatear_con_ceros($mot->nro) . ", puede revisarlo dando click al siguiente enlace.",
                route('mot.detalle', encriptar($mot->id_mot)),
                'text-primary'
            ));
        } elseif ($req->estado == 'aprobado') {
            $movs = MotMov::join('mot_partidas_presupuestarias as pp', 'pp.id_mot_pp', '=', 'mot_movimiento.id_mot_pp')
                ->where('pp.id_mot', $mot->id_mot)
                ->select('mot_movimiento.*')
                ->get();

            foreach ($movs as $mov) {
                $mbs              = Medida_bienservicio::find($mov->id_mbs);
                $mbs->descripcion = null; // null para valido
                $mbs->save();

                $mov->descripcion = 'aprobado';
                $mov->save();
            }

            Mail::to($mot->usuario->email)->send(new NotificacionGeneral(
                "Formulario MOT N°" . formatear_con_ceros($mot->nro) . " aprobado.",
                "Su formulario de modificación MOT N°" . formatear_con_ceros($mot->nro) . " ya ha sido aprobado, puede revisarlo dando click al siguiente enlace.",
                route('mot.detalle', encriptar($mot->id_mot)),
                'text-success'
            ));

            $mot->id_unidad_aprueba = Auth::user()->id;

            Mail::to(Auth::user()->email)->send(new NotificacionGeneral(
                "Formulario MOT N°" . formatear_con_ceros($mot->nro) . " verificado.",
                "A aprobado la modificación MOT N°" . formatear_con_ceros($mot->nro) . ", puede revisarlo dando click al siguiente enlace.",
                route('mot.detalle', encriptar($mot->id_mot)),
                'text-primary'
            ));
        }

        $mot->save();

        session()->flash('message', 'Formulario validado exitosamente.');
        return redirect()->back();
    }

    // Buscar por gestion y/o nro (tecnicos y admins)
    public function buscarCorrelativo(Request $req)
    {
        $nro          = intval($req->nro) ?? 0;
        $gestiones_id = $req->id_gestion ?? 0;

        if ($gestiones_id != 0 && $nro != 0) {
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'mot.id_configuracion_formulado')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'mot.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->where('mot.nro', 'like', '%' . $nro . '%')
                ->where('rcf.gestiones_id', $gestiones_id)
                ->whereNotIn('mot.estado', ["eliminado", "pendiente"])
                ->select('mot.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->orderBy('mot.id_mot', 'DESC')
                ->get();
        } else if ($nro != 0 && $gestiones_id == 0) {
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'mot.id_configuracion_formulado')
                ->where('nro', 'like', '%' . $nro . '%')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'mot.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->whereNotIn('mot.estado', ["eliminado", "pendiente"])
                ->select('mot.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->orderBy('mot.id_mot', 'DESC')
                ->get();
        } else if ($nro == 0 && $gestiones_id != 0) {
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'mot.id_configuracion_formulado')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'mot.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->where('rcf.gestiones_id', $gestiones_id)
                ->whereNotIn('mot.estado', ["eliminado", "pendiente"])
                ->select('mot.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->orderBy('mot.id_mot', 'DESC')
                ->get();
        } else {
            $mot = [];
        }

        $mot->transform(function ($item) {
            $item->id_encriptado        = encriptar($item->id_mot);
            $item->id_config_encriptado = encriptar($item->id_configuracion_formulado);
            $item->id_cua_encriptado    = encriptar($item->id_unidad_carrera);
            return $item;
        });

        if (isset(Auth::user()->unidad_carrera)) {
            if (stripos(Auth::user()->unidad_carrera->nombre_completo, 'PLANIFICA') !== false) {
                $user = 'planifica';
            } elseif (stripos(Auth::user()->unidad_carrera->nombre_completo, 'PRESUPUESTO') !== false) {
                $user = 'presupuesto';
            } else {
                $user = 'user';
            }
        } else {
            $user = '';
        }

        return response()->json([
            'nro'          => $nro,
            'gestiones_id' => $gestiones_id,
            'data'         => $mot,
            'rol'          => $user,
        ], 200);
    }

    // Modal unico para validacion de MOTs
    public function abrirModal($id_mot)
    {
        $data['mot']          = Mot::find($id_mot);
        $fecha_actual         = Carbon::now()->format('Y-m-d');
        $data['fecha_actual'] = $fecha_actual;
        $hora_actual          = Carbon::now()->format('H:i');
        $data['hora_actual']  = $hora_actual;

        return view('formulacion.mot.modal', $data)->render();
    }
}
