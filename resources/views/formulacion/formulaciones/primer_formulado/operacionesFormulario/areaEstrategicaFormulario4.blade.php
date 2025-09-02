@extends('principal')
@section('titulo', 'Formulario Nº 4')
@section('estilos')
    <style>
        #error_fieldset{
            border: 2px solid #F07968;
        }
        #error_legend{
            background: #F07968;
        }
        #success_fieldset{
            border: 2px solid #82CD7C;
        }
        #success_legend{
            background: #82CD7C
        }
    </style>
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="page-title">
                        <h5>TIPO : {{ $tipo_formulado->descripcion }}</h5>
                        <h5>FORMULARIO Nº 4 </h5>
                        <h5>GESTIÓN : {{ $gestiones->gestion }}</h5>
                        <h5>{{ $carrera_unidad->nombre_completo }}</h5>
                        <h5>ÁREA ESTRATÉGICA : {{ $area_estrategica->descripcion }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary">FORMULARIO Nº 4</h3>
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_formulario4"  ><i class="bx bxs-add-to-queue"></i> Nuevo registro</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive  text-center table-bordered table-hover" style="width:100%; font-size: 10px;" >
                        <thead >
                            <tr>
                                <th rowspan="2">ACCION</th>
                                <th rowspan="2">FORM #5</th>
                                <th rowspan="2">CODIGO</th>
                                <th rowspan="2">COD. <br>ARTICULACIÓN</th>
                                <th colspan="2">OBJETIVO INSTITUCIONAL <br> (acción a cortor Plazo)</th>
                                <th colspan="4">INDICADORES <br> (resultado esperado - Producto de la gestión)</th>
                                <th rowspan="2">Bien, Norma o Servicio</th>
                                <th colspan="3">Programación del Resultado <br> ( Producto (N° o %))</th>
                                <th rowspan="2">Presupuesto Programado por OGE</th>
                                <th rowspan="2">Asignar OGE</th>
                                <th rowspan="2">Unidad Responsable</th>
                            </tr>
                            <tr>
                                <th> cod. </th>
                                <th>Objetivo Especifico</th>
                                <th>Cod.</th>
                                <th>Indicador</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>1º Semestre.</th>
                                <th>2º Semestre.</th>
                                <th>Meta Anual</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">

                            @foreach ($formulario4_listar as $lis)
                                <tr>
                                    <td class="text-center">
                                        <button class="btn btn-outline-warning btn-sm" onclick="editarForm4('{{ $lis->id }}')" ><i class="ri-edit-2-fill"></i></button>
                                    </td>
                                    <td>
                                        <a href="{{ route('poa_form5', ['formulario4_id'=>encriptar($lis->id), 'formuladoTipo_id'=>encriptar($tipo_formulado->id), 'area_estrategica_id'=>encriptar($area_estrategica->id)]) }}" class="btn btn-outline-primary btn-sm">Form #5</a>
                                    </td>
                                    <td>
                                        {{ $lis->codigo }}
                                    </td>
                                    <td>
                                        {{ $area_estrategica->codigo_areas_estrategicas.'.'.$lis->formulario2->politica_desarrollo_pei[0]->codigo.'.' }}
                                    </td>
                                    <td>
                                        {{ $area_estrategica->codigo_areas_estrategicas.'.'.$lis->formulario2->politica_desarrollo_pei[0]->codigo.'.'.$lis->formulario2->objetivo_institucional[0]->codigo.'.' }}
                                    </td>
                                    <td>
                                        {{ $lis->formulario2->objetivo_institucional[0]->descripcion }}
                                    </td>
                                    <td>
                                        {{ $area_estrategica->codigo_areas_estrategicas.'.'.$lis->formulario2->politica_desarrollo_pei[0]->codigo.'.'.$lis->formulario2->objetivo_institucional[0]->codigo.'.'.$lis->formulario2->indicador->codigo.'.' }}
                                    </td>
                                    <td>{{ $lis->formulario2->indicador->descripcion }}</td>
                                    <td>{{ $lis->tipo->nombre }}</td>
                                    <td>{{ $lis->categoria->nombre }}</td>
                                    <td>{{ $lis->bien_servicio->nombre }}</td>
                                    <td>{{ $lis->primer_semestre }}</td>
                                    <td>{{ $lis->segundo_semestre }}</td>
                                    <td>{{ $lis->meta_anual }}</td>
                                    <td>
                                        @php
                                            $suma = 0;
                                            foreach ($lis->asignacion_monto_f4 as $lis1) {
                                                $suma = $suma + $lis1->monto_asignado;
                                            }
                                        @endphp
                                        {{ con_separador_comas($suma).' Bs' }}
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" onclick="asignar_financiadoF4('{{ $lis->id }}')" >Asignar GC</button>
                                    </td>
                                    <td>{{ $lis->unidad_responsable[0]->nombre_completo }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO --}}
    <div class="modal slide" id="nuevo_formulario4" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO REGISTRO DEL FORMULARIO Nº 4</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModalf4()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_formulario4" method="POST" autocomplete="off">
                        <input type="hidden" name="configFormulado" value="{{ $configuracion_formulado->id }}">
                        <input type="hidden" name="gestiones_id" value="{{ $gestiones->id }}">
                        <input type="hidden" name="area_estrategica" value="{{ $area_estrategica->id }}">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 py-2" >
                                <fieldset>
                                    <legend>CODIGO</legend>
                                        <div class="mb-2">
                                            <label for="codigo" class="col-form-label">Ingrese código</label>
                                            <input type="text" class="form-control" id="codigo" name="codigo"
                                                placeholder="Ingrese código" maxlength="4"
                                                onkeypress="return soloNumeros(event)">
                                            <div id="_codigo"></div>
                                        </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 py-2" >
                                <fieldset>
                                    <legend>INDICADOR DEL FORMULARIO Nº 2</legend>
                                    <div class="mb-2">
                                        <label for="indicador_formulario2" class="col-form-label">Seleccione Indicador del formulario nº 2</label>
                                        <select name="indicador_formulario2" id="indicador_formulario2" class="select2" onchange="validarUnicoform4(this.value)">
                                            <option value="selected" selected disabled>[SELECCIONE INDICADOR DEL FORMULARIO Nº 2]</option>
                                            @foreach ($formulario2 as $lis)
                                                <option value="{{ $lis->id }} ">[{{ $lis->indicador->codigo }}] {{ $lis->indicador->descripcion }} </option>
                                            @endforeach
                                        </select>
                                        <div id="_indicador_formulario2" ></div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row" id="vizualizar_detalles">

                        </div>


                        <fieldset>
                            <legend>TIPO - CATEGORIA - RESULTADO O PRODUCTO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="tipo" class="col-form-label">Seleccione Tipo</label>
                                    <select name="tipo" id="tipo" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                        @foreach ($tipo as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_tipo" ></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="categoria" class="col-form-label">Seleccione Categoria</label>
                                    <select name="categoria" id="categoria" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE CATEGORIA]</option>
                                        @foreach ($categoria as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_categoria" ></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>BIEN, NORMA O SERVICIO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2"  >
                                    <label for="tipo" class="col-form-label">Seleccione Bien, Norma o Servicio</label>
                                    <select name="bien_servicio" id="bien_servicio" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE BIEN, NORMA O SERVICIO]</option>
                                        @foreach ($bien_sevicio as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_bien_servicio" ></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>PROGRAMACIÓN DEL RESULTADO ( PRODUCTO (N° o %))</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="primer_semestre" class="form-label">Primer Semestre</label>
                                        <input type="text" class="form-control" id="primer_semestre" name="primer_semestre"
                                            placeholder="Descripción de 1er semestre" maxlength="4">
                                        <div id="_primer_semestre"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="segundo_semestre" class="form-label">Segundo Semestre</label>
                                        <input type="text" class="form-control" id="segundo_semestre" name="segundo_semestre"
                                            placeholder="Descripción de 2do Semestre" maxlength="4">
                                        <div id="_segundo_semestre"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="meta_anual" class="form-label">Meta Anual</label>
                                        <input type="text" class="form-control" id="meta_anual" name="meta_anual"
                                            placeholder="Descripción de Meta Anual" maxlength="4">
                                        <div id="_meta_anual"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>UNIDADES RESPONSABLES DE META</legend>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2" >
                                <div class="mb-2">
                                    <label for="unidades_responsables" class="col-form-label">Seleccione Unidad responsable de meta</label>
                                    <select name="unidades_responsable" id="unidades_responsable" class="select2">
                                        <option value="selected" selected disabled>[SELECCIONE UNIDAD RESPONSABLE]</option>
                                        @foreach ($unidades as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre_completo }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_unidades_responsable" ></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrarModalf4()" >Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarF4" @disabled(true)> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR --}}
    <div class="modal slide" id="editar_formulario4" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR REGISTRO DEL FORMULARIO Nº 4</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_formulario4_editado" method="POST" autocomplete="off">
                        <input type="hidden" name="formulario4_id" id="formulario4_id">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 py-2" >
                                <fieldset>
                                    <legend>CODIGO</legend>
                                        <div class="mb-2">
                                            <label for="codigo_" class="col-form-label">Ingrese código</label>
                                            <input type="text" class="form-control" id="codigo_" name="codigo_"
                                                placeholder="Ingrese código" maxlength="4"
                                                onkeypress="return soloNumeros(event)">
                                            <div id="_codigo_"></div>
                                        </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 py-2" >
                                <fieldset>
                                    <legend>INDICADOR DEL FORMULARIO Nº 2</legend>
                                    <div class="mb-2">
                                        <label for="indicador_formulario2_" class="col-form-label">Seleccione Indicador del formulario nº 2</label>
                                        <select name="indicador_formulario2_" id="indicador_formulario2_" class="select2_segundo">
                                            <option value="selected" selected disabled>[SELECCIONE INDICADOR DEL FORMULARIO Nº 2]</option>
                                            @foreach ($formulario2 as $lis)
                                                <option value="{{ $lis->id }}">[{{ $lis->indicador->codigo }}] {{ $lis->indicador->descripcion }} </option>
                                            @endforeach
                                        </select>
                                        <div id="_indicador_formulario2_" ></div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" id="politica_desarrolloEdi">
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" id="objetivo_estrategicoEdi">
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" id="objetivo_instuitucionalEdi">
                            </div>
                        </div>

                        <fieldset>
                            <legend>TIPO - CATEGORIA - RESULTADO O PRODUCTO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="tipo_" class="col-form-label">Seleccione Tipo</label>
                                    <select name="tipo_" id="tipo_" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                        @foreach ($tipo as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_tipo_" ></div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="categoria_" class="col-form-label">Seleccione Categoria</label>
                                    <select name="categoria_" id="categoria_" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE CATEGORIA]</option>
                                        @foreach ($categoria as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_categoria_" ></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>BIEN, NORMA O SERVICIO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2"  >
                                    <label for="bien_servicio_" class="col-form-label">Seleccione Bien, Norma o Servicio</label>
                                    <select name="bien_servicio_" id="bien_servicio_" class="form-select form-control">
                                        <option value="selected" selected disabled>[SELECCIONE BIEN, NORMA O SERVICIO]</option>
                                        @foreach ($bien_sevicio as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_bien_servicio_" ></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>PROGRAMACIÓN DEL RESULTADO ( PRODUCTO (N° o %))</legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="primer_semestre_" class="form-label">Primer Semestre</label>
                                        <input type="text" class="form-control" id="primer_semestre_" name="primer_semestre_"
                                            placeholder="Descripción de 1er semestre" maxlength="4">
                                        <div id="_primer_semestre_"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="segundo_semestre_" class="form-label">Segundo Semestre</label>
                                        <input type="text" class="form-control" id="segundo_semestre_" name="segundo_semestre_"
                                            placeholder="Descripción de 2do Semestre" maxlength="4">
                                        <div id="_segundo_semestre_"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="meta_anual_" class="form-label">Meta Anual</label>
                                        <input type="text" class="form-control" id="meta_anual_" name="meta_anual_"
                                            placeholder="Descripción de Meta Anual" maxlength="4">
                                        <div id="_meta_anual_"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>UNIDADES RESPONSABLES DE META</legend>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2" >
                                <div class="mb-2">
                                    <label for="unidades_responsable_" class="col-form-label">Seleccione Unidad responsable de meta</label>
                                    <select name="unidades_responsable_" id="unidades_responsable_" class="select2_segundo">
                                        <option value="selected" selected disabled>[SELECCIONE UNIDAD RESPONSABLE]</option>
                                        @foreach ($unidades as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->nombre_completo }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_unidades_responsable_" ></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarF4editar"> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA VER DETALLES DE CLASIFICADOR PRESUPÚESTARIO-->
    <div class="modal slide" id="Modal_asignarEjecucion_presupuestaria" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">ASIGNACIÓN</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_asignacion_form4()"></button>
                </div>
                <div class="modal-body">
                    <div id="mostrar_saldo_total" class="text-center">

                    </div>
                    <form id="form_asignarformulario4" method="post" autocomplete="off">
                        <input type="hidden" name="formulario4_id_asignar" id="formulario4_id_asignar">
                        <input type="hidden" name="caja_id" id="caja_id">
                        <input type="hidden" name="gestiones_id" id="gestiones_id" value="{{ $gestiones->id }}">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                                <div class="mb-3">
                                    <label for="tipo_financiamiento" class="form-label">Tipo de Financiamiento</label>
                                    <select name="tipo_financiamiento" id="tipo_financiamiento" class="form-select select2_tercero" onchange="tipo_financiamientoTengo(this.value)">
                                        <option selected disabled>[SELECCIONE TIPO DE FINANCIAMIENTO]</option>
                                    </select>
                                    <div id="_tipo_financiamiento"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4" id="ver_monto_catualCaja">
                            </div>
                        </div>

                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="monto_asignar" class="form-label">Monto Asignar</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Bs</span>
                                        <input type="text" name="monto_asignar" id="monto_asignar" class="form-control monto_number" onkeyup="validar_montos(this.value)" disabled>
                                        <div id="_monto_asignar"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Monto Sobrante</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Bs</span>
                                        <input type="text" class="form-control" id="monto_sobrante_ver" name="monto_sobrante_ver" readonly disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <button class="btn btn-outline-primary" id="btn_guardarasignacionf4" disabled>Guardar</button>
                                </div>
                            </div>
                            <input type="hidden" id="monto_actual" name="monto_actual">
                            <input type="hidden" id="monto_sobrante" name="monto_sobrante">
                            <input type="hidden" id="monto_concomas" name="monto_concomas">
                        </div>
                    </form>
                    <div class="table-responsive" id = "listar_asignacion_financiamiento_html" >
                    </div>

                    <div id="editar_financiamiento_html" >
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        select2_rodry('#nuevo_formulario4');
        let id_configf = {{ $configuracion_formulado->id }};
        let id_gestiones = {{ $gestiones->id }};
        //para validar que el solo se seleccione una vez el
        function validarUnicoform4(id){
            $.ajax({
                type: "POST",
                url: "{{ route('poa_validarf4f2') }}",
                data: {
                    id_configf:id_configf,
                    id_gestiones:id_gestiones,
                    id_formulario2:id,
                },
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('_indicador_formulario2').innerHTML = '';
                        document.getElementById('btn_guardarF4').disabled = false;
                        if(data.form2_rel !=null){
                            document.getElementById('vizualizar_detalles').innerHTML = `
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" >
                                    <fieldset id="success_fieldset" >
                                        <legend id="success_legend" >POLÍTICA DE DESARROLLO</legend>
                                        <p>`+data.form2_rel.politica_desarrollo_pei[0].descripcion+`</p>
                                    </fieldset>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" >
                                    <fieldset id="success_fieldset">
                                        <legend id="success_legend">OBJETIVO ESTRATEGICO (SUB)</legend>
                                        <p>`+data.form2_rel.objetivo_estrategico_sub[0].descripcion+`</p>
                                    </fieldset>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" >
                                    <fieldset id="success_fieldset">
                                        <legend id="success_legend" >OBJETIVO INSTITUCIONAL</legend>
                                        <p>`+data.form2_rel.politica_desarrollo_pei[0].descripcion+`</p>
                                    </fieldset>
                                </div>
                            `;
                        }

                    }
                    if(data.tipo==='error'){
                        document.getElementById('_indicador_formulario2').innerHTML = `<p id="error_in" >`+data.mensaje+`</p>`;
                        document.getElementById('btn_guardarF4').disabled = true;
                        if(data.form2_rel !=null){
                            document.getElementById('vizualizar_detalles').innerHTML = `
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" >
                                    <fieldset id="error_fieldset">
                                        <legend id="error_legend" >POLÍTICA DE DESARROLLO</legend>
                                        <p>`+data.form2_rel.politica_desarrollo_pei[0].descripcion+`</p>
                                    </fieldset>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" >
                                    <fieldset id="error_fieldset">
                                        <legend id="error_legend">OBJETIVO ESTRATEGICO (SUB)</legend>
                                        <p>`+data.form2_rel.objetivo_estrategico_sub[0].descripcion+`</p>
                                    </fieldset>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 py-2" >
                                    <fieldset id="error_fieldset">
                                        <legend id="error_legend">OBJETIVO INSTITUCIONAL</legend>
                                        <p>`+data.form2_rel.politica_desarrollo_pei[0].descripcion+`</p>
                                    </fieldset>
                                </div>
                            `;
                        }

                    }
                }
            });
        }

        //para guardar el formulario N4
        $(document).on('click', '#btn_guardarF4', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_formulario4'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_guardar_formulario4') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciar_erroresform4();
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#nuevo_AEarticulacion').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para vaciar errrores del form4
        function vaciar_erroresform4(){
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_indicador_formulario2').innerHTML = '';
            document.getElementById('_tipo').innerHTML = '';
            document.getElementById('_categoria').innerHTML = '';
            document.getElementById('_bien_servicio').innerHTML = '';
            document.getElementById('_primer_semestre').innerHTML = '';
            document.getElementById('_segundo_semestre').innerHTML = '';
            document.getElementById('_meta_anual').innerHTML = '';
            document.getElementById('_unidades_responsable').innerHTML = '';
        }
        //para cerrar el modal
        function cerrarModalf4(){
            vaciar_erroresform4();
            limpiar_campos('form_formulario4');
            $("#btn_guardarF4").prop("disabled", true);
            document.getElementById('vizualizar_detalles').innerHTML = '';
            $(".select2").val('selected').trigger('change.select2');
        }
        //function para editar el 4to formulado
        segundo_select2('#editar_formulario4');
        function editarForm4(id){
            $.ajax({
                type: "POST",
                url: "{{ route('poa_editarform4') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    vaciar_erroresform4_editar();
                    if(data.tipo==='success'){
                        $('#editar_formulario4').modal('show');
                        document.getElementById('formulario4_id').value = data.mensaje.id;
                        document.getElementById('codigo_').value = data.mensaje.codigo;
                        $('#indicador_formulario2_').val(data.mensaje.formulario2_id).trigger('change.select2');
                        document.getElementById('tipo_').value = data.mensaje.tipo_id;
                        document.getElementById('categoria_').value = data.mensaje.categoria_id;
                        document.getElementById('bien_servicio_').value = data.mensaje.bnservicio_id;
                        document.getElementById('primer_semestre_').value = data.mensaje.primer_semestre;
                        document.getElementById('segundo_semestre_').value = data.mensaje.segundo_semestre;
                        document.getElementById('meta_anual_').value = data.mensaje.meta_anual;
                        $('#unidades_responsable_').val(data.mensaje.unidad_responsable[0].id).trigger('change.select2');
                        document.getElementById('politica_desarrolloEdi').innerHTML = `
                            <fieldset>
                                <legend >POLÍTICA DE DESARROLLO</legend>
                                <p>`+data.mensaje.formulario2.politica_desarrollo_pei[0].descripcion+`</p>
                            </fieldset>
                        `;

                        document.getElementById('objetivo_estrategicoEdi').innerHTML = `
                            <fieldset>
                                <legend>OBJETIVO ESTRATEGICO (SUB)</legend>
                                <p>`+data.mensaje.formulario2.objetivo_estrategico_sub[0].descripcion+`</p>
                            </fieldset>
                        `;

                        document.getElementById('objetivo_instuitucionalEdi').innerHTML = `
                            <fieldset>
                                <legend >OBJETIVO INSTITUCIONAL</legend>
                                <p>`+data.mensaje.formulario2.objetivo_institucional[0].descripcion+`</p>
                            </fieldset>
                        `;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        //para verficaar cuando editamos si esta siendo utilizado o no
        let indicador_formulario2_select2 = $("#indicador_formulario2_");
        indicador_formulario2_select2.on('select2:select', (e)=>{
            e.preventDefault();
            let id_form2 = indicador_formulario2_select2.val();
            let id_form4 = document.getElementById('formulario4_id').value;
            $.ajax({
                type: "POST",
                url: "{{ route('poa_validarf4f2edi') }}",
                data: {
                    id_form2    : id_form2,
                    id_form4    : id_form4,
                    id_configf  : id_configf,
                    id_gestiones: id_gestiones,
                },
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('btn_guardarF4editar').disabled = false;
                        document.getElementById('_indicador_formulario2_').innerHTML = '';
                        if(data.formulario2f4 !=null){
                            document.getElementById('politica_desarrolloEdi').innerHTML = `
                                <fieldset id="success_fieldset">
                                    <legend id="success_legend">POLÍTICA DE DESARROLLO</legend>
                                    <p>`+data.formulario2f4.politica_desarrollo_pei[0].descripcion+`</p>
                                </fieldset>
                            `;

                            document.getElementById('objetivo_estrategicoEdi').innerHTML = `
                                <fieldset id="success_fieldset">
                                    <legend id="success_legend">OBJETIVO ESTRATEGICO (SUB)</legend>
                                    <p>`+data.formulario2f4.objetivo_estrategico_sub[0].descripcion+`</p>
                                </fieldset>
                            `;

                            document.getElementById('objetivo_instuitucionalEdi').innerHTML = `
                                <fieldset id="success_fieldset">
                                    <legend id="success_legend">OBJETIVO INSTITUCIONAL</legend>
                                    <p>`+data.formulario2f4.objetivo_institucional[0].descripcion+`</p>
                                </fieldset>
                            `;
                        }
                    }
                    if(data.tipo==='error'){
                        document.getElementById('btn_guardarF4editar').disabled = true;
                        document.getElementById('_indicador_formulario2_').innerHTML = `<p id="error_in" >`+data.mensaje+`</p>`;
                        if(data.formulario2f4 !=null){
                            document.getElementById('politica_desarrolloEdi').innerHTML = `
                                <fieldset id="error_fieldset">
                                    <legend id="error_legend">POLÍTICA DE DESARROLLO</legend>
                                    <p>`+data.formulario2f4.politica_desarrollo_pei[0].descripcion+`</p>
                                </fieldset>
                            `;
                            document.getElementById('objetivo_estrategicoEdi').innerHTML = `
                                <fieldset id="error_fieldset">
                                    <legend id="error_legend">OBJETIVO ESTRATEGICO (SUB)</legend>
                                    <p>`+data.formulario2f4.objetivo_estrategico_sub[0].descripcion+`</p>
                                </fieldset>
                            `;

                            document.getElementById('objetivo_instuitucionalEdi').innerHTML = `
                                <fieldset id="error_fieldset">
                                    <legend id="error_legend">OBJETIVO INSTITUCIONAL</legend>
                                    <p>`+data.formulario2f4.objetivo_institucional[0].descripcion+`</p>
                                </fieldset>
                            `;
                        }
                    }
                }
            });
        });

        //para guardar el formulario4 editado
        $(document).on('click', '#btn_guardarF4editar', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_formulario4_editado'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_editarform4guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciar_erroresform4_editar();
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#editar_formulario4').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para vaciar errores del formulario 4 editar
        function vaciar_erroresform4_editar(){
            document.getElementById('_codigo_').innerHTML = '';
            document.getElementById('_indicador_formulario2_').innerHTML = '';
            document.getElementById('_tipo_').innerHTML = '';
            document.getElementById('_categoria_').innerHTML = '';
            document.getElementById('_bien_servicio_').innerHTML = '';
            document.getElementById('_primer_semestre_').innerHTML = '';
            document.getElementById('_segundo_semestre_').innerHTML = '';
            document.getElementById('_meta_anual_').innerHTML = '';
            document.getElementById('_unidades_responsable_').innerHTML = '';
        }

        //para la parte de asignacion de dinero
        tercero_select2('#Modal_asignarEjecucion_presupuestaria');
        function asignar_financiadoF4(id){
            $.ajax({
                type: "POST",
                url: "{{ route('poa_asigarPresupuestoIndicador') }}",
                data: {
                    id:id,
                    id_gestiones:id_gestiones
                },
                dataType: "JSON",
                success: function (data) {
                    $('#Modal_asignarEjecucion_presupuestaria').modal('show');
                    document.getElementById('editar_financiamiento_html').innerHTML = '';
                    document.getElementById('mostrar_saldo_total').innerHTML=`
                        <div class="alert alert-primary" role="alert">
                            <strong>Monto Actual : `+data.suma_total+` Bs</strong>
                        </div>
                    `;
                    $('#tipo_financiamiento').empty().append(
                        '<option selected disabled>[SELECCIONE TIPO DE FINANCIAMIENTO]</option>'
                    );
                    document.getElementById('formulario4_id_asignar').value = id;
                    document.getElementById('monto_asignar').value = '';
                    document.getElementById('monto_sobrante_ver').value = '';
                    document.getElementById('monto_actual').value = '';
                    document.getElementById('monto_sobrante').value = '';
                    document.getElementById('monto_asignar').disabled = true;
                    document.getElementById('monto_concomas').value = '';
                    document.getElementById('btn_guardarasignacionf4').disabled = true;
                    document.getElementById('caja_id').value = '';
                    let cajar_it = data.caja;
                    cajar_it.forEach(value => {
                        if(value.financiamiento_tipo.asignacion_monto_formulario4.length === 0){
                            let fin_tipo = value.financiamiento_tipo;
                            //aqui agarramos el id de la caja principal
                            $('#tipo_financiamiento').append('<option value = "' + fin_tipo.id + '">' + '['+fin_tipo.sigla+']'+ fin_tipo.descripcion +'</option>');
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ route('poa_listar_asignacion_montor') }}",
                        data: {id:id},
                        success: function (resp) {
                            document.getElementById('listar_asignacion_financiamiento_html').innerHTML = resp;
                        }
                    });
                }
            });
        }
        //para saber cuanto de saldo tengo
        function tipo_financiamientoTengo(id){
            document.getElementById('monto_asignar').value = '';
            $.ajax({
                type: "POST",
                url: "{{ route('poa_verificar_cuanto_en_caja') }}",
                data: {
                    id:id,
                    id_gestiones:id_gestiones,
                },
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('ver_monto_catualCaja').innerHTML=`
                        <div class="mb-3">
                            <label for=""></label>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>`+data.monto_comas+' Bs'+`</strong>
                            </div>
                        </div>
                        `;
                        document.getElementById('monto_actual').value = data.monto_normal;
                        document.getElementById('monto_asignar').disabled = false;
                        document.getElementById('monto_concomas').value = data.monto_comas;
                        document.getElementById('monto_sobrante_ver').value = '';
                        document.getElementById('monto_sobrante').value = '';
                        document.getElementById('caja_id').value = data.id_caja;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para cerrar el modal de asignacion de montos
        function cerrar_modal_asignacion_form4(){
            /* document.getElementById('ver_monto_catualCaja').innerHTML='';
            $('#tipo_financiamiento').empty().append(
                '<option selected disabled>[SELECCIONE TIPO DE FINANCIAMIENTO]</option>'
            ); */
            window.location = '';
        }

        function validar_montos(monto_ingresado){
            if(monto_ingresado.length > 0){
                let monto_ingresado_validado =  monto_validado_enviado(monto_ingresado);
                let monto_actual = document.getElementById('monto_actual').value;
                let monto_conComas = document.getElementById('monto_concomas').value;
                $.ajax({
                    type: "POST",
                    url: "{{ route('poa_validar_montos_asignar') }}",
                    data: {
                        monto_ingresado_validado:monto_ingresado_validado,
                        monto_actual:monto_actual
                    },
                    dataType: "JSON",
                    success: function (data) {
                        if(data.tipo==='success'){
                            document.getElementById('monto_sobrante_ver').value = data.monto_sobrante_comas;
                            document.getElementById('monto_sobrante').value = data.monto_sobrante_comas;
                            document.getElementById('btn_guardarasignacionf4').disabled = false;
                        }
                        if(data.tipo==='error'){
                            alerta_top(data.tipo, data.mensaje);
                            document.getElementById('monto_asignar').value = monto_conComas;
                            document.getElementById('monto_sobrante_ver').value = data.monto_sobrante_comas;
                            document.getElementById('monto_sobrante').value = '';
                            document.getElementById('btn_guardarasignacionf4').disabled = true;
                        }
                    }
                });
            }else{
                document.getElementById('monto_sobrante_ver').value = '';
                document.getElementById('monto_sobrante').value = '';
                document.getElementById('btn_guardarasignacionf4').disabled = true;
            }
        }
        //para guardar la asignacion
        $(document).on('click', '#btn_guardarasignacionf4', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_asignarformulario4'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_guardar_asignacion_monto') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo==='success'){
                        alerta_top(data.tipo, data.mensaje);
                        asignar_financiadoF4(data.id_formulario4_recuperado);
                        document.getElementById('ver_monto_catualCaja').innerHTML = '';
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para editar el monto del financiamiento del indicador y form 4
        function editar_financiamiento_f4(id_form4, id_asignacion_f4){
            $.ajax({
                type: "POST",
                url: "{{ route('poa_editar_financiamientoMonto') }}",
                data: {
                    id_form4:id_form4,
                    id_asignacion_f4:id_asignacion_f4,
                    id_gestiones:id_gestiones,
                },
                success: function (data) {
                    document.getElementById('editar_financiamiento_html').innerHTML = data;
                }
            });
        }



        function solo_decimadinero(event){
            if(event != ''){
                //para el separador de miles
                $(".monto_fig").on({
                    "focus": function(event) {
                        $(event.target).select();
                    },
                    "keyup": function(event) {
                        $(event.target).val(function(index, value) {
                            return value.replace(/\D/g, "")
                                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        });
                    }
                });

                //seleccionado si es sumar o restar
                let accion_sum_res = document.getElementById('accion_').value;
                //convertimos el monto
                let monto_nuevo_asignar = monto_validado_enviado(event);
                //el motno a restar
                let monto_restar = document.getElementById('monto_asignado_f4_edi').value;
                //monto asignado
                let monto_asignado_f4 = document.getElementById('monto_asignado_f4_edi').value;
                //el monto actual
                let monto_actual = document.getElementById('monto_actual_en_caja_edi').value;
                //el asignacion monto formulario 4
                let asignacionf4_id = document.getElementById('asignacionf4_id').value;

                if(accion_sum_res=='sumar'){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('poa_asignar_fina_sumar') }}",
                        data: {
                            monto_nuevo_asignar : monto_nuevo_asignar,
                            monto_actual        : monto_actual,
                            monto_asignado_f4   : monto_asignado_f4,
                            asignacionf4_id     : asignacionf4_id,
                        },
                        dataType: "JSON",
                        success: function (data) {
                            if(data.tipo==='success'){
                                document.getElementById('monto_sobrante_env__').value                           = data.monto_sobrante;
                                document.getElementById('monto_sobrante_ver__').value                           = data.monto_sobrante;
                                document.getElementById('monto_asignar_env__').value                            = data.monto_asignacion_nuevo;
                                document.getElementById('monto_asignar_env').value                              = data.monto_asignacion_nuevo;
                                document.getElementById('btn_guardarasignacionf4_asignacionEditar').disabled    = false;
                            }
                            if(data.tipo==='error'){
                                alerta_top(data.tipo, data.mensaje);
                                document.getElementById('monto_asignar__').value        = 0;
                                document.getElementById('monto_sobrante_env__').value   = '';
                                document.getElementById('monto_sobrante_ver__').value   = '';
                                document.getElementById('monto_asignar_env__').value    = '';
                                document.getElementById('monto_asignar_env').value      = '';
                                document.getElementById('btn_guardarasignacionf4_asignacionEditar').disabled    = true;
                            }
                        }
                    });
                }else if(accion_sum_res=='restar'){
                    $.ajax({
                        type: "POST",
                        url: "{{ route('poa_asignar_fina_restar') }}",
                        data: {
                            monto_nuevo_asignar : monto_nuevo_asignar,
                            monto_actual        : monto_actual,
                            monto_asignado_f4   : monto_asignado_f4,
                            asignacionf4_id     : asignacionf4_id,
                        },
                        dataType: "JSON",
                        success: function (data) {
                            if(data.tipo==='success'){
                                document.getElementById('monto_sobrante_env__').value                           = data.monto_sobrante;
                                document.getElementById('monto_sobrante_ver__').value                           = data.monto_sobrante;
                                document.getElementById('monto_asignar_env__').value                            = data.monto_asignacion_nuevo;
                                document.getElementById('monto_asignar_env').value                              = data.monto_asignacion_nuevo;
                                document.getElementById('btn_guardarasignacionf4_asignacionEditar').disabled    = false;
                            }
                            if(data.tipo==='error'){
                                alerta_top(data.tipo, data.mensaje);
                                document.getElementById('monto_asignar__').value        = 0;
                                document.getElementById('monto_sobrante_env__').value   = '';
                                document.getElementById('monto_sobrante_ver__').value   = '';
                                document.getElementById('monto_asignar_env__').value    = '';
                                document.getElementById('monto_asignar_env').value      = '';
                                document.getElementById('btn_guardarasignacionf4_asignacionEditar').disabled    = true;
                            }
                        }
                    });
                }
            }else{
                document.getElementById('monto_asignar__').value        = '';
                document.getElementById('monto_sobrante_env__').value   = '';
                document.getElementById('monto_asignar__').disabled     = false;
                document.getElementById('monto_sobrante_ver__').value   = '';
                document.getElementById('monto_asignar_env').value      = '';
                document.getElementById('monto_asignar_env__').value    = '';
                document.getElementById('btn_guardarasignacionf4_asignacionEditar').disabled    = true;
            }

        }

        //para ver si es sumar o restar
        function accion_usar(accion){
            if(accion != 'selected'){
                if(accion=='sumar'){
                    document.getElementById('monto_ver_nn').innerHTML = 'Monto: Sumar';
                }else if(accion=='restar'){
                    document.getElementById('monto_ver_nn').innerHTML = 'Monto: Restar';
                }
                document.getElementById('monto_asignar__').value        = '';
                document.getElementById('monto_sobrante_env__').value   = '';
                document.getElementById('monto_asignar__').disabled     = false;
                document.getElementById('monto_sobrante_ver__').value   = '';
                document.getElementById('monto_asignar_env').value      = '';
                document.getElementById('monto_asignar_env__').value    = '';
                document.getElementById('btn_guardarasignacionf4_asignacionEditar').disabled    = true;
            }
        }

        //para guardar lo editado
        $(document).on('click', '#btn_guardarasignacionf4_asignacionEditar', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_asignarformulario4_asignacionEditar'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_guardar_datos_editados_financiamiento') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo==='success'){
                        alerta_top(data.tipo, data.mensaje);
                        asignar_financiadoF4(data.id_formulario_f4);
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
    </script>
@endsection
