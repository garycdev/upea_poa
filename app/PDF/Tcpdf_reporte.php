<?php
namespace App\PDF;
use Elibyy\TCPDF\Facades\TCPDF;

class Tcpdf_reporte extends TCPDF{
    // Encabezado
    public function Header() {
        // Contenido del encabezado
        $this::SetFont('helvetica', 'B', 12);
        $this::Cell(0, 10, 'Encabezado del PDF', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Pie de página
    public function Footer() {
        // Contenido del pie de página
        $this::SetY(-15);
        $this::SetFont('helvetica', 'I', 8);
        $this::Cell(0, 10, 'Página ' . $this::getAliasNumPage() . ' de ' . $this::getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
