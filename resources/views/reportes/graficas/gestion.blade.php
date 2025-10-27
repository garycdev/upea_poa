<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gastos | Gestion</title>
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
            Reporte de gastos y saldo por gestion
        </h4>
        <h4 class="text-primary">PLAN OPERATIVO ANUAL</h4>
        <h4 class="text-primary">GESTION: {{ $datos['rango'] }}</h4>
        {{-- <h4 class="text-primary">{{ $unidad_carrera->nombre_completo }} </h4> --}}
        <div class=" ms-auto position-relative">
        </div>
    </div>

    <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-right">

    <h5 class="formulario_esquina form-esquina-top-left">IMP {{ fecha_literal(date('Y-m-d'), 4) }}</h5>
    <h5 class="formulario_esquina form-esquina-top-rigth">
        Reporte gestion {{ $datos['rango'] }}
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
    {{-- @dd($datos) --}}
    <center><b>RESUMEN GENERAL</b></center>
    <br>
    <div class="table-responsive">
        <table class="my-table" style="width: 100%;margin:auto; font-size:10px;">
            @php
                $total = 0;
                $total1 = 0;
                $total2 = 0;
                $gestion = [];
            @endphp
            <thead>
                <tr>
                    <th></th>
                    @if (count($datos['por_gestion']) > 1)
                        @foreach ($datos['por_gestion'] as $item)
                            @php
                                $gestion[$item['gestion']] = [];
                                $gestion[$item['gestion']]['presupuesto'] = 0;
                                $gestion[$item['gestion']]['pendiente'] = 0;
                                $gestion[$item['gestion']]['total'] = 0;
                            @endphp
                            <th colspan="2">{{ $item['gestion'] }}</th>
                        @endforeach
                    @endif
                    <th colspan="2">Total</th>
                </tr>
            </thead>
            @php
                foreach ($datos['por_gestion'] as $item) {
                    $total1 += $item['total_presupuesto_sum'];
                    $total2 += $item['total_pendiente_sum'];
                    $total += $item['total_monto_sum'];

                    if (count($datos['por_gestion']) > 1) {
                        $gestion[$item['gestion']]['presupuesto'] += $item['total_presupuesto_sum'];
                        $gestion[$item['gestion']]['pendiente'] += $item['total_pendiente_sum'];
                        $gestion[$item['gestion']]['total'] += $item['total_monto_sum'];
                    }
                }
            @endphp
            <tbody>
                <tr>
                    <td><b>Monto ejecutado</b></td>
                    @php
                        $ptotal1 = 0;
                    @endphp
                    @if (count($datos['por_gestion']) > 1)
                        @foreach ($gestion as $item)
                            <td>
                                {{ $item['presupuesto'] != 0 ? con_separador_comas($item['presupuesto']) . ' bs' : '-' }}
                            </td>
                            @php
                                $porc = $item['total'] != 0 ? ($item['presupuesto'] * 100) / $item['total'] : 0;
                                $ptotal1 += $porc;
                            @endphp
                            <td>
                                {{ $porc != 0 ? round($porc, 2) . '%' : '-' }}
                            </td>
                        @endforeach
                    @else
                        @php
                            $ptotal1 = $total != 0 ? ($total1 * 100) / $total : 0;
                        @endphp
                    @endif
                    <td>{{ con_separador_comas($total1) }} bs</td>
                    <td>{{ round($ptotal1, 2) }}%</td>
                </tr>
                <tr>
                    <td><b>Saldo</b></td>
                    @php
                        $ptotal2 = 0;
                    @endphp
                    @if (count($datos['por_gestion']) > 1)
                        @foreach ($gestion as $item)
                            <td>
                                {{ $item['pendiente'] != 0 ? con_separador_comas($item['pendiente']) . ' bs' : '-' }}
                            </td>
                            @php
                                $porc = $item['total'] != 0 ? ($item['pendiente'] * 100) / $item['total'] : 0;
                                $ptotal2 += $porc;
                            @endphp
                            <td>
                                {{ $porc != 0 ? round($porc, 2) . '%' : '-' }}
                            </td>
                        @endforeach
                    @else
                        @php
                            $ptotal2 = $total != 0 ? ($total2 * 100) / $total : 0;
                        @endphp
                    @endif
                    <td>{{ con_separador_comas($total2) }} bs</td>
                    <td>{{ round($ptotal2, 2) }}%</td>
                </tr>
                <tr>
                    <td><b>Monto total</b></td>
                    @foreach ($gestion as $item)
                        <td>
                            <b>{{ con_separador_comas($item['total']) }} bs</b>
                        </td>
                        @php
                            $porc = $item['total'] != 0 ? '100%' : '0%';
                        @endphp
                        <td>
                            {{ $porc }}
                        </td>
                    @endforeach
                    <td><b>{{ con_separador_comas($total1 + $total2) }} bs</b></td>
                    <td><b>{{ round($ptotal1 + $ptotal2, 0) }}%</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    @if ($graficos)
        <br>
        <center>
            <img src="{{ $gestionChart }}" style="width:75%;margin:auto;">
        </center>
    @endif
    <br>
    <center><b>MONTOS POR GESTION Y FUENTE DE FINANCIAMIENTO</b></center>
    <br>
    @php
        $fuentes = count($datos['por_gestion_fuente'][0]['fuentes']);
    @endphp
    <div class="grid-container" style="width:100%;">
        {{-- @php
                $pares = collect($datos['por_gestion_fuente'])->chunk(2);
            @endphp --}}
        @foreach ($datos['por_gestion_fuente'] as $item)
            <div style="width:100%;">
                <table class="my-table" style="font-size:8px;">
                    @php
                        $finan = [];
                    @endphp
                    <thead>
                        <tr>
                            <th colspan="{{ $fuentes * 2 + 3 }}" style="font-size:13px">
                                <b>{{ $item['gestion'] }}</b>
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            @foreach ($item['fuentes'] as $item2)
                                @php
                                    $finan[$item2['fuente']] = [];
                                    $finan[$item2['fuente']]['presupuesto'] = 0;
                                    $finan[$item2['fuente']]['pendiente'] = 0;
                                    $finan[$item2['fuente']]['total'] = 0;
                                @endphp
                                <th colspan="2">{{ $item2['fuente'] }}</th>
                            @endforeach
                            <th colspan="2">Total</th>
                        </tr>
                    </thead>
                    @php
                        foreach ($item['fuentes'] as $item2) {
                            $finan[$item2['fuente']]['presupuesto'] += $item2['total_presupuesto_sum'];
                            $finan[$item2['fuente']]['pendiente'] += $item2['total_pendiente_sum'];
                            $finan[$item2['fuente']]['total'] += $item2['total_monto_sum'];
                        }

                        $total1 = 0;
                        $total2 = 0;

                        foreach ($item['fuentes'] as $item2) {
                            $total1 += $finan[$item2['fuente']]['presupuesto'];
                            $total2 += $finan[$item2['fuente']]['pendiente'];
                        }

                        $total = $total1 + $total2;
                        if ($total != 0) {
                            $ptotal1 = ($total1 * 100) / $total;
                            $ptotal2 = ($total2 * 100) / $total;
                        } else {
                            $ptotal1 = 0;
                            $ptotal2 = 0;
                        }
                    @endphp
                    <tbody>
                        <tr>
                            <td><b>Monto ejecutado</b></td>
                            @foreach ($item['fuentes'] as $item2)
                                <td>
                                    {{ $finan[$item2['fuente']]['presupuesto'] != 0 ? con_separador_comas($finan[$item2['fuente']]['presupuesto']) . ' bs' : '-' }}
                                </td>
                                @php
                                    if ($finan[$item2['fuente']]['total'] != 0) {
                                        $porc =
                                            ($finan[$item2['fuente']]['presupuesto'] * 100) /
                                            $finan[$item2['fuente']]['total'];
                                    } else {
                                        $porc = 0;
                                    }
                                @endphp
                                <td>{{ $porc != 0 ? round($porc, 2) . '%' : '-' }}</td>
                            @endforeach
                            <td>{{ con_separador_comas($total1) }} bs</td>
                            <td>{{ round($ptotal1, 2) }}%</td>
                        </tr>
                        <tr>
                            <td><b>Saldo</b></td>
                            @foreach ($item['fuentes'] as $item2)
                                <td>
                                    {{ $finan[$item2['fuente']]['pendiente'] != 0 ? con_separador_comas($finan[$item2['fuente']]['pendiente']) . ' bs' : '-' }}
                                </td>
                                @php
                                    if ($finan[$item2['fuente']]['total'] != 0) {
                                        $porc =
                                            ($finan[$item2['fuente']]['pendiente'] * 100) /
                                            $finan[$item2['fuente']]['total'];
                                    } else {
                                        $porc = 0;
                                    }
                                @endphp
                                <td>{{ $porc != 0 ? round($porc, 2) . '%' : '-' }}</td>
                            @endforeach
                            <td>{{ con_separador_comas($total2) }} bs</td>
                            <td>{{ round($ptotal2, 2) }}%</td>
                        </tr>
                        <tr>
                            <td><b>Monto total</b></td>
                            @foreach ($item['fuentes'] as $item2)
                                <td><b>{{ con_separador_comas($item2['total_monto_sum']) }} bs</b></td>
                                @php
                                    $porc = $item2['total_monto_sum'] != 0 ? '100%' : '0%';
                                @endphp
                                <td>
                                    {{ $porc }}
                                </td>
                            @endforeach
                            <td><b>{{ con_separador_comas($total1 + $total2) }} bs</b></td>
                            <td><b>{{ round($ptotal1 + $ptotal2, 0) }}%</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if ($graficos)
                <center>
                    <img src="{{ $chartsFinan[$item['gestion']] }}" style="width:75%;margin:auto;">
                </center>
            @endif
            <br>
        @endforeach
    </div>
    <br>
    <center><b>Montos totales por fuente de financiamiento</b></center>
    <br>
    <div class="table-responsive">
        <table class="my-table" style="width: 100%;font-size:10px;">
            @php
                $gestion = [];
            @endphp
            <thead>
                <tr>
                    <th>Financiamiento</th>
                    @foreach ($datos['por_gestion_fuente'] as $item)
                        @php
                            $gestion[$item['gestion']] = 0;
                        @endphp
                        <th>{{ $item['gestion'] }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($datos['por_gestion_fuente'][0]['fuentes']); $i++)
                    @php
                        $total = 0;
                    @endphp
                    <tr>
                        <td>
                            <b>{{ $datos['por_gestion_fuente'][0]['fuentes'][$i]['fuente'] }}</b>
                        </td>
                        @foreach ($datos['por_gestion_fuente'] as $key => $item)
                            @php
                                $total += $item['fuentes'][$i]['total_monto_sum'];
                                $gestion[$item['gestion']] += $item['fuentes'][$i]['total_monto_sum'];
                            @endphp
                            <td>
                                {{ $item['fuentes'][$i]['total_monto_sum'] != 0 ? con_separador_comas($item['fuentes'][$i]['total_monto_sum']) . ' bs' : '-' }}
                            </td>
                        @endforeach
                        <td><b>{{ con_separador_comas($total) }} bs</b></td>
                    </tr>
                @endfor
                <tr>
                    @php
                        $total2 = 0;
                    @endphp
                    <td><b>TOTAL</b></td>
                    @foreach ($gestion as $item)
                        @php
                            $total2 += $item;
                        @endphp
                        <td><b>{{ con_separador_comas($item) }} bs</b></td>
                    @endforeach
                    <td><b>{{ con_separador_comas($total2) }} bs</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <center><b>MONTOS POR GESTION Y UNIDAD/CARRERA</b></center>
    <br>
    @php
        $unidades = count($datos['por_gestion_unidad'][0]['unidades']);
    @endphp
    <div class="grid-container" style="width:100%;">
        {{-- @php
                $pares = collect($datos['por_gestion_unidad'])->chunk(2);
            @endphp --}}
        {{-- @dd($datos['por_gestion_unidad']) --}}
        @foreach ($datos['por_gestion_unidad'] as $key => $item)
            <table class="my-table" style="width:100%;font-size:8px;">
                <thead>
                    <tr>
                        <th colspan="7" style="font-size:13px">
                            <b>{{ $item['gestion'] }}</b>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2">Monto ejecutado</th>
                        <th colspan="2">Saldo</th>
                        <th colspan="2">Monto total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total1 = 0;
                        $total2 = 0;
                        $total3 = 0;
                    @endphp
                    @foreach ($item['unidades'] as $key => $item2)
                        @php
                            $presupuesto = $item2['total_presupuesto_sum'];
                            $pendiente = $item2['total_pendiente_sum'];
                            $total = $item2['total_monto_sum'];

                            $total1 += $presupuesto;
                            $total2 += $pendiente;
                            $total3 += $total;

                            $ptotal1 = $total != 0 ? ($presupuesto * 100) / $total : 0;
                            $ptotal2 = $total != 0 ? ($pendiente * 100) / $total : 0;
                        @endphp
                        <tr>
                            <td><b>{{ $item2['unidad'] }}</b></td>
                            <td>
                                {{ $presupuesto != 0 ? con_separador_comas($presupuesto) . ' bs' : '-' }}
                            </td>
                            <td>{{ round($ptotal1, 2) }}%</td>
                            <td>
                                {{ $pendiente != 0 ? con_separador_comas($pendiente) . ' bs' : '-' }}
                            </td>
                            <td>{{ round($ptotal2, 2) }}%</td>
                            <td>
                                <b>{{ $total != 0 ? con_separador_comas($total) . ' bs' : '-' }}</b>
                            </td>
                            <td><b>{{ round($ptotal1 + $ptotal2) }}%</b></td>
                        </tr>
                    @endforeach
                    @php
                        $ptotal1 = $total3 != 0 ? ($total1 * 100) / $total3 : 0;
                        $ptotal2 = $total3 != 0 ? ($total2 * 100) / $total3 : 0;
                    @endphp
                    <tr>
                        <td><b>Total</b></td>
                        <td><b>{{ con_separador_comas($total1) }} bs</b></td>
                        <td>{{ round($ptotal1, 2) }}%</td>
                        <td><b>{{ con_separador_comas($total2) }} bs</b></td>
                        <td>{{ round($ptotal2, 2) }}%</td>
                        <td><b>{{ con_separador_comas($total3) }} bs</b></td>
                        <td><b>{{ round($ptotal1 + $ptotal2) }}%</b></td>
                    </tr>
                </tbody>
            </table>
            @if ($graficos)
                <center>
                    <img src="{{ $chartsUnidades[$item['gestion']] }}" style="width:75%;margin:auto;">
                </center>
            @endif
            <br>
        @endforeach
    </div>
</body>

</html>
