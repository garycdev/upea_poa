@extends('principal')
@section('titulo', 'Listado')

@section('contenido')
    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary">{{ $tipo->nombre }}</h3>
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_carreraUnidadArea"  ><i class="bx bxs-add-to-queue"></i> NUEVO</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive table-hover" id="listarTipoCarrera_tabla" style="width:100%" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NOMBRE COMPLETO</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal  nuevo-->
    <div class="modal zoom" id="nuevo_carreraUnidadArea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close" onclick="cerrar_modal()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_nuevo" method="post" autocomplete="off">
                        <input type="hidden" name="id_tipo" id="id_tipo" value="{{ $tipo->id }}">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12" >
                                <label for="" class="form-label">Nombre completo</label>
                                <input type="text" name="nombre_completo" id="nombre_completo" class="form-control">
                                <div id="_nombre_completo" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_editar()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  editar-->
    <div class="modal zoom" id="editar_carreraUnidadArea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close" onclick="cerrar_modal()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_editar" method="post" autocomplete="off">
                        <input type="hidden" name="id_carreraUnidad" id="id_carreraUnidad">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12" >
                                <label for="" class="form-label">Nombre completo</label>
                                <input type="text" name="nombre_completo_" id="nombre_completo_" class="form-control">
                                <div id="_nombre_completo_" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_editar()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_editado"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let id_tipo = {{ $tipo->id }};
        function listar_tipo_carrera(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cua_carrera_adminListar') }}",
                data: {id_tipo:id_tipo},
                dataType: "JSON",
                success: function (data) {
                    let i=1;
                    $("#listarTipoCarrera_tabla").DataTable({
                        'data':data.listado_ca,
                        'columns':[
                            {"render":function(){
                                return a = i++;
                            }},
                            {"data":'nombre_completo'},
                            {"render": function(data, type, row, meta){
                                let a;
                                if(row.estado=="activo"){
                                    a =`<span class="badge rounded-pill text-bg-success">activo</span>`;
                                }else{
                                    a = `<span class="badge rounded-pill text-bg-danger">inactivo</span>`;
                                }
                                return a;
                            }},
                            {"render": function(data, type, row, meta){
                                let a=`
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_form('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-primary btn-sm" onclick="cambiar_estado('${row.id}')">Estado</button>
                                `;
                                return a;
                            }},
                        ]
                    });
                }
            });
        }
        listar_tipo_carrera();
        //para cerrar el modal y eliminar los errores que se pudo tener
        function cerrar_modal(){
            document.getElementById('_nombre_completo').innerHTML = '';
            limpiar_campos("form_nuevo");
        }
        //para guardar
        $(document).on('click', '#btn_guardar', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_nuevo'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cua_carrera_adminGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    document.getElementById('_nombre_completo').innerHTML = '';
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        $('#listarTipoCarrera_tabla').DataTable().destroy();
                        listar_tipo_carrera();
                        setTimeout(() => {
                            $('#nuevo_carreraUnidadArea').modal('hide');
                        }, 1400);
                        cerrar_modal();
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //par acambiar el estado
        function cambiar_estado(id){
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
                        url: "{{ route('adm_cua_carrera_adminEstado') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                $('#listarTipoCarrera_tabla').DataTable().destroy();
                                listar_tipo_carrera();
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
        //para editar el registro
        function editar_form(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cua_carrera_adminEditar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    document.getElementById('_nombre_completo_').innerHTML = '';
                    if(data.tipo==='success'){
                        $('#editar_carreraUnidadArea').modal('show');
                        document.getElementById('id_carreraUnidad').value = data.mensaje.id;
                        document.getElementById('nombre_completo_').value = data.mensaje.nombre_completo;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para guardar lo editado
        $(document).on('click','#btn_guardar_editado', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_editar'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cua_carrera_adminEguardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    document.getElementById('_nombre_completo_').innerHTML = '';
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        $('#listarTipoCarrera_tabla').DataTable().destroy();
                        listar_tipo_carrera();
                        setTimeout(() => {
                            $('#editar_carreraUnidadArea').modal('hide');
                        }, 1400);
                        document.getElementById('_nombre_completo_').innerHTML = '';
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
    </script>
@endsection
