<?php
namespace App\Http\Controllers;

use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestion;
use App\Models\Gestiones;
use App\Models\Poa\Medida_bienservicio;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Reportes_PDF_controlador extends Controller
{
    public function inicio()
    {
        $data['menu'] = 24;
        // $data['gestion'] = Gestion::get();

        // Todas las gestiones
        $data['gestion']   = Gestion::get();
        $data['gestiones'] = Gestiones::orderBy('gestion', 'ASC')->get();
        $data['fuente']    = Financiamiento_tipo::get();
        $data['cua']       = UnidadCarreraArea::get();
        return view('reportes.graficas.inicio', $data);
    }

    public function generarPdf(Request $req)
    {
        $graficos = $req->has('graficos') ? 1 : 0;
        $partidas = $req->has('partidas') ? 1 : 0;

        switch ($req->filtrar) {
            case '1':
                return redirect()->route('pdf.gestion', [encriptar(1), encriptar($req->gestion), encriptar($req->fuente_fin), encriptar($req->cua), encriptar($graficos), encriptar($partidas)]);
                break;
            case '2':
                return redirect()->route('pdf.gestion', [encriptar(2), encriptar($req->gestion_esp), encriptar($req->fuente_fin), encriptar($req->cua), encriptar($graficos), encriptar($partidas)]);
                break;
            case '3':
                return redirect()->route('pdf.fecha', [encriptar(3), encriptar($req->fuente_fin), encriptar($req->cua), encriptar($graficos), encriptar($partidas), encriptar($req->periodos), encriptar(0), encriptar($req->tipo)]);
                break;
            case '4':
                [$inicio, $fin] = explode(' - ', $req->rango);
                $inicio         = Carbon::parse($inicio);
                $fin            = Carbon::parse($fin);

                return redirect()->route('pdf.fecha', [encriptar(4), encriptar($req->fuente_fin), encriptar($req->cua), encriptar($graficos), encriptar($partidas), encriptar($inicio->timestamp), encriptar($fin->timestamp), encriptar($req->tipo)]);
                break;
            default:
                dd($req);
                break;
        }
    }

    public function filtrar_gestion($tipo, $id_gestion, $id_financiamiento, $id_unidad_carrera, $graficos, $partidas)
    {
        $tipo              = desencriptar($tipo);
        $id_gestion        = desencriptar($id_gestion);
        $id_financiamiento = desencriptar($id_financiamiento);
        $id_unidad_carrera = desencriptar($id_unidad_carrera);
        $graficos          = desencriptar($graficos);
        $partidas          = desencriptar($partidas);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        if ($tipo == 1) {
            $gestion = Gestion::findOrFail($id_gestion);
            $años   = range($gestion->inicio_gestion, $gestion->fin_gestion);
        } else {
            $gestion = Gestiones::findOrFail($id_gestion);
            $años   = range($gestion->gestion, $gestion->gestion);
        }

        $todas_fuentes = DB::table('rl_financiamiento_tipo')
            ->select('id', 'sigla')
            ->orderBy('sigla')
            ->get();

        if ($partidas) {
            $q3 = Medida_bienservicio::join('detalleTercerClasi_medida_bn as detalle_mbs3', 'detalle_mbs3.medidabn_id', '=', 'rl_medida_bienservicio.id')
                ->join('rl_detalleClasiTercero as detalle3', 'detalle3.id', '=', 'detalle_mbs3.detalle_tercerclasif_id')
                ->join('rl_clasificador_tercero as clasi3', 'clasi3.id', '=', 'detalle3.tercerclasificador_id')
                ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
                ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
                ->join('rl_gestiones as ges', 'ges.id', '=', 'config.gestiones_id')
                ->leftJoin('rl_financiamiento_tipo as ft', 'ft.id', '=', 'rl_medida_bienservicio.tipo_financiamiento_id')
                ->select(
                    'clasi3.codigo',
                    'ft.id as id_financiamiento',
                    'f5.unidadCarrera_id',
                    'ges.gestion as gestion',
                    DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                    DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                    DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
                )
                ->groupBy('clasi3.codigo', 'ft.id', 'f5.unidadCarrera_id', 'ges.gestion');

            $q4 = Medida_bienservicio::join('detalleCuartoClasi_medida_bn as detalle_mbs4', 'detalle_mbs4.medidabn_id', '=', 'rl_medida_bienservicio.id')
                ->join('rl_detalleClasiCuarto as detalle4', 'detalle4.id', '=', 'detalle_mbs4.detalle_cuartoclasif_id')
                ->join('rl_clasificador_cuarto as clasi4', 'clasi4.id', '=', 'detalle4.cuartoclasificador_id')
                ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
                ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
                ->join('rl_gestiones as ges', 'ges.id', '=', 'config.gestiones_id')
                ->leftJoin('rl_financiamiento_tipo as ft', 'ft.id', '=', 'rl_medida_bienservicio.tipo_financiamiento_id')
                ->select(
                    'clasi4.codigo',
                    'ft.id as id_financiamiento',
                    'f5.unidadCarrera_id',
                    'ges.gestion as gestion',
                    DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                    DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                    DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
                )
                ->groupBy('clasi4.codigo', 'ft.id', 'f5.unidadCarrera_id', 'ges.gestion');

            $q5 = Medida_bienservicio::join('detalleQuintoClasi_medida_bn as detalle_mbs5', 'detalle_mbs5.medidabn_id', '=', 'rl_medida_bienservicio.id')
                ->join('rl_detalleClasiQuinto as detalle5', 'detalle5.id', '=', 'detalle_mbs5.detalle_quintoclasif_id')
                ->join('rl_clasificador_quinto as clasi5', 'clasi5.id', '=', 'detalle5.quintoclasificador_id')
                ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
                ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
                ->join('rl_gestiones as ges', 'ges.id', '=', 'config.gestiones_id')
                ->leftJoin('rl_financiamiento_tipo as ft', 'ft.id', '=', 'rl_medida_bienservicio.tipo_financiamiento_id')
                ->select(
                    'clasi5.codigo',
                    'ft.id as id_financiamiento',
                    'f5.unidadCarrera_id',
                    'ges.gestion as gestion',
                    DB::raw('SUM(rl_medida_bienservicio.total_monto) as total_monto_sum'),
                    DB::raw('(SUM(rl_medida_bienservicio.total_monto) - SUM(rl_medida_bienservicio.total_presupuesto)) as total_presupuesto_sum'),
                    DB::raw('SUM(rl_medida_bienservicio.total_presupuesto) as total_pendiente_sum')
                )
                ->groupBy('clasi5.codigo', 'ft.id', 'f5.unidadCarrera_id', 'ges.gestion');

            $union = $q3->unionAll($q4)->unionAll($q5);

            $basePartidas = DB::table(DB::raw("({$union->toSql()}) as base"))
                ->mergeBindings($union->getQuery())
                ->select(
                    'codigo',
                    'id_financiamiento',
                    'unidadCarrera_id',
                    'gestion',
                    DB::raw('SUM(total_monto_sum) as total_monto_sum'),
                    DB::raw('SUM(total_presupuesto_sum) as total_presupuesto_sum'),
                    DB::raw('SUM(total_pendiente_sum) as total_pendiente_sum')
                )
                ->groupBy('codigo', 'id_financiamiento', 'unidadCarrera_id', 'gestion');
        }

        if ($tipo == 1) {
            $base = DB::table('rl_gestiones as ges')
                ->join('rl_configuracion_formulado as config', 'config.gestiones_id', '=', 'ges.id')
                ->join('rl_formulario5 as f5', 'f5.configFormulado_id', '=', 'config.id')
                ->join('rl_medida_bienservicio as mbs', 'mbs.formulario5_id', '=', 'f5.id')
                ->leftJoin('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
                ->leftJoin('rl_unidad_carrera as uc', 'uc.id', '=', 'f5.unidadCarrera_id')
                ->whereBetween('ges.gestion', [$gestion->inicio_gestion, $gestion->fin_gestion])
                ->select(
                    'ges.gestion',
                    'ft.id as fuente_id',
                    'ft.sigla as fuente',
                    'uc.id as unidad_id',
                    'uc.nombre_completo as unidad',
                    DB::raw('SUM(mbs.total_monto) as total_monto_sum'),
                    DB::raw('(SUM(mbs.total_monto) - SUM(mbs.total_presupuesto)) as total_presupuesto_sum'),
                    DB::raw('SUM(mbs.total_presupuesto) as total_pendiente_sum'),
                )
                ->groupBy('ges.gestion', 'ft.id', 'ft.sigla', 'uc.id', 'uc.nombre_completo');

            if ($partidas) {
                $basePartidas->whereIn('gestion', range($gestion->inicio_gestion, $gestion->fin_gestion));
            }
            $gestion_det = "{$gestion->inicio_gestion} - {$gestion->fin_gestion}";
        } else {
            $base = DB::table('rl_gestiones as ges')
                ->join('rl_configuracion_formulado as config', 'config.gestiones_id', '=', 'ges.id')
                ->join('rl_formulario5 as f5', 'f5.configFormulado_id', '=', 'config.id')
                ->join('rl_medida_bienservicio as mbs', 'mbs.formulario5_id', '=', 'f5.id')
                ->leftJoin('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mbs.tipo_financiamiento_id')
                ->leftJoin('rl_unidad_carrera as uc', 'uc.id', '=', 'f5.unidadCarrera_id')
                ->where('ges.id', $gestion->id)
                ->select(
                    'ges.gestion',
                    'ft.id as fuente_id',
                    'ft.sigla as fuente',
                    'uc.id as unidad_id',
                    'uc.nombre_completo as unidad',
                    DB::raw('SUM(mbs.total_monto) as total_monto_sum'),
                    DB::raw('(SUM(mbs.total_monto) - SUM(mbs.total_presupuesto)) as total_presupuesto_sum'),
                    DB::raw('SUM(mbs.total_presupuesto) as total_pendiente_sum'),
                )
                ->groupBy('ges.gestion', 'ft.id', 'ft.sigla', 'uc.id', 'uc.nombre_completo');

            if ($partidas) {
                $basePartidas->where('gestion', $gestion->gestion);
            }
            $gestion_det = "{$gestion->gestion}";
        }

        $data['financiamiento'] = null;
        if ($id_financiamiento != 0) {
            $base->where('ft.id', $id_financiamiento);
            $data['financiamiento'] = Financiamiento_tipo::findOrFail($id_financiamiento);

            if ($partidas) {
                $basePartidas->where('id_financiamiento', $id_financiamiento);
            }
        }

        $data['unidad_carrera'] = null;
        if ($id_unidad_carrera != 0) {
            $base->where('uc.id', $id_unidad_carrera);
            $data['unidad_carrera'] = UnidadCarreraArea::findOrFail($id_unidad_carrera);

            if ($partidas) {
                $basePartidas->where('unidadCarrera_id', $id_unidad_carrera);
            }
        }

        if ($partidas) {
            $sumas_partidas = $basePartidas
                ->orderBy('gestion')
                ->orderBy('codigo')
                ->get()
                ->groupBy('gestion');

            $porGestionPartida = collect($años)->map(function ($anio) use ($sumas_partidas) {
                return [
                    'gestion'  => $anio,
                    'partidas' => $sumas_partidas->get($anio, collect([]))->map(function ($p) {
                        return (array) $p;
                    })->values(),
                ];
            });
        }

        $data['graficos'] = $graficos;
        $data['partidas'] = $partidas;

        $base = $base->get();

        $porGestion = collect($años)->map(function ($anio) use ($base) {
            $items = $base->where('gestion', $anio);
            return [
                'gestion'               => $anio,
                'total_monto_sum'       => $items->sum('total_monto_sum'),
                'total_presupuesto_sum' => $items->sum('total_presupuesto_sum'),
                'total_pendiente_sum'   => $items->sum('total_pendiente_sum'),
            ];
        });

        if ($id_financiamiento == 0) {
            $porGestionFuente = collect($años)->map(function ($anio) use ($base, $todas_fuentes) {
                $items = $base->where('gestion', $anio);

                $fuentes = $todas_fuentes->map(function ($f) use ($items) {
                    $datos = $items->where('fuente_id', $f->id);
                    return [
                        'fuente'                => $f->sigla ?? $f->descripcion,
                        'total_monto_sum'       => $datos->sum('total_monto_sum'),
                        'total_presupuesto_sum' => $datos->sum('total_presupuesto_sum'),
                        'total_pendiente_sum'   => $datos->sum('total_pendiente_sum'),
                    ];
                });

                return [
                    'gestion' => $anio,
                    'fuentes' => $fuentes,
                ];
            });
        } else {
            $fuenteObj = $todas_fuentes->firstWhere('id', $id_financiamiento) ?? (object) ['id' => $id_financiamiento, 'sigla' => null, 'descripcion' => 'Sin fuente'];

            $label = $fuenteObj->sigla ?? $fuenteObj->descripcion;

            $porGestionFuente = collect($años)->map(function ($anio) use ($base, $id_financiamiento, $label) {
                $items = $base->where('gestion', $anio);
                $datos = $items->where('fuente_id', $id_financiamiento);

                return [
                    'gestion' => $anio,
                    'fuentes' => [[
                        'fuente'                => $label,
                        'total_monto_sum'       => $datos->sum('total_monto_sum'),
                        'total_presupuesto_sum' => $datos->sum('total_presupuesto_sum'),
                        'total_pendiente_sum'   => $datos->sum('total_pendiente_sum'),
                    ]],
                ];
            });
        }

        $todas_unidades = $base->unique('unidad_id')->map(function ($item) {
            return (object) [
                'id'     => $item->unidad_id,
                'nombre' => $item->unidad,
            ];
        });

        $porGestionUnidad = collect($años)->map(function ($anio) use ($base, $todas_unidades) {
            $items = $base->where('gestion', $anio);

            $unidades = $todas_unidades->map(function ($u) use ($items) {
                $datos = $items->where('unidad_id', $u->id);

                return [
                    'unidad'                => $u->nombre ?? 'Sin unidad',
                    'total_monto_sum'       => $datos->sum('total_monto_sum'),
                    'total_presupuesto_sum' => $datos->sum('total_presupuesto_sum'),
                    'total_pendiente_sum'   => $datos->sum('total_pendiente_sum'),
                ];
            });

            return [
                'gestion'  => $anio,
                'unidades' => $unidades,
            ];
        });

        if ($partidas) {
            $data['datos'] = [
                'rango'                => $gestion_det,
                'por_gestion'          => $porGestion,
                'por_gestion_fuente'   => $porGestionFuente,
                'por_gestion_unidad'   => $porGestionUnidad,
                'por_gestion_partidas' => $porGestionPartida,
            ];
        } else {
            $data['datos'] = [
                'rango'              => $gestion_det,
                'por_gestion'        => $porGestion,
                'por_gestion_fuente' => $porGestionFuente,
                'por_gestion_unidad' => $porGestionUnidad,
            ];
        }

        if ($graficos) {
            $array_gestion     = collect($porGestion)->pluck('gestion');
            $array_monto       = collect($porGestion)->pluck('total_monto_sum');
            $array_presupuesto = collect($porGestion)->pluck('total_presupuesto_sum');
            $array_pendiente   = collect($porGestion)->pluck('total_pendiente_sum');

            $chartConfig = [
                'type'    => 'bar',
                'data'    => [
                    'labels'   => $array_gestion->toArray(),
                    'datasets' => [[
                        'label'           => 'Monto ejecutado',
                        'backgroundColor' => 'rgba(40, 167, 69, 1)',
                        'data'            => $array_presupuesto->toArray(),
                    ], [
                        'label'           => 'Saldo',
                        'backgroundColor' => 'rgba(220, 53, 69, 1)',
                        'data'            => $array_pendiente->toArray(),
                    ], [
                        'label'           => 'Monto total',
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                        'data'            => $array_monto->toArray(),
                    ]],
                ],
                'options' => [
                    'title'   => [
                        'display' => true,
                        'text'    => 'Montos asignados por gestión',
                    ],
                    'scales'  => [
                        'yAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => true,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks' => [
                                'fontStyle' => 'bold',
                            ],
                        ]],
                    ],
                    'plugins' => [
                        'tickFormat' => [
                            'minimumFractionDigits' => 2,
                            'locale'                => 'en-US',
                        ],
                    ],
                ],
            ];
            $gestionChart         = "https://quickchart.io/chart?h=250&c=" . urlencode(json_encode($chartConfig));
            $data['gestionChart'] = $gestionChart;

            $chartsFinan = [];
            foreach ($porGestionFuente as $value) {
                $array_fuentes     = collect($value['fuentes'])->pluck('fuente');
                $array_monto       = collect($value['fuentes'])->pluck('total_monto_sum');
                $array_presupuesto = collect($value['fuentes'])->pluck('total_presupuesto_sum');
                $array_pendiente   = collect($value['fuentes'])->pluck('total_pendiente_sum');

                $chartConfig = [
                    'type'    => 'bar',
                    'data'    => [
                        'labels'   => $array_fuentes->toArray(),
                        'datasets' => [[
                            'label'           => 'Monto ejecutado',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => $array_presupuesto->toArray(),
                        ], [
                            'label'           => 'Saldo',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => $array_pendiente->toArray(),
                        ], [
                            'label'           => 'Monto total',
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'data'            => $array_monto->toArray(),
                        ]],
                    ],
                    'options' => [
                        'scales'  => [
                            'yAxes' => [[
                                'ticks'      => [
                                    'beginAtZero' => true,
                                    'fontStyle'   => 'bold',
                                ],
                                'scaleLabel' => [
                                    'display'     => true,
                                    'labelString' => 'Monto en Bs',
                                    'fontStyle'   => 'bold',
                                ],
                            ]],
                            'xAxes' => [[
                                'ticks' => [
                                    'fontStyle' => 'bold',
                                ],
                            ]],
                        ],
                        'plugins' => [
                            'tickFormat' => [
                                'minimumFractionDigits' => 2,
                                'locale'                => 'en-US',
                            ],
                        ],
                    ],
                ];

                $chart                          = "https://quickchart.io/chart?h=225&c=" . urlencode(json_encode($chartConfig));
                $chartsFinan[$value['gestion']] = $chart;
            }
            $data['chartsFinan'] = $chartsFinan;

            $chartsUnidades = [];
            foreach ($porGestionUnidad as $value) {
                $array_unidades    = collect($value['unidades'])->pluck('unidad');
                $array_monto       = collect($value['unidades'])->pluck('total_monto_sum');
                $array_presupuesto = collect($value['unidades'])->pluck('total_presupuesto_sum');
                $array_pendiente   = collect($value['unidades'])->pluck('total_pendiente_sum');

                $chartConfig = [
                    'type'    => count($array_unidades) > 1 ? 'horizontalBar' : 'bar',
                    'data'    => [
                        'labels'   => $array_unidades->toArray(),
                        'datasets' => [[
                            'label'           => 'Monto ejecutado',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => $array_presupuesto->toArray(),
                        ], [
                            'label'           => 'Saldo',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => $array_pendiente->toArray(),
                        ], [
                            'label'           => 'Monto total',
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'data'            => $array_monto->toArray(),
                        ]],
                    ],
                    'options' => [
                        'scales'  => [
                            'yAxes' => [[
                                'ticks'      => [
                                    'beginAtZero' => true,
                                    'fontStyle'   => 'bold',
                                ],
                                'scaleLabel' => [
                                    'display'     => count($array_unidades) > 1 ? false : true,
                                    'labelString' => 'Monto en Bs',
                                    'fontStyle'   => 'bold',
                                ],
                            ]],
                            'xAxes' => [[
                                'ticks'      => [
                                    'beginAtZero' => true,
                                    'fontStyle'   => 'bold',
                                ],
                                'scaleLabel' => [
                                    'display'     => count($array_unidades) > 1 ? true : false,
                                    'labelString' => 'Monto en Bs',
                                    'fontStyle'   => 'bold',
                                ],
                            ]],
                        ],
                        'plugins' => [
                            'tickFormat' => [
                                'minimumFractionDigits' => count($array_unidades) > 1 ? 0 : 2,
                                'locale'                => 'en-US',
                            ],
                        ],
                    ],
                ];

                $height                            = max(300, min(1200, 35 * count($array_unidades)));
                $chart                             = "https://quickchart.io/chart?" . (count($array_unidades) > 1 ? "h=$height&" : 'h=225&') . "c=" . urlencode(json_encode($chartConfig));
                $chartsUnidades[$value['gestion']] = $chart;
            }
            $data['chartsUnidades'] = $chartsUnidades;

            if ($partidas) {
                $chartsPartidas = [];
                foreach ($porGestionPartida as $value) {
                    $array_partidas    = collect($value['partidas'])->pluck('codigo');
                    $array_monto       = collect($value['partidas'])->pluck('total_monto_sum');
                    $array_presupuesto = collect($value['partidas'])->pluck('total_presupuesto_sum');
                    $array_pendiente   = collect($value['partidas'])->pluck('total_pendiente_sum');

                    $chartConfig = [
                        'type'    => 'horizontalBar',
                        'data'    => [
                            'labels'   => $array_partidas->toArray(),
                            'datasets' => [[
                                'label'           => 'Monto ejecutado',
                                'backgroundColor' => 'rgba(40, 167, 69, 1)',
                                'data'            => $array_presupuesto->toArray(),
                            ], [
                                'label'           => 'Saldo',
                                'backgroundColor' => 'rgba(220, 53, 69, 1)',
                                'data'            => $array_pendiente->toArray(),
                            ], [
                                'label'           => 'Monto total',
                                'backgroundColor' => 'rgba(54, 162, 235, 1)',
                                'data'            => $array_monto->toArray(),
                            ]],
                        ],
                        'options' => [
                            'scales'  => [
                                'yAxes' => [[
                                    'ticks' => [
                                        'fontStyle' => 'bold',
                                    ],
                                ]],
                                'xAxes' => [[
                                    'ticks'      => [
                                        'beginAtZero' => true,
                                        'fontStyle'   => 'bold',
                                    ],
                                    'scaleLabel' => [
                                        'display'     => true,
                                        'labelString' => 'Monto en Bs',
                                        'fontStyle'   => 'bold',
                                    ],
                                ]],
                            ],
                            'plugins' => [
                                'tickFormat' => [
                                    'minimumFractionDigits' => 2,
                                    'locale'                => 'en-US',
                                ],
                            ],
                        ],
                    ];

                    $height                            = max(300, min(1200, 25 * count($array_partidas)));
                    $chart                             = "https://quickchart.io/chart?h=" . $height . "&c=" . urlencode(json_encode($chartConfig));
                    $chartsPartidas[$value['gestion']] = $chart;
                }
                $data['chartsPartidas'] = $chartsPartidas;
            }
        }

        $html = View::make('reportes.graficas.gestion')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    public function filtrar_fecha($tipo, $id_financiamiento, $id_unidad_carrera, $graficos, $partidas, $fecha, $fecha_fin = 0, $_tipo)
    {
        $tipo              = desencriptar($tipo);
        $id_financiamiento = desencriptar($id_financiamiento);
        $id_unidad_carrera = desencriptar($id_unidad_carrera);
        $graficos          = desencriptar($graficos);
        $partidas          = desencriptar($partidas);
        $fecha             = desencriptar($fecha);
        $fecha_fin         = desencriptar($fecha_fin);
        $_tipo             = desencriptar($_tipo);

        // Rango de fechas personalizado
        if ($tipo == 4) {
            $fecha     = Carbon::createFromTimestamp($fecha)->format('Y-m-d');
            $fecha_fin = Carbon::createFromTimestamp($fecha_fin)->format('Y-m-d');
        }

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Establecer fecha de inicio y final
        if ($tipo == 3) {
            switch ($fecha) {
                case 1:
                    $startDate = Carbon::now()->subDays(7);
                    break;
                case 2:
                    $startDate = Carbon::now()->subDays(30);
                    break;
                case 3:
                    $startDate = Carbon::now()->subMonths(3);
                    break;
                case 4:
                    $startDate = Carbon::now()->subMonths(6);
                    break;
                default:
                    $startDate = Carbon::now()->subDays(7);
                    break;
            }
            $endDate = Carbon::now();
        } else {
            $startDate = Carbon::createFromFormat('Y-m-d', $fecha)->startOfDay();
            $endDate   = Carbon::createFromFormat('Y-m-d', $fecha_fin)->endOfDay();
        }

        /**
         * CONSULTA BASE PARA FUT
         */
        $baseFut = DB::table('fut')
            ->join('fut_partidas_presupuestarias as fpp', 'fpp.id_fut', '=', 'fut.id_fut')
            ->join('fut_movimiento as fm', 'fm.id_fut_pp', '=', 'fpp.id_fut_pp')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'fpp.organismo_financiador')
            ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'fut.id_unidad_carrera')
            ->join('rl_medida_bienservicio as mbs', 'mbs.id', '=', 'fm.id_mbs')
            ->whereBetween('fut.created_at', [$startDate, $endDate])
            ->whereNotIn('fut.estado', ['rechazado', 'eliminado'])
            ->select(
                DB::raw('SUM(fm.partida_monto) as total_monto_sum'),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra' THEN fm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra verificado' THEN fm.partida_monto ELSE 0 END) as total_verificado_sum"),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra aprobado' THEN fm.partida_monto ELSE 0 END) as total_aprobado_sum"),
            );

        /**
         * REPORTE BASE PARA MOT
         */
        $baseMotDe = DB::table('mot')
            ->join('mot_partidas_presupuestarias as mpp', 'mpp.id_mot', '=', 'mot.id_mot')
            ->join('mot_movimiento as mm', 'mm.id_mot_pp', '=', 'mpp.id_mot_pp')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mpp.organismo_financiador')
            ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'mot.id_unidad_carrera')
            ->join('rl_medida_bienservicio as mbs', 'mbs.id', '=', 'mm.id_mbs')
            ->whereBetween('mot.created_at', [$startDate, $endDate])
            ->whereNotIn('mot.estado', ['rechazado', 'eliminado'])
            ->select(
                DB::raw("SUM(CASE WHEN mpp.accion = 'DE' THEN mm.partida_monto ELSE 0 END) as total_monto_sum"),
                DB::raw("SUM(mm.partida_monto) - (SUM(CASE WHEN mpp.accion = 'A' THEN mm.partida_monto ELSE 0 END) * 2) as total_saldo_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica' THEN mm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica verificado' THEN mm.partida_monto ELSE 0 END) as total_verificado_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica aprobado' THEN mm.partida_monto ELSE 0 END) as total_aprobado_sum"),
            );
        $baseMotA = DB::table('mot')
            ->join('mot_partidas_presupuestarias as mpp', 'mpp.id_mot', '=', 'mot.id_mot')
            ->join('mot_movimiento as mm', 'mm.id_mot_pp', '=', 'mpp.id_mot_pp')
            ->join('rl_financiamiento_tipo as ft', 'ft.id', '=', 'mpp.organismo_financiador')
            ->join('rl_unidad_carrera as uc', 'uc.id', '=', 'mot.id_unidad_carrera')
            ->join('rl_medida_bienservicio as mbs', 'mbs.id', '=', 'mm.id_mbs')
            ->whereBetween('mot.created_at', [$startDate, $endDate])
            ->whereNotIn('mot.estado', ['rechazado', 'eliminado'])
            ->where('mpp.accion', 'A')
            ->select(
                DB::raw('SUM(mm.partida_monto) as total_monto_sum'),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'incrementa' THEN mm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'incrementa verificado' THEN mm.partida_monto ELSE 0 END) as total_verificado_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'incrementa aprobado' THEN mm.partida_monto ELSE 0 END) as total_aprobado_sum"),
            );

        $startDate = $startDate->format('d-m-Y');
        $endDate   = $endDate->format('d-m-Y');

        //Filtrado por fuente de financiamiento
        $data['financiamiento'] = null;
        if ($id_financiamiento != 0) {
            $baseFut->where('ft.id', $id_financiamiento);
            $baseMotDe->where('ft.id', $id_financiamiento);
            $baseMotA->where('ft.id', $id_financiamiento);
            $data['financiamiento'] = Financiamiento_tipo::findOrFail($id_financiamiento);
        }

        //Filtrado por unidad o carrera
        $data['unidad_carrera'] = null;
        if ($id_unidad_carrera != 0) {
            $baseFut->where('uc.id', $id_unidad_carrera);
            $baseMotDe->where('uc.id', $id_unidad_carrera);
            $baseMotA->where('uc.id', $id_unidad_carrera);
            $data['unidad_carrera'] = UnidadCarreraArea::findOrFail($id_unidad_carrera);
        }

        $data['graficos'] = $graficos;
        $data['partidas'] = $partidas;
        if ($_tipo == 1) {
            $_tipo = 'fut';
        } else if ($_tipo == 2) {
            $_tipo = 'mot';
        } else {
            $_tipo = '';
        }
        $data['tipo'] = $_tipo;

        /**
         * GENERAL FUT
         */
        $por_fecha_fut = clone $baseFut;
        if ($tipo == 3) { // Periodo
            $porFechaFut = [
                'fecha'                => 'Ultimos ' . ($fecha == 1 ? '7 días' : ($fecha == 2 ? '30 días' : ($fecha == 3 ? '3 meses' : '6 meses'))),
                'total_monto_sum'      => $por_fecha_fut->first()->total_monto_sum,
                'total_pendiente_sum'  => $por_fecha_fut->first()->total_pendiente_sum,
                'total_verificado_sum' => $por_fecha_fut->first()->total_verificado_sum,
                'total_aprobado_sum'   => $por_fecha_fut->first()->total_aprobado_sum,
            ];
        } else { // Rango de fechas
            $porFechaFut = [
                'fecha'                => $startDate . ' a ' . $endDate,
                'total_monto_sum'      => $por_fecha_fut->first()->total_monto_sum,
                'total_pendiente_sum'  => $por_fecha_fut->first()->total_pendiente_sum,
                'total_verificado_sum' => $por_fecha_fut->first()->total_verificado_sum,
                'total_aprobado_sum'   => $por_fecha_fut->first()->total_aprobado_sum,
            ];
        }

        /**
         * GENERAL MOT
         */
        $por_fecha_mot = clone $baseMotDe;
        if ($tipo == 3) { // Periodo
            $porFechaMot = [
                'fecha'                => 'Ultimos ' . ($fecha == 1 ? '7 días' : ($fecha == 2 ? '30 días' : ($fecha == 3 ? '3 meses' : '6 meses'))),
                'total_monto_sum'      => $por_fecha_mot->first()->total_monto_sum,
                'total_saldo_sum'      => $por_fecha_mot->first()->total_saldo_sum,
                'total_pendiente_sum'  => $por_fecha_mot->first()->total_pendiente_sum,
                'total_verificado_sum' => $por_fecha_mot->first()->total_verificado_sum,
                'total_aprobado_sum'   => $por_fecha_mot->first()->total_aprobado_sum,
            ];
        } else { // Rango de fechas
            $porFechaMot = [
                'fecha'                => $startDate . ' a ' . $endDate,
                'total_monto_sum'      => $por_fecha_mot->first()->total_monto_sum,
                'total_saldo_sum'      => $por_fecha_mot->first()->total_saldo_sum,
                'total_pendiente_sum'  => $por_fecha_mot->first()->total_pendiente_sum,
                'total_verificado_sum' => $por_fecha_mot->first()->total_verificado_sum,
                'total_aprobado_sum'   => $por_fecha_mot->first()->total_aprobado_sum,
            ];
        }

        /**
         * POR FUENTES DE FINANCIAMIENTO FUT
         */
        $base2fut               = clone $baseFut;
        $sub_financiamiento_fut = $base2fut
            ->groupBy('ft.sigla', 'ft.descripcion')
            ->select(
                'ft.sigla',
                'ft.descripcion',
                DB::raw('SUM(fm.partida_monto) as total_monto_sum'),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra' THEN fm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra verificado' THEN fm.partida_monto ELSE 0 END) as total_verificado_sum"),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra aprobado' THEN fm.partida_monto ELSE 0 END) as total_aprobado_sum")
            );

        $por_fecha_financiamiento_fut = DB::table('rl_financiamiento_tipo as ft')
            ->leftJoinSub($sub_financiamiento_fut, 'res', function ($join) {
                $join->on('res.sigla', '=', 'ft.sigla');
            })
            ->select(
                'ft.sigla',
                'ft.descripcion',
                DB::raw('COALESCE(res.total_monto_sum, 0) as total_monto_sum'),
                DB::raw('COALESCE(res.total_pendiente_sum, 0) as total_pendiente_sum'),
                DB::raw('COALESCE(res.total_verificado_sum, 0) as total_verificado_sum'),
                DB::raw('COALESCE(res.total_aprobado_sum, 0) as total_aprobado_sum')
            )
            ->orderBy('ft.id')
            ->get();

        $porFechaFinanciamientoFut = $por_fecha_financiamiento_fut->map(function ($item) {
            return [
                'fuente'               => $item->sigla,
                'descripcion'          => $item->descripcion,
                'total_monto_sum'      => $item->total_monto_sum,
                'total_pendiente_sum'  => $item->total_pendiente_sum,
                'total_verificado_sum' => $item->total_verificado_sum,
                'total_aprobado_sum'   => $item->total_aprobado_sum,
            ];
        });

        /**
         * POR FUENTES DE FINANCIAMIENTO MOT
         */
        $base2mot               = clone $baseMotDe;
        $sub_financiamiento_mot = $base2mot
            ->groupBy('ft.sigla', 'ft.descripcion')
            ->select(
                'ft.sigla',
                'ft.descripcion',
                DB::raw("SUM(CASE WHEN mpp.accion = 'DE' THEN mm.partida_monto ELSE 0 END) as total_monto_sum"),
                DB::raw("SUM(mm.partida_monto) - (SUM(CASE WHEN mpp.accion = 'A' THEN mm.partida_monto ELSE 0 END) * 2) as total_saldo_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica' THEN mm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica verificado' THEN mm.partida_monto ELSE 0 END) as total_verificado_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica aprobado' THEN mm.partida_monto ELSE 0 END) as total_aprobado_sum")
            );

        $por_fecha_financiamiento_mot = DB::table('rl_financiamiento_tipo as ft')
            ->leftJoinSub($sub_financiamiento_mot, 'res', function ($join) {
                $join->on('res.sigla', '=', 'ft.sigla');
            })
            ->select(
                'ft.sigla',
                'ft.descripcion',
                DB::raw('COALESCE(res.total_monto_sum, 0) as total_monto_sum'),
                DB::raw('COALESCE(res.total_saldo_sum, 0) as total_saldo_sum'),
                DB::raw('COALESCE(res.total_pendiente_sum, 0) as total_pendiente_sum'),
                DB::raw('COALESCE(res.total_verificado_sum, 0) as total_verificado_sum'),
                DB::raw('COALESCE(res.total_aprobado_sum, 0) as total_aprobado_sum')
            )
            ->orderBy('ft.id')
            ->get();

        $porFechaFinanciamientoMot = $por_fecha_financiamiento_mot->map(function ($item) {
            return [
                'fuente'               => $item->sigla,
                'descripcion'          => $item->descripcion,
                'total_monto_sum'      => $item->total_monto_sum,
                'total_saldo_sum'      => $item->total_saldo_sum,
                'total_pendiente_sum'  => $item->total_pendiente_sum,
                'total_verificado_sum' => $item->total_verificado_sum,
                'total_aprobado_sum'   => $item->total_aprobado_sum,
            ];
        });

        /**
         * POR UNIDAD O CARRERA FUT
         */
        $base3fut       = clone $baseFut;
        $sub_unidad_fut = $base3fut->groupBy('uc.nombre_completo')
            ->select(
                'uc.nombre_completo',
                DB::raw('SUM(fm.partida_monto) as total_monto_sum'),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra' THEN fm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra verificado' THEN fm.partida_monto ELSE 0 END) as total_verificado_sum"),
                DB::raw("SUM(CASE WHEN fm.descripcion = 'compra aprobado' THEN fm.partida_monto ELSE 0 END) as total_aprobado_sum")
            );

        $por_fecha_unidad_fut = DB::table('rl_unidad_carrera as uc')
            ->joinSub($sub_unidad_fut, 'res', function ($join) {
                $join->on('res.nombre_completo', '=', 'uc.nombre_completo');
            })
            ->select(
                'uc.nombre_completo',
                DB::raw('COALESCE(res.total_monto_sum, 0) as total_monto_sum'),
                DB::raw('COALESCE(res.total_pendiente_sum, 0) as total_pendiente_sum'),
                DB::raw('COALESCE(res.total_verificado_sum, 0) as total_verificado_sum'),
                DB::raw('COALESCE(res.total_aprobado_sum, 0) as total_aprobado_sum')
            )
            ->orderBy('uc.id')
            ->get();

        $porFechaUnidadFut = $por_fecha_unidad_fut->map(function ($item) {
            return [
                'unidad'               => $item->nombre_completo,
                'total_monto_sum'      => $item->total_monto_sum,
                'total_pendiente_sum'  => $item->total_pendiente_sum,
                'total_verificado_sum' => $item->total_verificado_sum,
                'total_aprobado_sum'   => $item->total_aprobado_sum,
            ];
        });

        /**
         * POR UNIDAD O CARRERA MOT
         */
        $base3mot       = clone $baseMotDe;
        $sub_unidad_mot = $base3mot->groupBy('uc.nombre_completo')
            ->select(
                'uc.nombre_completo',
                DB::raw("SUM(CASE WHEN mpp.accion = 'DE' THEN mm.partida_monto ELSE 0 END) as total_monto_sum"),
                DB::raw("SUM(mm.partida_monto) - (SUM(CASE WHEN mpp.accion = 'A' THEN mm.partida_monto ELSE 0 END) * 2) as total_saldo_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica' THEN mm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica verificado' THEN mm.partida_monto ELSE 0 END) as total_verificado_sum"),
                DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica aprobado' THEN mm.partida_monto ELSE 0 END) as total_aprobado_sum")
            );

        $por_fecha_unidad_mot = DB::table('rl_unidad_carrera as uc')
            ->joinSub($sub_unidad_mot, 'res', function ($join) {
                $join->on('res.nombre_completo', '=', 'uc.nombre_completo');
            })
            ->select(
                'uc.nombre_completo',
                DB::raw('COALESCE(res.total_monto_sum, 0) as total_monto_sum'),
                DB::raw('COALESCE(res.total_saldo_sum, 0) as total_saldo_sum'),
                DB::raw('COALESCE(res.total_pendiente_sum, 0) as total_pendiente_sum'),
                DB::raw('COALESCE(res.total_verificado_sum, 0) as total_verificado_sum'),
                DB::raw('COALESCE(res.total_aprobado_sum, 0) as total_aprobado_sum')
            )
            ->orderBy('uc.id')
            ->get();

        $porFechaUnidadMot = $por_fecha_unidad_mot->map(function ($item) {
            return [
                'unidad'               => $item->nombre_completo,
                'total_monto_sum'      => $item->total_monto_sum,
                'total_saldo_sum'      => $item->total_saldo_sum,
                'total_pendiente_sum'  => $item->total_pendiente_sum,
                'total_verificado_sum' => $item->total_verificado_sum,
                'total_aprobado_sum'   => $item->total_aprobado_sum,
            ];
        });

        /**
         * POR PARTIDAS FUT
         */
        $porFechaPartidasFut = [];
        if ($partidas) {
            $base4fut               = clone $baseFut;
            $por_fecha_partidas_fut = $base4fut->groupBy('fm.partida_codigo')
                ->select(
                    'fm.partida_codigo',
                    DB::raw('SUM(fm.partida_monto) as total_monto_sum'),
                    DB::raw("SUM(CASE WHEN fm.descripcion = 'compra' THEN fm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                    DB::raw("SUM(CASE WHEN fm.descripcion = 'compra verificado' THEN fm.partida_monto ELSE 0 END) as total_verificado_sum"),
                    DB::raw("SUM(CASE WHEN fm.descripcion = 'compra aprobado' THEN fm.partida_monto ELSE 0 END) as total_aprobado_sum")
                )
                ->orderBy('fm.partida_codigo')->get();

            $porFechaPartidasFut = $por_fecha_partidas_fut->map(function ($item) {
                return [
                    'partida'              => $item->partida_codigo,
                    'total_monto_sum'      => $item->total_monto_sum,
                    'total_pendiente_sum'  => $item->total_pendiente_sum,
                    'total_verificado_sum' => $item->total_verificado_sum,
                    'total_aprobado_sum'   => $item->total_aprobado_sum,
                ];
            });
        }

        /**
         * POR PARTIDAS MOT
         */
        $porFechaPartidasMotDE = [];
        $porFechaPartidasMotA  = [];
        if ($partidas) {
            // ORIGEN
            $base41mot                 = clone $baseMotDe;
            $por_fecha_partidas_mot_DE = $base41mot->where('mpp.accion', 'DE')
                ->groupBy('mm.partida_codigo')
                ->select(
                    'mm.partida_codigo',
                    DB::raw("SUM(CASE WHEN mpp.accion = 'DE' THEN mm.partida_monto ELSE 0 END) as total_monto_sum"),
                    DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica' THEN mm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                    DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica verificado' THEN mm.partida_monto ELSE 0 END) as total_verificado_sum"),
                    DB::raw("SUM(CASE WHEN mm.descripcion = 'modifica aprobado' THEN mm.partida_monto ELSE 0 END) as total_aprobado_sum")
                )
                ->orderBy('mm.partida_codigo')->get();

            $porFechaPartidasMotDE = $por_fecha_partidas_mot_DE->map(function ($item) {
                return [
                    'partida'              => $item->partida_codigo,
                    'total_monto_sum'      => $item->total_monto_sum,
                    'total_pendiente_sum'  => $item->total_pendiente_sum,
                    'total_verificado_sum' => $item->total_verificado_sum,
                    'total_aprobado_sum'   => $item->total_aprobado_sum,
                ];
            });

            // DESTINO
            $base42mot                = clone $baseMotA;
            $por_fecha_partidas_mot_A = $base42mot->groupBy('mm.partida_codigo')
                ->select(
                    'mm.partida_codigo',
                    DB::raw('SUM(mm.partida_monto) as total_monto_sum'),
                    DB::raw("SUM(CASE WHEN mm.descripcion = 'incrementa' THEN mm.partida_monto ELSE 0 END) as total_pendiente_sum"),
                    DB::raw("SUM(CASE WHEN mm.descripcion = 'incrementa verificado' THEN mm.partida_monto ELSE 0 END) as total_verificado_sum"),
                    DB::raw("SUM(CASE WHEN mm.descripcion = 'incrementa aprobado' THEN mm.partida_monto ELSE 0 END) as total_aprobado_sum")
                )
                ->orderBy('mm.partida_codigo')->get();

            $porFechaPartidasMotA = $por_fecha_partidas_mot_A->map(function ($item) {
                return [
                    'partida'              => $item->partida_codigo,
                    'total_monto_sum'      => $item->total_monto_sum,
                    'total_pendiente_sum'  => $item->total_pendiente_sum,
                    'total_verificado_sum' => $item->total_verificado_sum,
                    'total_aprobado_sum'   => $item->total_aprobado_sum,
                ];
            });

            $base43mot              = clone $baseMotDe;
            $por_fecha_partidas_mot = $base43mot
                ->whereNotIn('mot.estado', ['pendiente', 'elaborado'])
                ->groupBy('mm.partida_codigo', 'mpp.accion')
                ->select(
                    'mm.partida_codigo',
                    DB::raw('SUM(mm.partida_monto) as total_monto_sum'),
                    'mpp.accion'
                )
                ->orderBy('mpp.id_mot_pp', 'ASC')->get();

            $porFechaPartidasMot = $por_fecha_partidas_mot->map(function ($item) {
                return [
                    'partida'         => $item->partida_codigo,
                    'total_monto_sum' => $item->total_monto_sum,
                    'accion'          => $item->accion,
                ];
            });
        }

        // Resultados
        $data['datos'] = [
            'rango'                        => $startDate . ' - ' . $endDate,
            'por_fecha_fut'                => $porFechaFut,
            'por_fecha_financiamiento_fut' => $porFechaFinanciamientoFut,
            'por_fecha_unidad_fut'         => $porFechaUnidadFut,
            'por_fecha_partidas_fut'       => $porFechaPartidasFut,
            'por_fecha_mot'                => $porFechaMot,
            'por_fecha_financiamiento_mot' => $porFechaFinanciamientoMot,
            'por_fecha_unidad_mot'         => $porFechaUnidadMot,
            'por_fecha_partidas_mot_de'    => $porFechaPartidasMotDE,
            'por_fecha_partidas_mot_a'     => $porFechaPartidasMotA,
            'por_fecha_partidas_mot'       => $porFechaPartidasMot,
        ];

        // Resultados graficos (si graficos esta checked)
        if ($graficos) {
            /**
             * GRAFICOS FUT
             */
            $chartConfig = [
                'type'    => 'bar',
                'data'    => [
                    'labels'   => [$porFechaFut['fecha']],
                    'datasets' => [[
                        'label'           => 'Compras ejecutadas',
                        'backgroundColor' => 'rgba(40, 167, 69, 1)',
                        'data'            => [$porFechaFut['total_aprobado_sum']],
                    ], [
                        'label'           => 'Compras pendientes',
                        'backgroundColor' => 'rgba(255,193,7, 1)',
                        'data'            => [$porFechaFut['total_verificado_sum']],
                    ], [
                        'label'           => 'Saldo',
                        'backgroundColor' => 'rgba(220, 53, 69, 1)',
                        'data'            => [$porFechaFut['total_pendiente_sum']],
                    ], [
                        'label'           => 'Total',
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                        'data'            => [$porFechaFut['total_monto_sum']],
                    ]],
                ],
                'options' => [
                    'title'   => [
                        'display' => true,
                        'text'    => $porFechaFut['fecha'],
                    ],
                    'scales'  => [
                        'yAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => true,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks' => [
                                'fontStyle' => 'bold',
                            ],
                        ]],
                    ],
                    'plugins' => [
                        'tickFormat' => [
                            'minimumFractionDigits' => 2,
                            'locale'                => 'en-US',
                        ],
                    ],
                ],
            ];

            $chartFecha            = "https://quickchart.io/chart?format=svg&h=250&c=" . urlencode(json_encode($chartConfig));
            $data['chartFechaFut'] = $chartFecha;

            $array_fuentes    = collect($porFechaFinanciamientoFut)->pluck('fuente');
            $array_monto      = collect($porFechaFinanciamientoFut)->pluck('total_monto_sum');
            $array_aprobado   = collect($porFechaFinanciamientoFut)->pluck('total_aprobado_sum');
            $array_verificado = collect($porFechaFinanciamientoFut)->pluck('total_verificado_sum');
            $array_pendiente  = collect($porFechaFinanciamientoFut)->pluck('total_pendiente_sum');

            $chartConfig = [
                'type'    => 'bar',
                'data'    => [
                    'labels'   => $array_fuentes->toArray(),
                    'datasets' => [[
                        'label'           => 'Compras ejecutadas',
                        'backgroundColor' => 'rgba(40, 167, 69, 1)',
                        'data'            => $array_aprobado->toArray(),
                    ], [
                        'label'           => 'Compras pendientes',
                        'backgroundColor' => 'rgba(255,193,7, 1)',
                        'data'            => $array_verificado->toArray(),
                    ], [
                        'label'           => 'Saldo',
                        'backgroundColor' => 'rgba(220, 53, 69, 1)',
                        'data'            => $array_pendiente->toArray(),
                    ], [
                        'label'           => 'Total',
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                        'data'            => $array_monto->toArray(),
                    ]],
                ],
                'options' => [
                    'scales'  => [
                        'yAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => true,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks' => [
                                'fontStyle' => 'bold',
                            ],
                        ]],
                    ],
                    'plugins' => [
                        'tickFormat' => [
                            'minimumFractionDigits' => 2,
                            'locale'                => 'en-US',
                        ],
                    ],
                ],
            ];

            $chartFinan            = "https://quickchart.io/chart?h=225&c=" . urlencode(json_encode($chartConfig));
            $data['chartFinanFut'] = $chartFinan;

            $array_unidades   = collect($porFechaUnidadFut)->pluck('unidad');
            $array_monto      = collect($porFechaUnidadFut)->pluck('total_monto_sum');
            $array_aprobado   = collect($porFechaUnidadFut)->pluck('total_aprobado_sum');
            $array_verificado = collect($porFechaUnidadFut)->pluck('total_verificado_sum');
            $array_pendiente  = collect($porFechaUnidadFut)->pluck('total_pendiente_sum');

            $chartConfig = [
                'type'    => count($array_unidades) > 1 ? 'horizontalBar' : 'bar',
                'data'    => [
                    'labels'   => $array_unidades->toArray(),
                    'datasets' => [[
                        'label'           => 'Compras ejecutadas',
                        'backgroundColor' => 'rgba(40, 167, 69, 1)',
                        'data'            => $array_aprobado->toArray(),
                    ], [
                        'label'           => 'Compras pendientes',
                        'backgroundColor' => 'rgba(255,193,7, 1)',
                        'data'            => $array_verificado->toArray(),
                    ], [
                        'label'           => 'Saldo',
                        'backgroundColor' => 'rgba(220, 53, 69, 1)',
                        'data'            => $array_pendiente->toArray(),
                    ], [
                        'label'           => 'Total',
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                        'data'            => $array_monto->toArray(),
                    ]],
                ],
                'options' => [
                    'scales'  => [
                        'yAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => count($array_unidades) > 1 ? false : true,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => count($array_unidades) > 1 ? true : false,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                    ],
                    'plugins' => [
                        'tickFormat' => [
                            'minimumFractionDigits' => count($porFechaUnidadFut) > 1 ? 0 : 2,
                            'locale'                => 'en-US',
                        ],
                    ],
                ],
            ];

            $height                   = max(300, min(300, 35 * count($array_unidades)));
            $chartUnidades            = "https://quickchart.io/chart?" . (count($array_unidades) > 1 ? "h=$height&" : 'h=225&') . "c=" . urlencode(json_encode($chartConfig));
            $data['chartUnidadesFut'] = $chartUnidades;

            if ($partidas) {
                $array_partidas   = collect($porFechaPartidasFut)->pluck('partida');
                $array_monto      = collect($porFechaPartidasFut)->pluck('total_monto_sum');
                $array_aprobado   = collect($porFechaPartidasFut)->pluck('total_aprobado_sum');
                $array_verificado = collect($porFechaPartidasFut)->pluck('total_verificado_sum');
                $array_pendiente  = collect($porFechaPartidasFut)->pluck('total_pendiente_sum');

                $chartConfig = [
                    'type'    => 'horizontalBar',
                    'data'    => [
                        'labels'   => $array_partidas->toArray(),
                        'datasets' => [[
                            'label'           => 'Compras ejecutadas',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => $array_aprobado->toArray(),
                        ], [
                            'label'           => 'Compras pendientes',
                            'backgroundColor' => 'rgba(255,193,7, 1)',
                            'data'            => $array_verificado->toArray(),
                        ], [
                            'label'           => 'Saldo',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => $array_pendiente->toArray(),
                        ], [
                            'label'           => 'Total',
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'data'            => $array_monto->toArray(),
                        ]],
                    ],
                    'options' => [
                        'scales'  => [
                            'yAxes' => [[
                                'ticks' => [
                                    'fontStyle' => 'bold',
                                ],
                            ]],
                            'xAxes' => [[
                                'ticks'      => [
                                    'beginAtZero' => true,
                                    'fontStyle'   => 'bold',
                                ],
                                'scaleLabel' => [
                                    'display'     => true,
                                    'labelString' => 'Monto en Bs',
                                    'fontStyle'   => 'bold',
                                ],
                            ]],
                        ],
                        'plugins' => [
                            'tickFormat' => [
                                'minimumFractionDigits' => 2,
                                'locale'                => 'en-US',
                            ],
                        ],
                    ],
                ];

                $height                   = max(250, min(900, 25 * count($array_partidas)));
                $chart                    = "https://quickchart.io/chart?h=" . $height . "&c=" . urlencode(json_encode($chartConfig));
                $data['chartPartidasFut'] = $chart;
            }

            /**
             * GRAFICOS MOT
             */
            $chartConfig = [
                'type'    => 'bar',
                'data'    => [
                    'labels'   => [$porFechaMot['fecha']],
                    'datasets' => [
                        [
                            'label'           => 'Elaborado',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => [$porFechaMot['total_pendiente_sum']],
                        ], [
                            'label'           => 'Verificado',
                            'backgroundColor' => 'rgba(255,193,7, 1)',
                            'data'            => [$porFechaMot['total_verificado_sum']],
                        ], [
                            'label'           => 'Aprobado',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => [$porFechaMot['total_aprobado_sum']],
                        ]],
                ],
                'options' => [
                    'title'   => [
                        'display' => true,
                        'text'    => $porFechaMot['fecha'],
                    ],
                    'scales'  => [
                        'yAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => true,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks' => [
                                'fontStyle' => 'bold',
                            ],
                        ]],
                    ],
                    'plugins' => [
                        'tickFormat' => [
                            'minimumFractionDigits' => 2,
                            'locale'                => 'en-US',
                        ],
                    ],
                ],
            ];
            $chartFecha            = "https://quickchart.io/chart?h=250&c=" . urlencode(json_encode($chartConfig));
            $data['chartFechaMot'] = $chartFecha;

            $array_fuentes    = collect($porFechaFinanciamientoMot)->pluck('fuente');
            $array_monto      = collect($porFechaFinanciamientoMot)->pluck('total_monto_sum');
            $array_aprobado   = collect($porFechaFinanciamientoMot)->pluck('total_aprobado_sum');
            $array_verificado = collect($porFechaFinanciamientoMot)->pluck('total_verificado_sum');
            $array_pendiente  = collect($porFechaFinanciamientoMot)->pluck('total_pendiente_sum');

            $chartConfig = [
                'type'    => 'bar',
                'data'    => [
                    'labels'   => $array_fuentes->toArray(),
                    'datasets' => [
                        [
                            'label'           => 'Elaborado',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => $array_pendiente->toArray(),
                        ],
                        [
                            'label'           => 'Verificado',
                            'backgroundColor' => 'rgba(255,193,7, 1)',
                            'data'            => $array_verificado->toArray(),
                        ], [
                            'label'           => 'Aprobado',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => $array_aprobado->toArray(),
                        ]],
                ],
                'options' => [
                    'scales'  => [
                        'yAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => true,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks' => [
                                'fontStyle' => 'bold',
                            ],
                        ]],
                    ],
                    'plugins' => [
                        'tickFormat' => [
                            'minimumFractionDigits' => 2,
                            'locale'                => 'en-US',
                        ],
                    ],
                ],
            ];

            $chartFinan            = "https://quickchart.io/chart?h=225&c=" . urlencode(json_encode($chartConfig));
            $data['chartFinanMot'] = $chartFinan;

            $array_unidades   = collect($porFechaUnidadMot)->pluck('unidad');
            $array_monto      = collect($porFechaUnidadMot)->pluck('total_monto_sum');
            $array_aprobado   = collect($porFechaUnidadMot)->pluck('total_aprobado_sum');
            $array_verificado = collect($porFechaUnidadMot)->pluck('total_verificado_sum');
            $array_pendiente  = collect($porFechaUnidadMot)->pluck('total_pendiente_sum');

            $chartConfig = [
                'type'    => count($array_unidades) > 1 ? 'horizontalBar' : 'bar',
                'data'    => [
                    'labels'   => $array_unidades->toArray(),
                    'datasets' => [
                        [
                            'label'           => 'Elaborado',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => $array_pendiente->toArray(),
                        ], [
                            'label'           => 'Verificado',
                            'backgroundColor' => 'rgba(255,193,7, 1)',
                            'data'            => $array_verificado->toArray(),
                        ], [
                            'label'           => 'Aprobado',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => $array_aprobado->toArray(),
                        ]],
                ],
                'options' => [
                    'scales'  => [
                        'yAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'min'         => 0,
                                'display'     => count($array_unidades) > 1 ? false : true,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks'      => [
                                'beginAtZero' => true,
                                'fontStyle'   => 'bold',
                            ],
                            'scaleLabel' => [
                                'display'     => count($array_unidades) > 1 ? true : false,
                                'labelString' => 'Monto en Bs',
                                'fontStyle'   => 'bold',
                            ],
                        ]],
                    ],
                    'plugins' => [
                        'tickFormat' => [
                            'minimumFractionDigits' => count($porFechaUnidadMot) > 1 ? 0 : 2,
                            'locale'                => 'en-US',
                        ],
                    ],
                ],
            ];

            $height                   = max(250, min(900, 25 * count($array_unidades)));
            $chartUnidades            = "https://quickchart.io/chart?" . (count($array_unidades) > 1 ? "h=$height&" : 'h=225&') . "c=" . urlencode(json_encode($chartConfig));
            $data['chartUnidadesMot'] = $chartUnidades;

            if ($partidas) {
                $array_partidas    = collect($porFechaPartidasMot)->pluck('partida');
                $array_monto       = collect($porFechaPartidasMot)->pluck('total_monto_sum');
                $array_acciones    = collect();
                $array_accion_tipo = collect();

                foreach ($porFechaPartidasMot as $value) {
                    if ($value['accion'] == 'DE') {
                        $array_acciones->push('rgba(220, 53, 69, 1)');
                        $array_accion_tipo->push('DE');
                    } else {
                        $array_acciones->push('rgba(40, 167, 69, 1)');
                        $array_accion_tipo->push('A');
                    }
                }

                $chartConfig = [
                    'type'    => 'horizontalBar',
                    'data'    => [
                        'labels'   => $array_partidas->toArray(),
                        'datasets' => [[
                            'label'           => 'Modificaciones',
                            'backgroundColor' => $array_acciones->toArray(),
                            'data'            => $array_monto->toArray(),
                        ]],
                    ],
                    'options' => [
                        'plugins' => [
                            'legend' => ['display' => false],
                        ],
                        'scales'  => [
                            'yAxes' => [[
                                'ticks' => [
                                    'fontStyle' => 'bold',
                                ],
                            ]],
                            'xAxes' => [[
                                'ticks'      => [
                                    'beginAtZero' => true,
                                    'fontStyle'   => 'bold',
                                ],
                                'scaleLabel' => [
                                    'display'     => true,
                                    'labelString' => 'Monto en Bs',
                                    'fontStyle'   => 'bold',
                                ],
                            ]],
                        ],
                        'plugins' => [
                            'tickFormat' => [
                                'minimumFractionDigits' => 2,
                                'locale'                => 'en-US',
                            ],
                        ],
                    ],
                ];

                $height                   = max(250, min(900, 25 * count($array_partidas)));
                $chart                    = "https://quickchart.io/chart?h=" . $height . "&c=" . urlencode(json_encode($chartConfig));
                $data['chartPartidasMot'] = $chart;
            }
        }

        // dd($data);

        $html = View::make('reportes.graficas.fecha')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();
        // $dompdf->stream('reporte.pdf');

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }
}
