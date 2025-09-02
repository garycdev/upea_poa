@extends('principal')
@section('titulo', 'Fuente de Financiamiento')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>FUENTE DE FINANCIAMIENTO</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Configuración</li>
                        <li>Fuente de financiamiento</li>
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
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_fuente_financiamiento"> <i class="bx bxs-add-to-queue"></i> Nuevo Fuente de Financiamiento</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SIGLA</th>
                                <th>CÓDIGO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="listar_fdfianciamiento" ></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA CREAR NUEVA FUENTE DE FINANCIAMIENTO-->
    <div class="modal slide" id="nuevo_fuente_financiamiento" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO FUENTE DE FINANCIAMIENTO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limpiar_input_financiamiento()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_fuente_financiamiento" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="sigla" class="form-label">Ingrese la Sigla</label>
                                <input type="text" class="form-control" id="sigla" name="sigla" placeholder="Ingrese una sigla" maxlength="10">
                                <div id="_sigla"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="codigo" class="form-label">Ingrese la Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese un código" maxlength="10">
                                <div id="_codigo"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese la descripción" rows="5"></textarea>
                                <div id="_descripcion" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="limpiar_input_financiamiento()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_financiamiento"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Fuente de Financiamiento</button>
                </div>
            </div>
        </div>
    </div>
    <!--PARA EDITAR FUENTE DE FINANCIAMIENTO-->
    <div class="modal slide" id="editar_fuente_financiamiento" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO FUENTE DE FINANCIAMIENTO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="borrar_errores_editar_fn()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_fuente_financiamiento_edi" method="POST" autocomplete="off">
                        <input type="hidden" name="id_financiamiento" id="id_financiamiento">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="sigla_" class="form-label">Ingrese la Sigla</label>
                                <input type="text" class="form-control" id="sigla_" name="sigla_" placeholder="Ingrese una sigla" maxlength="10">
                                <div id="_sigla_"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="codigo_" class="form-label">Ingrese la Código</label>
                                <input type="text" class="form-control" id="codigo_" name="codigo_" placeholder="Ingrese un código" maxlength="10">
                                <div id="_codigo_"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion_" id="descripcion_" placeholder="Ingrese la descripción" rows="5"></textarea>
                                <div id="_descripcion_" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="borrar_errores_editar_fn()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_editado_financiamiento"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Fuente de Financiamiento</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function listar_financiamiento(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listafuenteFinanciamiento') }}",
                dataType: "JSON",
                success: function (data) {
                    let valores = data.fuente_financimiento;
                    let i = 1;
                    let cuerpo = "";
                    for(let key in valores){
                        cuerpo += "<tr>";
                        cuerpo += "<td>"+ i++ +"</td>";
                        cuerpo += "<td>"+ valores[key]['sigla'] +"</td>";
                        cuerpo += "<td>"+ valores[key]['codigo'] +"</td>";
                        cuerpo += "<td>"+ valores[key]['descripcion'] +"</td>";
                        if (valores[key]['estado'] == 'activo') {
                            cuerpo += "<td> <span class='badge text-bg-success'>" + valores[key]['estado'] +
                                "</span> </td>";
                        } else {
                            cuerpo += "<td> <span class='badge text-bg-danger'>" + valores[key]['estado'] +
                                "</span> </td>";
                        }
                        cuerpo += `<td>
                            <button type="button" class="btn btn-outline-primary" onclick="cambiar_estado('${valores[key]['id']}')">Estado</button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editar_financiamiento('${valores[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                            @can('fuenteDeFinanciamiento_eliminar')
                                <button class="btn btn-outline-danger btn-sm" onclick="eliminar_financiamiento('${valores[key]['id']}')"><i class="ri-delete-bin-7-fill"></i></button>
                            @endcan
                        </td>`;
                        cuerpo += "</tr>";
                    }
                    document.getElementById('listar_fdfianciamiento').innerHTML = cuerpo;
                }
            });
        }
        listar_financiamiento();

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
                        url: "{{ route('adm_fdfinanciamiento_estado') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_financiamiento();
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
        //para guardar el nuevo fuente de financiamiento
        $(document).on('click', '#btn_guardar_financiamiento', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_fuente_financiamiento'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_fdfinanciamiento_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    vaciar_fuente_financiamiento();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_financiamiento();
                        setTimeout(() => {
                            $('#nuevo_fuente_financiamiento').modal('hide');
                        }, 1000);
                        limpiar_input_financiamiento();
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //para vaciar los errores
        function vaciar_fuente_financiamiento(){
            document.getElementById('_sigla').innerHTML = '';
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_descripcion').innerHTML = '';
        }
        //para limpiar los input
        function limpiar_input_financiamiento(){
            limpiar_campos('form_fuente_financiamiento');
            vaciar_fuente_financiamiento();
        }
        //para editar la fuente de financiamiento
        function editar_financiamiento(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_fdfinanciamiento_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_fuente_financiamiento').modal('show');
                        document.getElementById('id_financiamiento').value = data.mensaje.id;
                        document.getElementById('sigla_').value = data.mensaje.sigla;
                        document.getElementById('codigo_').value = data.mensaje.codigo;
                        document.getElementById('descripcion_').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }
        //para borrar errores de edicion
        function borrar_errores_editar_fn(){
            document.getElementById('_sigla_').innerHTML = '';
            document.getElementById('_codigo_').innerHTML = '';
            document.getElementById('_descripcion_').innerHTML = '';
        }
        //para guardar lo editado
        $(document).on('click', '#btn_guardar_editado_financiamiento', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_fuente_financiamiento_edi'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_fdfinanciamiento_editar_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    borrar_errores_editar_fn();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_financiamiento();
                        setTimeout(() => {
                            $('#editar_fuente_financiamiento').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para eliminar fuente de financiamiento
        function eliminar_financiamiento(id){
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
                        url: "{{ route('adm_fdfinanciamiento_eliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_financiamiento();
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
