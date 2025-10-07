<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Clasificador\Clasificador_cuarto;
use App\Models\Clasificador\Clasificador_quinto;
use App\Models\Clasificador\Clasificador_tercero;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\FutMot\Mot;
use App\Models\FutMot\MotMov;
use App\Models\FutMot\MotPP;
use App\Models\Gestiones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ControladorMOT extends Controller
{
    // Vista inicio (Validar seguimiento solo admins y tecnicos)
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
            // ->where('usuario_id', '=', Auth::user()->id)
                ->where('unidadCarrera_id', '=', Auth::user()->id_unidad_carrera)
                ->first();
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'mot.id_configuracion_formulado', '=', 'rcf.id')
                ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
                ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
                ->where('id_configuracion_formulado', '=', $id_conformulado)
                ->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)
                ->select('mot.*', 'rg.gestion', 'rft.descripcion')
                ->get();
        } else {
            $formulado = DB::table('rl_formulario1')
                ->where('configFormulado_id', '=', $configuracion->id)
            // ->where('usuario_id', '=', Auth::user()->id)
                ->where('unidadCarrera_id', '=', $id_carrera)
                ->first();
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'mot.id_configuracion_formulado', '=', 'rcf.id')
                ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
                ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
                ->where('id_configuracion_formulado', '=', $id_conformulado)
                ->where('id_unidad_carrera', '=', $id_carrera)
                ->select('mot.*', 'rg.gestion', 'rft.descripcion')
                ->get();
            $carrera = UnidadCarreraArea::where('id', '=', $id_carrera)->first();
        }

        $data['menu']          = 20;
        $data['configuracion'] = $configuracion;
        $data['formulado']     = $formulado;
        $data['mot']           = $mot;
        $data['carrera']       = $carrera;

        return view('administrador.mot.lista', $data);
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
            ->select('rc.*', 'rft.descripcion', 'rft.codigo', 'rft.id as id_financiamiento')
            ->get();
        $financiamiento = DB::table('rl_financiamiento_tipo')->where('estado', '=', 'activo')->get();
        $nro_mot        = DB::table('mot')
            ->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)
            ->orderBy('nro', 'desc')
            ->first();

        $fecha_actual = Carbon::now()->format('Y-m-d');
        $hora_actual  = Carbon::now()->format('H:i');

        $data['menu']                     = 20;
        $data['areas_formulado']          = $areas_formulado;
        $data['areasEstrategicas']        = $areasEstrategicas;
        $data['financiamiento_formulado'] = $financiamiento_formulado;
        $data['financiamiento']           = $financiamiento;
        $data['fecha_actual']             = $fecha_actual;
        $data['hora_actual']              = $hora_actual;
        $data['id_formulado']             = $id_formulado;
        $data['gestiones_id']             = $gestiones_id;
        $data['id_conformulado']          = $id_conformulado;
        $data['nro_mot']                  = $nro_mot;

        return view('administrador.mot.formulario', $data);
    }
    public function modificacionP($id_mot)
    {
        // $id_mot        = Crypt::decryptString($id_mot);
        $mot           = Mot::where('id_mot', '=', $id_mot)->first();
        $configuracion = DB::table('rl_configuracion_formulado as rcf')
            ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
            ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
            ->where('rcf.id', '=', $mot->id_configuracion_formulado)
            ->select('rcf.*', 'rft.descripcion', 'rg.gestion', 'rcf.codigo')
            ->first();
        $formulado = DB::table('rl_formulario1')
            ->where('configFormulado_id', '=', $configuracion->id)
            ->where('unidadCarrera_id', '=', Auth::user()->id_unidad_carrera)
            ->first();
        $financiamientos = MotPP::where('id_mot', '=', $mot->id_mot)->get();
        $medidas         = DB::table('rl_medida')->get();

        $data['menu']            = 20;
        $data['mot']             = $mot;
        $data['configuracion']   = $configuracion;
        $data['formulado']       = $formulado;
        $data['financiamientos'] = $financiamientos;
        $data['medidas']         = $medidas;

        return view('administrador.mot.financiamiento', $data);
    }
    public function getSaldoPartidas(Request $req)
    {
        // $caja_id = $req->input('caja_id');
        // $saldo_formulado = DB::table('rl_historial_caja as rhc')
        //     ->join('rl_caja as rc', 'rhc.caja_id', '=', 'rc.id')
        //     ->join('rl_financiamiento_tipo as rft', 'rft.id', '=', 'rc.financiamiento_tipo_id')
        //     ->where('rhc.caja_id', '=', $caja_id)
        //     ->select('rhc.*', 'rft.codigo', 'rc.financiamiento_tipo_id')
        //     ->orderBy('id', 'DESC')
        //     ->first();

        $id_formulado        = $req->input('id_formulado');
        $gestiones_id        = $req->input('gestiones_id');
        $formulario5         = $req->input('formulario5');
        $id_area_estrategica = $req->input('id_area_estrategica');
        $financiamiento      = $req->input('financiamiento');

        $partidas3 = DB::table('rl_detalleClasiTercero as dc3')
            ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
            ->where('dc3.estado', '=', 'activo')
            ->select('dc3.id', 'dc3.titulo as titulo_detalle', 'dc3.tercerclasificador_id', 'c3.codigo as partida', 'c3.titulo', 'c3.descripcion', 'c3.id_clasificador_segundo')
            ->orderBy('c3.id', 'ASC')
            ->get();
        $partidas4 = DB::table('rl_detalleClasiCuarto as dc4')
            ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
            ->where('dc4.estado', '=', 'activo')
            ->select('dc4.id', 'dc4.titulo as titulo_detalle', 'dc4.cuartoclasificador_id', 'c4.codigo as partida', 'c4.titulo', 'c4.descripcion', 'c4.id_clasificador_tercero')
            ->orderBy('c4.id', 'ASC')
            ->get();
        $partidas5 = DB::table('rl_detalleClasiQuinto as dc5')
            ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
            ->where('dc5.estado', '=', 'activo')
            ->select('dc5.id', 'dc5.titulo as titulo_detalle', 'dc5.quintoclasificador_id', 'c5.codigo as partida', 'c5.titulo', 'c5.descripcion', 'c5.id_clasificador_cuarto')
            ->orderBy('c5.id', 'ASC')
            ->get();

        // $partidas_formulado3 = DB::table('rl_formulario2 as f2')
        //     ->join('rl_formulario4 as f4', 'f4.formulario2_id', '=', 'f2.id')
        //     ->join('rl_formulario5 as f5', 'f5.formulario4_id', '=', 'f4.id')
        //     ->join('rl_medida_bienservicio AS mbs', 'mbs.formulario5_id', '=', 'f5.id')
        //     ->join('detalleTercerClasi_medida_bn as dc3_mb', 'dc3_mb.medidabn_id', '=', 'mbs.id')
        //     ->join('rl_detalleClasiTercero as dc3', 'dc3.id', '=', 'dc3_mb.detalle_tercerclasif_id')
        //     ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
        //     ->where('f2.formulario1_id', '=', $id_formulado)
        //     ->where('f2.gestion_id', '=', $gestiones_id)
        //     ->where('mbs.tipo_financiamiento_id', '=', $saldo_formulado->financiamiento_tipo_id)
        //     ->where('mbs.total_presupuesto', '>', 0.00)
        //     ->where('f2.areaestrategica_id', '=', $id_area_estrategica)
        //     ->select('f2.id as id_f2', 'f4.id as id_f4', 'f5.id as id_f5', 'mbs.id AS id_mbs', 'mbs.tipo_financiamiento_id', 'dc3_mb.detalle_tercerclasif_id', 'dc3.id as id_dc3', 'dc3.titulo as titulo_detalle', 'c3.titulo', 'c3.descripcion', 'c3.codigo as partida', 'mbs.cantidad', 'mbs.precio_unitario', 'mbs.total_presupuesto', 'mbs.descripcion as observacion')
        //     ->get();
        // $partidas_formulado4 = DB::table('rl_formulario2 as f2')
        //     ->join('rl_formulario4 as f4', 'f4.formulario2_id', '=', 'f2.id')
        //     ->join('rl_formulario5 as f5', 'f5.formulario4_id', '=', 'f4.id')
        //     ->join('rl_medida_bienservicio AS mbs', 'mbs.formulario5_id', '=', 'f5.id')
        //     ->join('detalleCuartoClasi_medida_bn as dc4_mb', 'dc4_mb.medidabn_id', '=', 'mbs.id')
        //     ->join('rl_detalleClasiCuarto as dc4', 'dc4.id', '=', 'dc4_mb.detalle_cuartoclasif_id')
        //     ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
        //     ->where('f2.formulario1_id', '=', $id_formulado)
        //     ->where('f2.gestion_id', '=', $gestiones_id)
        //     ->where('mbs.tipo_financiamiento_id', '=', $saldo_formulado->financiamiento_tipo_id)
        //     ->where('mbs.total_presupuesto', '>', 0.00)
        //     ->where('f2.areaestrategica_id', '=', $id_area_estrategica)
        //     ->select('f2.id as id_f2', 'f4.id as id_f4', 'f5.id as id_f5', 'mbs.id AS id_mbs', 'mbs.tipo_financiamiento_id', 'dc4_mb.detalle_cuartoclasif_id', 'dc4.id as id_dc4', 'dc4.titulo as titulo_detalle', 'c4.titulo', 'c4.descripcion', 'c4.codigo as partida', 'mbs.cantidad', 'mbs.precio_unitario', 'mbs.total_presupuesto', 'mbs.descripcion as observacion')
        //     ->get();
        // $partidas_formulado5 = DB::table('rl_formulario2 as f2')
        //     ->join('rl_formulario4 as f4', 'f4.formulario2_id', '=', 'f2.id')
        //     ->join('rl_formulario5 as f5', 'f5.formulario4_id', '=', 'f4.id')
        //     ->join('rl_medida_bienservicio AS mbs', 'mbs.formulario5_id', '=', 'f5.id')
        //     ->join('detalleQuintoClasi_medida_bn as dc5_mb', 'dc5_mb.medidabn_id', '=', 'mbs.id')
        //     ->join('rl_detalleClasiQuinto as dc5', 'dc5.id', '=', 'dc5_mb.detalle_quintoclasif_id')
        //     ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
        //     ->where('f2.formulario1_id', '=', $id_formulado)
        //     ->where('f2.gestion_id', '=', $gestiones_id)
        //     ->where('mbs.tipo_financiamiento_id', '=', $saldo_formulado->financiamiento_tipo_id)
        //     ->where('mbs.total_presupuesto', '>', 0.00)
        //     ->where('f2.areaestrategica_id', '=', $id_area_estrategica)
        //     ->select('f2.id as id_f2', 'f4.id as id_f4', 'f5.id as id_f5', 'mbs.id AS id_mbs', 'mbs.tipo_financiamiento_id', 'dc5_mb.detalle_quintoclasif_id', 'dc5.id as id_dc5', 'dc5.titulo as titulo_detalle', 'c5.titulo', 'c5.descripcion', 'c5.codigo as partida', 'mbs.cantidad', 'mbs.precio_unitario', 'mbs.total_presupuesto', 'mbs.descripcion as observacion')
        //     ->get();
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

        $data = [$partidas3, $partidas4, $partidas5, $partidas_formulado3, $partidas_formulado4, $partidas_formulado5];
        return $data;
    }
    public function getObjetivoInstitucional(Request $req)
    {
        $id_area     = $req->input('id_area');
        $formulario1 = $req->input('formulario1');

        return DB::table('rl_formulario2 as f2')
            ->join('formulario2_objInstitucional as f2_oi', 'f2_oi.formulario2_id', '=', 'f2.id')
            ->join('rl_objetivo_institucional as oi', 'oi.id', '=', 'f2_oi.objInstitucional_id')
            ->where('f2.areaestrategica_id', '=', $id_area)
            ->where('f2.formulario1_id', '=', $formulario1)
            ->select('oi.*', 'f2_oi.formulario2_id as f2_id', 'f2.formulario1_id as f1_id')
            ->get();

        // $gestiones_id = $req->input('gestiones_id');

        // $financiamientos = DB::table('rl_medida_bienservicio as mbs')
        //     ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
        //     ->join('rl_financiamiento_tipo AS rft', 'rft.id', '=', 'mbs.tipo_financiamiento_id')
        //     ->join('rl_caja as rc', 'rc.financiamiento_tipo_id', '=', 'rft.id')
        //     ->where('f5.gestion_id', '=', $gestiones_id)
        //     ->where('f5.areaestrategica_id', '=', $id_area)
        //     ->where('rc.unidad_carrera_id', '=', Auth::user()->id_unidad_carrera)
        //     ->where('rc.gestiones_id', '=', $gestiones_id)
        //     ->where('mbs.total_presupuesto', '>', 0.00)
        //     ->select('rft.id AS id_financiamiento', 'rft.codigo', 'rft.descripcion', 'mbs.total_presupuesto', 'f5.areaestrategica_id', 'rc.id as id_caja', 'mbs.descripcion as observacion')
        //     ->get();
        // $saldo_formulado = DB::table('rl_historial_caja as rhc')
        // ->join('rl_caja as rc', 'rhc.caja_id', '=', 'rc.id')
        // ->join('rl_financiamiento_tipo as rft', 'rft.id', '=', 'rc.financiamiento_tipo_id')
        // ->where('rhc.caja_id', '=', $caja_id)
        // ->where('rc.gestiones_id', '=', $gestiones_id)
        // ->where('rc.unidad_carrera_id', '=', Auth::user()->id_unidad_carrera)
        // ->where('rhc.documento_privado', '=', NULL)
        // ->select('rhc.*', 'rft.codigo', 'rc.financiamiento_tipo_id')
        // ->orderBy('rft.id', 'ASC')
        // ->get();
        // $data = array($objetivos, $financiamientos);
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
    public function getPartidasDe(Request $req)
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
    public function postPartidaDe(Request $req)
    {
        // dd($req);
        // die();
        $nuevoMov                 = new MotMov();
        $nuevoMov->id_detalle     = $req->input('id_detalle');
        $nuevoMov->partida_codigo = $req->input('partida_codigo');
        $nuevoMov->partida_monto  = $req->input('monto_de');
        $nuevoMov->id_mbs         = $req->input('partida_presupuestaria_de');
        $nuevoMov->descripcion    = 'MODIFICA';
        $nuevoMov->id_mot_pp      = $req->input('id_mot_pp');

        $mbs         = DB::table('rl_medida_bienservicio')->where('id', '=', $req->input('partida_presupuestaria_de'))->first();
        $presupuesto = $mbs->total_presupuesto - $req->input('monto_de');
        DB::table('rl_medida_bienservicio')
            ->where('id', '=', $req->input('partida_presupuestaria_de'))
            ->update(['total_presupuesto' => $presupuesto, 'descripcion' => 'MODIFICA']);
        $nuevoMov->save();

        return back()->with('message', 'Partida de modificacion agregada.');
    }
    public function getPartidasA(Request $req)
    {
        $partidas3 = DB::table('rl_detalleClasiTercero as dc3')
            ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
            ->where('dc3.estado', '=', 'activo')
            ->select('dc3.id', 'dc3.titulo as titulo_detalle', 'dc3.tercerclasificador_id', 'c3.codigo as partida', 'c3.titulo', 'c3.descripcion', 'c3.id_clasificador_segundo')
            ->orderBy('c3.id', 'ASC')
            ->get();
        $partidas4 = DB::table('rl_detalleClasiCuarto as dc4')
            ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
            ->where('dc4.estado', '=', 'activo')
            ->select('dc4.id', 'dc4.titulo as titulo_detalle', 'dc4.cuartoclasificador_id', 'c4.codigo as partida', 'c4.titulo', 'c4.descripcion', 'c4.id_clasificador_tercero')
            ->orderBy('c4.id', 'ASC')
            ->get();
        $partidas5 = DB::table('rl_detalleClasiQuinto as dc5')
            ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
            ->where('dc5.estado', '=', 'activo')
            ->select('dc5.id', 'dc5.titulo as titulo_detalle', 'dc5.quintoclasificador_id', 'c5.codigo as partida', 'c5.titulo', 'c5.descripcion', 'c5.id_clasificador_cuarto')
            ->orderBy('c5.id', 'ASC')
            ->get();

        return [
            $partidas3,
            $partidas4,
            $partidas5,
        ];
    }

    public function postPartidaA(Request $req)
    {
        // dd($req);
        // die();
        DB::table('rl_medida_bienservicio')
            ->insert([
                'formulario5_id'         => $req->input('formulario5'),
                'medida_id'              => $req->input('medida'),
                'cantidad'               => $req->input('cantidad'),
                'precio_unitario'        => $req->input('precio_unitario'),
                'total_presupuesto'      => $req->input('total_presupuesto'),
                'descripcion'            => 'INCREMENTA',
                'tipo_financiamiento_id' => $req->input('financiamiento'),
                'fecha_requerida'        => $req->input('fecha_requerida'),
            ]);
        $mbs = DB::table('rl_medida_bienservicio')
            ->orderBy('id', 'DESC')
            ->first();

        $tabla = '5';
        for ($i = 3; $i < 5; $i++) {
            if (substr($req->input('partida_codigo_a'), $i, 1) == 0) {
                $tabla = $i;
                break;
            }
        }
        switch ($tabla) {
            case '3':
                DB::table('detalleTercerClasi_medida_bn')
                    ->insert([
                        'detalle_tercerclasif_id' => $req->input('id_detalle'),
                        'medidabn_id'             => $mbs->id,
                    ]);
                break;
            case '4':
                DB::table('detalleCuartoClasi_medida_bn')
                    ->insert([
                        'detalle_cuartoclasif_id' => $req->input('id_detalle'),
                        'medidabn_id'             => $mbs->id,
                    ]);
                break;
            case '5':
                DB::table('detalleQuintoClasi_medida_bn')
                    ->insert([
                        'detalle_quintoclasif_id' => $req->input('id_detalle'),
                        'medidabn_id'             => $mbs->id,
                    ]);
                break;
        }

        $nuevoMov                 = new MotMov();
        $nuevoMov->id_detalle     = $req->input('id_detalle');
        $nuevoMov->partida_codigo = $req->input('partida_codigo_a');
        $nuevoMov->partida_monto  = $req->input('total_presupuesto');
        $nuevoMov->id_mbs         = $mbs->id;
        $nuevoMov->descripcion    = 'INCREMENTA';
        $nuevoMov->id_mot_pp      = $req->input('id_mot_pp_a');
        $nuevoMov->save();

        return back()->with('message', 'Partida de modificacion agregada.');
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

    public function postModificacion(Request $req)
    {
        // dd($req);
        // die();
        $nuevoMot                             = new Mot();
        $nuevoMot->id_configuracion_formulado = $req->input('id_conformulado');
        $nuevoMot->nro                        = $req->input('nro_mot');
        $nuevoMot->area_estrategica_de        = $req->input('area_estrategica_de');
        $nuevoMot->ae_de_importe              = $req->input('ae_de_importe');
        $nuevoMot->area_estrategica_a         = $req->input('area_estrategica_a');
        $nuevoMot->ae_a_importe               = $req->input('ae_a_importe');
        $nuevoMot->objetivo_gestion_de        = $req->input('og_de_id');
        $nuevoMot->og_de_importe              = $req->input('og_de_importe');
        $nuevoMot->objetivo_gestion_a         = $req->input('og_a_id');
        $nuevoMot->og_a_importe               = $req->input('og_a_importe');
        $nuevoMot->tarea_proyecto_de          = $req->input('tarea_proyecto_de');
        $nuevoMot->tp_de_importe              = $req->input('tp_de_importe');
        $nuevoMot->tarea_proyecto_a           = $req->input('tarea_proyecto_a');
        $nuevoMot->tp_a_importe               = $req->input('tp_a_importe');
        $nuevoMot->respaldo_tramite           = $req->input('respaldo_tramite');
        $nuevoMot->fecha_tramite              = $req->input('fecha_actual') . ' ' . $req->input('hora_actual');
        $nuevoMot->id_unidad_carrera          = Auth::user()->id_unidad_carrera;
        $nuevoMot->id_usuario                 = Auth::user()->id;
        $nuevoMot->save();

        $mot = Mot::orderBy('id_mot', 'DESC')->first();

        for ($fin = 1; $fin <= 4; $fin++) {
            if ($req->has('fuente_' . $fin)) {
                if ($req->input('fuente_' . $fin) == 'on') {
                    $nuevoMotPP_de                        = new MotPP();
                    $nuevoMotPP_de->organismo_financiador = $req->input('organismo_financiador_' . $fin);
                    $nuevoMotPP_de->formulario5           = $req->input('formulario5_' . $fin);
                    $nuevoMotPP_de->accion                = 'DE';
                    $nuevoMotPP_de->id_mot                = $mot->id_mot;
                    $nuevoMotPP_de->save();
                    // $motPP_de = MotPP::orderBy('id_mot', 'DESC')->first();

                    // for ($i = 0; $i <= intval($req->input('contDe' . $fin)); $i++) {
                    //     if ($req->input('de_partida_' . $fin . $i)) {
                    //         $nuevoMotMov_de = new MotMov();
                    //         $nuevoMotMov_de->id_detalle = $req->input('de_detalle_' . $fin . $i);
                    //         $nuevoMotMov_de->partida_codigo = $req->input('de_partida_' . $fin . $i);
                    //         $nuevoMotMov_de->partida_monto = $req->input('de_partida_monto_' . $fin . $i);
                    //         $nuevoMotMov_de->id_mbs = $req->input('de_partida_monto_id_mbs_' . $fin . $i);
                    //         $nuevoMotMov_de->descripcion = 'modifica';
                    //         $nuevoMotMov_de->id_mot_pp = $motPP_de->id_mot_pp;
                    //         $nuevoMotMov_de->save();
                    // $mbs = DB::table('rl_medida_bienservicio')
                    //     ->where('id', '=', $req->input('de_partida_monto_id_mbs_' . $fin . $i))
                    //     ->first();
                    // $total_presupuesto = $mbs->total_presupuesto;
                    // $total_presupuesto = $total_presupuesto - $req->input('de_partida_monto_' . $fin . $i);
                    // DB::table('rl_medida_bienservicio')
                    //     ->where('id', '=', $req->input('de_partida_monto_id_mbs_' . $fin . $i))
                    //     ->update([
                    //         'total_presupuesto' => $total_presupuesto,
                    //         'descripcion' => 'modifica',
                    //     ]);
                    //     }
                    // }

                    $nuevoMotPP_a                        = new MotPP();
                    $nuevoMotPP_a->organismo_financiador = $req->input('organismo_financiador_' . $fin);
                    $nuevoMotPP_a->formulario5           = $req->input('formulario5_a');
                    $nuevoMotPP_a->accion                = 'A';
                    $nuevoMotPP_a->id_mot                = $mot->id_mot;
                    $nuevoMotPP_a->save();
                    // $motPP_a = MotPP::orderBy('id_mot', 'DESC')->first();

                    // for ($i = 0; $i <= intval($req->input('contA' . $fin)); $i++) {
                    //     if ($req->input('a_partida_' . $fin . $i)) {

                    //         $f5 = DB::table('rl_formulario5')
                    //             ->where('areaestrategica_id', '=', $req->input('area_estrategica_a'))
                    //             ->where('configFormulado_id', '=', $req->input('id_conformulado'))
                    //             ->where('gestion_id', '=', $req->input('gestiones_id'))
                    //             ->orderBy('id', 'DESC')
                    //             ->first();

                    //         $fechaActual = Carbon::now()->format('Y-m-d');
                    //         $fechaHoraActual = Carbon::now()->format('Y-m-d H:i:s');

                    //         DB::table('rl_medida_bienservicio')
                    //             ->insert([
                    //                 'formulario5_id' => $f5->id,
                    //                 'medida_id' => 3,
                    //                 'cantidad' => 'sin/requerimiento',
                    //                 'precio_unitario' => 'sin/requerimiento',
                    //                 'total_presupuesto' => $req->input('a_partida_monto_' . $fin . $i),
                    //                 'descripcion' => 'incrementa',
                    //                 'tipo_financiamiento_id' => $fin,
                    //                 'fecha_requerida' => $fechaActual,
                    //                 'creado_el' => $fechaHoraActual,
                    //                 'editado_el' => $fechaHoraActual,
                    //             ]);
                    //         $mbs2 = DB::table('rl_medida_bienservicio')
                    //             ->orderBy('id', 'DESC')
                    //             ->first();

                    //         $nuevoMotMov_a = new MotMov();
                    //         $nuevoMotMov_a->id_detalle = $req->input('a_detalle_' . $fin . $i);
                    //         $nuevoMotMov_a->partida_codigo = $req->input('a_partida_' . $fin . $i);
                    //         $nuevoMotMov_a->partida_monto = $req->input('a_partida_monto_' . $fin . $i);
                    //         $nuevoMotMov_a->id_mbs = $mbs2->id;
                    //         $nuevoMotMov_a->descripcion = 'incrementa';
                    //         $nuevoMotMov_a->id_mot_pp = $motPP_a->id_mot_pp;
                    //         $nuevoMotMov_a->save();
                    //     }
                    // }
                }
            }
        }

        return redirect()->route('listarFormularios', $req->input('id_conformulado'))->with(['message' => 'Modificacion presupuestaria solicitada.']);
        // echo "<script>console.log("+$req->input('de_partida_1')+")</script>";
    }
}

/**
SELECT dc3.id, dc3.titulo as titulo_detalle, dc3.tercerclasificador_id, c3.codigo, c3.titulo, c3.descripcion, c3.id_clasificador_segundo
FROM rl_detalleClasiTercero as dc3
INNER JOIN rl_clasificador_tercero as c3 ON (c3.id = dc3.tercerclasificador_id)
ORDER BY c3.id ASC;
 */

/**
 * Contraseña temporal Mot: sie24Yakys200320
 */

/*
SELECT f2.id as id_f2, f4.id as id_f4, f5.id as id_f5, mbs.id AS id_mbs, mbs.tipo_financiamiento_id, dc3_mb.detalle_tercerclasif_id, dc3.id as id_dc3, dc3.titulo as titulo_detalle, c3.titulo, c3.descripcion, c3.codigo as partida, mbs.cantidad, mbs.precio_unitario, mbs.total_presupuesto
FROM rl_formulario2 as f2
INNER JOIN rl_formulario4 as f4 ON (f4.formulario2_id = f2.id)
INNER JOIN rl_formulario5 as f5 ON (f5.formulario4_id = f4.id)
INNER JOIN rl_medida_bienservicio AS mbs ON (mbs.formulario5_id = f5.id)
INNER JOIN detalleTercerClasi_medida_bn as dc3_mb ON (dc3_mb.medidabn_id = mbs.id)
INNER JOIN rl_detalleClasiTercero as dc3 ON (dc3.id = dc3_mb.detalle_tercerclasif_id)
INNER JOIN rl_clasificador_tercero as c3 ON (c3.id = dc3.tercerclasificador_id)
WHERE f2.formulario1_id = 8
AND f2.gestion_id = 4
AND mbs.tipo_financiamiento_id = 1;

SELECT f2.id as id_f2, f4.id as id_f4, f5.id as id_f5, mbs.id AS id_mbs, mbs.tipo_financiamiento_id, dc4_mb.detalle_cuartoclasif_id, dc4.id as id_dc4, dc4.titulo as titulo_detalle, c4.titulo, c4.descripcion, c4.codigo as partida, mbs.cantidad, mbs.precio_unitario, mbs.total_presupuesto
FROM rl_formulario2 as f2
INNER JOIN rl_formulario4 as f4 ON (f4.formulario2_id = f2.id)
INNER JOIN rl_formulario5 as f5 ON (f5.formulario4_id = f4.id)
INNER JOIN rl_medida_bienservicio AS mbs ON (mbs.formulario5_id = f5.id)
INNER JOIN detalleCuartoClasi_medida_bn as dc4_mb ON (dc4_mb.medidabn_id = mbs.id)
INNER JOIN rl_detalleClasiCuarto as dc4 ON (dc4.id = dc4_mb.detalle_cuartoclasif_id)
INNER JOIN rl_clasificador_cuarto as c4 ON (c4.id = dc4.cuartoclasificador_id)
WHERE f2.formulario1_id = 8
AND f2.gestion_id = 4
AND mbs.tipo_financiamiento_id = 1;

SELECT f2.id as id_f2, f4.id as id_f4, f5.id as id_f5, mbs.id AS id_mbs, mbs.tipo_financiamiento_id, dc5_mb.detalle_quintoclasif_id, dc5.id as id_dc5, dc5.titulo as titulo_detalle, c5.titulo, c5.descripcion, c5.codigo as partida, mbs.cantidad, mbs.precio_unitario, mbs.total_presupuesto
FROM rl_formulario2 as f2
INNER JOIN rl_formulario4 as f4 ON (f4.formulario2_id = f2.id)
INNER JOIN rl_formulario5 as f5 ON (f5.formulario4_id = f4.id)
INNER JOIN rl_medida_bienservicio AS mbs ON (mbs.formulario5_id = f5.id)
INNER JOIN detalleQuintoClasi_medida_bn as dc5_mb ON (dc5_mb.medidabn_id = mbs.id)
INNER JOIN rl_detalleClasiQuinto as dc5 ON (dc5.id = dc5_mb.detalle_quintoclasif_id)
INNER JOIN rl_clasificador_quinto as c5 ON (c5.id = dc5.quintoclasificador_id)
WHERE f2.formulario1_id = 8
AND f2.gestion_id = 4
AND mbs.tipo_financiamiento_id = 1;
 */
