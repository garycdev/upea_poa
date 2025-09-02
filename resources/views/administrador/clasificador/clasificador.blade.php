@extends('principal')
@section('titulo', 'Clasificadores Presupuestarios')

@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>CLASIFICADOR PRESUPUESTARIO</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Configuración</li>
                        <li>Clasificador Presupuestario</li>
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
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_clasificador"> <i class="bx bxs-add-to-queue"></i> Nuevo Clasificador Presupuestario</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ACCIONES</th>
                                <th>TITULO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody id="listar_clasificadorP" ></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA CREAR NUEVO CLASIFICADOR PRESUPUESTARIO-->
    <div class="modal slide" id="nuevo_clasificador" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiar_input_clasificador()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificador" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingrese un titulo">
                                <div id="_titulo"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese la descripción" rows="10"></textarea>
                                <div id="_descripcion" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="limpiar_input_clasificador()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_clasificador"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA EDITAR EL CLASIFICADOR PRESUPUESTARIO-->
    <div class="modal slide" id="editar_clasificador_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificador_edi" method="POST" autocomplete="off">
                        <input type="hidden" name="id_clasificador" id="id_clasificador" >
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo_" name="titulo_" placeholder="Ingrese un titulo">
                                <div id="_titulo_"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion_" id="descripcion_" placeholder="Ingrese la descripción" rows="10"></textarea>
                                <div id="_descripcion_" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_clasificador_editar"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA VER DETALLES DE CLASIFICADOR PRESUPÚESTARIO-->
    <div class="modal slide" id="detallesclasificador_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO PRIMER CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiar_inputClasificadorPrimero()" ></button>
                </div>
                <div class="modal-body" >
                    <form id="form_primerClasificador" method="post" autocomplete="off">
                        <input type="hidden" name="id_clasificadorTipo" id="id_clasificadorTipo">
                        <input type="hidden" name="id_clasificadorPrimero" id="id_clasificadorPrimero">
                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                        placeholder="Ingrese una gestión inicial" maxlength="6"
                                        onkeypress="return soloNumeros(event)">
                                    <div id="_codigo"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Titulo</label>
                                    <input type="text" class="form-control" id="titulop" name="titulop"
                                        placeholder="Ingrese un titulo">
                                    <div id="_titulop"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="descripcionp" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="descripcionp" id="descripcionp" rows="8" placeholder="Descripción"></textarea>
                                    <div id="_descripcionp"></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-outline-primary" id="btn_guardarprimerClasificador">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="detalles_clasificadorPresupuestario">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        //para listar el clasificador
        function listar_clasificador(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_clasificador_listar') }}",
                dataType: "JSON",
                success: function (data) {
                    let valores = data.clasificadores;
                    let i = 1;
                    let cuerpo = "";
                    for(let key in valores){
                        cuerpo += "<tr>";
                        cuerpo += "<td>"+ i++ +"</td>";
                        cuerpo += `<td width='300'>
                            <button type="button" class="btn btn-outline-primary" onclick="cambiar_estado('${valores[key]['id']}')">Estado</button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editar_clasificador('${valores[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                            @can('clasificadorTipo_eliminar')
                                <button class="btn btn-outline-danger btn-sm" onclick="eliminar_clasificador('${valores[key]['id']}')"><i class="ri-delete-bin-7-fill"></i></button>
                            @endcan
                            @can('clasificadorPrimero')
                                <button class="btn btn-outline-secondary btn-sm" onclick="detalles_clasificador('${valores[key]['id']}')"><i class="ri-settings-3-fill"></i></button>
                            @endcan
                        </td>`;
                        cuerpo += "<td >"+ valores[key]['titulo'] +"</td>";
                        cuerpo += "<td  > "+ valores[key]['descripcion'] +"</td>";
                        if (valores[key]['estado'] == 'activo') {
                            cuerpo += "<td> <span class='badge text-bg-success'>" + valores[key]['estado'] +
                                "</span> </td>";
                        } else {
                            cuerpo += "<td> <span class='badge text-bg-danger'>" + valores[key]['estado'] +
                                "</span> </td>";
                        }
                        cuerpo += "</tr>";
                    }
                    document.getElementById('listar_clasificadorP').innerHTML = cuerpo;
                }
            });
        }
        listar_clasificador();

        //para cambiar el estado
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
                        url: "{{ route('adm_clasificador_estado') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_clasificador();
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
        //par aguardar nuevo clasificador
        $(document).on('click', '#btn_guardar_clasificador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificador'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_clasificador_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    vaciar_clasificador_presupuestario();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_clasificador();
                        setTimeout(() => {
                            $('#nuevo_clasificador').modal('hide');
                        }, 1000);
                        limpiar_input_clasificador();
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para vaciar los errores
        function vaciar_clasificador_presupuestario(){
            document.getElementById('_titulo').innerHTML = '';
            document.getElementById('_descripcion').innerHTML = '';
        }
        //para limpiar los input
        function limpiar_input_clasificador(){
            limpiar_campos('form_clasificador');
            vaciar_clasificador_presupuestario();
        }

        //para editar el clasificador presupuestario
        function editar_clasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_clasificador_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    limpiar_errores_editar();
                    if(data.tipo==='success'){
                        $('#editar_clasificador_modal').modal('show');
                        document.getElementById('id_clasificador').value = data.mensaje.id;
                        document.getElementById('titulo_').value = data.mensaje.titulo;
                        document.getElementById('descripcion_').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }

        //para vaciar los tipos de errores
        function limpiar_errores_editar(){
            document.getElementById('_titulo_').innerHTML = '';
            document.getElementById('_descripcion_').innerHTML = '';
        }
        //para realizar la edicion
        $(document).on('click', '#btn_guardar_clasificador_editar', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificador_edi'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_clasificador_eguardar') }}",
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
                        listar_clasificador();
                        setTimeout(() => {
                            $('#editar_clasificador_modal').modal('hide');
                        }, 1000);
                        limpiar_errores_editar();
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //para realizar la eliminacion
        function eliminar_clasificador(id){
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
                        url: "{{ route('adm_clasificador_eliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_clasificador();
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

        //para crear el primer clasificador o mostrar
        function detalles_clasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_clasificador_detalles') }}",
                data: {id:id},
                success: function (data) {
                    $('#detallesclasificador_modal').modal('show');
                    document.getElementById('id_clasificadorTipo').value = id;
                    document.getElementById('detalles_clasificadorPresupuestario').innerHTML = data;
                }
            });
        }
        //para guardar el primer clasificador
        $(document).on('click', '#btn_guardarprimerClasificador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_primerClasificador'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_primerCl') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    limpiar_erroresClasificadorPrimero();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if(data.tipo==='success'){
                        alerta_top(data.tipo, data.mensaje);
                        limpiar_inputClasificadorPrimero();
                        detalles_clasificador(data.id_tipoClasificador);
                        document.getElementById('id_clasificadorTipo').value = data.id_tipoClasificador;
                        document.getElementById('id_clasificadorPrimero').value='';
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para vaciar los inputs del formularion clasificador primero
        function limpiar_inputClasificadorPrimero(){
            limpiar_campos('form_primerClasificador');
            limpiar_erroresClasificadorPrimero();
        }
        //para vaciar los errores que talves se genero
        function limpiar_erroresClasificadorPrimero(){
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_titulop').innerHTML = '';
        }

        //para editar el clasificador primero
        function editar_clasificadorPrimero(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_primerCl_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('id_clasificadorPrimero').value = data.mensaje.id;
                        document.getElementById('codigo').value = data.mensaje.codigo;
                        document.getElementById('titulop').value = data.mensaje.titulo;
                        document.getElementById('descripcionp').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para eliminar el clasificador primero
        function eliminar_clasificadorPrimero(id, id_tipo_clasi){
            vaciarMomentoEliminar();
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
                        url: "{{ route('adm_primerCl_eliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                detalles_clasificador(id_tipo_clasi);
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
        //para vaciar al momento de eliminar
        function vaciarMomentoEliminar(){
            document.getElementById('id_clasificadorPrimero').value='';
            document.getElementById('codigo').value='';
            document.getElementById('titulop').value='';
            document.getElementById('descripcionp').value='';
        }
        //para cambiar el estado del clasificador primero
        function estado_clasificadorPrimero(id, id_tipo_clasi){
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
                        url: "{{ route('adm_primerCl_estado') }}",
                        data: {
                            id: id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                detalles_clasificador(id_tipo_clasi);
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
