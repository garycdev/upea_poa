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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ControladorReportePdf extends Controller
{
    public function generarPdfMot(Request $req, $id_mot)
    {
        $id_mot = Crypt::decryptString($id_mot);
        $mot    = Mot::where('id_mot', '=', $id_mot)->first();

        $pdf = new FPDF();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);

        $pdf->AddPage();

        // Titullo
        $pdf->setXY(36, 5);
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->MultiCell(120, 5, 'FORMULARIO DE MODIFICACIÓN POA - PRESUPUESTO DE OBJETIVOS Y/O TAREAS (ACTIVIDADES-OPERACIONES) - M.O.T.', 0, 'C', false);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->setXY(160, 6);
        $pdf->Cell(20, 5, utf8_decode('MOT N°:'), 0, 0, 'L', false);
        $pdf->setXY(180, 4);
        $pdf->Cell(20, 10, utf8_decode(formatear_con_ceros($mot->nro)), 1, 0, 'C', false);

        // Color rojito para Cell
        $pdf->SetFillColor(217, 149, 148);

        // F-1
        $pdf->setY(20);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Area Estratégica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(37);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        // $pdf->SetFillColor(0, 0, 0);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode($mot->area_estrategica_de), 1, 0, 'C', false);
        $pdf->setX(83);
        $pdf->Cell(87, 5, utf8_decode(strtoupper($mot->ae_de->descripcion)), 1, 0, 'L', false);
        $pdf->setX(172);
        $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
        $pdf->setX(184);
        $pdf->Cell(20, 5, utf8_decode($mot->ae_de_importe . ' bs'), 1, 0, 'C', false);
        $pdf->setX(77);

        // F-1
        $pdf->setY(28);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Area Estratégica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(37);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode($mot->area_estrategica_a), 1, 0, 'C', false);
        $pdf->setX(83);
        $pdf->Cell(87, 5, utf8_decode(strtoupper($mot->ae_a->descripcion)), 1, 0, 'L', false);
        $pdf->setX(172);
        $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
        $pdf->setX(184);
        $pdf->Cell(20, 5, utf8_decode($mot->ae_a_importe . ' bs'), 1, 0, 'C', false);
        $pdf->setX(77);

        // F-2
        $pdf->setY(36);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestión (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(37);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $og_de = DB::table('rl_objetivo_institucional as og')
            ->where('og.id', '=', $mot->objetivo_gestion_de)
            ->first();
        $pdf->Cell(10, 5, utf8_decode($mot->area_estrategica_de . '.' . $og_de->codigo), 1, 0, 'C', false);
        $pdf->setX(83);
        // $og_de = DB::table('rl_politica_de_desarrollo')
        //     ->where('id_area_estrategica', '=', $mot->area_estrategica_de)
        //     ->where('id_tipo_plan', '=', 1)
        //     ->where('CÓDIGO', '=', $mot->objetivo_gestion_de)
        //     ->first();
        $pdf->setFont('Arial', '', 5);
        $pdf->MultiCell(87, 3, utf8_decode($og_de->descripcion), 1, 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setXY(172, 36);
        $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
        $pdf->setX(184);
        $pdf->Cell(20, 5, utf8_decode($mot->og_de_importe . ' bs'), 1, 0, 'C', false);
        $pdf->setX(77);

        // F-2
        $pdf->setY(44);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestión (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(37);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $og_a = DB::table('rl_objetivo_institucional as og')
            ->where('og.id', '=', $mot->objetivo_gestion_a)
            ->first();
        $pdf->Cell(10, 5, utf8_decode($mot->area_estrategica_a . '.' . $og_a->codigo), 1, 0, 'C', false);
        $pdf->setX(83);
        // $og_a = DB::table('rl_politica_de_desarrollo')
        //     ->where('id_area_estrategica', '=', $mot->area_estrategica_a)
        //     ->where('id_tipo_plan', '=', 1)
        //     ->where('CÓDIGO', '=', $mot->objetivo_gestion_a)
        //     ->first();
        $pdf->setFont('Arial', '', 5);
        $pdf->MultiCell(87, 3, utf8_decode($og_a->descripcion), 1, 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setXY(172, 44);
        $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
        $pdf->setX(184);
        $pdf->Cell(20, 5, utf8_decode($mot->og_a_importe . ' bs'), 1, 0, 'C', false);
        $pdf->setX(77);

        // F-3 F-3A
        $pdf->setY(52);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(37);
        $pdf->Cell(20, 5, utf8_decode('MODIFICA'), 0, 0, 'C', true);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $tp_de = DB::table('rl_operaciones')
            ->where('id', '=', $mot->tarea_proyecto_de)
            ->first();
        $pdf->Cell(10, 5, utf8_decode($mot->area_estrategica_de . '.' . $og_de->codigo . '.' . $tp_de->tipo_operacion_id), 1, 0, 'C', false);
        $pdf->setX(83);
        $pdf->setFont('Arial', '', 5);
        $pdf->multiCell(87, 3, utf8_decode($tp_de->descripcion), 1, 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setXY(172, 52);
        $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
        $pdf->setX(184);
        $pdf->Cell(20, 5, utf8_decode($mot->tp_de_importe . ' bs'), 1, 0, 'C', false);
        $pdf->setX(77);

        // F-3 F-3A
        $pdf->setY(60);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(37);
        $pdf->Cell(20, 5, utf8_decode('INCREMENTA'), 0, 0, 'C', true);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $tp_a = DB::table('rl_operaciones')
            ->where('id', '=', $mot->tarea_proyecto_a)
            ->first();
        $pdf->Cell(10, 5, utf8_decode($mot->area_estrategica_a . '.' . $og_a->codigo . '.' . $tp_a->tipo_operacion_id), 1, 0, 'C', false);
        $pdf->setX(83);
        $pdf->setFont('Arial', '', 5);
        $pdf->MultiCell(87, 3, utf8_decode($tp_a->descripcion), 1, 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setXY(172, 60);
        $pdf->Cell(10, 5, utf8_decode('IMPORTE:'), 0, 0, 'C', false);
        $pdf->setX(184);
        $pdf->Cell(20, 5, utf8_decode($mot->tp_a_importe . ' bs'), 1, 0, 'C', false);
        $pdf->setX(77);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(3, 68, 207, 68);
        $pdf->Ln();

        $ancho           = 10;
        $altura          = 72;
        $financiamientos = MotPP::where('id_mot', '=', $mot->id_mot)->get();
        //Organismos financiadores
        foreach ($financiamientos as $fin) {
            if ($fin->accion == 'DE') {
                // Fuentes de financiamiento
                $pdf->setY($altura);
                $pdf->setFont('Arial', 'B', 6);
                $pdf->setX(10);
                $pdf->Cell(50, 3, utf8_decode('Fuente de Financiamiento :'), 0, 0, 'L', false);
                $pdf->setX(62);
                $pdf->Cell(8, 3, utf8_decode('1'), 1, 0, 'C', false);
                $pdf->setX(70);
                $pdf->Cell(5, 3, utf8_decode('1'), 1, 0, 'C', false);
                $altura = $altura + 5;

                $pdf->setY($altura);
                $pdf->setFont('Arial', 'B', 6);
                $pdf->setX(10);
                $pdf->Cell(50, 3, utf8_decode('Organismo Financiador   :'), 0, 0, 'L', false);
                $pdf->setFont('Arial', '', 6);
                $pdf->setX(62);
                $pdf->Cell(8, 3, utf8_decode(substr($fin->of->codigo, 0, 1)), 1, 0, 'C', false);
                $pdf->setX(70);
                $pdf->Cell(5, 3, utf8_decode(substr($fin->of->codigo, 1, 1)), 1, 0, 'C', false);
                $pdf->setX(75);
                $pdf->Cell(7, 3, utf8_decode(substr($fin->of->codigo, 2, 1)), 1, 0, 'C', false);
                $pdf->setX(88);
                $pdf->Cell(60, 3, utf8_decode($fin->of->descripcion), 1, 0, 'C', false);
                $altura = $altura + 3;
            } else {
                $altura = $altura - 2;
            }
            $pdf->setXY(45, $altura);
            $pdf->Cell(10, 3, utf8_decode($fin->accion), 0, 0, 'C', false);

            $altura = $altura + 4;
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 6);
            $pdf->setX($ancho);
            $pdf->MultiCell(35, 3, utf8_decode('Partidas Presupuestarias y Descripción                              :'), 0, 'L', false);

            $movimientos = MotMov::where('id_mot_pp', '=', $fin->id_mot_pp)->get();
            $total       = 0;
            foreach ($movimientos as $mov) {
                $altura++;
                // Lista
                $pdf->setY($altura);
                $pdf->setFont('Arial', '', 6);
                $pdf->setX(62);
                $pdf->Cell(25, 3, utf8_decode($mov->partida_codigo), 1, 0, 'C', false);
                $pdf->setX(92);
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
                        break;
                    case '4':
                        $partida = DB::table('rl_clasificador_cuarto')->where('codigo', '=', $mov->partida_codigo)->first();
                        break;
                    case '5':
                        $partida = DB::table('rl_clasificador_quinto')->where('codigo', '=', $mov->partida_codigo)->first();
                        break;
                }
                $pdf->Cell(65, 3, utf8_decode($partida->titulo), 1, 0, 'L', false);
                $pdf->setX(157);
                $pdf->Cell(20, 3, utf8_decode($mov->partida_monto . ' bs'), 1, 0, 'C', false);
                $altura = $altura + 5;
                $total  = $total + $mov->partida_monto;
            }
            // Total 1 1
            $altura = $altura - 2;
            $pdf->setXY(92, $altura);
            $pdf->Cell(65, 3, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(157);
            $pdf->Cell(20, 3, utf8_decode($total . ' bs'), 1, 0, 'C', true);
            $altura = $altura + 5;

            if ($fin->accion == 'A') {
                $altura = $altura + 3;
            }
        }

        // Respaldo tramite
        $pdf->setXY(5, 240);
        $pdf->Cell(30, 5, utf8_decode('Respaldo de Tramite             :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(120, 5, utf8_decode($mot->respaldo_tramite), 1, 0, 'L', false);

        // Fecha
        $pdf->setXY(5, 245);
        $pdf->Cell(30, 5, utf8_decode('Fecha de Inicio de Tramite    :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(20, 5, utf8_decode('Dia'), 1, 0, 'C', false);
        $pdf->setX(60);
        $pdf->Cell(10, 5, utf8_decode('Mes'), 1, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode('Año'), 1, 0, 'C', false);

        $pdf->setY(250);
        $pdf->setX(40);
        $pdf->MultiCell(40, 8, utf8_decode($mot->fecha_tramite), 1, 'C', false);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(3, 265, 110, 265);
        $pdf->Ln();

        $usuario = User::where('id', '=', $mot->id_usuario)->first();

        // Unidad
        $pdf->setXY(5, 270);
        $pdf->Cell(30, 5, utf8_decode('Unidad solicitante                  :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(60, 5, utf8_decode('Lic. ' . $usuario->nombre . ' ' . $usuario->apellido), 1, 0, 'C', false);

        $pdf->setFont('Arial', '', 5);
        $pdf->setXY(40, 275);
        $pdf->Cell(60, 5, utf8_decode($usuario->unidad_carrera->nombre_completo), 1, 0, 'C', false);

        // Firmas
        $pdf->SetLineWidth(0.25);
        $pdf->Line(125, 260, 155, 260);
        $pdf->Ln();
        $pdf->setXY(125, 261);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(125, 263);
        $pdf->MultiCell(30, 3, utf8_decode('Técnico de Planificación'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(165, 260, 195, 260);
        $pdf->Ln();
        $pdf->setXY(165, 261);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(165, 263);
        $pdf->MultiCell(30, 3, utf8_decode('Jefe de Planificación'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(145, 280, 175, 280);
        $pdf->Ln();
        $pdf->setXY(145, 281);
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
            $pdf->Cell(100, 5, utf8_decode(strtoupper($area->descripcion)), 1, 0, 'L', false);
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
            $pdf->Cell(100, 5, utf8_decode($oins->descripcion), 1, 'L', false);
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

                $pdf->Cell(70, 5, utf8_decode($movimientosGrupo[$key]['titulo']), 1, 0, 'L', false);
                $pdf->setX(157);
                $pdf->Cell(25, 5, utf8_decode(con_separador_comas($movimientosGrupo[$key]['monto']) . ' bs'), 1, 0, 'C', false);
                $altura = $altura + 5;

                $total = $total + $movimientosGrupo[$key]['monto'];
            }

            // Total 2 2
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setXY(62, $altura);
            $pdf->Cell(95, 5, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(157);
            $pdf->Cell(25, 5, utf8_decode(con_separador_comas($total) . ' bs'), 1, 0, 'C', true);
            $altura = $altura + 5;
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

    public function formulacionPdfFut(Request $req, $id_fut)
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
            $pdf->Cell(100, 5, utf8_decode(strtoupper($area->descripcion)), 1, 0, 'L', false);
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
            $pdf->Cell(100, 5, utf8_decode($oins->descripcion), 1, 'L', false);
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
                $pdf->Cell(70, 5, utf8_decode($detalle->titulo), 1, 0, 'L', false);
                $pdf->setX(157);
                $pdf->Cell(25, 5, utf8_decode(con_separador_comas($mov->partida_monto) . ' bs'), 1, 0, 'C', false);
                $altura = $altura + 5;

                $total = $total + $mov->partida_monto;
            }

            // Total 2 2
            $pdf->setFont('Arial', 'B', 8);
            $pdf->setXY(62, $altura);
            $pdf->Cell(95, 5, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(157);
            $pdf->Cell(25, 5, utf8_decode(con_separador_comas($total) . ' bs'), 1, 0, 'C', true);
            $altura = $altura + 5;
        }

        // Fecha
        $pdf->setFont('Arial', 'B', 8);
        $pdf->setXY(30, -20);
        $pdf->Cell(30, 5, utf8_decode('Fecha de Tramite    :'), 0, 0, 'L', false);
        $pdf->setX(70);
        $pdf->Cell(15, 5, utf8_decode('Dia'), 1, 0, 'C', false);
        $pdf->setX(85);
        $pdf->Cell(15, 5, utf8_decode('Mes'), 1, 0, 'C', false);
        $pdf->setX(100);
        $pdf->Cell(15, 5, utf8_decode('Año'), 1, 0, 'C', false);

        $pdf->setY(-15);
        $pdf->setX(70);
        $pdf->MultiCell(45, 5, utf8_decode($fut->created_at), 1, 'C', false);

        // $pdf->Output();

        // Descargar pdf directamente
        $nombreArchivo = 'FUT-N' . $fut->nro . '_' . date('Y-m-d_H-i-s') . '.pdf';
        $pdf->Output('I', $nombreArchivo);
        exit;
    }

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

    public function index()
    {
        $unidades  = Tipo_CarreraUnidad::get();
        $gestiones = Gestiones::where('estado', '=', 'activo')
            ->orderBy('id', 'DESC')
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
}
