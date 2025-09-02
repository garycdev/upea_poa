<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asignación de montos gestion {{ $gestiones->gestion }}</title>
    <style>
        .my-table {
            border-collapse: collapse;
            width: 100%;
        }
        .my-table th, .my-table td {
            border: 1px solid black;
            padding: 8px;
        }
        .my-table th {
            background-color: #f2f2f2;
        }

        #thead tr {
            position: sticky;
            top: 0;
            background-color: #fff; /* Agrega un fondo blanco para evitar que se mezcle con el contenido */
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
            top: 10px; /* Ajusta la posición vertical */
            left: 10px; /* Ajusta la posición horizontal */
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
            top: -30;
            right: 0;
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
        .text-primary{
            padding-top: 0px;
            margin-top: -18px;
        }
        .text-secundario{
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

        <div style="text-align: center; padding-top:10%">
            <h3 class="text-primary">LISTADO DE : {{ $tipo_carrera_unidad->nombre }}</h3>
            <h3 class="text-primary">ASIGNACIÓN DE MONTOS DE LA GESTIÓN : {{ $gestiones->gestion }}</h3>
            <div class=" ms-auto position-relative">
            </div>
        </div>

        <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-right">

    <div class="table-responsive">
        <table class="my-table" style="width: 100%; font-size:9px">
            <thead >
                <tr>
                    <th>#</th>
                    <th>NOMBRE COMPLETO</th>
                    <th>ESTADO</th>
                    <th>{{ $tipo_financiamiento[0]->sigla }}</th>
                    <th>{{ $tipo_financiamiento[1]->sigla }}</th>
                    <th>{{ $tipo_financiamiento[2]->sigla }}</th>
                    <th>{{ $tipo_financiamiento[3]->sigla }}</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody >

                @php
                    $suma_total             = 0;
                    $suma_total_TGN         = 0;
                    $suma_total_COP_TRIB    = 0;
                    $suma_total_IDH         = 0;
                    $suma_total_REC_PROP    = 0;
                    $suma_total_porine      = 0;
                @endphp
                @if ($resultado->isEmpty())
                    No se encontraron datos
                @else
                    @foreach ($resultado as $lis)
                        @php
                            $suma_total_porine = 0;
                        @endphp
                        <tr>
                            <td width="5%">{{ $loop->iteration }}</td>
                            <td width="30%" >{{ $lis->nombre_completo }}</td>
                            <td>
                                @if ($lis->relacion_caja->isEmpty())
                                    <span class="badge rounded-pill bg-danger">No financiado</span>
                                @else
                                    <span class="badge rounded-pill bg-success">Financiado</span>
                                @endif
                            </td>
                            <td>
                                @foreach ($lis->relacion_caja as $lis1)
                                    @if ($lis1->financiamiento_tipo->id==1)
                                        {{ con_separador_comas($lis1->saldo).' Bs' }}
                                        @php
                                            $suma_total_TGN = $suma_total_TGN + $lis1->saldo;
                                        @endphp
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($lis->relacion_caja as $lis1)
                                    @if ($lis1->financiamiento_tipo->id==2)
                                        {{ con_separador_comas($lis1->saldo).' Bs' }}
                                        @php
                                            $suma_total_COP_TRIB = $suma_total_COP_TRIB + $lis1->saldo;
                                        @endphp
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($lis->relacion_caja as $lis1)
                                    @if ($lis1->financiamiento_tipo->id==3)
                                        {{ con_separador_comas($lis1->saldo).' Bs' }}
                                        @php
                                            $suma_total_IDH = $suma_total_IDH + $lis1->saldo;
                                        @endphp
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach ($lis->relacion_caja as $lis1)
                                    @if ($lis1->financiamiento_tipo->id==4)
                                        {{ con_separador_comas($lis1->saldo).' Bs' }}
                                        @php
                                            $suma_total_REC_PROP = $suma_total_REC_PROP + $lis1->saldo;
                                        @endphp
                                    @endif
                                    @php
                                        $suma_total_porine = $suma_total_porine + $lis1->saldo;
                                    @endphp
                                @endforeach
                            </td>
                            <td>
                                {{ con_separador_comas($suma_total_porine).' Bs' }}
                            </td>
                        </tr>
                    @endforeach
                @endif

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" >SUMA TOTAL DE MONTOS ASIGNADOS DE {{ $tipo_carrera_unidad->nombre }} </td>
                    <td>{{ con_separador_comas($suma_total_TGN).' Bs' }}</td>
                    <td>{{ con_separador_comas($suma_total_COP_TRIB).' Bs' }}</td>
                    <td>{{ con_separador_comas($suma_total_IDH).' Bs' }}</td>
                    <td>{{ con_separador_comas($suma_total_REC_PROP).' Bs' }}</td>
                    <td>
                        @php
                            $suma_total_todo = $suma_total_TGN + $suma_total_COP_TRIB + $suma_total_IDH + $suma_total_REC_PROP;
                        @endphp
                        {{ con_separador_comas($suma_total_todo).' Bs' }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
