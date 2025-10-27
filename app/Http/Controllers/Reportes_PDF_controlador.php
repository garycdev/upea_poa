<?php
namespace App\Http\Controllers;

use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Gestion;
use App\Models\Gestiones;
use App\Models\Poa\Medida_bienservicio;
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

        switch ($req->filtrar) {
            case '1':
                return redirect()->route('pdf.gestion', [encriptar(1), encriptar($req->gestion), encriptar($req->fuente_fin), encriptar($req->cua), encriptar($graficos)]);
                break;
            case '2':
                return redirect()->route('pdf.gestion', [encriptar(2), encriptar($req->gestion_esp), encriptar($req->fuente_fin), encriptar($req->cua), encriptar($graficos)]);
                break;
            case '3':
                dd($req->filtrar);
                break;
            case '4':
                dd($req->filtrar);
                break;
            default:
                dd($req);
                break;
        }
    }

    public function filtrar_gestion($tipo, $id_gestion, $id_financiamiento, $id_unidad_carrera, $graficos)
    {
        $tipo              = desencriptar($tipo);
        $id_gestion        = desencriptar($id_gestion);
        $id_financiamiento = desencriptar($id_financiamiento);
        $id_unidad_carrera = desencriptar($id_unidad_carrera);
        $graficos          = desencriptar($graficos);

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

            $gestion_det = "{$gestion->gestion}";
        }

        $data['financiamiento'] = null;
        if ($id_financiamiento != 0) {
            $base->where('ft.id', $id_financiamiento);

            $data['financiamiento'] = Financiamiento_tipo::findOrFail($id_financiamiento);
        }
        $data['unidad_carrera'] = null;
        if ($id_unidad_carrera != 0) {
            $base->where('uc.id', $id_unidad_carrera);

            $data['unidad_carrera'] = UnidadCarreraArea::findOrFail($id_unidad_carrera);
        }
        $data['graficos'] = $graficos;

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

        $data['datos'] = [
            'rango'              => $gestion_det,
            'por_gestion'        => $porGestion,
            'por_gestion_fuente' => $porGestionFuente,
            'por_gestion_unidad' => $porGestionUnidad,
        ];

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
                        'label'           => 'Total monto',
                        'backgroundColor' => 'rgba(54, 162, 235, 1)',
                        'data'            => $array_monto->toArray(),
                    ], [
                        'label'           => 'Monto ejecutado',
                        'backgroundColor' => 'rgba(40, 167, 69, 1)',
                        'data'            => $array_presupuesto->toArray(),
                    ], [
                        'label'           => 'Saldo',
                        'backgroundColor' => 'rgba(220, 53, 69, 1)',
                        'data'            => $array_pendiente->toArray(),
                    ]],
                ],
                'options' => [
                    'title' => [
                        'display' => true,
                        'text'    => 'Montos asignados por gestión',
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
                            'label'           => 'Total monto asignado',
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'data'            => $array_monto->toArray(),
                        ], [
                            'label'           => 'Monto ejecutado',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => $array_presupuesto->toArray(),
                        ], [
                            'label'           => 'Saldo',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => $array_pendiente->toArray(),
                        ]],
                    ],
                    'options' => [
                        'title' => [
                            'display' => true,
                            'text'    => $value['gestion'],
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
                    'type'    => count($value['unidades']) > 1 ? 'horizontalBar' : 'bar',
                    'data'    => [
                        'labels'   => $array_unidades->toArray(),
                        'datasets' => [[
                            'label'           => 'Total monto asignado',
                            'backgroundColor' => 'rgba(54, 162, 235, 1)',
                            'data'            => $array_monto->toArray(),
                        ], [
                            'label'           => 'Monto ejecutado',
                            'backgroundColor' => 'rgba(40, 167, 69, 1)',
                            'data'            => $array_presupuesto->toArray(),
                        ], [
                            'label'           => 'Saldo',
                            'backgroundColor' => 'rgba(220, 53, 69, 1)',
                            'data'            => $array_pendiente->toArray(),
                        ]],
                    ],
                    'options' => [
                        'title' => [
                            'display' => true,
                            'text'    => $value['gestion'],
                        ],
                    ],
                ];

                $chart = "https://quickchart.io/chart?" . (count($value['unidades']) > 1 ? '' : 'h=225&') . "c=" . urlencode(json_encode($chartConfig));
                $chartsUnidades[$value['gestion']] = $chart;
            }
            $data['chartsUnidades'] = $chartsUnidades;
        }

        // $porUnidad = $porGestionUnidad
        //     ->flatMap(fn($g) => $g['unidades'])
        //     ->groupBy('unidad')
        //     ->map(fn($items) => [
        //         'unidad'                => $items->first()['unidad'],
        //         'total_monto_sum'       => $items->sum('total_monto_sum'),
        //         'total_presupuesto_sum' => $items->sum('total_presupuesto_sum'),
        //         'total_pendiente_sum'   => $items->sum('total_pendiente_sum'),
        //     ])
        //     ->values();

        // $array_unidades    = $porUnidad->pluck('unidad');
        // $array_monto       = $porUnidad->pluck('total_monto_sum');
        // $array_presupuesto = $porUnidad->pluck('total_presupuesto_sum');
        // $array_pendiente   = $porUnidad->pluck('total_pendiente_sum');

        // $chartConfig3 = [
        //     'type'    => 'horizontalBar',
        //     'data'    => [
        //         'labels'   => $array_unidades->toArray(),
        //         'datasets' => [[
        //             'label'           => 'Total monto asignado',
        //             'backgroundColor' => 'rgba(54, 162, 235, 1)',
        //             'data'            => $array_monto->toArray(),
        //         ], [
        //             'label'           => 'Monto ejecutado',
        //             'backgroundColor' => 'rgba(40, 167, 69, 1)',
        //             'data'            => $array_presupuesto->toArray(),
        //         ], [
        //             'label'           => 'Saldo',
        //             'backgroundColor' => 'rgba(220, 53, 69, 1)',
        //             'data'            => $array_pendiente->toArray(),
        //         ]],
        //     ],
        //     'options' => [
        //         'plugins' => [
        //             'title' => [
        //                 'display' => true,
        //                 'text'    => 'Montos por unidad o carrera',
        //             ],
        //         ],
        //     ],
        // ];

        // $unidadChart = "https://quickchart.io/chart?height=250&c=" . urlencode(json_encode($chartConfig3));

        // $data['unidadChart'] = $unidadChart;

        $html = View::make('reportes.graficas.gestion')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    public function get_partidas($gestion, $id_unidad_carrera)
    {
        $q3 = Medida_bienservicio::join('detalleTercerClasi_medida_bn as detalle_mbs3', 'detalle_mbs3.medidabn_id', '=', 'rl_medida_bienservicio.id')
            ->join('rl_detalleClasiTercero as detalle3', 'detalle3.id', '=', 'detalle_mbs3.detalle_tercerclasif_id')
            ->join('rl_clasificador_tercero as clasi3', 'clasi3.id', '=', 'detalle3.tercerclasificador_id')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'rl_medida_bienservicio.formulario5_id')
            ->join('rl_configuracion_formulado as config', 'config.id', '=', 'f5.configFormulado_id')
            ->where('config.gestiones_id', $gestion)
            ->where('f5.unidadCarrera_id', $id_unidad_carrera)
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
            ->where('f5.unidadCarrera_id', $id_unidad_carrera)
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
            ->where('f5.unidadCarrera_id', $id_unidad_carrera)
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
    }
}
