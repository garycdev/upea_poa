<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\FutMot\Fut;
use App\Models\FutMot\FutMov;
use App\Models\FutMot\FutPP;
use App\Models\Gestiones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ControladorFUT extends Controller
{
    public function inicio()
    {
        $data['menu'] = 19;
        if (Auth::user()->id_unidad_carrera != null) {
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['unidades']       = UnidadCarreraArea::get();
            $data['gestiones']      = Gestiones::get();

            return view('administrador.fut.inicio', $data);
        } else {
            $data['unidades']       = UnidadCarreraArea::get();
            $data['gestiones']      = Gestiones::get();

            return view('administrador.fut.inicio', $data);
        }
    }
    public function listar_CarreraUnidad(Request $request)
    {
        if ($request->ajax()) {
            $data['gestiones_lis']         = Gestiones::find($request->id);
            $data['tipoCarreraUnidadArea'] = Tipo_CarreraUnidad::orderBy('id', 'asc')->get();
            $data['menu']                  = '19';
            return view('administrador.fut.detalles_CarreraUnidadArea', $data);
        }
    }

    public function asignar_financiamiento($id_carreraUnidadArea, $id_gestiones)
    {
        $id_tipo_carrera        = desencriptar($id_carreraUnidadArea);
        $id_gestion             = desencriptar($id_gestiones);
        $gestiones_lis          = Gestiones::find($id_gestion);
        $tipo_carreraUnidadArea = Tipo_CarreraUnidad::find($id_tipo_carrera);
        $fuente_financiamiento  = Financiamiento_tipo::get();
        $data                   = [
            'gestion_seleccionada'   => $gestiones_lis,
            'tipo_carreraUnidadArea' => $tipo_carreraUnidadArea,
            'menu'                   => '19',
            'fuente_financiamiento'  => $fuente_financiamiento,
        ];
        return view('administrador.configuracion_poa.financiamiento_gestion.financiamiento_gestion', $data);
    }

    public function selectGestiones(Request $req)
    {
        $gestion   = DB::table('rl_gestion')->where('id', '=', $req->input('id_gestion'))->first();
        $gestiones = DB::table('rl_gestiones')->where('estado', '=', 'activo')->whereBetween('gestion', [$gestion->inicio_gestion, $gestion->fin_gestion])->get();

        return $gestiones;
    }

    public function selectGestion(Request $req)
    {
        $tipo_carrera = DB::table('rl_tipo_carrera')->orderBy('id', 'asc')->get();

        return $tipo_carrera;
    }

    public function selectIdCarrera(Request $req)
    {
        $tipo_carrera = DB::table('rl_unidad_carrera')->orderBy('id', 'nombre_completo')->get();
        //$tipo_user = DB::table('users')->orderBy('id')->get();

        return $tipo_carrera;
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
                ->get();
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
                ->get();
            $carrera = UnidadCarreraArea::where('id', '=', $id_carrera)->first();
        }

        $data['menu']          = 19;
        $data['configuracion'] = $configuracion;
        $data['fut']           = $fut;
        $data['formulado']     = $formulado;
        $data['carrera']       = $carrera;

        return view('administrador.fut.listaFUT', $data);
    }
    public function getSaldo(Request $req)
    {
        $formulario5 = $req->input('formulario5');
        return DB::table('rl_medida_bienservicio as mbs')
            ->join('rl_financiamiento_tipo as rft', 'rft.id', '=', 'mbs.tipo_financiamiento_id')
            ->where('mbs.formulario5_id', '=', $formulario5)
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->select('mbs.*', 'rft.codigo', 'rft.descripcion')
            ->orderBy('mbs.tipo_financiamiento_id', 'ASC')
            ->get();
    }
    public function getPartidas(Request $req)
    {
        $formulario5    = $req->input('formulario5');
        $financiamiento = $req->input('financiamiento');

        $partidas_formulado3 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleTercerClasi_medida_bn as dc3_mb', 'dc3_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiTercero as dc3', 'dc3.id', '=', 'dc3_mb.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->where('mbs.formulario5_id', '=', $formulario5)
            ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->select('mbs.*', 'dc3.id as id_detalle', 'dc3.titulo as titulo_detalle', 'c3.codigo as partida', 'c3.titulo', 'c3.descripcion')
            ->get();
        $partidas_formulado4 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleCuartoClasi_medida_bn as dc4_mb', 'dc4_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiCuarto as dc4', 'dc4.id', '=', 'dc4_mb.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->where('mbs.formulario5_id', '=', $formulario5)
            ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->select('mbs.*', 'dc4.id as id_detalle', 'dc4.titulo as titulo_detalle', 'c4.codigo as partida', 'c4.titulo', 'c4.descripcion')
            ->get();
        $partidas_formulado5 = DB::table('rl_medida_bienservicio AS mbs')
            ->join('detalleQuintoClasi_medida_bn as dc5_mb', 'dc5_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiQuinto as dc5', 'dc5.id', '=', 'dc5_mb.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->where('mbs.formulario5_id', '=', $formulario5)
            ->where('mbs.tipo_financiamiento_id', '=', $financiamiento)
            ->select('mbs.*', 'dc5.id as id_detalle', 'dc5.titulo as titulo_detalle', 'c5.codigo as partida', 'c5.titulo', 'c5.descripcion')
            ->get();
        $data = [
            $partidas_formulado3,
            $partidas_formulado4,
            $partidas_formulado5,
        ];
        return $data;
    }
    public function postPartida(Request $req)
    {
        // dd($req);
        // die();
        $nuevoFut                 = new FutMov();
        $nuevoFut->id_detalle     = $req->input('id_detalle');
        $nuevoFut->partida_codigo = $req->input('partida_codigo');
        $nuevoFut->partida_monto  = $req->input('monto_fut');
        $nuevoFut->id_mbs         = $req->input('id_mbs');
        $nuevoFut->descripcion    = 'COMPRA';
        $nuevoFut->id_fut_pp      = $req->input('id_fut_pp');

        $mbs         = DB::table('rl_medida_bienservicio')->where('id', '=', $req->input('id_mbs'))->first();
        $presupuesto = $mbs->total_presupuesto - $req->input('monto_fut');
        DB::table('rl_medida_bienservicio')
            ->where('id', '=', $req->input('id_mbs'))
            ->update(['total_presupuesto' => $presupuesto, 'descripcion' => 'COMPRA']);
        $nuevoFut->save();

        return back()->with('message', 'Partida de compra agregada.');
    }
    public function formulario($id_formulado, $gestiones_id, $id_conformulado)
    {
        $id_formulado    = Crypt::decryptString($id_formulado);
        $gestiones_id    = Crypt::decryptString($gestiones_id);
        $id_conformulado = Crypt::decryptString($id_conformulado);

        $areas_formulado = DB::table('areaestrategica_formulario1 as ae_f1')
            ->join('rl_areas_estrategicas as ae', 'ae_f1.areEstrategica_id', '=', 'ae.id')
            ->where('ae_f1.formulario1_id', '=', $id_formulado)
            ->where('ae.estado', '=', 'activo')
            ->select('ae_f1.*', 'ae.codigo_areas_estrategicas', 'ae.descripcion')
            ->get();

        $areasEstrategicas        = DB::table('rl_areas_estrategicas')->where('estado', '=', 'activo')->get();
        $financiamiento_formulado = DB::table('rl_caja as rc')
            ->join('rl_financiamiento_tipo as rft', 'rc.financiamiento_tipo_id', '=', 'rft.id')
            ->where('rc.gestiones_id', '=', $gestiones_id)
            ->where('rc.unidad_carrera_id', '=', Auth::user()->id_unidad_carrera)
            ->select('rc.*', 'rft.descripcion', 'rft.codigo')
            ->get();
        $financiamiento = DB::table('rl_financiamiento_tipo')->where('estado', '=', 'activo')->get();
        $nro_fut        = DB::table('fut')
            ->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)->orderBy('nro', 'desc')
            ->first();

        $fecha_actual = Carbon::now()->format('Y-m-d');
        $hora_actual  = Carbon::now()->format('H:i');

        $data['menu']                     = 19;
        $data['areas_formulado']          = $areas_formulado;
        $data['areasEstrategicas']        = $areasEstrategicas;
        $data['financiamiento_formulado'] = $financiamiento_formulado;
        $data['financiamiento']           = $financiamiento;
        $data['fecha_actual']             = $fecha_actual;
        $data['hora_actual']              = $hora_actual;
        $data['id_formulado']             = $id_formulado;
        $data['gestiones_id']             = $gestiones_id;
        $data['id_conformulado']          = $id_conformulado;
        $data['nro_fut']                  = $nro_fut;

        return view('administrador.fut.formularioFut', $data);
    }
    public function getSaldoPartidas(Request $req)
    {
        $caja_id         = $req->input('caja_id');
        $saldo_formulado = DB::table('rl_historial_caja as rhc')
            ->join('rl_caja as rc', 'rhc.caja_id', '=', 'rc.id')
            ->join('rl_financiamiento_tipo as rft', 'rft.id', '=', 'rc.financiamiento_tipo_id')
            ->where('rhc.caja_id', '=', $caja_id)
            ->select('rhc.*', 'rft.codigo', 'rc.financiamiento_tipo_id')
            ->orderBy('id', 'DESC')
            ->first();

        $id_formulado = $req->input('id_formulado');
        $gestiones_id = $req->input('gestiones_id');

        $partidas_formulado3 = DB::table('rl_formulario2 as f2')
            ->join('rl_formulario4 as f4', 'f4.formulario2_id', '=', 'f2.id')
            ->join('rl_formulario5 as f5', 'f5.formulario4_id', '=', 'f4.id')
            ->join('rl_medida_bienservicio AS mbs', 'mbs.formulario5_id', '=', 'f5.id')
            ->join('detalleTercerClasi_medida_bn as dc3_mb', 'dc3_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiTercero as dc3', 'dc3.id', '=', 'dc3_mb.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
            ->where('f2.formulario1_id', '=', $id_formulado)
            ->where('f2.gestion_id', '=', $gestiones_id)
            ->where('mbs.tipo_financiamiento_id', '=', $saldo_formulado->financiamiento_tipo_id)
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->select('f2.id as id_f2', 'f4.id as id_f4', 'f5.id as id_f5', 'mbs.id AS id_mbs', 'mbs.tipo_financiamiento_id', 'dc3_mb.detalle_tercerclasif_id', 'dc3.id as id_dc3', 'dc3.titulo as titulo_detalle', 'c3.titulo', 'c3.descripcion', 'c3.codigo as partida', 'mbs.cantidad', 'mbs.precio_unitario', 'mbs.total_presupuesto')
            ->get();
        $partidas_formulado4 = DB::table('rl_formulario2 as f2')
            ->join('rl_formulario4 as f4', 'f4.formulario2_id', '=', 'f2.id')
            ->join('rl_formulario5 as f5', 'f5.formulario4_id', '=', 'f4.id')
            ->join('rl_medida_bienservicio AS mbs', 'mbs.formulario5_id', '=', 'f5.id')
            ->join('detalleCuartoClasi_medida_bn as dc4_mb', 'dc4_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiCuarto as dc4', 'dc4.id', '=', 'dc4_mb.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
            ->where('f2.formulario1_id', '=', $id_formulado)
            ->where('f2.gestion_id', '=', $gestiones_id)
            ->where('mbs.tipo_financiamiento_id', '=', $saldo_formulado->financiamiento_tipo_id)
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->select('f2.id as id_f2', 'f4.id as id_f4', 'f5.id as id_f5', 'mbs.id AS id_mbs', 'mbs.tipo_financiamiento_id', 'dc4_mb.detalle_cuartoclasif_id', 'dc4.id as id_dc4', 'dc4.titulo as titulo_detalle', 'c4.titulo', 'c4.descripcion', 'c4.codigo as partida', 'mbs.cantidad', 'mbs.precio_unitario', 'mbs.total_presupuesto')
            ->get();
        $partidas_formulado5 = DB::table('rl_formulario2 as f2')
            ->join('rl_formulario4 as f4', 'f4.formulario2_id', '=', 'f2.id')
            ->join('rl_formulario5 as f5', 'f5.formulario4_id', '=', 'f4.id')
            ->join('rl_medida_bienservicio AS mbs', 'mbs.formulario5_id', '=', 'f5.id')
            ->join('detalleQuintoClasi_medida_bn as dc5_mb', 'dc5_mb.medidabn_id', '=', 'mbs.id')
            ->join('rl_detalleClasiQuinto as dc5', 'dc5.id', '=', 'dc5_mb.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
            ->where('f2.formulario1_id', '=', $id_formulado)
            ->where('f2.gestion_id', '=', $gestiones_id)
            ->where('mbs.tipo_financiamiento_id', '=', $saldo_formulado->financiamiento_tipo_id)
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->select('f2.id as id_f2', 'f4.id as id_f4', 'f5.id as id_f5', 'mbs.id AS id_mbs', 'mbs.tipo_financiamiento_id', 'dc5_mb.detalle_quintoclasif_id', 'dc5.id as id_dc5', 'dc5.titulo as titulo_detalle', 'c5.titulo', 'c5.descripcion', 'c5.codigo as partida', 'mbs.cantidad', 'mbs.precio_unitario', 'mbs.total_presupuesto')
            ->get();

        $data = [$partidas_formulado3, $partidas_formulado4, $partidas_formulado5, $saldo_formulado];
        return $data;
    }

    public function getPoliticaDesarrollo(Request $req)
    {
        $id_area   = $req->input('id_area');
        $politicas = DB::table('rl_politica_de_desarrollo')->where('id_area_estrategica', '=', $id_area)->get();

        $gestiones_id    = $req->input('gestiones_id');
        $financiamientos = DB::table('rl_medida_bienservicio as mbs')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_financiamiento_tipo AS rft', 'rft.id', '=', 'mbs.tipo_financiamiento_id')
            ->join('rl_caja as rc', 'rc.financiamiento_tipo_id', '=', 'rft.id')
            ->where('f5.gestion_id', '=', $gestiones_id)
            ->where('f5.areaestrategica_id', '=', $id_area)
            ->where('rc.unidad_carrera_id', '=', Auth::user()->id_unidad_carrera)
            ->where('rc.gestiones_id', '=', $gestiones_id)
            ->where('mbs.total_presupuesto', '>', 0.00)
            ->select('rft.id AS id_financiamiento', 'rft.codigo', 'rft.descripcion', 'mbs.total_presupuesto', 'f5.areaestrategica_id', 'rc.id as id_caja', 'mbs.descripcion as observacion', 'mbs.id as id_mbs')
            ->get();
        $data = [$politicas, $financiamientos];

        return $data;
    }
    public function getObjetivoInstitucional(Request $req)
    {
        $id_area      = $req->input('id_area');
        $id_formulado = $req->input('id_formulado');

        return DB::table('rl_formulario2 as f2')
            ->join('formulario2_objInstitucional as f2_oi', 'f2_oi.formulario2_id', '=', 'f2.id')
            ->join('rl_objetivo_institucional as oi', 'oi.id', '=', 'f2_oi.objInstitucional_id')
            ->where('f2.areaestrategica_id', '=', $id_area)
            ->where('f2.formulario1_id', '=', $id_formulado)
            ->select('oi.*', 'f2_oi.formulario2_id as f2_id', 'f2.formulario1_id as f1_id')
            ->get();
    }
    public function getTareaProyecto(Request $req)
    {
        $formulario2 = $req->input('formulario2');
        $objetivo    = $req->input('objetivo');

        return DB::table('rl_formulario5 as f5')
            ->join('rl_formulario4 as f4', 'f4.id', '=', 'f5.formulario4_id')
            ->join('rl_formulario2 as f2', 'f2.id', '=', 'f4.formulario2_id')
            ->join('formulario2_objInstitucional as f2_oi', 'f2_oi.formulario2_id', '=', 'f2.id')
            ->join('rl_operaciones as op', 'op.id', '=', 'f5.operacion_id')
            ->where('f2.id', '=', $formulario2)
            ->where('f2_oi.objInstitucional_id', '=', $objetivo)
            ->select('f5.id as f5_id', 'f4.id as f4_id', 'f2.id as f2_id', 'op.*')
            ->get();
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
            ->where('unidadCarrera_id', '=', Auth::user()->id_unidad_carrera)
            ->first();
        $financiamientos = FutPP::where('id_fut', '=', $fut->id_fut)->get();
        $medidas         = DB::table('rl_medida')->get();

        $data['menu']            = 19;
        $data['fut']             = $fut;
        $data['configuracion']   = $configuracion;
        $data['formulado']       = $formulado;
        $data['financiamientos'] = $financiamientos;
        $data['medidas']         = $medidas;

        return view('administrador.fut.financiamientoFut', $data);
    }
    public function postFormulario(Request $req)
    {
        // dd($req);
        // die();

        $nuevoFut                             = new Fut();
        $nuevoFut->id_configuracion_formulado = $req->input('id_conformulado');
        $nuevoFut->nro                        = $req->input('nro_fut');
        $nuevoFut->area_estrategica           = $req->input('area_estrategica');
        $nuevoFut->objetivo_gestion           = $req->input('og_id');
        $nuevoFut->tarea_proyecto             = $req->input('tarea_proyecto');
        // $nuevoFut->respaldo_tramite = 'HOJA DE TRAMITE ' . $req->input('respaldo_tramite_1') . ' Y HOJA INTERNA ' . $req->input('respaldo_tramite_2');
        $nuevoFut->importe           = $req->input('monto_poa');
        $nuevoFut->respaldo_tramite  = $req->input('respaldo_tramite');
        $nuevoFut->fecha_tramite     = $req->input('fecha_actual') . ' ' . $req->input('hora_actual');
        $nuevoFut->id_unidad_carrera = Auth::user()->id_unidad_carrera;
        $nuevoFut->id_usuario        = Auth::user()->id;
        $nuevoFut->nro_preventivo    = $req->input('nro_preventivo');
        $nuevoFut->save();

        $fut = Fut::orderBy('id_fut', 'DESC')->first();

        for ($k = 1; $k <= 4; $k++) {
            if ($req->has('fuente_' . $k)) {
                if ($req->input('fuente_' . $k) == 'on') {

                    $nuevoFutPP                        = new FutPP();
                    $nuevoFutPP->organismo_financiador = $k;
                    $nuevoFutPP->formulario5           = $req->input('formulario5_' . $k);
                    $nuevoFutPP->categoria_progmatica  = $req->input('categoria_progmatica' . $k);
                    $nuevoFutPP->id_fut                = $fut->id_fut;
                    $nuevoFutPP->save();
                    // $futPP = FutPP::orderBy('id_fut', 'DESC')->first();

                    // for ($i = 0; $i <= $req->input('cont' . $k); $i++) {
                    //     if ($req->input('partida_' . $k . $i)) {
                    //         $mbs = DB::table('rl_medida_bienservicio')->where('id', '=', $req->input('id_mbs' . $k . $i))->first();
                    //         $total_presupuesto = $mbs->total_presupuesto - number_format($req->input('partida_monto_' . $k . $i), 2);
                    //         DB::table('rl_medida_bienservicio')
                    //             ->where('id', '=', $mbs->id)
                    //             ->update([
                    //                 'total_presupuesto' => $total_presupuesto,
                    //                 'descripcion' => 'compra',
                    //             ]);
                    //         $nuevoFutMov = new FutMov();
                    //         $nuevoFutMov->id_detalle = $req->input('detalle_' . $k . $i);
                    //         $nuevoFutMov->partida_codigo = $req->input('partida_' . $k . $i);
                    //         $nuevoFutMov->partida_monto = number_format($req->input('partida_monto_' . $k . $i), 2);
                    //         $nuevoFutMov->id_mbs = $req->input('id_mbs' . $k . $i);
                    //         $nuevoFutMov->descripcion = 'compra';
                    //         $nuevoFutMov->id_fut_pp = $futPP->id_fut_pp;
                    //         $nuevoFutMov->save();
                    //     }
                    // }

                }
            }
        }
        return redirect()->route('listarFormulariosFut', $req->input('id_conformulado'))->with(['message' => 'Formulario realizado con éxito.']);
    }
}
