<?php
namespace App\Http\Controllers\Formulacion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\FutMot\Fut;
use App\Models\FutMot\FutMov;
use App\Models\FutMot\FutPP;
use App\Models\Gestiones;
use App\Models\Poa\Medida_bienservicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ControladorFormulacionFUT extends Controller
{
    public function inicio()
    {
        $data['menu'] = 21;
        if (Auth::user()->id_unidad_carrera != null) {
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['gestiones']      = Gestiones::get();

            return view('formulacion.fut.inicio', $data);
        } else {
            $data['tipo_error'] = 'NOTA!';
            $data['mensaje']    = 'Lo siento no tiene acceso!';
            return view('formulacion.errores.formulacion_error', $data);
        }
    }

    public function listarFormularios($id_conformulado, $id_carrera = 0)
    {
        // $id_formulado = $req->input('id_formulado');
        $configuracion = DB::table('rl_configuracion_formulado as rcf')
            ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
            ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
            ->where('rcf.id', '=', $id_conformulado)
            ->select('rcf.*', 'rft.descripcion', 'rg.gestion', 'rcf.codigo')
            ->first();
        $carrera = null;
        if ($id_carrera == 0) {
            $formulado = DB::table('rl_formulario1')
                ->where('configFormulado_id', '=', $configuracion->id)
                ->where('unidadCarrera_id', '=', Auth::user()->id_unidad_carrera)
                ->first();
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'fut.id_configuracion_formulado', '=', 'rcf.id')
                ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
                ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
                ->where('id_configuracion_formulado', '=', $id_conformulado)
                ->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)
                ->select('fut.*', 'rg.gestion', 'rft.descripcion')
                ->orderBy('fut.id_fut', 'desc')
                ->get();
            $carrera = UnidadCarreraArea::where('id', '=', Auth::user()->id_unidad_carrera)->first();
        } else {
            $formulado = DB::table('rl_formulario1')
                ->where('configFormulado_id', '=', $configuracion->id)
                ->where('unidadCarrera_id', '=', $id_carrera)
                ->first();
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'fut.id_configuracion_formulado', '=', 'rcf.id')
                ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
                ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
                ->where('id_configuracion_formulado', '=', $id_conformulado)
                ->where('id_unidad_carrera', '=', $id_carrera)
                ->select('fut.*', 'rg.gestion', 'rft.descripcion')
                ->orderBy('fut.id_fut', 'desc')
                ->get();
            $carrera = UnidadCarreraArea::where('id', '=', $id_carrera)->first();
        }

        $fecha_actual         = Carbon::now()->format('Y-m-d');
        $data['fecha_actual'] = $fecha_actual;
        $hora_actual          = Carbon::now()->format('H:i');
        $data['hora_actual']  = $hora_actual;

        $data['menu']          = 21;
        $data['configuracion'] = $configuracion;
        $data['fut']           = $fut;
        $data['formulado']     = $formulado;
        $data['carrera']       = $carrera;

        return view('formulacion.fut.lista', $data);
    }

    public function formulario($id_formulado, $gestiones_id, $id_conformulado)
    {
        $id_formulado    = Crypt::decryptString($id_formulado);
        $gestiones_id    = Crypt::decryptString($gestiones_id);
        $id_conformulado = Crypt::decryptString($id_conformulado);

        $nro_fut = DB::table('fut')
        // ->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)
            ->join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'fut.id_configuracion_formulado')
            ->where('rcf.gestiones_id', $gestiones_id)
            ->orderBy('fut.nro', 'desc')
            ->select('fut.*')
            ->first();

        $data['menu']            = 21;
        $data['id_formulado']    = $id_formulado;
        $data['gestiones_id']    = $gestiones_id;
        $data['id_conformulado'] = $id_conformulado;
        $data['nro_fut']         = $nro_fut;

        $partidas_formulado3 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleTercerClasi_medida_bn as dc3_mb', 'dc3_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiTercero as dc3', 'dc3.id', '=', 'dc3_mb.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
        // ->where('mbs.formulario5_id', '=', $formulario5)
        // ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->where('f5.gestion_id', $gestiones_id)
            ->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->select('mbs.*', 'dc3.id as id_detalle', 'dc3.titulo as titulo_detalle', 'c3.codigo as partida', 'c3.titulo', 'c3.descripcion', 'ft.sigla', 'ft.descripcion as financiamiento')
            ->get();
        $partidas_formulado4 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleCuartoClasi_medida_bn as dc4_mb', 'dc4_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiCuarto as dc4', 'dc4.id', '=', 'dc4_mb.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
        // ->where('mbs.formulario5_id', '=', $formulario5)
        // ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->where('f5.gestion_id', $gestiones_id)
            ->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->select('mbs.*', 'dc4.id as id_detalle', 'dc4.titulo as titulo_detalle', 'c4.codigo as partida', 'c4.titulo', 'c4.descripcion', 'ft.sigla', 'ft.descripcion as financiamiento')
            ->get();
        $partidas_formulado5 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleQuintoClasi_medida_bn as dc5_mb', 'dc5_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiQuinto as dc5', 'dc5.id', '=', 'dc5_mb.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
        // ->where('mbs.formulario5_id', '=', $formulario5)
        // ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->where('f5.gestion_id', $gestiones_id)
            ->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->select('mbs.*', 'dc5.id as id_detalle', 'dc5.titulo as titulo_detalle', 'c5.codigo as partida', 'c5.titulo', 'c5.descripcion', 'ft.sigla', 'ft.descripcion as financiamiento')
            ->get();

        $data['partidas_formulado3'] = $partidas_formulado3;
        $data['partidas_formulado4'] = $partidas_formulado4;
        $data['partidas_formulado5'] = $partidas_formulado5;
        $data['gestion']             = Gestiones::find($gestiones_id);

        return view('formulacion.fut.formulario', $data);
    }

    public function getOperacionObjetivo(Request $req)
    {
        $id_mbs = $req->id_mbs;

        $mbs = Medida_bienservicio::join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_formulario4 as f4', 'f4.id', '=', 'f5.formulario4_id')
            ->join('rl_operaciones as op', 'op.id', '=', 'f5.operacion_id')
            ->join('formulario2_objInstitucional as f2_oins', 'f2_oins.formulario2_id', '=', 'f4.formulario2_id')
            ->join('rl_objetivo_institucional as oins', 'oins.id', '=', 'f2_oins.objInstitucional_id')
            ->join('rl_areas_estrategicas as ae', 'ae.id', '=', 'op.area_estrategica_id')
            ->where('rl_medida_bienservicio.id', $id_mbs)
            ->select('op.id as op_id', 'op.descripcion as op_descripcion', 'oins.id as oins_id', 'oins.codigo as oins_codigo', 'oins.descripcion as oins_descripcion', 'ae.id as ae_id', 'ae.codigo_areas_estrategicas as ae_codigo', 'ae.descripcion as ae_descripcion')
            ->first();

        return $mbs;
    }

    public function realizarCompra(Request $req)
    {
        // dd($req);
        // die();

        $areas_estrategicas     = array_values(array_unique($req->areas_estrategicas));
        $objetivo_institucional = array_values(array_unique($req->objetivo_institucional));
        $operacion              = array_values(array_unique($req->operacion));

        $nuevoFut                             = new Fut();
        $nuevoFut->id_configuracion_formulado = $req->input('id_conformulado');
        $nuevoFut->nro                        = intval($req->input('nro_fut'));
        $nuevoFut->area_estrategica           = $areas_estrategicas;
        $nuevoFut->objetivo_gestion           = $objetivo_institucional;
        $nuevoFut->tarea_proyecto             = $operacion;
        $nuevoFut->importe                    = sin_separador_comas($req->input('monto_poa'));
        $nuevoFut->id_unidad_carrera          = Auth::user()->id_unidad_carrera;
        $nuevoFut->id_usuario                 = Auth::user()->id;
        $nuevoFut->save();

        $financiamientos = collect($req->finan)->sort()->values()->all();
        $montos          = $req->monto;
        $ids             = $req->id;
        $form5           = $req->form5;
        $partidas        = $req->partidas;
        $detalles        = $req->detalles;

        // dd($financiamientos);

        $fin        = 0;
        $nuevoFutPP = [];
        foreach ($financiamientos as $key => $value) {
            if ($value != $fin) {
                $fin = $value;

                $nuevoFutPP                        = new FutPP();
                $nuevoFutPP->organismo_financiador = $fin;
                $nuevoFutPP->formulario5           = $form5[$key];
                $nuevoFutPP->id_fut                = $nuevoFut->id_fut;
                $nuevoFutPP->save();
            }

            $nuevoFutMov                 = new FutMov();
            $nuevoFutMov->id_detalle     = $detalles[$key];
            $nuevoFutMov->partida_codigo = $partidas[$key];
            $nuevoFutMov->partida_monto  = sin_separador_comas($montos[$key]);
            $nuevoFutMov->id_mbs         = $ids[$key];
            $nuevoFutMov->descripcion    = 'compra';
            $nuevoFutMov->id_fut_pp      = $nuevoFutPP->id_fut_pp;
            $nuevoFutMov->save();

            $mbs                    = Medida_bienservicio::find($ids[$key]);
            $mbs->total_presupuesto = $mbs->total_presupuesto - sin_separador_comas($montos[$key]);
            $mbs->save();
        }

        session()->flash('message', 'Formulario realizado con éxito.');
        return redirect()->route('fut.listar', [$req->input('id_conformulado'), Auth::user()->id_unidad_carrera]);
    }

    public function formular($id_fut)
    {
        $fut           = Fut::where('id_fut', '=', $id_fut)->first();
        $configuracion = DB::table('rl_configuracion_formulado as rcf')
            ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
            ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
            ->where('rcf.id', '=', $fut->id_configuracion_formulado)
            ->select('rcf.*', 'rft.descripcion', 'rg.gestion', 'rcf.codigo')
            ->first();
        $formulado = DB::table('rl_formulario1')
            ->where('configFormulado_id', '=', $configuracion->id)
            ->where('unidadCarrera_id', '=', $fut->id_unidad_carrera)
            ->first();
        $financiamientos = FutPP::where('id_fut', '=', $fut->id_fut)->get();
        $medidas         = DB::table('rl_medida')->get();

        $data['menu']            = 19;
        $data['fut']             = $fut;
        $data['configuracion']   = $configuracion;
        $data['formulado']       = $formulado;
        $data['financiamientos'] = $financiamientos;
        $data['medidas']         = $medidas;

        $data['id_formulado']    = $formulado->id;
        $data['gestiones_id']    = $formulado->gestion_id;
        $data['id_conformulado'] = $configuracion->id;
        $data['nro_fut']         = $fut->nro;

        $partidas_formulado3 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleTercerClasi_medida_bn as dc3_mb', 'dc3_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiTercero as dc3', 'dc3.id', '=', 'dc3_mb.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
        // ->where('mbs.formulario5_id', '=', $formulario5)
        // ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->where('f5.gestion_id', $formulado->gestion_id)
            ->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->select('mbs.*', 'dc3.id as id_detalle', 'dc3.titulo as titulo_detalle', 'c3.codigo as partida', 'c3.titulo', 'c3.descripcion', 'ft.sigla', 'ft.descripcion as financiamiento')
            ->get();
        $partidas_formulado4 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleCuartoClasi_medida_bn as dc4_mb', 'dc4_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiCuarto as dc4', 'dc4.id', '=', 'dc4_mb.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
        // ->where('mbs.formulario5_id', '=', $formulario5)
        // ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->where('f5.gestion_id', $formulado->gestion_id)
            ->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->select('mbs.*', 'dc4.id as id_detalle', 'dc4.titulo as titulo_detalle', 'c4.codigo as partida', 'c4.titulo', 'c4.descripcion', 'ft.sigla', 'ft.descripcion as financiamiento')
            ->get();
        $partidas_formulado5 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleQuintoClasi_medida_bn as dc5_mb', 'dc5_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiQuinto as dc5', 'dc5.id', '=', 'dc5_mb.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
        // ->where('mbs.formulario5_id', '=', $formulario5)
        // ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->where('f5.gestion_id', $formulado->gestion_id)
            ->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->select('mbs.*', 'dc5.id as id_detalle', 'dc5.titulo as titulo_detalle', 'c5.codigo as partida', 'c5.titulo', 'c5.descripcion', 'ft.sigla', 'ft.descripcion as financiamiento')
            ->get();

        $data['partidas_formulado3'] = $partidas_formulado3;
        $data['partidas_formulado4'] = $partidas_formulado4;
        $data['partidas_formulado5'] = $partidas_formulado5;

        return view('formulacion.fut.detalle', $data);
    }

    public function editarMonto(Request $req)
    {
        $mbs                    = Medida_bienservicio::find($req->id_mbs);
        $total                  = sin_separador_comas($req->monto_actual) + sin_separador_comas($mbs->total_presupuesto);
        $mbs->total_presupuesto = $total - sin_separador_comas($req->monto);
        $mbs->save();

        $mov                = FutMov::find($req->id);
        $mov->partida_monto = sin_separador_comas($req->monto);
        $mov->save();

        $fut          = Fut::find($mov->futpp->id_fut);
        $dif          = sin_separador_comas($req->monto) - sin_separador_comas($req->monto_actual);
        $fut->importe = $fut->importe + $dif;
        $fut->save();

        session()->flash('message', 'Monto modificado exitosamente.');
        return redirect()->back();
    }
    public function eliminarMonto(Request $req)
    {
        try {
            //code...
            $mov = FutMov::find($req->id);

            $mbs                    = Medida_bienservicio::find($mov->id_mbs);
            $mbs->total_presupuesto = $mbs->total_presupuesto + $mov->partida_monto;
            $mbs->save();

            $fut          = Fut::find($mov->futpp->id_fut);
            $fut->importe = $fut->importe - $mov->partida_monto;
            $fut->save();

            $mov->delete();

            session()->flash('success', 'Movimiento eliminado correctamente.');

            return response()->json([
                'success' => true,
            ], 200);
        } catch (\Throwable $th) {
            session()->flash('error', 'Movimiento eliminado correctamente.');

            return response()->json([
                'success' => false,
            ], 403);
        }
    }

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
        }

        $fut->save();

        session()->flash('message', 'Formulario validado exitosamente.');
        return redirect()->back();
    }

    public function ejecutarFormulario(Request $req)
    {
        $fut         = Fut::find($req->id_fut);
        $fut->estado = 'ejecutado';
        $fut->save();

        session()->flash('message', 'Formulario ejecutado exitosamente.');
        return redirect()->back();
    }

    public function buscarCorrelativo(Request $req)
    {
        $nro          = intval($req->nro) ?? 0;
        $gestiones_id = $req->id_gestion ?? 0;

        if ($gestiones_id != 0 && $nro != 0) {
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'fut.id_configuracion_formulado')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'fut.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->where('fut.nro', 'like', '%' . $nro . '%')
                ->where('rcf.gestiones_id', $gestiones_id)
                ->select('fut.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->get();
        } else if ($nro != 0 && $gestiones_id == 0) {
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'fut.id_configuracion_formulado')
                ->where('nro', 'like', '%' . $nro . '%')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'fut.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->select('fut.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->get();
        } else if ($nro == 0 && $gestiones_id != 0) {
            $fut = Fut::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'fut.id_configuracion_formulado')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'fut.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->where('rcf.gestiones_id', $gestiones_id)
                ->select('fut.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->get();
        } else {
            $fut = [];
        }

        if (stripos(Auth::user()->unidad_carrera->nombre_completo, 'PLANIFICA') !== false) {
            $user = 'planifica';
        } elseif (stripos(Auth::user()->unidad_carrera->nombre_completo, 'PRESUPUESTO') !== false) {
            $user = 'presupuesto';
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
