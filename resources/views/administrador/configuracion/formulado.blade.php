@extends('principal')
@section('titulo', 'Formulado')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>FORMULADO</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Configuración</li>
                        <li>Tipo de Formulado</li>
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
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_formulado"> <i class="bx bxs-add-to-queue"></i> Nuevo tipo de Formulado</button>
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
                        <tbody id="listar_formulado" ></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA CREAR NUEVA TIPOD DE FORMULADO-->
    <div class="modal slide" id="nuevo_formulado" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO TIPO DE FORMULADO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiar_input_formulado()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_formulado_nuevo" method="POST" autocomplete="off">
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
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="limpiar_input_formulado()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_formulado"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Formulado</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA EDITAR TIPOD DE FORMULADO-->
    <div class="modal slide" id="editar_formulado" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR TIPO DE FORMULADO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body" >
                    <form id="form_formulado_editar" method="POST" autocomplete="off">
                        <input type="hidden" name="id_formulado" id="id_formulado">
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
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_editar_formulado"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Formulado</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        //para listar los formulados
        function listar_tipoFormulado(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_formulado_listar') }}",
                dataType: "JSON",
                success: function (data) {
                    let valores = data.listar_formulado;
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
                            <button type="button" class="btn btn-outline-primary" onclick="cambiar_estado_f('${valores[key]['id']}')">Estado</button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editar_formulado('${valores[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                            @can('tipoFormulado_eliminar')
                                <button class="btn btn-outline-danger btn-sm" onclick="eliminar_formulado('${valores[key]['id']}')"><i class="ri-delete-bin-7-fill"></i></button>
                            @endcan
                        </td>`;
                        cuerpo += "</tr>";
                    }
                    document.getElementById('listar_formulado').innerHTML = cuerpo;
                }
            });
        }
        listar_tipoFormulado();
        //para cambiar el estado
        function cambiar_estado_f(id){
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
                        url: "{{ route('adm_formulado_estado') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_tipoFormulado();
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
        //para guardar nuevo formulado
        $(document).on('click', '#btn_guardar_formulado', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_formulado_nuevo'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_formulado_guardar') }}",
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
                        listar_tipoFormulado();
                        setTimeout(() => {
                            $('#nuevo_formulado').modal('hide');
                        }, 1000);
                        limpiar_input_formulado();
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para vaciar los imputs
        function limpiar_input_formulado(){
            limpiar_campos('form_formulado_nuevo');
            lipiar_errores_nuevo();
        }
        //para limpiar los errores
        function lipiar_errores_nuevo(){
            document.getElementById('_descripcion').innerHTML = '';
        }
        //para editar el tipo de formulado
        function editar_formulado(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_formulado_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    limpiar_div_editar();
                    if(data.tipo==='success'){
                        $('#editar_formulado').modal('show');
                        document.getElementById('id_formulado').value = data.mensaje.id;
                        document.getElementById('descripcion_').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }

        //para liminar los div
        function limpiar_div_editar(){
            document.getElementById('_descripcion_').innerHTML = '';
        }

        //para guardar lo editado
        $(document).on('click', '#btn_editar_formulado', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_formulado_editar'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_formulado_editar_guardar') }}",
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
                        listar_tipoFormulado();
                        setTimeout(() => {
                            $('#editar_formulado').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para eliminar los formulados
        function eliminar_formulado(id){
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
                        url: "{{ route('adm_formulado_eliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_tipoFormulado();
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
