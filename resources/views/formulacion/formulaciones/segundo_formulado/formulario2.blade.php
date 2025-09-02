@extends('principal')
@section('titulo', 'Formulario Nº 2')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_error.css') }}">
    <link rel="stylesheet" href="{{ asset('rodry/estilo_cargando.css') }}">
@endsection
@section('contenido')

    @if ($resultado==0)
        <div id="primero" class="text-center">
            <h1 id="h1_estilo" >Cargando datos..</h1>

            <ul class="cargando">

                <li class="punto1" style="animation-delay:0"></li>
                <li class="punto2" style="animation-delay:.4s"></li>
                <li class="punto3" style="animation-delay:.8s"></li>
                <li class="punto4" style="animation-delay:1.2s"></li>
                <li class="punto5" style="animation-delay:1.6s"></li>
                <li class="punto6" style="animation-delay:2.0s"></li>
                <li class="punto7" style="animation-delay:2.4s"></li>
            </ul>
        </div>

        <div id="segundo" class="text-center" >
            <h1 id="h2_estilo">Datos cargados..</h1>

            <ul class="cargando">
                <button id="btn_segundo" class="learn-more">
                    <span class="circle" aria-hidden="true">
                    <span class="icon arrow"></span>
                    </span>
                    <span class="button-text" onclick="btn_recargarPagina()">Ingresar</span>
                </button>
            </ul>
        </div>
    @else
        <div class="page-title-area">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="page-title">
                            <h5>TIPO : {{ $formulado_tipo->descripcion }}</h5>
                            <h5>FORMULARIO Nº 2 </h5>
                            <h5>GESTIÓN : {{ $gestiones->gestion }}</h5>
                            <h5>{{ $carrera_unidad->nombre_completo }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary"></h3>
                    <div class=" ms-auto position-relative">
                        <form action="{{ route('pdf_form2') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="id_carreraunidad" value="{{ $carrera_unidad->id }}">
                            <input type="hidden" name="id_configuracion" value="{{ $configuracion_formulado->id }}">
                            <input type="hidden" name="id_gestion" value="{{ $gestiones->id }}">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nuevo_carreraUnidadArea"  ><i class="ri-file-pdf-line"></i> Imprimir PDF</button>
                        </form>
                    </div>
                </div>
                <div id="table-responsive" >
                    <table class="table table-striped table-hover" id="debilidad_tabla" style="width: 100%" >
                        <thead>
                            <tr>
                                <th>CÓDIGO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formulario1_areasEstrategicas as $lis)
                                <tr>
                                    <td>{{ $lis->codigo_areas_estrategicas }}</td>
                                    <td>{{ $lis->descripcion }}</td>
                                    <td>
                                        <a href="{{ route('poa_formAreaEstrategicas', ['formulario1_id'=>encriptar($formulario1->id), 'areaEstrategica_id'=>encriptar($lis->id)]) }}"  class="btn btn-outline-primary">Ingresar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif


@endsection
@section('scripts')
    <script>
        setTimeout(() => {
            document.getElementById('primero').style.display = 'none';
            document.getElementById('segundo').style.display = 'block';
        }, 3000);

        function btn_recargarPagina(){
            window.location='';
        }
    </script>
@endsection
