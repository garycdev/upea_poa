<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .my-table {
            border-collapse: collapse;
            width: 100%;
        }

        .my-table th,
        .my-table td {
            border: 1px solid black;
            padding: 8px;
        }

        .my-table th {
            background-color: #f2f2f2;
        }

        .rotar {
            transform: rotate(270deg);
            display: inline-block;
            vertical-align: middle;
            width: 1px;
            text-align: center;
            padding-right: 4px;
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
            top: 0;
            right: 0;
        }

        /**/
        .img_fondo {
            position: absolute;
            opacity: 0.8;
            top: -12%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            width: 50%;
        }

        .seccion {
            position: relative;
        }

        .text-primary {
            padding: 0px;
            margin: 2px;
        }

        .primario {
            margin-top: 5%;
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



    <main>
        <div style="text-align: center;">
            <h3 class="text-primary primario">MATRIZ DE PLANIFICACIÓN </h3>
            <h3 class="text-primary">AREA ESTRATEGICA Nº{{ $area_estrategica->codigo_areas_estrategicas }}
                {{ $area_estrategica->descripcion }} </h3>
        </div>

        <div class="seccion">
            <img src="{{ $imagen_encabezado }}" class="img_fondo">
            <!-- Contenido de la primera sección -->
        </div>





        {{-- <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-left"> --}}
        <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-right">

        <div class="table-container">
            <table class="my-table" style="width:100%;">
                <thead style="font-size: 9px;">
                    <tr>
                        <th rowspan="2">N°</th>
                        <th rowspan="2">Articulación PDES</th>
                        <th colspan="3">Articulación PEI-PDU</th>
                        <th rowspan="2"><span class="rotar">Area Estrategica</span></th>
                        <th colspan="2">Politica de Desarrollo</th>
                        <th colspan="2">Objetivo estategico (Sistema de Universidades de Bolivia)</th>
                        <th colspan="2">Objetivo estategico Institucional</th>
                        <th colspan="2">Indicador Estrategico</th>
                        <th rowspan="2"><span class="rotar"> Tipo</span></th>
                        <th rowspan="2"><span class="rotar"> Categoria</span></th>
                        <th rowspan="2"><span class="rotar"> Cod.</span></th>
                        <th rowspan="2"> Resultado o producto</th>
                        <th rowspan="2">Linea base
                            {{ $area_estrategica->reversa_relacion_areas_estrategicas->relacion_gestiones[0]->gestion - 1 }}
                        </th>
                        <th colspan="6">Programación anual de Metas</th>
                        <th rowspan="2">Programa/ Poryecto/ Acción Estrategica</th>
                        <th rowspan="2">Unidades involucradas</th>
                        <th rowspan="2">Unidades responsables de meta</th>
                    </tr>
                    <tr>
                        <th> <span class="rotar"> Area </span></th>
                        <th> <span class="rotar">Politica</span></th>
                        <th> <span class="rotar">OE</span></th>
                        <th>Cod.</th>
                        <th>Descripcion</th>
                        <th>Cod.</th>
                        <th>Descripcion</th>
                        <th>Cod.</th>
                        <th>Descripcion</th>
                        <th>Cod.</th>
                        <th>Descripcion</th>
                        <th>{{ $area_estrategica->reversa_relacion_areas_estrategicas->relacion_gestiones[0]->gestion }}
                        </th>
                        <th>{{ $area_estrategica->reversa_relacion_areas_estrategicas->relacion_gestiones[1]->gestion }}
                        </th>
                        <th>{{ $area_estrategica->reversa_relacion_areas_estrategicas->relacion_gestiones[2]->gestion }}
                        </th>
                        <th>{{ $area_estrategica->reversa_relacion_areas_estrategicas->relacion_gestiones[3]->gestion }}
                        </th>
                        <th>{{ $area_estrategica->reversa_relacion_areas_estrategicas->relacion_gestiones[4]->gestion }}
                        </th>
                        <th>Meta Media</th>
                    </tr>
                </thead>
                <tbody style="font-size: 7px;">
                    @foreach ($listar as $lis)
                        <tr>
                            <td>{{ $lis->codigo }}</td>
                            <td>
                                {{ 'Eje ' . $lis->areas_estrategicas->reversa_relacion_areas_estrategicas->relacion_pdes->codigo_eje . ' Meta ' . $lis->areas_estrategicas->reversa_relacion_areas_estrategicas->relacion_pdes->codigo_meta . ' Acción ' . $lis->areas_estrategicas->reversa_relacion_areas_estrategicas->relacion_pdes->descripcion_accion }}
                            </td>
                            <td>{{ $area_estrategica->codigo_areas_estrategicas }}</td>
                            <td>
                                {{ $area_estrategica->codigo_areas_estrategicas . '.' . $lis->politica_desarrollo_pdu[0]->codigo }}
                            </td>
                            <td>
                                {{ $area_estrategica->codigo_areas_estrategicas . '.' . $lis->politica_desarrollo_pdu[0]->codigo . '.' . $lis->objetivo_estrategico[0]->codigo }}
                            </td>
                            <td>
                                {{ $area_estrategica->codigo_areas_estrategicas }}
                            </td>
                            <td>
                                {{ $area_estrategica->codigo_areas_estrategicas . '.' . $lis->politica_desarrollo_pei[0]->codigo }}
                            </td>
                            <td>
                                {{ $lis->politica_desarrollo_pei[0]->descripcion }}
                            </td>
                            <td>
                                {{ $lis->objetivo_estrategico_sub[0]->codigo }}
                            </td>
                            <td>
                                {{ $lis->objetivo_estrategico_sub[0]->descripcion }}
                            </td>
                            <td>
                                @foreach ($lis->objetivo_institucional as $li1)
                                    {{ $li1->codigo }}
                                @endforeach
                            </td>
                            <td>
                                @foreach ($lis->objetivo_institucional as $li1)
                                    {{ $li1->descripcion }}
                                @endforeach
                            </td>
                            <td>
                                <span class="rotar">{{ $lis->indicador_pei->codigo }}</span>
                            </td>
                            <td>
                                {{ $lis->indicador_pei->descripcion }}
                            </td>
                            <td>
                                <span class="rotar">{{ $lis->tipo->nombre }}</span>
                            </td>
                            <td>
                                <span class="rotar">{{ $lis->categoria->nombre }} </span>
                                <span class="rotar"></span>
                            </td>
                            <td>{{ $lis->resultado_producto->codigo }}</td>
                            <td>{{ $lis->resultado_producto->descripcion }}</td>
                            <td>{{ $lis->linea_base }}</td>
                            <td>{{ $lis->gestion_1 }}</td>
                            <td>{{ $lis->gestion_2 }}</td>
                            <td>{{ $lis->gestion_3 }}</td>
                            <td>{{ $lis->gestion_4 }}</td>
                            <td>{{ $lis->gestion_5 }}</td>
                            <td>{{ $lis->meta_mediano_plazo }}</td>
                            <td>{{ $lis->programa_proyecto_accion->descripcion }}</td>
                            <td>
                                @php
                                    $unidades_inv = '';
                                @endphp
                                @foreach ($lis->unidades_administrativas_inv as $key => $li)
                                    @php
                                        if ($key == 0) {
                                            $unidades_inv .= $li->nombre_completo;
                                        } else {
                                            $unidades_inv .= ', ' . $li->nombre_completo;
                                        }
                                    @endphp
                                @endforeach
                                {{ $unidades_inv }}
                            </td>
                            <td>
                                @php
                                    $unidades_res = '';
                                @endphp
                                @foreach ($lis->unidades_administrativas_res as $key => $li)
                                    @php
                                        if ($key == 0) {
                                            $unidades_res .= $li->nombre_completo;
                                        } else {
                                            $unidades_res .= ', ' . $li->nombre_completo;
                                        }
                                    @endphp
                                @endforeach
                                {{ $unidades_res }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </main>

</body>

</html>
