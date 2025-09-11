<?php
namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Areas_estrategicas;
use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Clasificador\Clasificador_primero;
use App\Models\Clasificador\Detalle_cuartoClasificador;
use App\Models\Clasificador\Detalle_quintoClasificador;
use App\Models\Clasificador\Detalle_tercerClasificador;
use App\Models\Configuracion\Financiamiento_tipo;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\Configuracion_poa\Configuracion_formulado;
use App\Models\Gestion;
use App\Models\Gestiones;
use App\Models\Pdes\Pdes_articulacion;
use App\Models\Pei\Matriz_planificacion;
use App\Models\Pei\Tipo_foda;
use App\Models\Poa\Foda_carrerasUnidad;
use App\Models\Poa\Formulario1;
use App\Models\Poa\Formulario2;
use App\Models\Poa\Formulario4;
use App\Models\Poa\Formulario5;
use App\Models\Poa\Medida_bienservicio;
use App\Models\User;
use App\PDF\Reporte_PeiPdu;
use App\PDF\Tcpdf_reporte;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class Controlador_reportesPDF extends Controller
{
    public function reportes_pdf()
    {
        $data['menu']    = 15;
        $data['gestion'] = Gestion::get();
        // $data['gestiones'] = Gestiones::where('estado', 'activo')
        // ->whereYear('gestion', '>=', date('Y'))
        // ->orderBy('gestion', 'desc')
        // ->get();
        return view('reportes.pei', $data);
    }
    //para el reprte del PEI PDF
    public function reportes_poa(Request $request)
    {
        // Crea una nueva instancia de la clase CustomPDF
        $pdf = new Reporte_PeiPdu();

        // Agrega una página al PDF
        //carta
        //$pdf->AddPage('L', 'Letter');
        $pdf->addPage('P', 'Letter');
        //oficio
        //$pdf->AddPage('L',[216, 356]);

        // Personaliza el contenido del PDF
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(10);
        $pdf->CellFitScale(0, 5, mb_convert_encoding(mb_strtoupper('NOMINA DE APROBADOS EN EL CURSO '), "UTF-8", "ISO-8859-1"), '', 0, 'C');

        //$pdf->Watermark('../public/logos/no_perfil.png');

        // Configura la respuesta HTTP como un archivo PDF en el navegador
        $response = Response::make($pdf->Output('archivo.pdf', 'S'), 200);
        $response->header('Content-Type', 'application/pdf');

        return $response;
    }

    //para imprimir la matriz de planificacion
    public function matriz_planificacionPDF(Request $request)
    {
        $validar_datos = $request->validate([
            'gestion'          => 'required',
            'area_estrategica' => 'required',
        ]);

        $html = '<h1 style="color:red;">Hello World</h1>';

        $pdf = new Tcpdf_reporte();
        $pdf::SetTitle('Hello World');
        $pdf::AddPage();
        $pdf->Header(); // Agrega el encabezado
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf->Footer(); // Agrega el pie de página

        $pdf::Output('hello_world.pdf', 'I');
        /* $filename = 'hello_world.pdf';
        $pdf::Output(public_path($filename), 'F');
        return response()->download(public_path($filename)); */
    }

    //para impirmir de la matriz de planificacion
    public function matriz_pdf(Request $request)
    {
        $validar_datos = $request->validate([
            'gestion'          => 'required',
            'area_estrategica' => 'required',
        ]);

        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $aresEstrategicas = Areas_estrategicas::with(['reversa_relacion_areas_estrategicas' => function ($q) {
            $q->with('relacion_gestiones');
        }])->find($request->area_estrategica);
        $data['area_estrategica'] = $aresEstrategicas;
        $listar                   = Matriz_planificacion::with(['unidades_administrativas_inv', 'unidades_administrativas_res', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional', 'indicador_pei', 'tipo', 'categoria', 'resultado_producto', 'programa_proyecto_accion', 'areas_estrategicas' => function ($q) {
            $q->with(['reversa_relacion_areas_estrategicas' => function ($q1) {
                $q1->with('relacion_gestiones', 'relacion_pdes');
            }]);
        }])->where('id_area_estrategica', $request->area_estrategica)->get();

        $data['listar'] = $listar;
        $html           = View::make('reportes.pdf_impresion.matriz_planificacion')->with($data)->render();
        $dompdf->loadHtml($html);
        //$dompdf->setPaper('A4', 'portrait');
        $dompdf->setPaper([0, 0, 612, 1008], 'landscape');
        $dompdf->render();

        //return $dompdf->stream('nombre_del_archivo.pdf');
        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    public function asignacion_montos_por_gestion(Request $request)
    {
        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $data['listar_carreraUnidadArea'] = UnidadCarreraArea::where('id_tipo_carrera', $request->id_tcau)
            ->orderBy('id', 'asc')
            ->get();
        $data['tipo_carrera_unidad'] = Tipo_CarreraUnidad::find($request->id_tcau);
        $id_gestion                  = $request->id_ges;
        $data['resultado']           = UnidadCarreraArea::with(['relacion_caja' => function ($query1) use ($id_gestion) {
            $query1->where('gestiones_id', $id_gestion);
            $query1->with('financiamiento_tipo');
        }])->where('id_tipo_carrera', $request->id_tcau)
            ->orderBy('id', 'asc')
            ->get();
        $data['tipo_financiamiento'] = Financiamiento_tipo::get();
        $data['gestiones']           = Gestiones::find($request->id_gestiones);

        $html = View::make('reportes.listado_carreasPDF.listado_cua')->with($data)->render();
        $dompdf->loadHtml($html);
        //$dompdf->setPaper('A4', 'portrait');
        //$dompdf->setPaper([0, 0, 612, 1008], 'landscape');
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        //return $dompdf->stream('nombre_del_archivo.pdf');
        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    //para el menu de reportes
    public function reportes_pdf_poa()
    {
        $data['menu'] = 16;
        // $data['gestion'] = Gestion::get();
        $data['gestiones'] = Gestiones::where('estado', 'activo')
            // ->whereYear('gestion', '>=', date('Y'))
            ->orderBy('gestion', 'desc')
            ->get();
        $data['tipo'] = Tipo_CarreraUnidad::orderBy('id', 'asc')->get();
        return view('reportes.formulacion_poa', $data);
    }
    //para la parte de listar
    public function tipo_formulados_listar(Request $request)
    {
        if ($request->ajax()) {
            $gestiones = Gestiones::with(['configuracion_formulado' => function ($q) {
                $q->with('formulado_tipo');
            }])->find($request->id);
            if ($gestiones) {
                $data = mensaje_array('success', $gestiones);
            } else {
                $data = mensaje_array('error', 'No hay datos');
            }
            return response()->json($data, 200);
        }
    }
    //para listar la carrera, unidad o area estrategica
    public function listar_carreraunidad(Request $request)
    {
        if ($request->ajax()) {
            $tipo_carrera_unidad = Tipo_CarreraUnidad::with('carrera_unidad_area')
                ->find($request->id);
            if ($tipo_carrera_unidad) {
                $data = mensaje_array('success', $tipo_carrera_unidad);
            } else {
                $data = mensaje_array('error', 'No hay datos');
            }
            return response()->json($data, 200);
        }
    }
    //para ver si tiene formulario 1 o no
    public function carrera_unidadaarea_formulario(Request $request)
    {
        if ($request->ajax()) {
            $id_carreraunidad      = $request->id_carrera;
            $id_configuracion      = $request->id_config;
            $id_gestion_especifica = $request->gestion_especifica;

            $data['id_carreraunidad']      = $id_carreraunidad;
            $data['id_configuracion']      = $id_configuracion;
            $data['id_gestion_especifica'] = $id_gestion_especifica;

            //para el formulario # 1
            $formulario1 = Formulario1::where('gestion_id', $id_gestion_especifica)
                ->where('configFormulado_id', $id_configuracion)
                ->where('unidadCarrera_id', $id_carreraunidad)
                ->get();

            if (! $formulario1->isEmpty()) {
                $data['formulario1'] = 'existe';
            } else {
                $data['formulario1'] = 'vacio';
            }

            //ahora para el formulario 2
            $formulario2 = Formulario2::where('gestion_id', $id_gestion_especifica)
                ->where('configFormulado_id', $id_configuracion)
                ->where('unidadCarrera_id', $id_carreraunidad)
                ->get();
            if (! $formulario2->isEmpty()) {
                $data['formulario2'] = 'existe';
            } else {
                $data['formulario2'] = 'vacio';
            }

            $formulario3_foda = Foda_carrerasUnidad::where('gestion_id', $id_gestion_especifica)
                ->where('UnidadCarrera_id', $id_carreraunidad)
                ->get();
            if (! $formulario3_foda->isEmpty()) {
                $data['formulario3'] = 'existe';
            } else {
                $data['formulario3'] = 'vacio';
            }

            $formulario4 = Formulario4::where('gestion_id', $id_gestion_especifica)
                ->where('UnidadCarrera_id', $id_carreraunidad)
                ->where('configFormulado_id', $id_configuracion)
                ->get();
            if (! $formulario4->isEmpty()) {
                $data['formulario4'] = 'existe';
            } else {
                $data['formulario4'] = 'vacio';
            }

            $formulario5 = Formulario5::where('gestion_id', $id_gestion_especifica)
                ->where('configFormulado_id', $id_configuracion)
                ->where('unidadCarrera_id', $id_carreraunidad)
                ->get();
            if (! $formulario5->isEmpty()) {
                $data['formulario5'] = 'existe';
            } else {
                $data['formulario5'] = 'vacio';
            }
            return view('reportes.listado_formulario.listado_formularios', $data);
        }
    }

    //para generar el pdf del formulario 1
    public function formulario1_pdf(Request $request)
    {
        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf      = new Dompdf($options);
        $formulario1 = Formulario1::with(['relacion_areasEstrategicas', 'configuracion_formulado' => function ($q) {
            $q->with('formulado_tipo', 'gestiones');
        }])
            ->where('gestion_id', $request->id_gestion)
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->get();
        $data['formulario1']        = $formulario1;
        $data['carrera_unidad']     = UnidadCarreraArea::with('tipo_Carrera_UnidadaArea')->find($request->id_carreraunidad);
        $data['usuario_formulado1'] = User::find($formulario1[0]->usuario_id);

        $html = View::make('reportes.listado_formulario.formulario1_pdf')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    //para generar el formulario Nº 2
    public function formulario2_pdf(Request $request)
    {

        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $gestiones          = Gestiones::find($request->id_gestion);
        $areas_estrategicas = Areas_estrategicas::where('id_gestion', $gestiones->id_gestion)
            ->orderBy('id', 'asc')
            ->get();
        $pdes                            = Pdes_articulacion::where('id_gestion', $gestiones->id_gestion)->get();
        $configuracion_formulado         = Configuracion_formulado::with('formulado_tipo')->find($request->id_configuracion);
        $data['carrera_unidad']          = UnidadCarreraArea::with('tipo_Carrera_UnidadaArea')->find($request->id_carreraunidad);
        $data['pdes']                    = $pdes;
        $data['configuracion_formulado'] = $configuracion_formulado;
        $data['gestiones']               = $gestiones;

        //primeria area estrategica
        $formulario2_primer_area = Formulario2::with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional')
            ->where('gestion_id', $request->id_gestion)
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('areaestrategica_id', $areas_estrategicas[0]->id)
            ->get();

        if (! $formulario2_primer_area->isEmpty()) {
            $data['estado_primero']          = 'f2_area1';
            $data['formulario2_area1']       = $formulario2_primer_area;
            $data['area_estrategica_desc']   = $areas_estrategicas[0]->descripcion;
            $data['area_estrategica_codigo'] = $areas_estrategicas[0]->codigo_areas_estrategicas;
        } else {
            $data['estado_primero'] = 'area1_vacio';
        }
        //segunda area estrategica
        $formulario2_segundo_area = Formulario2::with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional')
            ->where('gestion_id', $request->id_gestion)
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('areaestrategica_id', $areas_estrategicas[1]->id)
            ->get();
        if (! $formulario2_segundo_area->isEmpty()) {
            $data['estado_segundo']           = 'f2_area2';
            $data['formulario2_area2']        = $formulario2_segundo_area;
            $data['area_estrategica_desc2']   = $areas_estrategicas[1]->descripcion;
            $data['area_estrategica_codigo2'] = $areas_estrategicas[1]->codigo_areas_estrategicas;
        } else {
            $data['estado_segundo'] = 'area2_vacio';
        }
        //tercer area estrategica
        $formulario2_tercer_area = Formulario2::with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional')
            ->where('gestion_id', $request->id_gestion)
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('areaestrategica_id', $areas_estrategicas[2]->id)
            ->get();
        if (! $formulario2_tercer_area->isEmpty()) {
            $data['estado_tercero']           = 'f2_area3';
            $data['formulario2_area3']        = $formulario2_tercer_area;
            $data['area_estrategica_desc3']   = $areas_estrategicas[2]->descripcion;
            $data['area_estrategica_codigo3'] = $areas_estrategicas[2]->codigo_areas_estrategicas;
        } else {
            $data['estado_tercero'] = 'area3_vacio';
        }
        //cuarto area estrategica
        $formulario2_cuarto_area = Formulario2::with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional')
            ->where('gestion_id', $request->id_gestion)
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('areaestrategica_id', $areas_estrategicas[3]->id)
            ->get();
        if (! $formulario2_cuarto_area->isEmpty()) {
            $data['estado_cuarto']            = 'f2_area4';
            $data['formulario2_area4']        = $formulario2_cuarto_area;
            $data['area_estrategica_desc4']   = $areas_estrategicas[3]->descripcion;
            $data['area_estrategica_codigo4'] = $areas_estrategicas[3]->codigo_areas_estrategicas;
        } else {
            $data['estado_cuarto'] = 'area4_vacio';
        }
        //quinto area estrategica

        /* $formulario2_quinto_area = Formulario2::with('indicador','politica_desarrollo_pdu','objetivo_estrategico','politica_desarrollo_pei','objetivo_estrategico_sub','objetivo_institucional')
                                    ->where('gestion_id', $request->id_gestion )
                                    ->where('configFormulado_id', $request->id_configuracion)
                                    ->where('unidadCarrera_id', $request->id_carreraunidad)
                                    ->where('areaestrategica_id', $areas_estrategicas[4]->id)
                                    ->get();
        if(!$formulario2_quinto_area->isEmpty()){
            $data['estado_quinto']             = 'f2_area5';
            $data['formulario2_area5']          = $formulario2_quinto_area;
            $data['area_estrategica_desc5']      = $areas_estrategicas[4]->descripcion;
            $data['area_estrategica_codigo5']    = $areas_estrategicas[4]->codigo_areas_estrategicas;
        }else{
            $data['estado_quinto']             = 'area5_vacio';
        } */

        $html = View::make('reportes.listado_formulario.formulario2_pdf')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    //para el formulario 3
    public function formulario3_pdf(Request $request)
    {
        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $gestiones = Gestiones::find($request->id_gestion);

        $pdes                            = Pdes_articulacion::where('id_gestion', $gestiones->id_gestion)->get();
        $configuracion_formulado         = Configuracion_formulado::with('formulado_tipo')->find($request->id_configuracion);
        $data['carrera_unidad']          = UnidadCarreraArea::with('tipo_Carrera_UnidadaArea')->find($request->id_carreraunidad);
        $data['pdes']                    = $pdes;
        $data['configuracion_formulado'] = $configuracion_formulado;
        $data['gestiones']               = $gestiones;

        $tipo_foda = Tipo_foda::orderBy('id', 'asc')->get();

        $data['fortalezas'] = Foda_carrerasUnidad::where('gestion_id', $request->id_gestion)
            ->where('UnidadCarrera_id', $request->id_carreraunidad)
            ->where('tipo_foda_id', $tipo_foda[0]->id)
            ->get();

        $data['oportunidades'] = Foda_carrerasUnidad::where('gestion_id', $request->id_gestion)
            ->where('UnidadCarrera_id', $request->id_carreraunidad)
            ->where('tipo_foda_id', $tipo_foda[1]->id)
            ->get();
        $data['debilidades'] = Foda_carrerasUnidad::where('gestion_id', $request->id_gestion)
            ->where('UnidadCarrera_id', $request->id_carreraunidad)
            ->where('tipo_foda_id', $tipo_foda[2]->id)
            ->get();
        $data['amenazas'] = Foda_carrerasUnidad::where('gestion_id', $request->id_gestion)
            ->where('UnidadCarrera_id', $request->id_carreraunidad)
            ->where('tipo_foda_id', $tipo_foda[3]->id)
            ->get();
        //$data['fortalezas'] = $fortalezas;

        $html = View::make('reportes.listado_formulario.formulario3_pdf')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    //para el fomrulario 4
    public function formulario4_pdf(Request $request)
    {
        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $gestiones          = Gestiones::find($request->id_gestion);
        $areas_estrategicas = Areas_estrategicas::where('id_gestion', $gestiones->id_gestion)
            ->orderBy('id', 'asc')
            ->get();
        $pdes                            = Pdes_articulacion::where('id_gestion', $gestiones->id_gestion)->get();
        $configuracion_formulado         = Configuracion_formulado::with('formulado_tipo')->find($request->id_configuracion);
        $data['carrera_unidad']          = UnidadCarreraArea::with('tipo_Carrera_UnidadaArea')->find($request->id_carreraunidad);
        $data['pdes']                    = $pdes;
        $data['configuracion_formulado'] = $configuracion_formulado;
        $data['gestiones']               = $gestiones;

        $area_estrategica_area1 = $areas_estrategicas[0]->id;
        //igual por areas estrategicas area 1
        $formulario4_area1 = Formulario4::with(['tipo', 'categoria', 'bien_servicio', 'unidad_responsable', 'asignacion_monto_f4', 'formulario2' => function ($query) use ($area_estrategica_area1) {
            $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            $query->where('areaestrategica_id', $area_estrategica_area1);
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
        // ->where('gestion_id', $gestiones->id_gestion)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[0]->id)
            ->get();

        // dd($formulario4_area1);
        if (! $formulario4_area1->isEmpty()) {
            $data['estado_primero']          = 'f4_area1';
            $data['formulario4_area1']       = $formulario4_area1;
            $data['area_estrategica_desc']   = $areas_estrategicas[0]->descripcion;
            $data['area_estrategica_codigo'] = $areas_estrategicas[0]->codigo_areas_estrategicas;
            $data['area_estrategica_area1']  = Areas_estrategicas::find($areas_estrategicas[0]->id);
        } else {
            $data['estado_primero'] = 'area1_vacio';
        }

        $area_estrategica_area2 = $areas_estrategicas[1]->id;
        //igual por areas estrategicas area 2
        $formulario4_area2 = Formulario4::with(['tipo', 'categoria', 'bien_servicio', 'unidad_responsable', 'asignacion_monto_f4', 'formulario2' => function ($query) use ($area_estrategica_area2) {
            $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            $query->where('areaestrategica_id', $area_estrategica_area2);
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[1]->id)
            ->get();
        if (! $formulario4_area2->isEmpty()) {
            $data['estado_segundo']           = 'f4_area2';
            $data['formulario4_area2']        = $formulario4_area2;
            $data['area_estrategica_desc2']   = $areas_estrategicas[1]->descripcion;
            $data['area_estrategica_codigo2'] = $areas_estrategicas[1]->codigo_areas_estrategicas;
            $data['area_estrategica_area2']   = Areas_estrategicas::find($areas_estrategicas[1]->id);
        } else {
            $data['estado_segundo'] = 'area2_vacio';
        }

        $area_estrategica_area3 = $areas_estrategicas[2]->id;
        //igual por areas estrategicas area 3
        $formulario4_area3 = Formulario4::with(['tipo', 'categoria', 'bien_servicio', 'unidad_responsable', 'asignacion_monto_f4', 'formulario2' => function ($query) use ($area_estrategica_area3) {
            $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            $query->where('areaestrategica_id', $area_estrategica_area3);
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[2]->id)
            ->get();
        if (! $formulario4_area3->isEmpty()) {
            $data['estado_tercero']           = 'f4_area3';
            $data['formulario4_area3']        = $formulario4_area3;
            $data['area_estrategica_desc3']   = $areas_estrategicas[2]->descripcion;
            $data['area_estrategica_codigo3'] = $areas_estrategicas[2]->codigo_areas_estrategicas;
            $data['area_estrategica_area3']   = Areas_estrategicas::find($areas_estrategicas[2]->id);
        } else {
            $data['estado_tercero'] = 'area3_vacio';
        }

        $area_estrategica_area4 = $areas_estrategicas[3]->id;
        //igual por areas estrategicas area 4
        $formulario4_area4 = Formulario4::with(['tipo', 'categoria', 'bien_servicio', 'unidad_responsable', 'asignacion_monto_f4', 'formulario2' => function ($query) use ($area_estrategica_area4) {
            $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            $query->where('areaestrategica_id', $area_estrategica_area4);
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[3]->id)
            ->get();
        if (! $formulario4_area4->isEmpty()) {
            $data['estado_cuarto']            = 'f4_area4';
            $data['formulario4_area4']        = $formulario4_area4;
            $data['area_estrategica_desc4']   = $areas_estrategicas[3]->descripcion;
            $data['area_estrategica_codigo4'] = $areas_estrategicas[3]->codigo_areas_estrategicas;
            $data['area_estrategica_area4']   = Areas_estrategicas::find($areas_estrategicas[3]->id);
        } else {
            $data['estado_cuarto'] = 'area4_vacio';
        }

        $html = View::make('reportes.listado_formulario.formulario4_pdf')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    public function formulario5_pdf(Request $request)
    {
        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $data['configuracion_formulado'] = Configuracion_formulado::with('formulado_tipo')->find($request->id_configuracion);
        $data['carrera_unidad']          = UnidadCarreraArea::with('tipo_Carrera_UnidadaArea')->find($request->id_carreraunidad);

        $gestiones          = Gestiones::find($request->id_gestion);
        $areas_estrategicas = Areas_estrategicas::with('operaciones')
            ->where('id_gestion', $gestiones->id_gestion)
            ->orderBy('id', 'asc')
            ->get();
        $data['gestiones'] = $gestiones;

        //PARA EL PRIMER AREA ESTRATEGICA Nº 1
        $formulario5_area1 = Formulario5::with(['operacion' => function ($q2) {
            $q2->with('tipo_operacion');
        }, 'formulario4' => function ($q1) {
            $q1->with(['formulario2' => function ($query) {
                $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            }]);
        }, 'medida_bien_serviciof5' => function ($q) {
            $q->with('medida', 'detalle_tercer_clasificador', 'detalle_cuarto_clasificador', 'detalle_quinto_clasificador', 'tipo_financiamiento');
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[0]->id)
            ->get();

        if (! $formulario5_area1->isEmpty()) {
            $data['estado_primero']           = 'f5_area1';
            $data['formulario5_area1']        = $formulario5_area1;
            $data['area_estrategica_desc1']   = $areas_estrategicas[0]->descripcion;
            $data['area_estrategica_codigo1'] = $areas_estrategicas[0]->codigo_areas_estrategicas;
            $data['area_estrategica_area1']   = Areas_estrategicas::find($areas_estrategicas[0]->id);
        } else {
            $data['estado_primero'] = 'area1_vacio';
        }

        //PARA EL PRIMER AREA ESTRATEGICA Nº 2
        $formulario5_area2 = Formulario5::with(['operacion' => function ($q2) {
            $q2->with('tipo_operacion');
        }, 'formulario4' => function ($q1) {
            $q1->with(['formulario2' => function ($query) {
                $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            }]);
        }, 'medida_bien_serviciof5' => function ($q) {
            $q->with('medida', 'detalle_tercer_clasificador', 'detalle_cuarto_clasificador', 'detalle_quinto_clasificador', 'tipo_financiamiento');
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[1]->id)
            ->get();

        if (! $formulario5_area2->isEmpty()) {
            $data['estado_segundo']           = 'f5_area2';
            $data['formulario5_area2']        = $formulario5_area2;
            $data['area_estrategica_desc2']   = $areas_estrategicas[1]->descripcion;
            $data['area_estrategica_codigo2'] = $areas_estrategicas[1]->codigo_areas_estrategicas;
            $data['area_estrategica_area2']   = Areas_estrategicas::find($areas_estrategicas[1]->id);
        } else {
            $data['estado_segundo'] = 'area2_vacio';
        }

        //PARA EL PRIMER AREA ESTRATEGICA Nº 3
        $formulario5_area3 = Formulario5::with(['operacion' => function ($q2) {
            $q2->with('tipo_operacion');
        }, 'formulario4' => function ($q1) {
            $q1->with(['formulario2' => function ($query) {
                $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            }]);
        }, 'medida_bien_serviciof5' => function ($q) {
            $q->with('medida', 'detalle_tercer_clasificador', 'detalle_cuarto_clasificador', 'detalle_quinto_clasificador', 'tipo_financiamiento');
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[2]->id)
            ->get();

        if (! $formulario5_area3->isEmpty()) {
            $data['estado_tercero']           = 'f5_area3';
            $data['formulario5_area3']        = $formulario5_area3;
            $data['area_estrategica_desc3']   = $areas_estrategicas[2]->descripcion;
            $data['area_estrategica_codigo3'] = $areas_estrategicas[2]->codigo_areas_estrategicas;
            $data['area_estrategica_area3']   = Areas_estrategicas::find($areas_estrategicas[2]->id);
        } else {
            $data['estado_tercero'] = 'area3_vacio';
        }

        //PARA EL PRIMER AREA ESTRATEGICA Nº 4
        $formulario5_area4 = Formulario5::with(['operacion' => function ($q2) {
            $q2->with('tipo_operacion');
        }, 'formulario4' => function ($q1) {
            $q1->with(['formulario2' => function ($query) {
                $query->with('indicador', 'politica_desarrollo_pdu', 'objetivo_estrategico', 'politica_desarrollo_pei', 'objetivo_estrategico_sub', 'objetivo_institucional');
            }]);
        }, 'medida_bien_serviciof5' => function ($q) {
            $q->with('medida', 'detalle_tercer_clasificador', 'detalle_cuarto_clasificador', 'detalle_quinto_clasificador', 'tipo_financiamiento');
        }])
            ->where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->where('areaestrategica_id', $areas_estrategicas[3]->id)
            ->get();

        if (! $formulario5_area4->isEmpty()) {
            $data['estado_cuarto']            = 'f5_area4';
            $data['formulario5_area4']        = $formulario5_area4;
            $data['area_estrategica_desc4']   = $areas_estrategicas[3]->descripcion;
            $data['area_estrategica_codigo4'] = $areas_estrategicas[3]->codigo_areas_estrategicas;
            $data['area_estrategica_area4']   = Areas_estrategicas::find($areas_estrategicas[3]->id);
        } else {
            $data['estado_cuarto'] = 'area4_vacio';
        }

        $html = View::make('reportes.listado_formulario.formulario5_pdf')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }

    /**
     * RESUMEN Formulario N°6
     */
    public function formulario6_pdf(Request $request)
    {
        $options = new Options;
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $data['configuracion_formulado'] = Configuracion_formulado::with('formulado_tipo')->find($request->id_configuracion);
        $data['carrera_unidad']          = UnidadCarreraArea::with('tipo_Carrera_UnidadaArea')->find($request->id_carreraunidad);

        $gestiones         = Gestiones::find($request->id_gestion);
        $data['gestiones'] = $gestiones;

        // Obtener formularios 5 vinculados al primer formulado
        $forms5 = Formulario5::where('configFormulado_id', $request->id_configuracion)
            ->where('unidadCarrera_id', $request->id_carreraunidad)
            ->where('gestion_id', $gestiones->id)
            ->select('id')
            ->get();

        $financiamientos         = Financiamiento_tipo::where('estado', 'activo')->get();
        $data['financiamientos'] = $financiamientos;

        $financiamientosForm5 = Medida_bienservicio::join('rl_formulario5', 'rl_medida_bienservicio.formulario5_id', '=', 'rl_formulario5.id')
            ->whereIn('rl_formulario5.id', $forms5->pluck('id'))
            ->select('rl_medida_bienservicio.*')
            ->get();

        /**
         * CLASIFICADORES PARA LISTAR
         * (tercer, cuarto y quinto detalle clasificador)
         */
        $terceros = Detalle_tercerClasificador::join('detalleTercerClasi_medida_bn', 'detalleTercerClasi_medida_bn.detalle_tercerclasif_id', '=', 'rl_detalleClasiTercero.id')
            ->join('rl_clasificador_tercero', 'rl_clasificador_tercero.id', '=', 'rl_detalleClasiTercero.tercerclasificador_id')
            ->join('rl_medida_bienservicio', 'rl_medida_bienservicio.id', '=', 'detalleTercerClasi_medida_bn.medidabn_id')
            ->whereIn('detalleTercerClasi_medida_bn.medidabn_id', $financiamientosForm5->pluck('id'))
            ->select('rl_detalleClasiTercero.titulo as detalle', 'rl_clasificador_tercero.codigo', 'rl_clasificador_tercero.titulo', 'rl_clasificador_tercero.descripcion', 'rl_clasificador_tercero.id_clasificador_segundo', 'rl_medida_bienservicio.formulario5_id', 'rl_medida_bienservicio.total_presupuesto', 'rl_medida_bienservicio.tipo_financiamiento_id', 'rl_medida_bienservicio.id')
            ->orderBy('rl_clasificador_tercero.codigo', 'asc')
            ->get();

        $cuartos = Detalle_cuartoClasificador::join('detalleCuartoClasi_medida_bn', 'detalleCuartoClasi_medida_bn.detalle_cuartoclasif_id', '=', 'rl_detalleClasiCuarto.id')
            ->join('rl_clasificador_cuarto', 'rl_clasificador_cuarto.id', '=', 'rl_detalleClasiCuarto.cuartoclasificador_id')
            ->join('rl_medida_bienservicio', 'rl_medida_bienservicio.id', '=', 'detalleCuartoClasi_medida_bn.medidabn_id')
            ->whereIn('detalleCuartoClasi_medida_bn.medidabn_id', $financiamientosForm5->pluck('id'))
            ->select('rl_detalleClasiCuarto.titulo as detalle', 'rl_clasificador_cuarto.codigo', 'rl_clasificador_cuarto.titulo', 'rl_clasificador_cuarto.descripcion', 'rl_clasificador_cuarto.id_clasificador_tercero', 'rl_medida_bienservicio.formulario5_id', 'rl_medida_bienservicio.total_presupuesto', 'rl_medida_bienservicio.tipo_financiamiento_id', 'rl_medida_bienservicio.id')
            ->orderBy('rl_clasificador_cuarto.codigo', 'asc')
            ->get();

        $quintos = Detalle_quintoClasificador::join('detalleQuintoClasi_medida_bn', 'detalleQuintoClasi_medida_bn.detalle_quintoclasif_id', '=', 'rl_detalleClasiQuinto.id')
            ->join('rl_clasificador_quinto', 'rl_clasificador_quinto.id', '=', 'rl_detalleClasiQuinto.quintoclasificador_id')
            ->join('rl_medida_bienservicio', 'rl_medida_bienservicio.id', '=', 'detalleQuintoClasi_medida_bn.medidabn_id')
            ->whereIn('detalleQuintoClasi_medida_bn.medidabn_id', $financiamientosForm5->pluck('id'))
            ->select('rl_detalleClasiQuinto.titulo as detalle', 'rl_clasificador_quinto.codigo', 'rl_clasificador_quinto.titulo', 'rl_clasificador_quinto.descripcion', 'rl_clasificador_quinto.id_clasificador_cuarto', 'rl_medida_bienservicio.formulario5_id', 'rl_medida_bienservicio.total_presupuesto', 'rl_medida_bienservicio.tipo_financiamiento_id', 'rl_medida_bienservicio.id')
            ->orderBy('rl_clasificador_quinto.codigo', 'asc')
            ->get();

        $data['terceros'] = $terceros;
        $data['cuartos']  = $cuartos;
        $data['quintos']  = $quintos;

        /**
         * FIN DE CLASIFICADORES PARA LISTAR
         */

        // Obtener detalles de clasificador primero
        $detalles = Clasificador_primero::with(['relacion_clasificador_segundo'])
            ->join('confor_clasprim_partipo', 'rl_clasificador_primero.id', '=', 'confor_clasprim_partipo.clasificador_pid')
            ->join('rl_configuracion_formulado', 'confor_clasprim_partipo.configuracion_fid', '=', 'rl_configuracion_formulado.id')
            ->where('confor_clasprim_partipo.configuracion_fid', $request->id_configuracion)
            ->select('rl_clasificador_primero.id', 'rl_clasificador_primero.titulo', 'rl_clasificador_primero.codigo')
            ->get();
        $data['detalles'] = $detalles;

        // Genera el PDF tamaño carta vertical
        $html = View::make('reportes.listado_formulario.formulario6_pdf')->with($data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        return response($pdfContent, 200)->header('Content-Type', 'application/pdf');
    }
}
