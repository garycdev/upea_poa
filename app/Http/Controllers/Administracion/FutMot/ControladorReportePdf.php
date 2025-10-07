<?php
namespace App\Http\Controllers\Administracion\FutMot;

use App\Http\Controllers\Controller;
use App\Models\Carreras_Unidades_Area\Tipo_CarreraUnidad;
use App\Models\Configuracion\UnidadCarreraArea;
use App\Models\FutMot\Fut;
use App\Models\FutMot\FutMov;
use App\Models\FutMot\FutPP;
use App\Models\FutMot\Mot;
use App\Models\FutMot\MotMov;
use App\Models\FutMot\MotPP;
use App\Models\Gestiones;
use App\Models\Poa\Formulario1;
use App\Models\User;
use FPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorReportePdf extends Controller
{
    // Modelo anterior MOT (ya no se usa)
    public function generarPdfMot(Request $req, $id_mot)
    {
        $mot       = Mot::where('id_mot', '=', $id_mot)->first();
        $objetivos = $this->getObjetivos($mot->id_mot);
        // dd($objetivos);

        $pdf = new Fpdf('P', 'mm', 'Letter');
        // $pdf = new Fpdf();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);

        $pdf->AddPage();

        $altura = 2;
        $pdf->SetXY(3, $altura);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, utf8_decode('IMP ' . fecha_literal(date('Y-m-d'), 4)), 0, 0, 'L', false);

        $pdf->Image('logos/encabezado.jpg', 41, 8, 135);
        $pdf->Image('logos/logo_upea.jpg', 185, 5, 25);

        // Titulo
        $altura += 27;
        $pdf->setXY(60, $altura);
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->MultiCell(100, 5, utf8_decode('FORMULARIO DE INICIO DE TRAMITE CONTRATACIÓN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS'), 0, 'C', false);
        $pdf->SetFont('Arial', 'B', 12);
        $altura += 1;
        $pdf->setXY(166, $altura + 15);
        $pdf->Cell(20, 5, utf8_decode('MOT N°:'), 0, 0, 'L', false);
        $pdf->setXY(185, $altura + 12);
        $pdf->Cell(20, 10, formatear_con_ceros($mot->nro), 1, 0, 'C', false);

        // Color rojito para Cell
        $pdf->SetFillColor(217, 149, 148);

        $usuario = User::where('id', '=', $mot->id_usuario)->first();

        // F-1
        $altura += 12;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(10);
        $pdf->Cell(55, 5, utf8_decode('Unidad Solicitante :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setY($altura);
        $altura += 7;
        $pdf->setX(39);
        $pdf->Cell(125, 5, utf8_decode('Lic. ' . $usuario->nombre . ' ' . $usuario->apellido), 1, 0, 'L', false);
        $pdf->setXY(39, $altura);
        $pdf->Cell(125, 5, utf8_decode('Area Carrera: ' . $usuario->unidad_carrera->nombre_completo), 1, 0, 'L', false);

        $altura += 8;
        $pdf->SetLineWidth(0.25);
        $pdf->Line(10, $altura, 200, $altura);
        $pdf->Ln();

        // F-1
        $altura += 4;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Area Estratégica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        // $pdf->SetFillColor(0, 0, 0);
        foreach ($mot->areas_estrategicas_de() as $area) {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, utf8_decode($area->codigo_areas_estrategicas), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, $this->ellipsis($pdf, $area->descripcion, 87), 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, utf8_decode($mot->ae_de_importe . ' bs'), 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-1
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Area Estratégica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);

        if (count($objetivos['areas']) > 0) {
            foreach ($objetivos['areas'] as $area) {
                // dd($area);
                $pdf->setXY(75, $altura);
                $pdf->Cell(8, 5, utf8_decode($area['codigo']), 1, 0, 'C', false);
                $pdf->setX(83);
                $pdf->Cell(87, 5, $this->ellipsis($pdf, $area['descripcion'], 87), 1, 0, 'L', false);
                $pdf->setX(172);
                $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
                $pdf->setX(184);
                $pdf->Cell(20, 5, utf8_decode($mot->ae_de_importe . ' bs'), 1, 0, 'C', false);
                $pdf->setX(77);
                $altura += 5;
            }
        } else {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, '-', 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, '-', 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, '-', 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestión (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($mot->objetivos_gestion_de() as $oins) {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, utf8_decode($oins->codigo), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->setFont('Arial', '', 6);
            $pdf->Cell(87, 5, $this->ellipsis($pdf, $oins->descripcion, 87), 1, 0, 'L', false);
            $pdf->setFont('Arial', '', 7);
            $pdf->setXY(172, $altura);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, utf8_decode($mot->og_de_importe . ' bs'), 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestión (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);

        if (count($objetivos['objetivos']) > 0) {
            foreach ($objetivos['objetivos'] as $oins) {
                $pdf->setXY(75, $altura);
                $pdf->Cell(8, 5, utf8_decode($oins['codigo']), 1, 0, 'C', false);
                $pdf->setX(83);
                $pdf->setFont('Arial', '', 6);
                $pdf->Cell(87, 5, $this->ellipsis($pdf, $oins['descripcion'], 87), 1, 0, 'L', false);
                $pdf->setFont('Arial', '', 7);
                $pdf->setXY(172, $altura);
                $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
                $pdf->setX(184);
                $pdf->Cell(20, 5, utf8_decode($mot->og_de_importe . ' bs'), 1, 0, 'C', false);
                $pdf->setX(77);
                $altura += 5;
            }
        } else {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, '-', 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, '-', 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, '-', 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-3 F-3A
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($mot->tareas_proyectos_de() as $op) {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, utf8_decode($op->id), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->setFont('Arial', '', 6);
            $pdf->Cell(87, 5, $this->ellipsis($pdf, $op->descripcion, 87), 1, 0, 'L', false);
            $pdf->setFont('Arial', '', 7);
            $pdf->setXY(172, $altura);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, utf8_decode($mot->tp_de_importe . ' bs'), 1, 0, 'C', false);
            $pdf->setX(77);

            $altura += 5;
        }
        $altura += 2;
        // F-3 F-3A
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);

        if (count($objetivos['operaciones']) > 0) {
            foreach ($objetivos['operaciones'] as $op) {
                $pdf->setXY(75, $altura);
                $pdf->Cell(8, 5, utf8_decode($op['id']), 1, 0, 'C', false);
                $pdf->setX(83);
                $pdf->setFont('Arial', '', 6);
                $pdf->Cell(87, 5, $this->ellipsis($pdf, $op['descripcion'], 87), 1, 0, 'L', false);
                $pdf->setFont('Arial', '', 7);
                $pdf->setXY(172, $altura);
                $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
                $pdf->setX(184);
                $pdf->Cell(20, 5, utf8_decode($mot->tp_de_importe . ' bs'), 1, 0, 'C', false);
                $pdf->setX(77);

                $altura += 5;
            }
        } else {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, '-', 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, '-', 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, '-', 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }
        $altura += 4;
        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(3, $altura, 207, $altura);
        $pdf->Ln();

        $ancho = 10;
        $altura += 3;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(10);
        $pdf->Cell(50, 3, utf8_decode('Fuente de Financiamiento :'), 0, 0, 'L', false);
        // $pdf->setX(62);
        // $pdf->Cell(8, 3, utf8_decode('1'), 1, 0, 'C', false);
        // $pdf->setX(70);
        // $pdf->Cell(5, 3, utf8_decode('1'), 1, 0, 'C', false);

        $financiamientos = MotPP::where('id_mot', '=', $mot->id_mot)->get();
        $altura          = $altura + 5;
        //Organismos financiadores
        foreach ($financiamientos as $fin) {
            if ($fin->accion == 'DE') {
                // Fuentes de financiamiento
                $pdf->setY($altura);
                $pdf->setFont('Arial', 'B', 7);
                $pdf->setX(10);
                $pdf->Cell(50, 5, utf8_decode('Organismo Financiador     :'), 0, 0, 'L', false);
                $pdf->setFont('Arial', '', 7);
                $pdf->setX(62);
                $pdf->Cell(8, 5, utf8_decode(substr($fin->of->codigo, 0, 1)), 1, 0, 'C', false);
                $pdf->setX(70);
                $pdf->Cell(5, 5, utf8_decode(substr($fin->of->codigo, 1, 1)), 1, 0, 'C', false);
                $pdf->setX(75);
                $pdf->Cell(7, 5, utf8_decode(substr($fin->of->codigo, 2, 1)), 1, 0, 'C', false);
                $pdf->setX(88);
                $pdf->Cell(60, 5, utf8_decode($fin->of->descripcion), 1, 0, 'C', false);
                $altura = $altura + 5;
            } else {
                $altura = $altura;
            }
            $pdf->setXY(45, $altura - 2);
            $pdf->Cell(10, 5, utf8_decode($fin->accion), 0, 0, 'C', false);

            $altura = $altura + 3;
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 7);
            $pdf->setX($ancho);
            $pdf->MultiCell(35, 5, utf8_decode('Partidas Presupuestarias y Descripción                         :'), 0, 'L', false);

            $movimientos = MotMov::where('id_mot_pp', '=', $fin->id_mot_pp)->get();
            $pdf->setFont('Arial', '', 7);
            $total = 0;

            $movimientosGrupo = [];
            $partidaGrupo     = '';
            foreach ($movimientos as $key => $mov) {
                $accion = '5';
                for ($i = 3; $i < 5; $i++) {
                    if (substr($mov->partida_codigo, $i, 1) == 0) {
                        $accion = $i;
                        break;
                    }
                }
                $partida = null;
                switch ($accion) {
                    case '3':
                        $partida = DB::table('rl_clasificador_tercero')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiTercero')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '4':
                        $partida = DB::table('rl_clasificador_cuarto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiCuarto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '5':
                        $partida = DB::table('rl_clasificador_quinto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiQuinto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                }

                if ($partidaGrupo != $mov->partida_codigo) {
                    $partidaGrupo = $mov->partida_codigo;

                    $movimientosGrupo[$partidaGrupo] = [
                        'titulo' => $partida->titulo,
                        'monto'  => $mov->partida_monto,
                    ];
                } else {
                    $movimientosGrupo[$partidaGrupo]['monto'] += $mov->partida_monto;
                }
            }

            $total = 0;
            foreach ($movimientosGrupo as $key => $mov) {
                $pdf->setY($altura);
                $pdf->setX(62);
                $pdf->Cell(25, 5, utf8_decode($key), 1, 0, 'C', false);
                $pdf->setX(87);

                $pdf->Cell(70, 5, utf8_decode($movimientosGrupo[$key]['titulo']), 1, 0, 'L', false);
                $pdf->setX(157);
                $pdf->Cell(25, 5, utf8_decode(con_separador_comas($movimientosGrupo[$key]['monto']) . ' bs'), 1, 0, 'C', false);
                $altura = $altura + 5;

                $total = $total + $movimientosGrupo[$key]['monto'];
            }

            // Total 1 1
            $altura = $altura;
            $pdf->setXY(62, $altura);
            $pdf->setFont('Arial', 'B', 7);
            $pdf->Cell(95, 5, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(157);
            $pdf->Cell(25, 5, utf8_decode(con_separador_comas($total) . ' bs'), 1, 0, 'C', true);
            $altura = $altura + 5;

            if ($fin->accion == 'A') {
                $altura = $altura + 3;
            }
        }

        // Respaldo tramite
        $pdf->setXY(5, -60);
        $pdf->Cell(30, 5, utf8_decode('Respaldo de Tramite           :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(120, 5, utf8_decode($mot->respaldo_tramite), 1, 0, 'L', false);

        // Fecha
        $pdf->setXY(5, -55);
        $pdf->Cell(30, 5, utf8_decode('Fecha de Inicio de Tramite :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(20, 5, utf8_decode('Dia'), 1, 0, 'C', false);
        $pdf->setX(60);
        $pdf->Cell(10, 5, utf8_decode('Mes'), 1, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode('Año'), 1, 0, 'C', false);

        $pdf->setY(-50);
        $pdf->setX(40);
        $pdf->MultiCell(40, 8, utf8_decode($mot->fecha_tramite), 1, 'C', false);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(3, 245, 110, 245);
        $pdf->Ln();

        $usuario = User::where('id', '=', $mot->id_usuario)->first();

        // Unidad
        $pdf->setXY(10, -26);
        $pdf->Cell(30, 5, utf8_decode('Unidad solicitante    :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(90, 5, utf8_decode('Lic. ' . $usuario->nombre . ' ' . $usuario->apellido), 1, 0, 'C', false);

        $pdf->setFont('Arial', '', 5);
        $pdf->setXY(40, -21);
        $pdf->Cell(90, 5, $this->ellipsis($pdf, $usuario->unidad_carrera->nombre_completo, 90), 1, 0, 'C', false);

        // Firmas
        $pdf->SetLineWidth(0.25);
        $pdf->Line(125, 240, 155, 240);
        $pdf->Ln();
        $pdf->setXY(125, -38);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(125, -35);
        $pdf->MultiCell(30, 3, utf8_decode('Técnico de Planificación'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(165, 240, 195, 240);
        $pdf->Ln();
        $pdf->setXY(165, -38);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(165, -35);
        $pdf->MultiCell(30, 3, utf8_decode('Jefe de Planificación'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(145, 260, 175, 260);
        $pdf->Ln();
        $pdf->setXY(145, -18);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        // $pdf->setXY(145, 284);
        // $pdf->MultiCell(30, 3, utf8_decode('Jefe de Planificación'), 0, 'C', false);

        // Nota
        $pdf->setFont('Arial', '', 7);
        $pdf->setXY(10, -7);
        $pdf->Cell(200, 3, utf8_decode('NOTA: La Unidad de Presupuestos remitirá una copia de la Modificación Presupuestaria realizada en el SIGEP a la Unidad de Planificación.'), 0, 0, 'L', false);

        $nombreArchivo = 'MotN' . $mot->nro . '-' . date('Y-m-d_H-i-s') . '.pdf';

        $pdf->Output('I', $nombreArchivo);
        exit;
        // $pdfContent = $pdf->Output($nombreArchivo, 'I');

        // return response($pdfContent, 200)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'inline; filename=nombre_del_pdf.pdf'); // Mostrar en línea en el navegador
    }

    // PDF Formulario de modificaciones (MOT)
    public function formulacionPdfMot(Request $req, $id_mot)
    {
        $id_mot = desencriptar($id_mot);

        $mot       = Mot::where('id_mot', '=', $id_mot)->first();
        $objetivos = $this->getObjetivos($mot->id_mot);
        // dd($objetivos);

        $pdf = new Fpdf('P', 'mm', 'Letter');
        // $pdf = new Fpdf();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);

        $pdf->AddPage();

        $altura = 2;
        $pdf->SetXY(3, $altura);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, utf8_decode('IMP ' . fecha_literal(date('Y-m-d'), 4)), 0, 0, 'L', false);

        $pdf->Image('logos/encabezado.jpg', 41, 8, 135);
        $pdf->Image('logos/logo_upea.jpg', 185, 5, 25);

        // Titulo
        $altura += 27;
        $pdf->setXY(60, $altura);
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->MultiCell(100, 5, utf8_decode('FORMULARIO DE INICIO DE TRAMITE CONTRATACIÓN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS'), 0, 'C', false);
        $pdf->SetFont('Arial', 'B', 12);
        $altura += 1;
        $pdf->setXY(166, $altura + 15);
        $pdf->Cell(20, 5, utf8_decode('MOT N°:'), 0, 0, 'L', false);
        $pdf->setXY(185, $altura + 12);
        $pdf->Cell(20, 10, formatear_con_ceros($mot->nro), 1, 0, 'C', false);

        // Color rojito para Cell
        $pdf->SetFillColor(217, 149, 148);

        $usuario    = User::where('id', '=', $mot->id_usuario)->first();
        $usuarioSol = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre', 'like', '%' . $usuario->nombre . '%')
            ->whereRaw("CONCAT(base_upea.vista_personal_administrativo_2020.paterno, ' ', base_upea.vista_personal_administrativo_2020.materno) LIKE '%{$usuario->apellido}%'")
            ->orderBy("fecha_inicio_asignacion_administrativo", "DESC")
            ->first();

        // F-1
        $altura += 12;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(10);
        $pdf->Cell(55, 5, utf8_decode('Unidad Solicitante :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setY($altura);
        $altura += 7;
        $pdf->setX(39);
        if ($usuarioSol) {
            $pdf->Cell(125, 5, utf8_decode('LIC. ' . $usuarioSol->nombre . ' ' . $usuarioSol->paterno . ' ' . $usuarioSol->materno), 1, 0, 'L', false);
        } else {
            $pdf->Cell(125, 5, utf8_decode('LIC. ' . $usuario->nombre . ' ' . $usuario->apellido), 1, 0, 'L', false);
        }
        $pdf->setXY(39, $altura);
        $pdf->Cell(125, 5, utf8_decode($usuario->unidad_carrera->nombre_completo), 1, 0, 'L', false);

        $altura += 8;
        $pdf->SetLineWidth(0.25);
        $pdf->Line(10, $altura, 200, $altura);
        $pdf->Ln();

        // F-1
        $altura += 4;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Area Estratégica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        // $pdf->SetFillColor(0, 0, 0);
        foreach ($mot->areas_estrategicas_de() as $area) {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, utf8_decode($area->codigo_areas_estrategicas), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, $this->ellipsis($pdf, $area->descripcion, 87), 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, utf8_decode($mot->ae_de_importe . ' bs'), 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-1
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Area Estratégica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);

        if (count($objetivos['areas']) > 0) {
            foreach ($objetivos['areas'] as $area) {
                // dd($area);
                $pdf->setXY(75, $altura);
                $pdf->Cell(8, 5, utf8_decode($area['codigo']), 1, 0, 'C', false);
                $pdf->setX(83);
                $pdf->Cell(87, 5, $this->ellipsis($pdf, $area['descripcion'], 87), 1, 0, 'L', false);
                $pdf->setX(172);
                $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
                $pdf->setX(184);
                $pdf->Cell(20, 5, utf8_decode($mot->ae_de_importe . ' bs'), 1, 0, 'C', false);
                $pdf->setX(77);
                $altura += 5;
            }
        } else {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, '-', 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, '-', 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, '-', 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestión (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($mot->objetivos_gestion_de() as $oins) {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, utf8_decode($oins->codigo), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->setFont('Arial', '', 6);
            $pdf->Cell(87, 5, $this->ellipsis($pdf, $oins->descripcion, 87), 1, 0, 'L', false);
            $pdf->setFont('Arial', '', 7);
            $pdf->setXY(172, $altura);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, utf8_decode($mot->og_de_importe . ' bs'), 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestión (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);

        if (count($objetivos['objetivos']) > 0) {
            foreach ($objetivos['objetivos'] as $oins) {
                $pdf->setXY(75, $altura);
                $pdf->Cell(8, 5, utf8_decode($oins['codigo']), 1, 0, 'C', false);
                $pdf->setX(83);
                $pdf->setFont('Arial', '', 6);
                $pdf->Cell(87, 5, $this->ellipsis($pdf, $oins['descripcion'], 87), 1, 0, 'L', false);
                $pdf->setFont('Arial', '', 7);
                $pdf->setXY(172, $altura);
                $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
                $pdf->setX(184);
                $pdf->Cell(20, 5, utf8_decode($mot->og_de_importe . ' bs'), 1, 0, 'C', false);
                $pdf->setX(77);
                $altura += 5;
            }
        } else {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, '-', 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, '-', 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, '-', 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }

        $altura += 2;
        // F-3 F-3A
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($mot->tareas_proyectos_de() as $op) {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, utf8_decode($op->id), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->setFont('Arial', '', 6);
            $pdf->Cell(87, 5, $this->ellipsis($pdf, $op->descripcion, 87), 1, 0, 'L', false);
            $pdf->setFont('Arial', '', 7);
            $pdf->setXY(172, $altura);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, utf8_decode($mot->tp_de_importe . ' bs'), 1, 0, 'C', false);
            $pdf->setX(77);

            $altura += 5;
        }
        $altura += 2;
        // F-3 F-3A
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(42);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(64);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);

        if (count($objetivos['operaciones']) > 0) {
            foreach ($objetivos['operaciones'] as $op) {
                $pdf->setXY(75, $altura);
                $pdf->Cell(8, 5, utf8_decode($op['id']), 1, 0, 'C', false);
                $pdf->setX(83);
                $pdf->setFont('Arial', '', 6);
                $pdf->Cell(87, 5, $this->ellipsis($pdf, $op['descripcion'], 87), 1, 0, 'L', false);
                $pdf->setFont('Arial', '', 7);
                $pdf->setXY(172, $altura);
                $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
                $pdf->setX(184);
                $pdf->Cell(20, 5, utf8_decode($mot->tp_de_importe . ' bs'), 1, 0, 'C', false);
                $pdf->setX(77);

                $altura += 5;
            }
        } else {
            $pdf->setXY(75, $altura);
            $pdf->Cell(8, 5, '-', 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(87, 5, '-', 1, 0, 'L', false);
            $pdf->setX(172);
            $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
            $pdf->setX(184);
            $pdf->Cell(20, 5, '-', 1, 0, 'C', false);
            $pdf->setX(77);
            $altura += 5;
        }
        $altura += 4;
        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(3, $altura, 207, $altura);
        $pdf->Ln();

        $ancho = 10;
        $altura += 3;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setX(10);
        $pdf->Cell(50, 3, utf8_decode('Fuente de Financiamiento :'), 0, 0, 'L', false);
        // $pdf->setX(62);
        // $pdf->Cell(8, 3, utf8_decode('1'), 1, 0, 'C', false);
        // $pdf->setX(70);
        // $pdf->Cell(5, 3, utf8_decode('1'), 1, 0, 'C', false);

        $financiamientos = MotPP::where('id_mot', '=', $mot->id_mot)->get();
        $altura          = $altura + 5;
        //Organismos financiadores
        foreach ($financiamientos as $fin) {
            if ($fin->accion == 'DE') {
                // Fuentes de financiamiento
                $pdf->setY($altura);
                $pdf->setFont('Arial', 'B', 7);
                $pdf->setX(10);
                $pdf->Cell(50, 5, utf8_decode('Organismo Financiador     :'), 0, 0, 'L', false);
                $pdf->setFont('Arial', '', 7);
                $pdf->setX(62);
                $pdf->Cell(8, 5, utf8_decode(substr($fin->of->codigo, 0, 1)), 1, 0, 'C', false);
                $pdf->setX(70);
                $pdf->Cell(5, 5, utf8_decode(substr($fin->of->codigo, 1, 1)), 1, 0, 'C', false);
                $pdf->setX(75);
                $pdf->Cell(7, 5, utf8_decode(substr($fin->of->codigo, 2, 1)), 1, 0, 'C', false);
                $pdf->setX(88);
                $pdf->Cell(60, 5, utf8_decode($fin->of->descripcion), 1, 0, 'C', false);
                $altura = $altura + 5;
            } else {
                $altura = $altura;
            }
            $pdf->setXY(45, $altura - 2);
            $pdf->Cell(10, 5, utf8_decode($fin->accion), 0, 0, 'C', false);

            $altura = $altura + 3;
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 7);
            $pdf->setX($ancho);
            $pdf->MultiCell(35, 5, utf8_decode('Partidas Presupuestarias y Descripción                         :'), 0, 'L', false);

            $movimientos = MotMov::where('id_mot_pp', '=', $fin->id_mot_pp)->get();
            $total       = 0;
            foreach ($movimientos as $mov) {
                $pdf->setY($altura);
                $pdf->setFont('Arial', '', 7);
                $pdf->setXY(62, $altura + 2);
                $pdf->Cell(25, 5, utf8_decode($mov->partida_codigo), 1, 0, 'C', false);
                $pdf->setX(87);
                $accion = '5';
                for ($i = 3; $i < 5; $i++) {
                    if (substr($mov->partida_codigo, $i, 1) == 0) {
                        $accion = $i;
                        break;
                    }
                }
                $partida = null;
                switch ($accion) {
                    case '3':
                        $partida = DB::table('rl_clasificador_tercero')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiTercero')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '4':
                        $partida = DB::table('rl_clasificador_cuarto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiCuarto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '5':
                        $partida = DB::table('rl_clasificador_quinto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiQuinto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                }
                $pdf->Cell(70, 5, utf8_decode($detalle->titulo), 1, 0, 'L', false);
                $pdf->setX(157);
                $pdf->Cell(20, 5, utf8_decode(con_separador_comas($mov->partida_monto) . ' bs'), 1, 0, 'C', false);
                $altura = $altura + 5;
                $total  = $total + $mov->partida_monto;
            }
            // Total 1 1
            $altura = $altura + 2;
            $pdf->setXY(62, $altura);
            $pdf->setFont('Arial', 'B', 7);
            $pdf->Cell(95, 5, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(157);
            $pdf->Cell(20, 5, utf8_decode(con_separador_comas($total) . ' bs'), 1, 0, 'C', true);
            $altura = $altura + 5;

            if ($fin->accion == 'A') {
                $altura = $altura + 3;
            }
        }

        $pdf->setFont('Arial', 'B', 7);
        // Respaldo tramite
        $pdf->setXY(10, -70);
        $pdf->Cell(30, 5, utf8_decode('Respaldo de Tramite           :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(45);
        $pdf->Cell(150, 5, utf8_decode($mot->respaldo_tramite ?? '-'), 1, 0, 'L', false);

        // Fecha
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setXY(10, -65);
        $pdf->Cell(30, 5, utf8_decode('Fecha de Inicio de Tramite :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(45);
        $pdf->Cell(20, 5, utf8_decode('Dia'), 1, 0, 'C', false);
        $pdf->setX(65);
        $pdf->Cell(10, 5, utf8_decode('Mes'), 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(10, 5, utf8_decode('Año'), 1, 0, 'C', false);

        $pdf->setY(-60);
        $pdf->setX(45);
        $pdf->MultiCell(40, 8, utf8_decode($mot->fecha_tramite ?? '-'), 1, 'C', false);

        // Unidad
        $pdf->setFont('Arial', 'B', 5);
        $pdf->setY(-50);
        $pdf->setX(10);
        $pdf->Cell(65, 5, 'ELABORADO POR', 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 5, 'VERIFICADO POR', 1, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 5, 'APROBADO POR', 1, 0, 'C', false);
        $pdf->setFont('Arial', '', 5);

        $pdf->setY(-45);
        $pdf->setX(10);
        $pdf->Cell(65, 18, '', 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 18, '', 1, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 18, '', 1, 0, 'C', false);

        // $pdf->setY(-32);
        $pdf->setX(10);
        if ($usuarioSol) {
            $pdf->setY(-33);
            $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioSol->nombre . ' ' . $usuarioSol->paterno . ' ' . $usuarioSol->paterno, 65), 0, 0, 'C', false);
            $pdf->setY(-33 + 2);
            $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioSol->nombre_cargo, 65), 0, 0, 'C', false);
        } else {
            $pdf->setY(-32);
            $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuario->nombre . ' ' . $usuario->apellido, 65), 0, 0, 'C', false);
        }
        $pdf->setX(75);
        if ($mot->unidad_verifica) {
            $usuarioVer = DB::table('base_upea.vista_personal_administrativo_2020')
                ->where('base_upea.vista_personal_administrativo_2020.nombre', 'like', '%' . $mot->unidad_verifica->nombre . '%')
                ->whereRaw("CONCAT(base_upea.vista_personal_administrativo_2020.paterno, ' ', base_upea.vista_personal_administrativo_2020.materno) LIKE '%{$mot->unidad_verifica->apellido}%'")
                ->orderBy("fecha_inicio_asignacion_administrativo", "DESC")
                ->first();

            if ($usuarioVer) {
                $pdf->setY(-33);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioVer->nombre . ' ' . $usuarioVer->paterno . ' ' . $usuarioVer->paterno, 65), 0, 0, 'C', false);
                $pdf->setY(-33 + 2);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioVer->nombre_cargo, 65), 0, 0, 'C', false);
            } else {
                $pdf->setY(-32);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $mot->unidad_verifica->nombre . ' ' . $mot->unidad_verifica->apellido, 65), 0, 0, 'C', false);
            }
        } else {
            $pdf->Cell(65, 5, '-', 0, 0, 'C', false);
        }
        $pdf->setX(140);
        if ($mot->unidad_aprueba) {
            $usuarioAp = DB::table('base_upea.vista_personal_administrativo_2020')
                ->where('base_upea.vista_personal_administrativo_2020.nombre', 'like', '%' . $mot->unidad_aprueba->nombre . '%')
                ->whereRaw("CONCAT(base_upea.vista_personal_administrativo_2020.paterno, ' ', base_upea.vista_personal_administrativo_2020.materno) LIKE '%{$mot->unidad_aprueba->apellido}%'")
                ->orderBy("fecha_inicio_asignacion_administrativo", "DESC")
                ->first();

            if ($usuarioAp) {
                $pdf->setY(-33);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioAp->nombre . ' ' . $usuarioAp->paterno . ' ' . $usuarioAp->paterno, 65), 0, 0, 'C', false);
                $pdf->setY(-33 + 2);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioAp->nombre_cargo, 65), 0, 0, 'C', false);
            } else {
                $pdf->setY(-32);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $mot->unidad_aprueba->nombre . ' ' . $mot->unidad_aprueba->apellido, 65), 0, 0, 'C', false);
            }
        } else {
            $pdf->Cell(65, 5, '-', 0, 0, 'C', false);
        }

        $pdf->setY(-27);
        $pdf->setX(10);
        $pdf->Cell(65, 20, '', 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 20, '', 1, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 20, '', 1, 0, 'C', false);

        $tipo = '';
        switch ($mot->usuario->unidad_carrera->id_tipo_carrera) {
            case 1:
                $tipo = 'DIRECTOR%';
                break;
            case 2:
                $tipo = 'JEFE%';
                break;
            case 3:
                $tipo = 'DECANO%';
                break;
            default:
                $tipo = '';
                break;
        }

        $solicitante = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre_cargo', 'like', $tipo)
            ->select(
                'vista_personal_administrativo_2020.*',
                DB::raw("bd_poa.buscarUnidad(unidad_trabajo, '{$mot->unidad_carrera->nombre_completo}') AS dist")
            )
            ->orderByRaw("dist ASC, fecha_inicio_asignacion_administrativo DESC")
            ->first();

        $planificacion = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre_cargo', 'like', 'JEFE%')
            ->select(
                'vista_personal_administrativo_2020.*',
                DB::raw("bd_poa.buscarUnidad(unidad_trabajo, 'UNIDAD DE DESARROLLO ESTRATÉGICO Y PLANIFICACIÓN') AS dist")
            )
            ->orderByRaw("dist ASC, fecha_inicio_asignacion_administrativo DESC")
            ->first();

        $presupuestos = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre_cargo', 'like', 'JEFE%')
            ->select(
                'vista_personal_administrativo_2020.*',
                DB::raw("bd_poa.buscarUnidad(unidad_trabajo, 'UNIDAD DE PRESUPUESTOS') AS dist")
            )
            ->orderByRaw("dist ASC, fecha_inicio_asignacion_administrativo DESC")
            ->first();

        $pdf->setY(-15);
        $pdf->setX(10);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, 'AUTORIZADO POR: ' . $solicitante->nombre . ' ' . $solicitante->paterno . ' ' . $solicitante->materno, 90), 0, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, 'AUTORIZADO POR: ' . $planificacion->nombre . ' ' . $planificacion->paterno . ' ' . $planificacion->materno, 90), 0, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, 'AUTORIZADO POR: ' . $presupuestos->nombre . ' ' . $presupuestos->paterno . ' ' . $presupuestos->materno, 90), 0, 0, 'C', false);

        $pdf->setFont('Arial', 'B', 5);
        
        $pdf->setY(-12);
        $pdf->setX(10);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, $mot->unidad_carrera->nombre_completo, 90), 0, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 5, utf8_decode('UNIDAD DE DESARROLLO ESTRATÉGICO Y PLANIFICACIÓN'), 0, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 5, 'UNIDAD DE PRESUPUESTOS', 0, 0, 'C', false);

        // Nota
        $pdf->setFont('Arial', '', 6);
        $pdf->setXY(5, -5);
        $pdf->Cell(200, 3, utf8_decode('NOTA: La Unidad de Presupuestos remitirá una copia de la Modificación Presupuestaria realizada en el SIGEP a la Unidad de Planificación.'), 0, 0, 'L', false);

        $nombreArchivo = 'MotN' . $mot->nro . '-' . date('Y-m-d_H-i-s') . '.pdf';

        $pdf->Output('I', $nombreArchivo);
        exit;
        // $pdfContent = $pdf->Output($nombreArchivo, 'I');

        // return response($pdfContent, 200)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'inline; filename=nombre_del_pdf.pdf'); // Mostrar en línea en el navegador
    }

    // Modelo anterior FUT (ya no se usa)
    public function generarPdfFut(Request $req, $id_fut)
    {
        $fut = Fut::where('id_fut', '=', $id_fut)->first();

        $pdf = new Fpdf('P', 'mm', 'Letter');
        // $pdf = new Fpdf();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);

        $pdf->AddPage();

        $altura = 2;
        $pdf->SetXY(3, $altura);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, utf8_decode('IMP ' . fecha_literal(date('Y-m-d'), 4)), 0, 0, 'L', false);

        $pdf->Image('logos/encabezado.jpg', 41, 8, 135);
        $pdf->Image('logos/logo_upea.jpg', 185, 5, 25);

        // Titulo
        $altura += 27;
        $pdf->setXY(60, $altura);
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->MultiCell(100, 5, utf8_decode('FORMULARIO DE INICIO DE TRAMITE CONTRATACIÓN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS'), 0, 'C', false);
        $pdf->SetFont('Arial', 'B', 12);
        $altura += 1;
        $pdf->setXY(166, $altura + 15);
        $pdf->Cell(20, 5, utf8_decode('FUT N°:'), 0, 0, 'L', false);
        $pdf->setXY(185, $altura + 12);
        $pdf->Cell(20, 10, formatear_con_ceros($fut->nro), 1, 0, 'C', false);

        // Color rojito para Cell
        $pdf->SetFillColor(217, 149, 148);

        $usuario = User::where('id', '=', $fut->id_usuario)->first();

        // F-1
        $altura += 12;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(10);
        $pdf->Cell(55, 5, utf8_decode('Unidad Solicitante :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setY($altura);
        $altura += 7;
        $pdf->setX(39);
        $pdf->Cell(125, 5, utf8_decode('LIC. ' . $usuario->nombre . ' ' . $usuario->apellido), 1, 0, 'L', false);
        $pdf->setXY(39, $altura);
        $pdf->Cell(125, 5, utf8_decode('UNIDAD ' . $usuario->unidad_carrera->nombre_completo), 1, 0, 'L', false);

        $altura += 8;
        $pdf->SetLineWidth(0.25);
        $pdf->Line(10, $altura, 200, $altura);
        $pdf->Ln();

        // F-1
        $altura += 4;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Area estrategica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($fut->areas_estrategicas() as $area) {
            $pdf->setY($altura);
            $pdf->setX(75);
            $pdf->Cell(10, 5, utf8_decode($area->codigo_areas_estrategicas), 1, 0, 'C', false);
            $pdf->setX(85);
            $pdf->Cell(100, 5, $this->ellipsis($pdf, $area->descripcion, 100), 1, 0, 'L', false);
            $pdf->setX(172);

            $altura += 5;
        }
        $altura += 3;

        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestion (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($fut->objetivos_gestion() as $oins) {
            $pdf->setY($altura);
            $pdf->setX(75);
            $pdf->Cell(10, 5, utf8_decode($oins->codigo), 1, 0, 'C', false);
            $pdf->setX(85);
            $pdf->Cell(100, 5, $this->ellipsis($pdf, $oins->descripcion, 100), 1, 'L', false);
            $pdf->setX(172);

            $altura += 5;
        }
        $altura += 3;

        // F-3
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);

        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($fut->tareas_proyectos() as $op) {
            $pdf->setY($altura);
            $pdf->setX(75);
            $pdf->Cell(10, 5, utf8_decode($op->id), 1, 0, 'C', false);
            $pdf->setX(85);
            $pdf->Cell(100, 5, $this->ellipsis($pdf, $op->descripcion, 100), 1, 0, 'L', false);
            $pdf->setX(172);

            $altura += 5;
        }
        $altura += 3;

        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(20, 5, utf8_decode('Monto Programado POA Bs. :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);
        $pdf->setX(59);
        $pdf->Cell(25, 5, utf8_decode(con_separador_comas($fut->importe) . ' bs'), 1, 0, 'C', false);
        $pdf->setX(84);
        $pdf->Cell(110, 5, utf8_decode(strtoupper('(SON ' . $this->numeroATexto($fut->importe) . ' BOLIVIANOS 00/100)')), 1, 0, 'L', false);
        $pdf->setXY(15, $altura + 3);
        $pdf->Cell(20, 5, utf8_decode('(disponible a la fecha de limite)'), 0, 0, 'L', false);
        $altura += 10;

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(10, $altura, 200, $altura);
        $pdf->Ln();
        $altura += 4;

        $ancho = 18;

        // Fuentes de financiamiento
        // $altura = 75;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX($ancho);
        $pdf->Cell(50, 3, utf8_decode('Fuente de Financiamiento      '), 0, 0, 'L', false);
        $altura = $altura + 5;
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX($ancho + 120);
        $pdf->Cell(50, 3, utf8_decode('Categoría Progmática             '), 0, 0, 'L', false);
        // $pdf->setX(57);
        // $pdf->Cell(6, 3, utf8_decode('0'), 1, 0, 'C', false);
        // $pdf->setX(63);
        // $pdf->Cell(6, 3, utf8_decode('0'), 1, 0, 'C', false);

        $financiamientos = FutPP::where('id_fut', '=', $fut->id_fut)
            ->get();

        $altura = $altura + 2;
        foreach ($financiamientos as $fin) {
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setX($ancho);
            $pdf->Cell(50, 5, utf8_decode('Organismo Financiador          :'), 0, 0, 'L', false);
            $pdf->setFont('Arial', '', 8);
            $pdf->setX(65);
            $pdf->Cell(6, 5, utf8_decode(substr($fin->of->codigo, 0, 1)), 1, 0, 'C', false);
            $pdf->setX(71);
            $pdf->Cell(6, 5, utf8_decode(substr($fin->of->codigo, 1, 1)), 1, 0, 'C', false);
            $pdf->setX(77);
            $pdf->Cell(6, 5, utf8_decode(substr($fin->of->codigo, 2, 1)), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(60, 5, utf8_decode($fin->of->descripcion), 1, 0, 'C', false);

            // $pdf->setX(57);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 0, 1) ? substr($fin->categoria_progmatica, 0, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(63);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 1, 1) ? substr($fin->categoria_progmatica, 1, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(76);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 3, 1) ? substr($fin->categoria_progmatica, 3, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(82);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 4, 1) ? substr($fin->categoria_progmatica, 4, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(88);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 5, 1) ? substr($fin->categoria_progmatica, 5, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(94);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 6, 1) ? substr($fin->categoria_progmatica, 6, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(106);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 8, 1) ? substr($fin->categoria_progmatica, 8, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(112);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 9, 1) ? substr($fin->categoria_progmatica, 9, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(118);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 10, 1) ? substr($fin->categoria_progmatica, 10, 1) : ''), 1, 0, 'C', false);

            $altura = $altura + 8;
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setX($ancho);
            $pdf->MultiCell(45, 3, utf8_decode('Partidas Presupuestarias y Descripción                              :'), 0, 'L', false);
            $altura++;

            // Lista
            $movimientos = FutMov::where('id_fut_pp', '=', $fin->id_fut_pp)->get();
            $pdf->setFont('Arial', '', 8);

            $movimientosGrupo = [];
            $partidaGrupo     = '';
            foreach ($movimientos as $key => $mov) {
                $accion = '5';
                for ($i = 3; $i < 5; $i++) {
                    if (substr($mov->partida_codigo, $i, 1) == 0) {
                        $accion = $i;
                        break;
                    }
                }
                $partida = null;
                switch ($accion) {
                    case '3':
                        $partida = DB::table('rl_clasificador_tercero')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiTercero')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '4':
                        $partida = DB::table('rl_clasificador_cuarto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiCuarto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '5':
                        $partida = DB::table('rl_clasificador_quinto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiQuinto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                }

                if ($partidaGrupo != $mov->partida_codigo) {
                    $partidaGrupo = $mov->partida_codigo;

                    $movimientosGrupo[$partidaGrupo] = [
                        'titulo' => $partida->titulo,
                        'monto'  => $mov->partida_monto,
                    ];
                } else {
                    $movimientosGrupo[$partidaGrupo]['monto'] += $mov->partida_monto;
                }
            }

            $total = 0;
            foreach ($movimientosGrupo as $key => $mov) {
                $pdf->setY($altura);
                $pdf->setX(62);
                $pdf->Cell(25, 5, utf8_decode($key), 1, 0, 'C', false);
                $pdf->setX(87);

                $pdf->Cell(80, 5, $this->ellipsis($pdf, $movimientosGrupo[$key]['titulo'], 80), 1, 0, 'L', false);
                $pdf->setX(167);
                $pdf->Cell(25, 5, utf8_decode(con_separador_comas($movimientosGrupo[$key]['monto']) . ' bs'), 1, 0, 'C', false);
                $altura = $altura + 5;

                $total = $total + $movimientosGrupo[$key]['monto'];
            }

            // Total 2 2
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setXY(62, $altura);
            $pdf->Cell(105, 5, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(167);
            $pdf->Cell(25, 5, utf8_decode(con_separador_comas($total) . ' bs'), 1, 0, 'C', true);
            $altura = $altura + 10;
        }

        $pdf->setFont('Arial', 'B', 8);
        // Respaldo tramite
        $pdf->setXY(5, -72);
        $pdf->Cell(30, 5, utf8_decode('Respaldo de Tramite             :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(50);
        $pdf->Cell(120, 5, utf8_decode($fut->respaldo_tramite), 1, 0, 'L', false);

        // Fecha
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setXY(5, -65);
        $pdf->Cell(30, 5, utf8_decode('Fecha de Inicio de Tramite    :'), 0, 0, 'L', false);
        $pdf->setX(50);
        $pdf->Cell(20, 5, utf8_decode('Dia'), 1, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode('Mes'), 1, 0, 'C', false);
        $pdf->setX(80);
        $pdf->Cell(10, 5, utf8_decode('Año'), 1, 0, 'C', false);

        $pdf->setY(-60);
        $pdf->setX(50);
        $pdf->MultiCell(40, 5, utf8_decode($fut->fecha_tramite), 1, 'C', false);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(0, 227, 210, 227);
        $pdf->Ln();

        $gestion = DB::table('fut')
            ->join('rl_configuracion_formulado AS cf', 'cf.id', '=', 'fut.id_configuracion_formulado')
            ->join('rl_gestiones AS rg', 'rg.id', '=', 'cf.gestiones_id')
            ->select('rg.gestion')
            ->first();

        $pdf->setFont('Arial', '', 7);
        // Unidad
        $pdf->setXY(10, -45);
        $pdf->Cell(30, 5, utf8_decode('Unidad de Planificación        :'), 0, 0, 'L', false);
        $pdf->setX(50);
        $pdf->MultiCell(50, 3, utf8_decode('La solicitud realizada, se encuentra programado en su POA ' . $gestion->gestion), 0, 'L', false);

        // Firmas
        $pdf->setFont('Arial', '', 6);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(115, 240, 145, 240);
        $pdf->Ln();
        $pdf->setXY(115, -38);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(115, -36);
        $pdf->MultiCell(30, 3, utf8_decode('Técnico de Planificación'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(160, 240, 190, 240);
        $pdf->Ln();
        $pdf->setXY(160, -38);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(160, -36);
        $pdf->MultiCell(30, 3, utf8_decode('Jefe de Planificación'), 0, 'C', false);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(0, 248, 210, 248);
        $pdf->Ln();

        // Unidad
        $pdf->setFont('Arial', '', 7);
        $pdf->setXY(10, -21);
        $pdf->Cell(30, 5, utf8_decode('Unidad de Presupuestos      :'), 0, 0, 'L', false);
        $pdf->setX(44);
        $pdf->Cell(60, 5, utf8_decode('Se encuentra presupuestado en el SIGEP'), 0, 0, 'C', false);

        $pdf->setXY(44, -18);
        $pdf->Cell(60, 5, utf8_decode('N° de Preventivo: ....................................'), 0, 0, 'C', false);

        // Firmas
        $pdf->setFont('Arial', '', 6);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(115, 262, 145, 262);
        $pdf->Ln();
        $pdf->setXY(115, -16);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(115, -14);
        $pdf->MultiCell(30, 3, utf8_decode('Técnico de Presupuestos'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(160, 262, 190, 262);
        $pdf->Ln();
        $pdf->setXY(160, -16);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(160, -14);
        $pdf->MultiCell(30, 3, utf8_decode('Jefe de Presupuestos'), 0, 'C', false);
        // $pdf->setXY(145, 284);
        // $pdf->MultiCell(30, 3, utf8_decode('Jefe de Planificación'), 0, 'C', false);

        // Nota
        $pdf->setFont('Arial', '', 7);
        $pdf->setXY(10, -7);
        $pdf->Cell(200, 3, utf8_decode('NOTA: La Unidad de Presupuestos remitirá una copia del Preventivo realizado en el SIGEP a la Unidad de Planificación.'), 0, 0, 'L', false);

        // $pdf->Output();

        // Descargar pdf directamente
        $nombreArchivo = 'FUT-N' . $fut->nro . '_' . date('Y-m-d_H-i-s') . '.pdf';
        $pdf->Output('I', $nombreArchivo);
        exit;
    }

    // PDF Formulario unico de tramite (FUT)
    public function formulacionPdfFut(Request $req, $id_fut)
    {
        $id_fut = desencriptar($id_fut);

        $fut = Fut::where('id_fut', '=', $id_fut)->first();

        $pdf = new Fpdf('P', 'mm', 'Letter');
        // $pdf = new Fpdf();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);

        $pdf->AddPage();

        $altura = 2;
        $pdf->SetXY(3, $altura);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, utf8_decode('IMP ' . fecha_literal(date('Y-m-d'), 4)), 0, 0, 'L', false);

        $pdf->Image('logos/encabezado.jpg', 41, 8, 135);
        $pdf->Image('logos/logo_upea.jpg', 185, 5, 25);

        // Titulo
        $altura += 27;
        $pdf->setXY(60, $altura);
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->MultiCell(100, 5, utf8_decode('FORMULARIO DE INICIO DE TRAMITE CONTRATACIÓN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS'), 0, 'C', false);
        $pdf->SetFont('Arial', 'B', 12);
        $altura += 1;
        $pdf->setXY(166, $altura + 15);
        $pdf->Cell(20, 5, utf8_decode('FUT N°:'), 0, 0, 'L', false);
        $pdf->setXY(185, $altura + 12);
        $pdf->Cell(20, 10, formatear_con_ceros($fut->nro), 1, 0, 'C', false);

        // Color rojito para Cell
        $pdf->SetFillColor(217, 149, 148);

        $usuario    = User::where('id', '=', $fut->id_usuario)->first();
        $usuarioSol = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre', 'like', '%' . $usuario->nombre . '%')
            ->whereRaw("CONCAT(base_upea.vista_personal_administrativo_2020.paterno, ' ', base_upea.vista_personal_administrativo_2020.materno) LIKE '%{$usuario->apellido}%'")
            ->orderBy("fecha_inicio_asignacion_administrativo", "DESC")
            ->first();

        // F-1
        $altura += 12;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(10);
        $pdf->Cell(55, 5, utf8_decode('Unidad Solicitante :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setY($altura);
        $altura += 7;
        $pdf->setX(39);
        if ($usuarioSol) {
            $pdf->Cell(125, 5, utf8_decode('LIC. ' . $usuarioSol->nombre . ' ' . $usuarioSol->paterno . ' ' . $usuarioSol->materno), 1, 0, 'L', false);
        } else {
            $pdf->Cell(125, 5, utf8_decode('LIC. ' . $usuario->nombre . ' ' . $usuario->apellido), 1, 0, 'L', false);
        }
        $pdf->setXY(39, $altura);
        $pdf->Cell(125, 5, utf8_decode($usuario->unidad_carrera->nombre_completo), 1, 0, 'L', false);

        $altura += 8;
        $pdf->SetLineWidth(0.25);
        $pdf->Line(10, $altura, 200, $altura);
        $pdf->Ln();

        // F-1
        $altura += 4;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Area estrategica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($fut->areas_estrategicas() as $area) {
            $pdf->setY($altura);
            $pdf->setX(75);
            $pdf->Cell(10, 5, utf8_decode($area->codigo_areas_estrategicas), 1, 0, 'C', false);
            $pdf->setX(85);
            $pdf->Cell(100, 5, $this->ellipsis($pdf, $area->descripcion, 100), 1, 0, 'L', false);
            $pdf->setX(172);

            $altura += 5;
        }
        $altura += 3;

        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestion (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($fut->objetivos_gestion() as $oins) {
            $pdf->setY($altura);
            $pdf->setX(75);
            $pdf->Cell(10, 5, utf8_decode($oins->codigo), 1, 0, 'C', false);
            $pdf->setX(85);
            $pdf->Cell(100, 5, $this->ellipsis($pdf, $oins->descripcion, 100), 1, 'L', false);
            $pdf->setX(172);

            $altura += 5;
        }
        $altura += 3;

        // F-3
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);

        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        foreach ($fut->tareas_proyectos() as $op) {
            $pdf->setY($altura);
            $pdf->setX(75);
            $pdf->Cell(10, 5, utf8_decode($op->id), 1, 0, 'C', false);
            $pdf->setX(85);
            $pdf->Cell(100, 5, $this->ellipsis($pdf, $op->descripcion, 100), 1, 0, 'L', false);
            $pdf->setX(172);

            $altura += 5;
        }
        $altura += 3;

        // F-2
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX(15);
        $pdf->Cell(20, 5, utf8_decode('Monto Programado POA Bs. :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 8);
        $pdf->setX(59);
        $pdf->Cell(25, 5, utf8_decode(con_separador_comas($fut->importe) . ' bs'), 1, 0, 'C', false);
        $pdf->setX(84);
        $pdf->Cell(110, 5, utf8_decode(strtoupper('(SON ' . $this->numeroATexto($fut->importe) . ' BOLIVIANOS 00/100)')), 1, 0, 'L', false);
        $pdf->setXY(15, $altura + 3);
        $pdf->Cell(20, 5, utf8_decode('(disponible a la fecha de limite)'), 0, 0, 'L', false);
        $altura += 10;

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(10, $altura, 200, $altura);
        $pdf->Ln();
        $altura += 4;

        $ancho = 18;

        // Fuentes de financiamiento
        // $altura = 75;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX($ancho);
        $pdf->Cell(50, 3, utf8_decode('Fuente de Financiamiento      '), 0, 0, 'L', false);
        $altura = $altura + 5;
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setX($ancho + 120);
        $pdf->Cell(50, 3, utf8_decode('Categoría Progmática             '), 0, 0, 'L', false);
        // $pdf->setX(57);
        // $pdf->Cell(6, 3, utf8_decode('0'), 1, 0, 'C', false);
        // $pdf->setX(63);
        // $pdf->Cell(6, 3, utf8_decode('0'), 1, 0, 'C', false);

        $financiamientos = FutPP::where('id_fut', '=', $fut->id_fut)
            ->get();

        $altura = $altura + 2;
        foreach ($financiamientos as $fin) {
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setX($ancho);
            $pdf->Cell(50, 5, utf8_decode('Organismo Financiador          :'), 0, 0, 'L', false);
            $pdf->setFont('Arial', '', 8);
            $pdf->setX(65);
            $pdf->Cell(6, 5, utf8_decode(substr($fin->of->codigo, 0, 1)), 1, 0, 'C', false);
            $pdf->setX(71);
            $pdf->Cell(6, 5, utf8_decode(substr($fin->of->codigo, 1, 1)), 1, 0, 'C', false);
            $pdf->setX(77);
            $pdf->Cell(6, 5, utf8_decode(substr($fin->of->codigo, 2, 1)), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(60, 5, utf8_decode($fin->of->descripcion), 1, 0, 'C', false);

            // $pdf->setX(57);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 0, 1) ? substr($fin->categoria_progmatica, 0, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(63);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 1, 1) ? substr($fin->categoria_progmatica, 1, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(76);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 3, 1) ? substr($fin->categoria_progmatica, 3, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(82);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 4, 1) ? substr($fin->categoria_progmatica, 4, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(88);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 5, 1) ? substr($fin->categoria_progmatica, 5, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(94);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 6, 1) ? substr($fin->categoria_progmatica, 6, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(106);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 8, 1) ? substr($fin->categoria_progmatica, 8, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(112);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 9, 1) ? substr($fin->categoria_progmatica, 9, 1) : ''), 1, 0, 'C', false);
            // $pdf->setX(118);
            // $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 10, 1) ? substr($fin->categoria_progmatica, 10, 1) : ''), 1, 0, 'C', false);

            $altura = $altura + 8;
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setX($ancho);
            $pdf->MultiCell(45, 3, utf8_decode('Partidas Presupuestarias y Descripción                              :'), 0, 'L', false);
            $altura++;

            $movimientos = FutMov::where('id_fut_pp', '=', $fin->id_fut_pp)->get();
            $total       = 0;
            // Lista

            $pdf->setFont('Arial', '', 8);
            foreach ($movimientos as $mov) {
                $pdf->setY($altura);
                $pdf->setX(62);
                $pdf->Cell(25, 5, utf8_decode($mov->partida_codigo), 1, 0, 'C', false);
                $pdf->setX(87);
                $accion = '5';
                for ($i = 3; $i < 5; $i++) {
                    if (substr($mov->partida_codigo, $i, 1) == 0) {
                        $accion = $i;
                        break;
                    }
                }
                $partida = null;
                switch ($accion) {
                    case '3':
                        $partida = DB::table('rl_clasificador_tercero')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiTercero')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '4':
                        $partida = DB::table('rl_clasificador_cuarto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiCuarto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                    case '5':
                        $partida = DB::table('rl_clasificador_quinto')->where('codigo', '=', $mov->partida_codigo)->first();
                        $detalle = DB::table('rl_detalleClasiQuinto')->where('id', '=', $mov->id_detalle)->first();
                        break;
                }
                $pdf->Cell(80, 5, $this->ellipsis($pdf, $detalle->titulo, 80), 1, 0, 'L', false);
                $pdf->setX(167);
                $pdf->Cell(25, 5, utf8_decode(con_separador_comas($mov->partida_monto) . ' bs'), 1, 0, 'C', false);
                $altura = $altura + 5;

                $total = $total + $mov->partida_monto;
            }

            // Total 2 2
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setXY(62, $altura);
            $pdf->Cell(105, 5, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(167);
            $pdf->Cell(25, 5, utf8_decode(con_separador_comas($total) . ' bs'), 1, 0, 'C', true);
            $altura = $altura + 10;
        }

        $pdf->setFont('Arial', 'B', 7);
        // Respaldo tramite
        $pdf->setXY(10, -70);
        $pdf->Cell(30, 5, utf8_decode('Respaldo de Tramite           :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(45);
        $pdf->Cell(150, 5, utf8_decode($fut->respaldo_tramite ?? '-'), 1, 0, 'L', false);

        // Fecha
        $pdf->setFont('Arial', 'B', 7);
        $pdf->setXY(10, -65);
        $pdf->Cell(30, 5, utf8_decode('Fecha de Inicio de Tramite :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 7);
        $pdf->setX(45);
        $pdf->Cell(20, 5, utf8_decode('Dia'), 1, 0, 'C', false);
        $pdf->setX(65);
        $pdf->Cell(10, 5, utf8_decode('Mes'), 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(10, 5, utf8_decode('Año'), 1, 0, 'C', false);

        $pdf->setY(-60);
        $pdf->setX(45);
        $pdf->MultiCell(40, 8, utf8_decode($fut->fecha_tramite ?? '-'), 1, 'C', false);

        // Unidad
        $pdf->setFont('Arial', 'B', 5);
        $pdf->setY(-50);
        $pdf->setX(10);
        $pdf->Cell(65, 5, 'ELABORADO POR', 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 5, 'VERIFICADO POR', 1, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 5, 'APROBADO POR', 1, 0, 'C', false);
        $pdf->setFont('Arial', '', 5);

        $pdf->setY(-45);
        $pdf->setX(10);
        $pdf->Cell(65, 18, '', 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 18, '', 1, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 18, '', 1, 0, 'C', false);

        // $pdf->setY(-32);
        $pdf->setX(10);
        if ($usuarioSol) {
            $pdf->setXY(10, -33);
            $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioSol->nombre . ' ' . $usuarioSol->paterno . ' ' . $usuarioSol->paterno, 65), 0, 0, 'C', false);
            $pdf->setXY(10, -33 + 2);
            $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioSol->nombre_cargo, 65), 0, 0, 'C', false);
        } else {
            $pdf->setXY(10, -32);
            $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuario->nombre . ' ' . $usuario->apellido, 65), 0, 0, 'C', false);
        }

        $pdf->setX(75);
        if ($fut->unidad_verifica) {
            $usuarioVer = DB::table('base_upea.vista_personal_administrativo_2020')
                ->where('base_upea.vista_personal_administrativo_2020.nombre', 'like', '%' . $fut->unidad_verifica->nombre . '%')
                ->whereRaw("CONCAT(base_upea.vista_personal_administrativo_2020.paterno, ' ', base_upea.vista_personal_administrativo_2020.materno) LIKE '%{$fut->unidad_verifica->apellido}%'")
                ->orderBy("fecha_inicio_asignacion_administrativo", "DESC")
                ->first();

            if ($usuarioVer) {
                $pdf->setXY(75, -33);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioVer->nombre . ' ' . $usuarioVer->paterno . ' ' . $usuarioVer->paterno, 65), 0, 0, 'C', false);
                $pdf->setXY(75, -33 + 2);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioVer->nombre_cargo, 65), 0, 0, 'C', false);
            } else {
                $pdf->setXY(75, -32);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $fut->unidad_verifica->nombre . ' ' . $fut->unidad_verifica->apellido, 65), 0, 0, 'C', false);
            }
        } else {
            $pdf->Cell(65, 5, '-', 0, 0, 'C', false);
        }

        $pdf->setX(140);
        if ($fut->unidad_aprueba) {
            $usuarioAp = DB::table('base_upea.vista_personal_administrativo_2020')
                ->where('base_upea.vista_personal_administrativo_2020.nombre', 'like', '%' . $fut->unidad_aprueba->nombre . '%')
                ->whereRaw("CONCAT(base_upea.vista_personal_administrativo_2020.paterno, ' ', base_upea.vista_personal_administrativo_2020.materno) LIKE '%{$fut->unidad_aprueba->apellido}%'")
                ->orderBy("fecha_inicio_asignacion_administrativo", "DESC")
                ->first();

            if ($usuarioAp) {
                $pdf->setXY(140, -33);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioAp->nombre . ' ' . $usuarioAp->paterno . ' ' . $usuarioAp->paterno, 65), 0, 0, 'C', false);
                $pdf->setXY(140, -33 + 2);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $usuarioAp->nombre_cargo, 65), 0, 0, 'C', false);
            } else {
                $pdf->setXY(140, -32);
                $pdf->Cell(65, 5, $this->ellipsis($pdf, $fut->unidad_aprueba->nombre . ' ' . $fut->unidad_aprueba->apellido, 65), 0, 0, 'C', false);
            }
        } else {
            $pdf->Cell(65, 5, '-', 0, 0, 'C', false);
        }

        $pdf->setY(-27);
        $pdf->setX(10);
        $pdf->Cell(65, 20, '', 1, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 20, '', 1, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 20, '', 1, 0, 'C', false);

        $tipo = '';
        switch ($fut->usuario->unidad_carrera->id_tipo_carrera) {
            case 1:
                $tipo = 'DIRECTOR%';
                break;
            case 2:
                $tipo = 'JEFE%';
                break;
            case 3:
                $tipo = 'DECANO%';
                break;
            default:
                $tipo = '';
                break;
        }

        $solicitante = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre_cargo', 'like', $tipo)
            ->select(
                'vista_personal_administrativo_2020.*',
                DB::raw("bd_poa.buscarUnidad(unidad_trabajo, '{$fut->unidad_carrera->nombre_completo}') AS dist")
            )
            ->orderByRaw("dist ASC, fecha_inicio_asignacion_administrativo DESC")
            ->first();

        $planificacion = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre_cargo', 'like', 'JEFE%')
            ->select(
                'vista_personal_administrativo_2020.*',
                DB::raw("bd_poa.buscarUnidad(unidad_trabajo, 'UNIDAD DE DESARROLLO ESTRATÉGICO Y PLANIFICACIÓN') AS dist")
            )
            ->orderByRaw("dist ASC, fecha_inicio_asignacion_administrativo DESC")
            ->first();

        $presupuestos = DB::table('base_upea.vista_personal_administrativo_2020')
            ->where('base_upea.vista_personal_administrativo_2020.nombre_cargo', 'like', 'JEFE%')
            ->select(
                'vista_personal_administrativo_2020.*',
                DB::raw("bd_poa.buscarUnidad(unidad_trabajo, 'UNIDAD DE PRESUPUESTOS') AS dist")
            )
            ->orderByRaw("dist ASC, fecha_inicio_asignacion_administrativo DESC")
            ->first();

        /**
         * SELECT bd_poa.buscarUnidad(unidad_trabajo, 'AREA DE SALUD') AS dist,
        base_upea.vista_personal_administrativo_2020.*
        FROM base_upea.vista_personal_administrativo_2020
        WHERE base_upea.vista_personal_administrativo_2020.nombre_cargo LIKE 'DECANO%'
        ORDER BY dist ASC, base_upea.vista_personal_administrativo_2020.fecha_inicio_asignacion_administrativo DESC
        LIMIT 1;
         */

        $pdf->setY(-15);
        $pdf->setX(10);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, 'AUTORIZADO POR: ' . $solicitante->nombre . ' ' . $solicitante->paterno . ' ' . $solicitante->materno, 90), 0, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, 'AUTORIZADO POR: ' . $planificacion->nombre . ' ' . $planificacion->paterno . ' ' . $planificacion->materno, 90), 0, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, 'AUTORIZADO POR: ' . $presupuestos->nombre . ' ' . $presupuestos->paterno . ' ' . $presupuestos->materno, 90), 0, 0, 'C', false);

        $pdf->setFont('Arial', 'B', 5);

        $pdf->setY(-12);
        $pdf->setX(10);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, $solicitante->nombre_cargo, 90), 0, 0, 'C', false);
        $pdf->setX(75);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, $planificacion->nombre_cargo, 90), 0, 0, 'C', false);
        $pdf->setX(140);
        $pdf->Cell(65, 5, $this->ellipsis($pdf, $presupuestos->nombre_cargo, 90), 0, 0, 'C', false);

        // Nota
        $pdf->setFont('Arial', '', 6);
        $pdf->setXY(5, -5);
        $pdf->Cell(200, 3, utf8_decode('NOTA: La Unidad de Presupuestos remitirá una copia del Preventivo realizado en el SIGEP a la Unidad de Planificación.'), 0, 0, 'L', false);
        // $pdf->Output();

        // Descargar pdf directamente
        $nombreArchivo = 'FUT-N' . $fut->nro . '_' . date('Y-m-d_H-i-s') . '.pdf';
        $pdf->Output('I', $nombreArchivo);
        exit;
    }

    // Convierte numero a literal
    public function numeroATexto($numero)
    {
        $unidades   = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete',
            'dieciocho', 'diecinueve',
        ];
        $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta',
            'noventa',
        ];
        $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos',
            'setecientos', 'ochocientos', 'novecientos',
        ];
        $miles = ['', 'mil', 'millón', 'mil millones', 'billón', 'mil billones', 'trilló', 'mil trilles'];
        if ($numero == 0) {
            return 'cero';
        }
        $texto = '';
        $num   = $numero;
        for ($i = count($miles) - 1; $i >= 0; $i--) {
            $divisor  = pow(10, $i * 3);
            $segmento = floor($num / $divisor);
            $num -= $segmento * $divisor;
            if ($segmento) {
                $centena = floor($segmento / 100);
                $decena  = floor(($segmento % 100) / 10);
                $unidad  = $segmento % 10;
                if ($centena) {
                    $texto .= $centenas[$centena] . ' ';
                }
                if ($decena == 1) {
                    $texto .= $especiales[$unidad] . ' ';
                } else {
                    $texto .= $decenas[$decena] . ' ';
                    $texto .= $unidades[$unidad] . ' ';
                }
                $texto .= $miles[$i] . ' ';
            }
        }
        return trim($texto);
    }

    // Coloca '...' si el texto se sobrepasa del tamaño
    public function ellipsis($pdf, $text, $width)
    {
        $width -= 2;
        $text = utf8_decode($text);
        if ($pdf->GetStringWidth($text) <= $width) {
            return $text;
        }

        while ($pdf->GetStringWidth($text . '...') > $width && strlen($text) > 0) {
            $text = substr($text, 0, -1);
        }
        return $text . '...';
    }

    // Lista unidades
    public function index()
    {
        $unidades  = Tipo_CarreraUnidad::get();
        $gestiones = Gestiones::where('estado', '=', 'activo')
            ->orderBy('gestion', 'ASC')
            ->get();

        return view('admin.unidades', compact('unidades', 'gestiones'));
    }

    public function obtenerCarreras(Request $req)
    {
        $id_tipo  = $req->input('id_tipo');
        $tipo     = Tipo_CarreraUnidad::where('id', '=', $id_tipo)->first();
        $carreras = UnidadCarreraArea::where('id_tipo_carrera', '=', $id_tipo)
            ->where('estado', '=', 'activo')
            ->get();

        $data = [$tipo, $carreras];
        return $data;
    }

    public function obtenerGestiones(Request $req)
    {
        $id_carrera = $req->input('id_carrera');
        $gestiones  = Formulario1::join('rl_gestiones as rg', 'rg.id', '=', 'rl_formulario1.gestion_id')
            ->join('rl_configuracion_formulado as rcf', 'rcf.id', '=', 'rl_formulario1.configFormulado_id')
            ->join('rl_formulado_tipo as rft', 'rft.id', '=', 'rcf.formulado_id')
            ->where('rl_formulario1.unidadCarrera_id', '=', $id_carrera)
            ->select('rl_formulario1.id as id_formulado', 'rcf.id as id_conformulado', 'rg.id as id_gestion', 'rg.gestion', 'rft.descripcion')
            ->orderBy('rg.id', 'DESC')
            ->orderBY('rft.id', 'ASC')
            ->get();
        return $gestiones;
    }

    public function getObjetivos($id_mot)
    {
        $data = Mot::join('mot_partidas_presupuestarias as motpp', 'motpp.id_mot', '=', 'mot.id_mot')
            ->join('mot_movimiento as motmov', 'motmov.id_mot_pp', '=', 'motpp.id_mot_pp')
            ->join('rl_medida_bienservicio as mbs', 'mbs.id', '=', 'motmov.id_mbs')
            ->join('rl_formulario5 as f5', 'f5.id', '=', 'mbs.formulario5_id')
            ->join('rl_formulario4 as f4', 'f4.id', '=', 'f5.formulario4_id')
            ->join('rl_operaciones as op', 'op.id', '=', 'f5.operacion_id')
            ->join('formulario2_objInstitucional as f2_oins', 'f2_oins.formulario2_id', '=', 'f4.formulario2_id')
            ->join('rl_objetivo_institucional as oins', 'oins.id', '=', 'f2_oins.objInstitucional_id')
            ->join('rl_areas_estrategicas as ae', 'ae.id', '=', 'op.area_estrategica_id')
            ->where('mot.id_mot', $id_mot)
            ->where('motpp.accion', 'A')
            ->select(
                'op.id as op_id', 'op.descripcion as op_descripcion',
                'oins.id as oins_id', 'oins.codigo as oins_codigo', 'oins.descripcion as oins_descripcion',
                'ae.id as ae_id', 'ae.codigo_areas_estrategicas as ae_codigo', 'ae.descripcion as ae_descripcion'
            )
            ->get();

        return [
            'operaciones' => $data->map(fn($item) => [
                'id'          => $item->op_id,
                'descripcion' => $item->op_descripcion,
            ])->unique('id')->values(),

            'objetivos'   => $data->map(fn($item) => [
                'id'          => $item->oins_id,
                'codigo'      => $item->oins_codigo,
                'descripcion' => $item->oins_descripcion,
            ])->unique('id')->values(),

            'areas'       => $data->map(fn($item) => [
                'id'          => $item->ae_id,
                'codigo'      => $item->ae_codigo,
                'descripcion' => $item->ae_descripcion,
            ])->unique('id')->values(),
        ];
    }
}

// vista base_upea para personal administrativo
/**
SELECT base_upea.vista_personal_administrativo_2020.*,
bd_poa.buscarUnidad(unidad_trabajo, 'UNIDAD DE TECNOLOGIAS DE INFORMACION Y COMUNICACIONES (UTIC)') AS dist
FROM base_upea.vista_personal_administrativo_2020
ORDER BY dist ASC, base_upea.vista_personal_administrativo_2020.fecha_inicio_asignacion_administrativo DESC
LIMIT 1;
 */
