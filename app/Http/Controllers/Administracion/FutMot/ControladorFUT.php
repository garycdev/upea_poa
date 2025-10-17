<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Mail\NotificacionGeneral;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\FutMot\Fut;
use App\Models\FutMot\FutMov;
use App\Models\Gestiones;
use App\Models\Poa\Medida_bienservicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ControladorFUT extends Controller
{
    public function inicio()
    {
        // Vista inicio (Validar seguimiento solo admins y tecnicos)
        $data['menu'] = 19;
        if (Auth::user()->id_unidad_carrera != null) {
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['unidades']       = UnidadCarreraArea::get();
            $data['gestiones']      = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->orderBy('gestion', 'ASC')
                ->get();

            return view('administrador.fut.inicio', $data);
        } else {
            $data['unidades']  = UnidadCarreraArea::get();
            $data['gestiones'] = Gestiones::where('estado', 'activo')
                ->where('gestion', '>=', date('Y'))
                ->orderBy('gestion', 'ASC')
                ->get();

            return view('administrador.fut.inicio', $data);
        }
    }

    // Aprobar/rechazar/verificar fomulario FUT (tecnicos de planificacion y presupuestos)
    public function validarFormulario(Request $req)
    {
        $fut                   = Fut::find($req->id_fut);
        $fut->respaldo_tramite = $req->respaldo_tramite;
        $fut->fecha_tramite    = $req->fecha_actual . ' ' . $req->hora_actual;
        $fut->nro_preventivo   = $req->nro_preventivo;
        $fut->observacion      = $req->observacion;
        $fut->estado           = $req->estado;

        // Devuelve todos los montos a medida bien servicio
        if ($req->estado == 'rechazado') {
            $fut->importe = 0;

            $movs = FutMov::join('fut_partidas_presupuestarias as pp', 'pp.id_fut_pp', '=', 'fut_movimiento.id_fut_pp')
                ->where('pp.id_fut', $fut->id_fut)
                ->select('fut_movimiento.*')
                ->get();

            foreach ($movs as $mov) {
                $mbs                    = Medida_bienservicio::find($mov->id_mbs);
                $mbs->total_presupuesto = $mbs->total_presupuesto + $mov->partida_monto;
                $mbs->save();

                $mov->descripcion = 'revertido';
                $mov->save();
            }

            Mail::to($fut->usuario->email)->send(new NotificacionGeneral(
                "Formulario FUT N°" . formatear_con_ceros($fut->nro) . " rechazado.",
                "Su formulario de compra FUT N°" . formatear_con_ceros($fut->nro) . " ha sido rechazado, puede revisarlo dando click al siguiente enlace.",
                route('fut.detalle', encriptar($fut->id_fut)),
                'text-danger'
            ));

        } elseif ($req->estado == 'verificado') {
            $movs = FutMov::join('fut_partidas_presupuestarias as pp', 'pp.id_fut_pp', '=', 'fut_movimiento.id_fut_pp')
                ->where('pp.id_fut', $fut->id_fut)
                ->select('fut_movimiento.*')
                ->get();

            foreach ($movs as $mov) {
                $mbs              = Medida_bienservicio::find($mov->id_mbs);
                $mbs->descripcion = 'compra verificado';
                $mbs->save();

                $mov->descripcion = 'compra verificado';
                $mov->save();
            }

            Mail::to($fut->usuario->email)->send(new NotificacionGeneral(
                "Formulario FUT N°" . formatear_con_ceros($fut->nro) . " verificado.",
                "Su formulario de compra FUT N°" . formatear_con_ceros($fut->nro) . " ya ha sido verificado por planificación, puede revisarlo dando click al siguiente enlace.",
                route('fut.detalle', encriptar($fut->id_fut)),
                'text-primary'
            ));

            $fut->id_unidad_verifica = Auth::user()->id;

            Mail::to(Auth::user()->email)->send(new NotificacionGeneral(
                "Formulario FUT N°" . formatear_con_ceros($fut->nro) . " verificado.",
                "A verificado la compra FUT N°" . formatear_con_ceros($fut->nro) . ", puede revisarlo dando click al siguiente enlace.",
                route('fut.detalle', encriptar($fut->id_fut)),
                'text-primary'
            ));
        } elseif ($req->estado == 'aprobado') {
            $movs = FutMov::join('fut_partidas_presupuestarias as pp', 'pp.id_fut_pp', '=', 'fut_movimiento.id_fut_pp')
                ->where('pp.id_fut', $fut->id_fut)
                ->select('fut_movimiento.*')
                ->get();

            foreach ($movs as $mov) {
                $mbs              = Medida_bienservicio::find($mov->id_mbs);
                $mbs->descripcion = null; // null para valido
                $mbs->save();

                $mov->descripcion = 'compra aprobado';
                $mov->save();
            }

            Mail::to($fut->usuario->email)->send(new NotificacionGeneral(
                "Formulario FUT N°" . formatear_con_ceros($fut->nro) . " aprobado.",
                "Su formulario de compra FUT N°" . formatear_con_ceros($fut->nro) . " ya ha sido aprobado para compra, puede revisarlo dando click al siguiente enlace.",
                route('fut.detalle', encriptar($fut->id_fut)),
                'text-success'
            ));

            $fut->id_unidad_aprueba = Auth::user()->id;

            Mail::to(Auth::user()->email)->send(new NotificacionGeneral(
                "Formulario FUT N°" . formatear_con_ceros($fut->nro) . " verificado.",
                "A aprobado la compra FUT N°" . formatear_con_ceros($fut->nro) . ", puede revisarlo dando click al siguiente enlace.",
                route('fut.detalle', encriptar($fut->id_fut)),
                'text-primary'
            ));
        }

        $fut->save();

        session()->flash('message', 'Formulario validado exitosamente.');
        return redirect()->back();
    }

    // Buscar por gestion y/o nro (tecnicos y admins)
    public function buscarCorrelativo(Request $req)
    {
        $nro          = intval($req->nro) ?? 0;
        $gestiones_id = $req->id_gestion ?? 0;

        if ($gestiones_id != 0 && $nro != 0) {
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'fut.id_configuracion_formulado')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'fut.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->where('fut.estado', '<>', 'eliminado')
                ->where('fut.nro', 'like', '%' . $nro . '%')
                ->where('rcf.gestiones_id', $gestiones_id)
                ->select('fut.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->orderBy('fut.id_fut', 'DESC')
                ->get();
        } else if ($nro != 0 && $gestiones_id == 0) {
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'fut.id_configuracion_formulado')
                ->where('nro', 'like', '%' . $nro . '%')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'fut.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->where('fut.estado', '<>', 'eliminado')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->select('fut.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->orderBy('fut.id_fut', 'DESC')
                ->get();
        } else if ($nro == 0 && $gestiones_id != 0) {
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'fut.id_configuracion_formulado')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'fut.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->where('fut.estado', '<>', 'eliminado')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->where('rcf.gestiones_id', $gestiones_id)
                ->select('fut.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->orderBy('fut.id_fut', 'DESC')
                ->get();
        } else {
            $fut = [];
        }

        $fut->transform(function ($item) {
            $item->id_encriptado        = encriptar($item->id_fut);
            $item->id_config_encriptado = encriptar($item->id_configuracion_formulado);
            $item->id_cua_encriptado    = encriptar($item->id_unidad_carrera);
            return $item;
        });

        if (Auth::user()->unidad_carrera) {
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
            'data'         => $fut,
            'rol'          => $user,
        ], 200);
    }

    // Modal unico para validacion de FUTs
    public function abrirModal($id_fut)
    {
        $data['fut']          = Fut::find($id_fut);
        $fecha_actual         = Carbon::now()->format('Y-m-d');
        $data['fecha_actual'] = $fecha_actual;
        $hora_actual          = Carbon::now()->format('H:i');
        $data['hora_actual']  = $hora_actual;

        return view('formulacion.fut.modal', $data)->render();
    }
}
