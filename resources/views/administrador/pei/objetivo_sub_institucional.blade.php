@extends('principal')
@section('titulo', 'PEI')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5 >ÁREA ESTRATÉGICA : "{{ $areas_estrategicas->descripcion }}" GESTIÓN {{ $gestion->inicio_gestion.' - '.$gestion->fin_gestion }}</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administración de PEI</li>
                        <li>Objetivos estratégicos (SUB)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tabs-wrap">
        <nav class="tabs-button">
            <div class="nav nav-tabs" role="tablist">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#fortaleza" type="button" role="tab" aria-selected="true">
                    OBJETIVO ESTRATEGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA (SUB)
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#oportunidades" type="button" role="tab" aria-selected="false">
                    OBJETIVO ESTRATEGICO INSTITUCIONAL
                </button>
            </div>
        </nav>

        <div class="tabs-content">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="fortaleza" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3 class="text-primary">OBJETIVO ESTRATÉGICO DEL SISTEMA DE UNIVERSIDADES DE BOLIVIA (SUB)</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_objetivo_estrategico_sub"> <i class="bx bxs-add-to-queue"></i> Nuevo Objetivo Estratégico (SUB)</button>
                                    </div>
                                </div>
                                <div class="table-responsive" >
                                    <table class="table table-responsive  text-center table-striped align-middle" style="width:100%" >
                                        <thead >
                                            <tr>
                                                <th></th>
                                                <th colspan="2">POLITICA DE DESARROLLO</th>
                                                <th colspan="1">OBJETIVO ESTRATÉGICO DEL (SUB)</th>
                                            </tr>
                                            <tr class="align-middle">
                                                <th>AE</th>
                                                <th>CODIGO</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th > <div style="float: left;">CODIGO</div>  DESCRIPCIÓN  <div style="float: right;">ACCIÓN</div></th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            @foreach ($listar as $lis)
                                                <tr>
                                                    <td>{{ $areas_estrategicas->codigo_areas_estrategicas }}</td>
                                                    <td>{{ $lis->codigo }}</td>
                                                    <td width="25%" align="justify"  >{{ $lis->descripcion }}</td>
                                                    <td>
                                                        <div class="table-responsive">
                                                            <table class="table table-responsive table-sm text-center align-middle">
                                                                <tbody>
                                                                    @foreach ($lis->relacion_objetivo_estrategico_sub as $obj_est)
                                                                        <tr>
                                                                            <td width="8%">
                                                                                {{ $obj_est->codigo }}
                                                                            </td>
                                                                            <td align="justify" width="70%">
                                                                                {{ $obj_est->descripcion }}
                                                                            </td>
                                                                            <td >
                                                                                <button class="btn btn-outline-warning btn-sm" onclick="editar_obj_estrategico_sub('{{ $obj_est->id }}')" ><i class="ri-edit-2-fill"></i></button>
                                                                                <button class="btn btn-outline-danger btn-sm" onclick="eliminar_obj_estrategico_sub('{{ $obj_est->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="oportunidades" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3 class="text-primary">OBJETIVO ESTRATÉGICO INSTITUCIONAL</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#nuevo_objetivo_institucional"> <i class="bx bxs-add-to-queue"></i> Nuevo Objetivo Institucional</button>
                                    </div>
                                </div>
                                <div class="table-responsive" >
                                    <table class="table table-responsive  text-center table-striped align-middle" style="width:100%" >
                                        <thead >
                                            <tr>
                                                <th></th>
                                                <th colspan="2">POLITICA DE DESARROLLO</th>
                                                <th colspan="1"><div style="float: left;">OBJETIVO ESTRATÉGICO DEL (SUB)</div>   <div style="float: right;">OBJETIVO INSTITUCIONAL</div></th>
                                            </tr>
                                            <tr class="align-middle">
                                                <th>AE</th>
                                                <th>COD</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>
                                                    <div style="float: left;">COD </div>
                                                    DESCRIPCIÓN

                                                    <div style="float: right;">
                                                        <div style="float: left;">COD @for($i = 0; $i < 15; $i++) &nbsp; @endfor</div>
                                                        DESCRIPCIÓN @for($i = 0; $i < 15; $i++) &nbsp; @endfor
                                                        <div style="float: right;">ACCIÓN</div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listar_politica_institucional as $pol_ins)
                                            <tr class="table-group-divider">
                                                <td>{{ $areas_estrategicas->codigo_areas_estrategicas }}</td>
                                                <td>{{ $pol_ins->codigo }}</td>
                                                <td width="20%" align="justify"  >{{ $pol_ins->descripcion }}</td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table-responsive table-sm text-center align-middle">
                                                            <tbody>
                                                                @foreach ($pol_ins->relacion_objetivo_estrategico_sub as $obj_est)
                                                                    <tr>
                                                                        <td width="5%">
                                                                            {{ $obj_est->codigo }}
                                                                        </td>
                                                                        <td align="justify" width="35%">
                                                                            {{ $obj_est->descripcion }}
                                                                        </td>
                                                                        <td>
                                                                            <div class="table-responsive">
                                                                                <table class="table table-responsive table-sm text-center align-middle">
                                                                                    <tbody>
                                                                                        @foreach ($obj_est->relacion_objetivo_institucional as $obj_institucional)
                                                                                            <tr>
                                                                                                <td width="8%">
                                                                                                    {{ $obj_institucional->codigo }}
                                                                                                </td>
                                                                                                <td align="justify" width="70%">
                                                                                                    {{ $obj_institucional->descripcion }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_obj_institucional('{{ $obj_institucional->id }}')" ><i class="ri-edit-2-fill"></i></button>
                                                                                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_obj_institucional('{{ $obj_institucional->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  objryivo estrategico SUB-->
    <div class="modal zoom" id="nuevo_objetivo_estrategico_sub" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">OBJETIVOS ESTRATÉGICOS (SUB)</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"  onclick="cerrar_modal_foda()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_objetivos_estrategicos_sub" method="post" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                                <label for="gestion_id" class="form-label">Seleccione Politica de Institucional</label>
                                <select name="politica_institucional" id="politica_institucional" class="select2">
                                    <option value="selected" disabled selected>[SELECCIONE POLITICA INSTITUCIONAL]</option>
                                    @foreach ($politica_institucional as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                    @endforeach
                                </select>
                                <div id="_politica_institucional" ></div>
                            </div>
                            <div class="mb-3 text-center">
                                <div id="alerta_nota">
                                    <p>! NOTA ¡ : Se podra agregar maximo de {{ maximo_agregar() }} registros a la vez!</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label id="tipo_seleccionado">INGRESE LOS OBJETIVOS ESTRATÉGICOS (SUB)</label>
                                <div id="repetir_obj_estrategicos_sub">
                                    <div class="form-group">
                                        <div data-repeater-list="repetir_obj_estrategicos_sub">
                                            <div data-repeater-item>
                                                <div class="row text-center d-flex justify-content-center align-items-center">
                                                    <div class="col-md-2 col-lg-2 col-xl-2" >
                                                        <label for="" class="form-label"></label>
                                                        <input type="text" class="form-control" name="codigo" id="codigo" onkeypress="return soloNumeros(event)" maxlength="2">
                                                    </div>
                                                    <div class="col-md-8 col-lg-8 col-xl-8" >
                                                        <label for="" class="form-label"></label>
                                                        <textarea name="descripcion" class="form-control" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-2 col-lg-2 col-xl-2 my-1">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-outline-danger mt-3">
                                                            <i class="ri-close-circle-fill"></i> Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:;" data-repeater-create class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="ri-add-line"></i> Agregar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_foda()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_objetivo_estrategico_sub"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Objetivos Estratégicos</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar objetivo estrategico SUB -->
    <div class="modal zoom" id="editar_objetivo_estrategico_sub" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR OBJETIVOS ESTRATÉGICOS (SUB)</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_objetivos_estrategicos_edi_sub" method="post" autocomplete="off">
                        <input type="hidden" name="id_obj_estrategico_sub" id="id_obj_estrategico_sub">
                        <div class="row">
                            <div>
                                <div class="alert alert-primary text-center" role="alert" id="politica_desarrollo_descripcion">
                                </div>
                            </div>
                            <hr>
                            <div class="mb-1">
                                <div class="row text-center d-flex justify-content-center align-items-center">
                                    <div class="col-md-2 col-lg-2 col-xl-2" >
                                        <label for="" class="form-label">CÓDIGO</label>
                                        <input type="text" class="form-control" name="codigo_" id="codigo_e" onkeypress="return soloNumeros(event)" maxlength="2">
                                        <div id="_codigo_" ></div>
                                    </div>
                                    <div class="col-md-10 col-lg-10 col-xl-10" >
                                        <label for="" class="form-label">DESCRIPCIÓN</label>
                                        <textarea name="descripcion_" id="descripcion_e" class="form-control" cols="30" rows="3"></textarea>
                                        <div id="_descripcion_" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" >Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_edi_objetivo_estrategico_sub"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Objetivos Estratégicos</button>
                </div>
            </div>
        </div>
    </div>


    <!-- OBJETIVO ESTRATÉGICO INSTITUCIONAL -->
    <div class="modal zoom" id="nuevo_objetivo_institucional" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">OBJETIVOS ESTRATÉGICOS INSTITUCIONALES</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close" onclick="cerrar_modal_obj_estrategicos_institucionales()" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_objetivos_institucionales" method="post" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                                <label for="gestion_id" class="form-label">Seleccione Politica de Institucional</label>
                                <select name="politica_institucional_" id="politica_institucional_" class="select2_segundo" onchange="politica_instucional_select(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE POLITICA INSTITUCIONAL]</option>
                                    @foreach ($politica_institucional as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                    @endforeach
                                </select>
                                <div id="_politica_institucional_" ></div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                                <label for="gestion_id" class="form-label">Seleccione objetivo estratégico (SUB) </label>
                                <select name="objetivo_estrategico_sub" id="objetivo_estrategico_sub" class="select2_tercero" >
                                    <option value="selected" disabled selected>[SELECCIONE OBJETIVO ESTRATÉGICO DE LA (SUB)]</option>
                                </select>
                                <div id="_objetivo_estrategico_sub" ></div>
                            </div>
                            <div class="mb-3 text-center">
                                <div id="alerta_nota">
                                    <p>! NOTA ¡ : Se podra agregar maximo de {{ maximo_agregar() }} registros a la vez!</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label id="tipo_seleccionado">INGRESE LOS OBJETIVOS ESTRATÉGICOS</label>
                                <div id="repetir_obj_institucionales">
                                    <div class="form-group">
                                        <div data-repeater-list="repetir_obj_institucionales">
                                            <div data-repeater-item>
                                                <div class="row text-center d-flex justify-content-center align-items-center">
                                                    <div class="col-md-2 col-lg-2 col-xl-2" >
                                                        <label for="" class="form-label"></label>
                                                        <input type="text" class="form-control" name="codigo" id="codigo" onkeypress="return soloNumeros(event)" maxlength="2">
                                                    </div>
                                                    <div class="col-md-8 col-lg-8 col-xl-8" >
                                                        <label for="" class="form-label"></label>
                                                        <textarea name="descripcion" class="form-control" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-2 col-lg-2 col-xl-2 my-1">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-outline-danger mt-3">
                                                            <i class="ri-close-circle-fill"></i> Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:;" data-repeater-create class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="ri-add-line"></i> Agregar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_objetivo_institucional"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Objetivos Estratégicos</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR ESTRATÉGICO INSTITUCIONAL-->
    <div class="modal zoom" id="editar_objetivo_institucional" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR OBJETIVOS INSTITUCIONALES</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_objetivos_institucionales_edi" method="post" autocomplete="off">
                        <input type="hidden" name="id_obj_institucional" id="id_obj_institucional">
                        <div class="row">
                            <div>
                                <div class="alert alert-primary text-center" role="alert" id="politica_desarrollo_descripcion_institucional">
                                </div>
                            </div>
                            <div>
                                <div class="alert alert-success text-center" role="alert" id="objetivo_institucional_sub_inst">
                                </div>
                            </div>
                            <hr>
                            <div class="mb-1">
                                <div class="row text-center d-flex justify-content-center align-items-center">
                                    <h5 class="text-center text-secondary" >OBJETIVO INSTITUCIONAL</h5>
                                    <hr>
                                    <div class="col-md-2 col-lg-2 col-xl-2" >
                                        <label for="" class="form-label">CÓDIGO</label>
                                        <input type="text" class="form-control" name="codigo_i" id="codigo_i" onkeypress="return soloNumeros(event)" maxlength="2">
                                        <div id="_codigo_i" ></div>
                                    </div>
                                    <div class="col-md-10 col-lg-10 col-xl-10" >
                                        <label for="" class="form-label">DESCRIPCIÓN</label>
                                        <textarea name="descripcion_i" id="descripcion_i" class="form-control" cols="30" rows="3"></textarea>
                                        <div id="_descripcion_i" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" >Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_edi_objetivo_institucionales"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Objetivo Institucional</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        repetir_x('#repetir_obj_estrategicos_sub');
        //
        select2_rodry('#nuevo_objetivo_estrategico_sub');

        function cerrar_modal_foda(){
            limpiar_campos('form_objetivos_estrategicos_sub');
            $(".select2").val('selected').trigger('change');
            document.getElementById('_politica_institucional').innerHTML = '';
        }
        //guardar objetivo estrategico SUB
        $(document).on('click', '#btn_guardar_objetivo_estrategico_sub', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_objetivos_estrategicos_sub'));
            document.getElementById('_politica_institucional').innerHTML = '';
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_estrategico_sub_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#nuevo_objetivo_estrategico_sub').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //eliminar objetivo estrategico SUB
        function eliminar_obj_estrategico_sub(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de eliminar el registro?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_obj_estrategico_sub_eliminar') }}",
                        data: { id:id },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                setTimeout(() => {
                                    window.location='';
                                }, 1500);
                            }
                            if (data.tipo === 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            });
        }

        //editar objetivo estrategico SUB
        function editar_obj_estrategico_sub(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_estrategico_sub_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_objetivo_estrategico_sub').modal('show');
                        limpiar_errores_edi()
                        document.getElementById('politica_desarrollo_descripcion').innerHTML = '<p style="font-weight: bold;" >'+data.mensaje.reversa_politica_desarrollo.descripcion+'</p>';
                        document.getElementById("codigo_e").value = data.mensaje.codigo;
                        document.getElementById("descripcion_e").value = data.mensaje.descripcion;
                        document.getElementById("id_obj_estrategico_sub").value = data.mensaje.id;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        function limpiar_errores_edi(){
            document.getElementById('_codigo_').innerHTML = '';
            document.getElementById('_descripcion_').innerHTML = '';
        }

        $(document).on('click', '#btn_guardar_edi_objetivo_estrategico_sub', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_objetivos_estrategicos_edi_sub'));
            limpiar_errores_edi()
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_estrategico_sub_editar_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#editar_objetivo_estrategico_sub').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        segundo_select2("#nuevo_objetivo_institucional");
        tercero_select2("#nuevo_objetivo_institucional");
        repetir_x('#repetir_obj_institucionales');

        function politica_instucional_select(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_estrategico_sub_mostrar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#objetivo_estrategico_sub').empty().append(
                        '<option selected disabled>[SELECCIONE OBJETIVO ESTRATÉGICO DE LA (SUB)]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje.relacion_objetivo_estrategico_sub;
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

        function cerrar_modal_obj_estrategicos_institucionales(){
            limpiar_campos('form_objetivos_institucionales');
            $(".select2_segundo").val('selected').trigger('change');
            limpiar_campos_requeridos_obj_inst();
        }

        function limpiar_campos_requeridos_obj_inst(){
            document.getElementById('_politica_institucional_').innerHTML = '';
            document.getElementById('_objetivo_estrategico_sub').innerHTML = '';
        }

        $(document).on('click', '#btn_guardar_objetivo_institucional', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_objetivos_institucionales'));
            limpiar_campos_requeridos_obj_inst();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_institucionales_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#nuevo_objetivo_institucional').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });


        //para eliminar el objetivo institucional
        function eliminar_obj_institucional(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de eliminar el registro?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_obj_institucionales_eliminar') }}",
                        data: { id:id },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                setTimeout(() => {
                                    window.location='';
                                }, 1500);
                            }
                            if (data.tipo === 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            });
        }
        //para editar el objetivo institucional
        function editar_obj_institucional(id){
            limpiar_errores_politica_institucional();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_institucionales_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_objetivo_institucional').modal('show');
                        document.getElementById('politica_desarrollo_descripcion_institucional').innerHTML = '<h5 class="text-primary"> POLITICA INSTITUCIONAL </h5><p style="font-weight: bold;" >'+data.mensaje.reversa_objetivo_estrategico_sub.reversa_politica_desarrollo.descripcion+'</p>';
                        document.getElementById('objetivo_institucional_sub_inst').innerHTML = '<h5 class="text-success"> OBJETIVO ESTRATEGICO (SUB) </h5><p style="font-weight: bold;" >'+data.mensaje.reversa_objetivo_estrategico_sub.descripcion+'</p>';
                        document.getElementById("codigo_i").value = data.mensaje.codigo;
                        document.getElementById("descripcion_i").value = data.mensaje.descripcion;
                        document.getElementById("id_obj_institucional").value = data.mensaje.id;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        function limpiar_errores_politica_institucional(){
            document.getElementById('_codigo_i').innerHTML = '';
            document.getElementById('_descripcion_i').innerHTML = '';
        }

        //para guardar editado las politicas institucionales
        $(document).on('click', '#btn_guardar_edi_objetivo_institucionales',(e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_objetivos_institucionales_edi'));
            limpiar_errores_politica_institucional()
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_institucionales_editar_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#editar_objetivo_institucional').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
    </script>

@endsection
