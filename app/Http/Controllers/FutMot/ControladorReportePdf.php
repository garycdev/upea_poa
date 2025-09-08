<?php
namespace App\Http\Controllers\FutMot;

use App\Http\Controllers\Controller;
use App\Models\FutMot\Fut;
use App\Models\FutMot\FutMov;
use App\Models\FutMot\FutPP;
use App\Models\FutMot\Mot;
use App\Models\FutMot\MotMov;
use App\Models\FutMot\MotPP;
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
        $pdf->Cell(20, 10, utf8_decode($mot->nro), 1, 0, 'C', false);

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

        $pdf = new Fpdf();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(false);

        $pdf->AddPage();

        // Titullo
        $pdf->setXY(36, 5);
        $pdf->SetFont('Arial', 'BU', 10);
        $pdf->MultiCell(100, 5, utf8_decode('FORMULARIO DE INICIO DE TRAMITE CONTRATACIÓN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS'), 0, 'C', false);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->setXY(160, 6);
        $pdf->Cell(20, 5, utf8_decode('MOT N°:'), 0, 0, 'L', false);
        $pdf->setXY(180, 4);
        $pdf->Cell(20, 10, $fut->nro, 1, 0, 'C', false);

        // Color rojito para Cell
        $pdf->SetFillColor(217, 149, 148);

        $usuario = User::where('id', '=', $fut->id_usuario)->first();

        // F-1
        $pdf->setY(20);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(5);
        $pdf->Cell(50, 5, utf8_decode('Unidad Solicitante            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(40);
        $pdf->Cell(87, 5, utf8_decode('Lic. ' . $usuario->nombre . ' ' . $usuario->apellido), 1, 0, 'L', false);
        $pdf->setXY(40, 26);
        $pdf->Cell(87, 5, utf8_decode('Area Carrera: ' . $usuario->unidad_carrera->nombre_completo), 1, 0, 'L', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(3, 33, 207, 33);
        $pdf->Ln();

        // F-1
        $pdf->setY(35);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Area estrategica (F-1)            :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode($fut->area_estrategica), 1, 0, 'C', false);
        $pdf->setX(83);
        $pdf->Cell(87, 5, utf8_decode(strtoupper($fut->ae->descripcion)), 1, 0, 'L', false);
        $pdf->setX(172);

        $og = DB::table('rl_politica_de_desarrollo')
            ->where('id_area_estrategica', '=', $fut->area_estrategica)
            ->where('id_tipo_plan', '=', 1)
            ->first();
        // F-2
        $pdf->setY(42);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Objetivo de Gestion (F-2)      :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $og = DB::table('rl_objetivo_institucional as og')
            ->where('og.id', '=', $fut->objetivo_gestion)
            ->first();
        $pdf->Cell(10, 5, utf8_decode($fut->area_estrategica . '.' . $og->codigo), 1, 0, 'C', false);
        $pdf->setX(83);
        $pdf->MultiCell(87, 3, utf8_decode($og->descripcion), 1, 'L', false);
        $pdf->setX(172);

        $tp = DB::table('rl_operaciones')
            ->where('id', '=', $fut->tarea_proyecto)
            ->first();
        // F-3
        $pdf->setY(49);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(15);
        $pdf->Cell(50, 5, utf8_decode('Tarea o Proyecto (F-3; F-3A) :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(59);
        $pdf->Cell(10, 5, utf8_decode('CÓDIGO'), 0, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode($fut->area_estrategica . '.' . $og->codigo . '.' . $tp->tipo_operacion_id), 1, 0, 'C', false);
        $pdf->setX(83);
        $pdf->MultiCell(87, 3, utf8_decode($tp->descripcion), 1, 'L', false);
        $pdf->setX(172);

        // F-2
        $pdf->setY(56);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX(15);
        $pdf->Cell(20, 5, utf8_decode('Monto Programado POA Bs. :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(50);
        $pdf->Cell(20, 5, utf8_decode($fut->importe), 1, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(100, 5, utf8_decode(strtoupper('(SON ' . $this->numeroATexto($fut->importe) . ' BOLIVIANOS 00/100)')), 1, 0, 'L', false);
        $pdf->setXY(15, 59);
        $pdf->Cell(20, 5, utf8_decode('(disponible a la fecha de limite)'), 0, 0, 'L', false);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(3, 65, 207, 65);
        $pdf->Ln();

        $ancho = 10;

        $altura = 67;
        $pdf->setY($altura);
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setX($ancho);
        $pdf->Cell(50, 3, utf8_decode('Fuente de Financiamiento      :'), 0, 0, 'L', false);
        // $pdf->setX(57);
        // $pdf->Cell(6, 3, utf8_decode('0'), 1, 0, 'C', false);
        // $pdf->setX(63);
        // $pdf->Cell(6, 3, utf8_decode('0'), 1, 0, 'C', false);

        $financiamientos = FutPP::where('id_fut', '=', $fut->id_fut)
            ->get();

        $altura = $altura + 5;
        foreach ($financiamientos as $fin) {
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 6);
            $pdf->setX($ancho);
            $pdf->Cell(50, 3, utf8_decode('Organismo Financiador          :'), 0, 0, 'L', false);
            $pdf->setFont('Arial', '', 6);
            $pdf->setX(57);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->of->codigo, 0, 1)), 1, 0, 'C', false);
            $pdf->setX(63);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->of->codigo, 1, 1)), 1, 0, 'C', false);
            $pdf->setX(69);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->of->codigo, 2, 1)), 1, 0, 'C', false);
            $pdf->setX(83);
            $pdf->Cell(60, 3, utf8_decode($fin->of->descripcion), 1, 0, 'C', false);

            // Fuentes de financiamiento
            $altura = $altura + 5;
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 6);
            $pdf->setX($ancho);
            $pdf->Cell(50, 3, utf8_decode('Categoría Progmática             :'), 0, 0, 'L', false);
            $pdf->setX(57);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 0, 1) ? substr($fin->categoria_progmatica, 0, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(63);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 1, 1) ? substr($fin->categoria_progmatica, 1, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(76);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 3, 1) ? substr($fin->categoria_progmatica, 3, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(82);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 4, 1) ? substr($fin->categoria_progmatica, 4, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(88);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 5, 1) ? substr($fin->categoria_progmatica, 5, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(94);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 6, 1) ? substr($fin->categoria_progmatica, 6, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(106);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 8, 1) ? substr($fin->categoria_progmatica, 8, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(112);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 9, 1) ? substr($fin->categoria_progmatica, 9, 1) : ''), 1, 0, 'C', false);
            $pdf->setX(118);
            $pdf->Cell(6, 3, utf8_decode(substr($fin->categoria_progmatica, 10, 1) ? substr($fin->categoria_progmatica, 10, 1) : ''), 1, 0, 'C', false);

            $altura = $altura + 6;
            $pdf->setY($altura);
            $pdf->setFont('Arial', 'B', 6);
            $pdf->setX($ancho);
            $pdf->MultiCell(35, 3, utf8_decode('Partidas Presupuestarias y Descripción                              :'), 0, 'L', false);
            $altura++;

            $movimientos = FutMov::where('id_fut_pp', '=', $fin->id_fut_pp)->get();
            $total       = 0;
            // Lista

            $pdf->setFont('Arial', '', 6);
            foreach ($movimientos as $mov) {
                $pdf->setY($altura);
                $pdf->setX(57);
                $pdf->Cell(25, 3, utf8_decode($mov->partida_codigo), 1, 0, 'C', false);
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
                        break;
                    case '4':
                        $partida = DB::table('rl_clasificador_cuarto')->where('codigo', '=', $mov->partida_codigo)->first();
                        break;
                    case '5':
                        $partida = DB::table('rl_clasificador_quinto')->where('codigo', '=', $mov->partida_codigo)->first();
                        break;
                }
                $pdf->Cell(65, 3, utf8_decode($partida->titulo), 1, 0, 'L', false);
                $pdf->setX(152);
                $pdf->Cell(20, 3, utf8_decode($mov->partida_monto), 1, 0, 'C', false);
                $altura = $altura + 5;

                $total = $total + $mov->partida_monto;
            }

            // Total 2 2
            $pdf->setXY(87, $altura);
            $pdf->Cell(65, 3, utf8_decode('TOTAL'), 1, 0, 'R', true);
            $pdf->setX(152);
            $pdf->Cell(20, 3, utf8_decode($total), 1, 0, 'C', true);
            $altura = $altura + 5;

            $altura = $altura + 2;
        }

        $pdf->setFont('Arial', 'B', 6);
        // Respaldo tramite
        $pdf->setXY(5, 220);
        $pdf->Cell(30, 5, utf8_decode('Respaldo de Tramite             :'), 0, 0, 'L', false);
        $pdf->setFont('Arial', '', 6);
        $pdf->setX(40);
        $pdf->Cell(120, 5, utf8_decode($fut->respaldo_tramite), 1, 0, 'L', false);

        // Fecha
        $pdf->setFont('Arial', 'B', 6);
        $pdf->setXY(5, 228);
        $pdf->Cell(30, 5, utf8_decode('Fecha de Inicio de Tramite    :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(20, 5, utf8_decode('Dia'), 1, 0, 'C', false);
        $pdf->setX(60);
        $pdf->Cell(10, 5, utf8_decode('Mes'), 1, 0, 'C', false);
        $pdf->setX(70);
        $pdf->Cell(10, 5, utf8_decode('Año'), 1, 0, 'C', false);

        $pdf->setY(233);
        $pdf->setX(40);
        $pdf->MultiCell(40, 5, utf8_decode($fut->fecha_tramite), 1, 'C', false);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(0, 242, 210, 242);
        $pdf->Ln();

        $gestion = DB::table('fut')
            ->join('rl_configuracion_formulado AS cf', 'cf.id', '=', 'fut.id_configuracion_formulado')
            ->join('rl_gestiones AS rg', 'rg.id', '=', 'cf.gestiones_id')
            ->select('rg.gestion')
            ->first();

        $pdf->setFont('Arial', '', 6);
        // Unidad
        $pdf->setXY(10, 252);
        $pdf->Cell(30, 5, utf8_decode('Unidad de Planificación        :'), 0, 0, 'L', false);
        $pdf->setX(50);
        $pdf->MultiCell(40, 3, utf8_decode('La solicitud realizada, se encuentra programado en su POA ' . $gestion->gestion), 0, 'L', false);

        // Firmas
        $pdf->setFont('Arial', '', 5);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(115, 258, 145, 258);
        $pdf->Ln();
        $pdf->setXY(115, 259);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(115, 261);
        $pdf->MultiCell(30, 3, utf8_decode('Técnico de Planificación'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(160, 258, 190, 258);
        $pdf->Ln();
        $pdf->setXY(160, 259);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(160, 261);
        $pdf->MultiCell(30, 3, utf8_decode('Jefe de Planificación'), 0, 'C', false);

        // Linea separadora
        $pdf->SetLineWidth(0.25);
        $pdf->Line(0, 267, 210, 267);
        $pdf->Ln();

        // Unidad
        $pdf->setFont('Arial', '', 6);
        $pdf->setXY(10, 275);
        $pdf->Cell(30, 5, utf8_decode('Unidad de Presupuestos      :'), 0, 0, 'L', false);
        $pdf->setX(40);
        $pdf->Cell(60, 5, utf8_decode('Se encuentra presupuestado en el SIGEP'), 0, 0, 'C', false);

        $pdf->setXY(40, 280);
        $pdf->Cell(60, 5, utf8_decode('N° de Preventivo: ....................................'), 0, 0, 'C', false);

        // Firmas
        $pdf->setFont('Arial', '', 5);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(115, 280, 145, 280);
        $pdf->Ln();
        $pdf->setXY(115, 281);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(115, 283);
        $pdf->MultiCell(30, 3, utf8_decode('Técnico de Presupuestos'), 0, 'C', false);

        $pdf->SetLineWidth(0.25);
        $pdf->Line(160, 280, 190, 280);
        $pdf->Ln();
        $pdf->setXY(160, 281);
        $pdf->MultiCell(30, 3, utf8_decode('Firma y Sello'), 0, 'C', false);
        $pdf->setXY(160, 283);
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
}
