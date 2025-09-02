@extends('principal')
@section('titulo', 'Partidas')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>PARTIDAS</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Configuración</li>
                        <li>Partidas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <h3></h3>
                <div class="others-title d-flex align-items-center">
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_tipoPartida"> <i class="bx bxs-add-to-queue"></i> Nuevo tipo de Partida</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="listar_tpartida"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA CREAR NUEVA TIPOD DE TIPO DE PARTIDA-->
    <div class="modal slide" id="nuevo_tipoPartida" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO TIPO DE PARTIDA</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiar_input_partida()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_partida_nuevo" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="descripcion" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese la descripción" rows="5"></textarea>
                                <div id="_descripcion" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="limpiar_input_partida()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_partida"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Partida</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA EDITAR TIPOD DE TIPO DE PARTIDA-->
    <div class="modal slide" id="editar_tipoPartida" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR TIPO DE PARTIDA</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body" >
                    <form id="form_partida_editar_g" method="POST" autocomplete="off">
                        <input type="hidden" name="id_partida_tipo" id="id_partida_tipo">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="descripcion_" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion_" id="descripcion_" placeholder="Ingrese la descripción" rows="5"></textarea>
                                <div id="_descripcion_" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_editar_partida_g"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Partida</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        //para listar tipos de partidas
        function listar_tipoPartida(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_partida_listar') }}",
                dataType: "JSON",
                success: function (data) {
                    let valores = data.tipos_partidas;
                    let i = 1;
                    let cuerpo = "";
                    for(let key in valores){
                        cuerpo += "<tr>";
                        cuerpo += "<td>"+ i++ +"</td>";
                        cuerpo += "<td>"+ valores[key]['descripcion'] +"</td>";
                        if (valores[key]['estado'] == 'activo') {
                            cuerpo += "<td> <span class='badge text-bg-success'>" + valores[key]['estado'] +
                                "</span> </td>";
                        } else {
                            cuerpo += "<td> <span class='badge text-bg-danger'>" + valores[key]['estado'] +
                                "</span> </td>";
                        }
                        cuerpo += `<td>
                                <button type="button" class="btn btn-outline-primary" onclick="cambiar_estado_tpartida('${valores[key]['id']}')">Estado</button>
                                <button class="btn btn-outline-warning btn-sm" onclick="editar_tpartida('${valores[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                                @can('tipoPartida_eliminar')
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_tpartida('${valores[key]['id']}')"><i class="ri-delete-bin-7-fill"></i></button>
                                @endcan
                        </td>`;
                        cuerpo += "</tr>";
                    }
                    document.getElementById('listar_tpartida').innerHTML = cuerpo;
                }
            });
        }
        listar_tipoPartida();
        //para guardar lo de tipo de partida
        $(document).on('click', '#btn_guardar_partida', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_partida_nuevo'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_partida_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    lipiar_errores_nuevo();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_tipoPartida();
                        setTimeout(() => {
                            $('#nuevo_tipoPartida').modal('hide');
                        }, 1000);
                        limpiar_input_partida();
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para vaciar los imputs
        function limpiar_input_partida(){
            limpiar_campos('form_partida_nuevo');
            lipiar_errores_nuevo();
        }
        //para limpiar los errores
        function lipiar_errores_nuevo(){
            document.getElementById('_descripcion').innerHTML = '';
        }
        //para cambiar el estado
        function cambiar_estado_tpartida(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de cambiar el estado?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Cambiar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_partida_estado') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_tipoPartida();
                            }
                            if (data.tipo === 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            })
        }
        //para editar el tipo de partida
        function editar_tpartida(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_partida_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    borrar_errores_editar_f();
                    if(data.tipo==='success'){
                        $('#editar_tipoPartida').modal('show');
                        document.getElementById('id_partida_tipo').value = data.mensaje.id;
                        document.getElementById('descripcion_').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }

        //para guardar lo editado
        $(document).on('click', '#btn_editar_partida_g', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_partida_editar_g'));

            $.ajax({
                type: "POST",
                url: "{{ route('adm_partida_editar_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_tipoPartida();
                        setTimeout(() => {
                            $('#editar_tipoPartida').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //borrar los errores
        function borrar_errores_editar_f(){
            document.getElementById('_descripcion_').innerHTML = '';
        }
        //para eliminar el reistro
        function eliminar_tpartida(id){
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
                        url: "{{ route('adm_partida_eliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_tipoPartida();
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
    </script>
@endsection
