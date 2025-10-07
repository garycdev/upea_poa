<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario Nº 6</title>
    <style>
        .my-table {
            border-collapse: collapse;
            width: 100%;
            table-layout: auto;
        }

        .my-table th,
        .my-table td {
            border: 1px solid black;
            padding: 5px;
        }

        .my-table th {
            background-color: #f2f2f2;
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
            width: 70%;
        }

        .seccion {
            position: relative;
        }

        .text-primary {
            padding-top: 0px;
            margin-top: -18px;
        }

        .text-secundario {
            padding-top: 0px;
            padding-bottom: 0px;
            margin-top: -12px;
        }

        .th-title {
            background-color: #d2d2d2
        }

        .suma-total {
            /* fondo verde */
            background-color: #00B050;
        }

        /* .my-table td:nth-child(2) {
            width: 250px;
        } */
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
        <!-- Contenido de la primera sección -->
    </div>

    <div style="text-align: center; padding-top:12%">
        <h5 class="text-primary">PLAN OPERATIVO ANUAL (POA) -
            {{ $configuracion_formulado->formulado_tipo->descripcion . ' ' . $gestiones->gestion }}</h5>
        <h5 class="text-primary">(RESUMEN PRESUPUESTO)</h5>
        <h6 class="text-primary">UNIDAD ACADÉMICA : {{ $carrera_unidad->nombre_completo }}</h6>
        <div class=" ms-auto position-relative">
        </div>
    </div>

    <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-right">

    <h5 class="formulario_esquina form-esquina-top-left">IMP {{ fecha_literal(date('Y-m-d'), 4) }}</h5>
    <h5 class="formulario_esquina form-esquina-top-rigth">FORMULARIO Nº 6</h5>

    <h5 class="text-secundario"> CÓDIGO : {{ $configuracion_formulado->codigo }}</h5>
    <h5 class="text-secundario"> SIGLA : UPEA </h5>

    <div class="table-responsive">
        @php
            $tabla = [];

            foreach ($detalles as $det) {
                $filaPadre = [
                    'codigo' => $det->codigo,
                    'titulo' => $det->titulo,
                    'financiamientos' => [],
                    'total' => 0,
                ];

                foreach ($financiamientos as $finan) {
                    $monto = 0;

                    foreach ($det->relacion_clasificador_segundo as $det2) {
                        foreach ($det2->clasificador_tercero as $det3) {
                            $monto += $terceros
                                ->where('codigo', $det3->codigo)
                                ->where('tipo_financiamiento_id', $finan->id)
                                ->sum('total_presupuesto');

                            foreach ($det3->clasificador_cuarto as $det4) {
                                $monto += $cuartos
                                    ->where('codigo', $det4->codigo)
                                    ->where('tipo_financiamiento_id', $finan->id)
                                    ->sum('total_presupuesto');

                                foreach ($det4->clasificador_quinto as $det5) {
                                    $monto += $quintos
                                        ->where('codigo', $det5->codigo)
                                        ->where('tipo_financiamiento_id', $finan->id)
                                        ->sum('total_presupuesto');
                                }
                            }
                        }
                    }

                    $filaPadre['financiamientos'][$finan->id] = $monto;
                    $filaPadre['total'] += $monto;
                }

                $tabla[$det->id] = $filaPadre;
            }

            // dd($tabla);

        @endphp
        <table class="my-table" style="width: 100%; font-size:10px">
            <thead>
                <tr>
                    <th>PARTIDA</th>
                    <th>DETALLE</th>
                    @foreach ($financiamientos as $finan)
                        @php
                            $totales[$finan->id] = 0;
                        @endphp
                        <th>{{ $finan->sigla }}</th>
                    @endforeach
                    <th>TOTALES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $det)
                    @if ($tabla[$det->id]['total'] > 0)
                        <tr class="th-title" style="font-weight: bold;">
                            <td>
                                {{ $tabla[$det->id]['codigo'] }}
                            </td>
                            <td>
                                {{ $tabla[$det->id]['titulo'] }}
                            </td>
                            @foreach ($financiamientos as $finan)
                                <td>
                                    {{ $tabla[$det->id]['financiamientos'][$finan->id] ? con_separador_comas($tabla[$det->id]['financiamientos'][$finan->id]) . ' bs' : '-' }}
                                </td>
                            @endforeach
                            <td>{{ $tabla[$det->id]['total'] ? con_separador_comas($tabla[$det->id]['total']) . ' bs' : '-' }}
                            </td>
                        </tr>
                    @endif

                    @foreach ($det->relacion_clasificador_segundo as $det2)
                        {{-- <tr>
                            <td>{{ $det2->codigo }}</td>
                            <td>{{ $det2->titulo }}</td>
                            @foreach ($financiamientos as $finan)
                                <td>-</td>
                            @endforeach
                            <td>-</td>
                        </tr> --}}

                        @foreach ($det2->clasificador_tercero as $det3)
                            @php
                                $ter = $terceros->where('codigo', $det3->codigo);
                            @endphp
                            @if ($ter->isNotEmpty())
                                @php
                                    $suma = 0;
                                @endphp
                                <tr>
                                    <td>{{ $det3->codigo }}</td>
                                    <td>{{ $det3->titulo }}</td>
                                    @foreach ($financiamientos as $finan)
                                        @php
                                            $query = $ter->where('tipo_financiamiento_id', $finan->id);
                                            $monto = $query->sum('total_presupuesto');

                                            if ($query->count() == 0) {
                                                $monto = '';
                                            } else {
                                                $suma += $monto;
                                                $totales[$finan->id] += $monto;
                                            }
                                        @endphp
                                        <td>
                                            {{ $monto >= 0 ? con_separador_comas($monto) . ' bs' : '' }}
                                        </td>
                                    @endforeach
                                    <td>{{ $suma >= 0 ? con_separador_comas($suma) . ' bs' : '' }}</td>
                                </tr>
                            @endif

                            @foreach ($det3->clasificador_cuarto as $det4)
                                @php
                                    $cua = $cuartos->where('codigo', $det4->codigo);
                                @endphp
                                @if ($cua->isNotEmpty())
                                    @php
                                        $suma = 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $det4->codigo }}</td>
                                        <td>{{ $det4->titulo }}</td>
                                        @foreach ($financiamientos as $finan)
                                            @php
                                                $query = $cua->where('tipo_financiamiento_id', $finan->id);
                                                $monto = $query->sum('total_presupuesto');

                                                if ($query->count() == 0) {
                                                    $monto = '';
                                                } else {
                                                    $suma += $monto;
                                                    $totales[$finan->id] += $monto;
                                                }
                                            @endphp
                                            <td>
                                                {{ $monto >= 0 ? con_separador_comas($monto) . ' bs' : '' }}
                                            </td>
                                        @endforeach
                                        <td>{{ $suma >= 0 ? con_separador_comas($suma) . ' bs' : '' }}</td>
                                    </tr>
                                @endif

                                @foreach ($det4->clasificador_quinto as $det5)
                                    @php
                                        $quin = $quintos->where('codigo', $det5->codigo);
                                    @endphp
                                    @if ($quin->isNotEmpty())
                                        @php
                                            $suma = 0;
                                        @endphp
                                        <tr>
                                            <td>{{ $det5->codigo }}</td>
                                            <td>{{ $det5->titulo }}</td>
                                            @foreach ($financiamientos as $finan)
                                                @php
                                                    $query = $quin->where('tipo_financiamiento_id', $finan->id);
                                                    $monto = $query->sum('total_presupuesto');

                                                    if ($query->count() == 0) {
                                                        $monto = '';
                                                    } else {
                                                        $suma += $monto;
                                                        $totales[$finan->id] += $monto;
                                                    }
                                                @endphp
                                                <td>{{ $monto >= 0 ? con_separador_comas($monto) . ' bs' : '' }}
                                                </td>
                                            @endforeach
                                            <td>{{ $suma >= 0 ? con_separador_comas($suma) . ' bs' : '' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach

                </tr>
                <tr style="font-weight: bold;">
                    <td colspan="2" align="center">
                        TOTAL
                    </td>
                    @foreach ($financiamientos as $finan)
                        <td class="suma-total">
                            {{ $totales[$finan->id] ? con_separador_comas($totales[$finan->id]) . ' bs' : '-' }}
                        </td>
                    @endforeach
                    <td class="suma-total">
                        {{ array_sum($totales) ? con_separador_comas(array_sum($totales)) . ' bs' : '-' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border:none;"></td>
                    @foreach ($financiamientos as $finan)
                        <td align="center">{{ $finan->sigla }}</td>
                    @endforeach
                    <td>TOTALES</td>
                </tr>
            </tbody>
        </table>

        <table class="my-table" style="width: 50%; font-size:10px; margin-top: 50px;">
            <thead>
                <tr>
                    <td colspan="2" style="border: 0;font-weight:bold;">PRESUPUESTO ASIGNADO A LA UNIDAD</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($financiamientos as $finan)
                    <tr>
                        <td>{{ $finan->descripcion }}</td>
                        <td align="right">
                            {{ $totales[$finan->id] ? con_separador_comas($totales[$finan->id]) . ' bs' : '-' }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td style="border:0"></td>
                    <td style="font-weight:bold;" class="suma-total" align="right">
                        {{ array_sum($totales) ? con_separador_comas(array_sum($totales)) . ' bs' : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
