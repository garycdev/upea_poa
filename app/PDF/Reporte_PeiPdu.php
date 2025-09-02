<?php

namespace App\PDF;

use FPDF;
class Reporte_PeiPdu extends FPDF
{
    // Encabezado
    public function Header()
    {
        // Logo izquierdo
        $this->Image('../public/logos/upea_logo.png', 8, 8, 30);

        // Logo derecho
        $this->Image('../public/logos/logo_sistemas.png', 180, 8, 30);

        // Logo en el centro
        $this->Image('../public/logos/encabezado.jpg', 45,5,120);

        // Salto de línea
        $this->Ln(12);
    }

    // Pie de página
    public function Footer()
    {
        // Personaliza el pie de página según tus necesidades
        /* $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C'); */

        $this->SetY(-15);

        $dates = date('d/m/Y');
        $this->ln(6);
        $this->SetFont('Arial', '', 5);
        $this->SetX(15);
        $this->Cell(70, 6, utf8_decode('TELF.: (591-2) 2201120 . FAX: (591-2) 2201120 . www.upea.bo'), 'T', 0, 'C');
        $this->SetFont('Arial', '', 7);
        $this->Cell(45, 6, utf8_decode('EL ALTO - BOLIVIA'), 'T', 0, 'C');
        $this->SetFont('Arial', '', 5);
        $this->Cell(75, 6, utf8_decode('UNIDAD DE PLANIFICACIÓN . UNIVERSIDAD PUBLICA DE EL ALTO'), 'T', 0, 'C');
        $this->ln(7);
        $this->Cell(0, null, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->ln();
        $this->cell(0, null, utf8_decode('Fecha de Impresión: ') . date('d/m/Y'), 0, 0, 'R');
    }


    //Celda con escala horizontal si el texto es demasiado ancho
    function CellFit($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true){
        //Obtener ancho de cadena
        $str_width = $this->GetStringWidth($txt);

        //Calcular la relación para ajustar la celda
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $ratio = ($w - $this->cMargin * 2) / $str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit) {
            if ($scale) {
                //Calcular escala horizontal
                $horiz_scale = $ratio * 100.0;
                //Establecer escala horizontal
                $this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));
            } else {
                //Calcular el espacio entre caracteres en puntos
                $char_space = ($w - $this->cMargin * 2 - $str_width) / max(strlen($txt) - 1, 1) * $this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET', $char_space));
            }
            //Anular la alineación del usuario (ya que el texto llenará la celda)
            $align = '';
        }

        //Pasar al método de celda
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);

        //Restablecer espaciado entre caracteres/escala horizontal
        if ($fit)
            $this->_out('BT ' . ($scale ? '100 Tz' : '0 Tc') . ' ET');
    }

    //Celda con escala horizontal solo si es necesario
    function CellFitScale($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = ''){
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, true, false);
    }

    var $ancho;
    var $alinea;

    function SetAncho($w){//Establecer la matriz de anchos de columna
        $this->ancho=$w;
    }

    function SetAlinea($a)
    {//Establecer la matriz de alineaciones de columnas
        $this->alinea=$a;
    }

    function Row($data){
          //Calcular la altura de la fila.
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->ancho[$i],$data[$i]));
        $h=5*$nb;
        //Emita un salto de página primero si es necesario
        $this->CheckPageBreak($h);
        //Dibuja las celdas de la fila.
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->ancho[$i];
            $a=isset($this->alinea[$i]) ? $this->alinea[$i] : 'L';
            //Guardar la posición actual
            $x=$this->GetX();
            $y=$this->GetY();
            //dibujar el borde
            $this->Rect($x,$y,$w,$h);
            //Imprime el texto
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Poner la posición a la derecha de la celda.
            $this->SetXY($x+$w,$y);
        }
        //Ir a la siguiente línea
        $this->Ln($h);
    }

    function CheckPageBreak($h){
        //Si la altura h causaría un desbordamiento, agregue una nueva página inmediatamente
        if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt){
        //Calcula el número de líneas que tomará una MultiCell de ancho w
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    public function cellWithDescription($width, $height, $text, $border = 0, $ln = 0, $align = '', $fill = false)
    {
        $lines = $this->MultiCell($width, $height, $text, $border, $align, $fill);
        if ($ln === 1) {
            $this->Ln();
        }
    }
}
