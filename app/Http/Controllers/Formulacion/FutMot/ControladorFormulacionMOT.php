<?php
namespace App\Http\Controllers\Formulacion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\FutMot\Mot;
use App\Models\FutMot\MotMov;
use App\Models\FutMot\MotPP;
use App\Models\Gestiones;
use App\Models\Poa\Formulario5;
use App\Models\Poa\Medida_bienservicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ControladorFormulacionMOT extends Controller
{
    public function inicio()
    {
        $data['menu'] = 22;
        if (Auth::user()->id_unidad_carrera != null) {
            $data['carrera_unidad'] = UnidadCarreraArea::where('id', Auth::user()->id_unidad_carrera)->get();
            $data['gestiones']      = Gestiones::get();

            return view('formulacion.mot.inicio', $data);
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
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'mot.id_configuracion_formulado', '=', 'rcf.id')
                ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
                ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
                ->where('id_configuracion_formulado', '=', $id_conformulado)
                ->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)
                ->select('mot.*', 'rg.gestion', 'rft.descripcion')
                ->orderBy('mot.id_mot', 'desc')
                ->get();
            $carrera = UnidadCarreraArea::where('id', '=', Auth::user()->id_unidad_carrera)->first();
        } else {
            $formulado = DB::table('rl_formulario1')
                ->where('configFormulado_id', '=', $configuracion->id)
                ->where('unidadCarrera_id', '=', $id_carrera)
                ->first();
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'mot.id_configuracion_formulado', '=', 'rcf.id')
                ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
                ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
                ->where('id_configuracion_formulado', '=', $id_conformulado)
                ->where('id_unidad_carrera', '=', $id_carrera)
                ->select('mot.*', 'rg.gestion', 'rft.descripcion')
                ->orderBy('mot.id_mot', 'desc')
                ->get();
            $carrera = UnidadCarreraArea::where('id', '=', $id_carrera)->first();
        }

        $fecha_actual         = Carbon::now()->format('Y-m-d');
        $data['fecha_actual'] = $fecha_actual;
        $hora_actual          = Carbon::now()->format('H:i');
        $data['hora_actual']  = $hora_actual;

        $data['menu']          = 22;
        $data['configuracion'] = $configuracion;
        $data['mot']           = $mot;
        $data['formulado']     = $formulado;
        $data['carrera']       = $carrera;

        return view('formulacion.mot.lista', $data);
    }

    public function formulario($id_formulado, $gestiones_id, $id_conformulado)
    {
        $id_formulado    = Crypt::decryptString($id_formulado);
        $gestiones_id    = Crypt::decryptString($gestiones_id);
        $id_conformulado = Crypt::decryptString($id_conformulado);

        $nro_mot = DB::table('mot')
        // ->where('id_unidad_carrera', '=', Auth::user()->id_unidad_carrera)
            ->join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'mot.id_configuracion_formulado')
            ->where('rcf.gestiones_id', $gestiones_id)
            ->orderBy('mot.nro', 'desc')
            ->select('mot.*')
            ->first();

        $data['menu']            = 22;
        $data['id_formulado']    = $id_formulado;
        $data['gestiones_id']    = $gestiones_id;
        $data['id_conformulado'] = $id_conformulado;
        $data['nro_mot']         = $nro_mot;

        $financiamientos = Medida_bienservicio::join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'rl_medida_bienservicio.tipo_financiamiento_id')
            ->where('rl_medida_bienservicio.total_presupuesto', '>', 0.00)
            ->where('f5.gestion_id', $gestiones_id)
            ->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera)
            ->select('ft.*')
            ->distinct('')
            ->get();

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

        $data['financiamientos']     = $financiamientos;
        $data['partidas_formulado3'] = $partidas_formulado3;
        $data['partidas_formulado4'] = $partidas_formulado4;
        $data['partidas_formulado5'] = $partidas_formulado5;
        $data['gestion']             = Gestiones::find($gestiones_id);

        return view('formulacion.mot.formulario', $data);
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

    public function realizarModificacion(Request $req)
    {
        // dd($req);
        // die();

        $areas_estrategicas     = array_values(array_unique($req->areas_estrategicas));
        $objetivo_institucional = array_values(array_unique($req->objetivo_institucional));
        $operacion              = array_values(array_unique($req->operacion));

        $nuevoMot                             = new Mot();
        $nuevoMot->id_configuracion_formulado = $req->input('id_conformulado');
        $nuevoMot->nro                        = intval($req->input('nro_mot'));
        $nuevoMot->area_estrategica_de        = $areas_estrategicas;
        $nuevoMot->objetivo_gestion_de        = $objetivo_institucional;
        $nuevoMot->tarea_proyecto_de          = $operacion;

        $nuevoMot->ae_de_importe = sin_separador_comas($req->input('monto_poa'));
        $nuevoMot->og_de_importe = sin_separador_comas($req->input('monto_poa'));
        $nuevoMot->tp_de_importe = sin_separador_comas($req->input('monto_poa'));

        $nuevoMot->importe           = sin_separador_comas($req->input('monto_poa'));
        $nuevoMot->id_unidad_carrera = Auth::user()->id_unidad_carrera;
        $nuevoMot->id_usuario        = Auth::user()->id;
        $nuevoMot->save();

        $financiamientos = collect($req->finan)->sort()->values()->all();
        $montos          = $req->monto;
        $ids             = $req->id;
        $form5           = $req->form5;
        $partidas        = $req->partidas;
        $detalles        = $req->detalles;

        // dd($financiamientos);

        $fin        = 0;
        $nuevoMotPP = [];
        foreach ($financiamientos as $key => $value) {
            if ($value != $fin) {
                $fin = $value;

                $nuevoMotPP                        = new MotPP();
                $nuevoMotPP->organismo_financiador = $fin;
                $nuevoMotPP->saldo                 = sin_separador_comas($req->input('monto_poa'));
                $nuevoMotPP->formulario5           = $form5[$key];
                $nuevoMotPP->accion                = 'DE';
                $nuevoMotPP->id_mot                = $nuevoMot->id_mot;
                $nuevoMotPP->save();

                $nuevoMotPPa                        = new MotPP();
                $nuevoMotPPa->organismo_financiador = $fin;
                $nuevoMotPPa->saldo                 = sin_separador_comas($req->input('monto_poa'));
                $nuevoMotPPa->formulario5           = $form5[$key];
                $nuevoMotPPa->accion                = 'A';
                $nuevoMotPPa->id_mot                = $nuevoMot->id_mot;
                $nuevoMotPPa->save();
            }

            $nuevoMotMov                 = new MotMov();
            $nuevoMotMov->id_detalle     = $detalles[$key];
            $nuevoMotMov->partida_codigo = $partidas[$key];
            $nuevoMotMov->partida_monto  = sin_separador_comas($montos[$key]);
            $nuevoMotMov->id_mbs         = $ids[$key];
            $nuevoMotMov->descripcion    = 'modifica';
            $nuevoMotMov->id_mot_pp      = $nuevoMotPP->id_mot_pp;
            $nuevoMotMov->save();

            $mbs                    = Medida_bienservicio::find($ids[$key]);
            $mbs->total_presupuesto = $mbs->total_presupuesto - sin_separador_comas($montos[$key]);
            $mbs->save();
        }

        session()->flash('message', 'Formulario realizado con éxito.');
        return redirect()->route('mot.listar', [$req->input('id_conformulado'), Auth::user()->id_unidad_carrera]);
    }

    public function formular($id_mot)
    {
        $mot           = Mot::where('id_mot', '=', $id_mot)->first();
        $configuracion = DB::table('rl_configuracion_formulado as rcf')
            ->join('rl_formulado_tipo as rft', 'rcf.formulado_id', '=', 'rft.id')
            ->join('rl_gestiones as rg', 'rcf.gestiones_id', '=', 'rg.id')
            ->where('rcf.id', '=', $mot->id_configuracion_formulado)
            ->select('rcf.*', 'rft.descripcion', 'rg.gestion', 'rcf.codigo')
            ->first();
        $formulado = DB::table('rl_formulario1')
            ->where('configFormulado_id', '=', $configuracion->id)
            ->where('unidadCarrera_id', '=', $mot->id_unidad_carrera)
            ->first();
        $financiamientos = MotPP::where('id_mot', '=', $mot->id_mot)->get();
        $medidas         = DB::table('rl_medida')->get();

        $data['menu']            = 22;
        $data['mot']             = $mot;
        $data['configuracion']   = $configuracion;
        $data['formulado']       = $formulado;
        $data['financiamientos'] = $financiamientos;
        $data['medidas']         = $medidas;

        $data['id_formulado']    = $formulado->id;
        $data['gestiones_id']    = $formulado->gestion_id;
        $data['id_conformulado'] = $configuracion->id;
        $data['nro_mot']         = $mot->nro;

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

        $partidas = MotPP::join('mot_movimiento as mm', 'mm.id_mot_pp', '=', 'mot_partidas_presupuestarias.id_mot_pp')
            ->where('mot_partidas_presupuestarias.accion', 'DE')
            ->pluck('mm.partida_codigo')
            ->toArray();

        $partidas3 = DB::table('rl_detalleClasiTercero as dc3')
            ->join('rl_clasificador_tercero as c3', 'c3.id', '=', 'dc3.tercerclasificador_id')
            ->where('dc3.estado', '=', 'activo')
            ->whereNotIn('c3.codigo', $partidas)
            ->select('dc3.id', 'dc3.titulo as titulo_detalle', 'dc3.tercerclasificador_id', 'c3.codigo as partida', 'c3.titulo', 'c3.descripcion', 'c3.id_clasificador_segundo')
            ->orderBy('c3.id', 'ASC')
            ->get();
        $partidas4 = DB::table('rl_detalleClasiCuarto as dc4')
            ->join('rl_clasificador_cuarto as c4', 'c4.id', '=', 'dc4.cuartoclasificador_id')
            ->where('dc4.estado', '=', 'activo')
            ->whereNotIn('c4.codigo', $partidas)
            ->select('dc4.id', 'dc4.titulo as titulo_detalle', 'dc4.cuartoclasificador_id', 'c4.codigo as partida', 'c4.titulo', 'c4.descripcion', 'c4.id_clasificador_tercero')
            ->orderBy('c4.id', 'ASC')
            ->get();
        $partidas5 = DB::table('rl_detalleClasiQuinto as dc5')
            ->join('rl_clasificador_quinto as c5', 'c5.id', '=', 'dc5.quintoclasificador_id')
            ->where('dc5.estado', '=', 'activo')
            ->whereNotIn('c5.codigo', $partidas)
            ->select('dc5.id', 'dc5.titulo as titulo_detalle', 'dc5.quintoclasificador_id', 'c5.codigo as partida', 'c5.titulo', 'c5.descripcion', 'c5.id_clasificador_cuarto')
            ->orderBy('c5.id', 'ASC')
            ->get();

        $data['partidas_formulado3'] = $partidas_formulado3;
        $data['partidas_formulado4'] = $partidas_formulado4;
        $data['partidas_formulado5'] = $partidas_formulado5;
        $data['partidas3']           = $partidas3;
        $data['partidas4']           = $partidas4;
        $data['partidas5']           = $partidas5;

        return view('formulacion.mot.detalle', $data);
    }

    public function objetivos(Request $req)
    {
        $objetivos = Formulario5::join('rl_formulario4 as f4', 'f4.id', '=', 'rl_formulario5.formulario4_id')
            ->join('rl_operaciones as op', 'op.id', '=', 'rl_formulario5.operacion_id')
            ->join('formulario2_objInstitucional as f2_oins', 'f2_oins.formulario2_id', '=', 'f4.formulario2_id')
            ->join('rl_objetivo_institucional as oins', 'oins.id', '=', 'f2_oins.objInstitucional_id')
            ->join('rl_areas_estrategicas as ae', 'ae.id', '=', 'op.area_estrategica_id')
            ->whereIn('rl_formulario5.id', $req->form5)
            ->select('rl_formulario5.id', 'op.id as op_id', 'op.descripcion as op_descripcion', 'oins.id as oins_id', 'oins.codigo as oins_codigo', 'oins.descripcion as oins_descripcion', 'ae.id as ae_id', 'ae.codigo_areas_estrategicas as ae_codigo', 'ae.descripcion as ae_descripcion')
            ->get();

        return response()->json($objetivos);
    }

    public function editarMonto(Request $req)
    {
        if ($req->accion == 'DE') {
            $mbs                    = Medida_bienservicio::find($req->id_mbs);
            $total                  = sin_separador_comas($req->monto_actual) + sin_separador_comas($mbs->total_presupuesto);
            $mbs->total_presupuesto = $total - sin_separador_comas($req->monto);
            $mbs->save();

            $mov                = MotMov::find($req->id);
            $mov->partida_monto = sin_separador_comas($req->monto);
            $mov->save();

            $mot          = Mot::find($mov->motpp->id_mot);
            $dif          = sin_separador_comas($req->monto) - sin_separador_comas($req->monto_actual);
            $mot->importe = $mot->importe + $dif;
            $mot->save();

            session()->flash('message', 'Monto modificado exitosamente.');
            return redirect()->back();
        } else {
            $mbs                    = Medida_bienservicio::find($req->id_mbs);
            $mbs->total_presupuesto = sin_separador_comas($req->monto);
            $mbs->save();

            $mov                = MotMov::find($req->id);
            $mov->partida_monto = sin_separador_comas($req->monto);
            $mov->save();

            $motPP        = MotPP::find($mov->motpp->id_mot_pp);
            $saldo        = $motPP->mot_a($motPP->id_mot)->saldo + sin_separador_comas($req->monto_actual);
            $motPP->saldo = $saldo - sin_separador_comas($req->monto);
            $motPP->save();

            session()->flash('message', 'Monto modificado exitosamente.');
            return redirect()->back();
        }
    }
    public function eliminarMonto(Request $req)
    {
        if ($req->accion == 'DE') {
            $mov = MotMov::find($req->id);

            $mbs                    = Medida_bienservicio::find($mov->id_mbs);
            $mbs->total_presupuesto = $mbs->total_presupuesto + $mov->partida_monto;
            $mbs->save();

            $mot          = Mot::find($mov->motpp->id_mot);
            $mot->importe = $mot->importe - $mov->partida_monto;
            $mot->save();

            $mov->delete();

            session()->flash('success', 'Movimiento eliminado correctamente.');

            return response()->json([
                'success' => true,
            ], 200);
        } else {
            $mov = MotMov::find($req->id);
            $mbs = Medida_bienservicio::find($mov->id_mbs);

            $motPP        = MotPP::find($mov->motpp->id_mot_pp);
            $saldo        = $motPP->mot_a($motPP->id_mot)->saldo + $mov->partida_monto;
            $motPP->saldo = $saldo;
            $motPP->save();

            $mbs->delete();
            $mov->delete();

            session()->flash('success', 'Movimiento eliminado correctamente.');

            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function agregar(Request $req)
    {
        // return response()->json($req);

        $mbs                         = new Medida_bienservicio();
        $mbs->formulario5_id         = $req->objetivo_gestion;
        $mbs->medida_id              = $req->medida;
        $mbs->cantidad               = $req->cantidad;
        $mbs->precio_unitario        = sin_separador_comas($req->precio_unitario);
        $mbs->total_presupuesto      = sin_separador_comas($req->total_presupuesto);
        $mbs->total_monto            = sin_separador_comas($req->total_presupuesto);
        $mbs->descripcion            = 'incrementa';
        $mbs->tipo_financiamiento_id = $req->organismo_financiador;
        $mbs->fecha_requerida        = $req->fecha_requerida;
        $mbs->save();

        $motMov                 = new MotMov();
        $motMov->id_detalle     = $req->partida_a;
        $motMov->partida_codigo = $req->partida;
        $motMov->partida_monto  = sin_separador_comas($req->total_presupuesto);
        $motMov->id_mbs         = $mbs->id;
        $motMov->descripcion    = 'incrementa';
        $motMov->id_mot_pp      = $req->id_mot_pp;
        $motMov->save();

        $motPP        = MotPP::find($req->id_mot_pp);
        $motPP->saldo = $motPP->saldo - sin_separador_comas($req->total_presupuesto);
        $motPP->save();

        session()->flash('mensaje', 'Movimiento agregado correctamente');
        return redirect()->route('mot.detalle', $motPP->id_mot);
    }

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
                    $mbs->save();

                    $mov->descripcion = 'revertido';
                } else {
                    $mbs = Medida_bienservicio::find($mov->id_mbs);
                    $mbs->delete();

                    $mov->descripcion = 'eliminado';
                }

                $mov->save();
            }
        }

        $mot->save();

        session()->flash('message', 'Formulario validado exitosamente.');
        return redirect()->back();
    }

    public function ejecutarFormulario(Request $req)
    {
        $mot         = Mot::find($req->id_mot);
        $mot->estado = 'ejecutado';
        $mot->save();

        session()->flash('message', 'Formulario ejecutado exitosamente.');
        return redirect()->back();
    }

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
                ->select('mot.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->get();
        } else if ($nro != 0 && $gestiones_id == 0) {
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'mot.id_configuracion_formulado')
                ->where('nro', 'like', '%' . $nro . '%')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'mot.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->select('mot.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->get();
        } else if ($nro == 0 && $gestiones_id != 0) {
            $mot = Mot::join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'mot.id_configuracion_formulado')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'mot.id_unidad_carrera')
                ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
                ->join('rl_gestiones as rg', 'rg.id', '=', 'rcf.gestiones_id')
                ->where('rcf.gestiones_id', $gestiones_id)
                ->select('mot.*', 'uc.nombre_completo as carrera', 'rft.descripcion as formulado', 'rg.gestion')
                ->get();
        } else {
            $mot = [];
        }

        return response()->json([
            'nro'          => $nro,
            'gestiones_id' => $gestiones_id,
            'data'         => $mot,
        ], 200);
    }

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
