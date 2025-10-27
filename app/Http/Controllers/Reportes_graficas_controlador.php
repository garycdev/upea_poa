<?php
namespace App\Http\Controllers;

use App\Models\Gestion;
use App\Models\Poa\Medida_bienservicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reportes_graficas_controlador extends Controller
{
    /**
     * GRAFICOS
     */

    // Montos por gestión
    public function ver_gestion_gastos(Request $req)
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $gestions = $req->gestions;
        $gestion  = Gestion::find($gestions);

        if (! $gestion) {
            return response()->json(['sumas_gestion' => []]);
        }

        $años = range($gestion->inicio_gestion, $gestion->fin_gestion);

        $query = DB::table('rl_gestiones as ges')
            ->join('rl_configuracion_formulado as config', 'config.gestiones_id', '=', 'ges.id')
            ->join('rl_formulario5 as f5', 'f5.configFormulado_id', '=', 'config.id')
            ->join('rl_medida_bienservicio as mbs', 'mbs.formulario5_id', '=', 'f5.id')
            ->where('ges.id_gestion', $gestions)
            ->select(
                'ges.gestion',
                DB::raw('SUM(mbs.total_monto) as total_monto_sum'),
                DB::raw('(SUM(mbs.total_monto) - SUM(mbs.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(mbs.total_presupuesto) as total_pendiente_sum'),
            )
            ->groupBy('ges.gestion');

        if ($rol->name === 'usuario') {
            $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
        }

        $suma_por_gestion = $query->get()->keyBy('gestion');

        $sumas_gestion_final = collect($años)->map(function ($anio) use ($suma_por_gestion) {
            $datos = $suma_por_gestion->get($anio);
            return [
                'gestion'               => $anio,
                'total_monto_sum'       => $datos->total_monto_sum ?? 0,
                'total_presupuesto_sum' => $datos->total_presupuesto_sum ?? 0,
                'total_pendiente_sum'   => $datos->total_pendiente_sum ?? 0,
            ];
        });

        return response()->json($sumas_gestion_final);
    }

    // Montos por financiamiento
    public function ver_financiamiento_gastos(Request $req)
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $gestion = $req->gestion;

        $todas_fuentes = DB::table('rl_financiamiento_tipo')->pluck('descripcion');

        $query = DB::table('rl_financiamiento_tipo as ft')
            ->join('rl_medida_bienservicio as mbs', 'mbs.tipo_financiamiento_id', '=', 'ft.id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->join('rl_gestiones as ges', 'ges.id', '=', 'config.gestiones_id')
            ->where('ges.id', $gestion)
            ->select(
                'ft.descripcion',
                DB::raw('SUM(mbs.total_monto) as total_monto_sum'),
                DB::raw('(SUM(mbs.total_monto) - SUM(mbs.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(mbs.total_presupuesto) as total_pendiente_sum')
            )
            ->groupBy('ft.descripcion');

        if ($rol->name === 'usuario') {
            $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
        }

        $sumas = $query->get()->keyBy('descripcion');

        $resultado_final = collect($todas_fuentes)->map(function ($fuente) use ($sumas) {
            $val = $sumas->get($fuente);
            return [
                'descripcion'           => $fuente,
                'total_monto_sum'       => $val->total_monto_sum ?? 0,
                'total_presupuesto_sum' => $val->total_presupuesto_sum ?? 0,
                'total_pendiente_sum'   => $val->total_pendiente_sum ?? 0,
            ];
        });

        return response()->json($resultado_final->values());
    }

    // Montos por partidas
    public function ver_partidas_gastos(Request $req)
    {
        $rol = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $gestion = $req->gestion;

        $q3 = Medida_bienservicio::join('detalleTercerClasi_medida_bn as detalle_mbs3', 'detalle_mbs3.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiTercero as detalle3', 'detalle3.id', '=', 'detalle_mbs3.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as clasi3', 'clasi3.id', '=', 'detalle3.tercerclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->where('config.gestiones_id', $gestion)
            ->when($rol->name === 'usuario', function ($query) {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            })
            ->select(
                'clasi3.codigo',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
            )
            ->groupBy('clasi3.codigo');

        $q4 = Medida_bienservicio::join('detalleCuartoClasi_medida_bn as detalle_mbs4', 'detalle_mbs4.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiCuarto as detalle4', 'detalle4.id', '=', 'detalle_mbs4.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as clasi4', 'clasi4.id', '=', 'detalle4.cuartoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->where('config.gestiones_id', $gestion)
            ->when($rol->name === 'usuario', function ($query) {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            })
            ->select(
                'clasi4.codigo',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
            )
            ->groupBy('clasi4.codigo');

        $q5 = Medida_bienservicio::join('detalleQuintoClasi_medida_bn as detalle_mbs5', 'detalle_mbs5.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiQuinto as detalle5', 'detalle5.id', '=', 'detalle_mbs5.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as clasi5', 'clasi5.id', '=', 'detalle5.quintoclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->where('config.gestiones_id', $gestion)
            ->when($rol->name === 'usuario', function ($query) {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            })
            ->select(
                'clasi5.codigo',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
            )
            ->groupBy('clasi5.codigo');

        $union = $q3->unionAll($q4)->unionAll($q5);

        $sumas_partidas = DB::table(DB::raw("({$union->toSql()}) as u"))
            ->mergeBindings($union->getQuery())
            ->select(
                'codigo',
                DB::raw('SUM(total_monto_sum) as total_monto_sum'),
                DB::raw('SUM(total_presupuesto_sum) as total_presupuesto_sum'),
                DB::raw('SUM(total_pendiente_sum) as total_pendiente_sum')
            )
            ->groupBy('codigo')
            ->orderByDesc('total_monto_sum')
            ->get()
            ->sortBy('codigo')
            ->values();

        return response()->json($sumas_partidas);
    }

    // Montos por carreras
    public function ver_carreras_gastos(Request $req)
    {
        $gestion = $req->gestion;
        $rol     = DB::table('model_has_roles as mhr')
            ->join('roles', 'roles.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', Auth::user()->id)
            ->first();

        $base = function () use ($gestion, $rol) {
            $query = Medida_bienservicio::join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
                ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'f5.unidadCarrera_id')
                ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
                ->where('config.gestiones_id', $gestion);

            if ($rol->name == 'usuario') {
                $query->where('f5.unidadCarrera_id', Auth::user()->id_unidad_carrera);
            }

            return $query;
        };

        $q3 = $base()
            ->join('detalleTercerClasi_medida_bn as detalle_mbs3', 'detalle_mbs3.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiTercero as detalle3', 'detalle3.id', '=', 'detalle_mbs3.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as clasi3', 'clasi3.id', '=', 'detalle3.tercerclasificador_id')
            ->select(
                'uc.id',
                'uc.nombre_completo as carrera',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
            )
            ->groupBy('uc.id', 'uc.nombre_completo');

        $q4 = $base()
            ->join('detalleCuartoClasi_medida_bn as detalle_mbs4', 'detalle_mbs4.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiCuarto as detalle4', 'detalle4.id', '=', 'detalle_mbs4.detalle_cuartoclasif_id')
            ->join('rl_clasificador_cuarto as clasi4', 'clasi4.id', '=', 'detalle4.cuartoclasificador_id')
            ->select(
                'uc.id',
                'uc.nombre_completo as carrera',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
            )
            ->groupBy('uc.id', 'uc.nombre_completo');

        $q5 = $base()
            ->join('detalleQuintoClasi_medida_bn as detalle_mbs5', 'detalle_mbs5.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiQuinto as detalle5', 'detalle5.id', '=', 'detalle_mbs5.detalle_quintoclasif_id')
            ->join('rl_clasificador_quinto as clasi5', 'clasi5.id', '=', 'detalle5.quintoclasificador_id')
            ->select(
                'uc.id',
                'uc.nombre_completo as carrera',
                DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
            )
            ->groupBy('uc.id', 'uc.nombre_completo');

        $union = $q3->unionAll($q4)->unionAll($q5);

        $sumas_carrera = DB::table(DB::raw("({$union->toSql()}) as u"))
            ->mergeBindings($union->getQuery())
            ->select(
                'carrera',
                DB::raw('SUM(total_monto_sum) as total_monto_sum'),
                DB::raw('SUM(total_presupuesto_sum) as total_presupuesto_sum'),
                DB::raw('SUM(total_pendiente_sum) as total_pendiente_sum')
            )
            ->groupBy('carrera')
            ->orderByDesc('total_monto_sum')
            ->limit(15)
            ->get();

        return response()->json($sumas_carrera);
    }
}
