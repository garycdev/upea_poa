<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario Nº 1</title>
    <style>
        .my-table {
            border-collapse: collapse;
            width: 100%;
        }
        .my-table th, .my-table td {
            border: 1px solid black;
            padding: 30px;
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
            top: -20;
            right: -25px;
        }

        .formulario_esquina{
            position: absolute;
        }
        .form-esquina-top-rigth{
            top: -47;
            right: -25px;
        }

        .form-esquina-top-left{
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
        .text-primary{
            padding-top: 0px;
            margin: 2px;
        }
        .text-secundario{
            padding-top: 0px;
            margin-top: -2px;
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

        <div style="text-align: center; padding-top:10% ">
            <h4 class="text-primary">POA {{ $formulario1[0]->configuracion_formulado->formulado_tipo->descripcion.' '.$formulario1[0]->configuracion_formulado->gestiones->gestion }}</h4>
            <h4 class="text-primary">OBJETIVOS DE GESTION DE LA UNIVERSIDAD</h4>
            <h6 class="text-primary" >UNIDAD ACADÉMICA : {{ $carrera_unidad->nombre_completo }}</h6>
            <div class=" ms-auto position-relative">
            </div>
        </div>

        <img src="{{ $imagen_upea }}" class="img-esquina img-esquina-top-right">

        <h5 class="formulario_esquina form-esquina-top-left" >IMP {{ fecha_literal(date('Y-m-d'),4) }}</h5>
        <h5 class="formulario_esquina form-esquina-top-rigth" >FORMULARIO Nº 1</h5>

        <h5 class="text-secundario"> CÓDIGO :  {{ $formulario1[0]->configuracion_formulado->codigo }}</h5>
        <h5 class="text-secundario"> SIGLA : UPEA </h5>
        <h5 class="text-secundario"> FECHA : {{ fecha_literal($formulario1[0]->fecha,5) }}</h5>

        <div class="table-responsive">
            <table class="my-table" style="width: 100%; font-size:9px">
                <thead >
                    <tr>
                        <th>CODIGO</th>
                        <th>DESCRIPCION DE ÁREA ESTRATÉGICA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulario1[0]->relacion_areasEstrategicas as $lis)
                        <tr>
                            <td>{{ $lis->codigo_areas_estrategicas }}</td>
                            <td>{{ $lis->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>

        <div class="table-responsive">
            <table class="my-table" style="width: 100%; font-size:9px">
                <thead>
                    <tr>
                        <th width="30%" >RESPONSABLE DE LA INFORMACIÓN : </th>
                        <th width="20%">NOMBRE</th>
                        <th width="20%">CARGO</th>
                        <th width="30%">FIRMA</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $cargo = '';
                        if($carrera_unidad->tipo_Carrera_UnidadaArea->nombre == 'CARRERAS'){
                            $cargo = 'DIRECTOR DE LA: . ';
                        }
                        if($carrera_unidad->tipo_Carrera_UnidadaArea->nombre == 'UNIDADES ADMINISTRATIVAS'){
                            $cargo = 'JEFE DE UNIDAD DE : . ';
                        }
                        if($carrera_unidad->tipo_Carrera_UnidadaArea->nombre == 'AREAS'){
                            $cargo = 'DECANO DE AREA DE  : . ';
                        }
                    @endphp

                    <tr>
                        <td>ELABORADO POR : </td>
                        <td>  {{ ' Lic. '.$usuario_formulado1->nombre.' '.$usuario_formulado1->apellido }}</td>
                        <td>{{ $cargo.' '.$carrera_unidad->nombre_completo }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Vº Bº MAXIMA AUTORIDAD EJECUTIVA : </td>
                        <td>Rector {{ $formulario1[0]->maxima_autoridad }}</td>
                        <td>RECTOR - UPEA</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>


</body>
</html>
