<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario Nº 5</title>
    <style>
        .my-table {
            border-collapse: collapse;
            width: 100%;
        }

        .my-table th,
        .my-table td {
            border: 1px solid black;
            padding: 5px;
        }

        /* Quitar los bordes externos */
        .my-sub-table tr:first-child th,
        .my-sub-table tr:first-child td {
            border-top: none;
        }

        .my-sub-table tr:last-child td {
            border-bottom: none;
        }

        .my-sub-table tr td:first-child,
        .my-sub-table tr th:first-child {
            border-left: none;
        }

        .my-sub-table tr td:last-child,
        .my-sub-table tr th:last-child {
            border-right: none;
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
            margin-top: -12px;
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
        <!-- Contenido de la primera sección -->
    </div>

    <div style="text-align: center; padding-top:9%">
        <h5 class="text-primary">PLAN OPERATIVO ANUAL (POA) -
            {{ $configuracion_formulado->formulado_tipo->descripcion . ' ' . $gestiones->gestion }}</h5>
        <h5 class="text-primary">DETERMINACIÓN DE OPERACIONES Y REQUERIMIENTOS</h5>
        <h6 class="text-primary">UNIDAD ACADÉMICA : {{ $carrera_unidad->nombre_completo }}</h6>
        <div class=" ms-auto position-relative">
        </div>
    </div>

    <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-right">

    <h5 class="formulario_esquina form-esquina-top-left">IMP {{ fecha_literal(date('Y-m-d'), 4) }}</h5>
    <h5 class="formulario_esquina form-esquina-top-rigth">FORMULARIO Nº 5</h5>

    <h5 class="text-secundario"> CÓDIGO : {{ $configuracion_formulado->codigo }}</h5>
    <h5 class="text-secundario"> SIGLA : UPEA </h5>

    @if ($estado_primero == 'f5_area1')
        <h5>AREA ESTRATEGICA Nº {{ $area_estrategica_codigo1 }}: {{ $area_estrategica_desc1 }}</h5>
        <div class="table-responsive">
            <table class="my-table" style="width: 100%; font-size:5px">
                <thead>
                    <tr>
                        <th colspan="10">OPERACIONES</th>
                        <th rowspan="3">REQUERIMIENTOS</th>
                    </tr>
                    <tr>
                        <th rowspan="2">CÓDIGO ARTICULACIÓN <br>(Objetivos)</th>
                        <th rowspan="2">CÓDIGO INDICADOR <br>(Resultado Esperado)</th>
                        <th rowspan="2">OPERACIONES</th>
                        <th rowspan="2">TIPO DE<br>OPERACIONES</th>
                        <th colspan="3">PROGRAMA SEMESTRAL DE LA OPERACIÓN <br></th>
                        <th colspan="2">PERIODO DE EJECUCIÓN</th>
                        <th rowspan="2">PREUPUESTO ASIGNADO A LA OPERACIÓN</th>
                    </tr>
                    <tr>
                        <th>1er Semestre </th>
                        <th>2do Semestre</th>
                        <th>Total</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulario5_area1 as $lis)
                        <tr>
                            <td>
                                {{ $area_estrategica_area1->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo }}
                            </td>
                            <td>
                                {{ $area_estrategica_area1->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo . '.' . $lis->formulario4->formulario2->indicador->codigo }}
                            </td>
                            <td>
                                {{ $lis->operacion->descripcion }}
                            </td>
                            <td>
                                {{ $lis->operacion->tipo_operacion->nombre }}
                            </td>
                            <td>
                                {{ $lis->primer_semestre }}
                            </td>
                            <td>
                                {{ $lis->segundo_semestre }}
                            </td>
                            <td>
                                {{ $lis->total }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->desde, 4) }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->hasta, 4) }}
                            </td>
                            <td>
                                @php
                                    $suma_total = 0;
                                    foreach ($lis->medida_bien_serviciof5 as $lis1) {
                                        $suma_total = $suma_total + $lis1->total_presupuesto;
                                    }
                                    echo con_separador_comas($suma_total) . ' Bs';
                                @endphp
                            </td>
                            <td style="margin:0;padding:0;">
                                <table class="my-table my-sub-table" style="width: 100%; font-size:5px">
                                    <thead>
                                        <tr>
                                            <th>DESCRIPCIÓN DEL BIEN O SERVICIO DEMANDADO ITEM</th>
                                            <th>MEDIDA</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO UNITARIO</th>
                                            <th>TOTAL PRESUPUESTO</th>
                                            <th>PARTIDA POR OBJETIO DE GASTO</th>
                                            <th>FUENTE DE FINANCIAMIENTO</th>
                                            <th>FECHA EN LA QUE SE REQUIRE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lis->medida_bien_serviciof5 as $lis1)
                                            <tr>
                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->titulo }}</td>
                                                @endif
                                                <td>
                                                    {{ $lis1->medida->nombre }}
                                                </td>
                                                <td>
                                                    {{ $lis1->cantidad }}
                                                </td>
                                                <td>
                                                    @if (is_numeric($lis1->precio_unitario))
                                                        {{ con_separador_comas($lis1->precio_unitario) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->precio_unitario }}
                                                    @endif

                                                </td>
                                                <td>

                                                    @if (is_numeric($lis1->total_presupuesto))
                                                        {{ con_separador_comas($lis1->total_presupuesto) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->total_presupuesto }}
                                                    @endif
                                                </td>

                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->clasificador_tercero->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->clasificador_cuarto->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->clasificador_quinto->codigo }}
                                                    </td>
                                                @endif

                                                <td>
                                                    {{ $lis1->tipo_financiamiento->sigla }}
                                                </td>
                                                <td>
                                                    {{ fecha_literal($lis1->fecha_requerida, 4) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($estado_segundo == 'f5_area2')
        <h5>AREA ESTRATEGICA Nº {{ $area_estrategica_codigo2 }}: {{ $area_estrategica_desc2 }}</h5>
        <div class="table-responsive">
            <table class="my-table" style="width: 100%; font-size:5px">
                <thead>
                    <tr>
                        <th colspan="10">OPERACIONES</th>
                        <th rowspan="3">REQUERIMIENTOS</th>
                    </tr>
                    <tr>
                        <th rowspan="2">CÓDIGO ARTICULACIÓN <br>(Objetivos)</th>
                        <th rowspan="2">CÓDIGO INDICADOR <br>(Resultado Esperado)</th>
                        <th rowspan="2">OPERACIONES</th>
                        <th rowspan="2">TIPO DE<br>OPERACIONES</th>
                        <th colspan="3">PROGRAMA SEMESTRAL DE LA OPERACIÓN <br></th>
                        <th colspan="2">PERIODO DE EJECUCIÓN</th>
                        <th rowspan="2">PREUPUESTO ASIGNADO A LA OPERACIÓN</th>
                    </tr>
                    <tr>
                        <th>1er Semestre </th>
                        <th>2do Semestre</th>
                        <th>Total</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulario5_area2 as $lis)
                        <tr>
                            <td>
                                {{ $area_estrategica_area2->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo }}
                            </td>
                            <td>
                                {{ $area_estrategica_area2->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo . '.' . $lis->formulario4->formulario2->indicador->codigo }}
                            </td>
                            <td>
                                {{ $lis->operacion->descripcion }}
                            </td>
                            <td>
                                {{ $lis->operacion->tipo_operacion->nombre }}
                            </td>
                            <td>
                                {{ $lis->primer_semestre }}
                            </td>
                            <td>
                                {{ $lis->segundo_semestre }}
                            </td>
                            <td>
                                {{ $lis->total }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->desde, 4) }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->hasta, 4) }}
                            </td>
                            <td>
                                @php
                                    $suma_total = 0;
                                    foreach ($lis->medida_bien_serviciof5 as $lis1) {
                                        $suma_total = $suma_total + $lis1->total_presupuesto;
                                    }
                                    echo con_separador_comas($suma_total) . ' Bs';
                                @endphp
                            </td>
                            <td style="margin:0;padding:0;">
                                <table class="my-table my-sub-table" style="width: 100%; font-size:5px">
                                    <thead>
                                        <tr>
                                            <th>DESCRIPCIÓN DEL BIEN O SERVICIO DEMANDADO ITEM</th>
                                            <th>MEDIDA</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO UNITARIO</th>
                                            <th>TOTAL PRESUPUESTO</th>
                                            <th>PARTIDA POR OBJETIO DE GASTO</th>
                                            <th>FUENTE DE FINANCIAMIENTO</th>
                                            <th>FECHA EN LA QUE SE REQUIRE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lis->medida_bien_serviciof5 as $lis1)
                                            <tr>
                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->titulo }}</td>
                                                @endif
                                                <td>
                                                    {{ $lis1->medida->nombre }}
                                                </td>
                                                <td>
                                                    {{ $lis1->cantidad }}
                                                </td>
                                                <td>
                                                    @if (is_numeric($lis1->precio_unitario))
                                                        {{ con_separador_comas($lis1->precio_unitario) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->precio_unitario }}
                                                    @endif

                                                </td>
                                                <td>

                                                    @if (is_numeric($lis1->total_presupuesto))
                                                        {{ con_separador_comas($lis1->total_presupuesto) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->total_presupuesto }}
                                                    @endif
                                                </td>

                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->clasificador_tercero->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->clasificador_cuarto->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->clasificador_quinto->codigo }}
                                                    </td>
                                                @endif

                                                <td>
                                                    {{ $lis1->tipo_financiamiento->sigla }}
                                                </td>
                                                <td>
                                                    {{ fecha_literal($lis1->fecha_requerida, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($estado_tercero == 'f5_area3')
        <h5>AREA ESTRATEGICA Nº {{ $area_estrategica_codigo3 }}: {{ $area_estrategica_desc3 }}</h5>
        <div class="table-responsive">
            <table class="my-table" style="width: 100%; font-size:5px">
                <thead>
                    <tr>
                        <th colspan="10">OPERACIONES</th>
                        <th rowspan="3">REQUERIMIENTOS</th>
                    </tr>
                    <tr>
                        <th rowspan="2">CÓDIGO ARTICULACIÓN <br>(Objetivos)</th>
                        <th rowspan="2">CÓDIGO INDICADOR <br>(Resultado Esperado)</th>
                        <th rowspan="2">OPERACIONES</th>
                        <th rowspan="2">TIPO DE<br>OPERACIONES</th>
                        <th colspan="3">PROGRAMA SEMESTRAL DE LA OPERACIÓN <br></th>
                        <th colspan="2">PERIODO DE EJECUCIÓN</th>
                        <th rowspan="2">PREUPUESTO ASIGNADO A LA OPERACIÓN</th>
                    </tr>
                    <tr>
                        <th>1er Semestre </th>
                        <th>2do Semestre</th>
                        <th>Total</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulario5_area3 as $lis)
                        <tr>
                            <td>
                                {{ $area_estrategica_area3->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo }}
                            </td>
                            <td>
                                {{ $area_estrategica_area3->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo . '.' . $lis->formulario4->formulario2->indicador->codigo }}
                            </td>
                            <td>
                                {{ $lis->operacion->descripcion }}
                            </td>
                            <td>
                                {{ $lis->operacion->tipo_operacion->nombre }}
                            </td>
                            <td>
                                {{ $lis->primer_semestre }}
                            </td>
                            <td>
                                {{ $lis->segundo_semestre }}
                            </td>
                            <td>
                                {{ $lis->total }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->desde, 4) }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->hasta, 4) }}
                            </td>
                            <td>
                                @php
                                    $suma_total = 0;
                                    foreach ($lis->medida_bien_serviciof5 as $lis1) {
                                        $suma_total = $suma_total + $lis1->total_presupuesto;
                                    }
                                    echo con_separador_comas($suma_total) . ' Bs';
                                @endphp
                            </td>
                            <td style="margin:0;padding:0;">
                                <table class="my-table my-sub-table" style="width: 100%; font-size:5px">
                                    <thead>
                                        <tr>
                                            <th>DESCRIPCIÓN DEL BIEN O SERVICIO DEMANDADO ITEM</th>
                                            <th>MEDIDA</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO UNITARIO</th>
                                            <th>TOTAL PRESUPUESTO</th>
                                            <th>PARTIDA POR OBJETIO DE GASTO</th>
                                            <th>FUENTE DE FINANCIAMIENTO</th>
                                            <th>FECHA EN LA QUE SE REQUIRE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lis->medida_bien_serviciof5 as $lis1)
                                            <tr>
                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->titulo }}</td>
                                                @endif
                                                <td>
                                                    {{ $lis1->medida->nombre }}
                                                </td>
                                                <td>
                                                    {{ $lis1->cantidad }}
                                                </td>
                                                <td>
                                                    @if (is_numeric($lis1->precio_unitario))
                                                        {{ con_separador_comas($lis1->precio_unitario) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->precio_unitario }}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if (is_numeric($lis1->total_presupuesto))
                                                        {{ con_separador_comas($lis1->total_presupuesto) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->total_presupuesto }}
                                                    @endif
                                                </td>

                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->clasificador_tercero->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->clasificador_cuarto->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->clasificador_quinto->codigo }}
                                                    </td>
                                                @endif

                                                <td>
                                                    {{ $lis1->tipo_financiamiento->sigla }}
                                                </td>
                                                <td>
                                                    {{ fecha_literal($lis1->fecha_requerida, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif


    @if ($estado_cuarto == 'f5_area4')
        <h5>AREA ESTRATEGICA Nº {{ $area_estrategica_codigo4 }}: {{ $area_estrategica_desc4 }}</h5>
        <div class="table-responsive">
            <table class="my-table" style="width: 100%; font-size:5px">
                <thead>
                    <tr>
                        <th colspan="10">OPERACIONES</th>
                        <th rowspan="3">REQUERIMIENTOS</th>
                    </tr>
                    <tr>
                        <th rowspan="2">CÓDIGO ARTICULACIÓN <br>(Objetivos)</th>
                        <th rowspan="2">CÓDIGO INDICADOR <br>(Resultado Esperado)</th>
                        <th rowspan="2">OPERACIONES</th>
                        <th rowspan="2">TIPO DE<br>OPERACIONES</th>
                        <th colspan="3">PROGRAMA SEMESTRAL DE LA OPERACIÓN <br></th>
                        <th colspan="2">PERIODO DE EJECUCIÓN</th>
                        <th rowspan="2">PREUPUESTO ASIGNADO A LA OPERACIÓN</th>
                    </tr>
                    <tr>
                        <th>1er Semestre </th>
                        <th>2do Semestre</th>
                        <th>Total</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulario5_area4 as $lis)
                        <tr>
                            <td>
                                {{ $area_estrategica_area4->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo }}
                            </td>
                            <td>
                                {{ $area_estrategica_area4->codigo_areas_estrategicas . '.' . $lis->formulario4->formulario2->politica_desarrollo_pei[0]->codigo . '.' . $lis->formulario4->formulario2->objetivo_institucional[0]->codigo . '.' . $lis->formulario4->formulario2->indicador->codigo }}
                            </td>
                            <td>
                                {{ $lis->operacion->descripcion }}
                            </td>
                            <td>
                                {{ $lis->operacion->tipo_operacion->nombre }}
                            </td>
                            <td>
                                {{ $lis->primer_semestre }}
                            </td>
                            <td>
                                {{ $lis->segundo_semestre }}
                            </td>
                            <td>
                                {{ $lis->total }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->desde, 4) }}
                            </td>
                            <td>
                                {{ fecha_literal($lis->hasta, 4) }}
                            </td>
                            <td>
                                @php
                                    $suma_total = 0;
                                    foreach ($lis->medida_bien_serviciof5 as $lis1) {
                                        $suma_total = $suma_total + $lis1->total_presupuesto;
                                    }
                                    echo con_separador_comas($suma_total) . ' Bs';
                                @endphp
                            </td>
                            <td style="margin:0;padding:0;">
                                <table class="my-table my-sub-table" style="width: 100%; font-size:5px">
                                    <thead>
                                        <tr>
                                            <th>DESCRIPCIÓN DEL BIEN O SERVICIO DEMANDADO ITEM</th>
                                            <th>MEDIDA</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO UNITARIO</th>
                                            <th>TOTAL PRESUPUESTO</th>
                                            <th>PARTIDA POR OBJETIO DE GASTO</th>
                                            <th>FUENTE DE FINANCIAMIENTO</th>
                                            <th>FECHA EN LA QUE SE REQUIRE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lis->medida_bien_serviciof5 as $lis1)
                                            <tr>
                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->titulo }}</td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->titulo }}</td>
                                                @endif
                                                <td>
                                                    {{ $lis1->medida->nombre }}
                                                </td>
                                                <td>
                                                    {{ $lis1->cantidad }}
                                                </td>
                                                <td>
                                                    @if (is_numeric($lis1->precio_unitario))
                                                        {{ con_separador_comas($lis1->precio_unitario) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->precio_unitario }}
                                                    @endif

                                                </td>
                                                <td>

                                                    @if (is_numeric($lis1->total_presupuesto))
                                                        {{ con_separador_comas($lis1->total_presupuesto) . ' Bs' }}
                                                    @else
                                                        {{ $lis1->total_presupuesto }}
                                                    @endif
                                                </td>

                                                @if (count($lis1->detalle_tercer_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_tercer_clasificador[0]->clasificador_tercero->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_cuarto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_cuarto_clasificador[0]->clasificador_cuarto->codigo }}
                                                    </td>
                                                @endif

                                                @if (count($lis1->detalle_quinto_clasificador) > 0)
                                                    <td>{{ $lis1->detalle_quinto_clasificador[0]->clasificador_quinto->codigo }}
                                                    </td>
                                                @endif

                                                <td>
                                                    {{ $lis1->tipo_financiamiento->sigla }}
                                                </td>
                                                <td>
                                                    {{ fecha_literal($lis1->fecha_requerida, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</body>

</html>
