@extends('principal')
@section('titulo', 'Formulario Nº 2')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="page-title">
                        <h5>TIPO : {{ $tipo_formulado->descripcion }}</h5>
                        <h5>FORMULARIO Nº 2 </h5>
                        <h5>GESTIÓN : {{ $gestiones->gestion }}</h5>
                        <h5>{{ $carrera_unidad->nombre_completo }}</h5>
                        <h5>ÁREA ESTRATÉGICA : {{ $area_estrategica->descripcion }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid">
        <div class="card-box-style">
            <div class="others-title d-flex align-items-center">
                <h3></h3>
                <div class=" ms-auto position-relative">
                    <button type="button" class="btn btn-outline-primary" onclick="modal_nueveAEart()"> <i class="bx bxs-add-to-queue"></i> Nuevo </button>
                </div>
            </div>
            <div id="table-responsive" >
                <table class="table table-striped table-hover" id="debilidad_tabla" style="width: 100%" >
                    <thead class="text-center">
                        <tr>
                            <th>ACCIONES</th>
                            <th>CODIGO</th>
                            <th>PDES</th>
                            <th>CÓDIGO</th>
                            <th>OBJETIVO ESTRATEGICO (PDU)</th>
                            <th>CÓDIGO</th>
                            <th>OBJETIVO ESTRATEGICO INSTITUCIONAL (PEI)</th>
                            <th>CÓDIGO</th>
                            <th>INDICADOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listarForm2_AEstrategica as $lis)
                            <tr>
                                <td class="text-center">
                                    <button class="btn btn-outline-warning btn-sm" onclick="editarForm2AE('{{ $pdes->id }}', '{{ $lis->id }}')" ><i class="ri-edit-2-fill"></i></button>
                                </td>
                                <td>
                                    {{ $lis->codigo }}
                                </td>
                                <td>{{ 'Eje '.$pdes->codigo_eje.' Meta '.$pdes->codigo_meta.' Acción '.$pdes->codigo_accion.' '.$pdes->descripcion_accion }}</td>
                                <td>
                                    @foreach ($lis->objetivo_estrategico as $lisOE)
                                        {{ $lisOE->codigo }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($lis->objetivo_estrategico as $lisOE)
                                        {{ $lisOE->descripcion }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($lis->objetivo_institucional as $lisOEI)
                                        {{ $lisOEI->codigo }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($lis->objetivo_institucional as $lisOEI)
                                        {{ $lisOEI->descripcion }}
                                    @endforeach
                                </td>
                                <td>
                                    {{ $lis->indicador->codigo }}
                                </td>
                                <td>
                                    {{ $lis->indicador->descripcion }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO --}}
    <div class="modal slide" id="nuevo_AEarticulacion" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modalAE()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_EAarticulacion" method="POST" autocomplete="off">
                        <input type="hidden" name="areaestrategica_id" value="{{ $area_estrategica->id }}">
                        <input type="hidden" name="formulario1_id" value="{{ $formulario1->id }}">
                        <input type="hidden" name="configFormulado_id" value="{{ $formulario1->configFormulado_id }}">
                        <input type="hidden" name="gestiones_id" value="{{ $gestiones->id }}">
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
                                    <legend>PLAN DE DESARROLLO ESTRATÉGICO Y SOCIAL (PDES)</legend>
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                                                <div class="alert alert-primary" role="alert">
                                                    <h5 class="alert-heading">Eje : {{ $pdes->codigo_eje }}</h5>
                                                    <p>{{ $pdes->descripcion_eje }}</p>
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
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="politica_desarrollo_pdu" class="col-form-label">Seleccione Política de Desarrollo</label>
                                    <select name="politica_desarrollo_pdu" id="politica_desarrollo_pdu" class="select2" onchange="obj_estrategico_pduAE(this.value)">
                                        <option value="selected" selected disabled>[SELECCIONE LA POLÍTICA DE DESARROLLO]</option>
                                        @foreach ($politica_desarrolloPDU as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_desarrollo_pdu" ></div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2" >
                                    <label for="objetivo_estrategico_pdu" class="col-form-label">Seleccione Objetivo Estratégico</label>
                                    <select name="objetivo_estrategico_pdu" id="objetivo_estrategico_pdu" class="select2">
                                        <option value="selected" selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_pdu" ></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PLAN ESTRATÉGICO INSTITUCIONAL (PEI)</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="obj_politica_institucional_pei" class="col-form-label">Seleccione Politica Institucional</label>
                                    <select name="politica_institucional_pei" id="politica_institucional_pei" class="select2" onchange="obj_estrategico_subAE(this.value)">
                                        <option value="selected" selected disabled>[SELECCIONE LA POLITICA INSTITUCIONAL]</option>
                                        @foreach ($politica_institucionalPEI as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_institucional_pei"></div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2" >
                                    <label for="objetivo_estrategico_sub" class="col-form-label">Seleccione Objetivo Estratégico (SUB)</label>
                                    <select name="objetivo_estrategico_sub" id="objetivo_estrategico_sub" class="select2" onchange="objetivo_estrategico_inst_peiAE(this.value)">
                                        <option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_sub" ></div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2" >
                                    <label for="objetivo_estrategico_institucional" class="col-form-label">Seleccione Objetivo Estratégico Institucional</label>
                                    <select name="objetivo_estrategico_institucional" id="objetivo_estrategico_institucional" class="select2">
                                        <option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_institucional" ></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>INDICADOR ESTRATÉGICO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2"  >
                                    <label for="indicador_estrategico" class="col-form-label">Seleccione Indicador Estratégico</label>
                                    <select name="indicador_estrategico" id="indicador_estrategico" class="select2" onchange="validarExisteIndicador(this.value)">
                                        <option value="selected" selected disabled>[SELECCIONE EL INDICADOR ESTRATÉGICO]</option>
                                        @foreach ($matriz_areaestrategica_indicador as $lis)
                                            <option value="{{ $lis->indicador_pei->id }}">  [{{ $lis->indicador_pei->codigo }}] {{ $lis->indicador_pei->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_indicador_estrategico" ></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modalAE()" >Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarAE" @disabled(true)> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL EDITAR --}}
    <div class="modal slide" id="editar_AEarticulacion" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModalAE()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_EAarticulacionEditado" method="POST" autocomplete="off">
                        <input type="hidden" name="formulario2Edi_id" id="formulario2Edi_id">
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
                                    <legend>PLAN DE DESARROLLO ESTRATÉGICO Y SOCIAL (PDES)</legend>
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                                                <div class="alert alert-primary" role="alert">
                                                    <h5 class="alert-heading">Eje : {{ $pdes->codigo_eje }}</h5>
                                                    <p>{{ $pdes->descripcion_eje }}</p>
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
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="politica_desarrollo_pdu" class="col-form-label">Seleccione Política de Desarrollo</label>
                                    <select name="politica_desarrollo_pdu_" id="politica_desarrollo_pdu_" class="select2_segundo">
                                        <option value="selected" selected disabled>[SELECCIONE LA POLÍTICA DE DESARROLLO]</option>
                                        @foreach ($politica_desarrolloPDU as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_desarrollo_pdu_" ></div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2" >
                                    <label for="objetivo_estrategico_pdu_" class="col-form-label">Seleccione Objetivo Estratégico</label>
                                    <select name="objetivo_estrategico_pdu_" id="objetivo_estrategico_pdu_" class="select2_segundo">
                                        <option value="selected" selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_pdu_" ></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>PLAN ESTRATÉGICO INSTITUCIONAL (PEI)</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2"  >
                                    <label for="obj_politica_institucional_pei_" class="col-form-label">Seleccione Politica Institucional</label>
                                    <select name="politica_institucional_pei_" id="politica_institucional_pei_" class="select2_segundo" onchange="obj_estrategico_subAE(this.value)">
                                        <option value="selected" selected disabled>[SELECCIONE LA POLITICA INSTITUCIONAL]</option>
                                        @foreach ($politica_institucionalPEI as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_politica_institucional_pei_"></div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2" >
                                    <label for="objetivo_estrategico_sub_" class="col-form-label">Seleccione Objetivo Estratégico (SUB)</label>
                                    <select name="objetivo_estrategico_sub_" id="objetivo_estrategico_sub_" class="select2_segundo" onchange="objetivo_estrategico_inst_peiAE(this.value)">
                                        <option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_sub_" ></div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2" >
                                    <label for="objetivo_estrategico_institucional_" class="col-form-label">Seleccione Objetivo Estratégico Institucional</label>
                                    <select name="objetivo_estrategico_institucional_" id="objetivo_estrategico_institucional_" class="select2_segundo">
                                        <option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>
                                    </select>
                                    <div id="_objetivo_estrategico_institucional_" ></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>INDICADOR ESTRATÉGICO</legend>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2"  >
                                    <label for="indicador_estrategico_" class="col-form-label">Seleccione Indicador Estratégico</label>
                                    <select name="indicador_estrategico_" id="indicador_estrategico_" class="select2_segundo">
                                        <option value="selected" selected disabled>[SELECCIONE EL INDICADOR ESTRATÉGICO]</option>
                                        @foreach ($matriz_areaestrategica_indicador as $lis)
                                            <option value="{{ $lis->indicador_pei->id }}">  [{{ $lis->indicador_pei->codigo }}] {{ $lis->indicador_pei->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_indicador_estrategico_" ></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrarModalAE()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarAEditado"> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        select2_rodry('#nuevo_AEarticulacion');
        function modal_nueveAEart(){
            $('#nuevo_AEarticulacion').modal('show');
        }

        //para listar los objetivos estrategicos de PDU
        function obj_estrategico_pduAE(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#objetivo_estrategico_pdu').empty().append(
                        '<option selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_pdu').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }
        //para listar los objetivos estrategicos de la SUB
        function obj_estrategico_subAE(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_sub') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {

                    $('#objetivo_estrategico_institucional').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
                    );
                    $('#objetivo_estrategico_sub').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_sub').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }
        //para listar los objetivos institucionales
        function objetivo_estrategico_inst_peiAE(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_institucional') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#objetivo_estrategico_institucional').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_institucional').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }

        //para guardar formulario Nº2 area estrategica
        $(document).on('click', '#btn_guardarAE', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_EAarticulacion'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_guardarform2') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    limpiar_erroresAE();
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
        //para la parte de errores
        function limpiar_erroresAE(){
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_politica_desarrollo_pdu').innerHTML = '';
            document.getElementById('_objetivo_estrategico_pdu').innerHTML = '';
            document.getElementById('_politica_institucional_pei').innerHTML = '';
            document.getElementById('_objetivo_estrategico_sub').innerHTML = '';
            document.getElementById('_objetivo_estrategico_institucional').innerHTML = '';
            document.getElementById('_indicador_estrategico').innerHTML = '';
        }
        //para cerrar el modal
        function cerrar_modalAE(){
            limpiar_erroresAE();
            $(".select2").val('selected').trigger('change');
            limpiar_campos('form_EAarticulacion');
            $('#objetivo_estrategico_pdu').empty().append(
                '<option value="selected" selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
            );

            $('#objetivo_estrategico_institucional').empty().append(
                '<option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
            );
            $('#objetivo_estrategico_sub').empty().append(
                '<option value="selected" selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>'
            );
        }
        //aqui tenemos el ID que llega
        let id_ges = {{ $gestiones->id }};
        let id_config = {{ $configuracion_formulado->id }};
        //para validar si ya existe el registro en la table XD
        function validarExisteIndicador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('poa_validarExisteIndicador') }}",
                data: {id:id,id_ges:id_ges,id_config:id_config},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('_indicador_estrategico').innerHTML=`<p id="error_in" >`+data.mensaje+`</p>`;
                        document.getElementById('btn_guardarAE').disabled = true;
                    }
                    if(data.tipo==='error'){
                        document.getElementById('_indicador_estrategico').innerHTML='';
                        document.getElementById('btn_guardarAE').disabled = false;
                    }
                }
            });
        }


        segundo_select2('#editar_AEarticulacion');
        //para editar el formulario 2
        function editarForm2AE(id_pdes, id_form2){
            $.ajax({
                type: "POST",
                url: "{{ route('poa_editarform2') }}",
                data: {
                    id_pdes:id_pdes,
                    id_form2:id_form2
                },
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_AEarticulacion').modal('show');
                        document.getElementById('formulario2Edi_id').value = data.formulario2_edi.id;
                        document.getElementById('codigo_').value =data.formulario2_edi.codigo;
                        $('#politica_desarrollo_pdu_').val(data.formulario2_edi.politica_desarrollo_pdu[0].id).trigger('change');
                        //para el objetivo estrategico
                        data.objetivo_estrategico_edi.forEach(value => {
                            $('#objetivo_estrategico_pdu_').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                        $('#objetivo_estrategico_pdu_').val(data.formulario2_edi.objetivo_estrategico[0].id).trigger('change');
                        //para la politica institucional PEI
                        $('#politica_institucional_pei_').val(data.formulario2_edi.politica_desarrollo_pei[0].id).trigger('change');
                        //para la parte de objetivo estrategico SUB
                        data.objetivo_estrategico_sub_edi.forEach(value => {
                            $('#objetivo_estrategico_sub_').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                        $('#objetivo_estrategico_sub_').val(data.formulario2_edi.objetivo_estrategico_sub[0].id).trigger('change');
                        //para la parte de objetivo institucional
                        data.objetivo_institucional_edi.forEach(value => {
                            $('#objetivo_estrategico_institucional_').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                        $('#objetivo_estrategico_institucional_').val(data.formulario2_edi.objetivo_institucional[0].id).trigger('change');
                        //para la parte de indicador
                        $('#indicador_estrategico_').val(data.formulario2_edi.indicador_id).trigger('change');
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }
        //para cerrar el modal
        function cerrarModalAE(){
            $('#objetivo_estrategico_pdu_').empty().append(
                '<option selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
            );
            $('#objetivo_estrategico_institucional_').empty().append(
                '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
            );
            $('#objetivo_estrategico_sub_').empty().append(
                '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>'
            );
            vaciarErroresAE();
        }

        //para vaciar errores editar
        function vaciarErroresAE(){
            document.getElementById('_codigo_').innerHTML = '';
            document.getElementById('_politica_desarrollo_pdu_').innerHTML = '';
            document.getElementById('_objetivo_estrategico_pdu_').innerHTML = '';
            document.getElementById('_politica_institucional_pei_').innerHTML = '';
            document.getElementById('_objetivo_estrategico_sub_').innerHTML = '';
            document.getElementById('_objetivo_estrategico_institucional_').innerHTML = '';
            document.getElementById('_indicador_estrategico_').innerHTML = '';
        }
        //para guardar lo editado
        $(document).on('click', '#btn_guardarAEditado', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_EAarticulacionEditado'));
            $.ajax({
                type: "POST",
                url: "{{ route('poa_editarform2guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresAE();
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#editar_AEarticulacion').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para editar plan de desarrollo universitario PDU
        let politica_desarrollo_pdu_select2 = $('#politica_desarrollo_pdu_');
        politica_desarrollo_pdu_select2.on('select2:select', (e)=>{
            e.preventDefault();
            let id = politica_desarrollo_pdu_select2.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#objetivo_estrategico_pdu_').empty().append(
                        '<option selected disabled>[SELECCIONE EL OBJETIVO ESTRATÉGICO]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_pdu_').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });
        //de la pla estrategico institucional sacar el objetivo estrategico (SUB)
        let politica_institucional_pei_select2 = $('#politica_institucional_pei_');
        politica_institucional_pei_select2.on('select2:select',(e)=>{
            e.preventDefault();
            let id = politica_institucional_pei_select2.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_sub') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#objetivo_estrategico_institucional_').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
                    );
                    $('#objetivo_estrategico_sub_').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA ]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_sub_').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });

        //para listar objetivo estrategico SUB
        let objetivo_estrategico_sub_select2 = $('#objetivo_estrategico_sub_');
        objetivo_estrategico_sub_select2.on('select2:select',(e)=>{
            e.preventDefault();
            let id = objetivo_estrategico_sub_select2.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_matriz_obj_estrategico_institucional') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#objetivo_estrategico_institucional_').empty().append(
                        '<option selected disabled>[OBJETIVO ESTRATÉGICO INSTITUCIONAL ]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#objetivo_estrategico_institucional_').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });


        let indicador_estrategico_select = $('#indicador_estrategico_');
        indicador_estrategico_select.on('select2:select',(e)=>{
            e.preventDefault();
            let id = indicador_estrategico_select.val();
            let id_form2 = document.getElementById('formulario2Edi_id').value;
            $.ajax({
                type: "POST",
                url: "{{ route('poa_validarIndicadorExiste') }}",
                data: {
                    id:id,
                    id_form2:id_form2,
                    id_ges:id_ges,
                    id_config:id_config,
                },
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('_indicador_estrategico_').innerHTML = '';
                        document.getElementById('btn_guardarAEditado').disabled = false;
                    }
                    if(data.tipo==='error'){
                        document.getElementById('_indicador_estrategico_').innerHTML = `<p id="error_in" >`+data.mensaje+`</p>`;
                        document.getElementById('btn_guardarAEditado').disabled = true;
                    }
                }
            });
        });
    </script>
@endsection
