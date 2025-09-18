@extends('principal')
@section('titulo', 'Formulario Nº 2')
@section('contenido')
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
                <a class="btn btn-outline-secondary"
                    href="{{ route('poa_formulacionPOA', [encriptar($configuracion_formulado->id), encriptar($gestiones->id)]) }}">
                    <i class="bx bx-arrow-back"></i>
                    Inicio
                </a>
                <h3 class="text-primary"></h3>
                <div class=" ms-auto position-relative">
                    <form action="{{ route('pdf_form2') }}" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="id_carreraunidad" value="{{ $carrera_unidad->id }}">
                        <input type="hidden" name="id_configuracion" value="{{ $configuracion_formulado->id }}">
                        <input type="hidden" name="id_gestion" value="{{ $gestiones->id }}">
                        <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#nuevo_carreraUnidadArea"><i class="ri-file-pdf-line"></i> Imprimir PDF</button>
                    </form>
                </div>
            </div>
            <div id="table-responsive">
                <table class="table table-hover" id="debilidad_tabla" style="width: 100%">
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
                                    <a href="{{ route('poa_formAreaEstrategicas', ['formulario1_id' => encriptar($formulario1->id), 'areaEstrategica_id' => encriptar($lis->id)]) }}"
                                        class="btn btn-outline-primary">Ingresar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                <a class="me-2"
                    href="{{ route('fodac_listado', ['id_gestiones' => encriptar($gestiones->id), 'id_formulario1' => encriptar($formulario1->id)]) }}">
                    <button href="submit" class="btn btn-warning">
                        Form N°3
                        <i class="bx bx-arrow-to-right"></i>
                    </button>
                </a>
                <a class=""
                    href="{{ route('poa_form4', ['formulario1_id' => encriptar($formulario1->id), 'formuladoTipo_id' => encriptar($formulado_tipo->id)]) }}">
                    <button type="submit" class="btn btn-primary">
                        Form N°4
                        <i class="bx bx-arrow-to-right"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>


@endsection
