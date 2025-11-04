<?php

use Hashids\Hashids;

//rodrigo , 50, 1002868503111997

function encriptar($id)
{
    $encriptado = new Hashids('aj62E8W9MP5BG3w40xaAvzVPv1vpTGDBxznLDYb7rvpgQdZkKe', 15);
    $id1        = $encriptado->encodeHex($id);
    return $id1;
}

function desencriptar($id)
{
    $encriptado = new Hashids('aj62E8W9MP5BG3w40xaAvzVPv1vpTGDBxznLDYb7rvpgQdZkKe', 15);
    $id1        = $encriptado->decodeHex($id);
    return $id1;
}

//para 1000000.00
function sin_separador_comas($monto)
{
    $saldo_respuesta = str_replace(",", "", $monto);
    return $saldo_respuesta;
}
//para 100,000.00
function con_separador_comas($monto)
{
    $monto           = (float) $monto;
    $saldo_respuesta = number_format($monto, 2, '.', ',');
    return $saldo_respuesta;
}

//para las limitaciones
function minimo_agregar()
{
    return 1;
}

function maximo_agregar()
{
    return 10;
}

//para mostrar los mensajes
function mensaje_array($tipo, $mensaje)
{
    return [
        'tipo'    => $tipo,
        'mensaje' => $mensaje,
    ];
}

function fecha_literal($Fecha, $Formato)
{
    $dias = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Mièrcoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sàbado',
    ];
    $meses = [
        1  => 'enero',
        2  => 'febrero',
        3  => 'marzo',
        4  => 'abril',
        5  => 'mayo',
        6  => 'junio',
        7  => 'julio',
        8  => 'agosto',
        9  => 'septiembre',
        10 => 'octubre',
        11 => 'noviembre',
        12 => 'diciembre'];
    $aux = date_parse($Fecha);
    switch ($Formato) {
        case 1: // 04/10/23
            return date('d/m/y', strtotime($Fecha));
        case 2: //04/oct/23
            return sprintf('%02d/%s/%02d', $aux['day'], substr($meses[$aux['month']], 0, 3), $aux['year'] % 100);
        case 3: //octubre 4, 2023
            return $meses[$aux['month']] . ' ' . sprintf('%.2d', $aux['day']) . ', ' . $aux['year'];
        case 4: // 4 de octubre de 2023
            return $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
        case 5: //lunes 4 de octubre de 2023
            $numeroDia = date('w', strtotime($Fecha));
            return $dias[$numeroDia] . ' ' . $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'];
        case 6:
            return date('d/m/Y', strtotime($Fecha));
        case 7:
            return $aux['day'] . ' de ' . $meses[$aux['month']] . ' de ' . $aux['year'] . ' ' . date('H:i:s');
        default:
            return date('d/m/Y', strtotime($Fecha));
    }
}

function formatear_con_ceros($numero, $longitud = 4)
{
    return str_pad(intval($numero), $longitud, '0', STR_PAD_LEFT);
}

//PDU =  1
function pdu_t()
{
    return 1;
}
//PEI
function pei_t()
{
    return 2;
}

//tipo carrera
function carrera()
{
    return 1;
}
//tipo unidades administrativas
function unidades_adm()
{
    return 2;
}
//tipo area
function areas()
{
    return 3;
}
