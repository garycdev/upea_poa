@extends('principal')
@section('titulo', 'Formulario Nº 1')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/formulario.css') }}">
    <link rel="stylesheet" href="{{ asset('rodry/estilo_error.css') }}">
    <link rel="stylesheet" href="{{ asset('rodry/estilo_cargando.css') }}">
@endsection
@section('contenido')



    @if ($resultado == 0)
        <div id="primero" class="text-center">
            <h1 id="h1_estilo">Cargando datos..</h1>

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

        <div id="segundo" class="text-center">
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
                            <h5>FORMULARIO Nº 1 </h5>
                            <h5>GESTIÓN : {{ $gestiones->gestion }}</h5>
                            <h5>{{ $carrera_unidad->nombre_completo }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- {{ $formulario1_Existe }} --}}
        <div class="default-table-area">
            <div class="container-fluid">
                <div class="card-box-style">
                    <div class="others-title d-flex align-items-center">
                        <h3 class="text-primary"></h3>
                        <div class=" ms-auto position-relative">
                            <form action="{{ route('pdf_form1') }}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="id_carreraunidad" value="{{ $carrera_unidad->id }}">
                                <input type="hidden" name="id_configuracion" value="{{ $id_configuracion_formulado }}">
                                <input type="hidden" name="id_gestion" value="{{ $gestiones->id }}">
                                <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#nuevo_carreraUnidadArea"><i class="ri-file-pdf-line"></i> Imprimir
                                    FORM. N°1</button>
                            </form>
                        </div>
                    </div>
                    @if ($resultado == 1)
                        <div class="row">
                            <div class="mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <fieldset>
                                    <legend>Fecha realizado</legend>
                                    <div class="alert alert-primary" role="alert">
                                        <h6 class="alert-heading">{{ fecha_literal($formulario1->fecha, 5) }}</h6>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <fieldset>
                                    <legend>Maxima Autoridad</legend>
                                    <div class="alert alert-primary" role="alert">
                                        <h6 class="alert-heading">{{ 'Rector. ' . $formulario1->maxima_autoridad }}</h6>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <fieldset>
                                    <legend>Realizado por : </legend>
                                    <div class="alert alert-primary" role="alert">
                                        <h6 class="alert-heading">
                                            {{-- {{ $tipo_carreraUnidad . ' ' . $realizado_por->nombre . ' ' . $realizado_por->apellido }} --}}
                                            {{ $realizado_por->nombre . ' ' . $realizado_por->apellido }}
                                        </h6>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <fieldset>
                                    <legend>Areas Estrategicas Utilizadas</legend>
                                    @foreach ($formulario1_areasEstrategicas as $lis1)
                                        <ul>
                                            <li>
                                                <p> {{ $lis1->descripcion }} </p>
                                            </li>
                                        </ul>
                                    @endforeach
                                </fieldset>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                                <fieldset>
                                    <legend>Formularios</legend>

                                    <div class="container_rodry">
                                        <button class="card2" href="#"
                                            onclick="editar_formulario1('{{ $formulario1->id }}', '{{ $gestion->id }}')">
                                            <h3 id="titulo_h3">FORM. Nº 1</h3>
                                            <div class="go-corner-edit" href="#">
                                                <div class="go-arrow text-dark"><i class="ri-edit-2-line"></i></div>
                                            </div>
                                        </button>
                                        <a class="card2"
                                            href="{{ route('poaf_fromulario2', ['formulario1_id' => encriptar($formulario1->id), 'formuladoTipo_id' => encriptar($formulado_tipo->id)]) }}">
                                            <h3 id="titulo_h3">FORM. Nº 2</h3>
                                            <div class="go-corner" href="#">
                                                <div class="go-arrow"><i class="ri-eye-line"></i></div>
                                            </div>
                                        </a>

                                        <a class="card2"
                                            href="{{ route('fodac_listado', ['id_gestiones' => encriptar($gestiones->id), 'id_formulario1' => encriptar($formulario1->id)]) }}">
                                            <h3 id="titulo_h3">FORM. Nº 3</h3>
                                            <div class="go-corner" href="#">
                                                <div class="go-arrow"><i class="ri-eye-line"></i></div>
                                            </div>
                                        </a>

                                        <a class="card2"
                                            href="{{ route('poa_form4', ['formulario1_id' => encriptar($formulario1->id), 'formuladoTipo_id' => encriptar($formulado_tipo->id)]) }}">
                                            <h3 id="titulo_h3">FORM. Nº 4</h3>
                                            <div class="go-corner" href="#">
                                                <div class="go-arrow"><i class="ri-eye-line"></i></div>
                                            </div>
                                        </a>

                                        <form action="{{ route('pdf_form5') }}" method="post" target="_blank">
                                            @csrf
                                            <input type="hidden" name="id_carreraunidad"
                                                value="{{ $formulario1->unidadCarrera_id }}">
                                            <input type="hidden" name="id_configuracion"
                                                value="{{ $formulario1->configFormulado_id }}">
                                            <input type="hidden" name="id_gestion" value="{{ $gestiones->id }}">

                                            <button class="card2" type="submit">
                                                <h3 id="titulo_h3">FORM. Nº 5</h3>
                                                <div class="go-corner-pdf" href="#">
                                                    <div class="go-arrow"><i class="ri-file-pdf-line"></i></div>
                                                </div>
                                            </button>
                                        </form>

                                        <form action="{{ route('pdf_form6') }}" method="post" target="_blank">
                                            @csrf
                                            <input type="hidden" name="id_carreraunidad"
                                                value="{{ $formulario1->unidadCarrera_id }}">
                                            <input type="hidden" name="id_configuracion"
                                                value="{{ $formulario1->configFormulado_id }}">
                                            <input type="hidden" name="id_gestion" value="{{ $gestiones->id }}">

                                            <button class="card2" type="submit">
                                                <h3 id="titulo_h3">FORM. Nº 6</h3>
                                                <div class="go-corner-pdf" href="#">
                                                    <div class="go-arrow"><i class="ri-file-pdf-line"></i></div>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <form id="form_primerFormulario" method="post" autocomplete="off">
                                <input type="hidden" name="configuracionFormulado_id"
                                    value="{{ $configuracion_poa->id }}">
                                <input type="hidden" name="gestiones_id" value="{{ $gestiones->id }}">
                                <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <fieldset>
                                        <legend>Ingrese nombre de la Maxima Autoridad (RECTOR)</legend>
                                        <input type="text" name="maxima_autoridad" id="maxima_autoridad"
                                            class="form-control"
                                            placeholder="Ingrese el nombre de la Maxima Autoridad de la Universidad Pública de el Alto">
                                        <div id="_maxima_autoridad"></div>
                                    </fieldset>
                                </div>
                                <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <fieldset>
                                        <legend>Seleccione las Áreas estratégicas a usar</legend>
                                        <table class="table text-justify">
                                            <tbody>
                                                @forelse ($areas_estrategicas as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="{{ $value->id }}" name="areas_estrategicas1[]"
                                                                    value="{{ $value->id }}">
                                                                <label class="form-check-label"
                                                                    for="{{ $value->id }}">
                                                                    {{ $value->descripcion }}
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    --------
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                            </form>

                            <div class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    id="btn_guardarPrimerFormulario"> <i class="bx bxs-save" id="icono_rodry"></i>
                                    Guardar primer formulario</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!--MODAL PARA EDITAR EL FORMULARIO Nº 1-->
        <div class="modal slide" id="editar_formulario1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">EDITAR FORMULARIO Nº 1</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal_editarFormularioNº1">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarFormuladoEditar"> <i
                                class="bx bxs-save" id="icono_rodry"></i> Guardar primer formulario</button>
                    </div>
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

        function btn_recargarPagina() {
            window.location = '';
        }
        //par aeditar el formulario Nº1
        function editar_formulario1(id_formulario, id_gestion) {
            $.ajax({
                type: "POST",
                url: "{{ route('poa_formulario1Editar') }}",
                data: {
                    id_formulario: id_formulario,
                    id_gestion: id_gestion,
                },
                success: function(data) {
                    $('#editar_formulario1').modal('show');
                    document.getElementById('modal_editarFormularioNº1').innerHTML = data;
                }
            });
        }
        //para guardar el primer formulado
        $(document).on('click', '#btn_guardarFormuladoEditar', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_primerFormularioEditar'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_form1EditarGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    document.getElementById('_maxima_autoridad_').innerHTML = '';
                    if (data.tipo == 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = `<p id="error_in" >` + obj[
                                key] + `</p>`;
                        }
                    }
                    if (data.tipo === 'success') {
                        $('#editar_formulario1').modal('hide');
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location = '';
                        }, 1500);
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
    </script>
@endsection
