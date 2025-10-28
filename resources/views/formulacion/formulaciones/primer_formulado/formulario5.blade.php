@extends('principal')
@section('titulo', 'Formulario Nº 5')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="page-title">
                        <h5>TIPO : {{ $tipo_formulado->descripcion }}</h5>
                        <h5>FORMULARIO Nº 5 </h5>
                        <h5>GESTIÓN : {{ $gestiones->gestion }}</h5>
                        <h5>{{ $carrera_unidad->nombre_completo }}</h5>
                        <h5>ÁREA ESTRATÉGICA : {{ $areas_estrategicas->descripcion }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <a class="me-5 btn btn-outline-secondary"
                        href="{{ route('poa_formulacionPOA', [encriptar($formulario2_detalle->configFormulado_id), encriptar($gestiones->id)]) }}">
                        <i class="bx bx-arrow-back"></i>
                        Inicio
                    </a>
                    <h3 class="text-primary">FORMULARIO Nº 5 (Presupuesto asignado a la operación)</h3>
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#nuevo_formulario5"><i class="bx bxs-add-to-queue"></i> Nuevo registro</button>
                    </div>
                </div>

                <div class="row d-flex justify-content-center align-items-center">
                    {{-- <div class="col-sm-12 col-md-12 col-lg-3 col-lg-3">
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading">Politica Institucional</h6>
                            <p> <strong>{{ '['.$formulario2_detalle->politica_desarrollo_pei[0]->codigo.'] : ' }}</strong> {{ $formulario2_detalle->politica_desarrollo_pei[0]->descripcion }} </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-3 col-lg-3">
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading">Objetivo estrategico del (SUB)</h6>
                            <p> <strong>{{ '['.$formulario2_detalle->objetivo_estrategico_sub[0]->codigo.'] : ' }}</strong> {{ $formulario2_detalle->objetivo_estrategico_sub[0]->descripcion }} </p>
                        </div>
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading">Objetivo Institucional</h6>
                            <p> <strong>{{ '['.$formulario2_detalle->objetivo_institucional[0]->codigo.'] : ' }}</strong> {{ $formulario2_detalle->objetivo_institucional[0]->descripcion }} </p>
                        </div>
                    </div> --}}
                    <div class="col-sm-12 col-md-12 col-lg-6 col-lg-6">
                        <div class="alert alert-success" role="alert">
                            <h6 class="alert-heading">Indicador Estrategico</h6>
                            <p> <strong>{{ '[' . $formulario2_detalle->indicador->codigo . '] : ' }}</strong>
                                {{ $formulario2_detalle->indicador->descripcion }} </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-lg-6">
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading">Montos Asignados</h6>
                            @php
                                $suma_total = 0;
                            @endphp
                            @foreach ($formulario4->asignacion_monto_f4 as $lis)
                                @php
                                    $suma_total = $suma_total + $lis->monto_asignado;
                                @endphp
                                <ul>
                                    <li> <strong> {{ con_separador_comas($lis->monto_asignado) . ' Bs ' }} </strong>
                                        {{ ' [ ' . $lis->financiamiento_tipo->sigla . ' ] ' . '[' . $lis->financiamiento_tipo->descripcion . ']' }}
                                    </li>
                                </ul>
                            @endforeach
                            <h5 class="alert-heading">Total: {{ con_separador_comas($suma_total) . ' Bs' }} </h5>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary"></h3>
                    <div class=" ms-auto position-relative">
                        <form action="{{ route('pdf_form5') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="id_carreraunidad" value="{{ $carrera_unidad->id }}">
                            <input type="hidden" name="id_configuracion" value="{{ $formulario4->configFormulado_id }}">
                            <input type="hidden" name="id_gestion" value="{{ $gestiones->id }}">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#nuevo_carreraUnidadArea"><i class="ri-file-pdf-line"></i> Imprimir
                                PDF</button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-responsive  text-center table-bordered table-hover"
                        style="width:100%; font-size: 10px;">
                        <thead>
                            <tr>
                                <th rowspan="2">ACCIÓN</th>
                                <th rowspan="2">CODIGO ARTICULACIÓN <br>(Objetivos)</th>
                                <th rowspan="2">CODIGO INDICADOR <br>(Resultado Esperado)</th>
                                <th rowspan="2">OPERACIONES</th>
                                <th rowspan="2">TIPO DE<br>OPERACIONES</th>
                                <th colspan="3">PROGRAMA SEMESTRAL DE LA OPERACIÓN <br></th>
                                <th colspan="2">PERIODO DE EJECUCIÓN</th>
                                <th rowspan="2">REQUERIMIENTOS</th>
                                <th rowspan="2">LISTAR REQUERIMIENTOS</th>
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
                            {{-- {{ $formulario4 }} --}}
                            @foreach ($formulario4->formulario5_f4 as $lis)
                                <tr>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm"
                                            onclick="editar_formulario5('{{ $lis->id }}')"><i
                                                class="ri-edit-2-fill"></i></button>
                                    </td>
                                    <td>
                                        {{ $areas_estrategicas->codigo_areas_estrategicas . ' . ' . $formulario2_detalle->politica_desarrollo_pei[0]->codigo . ' . ' . $formulario2_detalle->objetivo_institucional[0]->codigo . '.' }}
                                    </td>
                                    <td>
                                        {{ $areas_estrategicas->codigo_areas_estrategicas . ' . ' . $formulario2_detalle->politica_desarrollo_pei[0]->codigo . ' . ' . $formulario2_detalle->objetivo_institucional[0]->codigo . ' . ' . $formulario2_detalle->indicador->codigo . '.' }}
                                    </td>
                                    <td>{{ $lis->operacion->descripcion }}</td>
                                    <td>{{ $lis->operacion->tipo_operacion->nombre }}</td>
                                    <td>{{ $lis->primer_semestre }}</td>
                                    <td>{{ $lis->segundo_semestre }}</td>
                                    <td>{{ $lis->total }}</td>
                                    <td>{{ fecha_literal($lis->desde, 4) }}</td>
                                    <td>{{ fecha_literal($lis->hasta, 4) }}</td>
                                    <td>
                                        <button class="btn btn-outline-primary"
                                            onclick="asignar_requerimientos('{{ $lis->id }}')">Agregar</button>
                                    </td>
                                    <td>
                                        <a href="{{ route('req_listar', ['id' => encriptar($lis->id)]) }}"
                                            class="btn btn-outline-primary">Listar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    <a class="me-2"
                        href="{{ route('poa_formulario2', ['formulario1_id' => encriptar($formulario2_detalle->formulario1_id), 'formuladoTipo_id' => encriptar($tipo_formulado->id)]) }}">
                        <button href="submit" class="btn btn-primary">
                            <i class="bx bx-arrow-to-left"></i>
                            Form N°2
                        </button>
                    </a>
                    <a class=""
                        href="{{ route('poa_form4AreasEstrategicas', ['formulario1_id' => encriptar($formulario2_detalle->formulario1_id), 'areaEstrategica_id' => encriptar($areas_estrategicas->id)]) }}">
                        <button href="submit" class="btn btn-primary">
                            <i class="bx bx-arrow-to-left"></i>
                            Form N°4
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO FORMULARIO #5 --}}
    <div class="modal slide" id="nuevo_formulario5" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO REGISTRO DEL FORMULARIO Nº 5 (Operaciones) </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrarModalf5()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_formulario5" method="POST" autocomplete="off">
                        <input type="hidden" name="formulario4_id" value="{{ $formulario4->id }}">
                        <input type="hidden" name="configFormulado" value="{{ $formulario4->configFormulado_id }}">
                        <input type="hidden" name="gestiones_id" value="{{ $gestiones->id }}">
                        <input type="hidden" name="area_estrategica" value="{{ $areas_estrategicas->id }}">

                        <fieldset>
                            <legend class="text-center">OPERACIONES</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 mb-2">
                                    <label for="tipo" class="col-form-label">Seleccione</label>
                                    <select name="tipo" id="tipo" class="form-select select2"
                                        onchange="seleccionar_describir(this.value)">
                                        <option selected disabled>[SELECCIONE]</option>
                                        <option value="seleccione">Seleccione Operacion</option>
                                        <option value="ingrese">ingrese Operacion</option>
                                    </select>
                                    <div id="_tipo"></div>
                                </div>
                                {{-- aqui va ir el select2 --}}
                                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="operacion" class="col-form-label">Operacion</label>
                                        <select name="operacion" id="operacion" class="form-select select2"
                                            @disabled(true)>
                                            <option value="selected" selected disabled>[SELECCIONE OPERACIÓN]</option>
                                            @foreach ($operaciones as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <label for="descripcion_operacion" class="col-form-label">Describa la
                                        Operación</label>
                                    <textarea name="descripcion_operacion" id="descripcion_operacion" cols="5" rows="3"
                                        class="form-control" @disabled(true)></textarea>
                                    <div id="_descripcion_operacion"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="tipo_operacion" class="col-form-label">Tipo Operacion</label>
                                        <select name="tipo_operacion" id="tipo_operacion" class="form-select select2"
                                            @disabled(true)>
                                            <option selected disabled value="selected">[SELECCIONE TIPO DE OPERACIÓN]
                                            </option>
                                            @foreach ($tipo_operacion as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div id="tipo_operacion"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-center">PROGRAMACIÓN SEMESTRAL DE LA OPERACIÓN</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="primer_semestre" class="form-label">Primer Semestre</label>
                                        <input type="text" class="form-control" id="primer_semestre"
                                            name="primer_semestre" placeholder="Descripción de 1er semestre"
                                            maxlength="4">
                                        <div id="_primer_semestre"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="segundo_semestre" class="form-label">Segundo Semestre</label>
                                        <input type="text" class="form-control" id="segundo_semestre"
                                            name="segundo_semestre" placeholder="Descripción de 2do Semestre"
                                            maxlength="4">
                                        <div id="_segundo_semestre"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="total" class="form-label">Total</label>
                                        <input type="text" class="form-control" id="total" name="total"
                                            placeholder="Descripción de Total" maxlength="4">
                                        <div id="_total"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="cerrarModalf5()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarF5"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR FORMULARIO #5 --}}
    <div class="modal slide" id="editar_formulario5" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR REGISTRO DEL FORMULARIO Nº 5 (Operaciones) </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrarModalf5()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_editar_formulario5" method="POST" autocomplete="off">
                        <input type="hidden" name="formulario5_id" id="formulario5_id">
                        <fieldset>
                            <legend class="text-center">OPERACIONES</legend>
                            <div class="row">
                                {{-- aqui va ir el select2 --}}
                                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 mb-2">
                                    <div class="mb-2">
                                        <label for="operacion_" class="col-form-label">Operacion</label>
                                        <select name="operacion_" id="operacion_" class="form-select select2_segundo">
                                            <option value="selected" selected disabled>[SELECCIONE OPERACIÓN]</option>
                                            @foreach ($operaciones as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                            @endforeach
                                        </select>
                                        <div id="_operacion_"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="tipo_operacion_" class="col-form-label">Tipo Operacion</label>
                                        <select name="tipo_operacion_" id="tipo_operacion_"
                                            class="form-select select2_segundo">
                                            <option selected disabled value="selected">[SELECCIONE TIPO DE OPERACIÓN]
                                            </option>
                                            @foreach ($tipo_operacion as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div id="_tipo_operacion_"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>PROGRAMACIÓN SEMESTRAL DE LA OPERACIÓN</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="primer_semestre_" class="form-label">Primer Semestre</label>
                                        <input type="text" class="form-control" id="primer_semestre_"
                                            name="primer_semestre_" placeholder="Descripción de 1er semestre"
                                            maxlength="4">
                                        <div id="_primer_semestre_"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="segundo_semestre_" class="form-label">Segundo Semestre</label>
                                        <input type="text" class="form-control" id="segundo_semestre_"
                                            name="segundo_semestre_" placeholder="Descripción de 2do Semestre"
                                            maxlength="4">
                                        <div id="_segundo_semestre_"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="total_" class="form-label">Total</label>
                                        <input type="text" class="form-control" id="total_" name="total_"
                                            placeholder="Descripción de Total" maxlength="4">
                                        <div id="_total_"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="cerrarModalf5()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarF5_editado"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL PARA ASIGNAR LOS REQUERIMIENTOS #5 --}}
    <div class="modal slide" id="asignar_requerimientosf5" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO REGISTRO DEL FORMULARIO Nº 5 (Requerimientos) </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrar_modal_requerimiento()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_formulario5_operacion" method="POST" autocomplete="off">
                        <input type="hidden" name="formulario4_id_requerimiento" value="{{ $formulario4->id }}">
                        <input type="hidden" name="formulario5_id_requerimientos" id="formulario5_id_requerimientos">
                        <fieldset>
                            <legend class="text-center">BIEN O SERVICIO</legend>
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
                                    <label for="clasificador_presupuestario" class="col-form-label">Clasificadores
                                        Presupuestarios</label>
                                    <select name="clasificador_presupuestario" id="clasificador_presupuestario"
                                        class="form-select select2_tercero"
                                        onchange="mostrar_clasificador_ver(this.value)">
                                        <option value="selected" selected disabled>[SELECCIONE CLASIFICADOR]</option>
                                        @foreach ($union_tres as $lis)
                                            <option value="{{ $lis->id . '_' . $lis->origen }}">
                                                [{{ $lis->codigo }}] {{ $lis->titulo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="_clasificador_presupuestario"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2 text-center"
                                    id="descripcion_clasificador_html">

                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-center"> ¡ ASIGNACIÓN PRESUPUESTARIA DISPONIBLE !</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
                                    <div class="mb-2">
                                        <label for="tipo_financiamiento_" class="form-label">Tipo de
                                            Financiamiento</label>
                                        <select name="tipo_financiamiento_" id="tipo_financiamiento_"
                                            class="form-select select2_tercero"
                                            onchange="verificar_monto_asignado(this.value)">
                                            <option value="selected" selected disabled>[SELECCIONE TIPO DE FINANCIAMIENTO]
                                            </option>
                                        </select>
                                        <div id="_tipo_financiamiento_"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
                                    <div class="mb-2" id="monto_actual_asignadof4">
                                    </div>
                                </div>
                                <input type="hidden" name="tipo_fina_id" id="tipo_fina_id">
                                <input type="hidden" name="monto_actual_asignado_val" id="monto_actual_asignado_val">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-center">PROGRAMACIÓN SEMESTRAL DE LA OPERACIÓN</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="medida" class="form-label">Medida</label>
                                        <select name="medida" id="medida" class="form-select select2_tercero"
                                            onchange="validar_medidaf4(this.value)" @disabled(true)>
                                            <option value="selected" selected disabled>[SELECCIONE MEDIDA]</option>
                                            @foreach ($medida as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                            @endforeach
                                        </select>
                                        <div id="_medida"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type="text" class="form-control" id="cantidad" name="cantidad"
                                            placeholder="Ingrese la cantidad" maxlength="7"
                                            onkeypress="return soloNumeros(event)" @disabled(true)>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="precio_unitario" class="form-label">Precio unitario</label>
                                        <input type="text" class="form-control monto_number" id="precio_unitario"
                                            name="precio_unitario" placeholder="Ingrese el precio unitario"
                                            maxlength="15" onkeyup="validar_monto_precionUnitario(this.value)"
                                            @disabled(true)>
                                        <div id="_precio_unitario"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="total_presupuesto" class="form-label">Total Presupuesto</label>
                                        <input type="text" class="form-control monto_number" id="total_presupuesto"
                                            name="total_presupuesto" onkeyup="validar_monto_asignandoSob(this.value)"
                                            placeholder="Total Presupuesto" @disabled(true)>
                                        <div id="_total_presupuesto"></div>
                                    </div>
                                </div>
                                <input type="hidden" class="monto_number" id="total_presupuesto_env"
                                    name="total_presupuesto_env">
                                <input type="hidden" class="monto_number" id="monto_sobrante_presupuesto"
                                    name="monto_sobrante_presupuesto">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-center">FECHA EN LA QUE SE REQUIERE</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
                                    <div class="mb-2">
                                        <label for="mes" class="form-label">Mes</label>
                                        <select name="mes" id="mes" class="form-select select2_tercero"
                                            onchange="validar_gestiondia(this.value)">
                                            <option value="selected" selected disabled>[SELECCIONE MES]</option>
                                            <option value="1">ENERO</option>
                                            <option value="2">FEBRERO</option>
                                            <option value="3">MARZO</option>
                                            <option value="4">ABRIL</option>
                                            <option value="5">MAYO</option>
                                            <option value="6">JUNIO</option>
                                            <option value="7">JULIO</option>
                                            <option value="8">AGOSTO</option>
                                            <option value="9">SEPTIEMBRE</option>
                                            <option value="10">OCTUBRE</option>
                                            <option value="11">NOVIEMBRE</option>
                                            <option value="12">DICIEMBRE</option>
                                        </select>
                                        <div id="_mes"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
                                    <div class="mb-2">
                                        <label for="dia" class="form-label">Dia</label>
                                        <select name="dia" id="dia" class="form-select select2_tercero">
                                            <option value="selected" selected disabled>[SELECCIONE DIA]</option>
                                            {{-- @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor --}}
                                        </select>
                                        <div id="_dia"></div>
                                    </div>
                                </div>
                                <input type="hidden" id="gestion" name="gestion" value="{{ $gestiones->gestion }}">
                            </div>
                        </fieldset>
                    </form>

                    <fieldset>
                        <legend class="text-center">LISTADO DE DE LOS REQUERIMIENTOS</legend>
                        <div class="row text-center">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
                                <div class="mb-2" id="">
                                    <div class="table-responsive" id="listar_html_requerimientos">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="cerrar_modal_requerimiento()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarRequerimiento"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        select2_rodry('#nuevo_formulario5');

        //para validar si escribira o seleccionara la operacion
        function seleccionar_describir(valor) {
            if (valor === 'seleccione') {
                document.getElementById('operacion').disabled = false;
                document.getElementById('descripcion_operacion').disabled = true;
                document.getElementById('tipo_operacion').disabled = true;
                document.getElementById('descripcion_operacion').value = '';
                $("#tipo_operacion").val("selected").trigger('change');
                $("#operacion").val("selected").trigger('change');
            } else if (valor === 'ingrese') {
                document.getElementById('operacion').disabled = true;
                document.getElementById('descripcion_operacion').disabled = false;
                document.getElementById('tipo_operacion').disabled = false;
                $("#tipo_operacion").val("selected").trigger('change');
                $("#operacion").val("selected").trigger('change');
            }
        }
        //para vaciar el modal
        function cerrarModalf5() {
            document.getElementById('operacion').disabled = true;
            document.getElementById('descripcion_operacion').disabled = true;
            document.getElementById('tipo_operacion').disabled = true;
            document.getElementById('descripcion_operacion').value = '';
            $("#tipo_operacion").val("selected").trigger('change');
            $("#operacion").val("selected").trigger('change');
            document.getElementById('primer_semestre').value = '';
            document.getElementById('segundo_semestre').value = '';
            document.getElementById('total').value = '';
            vaciar_errores_f5();
        }
        //para guardar el formulario 5
        $(document).on('click', '#btn_guardarF5', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_formulario5'));
            let tipo = document.getElementById('tipo').value;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro con los datos ingresados no podra editar la operación?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Seguro!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('poa_guardar_formulario5') }}",
                        data: datos,
                        dataType: "JSON",
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            vaciar_errores_f5();
                            if (data.tipo == 'errores') {
                                let obj = data.mensaje;
                                for (let key in obj) {
                                    document.getElementById('_' + key).innerHTML =
                                        `<p id="error_in" >` + obj[key] + `</p>`;
                                }
                            }
                            if (data.tipo == 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                document.getElementById('btn_guardarF5').disabled = true;
                                setTimeout(() => {
                                    $('#nuevo_formulario5').modal('hide');
                                    window.location = '';
                                }, 1500);
                            }
                            if (data.tipo == 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            })
        });
        //para vacair los errores del focmrulario 5
        function vaciar_errores_f5() {
            document.getElementById('_tipo').innerHTML = '';
            document.getElementById('_primer_semestre').innerHTML = '';
            document.getElementById('_segundo_semestre').innerHTML = '';
            document.getElementById('_total').innerHTML = '';
        }

        //para la parte de editar
        segundo_select2('#editar_formulario5');
        //para editar el formulario Nº5
        function editar_formulario5(id) {
            vaciar_errores_f5_editar();
            $.ajax({
                type: "POST",
                url: "{{ route('poa_editar_formulario5') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    if (data.tipo === 'success') {
                        $('#editar_formulario5').modal('show');
                        document.getElementById('formulario5_id').value = data.mensaje.id;
                        $('#operacion_').val(data.mensaje.operacion_id).trigger('change');
                        $('#tipo_operacion_').val(data.mensaje.operacion.tipo_operacion_id).trigger('change');
                        document.getElementById('primer_semestre_').value = data.mensaje.primer_semestre;
                        document.getElementById('segundo_semestre_').value = data.mensaje.segundo_semestre;
                        document.getElementById('total_').value = data.mensaje.total;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para guardar el fomrulario 5 editado
        $(document).on('click', '#btn_guardarF5_editado', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_editar_formulario5'));
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro con los datos ingresados?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Seguro!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('poa_editar_guardar_formulario5') }}",
                        data: datos,
                        dataType: "JSON",
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            vaciar_errores_f5_editar();
                            if (data.tipo == 'errores') {
                                let obj = data.mensaje;
                                for (let key in obj) {
                                    document.getElementById('_' + key).innerHTML =
                                        `<p id="error_in" >` + obj[key] + `</p>`;
                                }
                            }
                            if (data.tipo == 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                document.getElementById('btn_guardarF5_editado').disabled =
                                    true;
                                setTimeout(() => {
                                    $('#editar_formulario5').modal('hide');
                                    window.location = '';
                                }, 1500);
                            }
                            if (data.tipo == 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            })
        });

        function vaciar_errores_f5_editar() {
            document.getElementById('_operacion_').innerHTML = '';
            document.getElementById('_tipo_operacion_').innerHTML = '';
            document.getElementById('_primer_semestre_').innerHTML = '';
            document.getElementById('_segundo_semestre_').innerHTML = '';
            document.getElementById('_total_').innerHTML = '';
        }

        //PARA LA PARTE DE ASIGNACION DE REQUERIMIENTOS
        //aqui agarramos id_formulario4
        let formulario4_idf5 = {{ $formulario4->id }};
        tercero_select2('#asignar_requerimientosf5');

        function asignar_requerimientos(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('poa_listar_financiamientof4') }}",
                data: {
                    id: id,
                    formulario4_idf5: formulario4_idf5,
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        vaciar_errores_requerimientos();
                        $('#asignar_requerimientosf5').modal('show');
                        $('#clasificador_presupuestario').val('selected').trigger('change');
                        document.getElementById('formulario5_id_requerimientos').value = id;
                        document.getElementById('descripcion_clasificador_html').innerHTML = '';
                        document.getElementById('monto_actual_asignadof4').innerHTML = '';
                        document.getElementById('monto_actual_asignado_val').value = '';
                        document.getElementById('total_presupuesto').disabled = true;
                        document.getElementById('total_presupuesto').value = '';
                        document.getElementById('cantidad').value = '';
                        document.getElementById('tipo_fina_id').value = '';
                        document.getElementById('precio_unitario').value = '';
                        document.getElementById('total_presupuesto_env').value = '';
                        document.getElementById('monto_sobrante_presupuesto').value = '';
                        $("#medida").val("selected").trigger('change');
                        // $("#mes").val("selected").trigger('change');
                        // $("#dia").val("selected").trigger('change');
                        $('#tipo_financiamiento_').empty().append(
                            '<option selected disabled>[SELECCIONE TIPO DE FINANCIAMIENTO]</option>'
                        );
                        let asignacion_m = data.formulario4.asignacion_monto_f4;
                        asignacion_m.forEach(value => {
                            $('#tipo_financiamiento_').append('<option value = "' + value.id + '">' +
                                '[' + value.financiamiento_tipo.sigla + ']' + value
                                .financiamiento_tipo.descripcion + '</option>');
                        });
                        habilidar_desabilitar(true);


                        //para listar los requerimientos
                        $.ajax({
                            type: "POST",
                            url: "{{ route('poa_listar_requerimientos') }}",
                            data: {
                                id: id,
                                formulario4_idf5: formulario4_idf5,
                            },
                            success: function(res) {
                                document.getElementById('listar_html_requerimientos').innerHTML =
                                    res;
                            }
                        });
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        //para mostrar el clasificador
        function mostrar_clasificador_ver(valor) {
            if (valor !== 'selected') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('poa_f5_buscar_clasificador') }}",
                    data: {
                        valor: valor
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.tipo === 'success') {
                            let valor_html = document.getElementById('descripcion_clasificador_html');
                            console.log(data);

                            switch (data.valor_deinido) {
                                case 3:
                                    valor_html.innerHTML = `
                                        <label for=""></label>
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <strong> Clasificador Nº ` + data.mensaje.clasificador_tercero.codigo + `</strong>
                                            <hr>
                                            <p>${data.mensaje.clasificador_tercero.descripcion ? data.mensaje.clasificador_tercero.descripcion : data.mensaje.clasificador_tercero.titulo}</p>
                                        </div>
                                    `;
                                    break;

                                case 4:
                                    valor_html.innerHTML = `
                                        <label for=""></label>
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <strong> Clasificador Nº ` + data.mensaje.clasificador_cuarto.codigo + `</strong>
                                            <hr>
                                            <p>${data.mensaje.clasificador_cuarto.descripcion ? data.mensaje.clasificador_cuarto.descripcion : data.mensaje.clasificador_cuarto.titulo}</p>
                                        </div>
                                    `;
                                    break;

                                case 5:
                                    valor_html.innerHTML = `
                                        <label for=""></label>
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <strong> Clasificador Nº ` + data.mensaje.clasificador_quinto.codigo + `</strong>
                                            <hr>
                                            <p>${data.mensaje.clasificador_quinto.descripcion ? data.mensaje.clasificador_quinto.descripcion : data.mensaje.clasificador_quinto.titulo}</p>
                                        </div>
                                    `;
                                    break;
                            }
                        }
                        if (data.tipo === 'error') {
                            alerta_top(data.tipo, data.mensaje);
                        }
                    }
                });
            }
        }

        //para ver el monto asignado
        function verificar_monto_asignado(id_asignacion) {
            $.ajax({
                type: "POST",
                url: "{{ route('poa_mostrar_monto_actualAf4') }}",
                data: {
                    id_asignacion: id_asignacion
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        document.getElementById('monto_actual_asignadof4').innerHTML = `
                            <label for="" class="form-label"></label>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>` + data.monto_asignado_c + ' Bs' + `</strong>
                            </div>
                        `;
                        document.getElementById('monto_actual_asignado_val').value = data.monto_asignado_c;
                        habilidar_desabilitar(false);
                        document.getElementById('tipo_fina_id').value = data.financiamiento_t.id;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        function habilidar_desabilitar(valor) {
            //habilitamos los que estan desabilitados
            document.getElementById('medida').disabled = valor;
            document.getElementById('cantidad').disabled = valor;
            document.getElementById('precio_unitario').disabled = valor;
        }

        //para validar la medida
        function validar_medidaf4(valor) {
            if (valor !== 'selected') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('poa_listar_medida') }}",
                    data: {
                        valor: valor
                    },
                    dataType: "JSON",
                    success: function(data) {
                        let unidad_name = data.mensaje.nombre;
                        let input_cantidad = document.getElementById('cantidad');
                        let input_precio_unitario = document.getElementById('precio_unitario');
                        let input_total_presupuesto = document.getElementById('total_presupuesto');

                        document.getElementById('total_presupuesto_env').value = '';
                        document.getElementById('monto_sobrante_presupuesto').value = '';

                        switch (unidad_name) {
                            case 'SIN REQUERIMIENTO':
                                input_cantidad.readOnly = true;
                                input_cantidad.value = 'sin/requerimiento';
                                input_precio_unitario.readOnly = true;
                                input_precio_unitario.value = 'sin/requerimiento';
                                input_total_presupuesto.disabled = false;
                                input_total_presupuesto.value = '';
                                break;

                            case 'MESES':
                                input_cantidad.readOnly = true;
                                input_cantidad.value = 12;
                                input_precio_unitario.readOnly = false;
                                input_precio_unitario.value = '';
                                input_total_presupuesto.value = '';
                                break;

                            case 'ANUAL':
                                input_cantidad.readOnly = true;
                                input_cantidad.value = 1;
                                input_precio_unitario.readOnly = false;
                                input_precio_unitario.value = '';
                                input_total_presupuesto.disabled = true;
                                input_total_presupuesto.value = '';
                                break;

                            default:
                                input_cantidad.readOnly = false;
                                input_cantidad.value = '';
                                input_precio_unitario.readOnly = false;
                                input_precio_unitario.value = '';
                                input_total_presupuesto.disabled = true;
                                input_total_presupuesto.value = '';
                                break;
                        }
                    }
                });
            }
        }
        //para vlidar montos
        function validar_monto_asignandoSob(monto) {
            if (monto) {
                let monto_seleccionado = document.getElementById('monto_actual_asignado_val').value;
                let monto_validado = monto_validado_enviado(monto);
                $.ajax({
                    type: "POST",
                    url: "{{ route('poa_validar_montoIngresado') }}",
                    data: {
                        monto_validado: monto_validado,
                        monto_seleccionado: monto_seleccionado,
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.tipo === 'success') {
                            document.getElementById('total_presupuesto_env').value = monto_validado;
                            document.getElementById('monto_sobrante_presupuesto').value = data
                                .monto_sobrante_comas;
                        }
                        if (data.tipo === 'error') {
                            alerta_top(data.tipo, data.mensaje);
                            document.getElementById('total_presupuesto').value = '';
                            document.getElementById('total_presupuesto_env').value = '';
                            document.getElementById('monto_sobrante_presupuesto').value = '';
                        }
                    }
                });
            }
        }
        //para validar y multiplicar cada valor
        function validar_monto_precionUnitario(monto) {
            let inp_cantidad = document.getElementById('cantidad').value;
            let monto_seleccionado = document.getElementById('monto_actual_asignado_val').value;
            let medida = document.getElementById('medida').value;

            if (medida !== 'selected') {
                if (inp_cantidad != '') {
                    if (monto) {
                        let monto_validado = monto_validado_enviado(monto);
                        $.ajax({
                            type: "POST",
                            url: "{{ route('poa_validar_montoIngresadoMulti') }}",
                            data: {
                                inp_cantidad: inp_cantidad,
                                monto_seleccionado: monto_seleccionado,
                                monto_validado: monto_validado,
                            },
                            dataType: "JSON",
                            success: function(data) {
                                if (data.tipo === 'success') {
                                    document.getElementById('total_presupuesto').value = data.multiplicado;
                                    document.getElementById('total_presupuesto_env').value = data.multiplicado;
                                    document.getElementById('monto_sobrante_presupuesto').value = data
                                        .monto_sobrante_comas;
                                }
                                if (data.tipo === 'error') {
                                    document.getElementById('total_presupuesto').value = '';
                                    document.getElementById('total_presupuesto_env').value = '';
                                    document.getElementById('monto_sobrante_presupuesto').value = '';
                                    document.getElementById('precio_unitario').value = '';
                                    alerta_top(data.tipo, data.mensaje);
                                }
                            }
                        });
                    } else {
                        document.getElementById('precio_unitario').value = '';
                        document.getElementById('total_presupuesto').value = '';
                        document.getElementById('total_presupuesto_env').value = '';
                        document.getElementById('monto_sobrante_presupuesto').value = '';
                    }
                } else {
                    alerta_top('error', 'Porfavor Ingrese la cantidad!');
                    document.getElementById('precio_unitario').value = '';
                    document.getElementById('total_presupuesto').value = '';
                    document.getElementById('total_presupuesto_env').value = '';
                    document.getElementById('monto_sobrante_presupuesto').value = '';
                }
            } else {
                alerta_top('error', 'Porfavor Ingrese la medida!');
                document.getElementById('precio_unitario').value = '';
            }

        }

        //para guardar las requerimientos del form5
        $(document).on('click', '#btn_guardarRequerimiento', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_formulario5_operacion'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_guardar_requerimientosf5') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    vaciar_errores_requerimientos();
                    if (data.tipo == 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = `<p id="error_in" >` + obj[
                                key] + `</p>`;
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        document.getElementById('btn_guardarF5_editado').disabled = true;
                        asignar_requerimientos(data.form5);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //vaciar campos de los errores
        function vaciar_errores_requerimientos() {
            document.getElementById('_tipo_financiamiento_').innerHTML = '';
            document.getElementById('_clasificador_presupuestario').innerHTML = '';
            document.getElementById('_medida').innerHTML = '';
            document.getElementById('_mes').innerHTML = '';
            document.getElementById('_dia').innerHTML = '';
        }

        //
        function cerrar_modal_requerimiento() {
            window.location = '';
        }

        //para que cuando seleccione un mes y dependiento si e sun o dos uma la gestion
        // let gestion_valor = {{ $gestiones->gestion }};

        function validar_gestiondia(val) {
            const input_gestion = document.getElementById('gestion');
            const ultimoDia = new Date(input_gestion.value, val, 0).getDate();

            // if (val != 'selected') {
            //     if (val == 1) {
            //         input_gestion.value = gestion_valor + 1;
            //     }
            //     if (val == 12) {
            //         input_gestion.value = gestion_valor;
            //     }
            // }

            $('#dia').empty();
            $('#dia').append('<option value="selected" selected disabled>[SELECCIONE DIA]</option>');
            for (let d = 1; d <= ultimoDia; d++) {
                $('#dia').append(`<option value="${d}">${d}</option>`)
            }
        }
    </script>
@endsection
