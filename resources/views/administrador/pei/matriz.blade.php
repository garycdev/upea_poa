@extends('principal')
@section('titulo', 'Matriz de Planificación')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>ÁREA ESTRATÉGICA : "{{ $areas_estrategicas->descripcion }}" GESTIÓN
                            {{ $gestion->inicio_gestion . ' - ' . $gestion->fin_gestion }}</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administración</li>
                        <li>Matriz de Planificación</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary">MATRIZ DE PLANIFICACIÓN</h3>
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#nueva_matriz_planificacion"><i class="bx bxs-add-to-queue"></i> Nuevo Matriz de
                            Planificación</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive  text-center table-bordered table-striped"
                        style="width:100%; font-size: 12px;">
                        <thead>
                            <tr>
                                <th rowspan="2">ACCION</th>
                                <th rowspan="2">N°</th>
                                <th rowspan="2">Articulación PDES</th>
                                <th colspan="3">Articulación PEI-PDU</th>
                                <th rowspan="2" id="verticalText">Area Estrategica</th>
                                <th colspan="2">Politica de Desarrollo</th>
                                <th colspan="2">Objetivo estategico (Sistema de Universidades de Bolivia)</th>
                                <th colspan="2">Objetivo estategico Institucional</th>
                                <th colspan="2">Indicador Estrategico</th>
                                <th rowspan="2" id="verticalText">Tipo</th>
                                <th rowspan="2" id="verticalText">Categoria</th>
                                <th rowspan="2" id="verticalText">Cod.</th>
                                <th rowspan="2" id="verticalText">Resultado o <br> producto</th>
                                <th rowspan="2">Linea base {{ $gestiones[0]->gestion - 1 }}</th>
                                <th colspan="6">Programación anual de Metas</th>
                                <th rowspan="2">Programa/ Poryecto/ Acción Estrategica</th>
                                <th rowspan="2">Unidades involucradas</th>
                                <th rowspan="2">Unidades responsables de meta</th>
                            </tr>
                            <tr>
                                <th id="verticalText"> Area </th>
                                <th id="verticalText">Politica</th>
                                <th id="verticalText">OE</th>
                                <th>Cod.</th>
                                <th>Descripcion</th>
                                <th>Cod.</th>
                                <th>Descripcion</th>
                                <th>Cod.</th>
                                <th>Descripcion</th>
                                <th>Cod.</th>
                                <th>Descripcion</th>
                                <th>{{ $gestiones[0]->gestion }}</th>
                                <th>{{ $gestiones[1]->gestion }}</th>
                                <th>{{ $gestiones[2]->gestion }}</th>
                                <th>{{ $gestiones[3]->gestion }}</th>
                                <th>{{ $gestiones[4]->gestion }}</th>
                                <th>Meta Media</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider ">
                            @foreach ($matriz_p as $lis)
                                <tr>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm"
                                            onclick="editar_matriz('{{ $lis->id }}', '{{ $pdes[0]->id }}', '{{ $id_area_estrategica }}', '{{ $gestion->id }}')"><i
                                                class="ri-edit-2-fill"></i></button>
                                    </td>
                                    <td>{{ $lis->codigo }}</td>
                                    <td>{{ 'Eje ' . $pdes[0]->codigo_eje . ' Meta ' . $pdes[0]->codigo_meta . ' Acción ' . $pdes[0]->codigo_accion . ' ' . $pdes[0]->descripcion_accion }}
                                    </td>
                                    <td id="verticalText">
                                        {{ $areas_estrategicas->codigo_areas_estrategicas }}
                                    </td>
                                    <td id="verticalText">
                                        {{ $areas_estrategicas->codigo_areas_estrategicas . ' . ' . $lis->politica_desarrollo_pdu[0]->codigo }}
                                    </td>
                                    <td id="verticalText">
                                        {{ $areas_estrategicas->codigo_areas_estrategicas . ' . ' . $lis->politica_desarrollo_pdu[0]->codigo . ' . ' . $lis->objetivo_estrategico[0]->codigo }}
                                    </td>
                                    <td>
                                        {{ $areas_estrategicas->codigo_areas_estrategicas }}
                                    </td>
                                    <td>
                                        {{ $areas_estrategicas->codigo_areas_estrategicas . ' . ' . $lis->objetivo_estrategico_sub[0]->codigo }}
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

                                        @foreach ($lis->objetivo_institucional as $ro)
                                            {{ $ro->codigo }}
                                        @endforeach

                                    <td>
                                        @foreach ($lis->objetivo_institucional as $ro)
                                            {{ $ro->descripcion }}
                                        @endforeach
                                    </td>
                                    <td>{{ $lis->indicador_pei->codigo }}</td>
                                    <td>{{ $lis->indicador_pei->descripcion }}</td>
                                    <td id="verticalText">{{ $lis->tipo->nombre }}</td>
                                    <td id="verticalText">{{ $lis->categoria->nombre }}</td>
                                    <td id="verticalText">{{ $lis->resultado_producto->codigo }}</td>
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
            </div>
        </div>
    </div>

    <!-- Modal  de nuevo matriz de planificacion-->
    <div class="modal zoom" id="nueva_matriz_planificacion" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">MATRIZ DE PLANIFICACIÓN</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrar_modal_matriz()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_matriz" method="post" autocomplete="off">
                        <input type="hidden" name="id_area_estrategica" id="id_area_estrategica"
                            value="{{ $areas_estrategicas->id }}">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 py-2">
                                <fieldset>
                                    <legend>CODIGO</legend>
                                    <div class="mb-2">
                                        <label for="codigo_matriz" class="col-form-label">Ingrese código de matriz</label>
                                        <input type="text" class="form-control" id="codigo_matriz" name="codigo_matriz"
                                            placeholder="Ingrese código" maxlength="4"
                                            onkeypress="return soloNumeros(event)">
                                        <div id="_codigo_matriz"></div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 py-2">
                                <fieldset>
                                    <legend>PLAN DE DESARROLLO ESTRATÉGICO Y SOCIAL (PDES)</legend>
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <div class="alert alert-primary" role="alert">
                                                    <h5 class="alert-heading">Eje : {{ $pdes[0]->codigo_eje }}</h5>
                                                    <p>{{ $pdes[0]->descripcion_eje }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>


                        <fieldset>
                            <legend>PLAN DE DESARROLLO UNIVERSITARIO (PDU)</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="objetivo_estrategico_pdu" class="col-form-label">Seleccione Objetivo
                                        Estratégico</label>
                                    <select name="objetivo_estrategico_pdu" id="objetivo_estrategico_pdu" class="select2"
                                        onchange="obj_estrategico_pdu(this)">
                                        <option value="" selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]
                                        </option>
                                        @foreach ($objetivos_estrategicos as $lis)
                                            <option value="{{ $lis->id }}"
                                                data-id="{{ $lis->id_politica_desarrollo }}">{{ $lis->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="_objetivo_estrategico_pdu"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="politica_desarrollo_pdu" class="col-form-label">Política de
                                        Desarrollo</label>
                                    {{-- <select name="politica_desarrollo_pdu" id="politica_desarrollo_pdu" class="select2" onchange="obj_estrategico_pdu(this.value)"> --}}
                                    <select name="politica_desarrollo_pdu" id="politica_desarrollo_pdu"
                                        class="form-control select-readonly">
                                        <option value="" selected disabled>[SELECCIONE LA POLÍTICA DE DESARROLLO]
                                        </option>
                                        @foreach ($politica_desarrollo as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_desarrollo_pdu"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PLAN ESTRATÉGICO INSTITUCIONAL (PEI)</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="objetivo_estrategico_institucional" class="col-form-label">Seleccione
                                        Objetivo Estratégico Institucional</label>
                                    <select name="objetivo_estrategico_institucional"
                                        id="objetivo_estrategico_institucional" class="select2"
                                        onchange="obj_estrategico_sub_1(this)">
                                        <option value="" selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL]
                                        </option>
                                        @foreach ($objetivos_estrategicos_institucionales as $lis)
                                            <option value="{{ $lis->id }}" data-pdd-id="{{ $lis->pdd_id }}"
                                                data-oes-id="{{ $lis->oes_id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_objetivo_estrategico_institucional"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2"></div>

                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="objetivo_estrategico_sub" class="col-form-label">Seleccione Objetivo
                                        Estratégico (SUB)</label>
                                    {{-- <select name="objetivo_estrategico_sub" id="objetivo_estrategico_sub" class="select2"
                                        onchange="objetivo_estrategico_inst_pei(this.value)"> --}}
                                    <select name="objetivo_estrategico_sub" id="objetivo_estrategico_sub"
                                        class="form-control select-readonly">
                                        <option value="" selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE
                                            UNIVERSIDADES DE BOLIVIA ]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_sub"></div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="obj_politica_institucional_pei" class="col-form-label">Seleccione Politica
                                        Institucional</label>
                                    <select name="politica_institucional_pei" id="politica_institucional_pei"
                                        class="form-control select-readonly" onchange="obj_estrategico_sub(this)">
                                        <option value="" selected disabled>[SELECCIONE LA POLITICA INSTITUCIONAL]
                                        </option>
                                        @foreach ($politica_institucional as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_institucional_pei"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>INDICADOR ESTRATÉGICO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
                                    <label for="indicador_estrategico" class="col-form-label">Seleccione Indicador
                                        Estratégico</label>
                                    <select name="indicador_estrategico" id="indicador_estrategico" class="select2">
                                        <option value="selected" selected disabled>[SELECCIONE EL INDICADOR ESTRATÉGICO]
                                        </option>
                                        @foreach ($indicador as $lis)
                                            <option value="{{ $lis->id }}"> [{{ $lis->codigo }}]
                                                {{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_indicador_estrategico"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>TIPO - CATEGORIA - RESULTADO O PRODUCTO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="tipo" class="col-form-label">Seleccione Tipo</label>
                                    <select name="tipo" id="tipo" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                        @foreach ($tipo as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_tipo"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="categoria" class="col-form-label">Seleccione Categoria</label>
                                    <select name="categoria" id="categoria" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE CATEGORIA]</option>
                                        @foreach ($categoria as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_categoria"></div>
                                </div>
                                <div class="text-center mb-2 linea_arriba">
                                    <h5>RESULTADO O PRODUCTO</h5>
                                </div>
                                <div class="row text-center d-flex justify-content-center align-items-center">
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                        <div class="mb-2">
                                            <label for="codigo_resultado_producto" class="form-label">Código</label>
                                            <input type="text" class="form-control" id="codigo_resultado_producto"
                                                name="codigo_resultado_producto" placeholder="Ingrese código"
                                                maxlength="4" onkeypress="return soloNumeros(event)">
                                            <div id="_codigo_resultado_producto"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 mb-2">
                                        <div class="mb-2">
                                            <label for="descripcion_resultado_producto"
                                                class="form-label">Descripción</label>
                                            <textarea class="form-control" name="descripcion_resultado_producto" id="descripcion_resultado_producto"
                                                rows="3" placeholder="Descripción resultado o producto"></textarea>
                                            <div id="_descripcion_resultado_producto"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PROGRAMACIÓN ANUAL DE METAS</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="linea_base" class="form-label">Linea Base
                                            {{ $gestiones[0]->gestion - 1 }}</label>
                                        <input type="text" class="form-control" id="linea_base" name="linea_base"
                                            placeholder="Descripción" maxlength="5">
                                        <div id="_linea_base"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_1" class="form-label">Gestión:
                                            {{ $gestiones[0]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_1" name="gestion_1"
                                            placeholder="Descripción" maxlength="5">
                                        <div id="_gestion_1"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_2" class="form-label">Gestión:
                                            {{ $gestiones[1]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_2" name="gestion_2"
                                            placeholder="Descripción" maxlength="5">
                                        <div id="_gestion_2"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_3" class="form-label">Gestión:
                                            {{ $gestiones[2]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_3" name="gestion_3"
                                            placeholder="Descripción" maxlength="5">
                                        <div id="_gestion_3"></div>
                                    </div>
                                </div>

                                <div class="linea_arriba">
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_4" class="form-label">Gestión:
                                            {{ $gestiones[3]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_4" name="gestion_4"
                                            placeholder="Descripción" maxlength="5">
                                        <div id="_gestion_4"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_5" class="form-label">Gestión:
                                            {{ $gestiones[4]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_5" name="gestion_5"
                                            placeholder="Descripción" maxlength="5">
                                        <div id="_gestion_5"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="meta_mediano_plazo" class="form-label">Meta de mediano plazo</label>
                                        <input type="text" class="form-control" id="meta_mediano_plazo"
                                            name="meta_mediano_plazo" placeholder="Descripción" maxlength="5">
                                        <div id="_meta_mediano_plazo"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PROGRAMA - PROYECTO - ACCIÓN ESTRATÉGICA</legend>
                            <div class="row text-center d-flex justify-content-center align-items-center">
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 mb-2">
                                    <label for="programa_accion_estrategica" class="col-form-label">Seleccione
                                        tipo</label>
                                    <select name="programa_accion_estrategica" id="programa_accion_estrategica"
                                        class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                        @foreach ($porgrama_proy_acc as $lis)
                                            <option value="{{ $lis->id }}"> {{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_programa_accion_estrategica"></div>
                                </div>
                                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 mb-2">
                                    <div class="mb-2">
                                        <label for="descripcion_progrma_accion_estrategica"
                                            class="form-label">Descripción</label>
                                        <textarea class="form-control" name="descripcion_progrma_accion_estrategica"
                                            id="descripcion_progrma_accion_estrategica" rows="3"
                                            placeholder="Descripción programa, proyecto acción estratégica"></textarea>
                                        <div id="_descripcion_progrma_accion_estrategica"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                <fieldset>
                                    <legend>UNIDADES INVOLUCRADAS</legend>
                                    <div class="mb-2">
                                        <label for="unidades_involucradas" class="col-form-label">Seleccione Unidades
                                            involucradas</label>
                                        <select name="unidades_involucradas[]" id="unidades_involucradas" class="select2"
                                            multiple="multiple">
                                            @foreach ($unidades as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre_completo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                <fieldset>
                                    <legend>UNIDADES RESPONSABLES DE META</legend>
                                    <div class="mb-2">
                                        <label for="unidades_responsables" class="col-form-label">Seleccione Unidades
                                            responsables de meta</label>
                                        <select name="unidades_responsables[]" id="unidades_responsables" class="select2"
                                            multiple="multiple">
                                            @foreach ($unidades as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre_completo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="cerrar_modal_matriz()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_matriz"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Matriz de Planificacion</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar matriz de planificacion-->
    <div class="modal zoom" id="editar_matriz_planificacion" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR MATRIZ DE PLANIFICACIÓN</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="reset_editar()"></button>
                </div>
                <div class="modal-body">
                    <div id="mensaje"></div>
                    <form id="form_matriz_eitar" method="post" autocomplete="off">
                        <input type="hidden" name="id_matriz_plan" id="id_matriz_plan">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                <fieldset>
                                    <legend>CODIGO</legend>
                                    <div class="mb-2">
                                        <label for="codigo_matriz_e" class="col-form-label">Ingrese código de
                                            matriz</label>
                                        <input type="text" class="form-control" id="codigo_matriz_e"
                                            name="codigo_matriz_e" placeholder="Ingrese código" maxlength="4"
                                            onkeypress="return soloNumeros(event)">
                                        <div id="_codigo_matriz_e"></div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                <fieldset>
                                    <legend>PLAN DE DESARROLLO ESTRATÉGICO Y SOCIAL (PDES)</legend>
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                <div class="alert alert-primary" role="alert">
                                                    <h5 class="alert-heading">Eje : {{ $pdes[0]->codigo_eje }}</h5>
                                                    <p>{{ $pdes[0]->descripcion_eje }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <fieldset>
                            <legend>PLAN DE DESARROLLO UNIVERSITARIO (PDU)</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="objetivo_estrategico_pdu_e" class="col-form-label">Seleccione Objetivo
                                        Estratégico</label>
                                    <div id="cambiar_obj">
                                        <select name="objetivo_estrategico_pdu_e" id="objetivo_estrategico_pdu_e"
                                            class="select2_segundo" onchange="obj_estrategico_pdu_e(this)">
                                            <option value="" selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]
                                            </option>
                                            @foreach ($objetivos_estrategicos as $lis)
                                                <option value="{{ $lis->id }}"
                                                    data-id="{{ $lis->id_politica_desarrollo }}">
                                                    {{ $lis->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="_objetivo_estrategico_pdu_e"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="politica_desarrollo_pdu_e" class="col-form-label">Politica de
                                        Desarrollo</label>
                                    <select name="politica_desarrollo_pdu_e" id="politica_desarrollo_pdu_e"
                                        class="form-control select-readonly">
                                        <option value="" selected disabled>[SELECCIONE LA POLITICA DE DESARROLLO]
                                        </option>
                                        @foreach ($politica_desarrollo as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_desarrollo_pdu_e"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PLAN ESTRATÉGICO INSTITUCIONAL (PEI)</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="politica_institucional_pei_e" class="col-form-label">Seleccione Politica
                                        Institucional</label>
                                    <select name="politica_institucional_pei_e" id="politica_institucional_pei_e"
                                        class="select2_segundo">
                                        <option value="selected" selected disabled>[SELECCIONE LA POLITICA INSTITUCIONAL]
                                        </option>
                                        @foreach ($politica_institucional as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_institucional_pei_e"></div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="objetivo_estrategico_sub_e" class="col-form-label">Seleccione Objetivo
                                        Estratégico (SUB)</label>
                                    <select name="objetivo_estrategico_sub_e" id="objetivo_estrategico_sub_e"
                                        class="select2_segundo">
                                        <option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE
                                            UNIVERSIDADES DE BOLIVIA ]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_sub_e"></div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="objetivo_estrategico_institucional_e" class="col-form-label">Seleccione
                                        Objetivo Estratégico Institucional</label>
                                    <select name="objetivo_estrategico_institucional_e"
                                        id="objetivo_estrategico_institucional_e" class="select2_segundo">
                                        <option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL]
                                        </option>
                                    </select>
                                    <div id="_objetivo_estrategico_institucional_e"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>INDICADOR ESTRATÉGICO</legend>
                            <input type="hidden" name="indicador_ant" id="indicador_ant">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">
                                    <label for="indicador_estrategico_e" class="col-form-label">Seleccione Indicador
                                        Estratégico</label>
                                    <select name="indicador_estrategico_e" id="indicador_estrategico_e"
                                        class="select2_segundo">
                                        <option value="selected" selected disabled>[SELECCIONE EL INDICADOR ESTRATÉGICO]
                                        </option>
                                    </select>
                                    <div id="_indicador_estrategico_e"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>TIPO - CATEGORIA - RESULTADO O PRODUCTO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="tipo_e" class="col-form-label">Seleccione Tipo</label>
                                    <select name="tipo_e" id="tipo_e" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                        @foreach ($tipo as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_tipo_e"></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <label for="categoria_e" class="col-form-label">Seleccione Categoria</label>
                                    <select name="categoria_e" id="categoria_e" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE CATEGORIA]</option>
                                        @foreach ($categoria as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_categoria_e"></div>
                                </div>
                                <div class="text-center mb-2 linea_arriba">
                                    <h5>RESULTADO O PRODUCTO</h5>
                                </div>
                                <div class="row text-center d-flex justify-content-center align-items-center">
                                    <input type="hidden" name="edi_id_resultado_producto"
                                        id="edi_id_resultado_producto">
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                        <div class="mb-2">
                                            <label for="codigo_resultado_producto_e" class="form-label">Código</label>
                                            <input type="text" class="form-control" id="codigo_resultado_producto_e"
                                                name="codigo_resultado_producto_e" placeholder="Ingrese código"
                                                maxlength="4" onkeypress="return soloNumeros(event)">
                                            <div id="_codigo_resultado_producto_e"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 mb-2">
                                        <div class="mb-2">
                                            <label for="descripcion_resultado_producto_e"
                                                class="form-label">Descripción</label>
                                            <textarea class="form-control" name="descripcion_resultado_producto_e" id="descripcion_resultado_producto_e"
                                                rows="3" placeholder="Descripción resultado o producto"></textarea>
                                            <div id="_descripcion_resultado_producto_e"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PROGRAMACIÓN ANUAL DE METAS</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="linea_base_e" class="form-label">Linea Base
                                            {{ $gestiones[0]->gestion - 1 }}</label>
                                        <input type="text" class="form-control" id="linea_base_e" name="linea_base_e"
                                            placeholder="Descripción" maxlength="4">
                                        <div id="_linea_base_e"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_1_e" class="form-label">Gestión:
                                            {{ $gestiones[0]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_1_e" name="gestion_1_e"
                                            placeholder="Descripción" maxlength="4">
                                        <div id="_gestion_1_e"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_2_e" class="form-label">Gestión:
                                            {{ $gestiones[1]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_2_e" name="gestion_2_e"
                                            placeholder="Descripción" maxlength="4">
                                        <div id="_gestion_2_e"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_3_e" class="form-label">Gestión:
                                            {{ $gestiones[2]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_3_e" name="gestion_3_e"
                                            placeholder="Descripción" maxlength="4">
                                        <div id="_gestion_3_e"></div>
                                    </div>
                                </div>

                                <div class="linea_arriba">
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_4_e" class="form-label">Gestión:
                                            {{ $gestiones[3]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_4_e" name="gestion_4_e"
                                            placeholder="Descripción" maxlength="4">
                                        <div id="_gestion_4_e"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="gestion_5" class="form-label">Gestión:
                                            {{ $gestiones[4]->gestion }}</label>
                                        <input type="text" class="form-control" id="gestion_5_e" name="gestion_5_e"
                                            placeholder="Descripción" maxlength="4">
                                        <div id="_gestion_5_e"></div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="meta_mediano_plazo_e" class="form-label">Meta de mediano plazo</label>
                                        <input type="text" class="form-control" id="meta_mediano_plazo_e"
                                            name="meta_mediano_plazo_e" placeholder="Descripción" maxlength="4">
                                        <div id="_meta_mediano_plazo_e"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PROGRAMA - PROYECTO - ACCIÓN ESTRATÉGICA</legend>
                            <div class="row text-center d-flex justify-content-center align-items-center">
                                <input type="hidden" name="edi_inv_programa_proyecto_accion_estrategica"
                                    id="edi_inv_programa_proyecto_accion_estrategica">
                                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 mb-2">
                                    <label for="programa_accion_estrategica_e" class="col-form-label">Seleccione
                                        tipo</label>
                                    <select name="programa_accion_estrategica_e" id="programa_accion_estrategica_e"
                                        class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                        @foreach ($porgrama_proy_acc as $lis)
                                            <option value="{{ $lis->id }}"> {{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_programa_accion_estrategica_e"></div>
                                </div>
                                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 mb-2">
                                    <div class="mb-2">
                                        <label for="descripcion_progrma_accion_estrategica_e"
                                            class="form-label">Descripción</label>
                                        <textarea class="form-control" name="descripcion_progrma_accion_estrategica_e"
                                            id="descripcion_progrma_accion_estrategica_e" rows="3"
                                            placeholder="Descripción programa, proyecto acción estratégica"></textarea>
                                        <div id="_descripcion_progrma_accion_estrategica_e"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                <fieldset>
                                    <legend>UNIDADES INVOLUCRADAS</legend>
                                    <div class="mb-2">
                                        <label for="unidades_involucradas_e" class="col-form-label">Seleccione Unidades
                                            involucradas</label>
                                        <select name="unidades_involucradas_e[]" id="unidades_involucradas_e"
                                            class="select2_segundo valores_inv" multiple="multiple">
                                            @foreach ($unidades as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre_completo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                <fieldset>
                                    <legend>UNIDADES RESPONSABLES DE META</legend>
                                    <div class="mb-2">
                                        <label for="unidades_responsables_e" class="col-form-label">Seleccione Unidades
                                            responsables de meta</label>
                                        <select name="unidades_responsables_e[]" id="unidades_responsables_e"
                                            class="select2_segundo" multiple="multiple">
                                            @foreach ($unidades as $lis)
                                                <option value="{{ $lis->id }}">{{ $lis->nombre_completo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="reset_editar()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_matriz_editado"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Matriz de Planificacion</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        select2_rodry('#nueva_matriz_planificacion');
        segundo_select2('#editar_matriz_planificacion');

        $(document).ready(function() {
            $(".txtEditor").Editor();
        });


        function cerrar_modal_matriz() {
            limpiar_campos('form_matriz');

            // $(".select2").val('selected').trigger('change');

            // $('#objetivo_estrategico_pdu').empty().append(
            //     '<option selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
            // );
            // $('#objetivo_estrategico_sub').empty().append(
            //     '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>'
            // );
            // $('#objetivo_estrategico_institucional').empty().append(
            //     '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL]</option>'
            // );

            $('#objetivo_estrategico_pdu').val('').trigger('change');
            $('#objetivo_estrategico_sub').val('').trigger('change');
            $('#objetivo_estrategico_institucional').val('').trigger('change');
            $('#politica_institucional_pei').val('').trigger('change');

            vaciar_errores_matriz();
        }
        //para listar los objetivos estrategicos de PDU
        function obj_estrategico_pdu(select) {
            const id = $(select).val();
            const id_pdd = $(select).find(':selected').data('id');

            $('#politica_desarrollo_pdu').val(id_pdd).trigger('change');
            // $.ajax({
            //     type: "POST",
            //     url: "{{ route('adm_matriz_obj_estrategico') }}",
            //     data: {
            //         id: id
            //     },
            //     dataType: "JSON",
            //     success: function(data) {
            //         $('#objetivo_estrategico_pdu').empty().append(
            //             '<option selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
            //         );
            //         if (data.tipo === 'success') {
            //             let datos = data.mensaje;
            //             datos.forEach(value => {
            //                 $('#objetivo_estrategico_pdu').append('<option value = "' + value.id +
            //                     '">' + value.descripcion + '</option>');
            //             });
            //         }
            //         if (data.tipo === 'error') {
            //             toastr[data.tipo](data.mensaje);
            //         }
            //     }
            // });
        }

        function obj_estrategico_pdu_e(select) {
            const id = $(select).val();
            const id_pdd = $(select).find(':selected').data('id');

            $('#politica_desarrollo_pdu_e').val(id_pdd).trigger('change');
        }
        //para listar los objetivos estrategicos de la SUB
        function obj_estrategico_sub_1(select) {
            const id = $(select).val();
            const pdd_id = $(select).find(':selected').data('pdd-id');
            const oes_id = $(select).find(':selected').data('oes-id');

            $('#politica_institucional_pei').val(pdd_id).trigger('change');
            $('#politica_institucional_pei').attr('data-oes-id', oes_id);
        }

        function obj_estrategico_sub(select) {
            if ($(select).val() == null) {
                $('#objetivo_estrategico_sub').empty().append(
                    '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA]</option>'
                );
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_sub') }}",
                data: {
                    id: $(select).val()
                },
                dataType: "JSON",
                success: function(data) {
                    // $('#objetivo_estrategico_institucional').empty().append(
                    //     '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL]</option>'
                    // );
                    $('#objetivo_estrategico_sub').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA]</option>'
                    );
                    if (data.tipo === 'success') {
                        let datos = data.mensaje;
                        datos.forEach((value, index) => {
                            $('#objetivo_estrategico_sub').append(
                                `<option value="${value.id}" >${value.descripcion}</option>`
                            );
                        });
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }

                    const oes_id = $(select).attr('data-oes-id');
                    $('#objetivo_estrategico_sub').val(oes_id).trigger('change')
                }
            });
        }
        //para listar los objetivos institucionales
        function objetivo_estrategico_inst_pei(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_institucional') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#objetivo_estrategico_institucional').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
                    );
                    if (data.tipo === 'success') {
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_institucional').append('<option value = "' + value
                                .id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }

        //para guardar la matriz de planificacion
        $(document).on('click', '#btn_guardar_matriz', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_matriz'));

            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    vaciar_errores_matriz();
                    if (data.tipo == 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = `<p id="error_in" >` + obj[
                                key] + `</p>`;
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#nueva_matriz_planificacion').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para vaciar los erroes que tuviera la matriz de planificacion
        function vaciar_errores_matriz() {
            document.getElementById('_codigo_matriz').innerHTML = '';
            document.getElementById('_politica_desarrollo_pdu').innerHTML = '';
            document.getElementById('_objetivo_estrategico_pdu').innerHTML = '';
            document.getElementById('_politica_institucional_pei').innerHTML = '';
            document.getElementById('_objetivo_estrategico_sub').innerHTML = '';
            document.getElementById('_objetivo_estrategico_institucional').innerHTML = '';
            document.getElementById('_indicador_estrategico').innerHTML = '';
            document.getElementById('_tipo').innerHTML = '';
            document.getElementById('_categoria').innerHTML = '';
            document.getElementById('_codigo_resultado_producto').innerHTML = '';
            document.getElementById('_descripcion_resultado_producto').innerHTML = '';
            document.getElementById('_linea_base').innerHTML = '';
            document.getElementById('_gestion_1').innerHTML = '';
            document.getElementById('_gestion_2').innerHTML = '';
            document.getElementById('_gestion_3').innerHTML = '';
            document.getElementById('_gestion_4').innerHTML = '';
            document.getElementById('_gestion_5').innerHTML = '';
            document.getElementById('_meta_mediano_plazo').innerHTML = '';
            document.getElementById('_programa_accion_estrategica').innerHTML = '';
            document.getElementById('_descripcion_progrma_accion_estrategica').innerHTML = '';
        }

        //PARA EDITAR LA MATRIZ DE PLANIFICACION
        function editar_matriz(id, id_pdes, id_area_est, id_ges) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_editar') }}",
                data: {
                    id: id,
                    id_pdes: id_pdes,
                    id_area_est: id_area_est,
                    id_ges: id_ges
                },
                dataType: "JSON",
                async: false,
                success: function(data) {
                    if (data.tipo === 'success') {
                        $('#editar_matriz_planificacion').modal('show');
                        document.getElementById('id_matriz_plan').value = data.mensaje.matriz_e.id;
                        document.getElementById('codigo_matriz_e').value = data.mensaje.matriz_e.codigo;
                        //PAR ALA PARTE DEL PDU
                        $('#politica_desarrollo_pdu_e').val(data.mensaje.matriz_e.politica_desarrollo_pdu[0].id)
                            .trigger('change');
                        // data.mensaje.objetivo_estrategico_e.forEach(value => {
                        //     $('#objetivo_estrategico_pdu_e').append('<option value = "' + value.id +
                        //         '">' + value.descripcion + '</option>');
                        // });
                        $('#objetivo_estrategico_pdu_e').val(data.mensaje.matriz_e.objetivo_estrategico[0].id)
                            .trigger('change');
                        //PARA LA PARTE DE PEI SUB
                        $('#politica_institucional_pei_e').val(data.mensaje.matriz_e.politica_desarrollo_pei[0]
                            .id).trigger('change');

                        data.mensaje.objetivo_estrategico_sub_e.forEach(value => {
                            $('#objetivo_estrategico_sub_e').append('<option value = "' + value.id +
                                '">' + value.descripcion + '</option>');
                        });
                        $('#objetivo_estrategico_sub_e').val(data.mensaje.matriz_e.objetivo_estrategico_sub[0]
                            .id).trigger('change');
                        //PARA LA PARTE DE PEI INSTITUCIONAL
                        data.mensaje.objetivo_institucional_e.forEach(value => {
                            $('#objetivo_estrategico_institucional_e').append('<option value = "' +
                                value.id + '">' + value.descripcion + '</option>');
                        });
                        data.mensaje.matriz_e.objetivo_institucional.forEach(valor => {
                            $('#objetivo_estrategico_institucional_e').val(valor.id).trigger('change');
                        });
                        //INDICADOR
                        document.getElementById('indicador_ant').value = data.mensaje.matriz_e.indicador_pei.id;
                        data.mensaje.indicador_e.forEach(value => {
                            $('#indicador_estrategico_e').append('<option value = "' + value.id + '">' +
                                '[' + value.codigo + ']' + value.descripcion + '</option>');
                        });
                        $('#indicador_estrategico_e').val(data.mensaje.matriz_e.indicador_pei.id).trigger(
                            'change');
                        //TIPO CATEGORIA RESULTADO PROCUTO
                        document.getElementById('tipo_e').value = data.mensaje.matriz_e.tipo.id;
                        document.getElementById('categoria_e').value = data.mensaje.matriz_e.categoria.id;
                        document.getElementById('edi_id_resultado_producto').value = data.mensaje.matriz_e
                            .resultado_producto.id;
                        document.getElementById('codigo_resultado_producto_e').value = data.mensaje.matriz_e
                            .resultado_producto.codigo;
                        document.getElementById('descripcion_resultado_producto_e').value = data.mensaje
                            .matriz_e.resultado_producto.descripcion;
                        //PROGRAMACION ANUAL DE METAS
                        document.getElementById('linea_base_e').value = data.mensaje.matriz_e.linea_base;
                        document.getElementById('gestion_1_e').value = data.mensaje.matriz_e.gestion_1;
                        document.getElementById('gestion_2_e').value = data.mensaje.matriz_e.gestion_2;
                        document.getElementById('gestion_3_e').value = data.mensaje.matriz_e.gestion_3;
                        document.getElementById('gestion_4_e').value = data.mensaje.matriz_e.gestion_4;
                        document.getElementById('gestion_5_e').value = data.mensaje.matriz_e.gestion_5;
                        document.getElementById('meta_mediano_plazo_e').value = data.mensaje.matriz_e
                            .meta_mediano_plazo;
                        //PROGRAMA PROYECTO-ACCION ESTRATEGICA
                        document.getElementById('edi_inv_programa_proyecto_accion_estrategica').value = data
                            .mensaje.matriz_e.programa_proyecto_accion.id;
                        document.getElementById('programa_accion_estrategica_e').value = data.mensaje.matriz_e
                            .programa_proyecto_accion.id_tipo_prog_acc;
                        document.getElementById('descripcion_progrma_accion_estrategica_e').value = data.mensaje
                            .matriz_e.programa_proyecto_accion.descripcion;
                        //PARA LAS UNIDADES ADMINISTRATICAS
                        let unidades_inv = data.mensaje.matriz_e.unidades_administrativas_inv;
                        let array = [];
                        unidades_inv.forEach(valor => {
                            array.push(valor.id)
                        });
                        $('#unidades_involucradas_e').val(array).trigger('change');
                        let unidades_res = data.mensaje.matriz_e.unidades_administrativas_res;
                        let array1 = [];
                        unidades_res.forEach(valor => {
                            array1.push(valor.id)
                        });
                        $('#unidades_responsables_e').val(array1).trigger('change');
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }

        //para editar al momento de salir se debe reset
        function reset_editar() {
            // $('#objetivo_estrategico_pdu_e').empty().append(
            //     '<option selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
            // );
            // $('#objetivo_estrategico_sub_e').empty().append(
            //     '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>'
            // );
            // $('#objetivo_estrategico_institucional_e').empty().append(
            //     '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL]</option>'
            // );
            // $('#indicador_estrategico_e').empty().append(
            //     '<option selected disabled>[SELECCIONE EL INDICADOR ESTRATÉGICO]</option>'
            // );
            vaciar_errores_editar_matriz();
        }

        //para listar los objetivo estrategicos de PDU
        // let select2_politica_desarrolloPDU = $('#politica_desarrollo_pdu_e');
        // select2_politica_desarrolloPDU.on('select2:select', function(e) {
        //     let id = select2_politica_desarrolloPDU.val();
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('adm_matriz_obj_estrategico') }}",
        //         data: {
        //             id: id
        //         },
        //         dataType: "JSON",
        //         success: function(data) {
        //             $('#objetivo_estrategico_pdu_e').empty().append(
        //                 '<option selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
        //             );
        //             if (data.tipo === 'success') {
        //                 let datos = data.mensaje;
        //                 datos.forEach(value => {
        //                     $('#objetivo_estrategico_pdu_e').append('<option value = "' + value
        //                         .id + '">' + value.descripcion + '</option>');
        //                 });
        //             }
        //             if (data.tipo === 'error') {
        //                 toastr[data.tipo](data.mensaje);
        //             }
        //         }
        //     });
        // });
        //para listar los objetivos de la SUB
        let select2_politica_desarrollo_PEI = $("#politica_institucional_pei_e");
        select2_politica_desarrollo_PEI.on('select2:select', function(e) {
            let id = select2_politica_desarrollo_PEI.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_sub') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#objetivo_estrategico_sub_e').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>'
                    );
                    $('#objetivo_estrategico_institucional_e').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL]</option>'
                    );
                    if (data.tipo === 'success') {
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_sub_e').append('<option value = "' + value
                                .id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });
        //para listar los objetivos estrategicos institucionales
        let select2_objetivo_estrategico_institucional = $("#objetivo_estrategico_sub_e");
        select2_objetivo_estrategico_institucional.on('select2:select', function(e) {
            let id = select2_objetivo_estrategico_institucional.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_institucional') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#objetivo_estrategico_institucional_e').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
                    );
                    if (data.tipo === 'success') {
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_institucional_e').append(
                                '<option value = "' + value.id + '">' + value.descripcion +
                                '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });

        //para guardar lo editado
        $(document).on('click', '#btn_guardar_matriz_editado', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_matriz_eitar'));
            vaciar_errores_editar_matriz();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_editar_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.tipo == 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = `<p id="error_in" >` + obj[
                                key] + `</p>`;
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#editar_matriz_planificacion').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });


        //para vaciar los errores de la parte de edición
        function vaciar_errores_editar_matriz() {
            document.getElementById('_codigo_matriz_e').innerHTML = '';
            document.getElementById('_politica_desarrollo_pdu_e').innerHTML = '';
            document.getElementById('_objetivo_estrategico_pdu_e').innerHTML = '';
            document.getElementById('_politica_institucional_pei_e').innerHTML = '';
            document.getElementById('_objetivo_estrategico_sub_e').innerHTML = '';
            document.getElementById('_objetivo_estrategico_institucional_e').innerHTML = '';
            document.getElementById('_indicador_estrategico_e').innerHTML = '';
            document.getElementById('_tipo_e').innerHTML = '';
            document.getElementById('_categoria_e').innerHTML = '';
            document.getElementById('_codigo_resultado_producto_e').innerHTML = '';
            document.getElementById('_descripcion_resultado_producto_e').innerHTML = '';
            document.getElementById('_linea_base_e').innerHTML = '';
            document.getElementById('_gestion_1_e').innerHTML = '';
            document.getElementById('_gestion_2_e').innerHTML = '';
            document.getElementById('_gestion_3_e').innerHTML = '';
            document.getElementById('_gestion_4_e').innerHTML = '';
            document.getElementById('_gestion_5_e').innerHTML = '';
            document.getElementById('_meta_mediano_plazo_e').innerHTML = '';
            document.getElementById('_programa_accion_estrategica_e').innerHTML = '';
            document.getElementById('_descripcion_progrma_accion_estrategica_e').innerHTML = '';
        }
    </script>
@endsection
