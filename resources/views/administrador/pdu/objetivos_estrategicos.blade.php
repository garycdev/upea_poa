@extends('principal')
@section('titulo', 'objetivo estrategico')
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
                        <li>Administración de PDU</li>
                        <li>Objetivos estratégicos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary">OBJETIVOS ESTRATÉGICOS (PDU)</h3>
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_objetivo_estrategico"  ><i class="bx bxs-add-to-queue"></i> Nuevo Objetivo Estratégico</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive  text-center table-striped align-middle" style="width:100%" >
                        <thead >
                            <tr>
                                <th></th>
                                <th colspan="2">POLITICA DE DESARROLLO</th>
                                <th colspan="1">OBJETIVOS ESTRATÉGICOS</th>
                            </tr>
                            <tr class="align-middle" >
                                <th>AE</th>
                                <th>CODIGO</th>
                                <th>DESCRIPCIÓN</th>
                                <th > <div style="float: left;">CODIGO</div>  DESCRIPCIÓN  <div style="float: right;">ACCION</div></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider ">
                            @foreach ($listar as $lis)
                                <tr>
                                    <td>{{ $areas_estrategicas->codigo_areas_estrategicas }}</td>
                                    <td>{{ $lis->codigo }}</td>
                                    <td width="25%" align="justify"  >{{ $lis->descripcion }}</td>
                                    <td>
                                        <div class="table-responsive" >
                                            <table class="table table-responsive table-sm text-center align-middle">
                                                <tbody>
                                                    @foreach ($lis->relacion_objetivo_estrategico as $obj_est)
                                                        <tr>
                                                            <td width="8%">
                                                                {{ $obj_est->codigo }}
                                                            </td>
                                                            <td align="justify" width="70%">
                                                                {{ $obj_est->descripcion }}
                                                            </td>
                                                            <td >
                                                                <button class="btn btn-outline-warning btn-sm" onclick="editar_obj_estrategico('{{ $obj_est->id }}')" ><i class="ri-edit-2-fill"></i></button>
                                                                <button class="btn btn-outline-danger btn-sm" onclick="eliminar_obj_estrategico('{{ $obj_est->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
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



    <!-- Modal  nuevo objetivo estrategico-->
    <div class="modal zoom" id="nuevo_objetivo_estrategico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">OBJETIVOS ESTRATÉGICOS</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"  onclick="cerrar_modal_foda()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_objetivos_estrategicos" method="post" autocomplete="off">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                                <label for="gestion_id" class="form-label">Seleccione Politica de Desarrollo</label>
                                <select name="politica_desarrollo" id="politica_desarrollo" class="select2">
                                    <option value="selected" disabled selected>[SELECCIONE POLITICA DE DESARROLLO]</option>
                                    @foreach ($politica_desarrollo as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                    @endforeach
                                </select>
                                <div id="_politica_desarrollo" ></div>
                            </div>
                            <div class="mb-3 text-center">
                                <div id="alerta_nota">
                                    <p>! NOTA ¡ : Se podra agregar maximo de {{ maximo_agregar() }} registros a la vez!</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label id="tipo_seleccionado">INGRESE LOS OBJETIVOS ESTRATÉGICOS</label>
                                <div id="repetir_obj_estrategicos">
                                    <div class="form-group">
                                        <div data-repeater-list="repetir_obj_estrategicos">
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
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_objetivo_estrategico"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Objetivos Estratégicos</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal  nuevo editar objetivo estrategico-->
    <div class="modal zoom" id="editar_objetivo_estrategico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR OBJETIVOS ESTRATÉGICOS</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_objetivos_estrategicos_edi" method="post" autocomplete="off">
                        <input type="hidden" name="id_obj_estrategico" id="id_obj_estrategico">
                        <div class="row">
                            <div>
                                <div class="alert alert-primary text-center" role="alert" id="politica_desarrollo_descripcion">
                                </div>
                            </div>
                            <hr>
                            <div class="mb-1">
                                <div class="row text-center d-flex justify-content-center align-items-center">
                                    <div class="col-md-2 col-lg-2 col-xl-2" >
                                        <label for="" class="form-label">CODIGO</label>
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
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_edi_objetivo_estrategico"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Objetivos Estratégicos</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        repetir_x('#repetir_obj_estrategicos');
        //
        select2_rodry('#nuevo_objetivo_estrategico');

        function cerrar_modal_foda(){
            limpiar_campos('form_objetivos_estrategicos');
            $(".select2").val('selected').trigger('change');
            document.getElementById('_politica_desarrollo').innerHTML = '';
        }
        //guardar objetivo estrategico
        $(document).on('click', '#btn_guardar_objetivo_estrategico', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_objetivos_estrategicos'));
            document.getElementById('_politica_desarrollo').innerHTML = '';
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_estrategico_guardar') }}",
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
                            $('#nuevo_objetivo_estrategico').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //eliminar objetivo estrategico
        function eliminar_obj_estrategico(id){
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
                        url: "{{ route('adm_obj_estrategico_eliminar') }}",
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
        //editar objetivo estrategico
        function editar_obj_estrategico(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_estrategico_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_objetivo_estrategico').modal('show');
                        limpiar_errores_edi()
                        document.getElementById('politica_desarrollo_descripcion').innerHTML = '<p style="font-weight: bold;" >'+data.mensaje.relacion_inversa_objetivo_estrategico_pol_desarrollo.descripcion+'</p>';
                        document.getElementById("codigo_e").value = data.mensaje.codigo;
                        document.getElementById("descripcion_e").value = data.mensaje.descripcion;
                        document.getElementById("id_obj_estrategico").value = data.mensaje.id;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para guardar lo editado
        $(document).on('click','#btn_guardar_edi_objetivo_estrategico', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_objetivos_estrategicos_edi'));
            limpiar_errores_edi()
            $.ajax({
                type: "POST",
                url: "{{ route('adm_obj_estrategico_editar_guardar') }}",
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
                            $('#editar_objetivo_estrategico').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //
        function limpiar_errores_edi(){
            document.getElementById('_codigo_').innerHTML = '';
            document.getElementById('_descripcion_').innerHTML = '';
        }


    </script>
@endsection
