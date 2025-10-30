<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $tipo == 'fut' ? 'Gastos' : ($tipo == 'mot' ? 'Modificaciones' : 'Gastos y modificaciones') }} | Fecha
    </title>
    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .my-table {
            border-collapse: collapse;
            width: 100%;
            page-break-inside: avoid;
        }

        .my-table th,
        .my-table td {
            border: 1px solid black;
            padding: 5px;
        }

        .my-table th {
            background-color: #f2f2f2;
        }

        tr {
            page-break-inside: avoid;
        }

        thead {
            display: table-row-group;
        }

        #thead tr {
            position: sticky;
            top: 0;
            background-color: #fff;
            /* Agrega un fondo blanco para evitar que se mezcle con el contenido */
        }

        .table-container {
            position: relative;
            page: auto;
        }

        .table-container:not(:first-child) {
            page-break-before: always;
        }

        .thead-container {
            position: absolute;
            top: 0;
            left: 0;
        }

        .corner-image {
            position: absolute;
            top: 10px;
            /* Ajusta la posición vertical */
            left: 10px;
            /* Ajusta la posición horizontal */
        }

        p {
            font-size: 12px;
        }

        .texto {
            font-size: 13px;
            margin-left: 50px;
        }

        /*para */
        .img-esquina {
            position: absolute;
            width: 90px;
        }

        .img-esquina-top-left {
            top: 0;
            left: 0;
        }

        .img-esquina-top-right {
            top: -20;
            right: -25px;
        }

        .formulario_esquina {
            position: absolute;
        }

        .form-esquina-top-rigth {
            top: -47;
            right: -25px;
        }

        .form-esquina-top-left {
            top: -60px;
            left: -30px;
        }



        /**/
        .img_fondo {
            position: absolute;
            opacity: 0.8;
            top: 2%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            width: 80%;
        }

        .seccion {
            position: relative;
        }

        .text-primary {
            padding-top: 0px;
            margin: 2px;
        }

        /* .text-secundario {
            padding-top: 0px;
            margin-top: -2px;
        } */

        .item-centro {
            border: none !important;
            background: transparent !important;
            width: 5px;
        }
    </style>
</head>

<body>
    @php
        $img_upea = public_path('logos/logo_upea.jpg');
        $imagen_upea = 'data:image/png;base64,' . base64_encode(file_get_contents($img_upea));

        $img_encabezado = public_path('logos/encabezado.jpg');
        $imagen_encabezado = 'data:image/png;base64,' . base64_encode(file_get_contents($img_encabezado));
    @endphp

    <div class="seccion">
        <img src="{{ $imagen_encabezado }}" class="img_fondo">
    </div>
    <div style="text-align: center; padding-top:10% ">
        <h4 class="text-primary">
            Reporte de gastos por fecha
        </h4>
        <h4 class="text-primary">PLAN OPERATIVO ANUAL</h4>
        <h4 class="text-primary">FECHA: {{ $datos['rango'] }}</h4>
        <div class=" ms-auto position-relative">
        </div>
    </div>

    <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-right">

    <h5 class="formulario_esquina form-esquina-top-left">IMP {{ fecha_literal(date('Y-m-d'), 4) }}</h5>
    <h5 class="formulario_esquina form-esquina-top-rigth">
        Reporte fecha {{ $datos['rango'] }}
    </h5>
    <p class="texto">
        <b>UNIDAD AREA CARRERA :</b>
        @if ($unidad_carrera)
            {{ $unidad_carrera->nombre_completo }}
        @else
            TODAS
        @endif
    </p>
    <p class="texto">
        <b>FUENTE DE FINANCIAMIENTO :</b>
        @if ($financiamiento)
            {{ $financiamiento->descripcion }}
        @else
            TODAS
        @endif
    </p>

    @if ($tipo == 'fut' || $tipo == '')
        <center><b>RESUMEN GENERAL DE GASTOS (FUT)</b></center>
        <br>
        <div class="table-responsive">
            <table class="my-table" style="width: 100%;margin:auto; font-size:10px;">
                <thead>
                    <tr>
                        <th colspan="8">{{ $datos['por_fecha_fut']['fecha'] }}</th>
                    </tr>
                    <tr>
                        <th colspan="2">Compra ejecutada</th>
                        <th colspan="2">Compra pendiente</th>
                        <th colspan="2">Saldo</th>
                        <th colspan="2">Monto total</th>
                    </tr>
                </thead>
                @php
                    $aprobado = $datos['por_fecha_fut']['total_aprobado_sum'];
                    $verificado = $datos['por_fecha_fut']['total_verificado_sum'];
                    $pendiente = $datos['por_fecha_fut']['total_pendiente_sum'];
                    $total = $datos['por_fecha_fut']['total_monto_sum'];

                    $ptotal1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                    $ptotal2 = $total != 0 ? ($verificado * 100) / $total : 0;
                    $ptotal3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                @endphp
                <tbody>
                    <tr>
                        <td>{{ con_separador_comas($aprobado) }} bs</td>
                        <td>{{ round($ptotal1, 2) }}%</td>
                        <td>{{ con_separador_comas($verificado) }} bs</td>
                        <td>{{ round($ptotal2, 2) }}%</td>
                        <td>{{ con_separador_comas($pendiente) }} bs</td>
                        <td>{{ round($ptotal3, 2) }}%</td>
                        <td><b>{{ con_separador_comas($total) }} bs</b></td>
                        <td><b>{{ round($ptotal1 + $ptotal2 + $ptotal3, 0) }}%</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($graficos)
            <br>
            <center>
                <img src="{{ $chartFechaFut }}" style="width:75%;margin:auto;">
            </center>
        @endif
        <br>
        <center><b>GASTOS POR FUENTE DE FINANCIAMIENTO</b></center>
        <br>
        <div style="width:100%;">
            <table class="my-table" style="font-size:8px;">
                <thead>
                    <tr>
                        <th colspan="9">{{ $datos['por_fecha_fut']['fecha'] }}</th>
                    </tr>
                    <tr>
                        <th>Fuentes de financiamiento</th>
                        <th colspan="2">Compra ejecutada</th>
                        <th colspan="2">Compra pendiente</th>
                        <th colspan="2">Saldo</th>
                        <th colspan="2">Monto total</th>
                    </tr>
                </thead>
                @php
                    $total1 = 0;
                    $total2 = 0;
                    $total3 = 0;
                    $total4 = 0;

                    $total_total = 0;

                    foreach ($datos['por_fecha_financiamiento_fut'] as $value) {
                        $total_total += $value['total_monto_sum'];
                    }
                @endphp
                <tbody>
                    @foreach ($datos['por_fecha_financiamiento_fut'] as $item)
                        @php
                            $aprobado = $item['total_aprobado_sum'];
                            $verificado = $item['total_verificado_sum'];
                            $pendiente = $item['total_pendiente_sum'];
                            $total = $item['total_monto_sum'];

                            $total1 += $aprobado;
                            $total2 += $verificado;
                            $total3 += $pendiente;
                            $total4 += $total;

                            $pt1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                            $pt2 = $total != 0 ? ($verificado * 100) / $total : 0;
                            $pt3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                            $pt4 = $total_total != 0 ? ($total * 100) / $total_total : 0;
                        @endphp
                        <tr>
                            <td>{{ $item['descripcion'] }}</td>
                            <td>{{ $aprobado != 0 ? con_separador_comas($aprobado) . ' bs' : '-' }}</td>
                            <td>{{ $pt1 != 0 ? round($pt1, 2) . '%' : '-' }}</td>
                            <td>{{ $verificado != 0 ? con_separador_comas($verificado) . ' bs' : '-' }}</td>
                            <td>{{ $pt2 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                            <td>{{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}</td>
                            <td>{{ $pt3 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                            <td><b>{{ con_separador_comas($total) }} bs</b></td>
                            <td><b>{{ round($pt4, 2) }}%</b></td>
                        </tr>
                    @endforeach
                    @php
                        $ptotal1 = $total4 != 0 ? ($total1 * 100) / $total4 : 0;
                        $ptotal2 = $total4 != 0 ? ($total2 * 100) / $total4 : 0;
                        $ptotal3 = $total4 != 0 ? ($total3 * 100) / $total4 : 0;
                    @endphp
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{ con_separador_comas($total1) }} bs</b></td>
                        <td><b>{{ round($ptotal1, 2) }}%</b></td>
                        <td><b>{{ con_separador_comas($total2) }} bs</b></td>
                        <td><b>{{ round($ptotal2, 2) }}%</b></td>
                        <td><b>{{ con_separador_comas($total3) }} bs</b></td>
                        <td><b>{{ round($ptotal3, 2) }}%</b></td>
                        <td><b>{{ con_separador_comas($total4) }} bs</b></td>
                        <td><b>{{ round($ptotal1 + $ptotal2 + $ptotal3, 0) }}%</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($graficos)
            <br>
            <center>
                <img src="{{ $chartFinanFut }}" style="width:75%;margin:auto;">
            </center>
        @endif
        <br>
        {{-- @dd($datos['por_fecha_unidad']) --}}
        @if (!isset($unidad_carrera))
            <br>
            <center><b>GASTOS POR UNIDAD/CARRERA</b></center>
            <br>
            <div class="table-responsive">
                <table class="my-table" style="font-size:8px;">
                    <thead>
                        <tr>
                            <th colspan="9">{{ $datos['por_fecha_fut']['fecha'] }}</th>
                        </tr>
                        <tr>
                            <th>Unidad area carrera</th>
                            <th colspan="2">Compra ejecutada</th>
                            <th colspan="2">Compra pendiente</th>
                            <th colspan="2">Saldo</th>
                            <th colspan="2">Monto total</th>
                        </tr>
                    </thead>
                    @php
                        $total1 = 0;
                        $total2 = 0;
                        $total3 = 0;
                        $total4 = 0;

                        $total_total = 0;

                        foreach ($datos['por_fecha_unidad_fut'] as $value) {
                            $total_total += $value['total_monto_sum'];
                        }
                    @endphp
                    <tbody>
                        @foreach ($datos['por_fecha_unidad_fut'] as $item)
                            @php
                                $aprobado = $item['total_aprobado_sum'];
                                $verificado = $item['total_verificado_sum'];
                                $pendiente = $item['total_pendiente_sum'];
                                $total = $item['total_monto_sum'];

                                $total1 += $aprobado;
                                $total2 += $verificado;
                                $total3 += $pendiente;
                                $total4 += $total;

                                $pt1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                                $pt2 = $total != 0 ? ($verificado * 100) / $total : 0;
                                $pt3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                                $pt4 = $total_total != 0 ? ($total * 100) / $total_total : 0;
                            @endphp
                            <tr>
                                <td>{{ $item['unidad'] }}</td>
                                <td>{{ $aprobado != 0 ? con_separador_comas($aprobado) . ' bs' : '-' }}</td>
                                <td>{{ $pt1 != 0 ? round($pt1, 2) . '%' : '-' }}</td>
                                <td>{{ $verificado != 0 ? con_separador_comas($verificado) . ' bs' : '-' }}</td>
                                <td>{{ $pt2 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                                <td>{{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}</td>
                                <td>{{ $pt3 != 0 ? round($pt3, 2) . '%' : '-' }}</td>
                                <td><b>{{ con_separador_comas($total) }} bs</b></td>
                                <td><b>{{ round($pt4, 2) }}%</b></td>
                            </tr>
                        @endforeach
                        @php
                            $ptotal1 = $total4 != 0 ? ($total1 * 100) / $total4 : 0;
                            $ptotal2 = $total4 != 0 ? ($total2 * 100) / $total4 : 0;
                            $ptotal3 = $total4 != 0 ? ($total3 * 100) / $total4 : 0;
                        @endphp
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><b>{{ con_separador_comas($total1) }} bs</b></td>
                            <td><b>{{ round($ptotal1, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total2) }} bs</b></td>
                            <td><b>{{ round($ptotal2, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total3) }} bs</b></td>
                            <td><b>{{ round($ptotal3, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total4) }} bs</b></td>
                            <td><b>{{ round($ptotal1 + $ptotal2 + $ptotal3, 0) }}%</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($graficos)
                <br>
                <center>
                    <img src="{{ $chartUnidadesFut }}"
                        style="{{ count($datos['por_fecha_unidad_fut']) > 1 ? 'width:100%' : 'width:75%' }};margin:auto;">
                </center>
            @endif
        @endif
        @if ($partidas)
            <br>
            <center><b>GASTOS POR PARTIDAS</b></center>
            <br>
            <div class="table-responsive">
                <table class="my-table" style="font-size:8px;">
                    <thead>
                        <tr>
                            <th colspan="9">{{ $datos['por_fecha_fut']['fecha'] }}</th>
                        </tr>
                        <tr>
                            <th>Codigo partidas</th>
                            <th colspan="2">Compra ejecutada</th>
                            <th colspan="2">Compra pendiente</th>
                            <th colspan="2">Saldo</th>
                            <th colspan="2">Monto total</th>
                        </tr>
                    </thead>
                    @php
                        $total1 = 0;
                        $total2 = 0;
                        $total3 = 0;
                        $total4 = 0;

                        $total_total = 0;

                        foreach ($datos['por_fecha_partidas_fut'] as $value) {
                            $total_total += $value['total_monto_sum'];
                        }
                    @endphp
                    <tbody>
                        @foreach ($datos['por_fecha_partidas_fut'] as $item)
                            @php
                                $aprobado = $item['total_aprobado_sum'];
                                $verificado = $item['total_verificado_sum'];
                                $pendiente = $item['total_pendiente_sum'];
                                $total = $item['total_monto_sum'];

                                $total1 += $aprobado;
                                $total2 += $verificado;
                                $total3 += $pendiente;
                                $total4 += $total;

                                $pt1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                                $pt2 = $total != 0 ? ($verificado * 100) / $total : 0;
                                $pt3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                                $pt4 = $total_total != 0 ? ($total * 100) / $total_total : 0;
                            @endphp
                            <tr>
                                <td><b>{{ $item['partida'] }}</b></td>
                                <td>{{ $aprobado != 0 ? con_separador_comas($aprobado) . ' bs' : '-' }}</td>
                                <td>{{ $pt1 != 0 ? round($pt1, 2) . '%' : '-' }}</td>
                                <td>{{ $verificado != 0 ? con_separador_comas($verificado) . ' bs' : '-' }}</td>
                                <td>{{ $pt2 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                                <td>{{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}</td>
                                <td>{{ $pt3 != 0 ? round($pt3, 2) . '%' : '-' }}</td>
                                <td><b>{{ con_separador_comas($total) }} bs</b></td>
                                <td><b>{{ round($pt4, 2) }}%</b></td>
                            </tr>
                        @endforeach
                        @php
                            $ptotal1 = $total4 != 0 ? ($total1 * 100) / $total4 : 0;
                            $ptotal2 = $total4 != 0 ? ($total2 * 100) / $total4 : 0;
                            $ptotal3 = $total4 != 0 ? ($total3 * 100) / $total4 : 0;
                        @endphp
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><b>{{ con_separador_comas($total1) }} bs</b></td>
                            <td><b>{{ round($ptotal1, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total2) }} bs</b></td>
                            <td><b>{{ round($ptotal2, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total3) }} bs</b></td>
                            <td><b>{{ round($ptotal3, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total4) }} bs</b></td>
                            <td><b>{{ round($ptotal1 + $ptotal2 + $ptotal3, 0) }}%</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($graficos)
                <br>
                <center>
                    <img src="{{ $chartPartidasFut }}" style="width:85%;margin:auto;">
                </center>
            @endif
        @endif
    @endif


    @if ($tipo == 'mot' || $tipo == '')
        <br>
        <center><b>RESUMEN GENERAL DE MODIFICACIONES (MOT)</b></center>
        <br>
        <div class="table-responsive">
            <table class="my-table" style="width: 100%;margin:auto; font-size:10px;">
                <thead>
                    <tr>
                        <th colspan="8">{{ $datos['por_fecha_mot']['fecha'] }}</th>
                    </tr>
                    <tr>
                        <th colspan="2">Aprobado</th>
                        <th colspan="2">Verificado</th>
                        <th colspan="2">Elaborado</th>
                        <th colspan="2">Monto total</th>
                    </tr>
                </thead>
                @php
                    $aprobado = $datos['por_fecha_mot']['total_aprobado_sum'];
                    $verificado = $datos['por_fecha_mot']['total_verificado_sum'];
                    $pendiente = $datos['por_fecha_mot']['total_pendiente_sum'];
                    $saldo = $datos['por_fecha_mot']['total_saldo_sum'];
                    $total = $datos['por_fecha_mot']['total_monto_sum'];

                    $ptotal1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                    $ptotal2 = $total != 0 ? ($verificado * 100) / $total : 0;
                    $ptotal3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                    $ptotal4 = $pendiente != 0 ? ($saldo * 100) / $pendiente : 0;
                @endphp
                <tbody>
                    <tr>
                        <td>{{ con_separador_comas($pendiente) }} bs</td>
                        <td>{{ round($ptotal3, 2) }}%</td>
                        <td>{{ con_separador_comas($verificado) }} bs</td>
                        <td>{{ round($ptotal2, 2) }}%</td>
                        <td>{{ con_separador_comas($aprobado) }} bs</td>
                        <td>{{ round($ptotal1, 2) }}%</td>
                        {{-- <td>{{ con_separador_comas($saldo) }} bs</td>
                    <td>{{ round($ptotal4, 2) }}%</td> --}}
                        <td><b>{{ con_separador_comas($total) }} bs</b></td>
                        <td><b>{{ round($ptotal1 + $ptotal2 + $ptotal3, 0) }}%</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($graficos)
            <br>
            <center>
                <img src="{{ $chartFechaMot }}" style="width:75%;margin:auto;">
            </center>
        @endif
        <br>
        <center><b>MODIFICACIONES POR FUENTE DE FINANCIAMIENTO</b></center>
        <br>
        <div style="width:100%;">
            <table class="my-table" style="font-size:8px;">
                <thead>
                    <tr>
                        <th colspan="9">{{ $datos['por_fecha_mot']['fecha'] }}</th>
                    </tr>
                    <tr>
                        <th>Fuentes de financiamiento</th>
                        <th colspan="2">Aprobado</th>
                        <th colspan="2">Verificado</th>
                        <th colspan="2">Elaborado</th>
                        <th colspan="2">Monto total</th>
                    </tr>
                </thead>
                @php
                    $total1 = 0;
                    $total2 = 0;
                    $total3 = 0;
                    $total4 = 0;
                    $total5 = 0;

                    $total_total = 0;

                    foreach ($datos['por_fecha_financiamiento_mot'] as $value) {
                        $total_total += $value['total_monto_sum'];
                    }
                @endphp
                <tbody>
                    @foreach ($datos['por_fecha_financiamiento_mot'] as $item)
                        @php
                            $aprobado = $item['total_aprobado_sum'];
                            $verificado = $item['total_verificado_sum'];
                            $pendiente = $item['total_pendiente_sum'];
                            $saldo = $item['total_saldo_sum'];
                            $total = $item['total_monto_sum'];

                            $total1 += $aprobado;
                            $total2 += $verificado;
                            $total3 += $pendiente;
                            $total4 += $saldo;
                            $total5 += $total;

                            $pt1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                            $pt2 = $total != 0 ? ($verificado * 100) / $total : 0;
                            $pt3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                            $pt4 = $pendiente != 0 ? ($saldo * 100) / $pendiente : 0;
                            $pt5 = $total_total != 0 ? ($total * 100) / $total_total : 0;
                        @endphp
                        <tr>
                            <td>{{ $item['descripcion'] }}</td>
                            <td>{{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}</td>
                            <td>{{ $pt3 != 0 ? round($pt3, 2) . '%' : '-' }}</td>
                            <td>{{ $verificado != 0 ? con_separador_comas($verificado) . ' bs' : '-' }}</td>
                            <td>{{ $pt2 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                            <td>{{ $aprobado != 0 ? con_separador_comas($aprobado) . ' bs' : '-' }}</td>
                            <td>{{ $pt1 != 0 ? round($pt1, 2) . '%' : '-' }}</td>
                            {{-- <td>{{ $saldo != 0 ? con_separador_comas($saldo) . ' bs' : '-' }}</td>
                        <td>{{ $pt4 != 0 ? round($pt4, 2) . '%' : '-' }}</td> --}}
                            <td><b>{{ con_separador_comas($total) }} bs</b></td>
                            <td><b>{{ round($pt5, 2) }}%</b></td>
                        </tr>
                    @endforeach
                    @php
                        $ptotal1 = $total5 != 0 ? ($total1 * 100) / $total5 : 0;
                        $ptotal2 = $total5 != 0 ? ($total2 * 100) / $total5 : 0;
                        $ptotal3 = $total5 != 0 ? ($total3 * 100) / $total5 : 0;
                        $ptotal4 = $total3 != 0 ? ($total4 * 100) / $total3 : 0;
                    @endphp
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td><b>{{ con_separador_comas($total3) }} bs</b></td>
                        <td><b>{{ round($ptotal3, 2) }}%</b></td>
                        <td><b>{{ con_separador_comas($total2) }} bs</b></td>
                        <td><b>{{ round($ptotal2, 2) }}%</b></td>
                        <td><b>{{ con_separador_comas($total1) }} bs</b></td>
                        <td><b>{{ round($ptotal1, 2) }}%</b></td>
                        {{-- <td><b>{{ con_separador_comas($total4) }} bs</b></td>
                    <td><b>{{ round($ptotal4, 2) }}%</b></td> --}}
                        <td><b>{{ con_separador_comas($total5) }} bs</b></td>
                        <td><b>{{ round($ptotal1 + $ptotal2 + $ptotal3, 0) }}%</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($graficos)
            <br>
            <center>
                <img src="{{ $chartFinanMot }}" style="width:75%;margin:auto;">
            </center>
        @endif
        <br>
        {{-- @dd($datos['por_fecha_unidad']) --}}
        @if (!isset($unidad_carrera))
            <br>
            <center><b>MODIFICACIONES POR UNIDAD/CARRERA</b></center>
            <br>
            <div class="table-responsive">
                <table class="my-table" style="font-size:8px;">
                    <thead>
                        <tr>
                            <th colspan="9">{{ $datos['por_fecha_mot']['fecha'] }}</th>
                        </tr>
                        <tr>
                            <th>Unidad carrera area</th>
                            <th colspan="2">Aprobado</th>
                            <th colspan="2">Verificado</th>
                            <th colspan="2">Elaborado</th>
                            <th colspan="2">Monto total</th>
                        </tr>
                    </thead>
                    @php
                        $total1 = 0;
                        $total2 = 0;
                        $total3 = 0;
                        $total4 = 0;
                        $total5 = 0;

                        $total_total = 0;

                        foreach ($datos['por_fecha_unidad_mot'] as $value) {
                            $total_total += $value['total_monto_sum'];
                        }
                    @endphp
                    <tbody>
                        @foreach ($datos['por_fecha_unidad_mot'] as $item)
                            @php
                                $aprobado = $item['total_aprobado_sum'];
                                $verificado = $item['total_verificado_sum'];
                                $pendiente = $item['total_pendiente_sum'];
                                $saldo = $item['total_saldo_sum'];
                                $total = $item['total_monto_sum'];

                                $total1 += $aprobado;
                                $total2 += $verificado;
                                $total3 += $pendiente;
                                $total4 += $saldo;
                                $total5 += $total;

                                $pt1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                                $pt2 = $total != 0 ? ($verificado * 100) / $total : 0;
                                $pt3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                                $pt4 = $pendiente != 0 ? ($saldo * 100) / $pendiente : 0;
                                $pt5 = $total_total != 0 ? ($total * 100) / $total_total : 0;
                            @endphp
                            <tr>
                                <td>{{ $item['unidad'] }}</td>
                                <td>{{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}</td>
                                <td>{{ $pt3 != 0 ? round($pt3, 2) . '%' : '-' }}</td>
                                <td>{{ $verificado != 0 ? con_separador_comas($verificado) . ' bs' : '-' }}</td>
                                <td>{{ $pt2 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                                <td>{{ $aprobado != 0 ? con_separador_comas($aprobado) . ' bs' : '-' }}</td>
                                <td>{{ $pt1 != 0 ? round($pt1, 2) . '%' : '-' }}</td>
                                {{-- <td>{{ $saldo != 0 ? con_separador_comas($saldo) . ' bs' : '-' }}</td>
                        <td>{{ $pt4 != 0 ? round($pt4, 2) . '%' : '-' }}</td> --}}
                                <td><b>{{ con_separador_comas($total) }} bs</b></td>
                                <td><b>{{ round($pt5, 2) }}%</b></td>
                            </tr>
                        @endforeach
                        @php
                            $ptotal1 = $total5 != 0 ? ($total1 * 100) / $total5 : 0;
                            $ptotal2 = $total5 != 0 ? ($total2 * 100) / $total5 : 0;
                            $ptotal3 = $total5 != 0 ? ($total3 * 100) / $total5 : 0;
                            $ptotal4 = $total3 != 0 ? ($total4 * 100) / $total3 : 0;
                        @endphp
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><b>{{ con_separador_comas($total3) }} bs</b></td>
                            <td><b>{{ round($ptotal3, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total2) }} bs</b></td>
                            <td><b>{{ round($ptotal2, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total1) }} bs</b></td>
                            <td><b>{{ round($ptotal1, 2) }}%</b></td>
                            {{-- <td><b>{{ con_separador_comas($total4) }} bs</b></td>
                    <td><b>{{ round($ptotal4, 2) }}%</b></td> --}}
                            <td><b>{{ con_separador_comas($total5) }} bs</b></td>
                            <td><b>{{ round($ptotal1 + $ptotal2 + $ptotal3, 0) }}%</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($graficos)
                <br>
                <center>
                    <img src="{{ $chartUnidadesMot }}" style="width:75%;margin:auto;">
                </center>
            @endif
        @endif
        @if ($partidas)
            <br>
            <center><b>MODIFICACIONES POR PARTIDAS</b></center>
            <center><b style="font-size: 14px">Partidas de origen (para modificación)</b></center>
            <div class="table-responsive">
                <table class="my-table" style="font-size:8px;">
                    <thead>
                        <tr>
                            <th colspan="9">{{ $datos['por_fecha_mot']['fecha'] }}</th>
                        </tr>
                        <tr>
                            <th>Codigo partidas</th>
                            <th colspan="2">Elaborado</th>
                            <th colspan="2">Verificado</th>
                            <th colspan="2">Aprobado</th>
                            <th colspan="2">Monto total</th>
                        </tr>
                    </thead>
                    @php
                        $total11 = 0;
                        $total21 = 0;
                        $total31 = 0;
                        $total41 = 0;

                        $total_total1 = 0;

                        foreach ($datos['por_fecha_partidas_mot_de'] as $value) {
                            $total_total1 += $value['total_monto_sum'];
                        }
                    @endphp
                    <tbody>
                        @foreach ($datos['por_fecha_partidas_mot_de'] as $item)
                            @php
                                $aprobado = $item['total_aprobado_sum'];
                                $verificado = $item['total_verificado_sum'];
                                $pendiente = $item['total_pendiente_sum'];
                                $total = $item['total_monto_sum'];

                                $total11 += $aprobado;
                                $total21 += $verificado;
                                $total31 += $pendiente;
                                $total41 += $total;

                                $pt1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                                $pt2 = $total != 0 ? ($verificado * 100) / $total : 0;
                                $pt3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                                $pt4 = $total_total1 != 0 ? ($total * 100) / $total_total1 : 0;
                            @endphp
                            <tr>
                                <td>{{ $item['partida'] }}</td>
                                <td>{{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}</td>
                                <td>{{ $pt3 != 0 ? round($pt3, 2) . '%' : '-' }}</td>
                                <td>{{ $verificado != 0 ? con_separador_comas($verificado) . ' bs' : '-' }}</td>
                                <td>{{ $pt2 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                                <td>{{ $aprobado != 0 ? con_separador_comas($aprobado) . ' bs' : '-' }}</td>
                                <td>{{ $pt1 != 0 ? round($pt1, 2) . '%' : '-' }}</td>
                                <td><b>{{ con_separador_comas($total) }} bs</b></td>
                                <td><b>{{ round($pt4, 2) }}%</b></td>
                            </tr>
                        @endforeach
                        @php
                            $ptotal11 = $total41 != 0 ? ($total11 * 100) / $total41 : 0;
                            $ptotal21 = $total41 != 0 ? ($total21 * 100) / $total41 : 0;
                            $ptotal31 = $total41 != 0 ? ($total31 * 100) / $total41 : 0;
                        @endphp
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><b>{{ con_separador_comas($total31) }} bs</b></td>
                            <td><b>{{ round($ptotal31, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total21) }} bs</b></td>
                            <td><b>{{ round($ptotal21, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total11) }} bs</b></td>
                            <td><b>{{ round($ptotal11, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total41) }} bs</b></td>
                            <td><b>{{ round($ptotal11 + $ptotal21 + $ptotal31, 0) }}%</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- @if ($graficos)
            <br>
            <center>
                <img src="{{ $chartPartidasMotDE }}" style="width:100%;margin:auto;">
            </center>
        @endif --}}
            <br>
            <center><b style="font-size: 14px">Partidas de destino</b></center>
            <div class="table-responsive">
                <table class="my-table" style="font-size:8px;">
                    <thead>
                        <tr>
                            <th colspan="9">{{ $datos['por_fecha_mot']['fecha'] }}</th>
                        </tr>
                        <tr>
                            <th>Codigo partidas</th>
                            <th colspan="2">Elaborado</th>
                            <th colspan="2">Verificado</th>
                            <th colspan="2">Aprobados</th>
                            <th colspan="2">Monto total</th>
                        </tr>
                    </thead>
                    @php
                        $total12 = 0;
                        $total22 = 0;
                        $total32 = 0;
                        $total42 = 0;

                        $total_total2 = 0;

                        foreach ($datos['por_fecha_partidas_mot_a'] as $value) {
                            $total_total2 += $value['total_monto_sum'];
                        }
                    @endphp
                    <tbody>
                        @foreach ($datos['por_fecha_partidas_mot_a'] as $item)
                            @php
                                $aprobado = $item['total_aprobado_sum'];
                                $verificado = $item['total_verificado_sum'];
                                $pendiente = $item['total_pendiente_sum'];
                                $total = $item['total_monto_sum'];

                                $total12 += $aprobado;
                                $total22 += $verificado;
                                $total32 += $pendiente;
                                $total42 += $total;

                                $pt1 = $total != 0 ? ($aprobado * 100) / $total : 0;
                                $pt2 = $total != 0 ? ($verificado * 100) / $total : 0;
                                $pt3 = $total != 0 ? ($pendiente * 100) / $total : 0;
                                $pt4 = $total_total2 != 0 ? ($total * 100) / $total_total2 : 0;
                            @endphp
                            <tr>
                                <td>{{ $item['partida'] }}</td>
                                <td>{{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}</td>
                                <td>{{ $pt3 != 0 ? round($pt3, 2) . '%' : '-' }}</td>
                                <td>{{ $verificado != 0 ? con_separador_comas($verificado) . ' bs' : '-' }}</td>
                                <td>{{ $pt2 != 0 ? round($pt2, 2) . '%' : '-' }}</td>
                                <td>{{ $aprobado != 0 ? con_separador_comas($aprobado) . ' bs' : '-' }}</td>
                                <td>{{ $pt1 != 0 ? round($pt1, 2) . '%' : '-' }}</td>
                                <td><b>{{ con_separador_comas($total) }} bs</b></td>
                                <td><b>{{ round($pt4, 2) }}%</b></td>
                            </tr>
                        @endforeach
                        @php
                            $ptotal12 = $total42 != 0 ? ($total12 * 100) / $total42 : 0;
                            $ptotal22 = $total42 != 0 ? ($total22 * 100) / $total42 : 0;
                            $ptotal32 = $total42 != 0 ? ($total32 * 100) / $total42 : 0;
                        @endphp
                        <tr>
                            <td><b>TOTAL</b></td>
                            <td><b>{{ con_separador_comas($total32) }} bs</b></td>
                            <td><b>{{ round($ptotal32, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total22) }} bs</b></td>
                            <td><b>{{ round($ptotal22, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total12) }} bs</b></td>
                            <td><b>{{ round($ptotal12, 2) }}%</b></td>
                            <td><b>{{ con_separador_comas($total42) }} bs</b></td>
                            <td><b>{{ round($ptotal12 + $ptotal22 + $ptotal32, 0) }}%</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- @if ($graficos)
            <br>
            <center>
                <img src="{{ $chartPartidasMotA }}" style="width:100%;margin:auto;">
            </center>
        @endif --}}
            <br>
            {{-- @dd($datos['por_fecha_partidas_mot']) --}}
            <center><b style="font-size: 14px">Resumen de modificaciones por partidas (aprobadas)</b></center>
            <div class="table-responsive">
                <table class="my-table" style="font-size:11px;width:50%;margin:auto;">
                    <thead>
                        <tr>
                            <th colspan="3">{{ $datos['por_fecha_mot']['fecha'] }}</th>
                        </tr>
                        <tr>
                            <th>Partida</th>
                            <th>Monto origen</th>
                            <th>Monto destino</th>
                            {{-- <th>Total</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalDe = 0;
                            $totalA = 0;
                            $totalTotal = 0;
                        @endphp
                        @foreach ($datos['por_fecha_partidas_mot'] as $item)
                            @php
                                $total = 0;
                                $i = 0;
                            @endphp
                            <tr>
                                <td>{{ $item['partida'] }}</td>
                                @if ($item['accion'] == 'DE')
                                    @php
                                        $total += $item['total_monto_sum'];
                                        $totalDe += $item['total_monto_sum'];
                                        $totalTotal += $item['total_monto_sum'];
                                    @endphp
                                    <td>{{ con_separador_comas($item['total_monto_sum']) }} bs</td>
                                    <td>-</td>
                                @else
                                    @php
                                        $total += $item['total_monto_sum'];
                                        $totalA += $item['total_monto_sum'];
                                        $totalTotal += $item['total_monto_sum'];
                                    @endphp
                                    <td>-</td>
                                    <td>{{ con_separador_comas($item['total_monto_sum']) }} bs</td>
                                @endif
                                {{-- <td><b>{{ con_separador_comas($total) }} bs</b></td> --}}
                            </tr>
                        @endforeach
                        <tr>
                            <td><b>Total</b></td>
                            <td><b>{{ con_separador_comas($totalDe) }} bs</b></td>
                            <td><b>{{ con_separador_comas($totalA) }} bs</b></td>
                            {{-- <td><b>{{ con_separador_comas($totalTotal - $totalA) }} bs</b></td> --}}
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($graficos)
                <br>
                <center>
                    <img src="{{ $chartPartidasMot }}" style="width:75%;margin:auto;">
                </center>
            @endif
        @endif
    @endif
</body>

</html>
