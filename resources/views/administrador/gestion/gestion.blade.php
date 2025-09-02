@extends('principal')
@section('titulo', 'Gestión')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_gestion.css') }}">
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h3>GESTIÓN</h3>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administracion de Gestión</li>
                        <li>Gestión</li>
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
                        @can('gestion_crear')
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nueva_gestion"> <i class="bx bxs-add-to-queue"></i> Nueva Gestión</button>
                        @endcan
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm align-middle dataTable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ACCIONES</th>
                                <th>PDES</th>
                                <th>ÁREAS ESTRATÉGICAS</th>
                                <th>INDICADORES</th>
                                <th>GESTIONES</th>
                                <th>INICIO DE GESTIÓN</th>
                                <th>FIN DE GESTIÓN</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gestion as $lis)
                                <tr>
                                    <td>
                                        @can('gestion_seleccionar')
                                            <button onclick="modal_seleccionar('{{ $lis->id }}')" class="btn btn-outline-primary btn-sm"><i class="ri-settings-5-fill"></i></button>
                                        @endcan
                                        @can('gestion_editar')
                                            <button class="btn btn-outline-warning btn-sm" onclick="editar_gestion('{{ $lis->id }}')"><i class="ri-edit-2-fill"></i></button>
                                        @endcan
                                        @can('gestion_eliminar')
                                            <button class="btn btn-outline-danger btn-sm" onclick="eliminar_gestion('{{ $lis->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('gestion_pdes')
                                            <button class="btn btn-outline-primary btn-sm" onclick="mostrar_pdes('{{ $lis->id }}')"><i class="ri-eye-fill"></i> PDES</button>
                                        @endcan

                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" onclick="areas_estrategicas('{{ $lis->id }}')"><i class="ri-eye-fill"></i> Areas Estrategicas</button>
                                    </td>
                                    <td>
                                        <a href="{{ route('adm_indicador', ['id'=> encriptar($lis->id)]) }}" class="btn btn-outline-primary btn-sm"><i class="ri-eye-fill"></i> Indicador</a>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" onclick="mostrar_gestiones('{{ $lis->id }}')"><i class="ri-file-list-3-fill"></i> Gestiones</button>
                                    </td>
                                    <td>{{ $lis->inicio_gestion }}</td>
                                    <td>{{ $lis->fin_gestion }}</td>
                                    <td>
                                        @if ($lis->estado === 'activo')
                                            <div class="form-check form-switch ">
                                                <input class="form-check-input" type="checkbox" checked="checked" onclick="estado_gestion('{{ $lis->id }}')" />
                                            </div>
                                        @else
                                            <div class="form-check form-switch ">
                                                <input class="form-check-input" type="checkbox" onclick="estado_gestion('{{ $lis->id }}')" />
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal nuevo-->
    <div class="modal zoom" id="nueva_gestion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Nueva Gestión</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="vaciar_campo_gestion()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_gestion" method="post" autocomplete="off">
                        <div class="row">
                            <div class="mb-3">
                                <label for="gestion_id" class="form-label">Ingrese una gestión inicial</label>
                                <input type="text" class="form-control" id="gestion_id" name="gestion_inicial"
                                    placeholder="Ingrese una gestión inicial" maxlength="4"
                                    onkeypress="return soloNumeros(event)" onkeyup="validar_anios(this.value)">
                                <div id="_gestion_inicial"></div>
                            </div>
                            <div class="mb-3">
                                <label for="gestion_id_fin" class="form-label">Ingrese una gestión final</label>
                                <input type="text" class="form-control" id="gestion_id_fin" name="gestion_final"
                                    placeholder="Ingrese una gestión final" maxlength="4"
                                    onkeypress="return soloNumeros(event)" readonly>
                                <div id="_gestion_final"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="vaciar_campo_gestion()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_gestion"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Gestión</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar -->
    <div class="modal slide" id="editar_gestion" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Editar Permiso</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_gestion_editar" method="post" autocomplete="off">
                        <input type="hidden" id="id_gestion_edi" name="id_gestion_edi">
                        <div class="row">
                            <div class="mb-3">
                                <label for="gestion_id" class="form-label">Ingrese una gestión inicial</label>
                                <input type="text" class="form-control" id="gestion_id_edi" name="gestion_inicial_e"
                                    placeholder="Ingrese una gestión inicial" maxlength="4"
                                    onkeypress="return soloNumeros(event)" onkeyup="validar_anios_e(this.value)">
                                <div id="_gestion_inicial_e"></div>
                            </div>
                            <div class="mb-3">
                                <label for="gestion_id_fin_edi" class="form-label">Ingrese una gestión final</label>
                                <input type="text" class="form-control" id="gestion_id_fin_edi"
                                    name="gestion_final_e" placeholder="Ingrese una gestión final" maxlength="4"
                                    onkeypress="return soloNumeros(event)" readonly>
                                <div id="_gestion_final_e"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_gestion_edi"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Permiso</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal  nostrar las gestiones-->
    <div class="modal slide" id="mostrar_gestiones" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Mostrar Gestiones</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="gestiones_datos">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>GESTIÓN</th>
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="listar_gestiones">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ÁREAS ESTRATÉGICAS -->
    <div class="modal slide" id="modal_areas_estrategicas" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">ÁREAS ESTRATÉGICAS</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="vaciar_campos_cerrar()"></button>
                </div>
                <div class="modal-body" id="gestiones_datos">

                    <form id="form_areas_estrategicas" method="post" autocomplete="off">
                        <input type="hidden" name="id_gestion" id="id_gestion">
                        <input type="hidden" name="id_area_estrategica" id="id_area_estrategica">
                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                        placeholder="Ingrese una gestión inicial" maxlength="4"
                                        onkeypress="return soloNumeros(event)">
                                    <div id="_codigo"></div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="2" placeholder="Descripción"></textarea>
                                    <div id="_descripcion"></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-outline-primary"
                                        id="btn_guardar_area_estrategica">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="listar_areas_estrategicas_html">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ÁREAS ESTRATÉGICAS -->
    <div class="modal slide" id="modal_seleccionar" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">SELECCIONAR</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="selecionar_thml">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal PLAN DE DESARROLLO ECONÓMICO Y SOCIAL  -->
    <div class="modal slide" id="modal_pdes" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">PLAN DE DESARROLLO ECONÓMICO Y SOCIAL <br> <div id="gestion_html_pdes" ></div> </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciar_campos_pdes()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_pdes" method="post" autocomplete="off">
                        <input type="hidden" id="id_pdes" name="id_pdes">
                        <input type="hidden" id="id_gestion_pdes" name="id_gestion_pdes">
                        <div class="row">
                            <div class="mb-3">
                                <label for="codigo_eje" class="form-label">Ingrese código del Eje</label>
                                <input type="text" class="form-control" id="codigo_eje" name="codigo_eje" placeholder="Ingrese el codigo del eje" maxlength="2" onkeypress="return soloNumeros(event)" onkeyup="validar_codigo_eje(this.value)">
                                <div id="_codigo_eje" ></div>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_eje" class="form-label">Descripción del Eje</label>
                                <textarea name="descripcion_eje" id="descripcion_eje" cols="30" rows="3" class="form-control" placeholder="Descipción del eje"></textarea>
                                <div id="_descripcion_eje" ></div>
                            </div>

                            <div class="mb-3">
                                <label for="codigo_meta" class="form-label">Ingrese código del Meta</label>
                                <input type="text" class="form-control" id="codigo_meta" name="codigo_meta" placeholder="Ingrese el codigo de la meta" maxlength="8" onkeyup="validar_codigo_meta(this.value)">
                                <div id="_codigo_meta" ></div>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_meta" class="form-label">Descripción del Meta</label>
                                <textarea name="descripcion_meta" id="descripcion_meta" cols="30" rows="3" class="form-control" placeholder="Descipción de la meta"></textarea>
                                <div id="_descripcion_meta" ></div>
                            </div>

                            <div class="mb-3">
                                <label for="codigo_resultado" class="form-label">Ingrese código del resultado</label>
                                <input type="text" class="form-control" id="codigo_resultado" name="codigo_resultado" placeholder="Ingrese el codigo del resultado" maxlength="8" onkeyup="validar_codigo_resultado(this.value)">
                                <div id="_codigo_resultado" ></div>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_resultado" class="form-label">Descripción del resultado</label>
                                <textarea name="descripcion_resultado" id="descripcion_resultado" cols="30" rows="3" class="form-control" placeholder="Descripción del resultado"></textarea>
                                <div id="_descripcion_resultado" ></div>
                            </div>

                            <div class="mb-3">
                                <label for="codigo_accion" class="form-label">Ingrese código del acción</label>
                                <input type="text" class="form-control" id="codigo_accion" name="codigo_accion" placeholder="Ingrese el codigo del resultado" maxlength="8">
                                <div id="_codigo_accion" ></div>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion_accion" class="form-label">Descripción del acción</label>
                                <textarea name="descripcion_accion" id="descripcion_accion" cols="30" rows="3" class="form-control" placeholder="Descripción acción"></textarea>
                                <div id="_descripcion_accion" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciar_campos_pdes()">Cerrar</button>
                    @can('gestion_pdes_guardar')
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_pdes"> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar PDES</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        //para validar los 5 años
        function validar_anios(anio) {
            let anio_fin = document.getElementById('gestion_id_fin');
            if (anio.length === 4) {
                anio_fin.value = parseFloat(anio) + parseFloat(4);
            } else {
                anio_fin.value = '';
                vaciar_campos_html();
            }
        }

        //vaciar campos value
        function vaciar_campo_gestion() {
            document.getElementById('gestion_id').value = '';
            document.getElementById('gestion_id_fin').value = '';
            vaciar_campos_html();
        }
        //vaciar capos html
        function vaciar_campos_html() {
            document.getElementById('_gestion_inicial').innerHTML = '';
            document.getElementById('_gestion_final').innerHTML = '';
        }

        //para guardar la gestion
        $(document).on('click', '#btn_guardar_gestion', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_gestion'));
            vaciar_campos_html();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_gestion_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location = '';
                        }, 1600);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //eliminar gestion
        function eliminar_gestion(id) {
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
                        url: "{{ route('adm_gestion_eliminar') }}",
                        data: {
                            id: id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                setTimeout(() => {
                                    window.location = '';
                                }, 1600);
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
        //editar gestion
        function editar_gestion(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_gestion_editar') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        $('#editar_gestion').modal('show');
                        document.getElementById('id_gestion_edi').value = data.mensaje.id;
                        document.getElementById('gestion_id_edi').value = data.mensaje.inicio_gestion;
                        document.getElementById('gestion_id_fin_edi').value = data.mensaje.fin_gestion;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        //para validar los 5 años
        function validar_anios_e(anio) {
            let anio_fin = document.getElementById('gestion_id_fin_edi');
            if (anio.length === 4) {
                anio_fin.value = parseFloat(anio) + parseFloat(4);
            } else {
                anio_fin.value = '';
                vaciar_campos_html_e();
            }
        }

        //vaciar capos html
        function vaciar_campos_html_e() {
            document.getElementById('_gestion_inicial_e').innerHTML = '';
            document.getElementById('_gestion_final_e').innerHTML = '';
        }

        //para guardar lo editado
        $(document).on('click', '#btn_guardar_gestion_edi', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_gestion_editar'));
            vaciar_campos_html_e();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_gestion_editar_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location = '';
                        }, 1600);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //para cambiar el estado de la gestión
        function estado_gestion(id) {
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
                        url: "{{ route('adm_gestion_estado') }}",
                        data: {
                            id: id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                setTimeout(() => {
                                    window.location = '';
                                }, 1600);
                            }
                            if (data.tipo === 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                    setTimeout(() => {
                        window.location = '';
                    }, 1600);
                }
            })
        }

        //mostrar gestiuones
        function mostrar_gestiones(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_gestiones_listar') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        $("#mostrar_gestiones").modal('show');
                        let i = 1;
                        let datos = data.mensaje;
                        let cuerpo = "";
                        for (let key in datos) {
                            cuerpo += '<tr>';
                            cuerpo += "<td>" + i++ + "</td>";
                            cuerpo += "<td>" + datos[key]['gestion'] + "</td>";
                            if (datos[key]['estado'] == 'activo') {
                                cuerpo += "<td> <span class='badge text-bg-success'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            } else {
                                cuerpo += "<td> <span class='badge text-bg-danger'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            }

                            cuerpo += `<td>
                                <button type="button" class="btn btn-outline-primary" onclick="cambiar_estado_gestions('${datos[key]['id']}')">Cambiar estado</button>
                            </td>`;
                            cuerpo += '</tr>';
                        }
                        document.getElementById('listar_gestiones').innerHTML = cuerpo;
                    } else {
                        console.log(data.mensaje);
                    }
                }
            });
        }

        function cambiar_estado_gestions(id) {
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
                        url: "{{ route('adm_gestiones_estado') }}",
                        data: {
                            id: id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                mostrar_gestiones(data.id_rec);
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

        //para la parte de ÁREAS ESTRATÉGICAS
        function areas_estrategicas(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listar_areas_estrategicas') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        document.getElementById('id_gestion').value = data.id_ges;
                        $('#modal_areas_estrategicas').modal('show');
                        let datos = data.mensaje.relacion_areas_estrategicas;
                        let cuerpo = "";
                        for (let key in datos) {
                            cuerpo += '<tr>';
                            cuerpo += "<td>" + datos[key]['codigo_areas_estrategicas'] + "</td>";
                            cuerpo += "<td>" + datos[key]['descripcion'] + "</td>";
                            if (datos[key]['estado'] == 'activo') {
                                cuerpo += "<td> <span class='badge text-bg-success'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            } else {
                                cuerpo += "<td> <span class='badge text-bg-danger'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            }

                            cuerpo += `<td>
                                @can('areas_estrategicas_eliminar')
                                    <button type="button" class="btn btn-outline-danger" onclick="eliminar_area_estrategica('${datos[key]['id']}','${datos[key]['id_gestion']}')" ><i class="ri-delete-bin-2-fill"></i></button>
                                @endcan
                                <button type="button" class="btn btn-outline-warning" onclick="editar_areas_estrategicas('${datos[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                                <button type="button" class="btn btn-outline-primary" onclick="cambiar_estado_area_estrategica('${datos[key]['id']}')">estado</button>
                            </td>`;
                            cuerpo += '</tr>';
                        }
                        document.getElementById('listar_areas_estrategicas_html').innerHTML = cuerpo;
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                },
                error: function() {
                    toastr["error"]("Ocurrio un error");
                }
            });
        }


        $(document).on('click', '#btn_guardar_area_estrategica', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_areas_estrategicas'));
            errores_c();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_areas_estrategicas_crear') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.tipo === 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = '<div id="error_in" >' + obj[key] + '</div>';
                        }
                    }
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        areas_estrategicas(data.id_aec);
                        vaciar_campos_cerrar();
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para vaciar los campos y los errores
        function vaciar_campos_cerrar() {
            document.getElementById('id_area_estrategica').value = '';
            document.getElementById('codigo').value = '';
            document.getElementById('descripcion').value = '';
            errores_c();
        }

        function errores_c() {
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_descripcion').innerHTML = '';
        }

        //PARA EL ESTADO
        function cambiar_estado_area_estrategica(id) {
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
                        url: "{{ route('adm_areas_estrategicas_estado') }}",
                        data: {
                            id: id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                areas_estrategicas(data.ges_id);
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

        //PARA ELIMINAR
        function eliminar_area_estrategica(id, id_gestion) {
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
                        url: "{{ route('adm_areas_estrategicas_eliminar') }}",
                        data: {
                            id: id,
                            id_gestion: id_gestion
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                vaciar_campos_cerrar();
                                alerta_top(data.tipo, data.mensaje);
                                areas_estrategicas(data.id_ges);
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

        //PARA EDITAR POLITICAS INSTITUCIONALES
        function editar_areas_estrategicas(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_areas_estrategicas_editar') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        document.getElementById('id_area_estrategica').value = data.mensaje.id;
                        document.getElementById('codigo').value = data.mensaje.codigo_areas_estrategicas;
                        document.getElementById('descripcion').value = data.mensaje.descripcion;
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }

        //para seleccionar PDU p PEI
        function modal_seleccionar(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_detalles') }}",
                data: {id:id},
                success: function (data) {
                    $('#modal_seleccionar').modal('show');
                    document.getElementById('selecionar_thml').innerHTML = data;
                }
            });

        }

        //PDES
        function mostrar_pdes(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_pdes_detalle') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data){
                    $('#modal_pdes').modal('show');
                    let id_pdes = document.getElementById('id_pdes');
                    let id_gestion_pdes = document.getElementById('id_gestion_pdes');
                    let codigo_eje_pdes = document.getElementById('codigo_eje');
                    let descripcion_eje_pdes = document.getElementById('descripcion_eje');
                    let codigo_meta_pdes = document.getElementById('codigo_meta');
                    let descripcion_meta_pdes = document.getElementById('descripcion_meta');
                    let codigo_resultado_pdes = document.getElementById('codigo_resultado');
                    let descripcion_resultado_pdes = document.getElementById('descripcion_resultado');
                    let codigo_accion_pdes = document.getElementById('codigo_accion');
                    let descripcion_accion_pdes = document.getElementById('descripcion_accion');
                    if(data.tipo=='success'){
                        document.getElementById('gestion_html_pdes').innerHTML = 'GESTIÓN ' + data.gestion_pdes_1.inicio_gestion+' - '+data.gestion_pdes_1.fin_gestion;
                        id_pdes.value = data.mensaje.id;
                        id_gestion_pdes.value = data.id;
                        codigo_eje_pdes.value = data.mensaje.codigo_eje;
                        descripcion_eje_pdes.value = data.mensaje.descripcion_eje;
                        codigo_meta_pdes.value = data.mensaje.codigo_meta;
                        descripcion_meta_pdes.value = data.mensaje.descripcion_meta;
                        codigo_resultado_pdes.value = data.mensaje.codigo_resultado;
                        descripcion_resultado_pdes.value = data.mensaje.descripcion_resultado;
                        codigo_accion_pdes.value = data.mensaje.codigo_accion;
                        descripcion_accion_pdes.value = data.mensaje.descripcion_accion;
                    }
                    if(data.tipo=='error'){
                        document.getElementById('gestion_html_pdes').innerHTML = 'GESTIÓN ' + data.gestion_pdes_1.inicio_gestion+' - '+data.gestion_pdes_1.fin_gestion;
                        id_pdes.value = '';
                        id_gestion_pdes.value = data.id;
                        codigo_eje_pdes.value = '';
                        descripcion_eje_pdes.value = '';
                        codigo_meta_pdes.value = '';
                        descripcion_meta_pdes.value = '';
                        codigo_resultado_pdes.value = '';
                        descripcion_resultado_pdes.value = '';
                        codigo_accion_pdes.value = '';
                        descripcion_accion_pdes.value = '';
                    }
                }
            });
        }

        //validar numeros
        function validar_codigo_eje(valor){
            if(valor){
                document.getElementById('codigo_meta').value = valor+'.';
            }else{
                document.getElementById('codigo_meta').value = '';
                document.getElementById('codigo_resultado').value = '';
                document.getElementById('codigo_accion').value = '';
            }
        }

        function validar_codigo_meta(valor){
            if(valor){
                document.getElementById('codigo_resultado').value = valor+'.';
            }else{
                document.getElementById('codigo_resultado').value = '';
                document.getElementById('codigo_accion').value = '';
            }
        }

        function validar_codigo_resultado(valor){
            if(valor){
                document.getElementById('codigo_accion').value = valor+'.';
            }else{
                document.getElementById('codigo_accion').value = '';
            }
        }

        //vaciar los campos del pdes
        function vaciar_campos_pdes(){
            limpiar_campos('form_pdes');
            vaciar_errores_pdes();
        }

        $(document).on('click', "#btn_guardar_pdes", (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_pdes'));
            vaciar_errores_pdes();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_pdes_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo==='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo==='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $("#modal_pdes").modal('hide');
                        }, 1000);
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $("#modal_pdes").modal('hide');
                        }, 1000);
                    }
                }
            });
        });

        //para vaciar la parte de errores
        function vaciar_errores_pdes(){
            document.getElementById('_codigo_eje').innerHTML = '';
            document.getElementById('_descripcion_eje').innerHTML = '';
            document.getElementById('_codigo_meta').innerHTML = '';
            document.getElementById('_descripcion_meta').innerHTML = '';
            document.getElementById('_codigo_resultado').innerHTML = '';
            document.getElementById('_descripcion_resultado').innerHTML = '';
            document.getElementById('_codigo_accion').innerHTML = '';
            document.getElementById('_descripcion_accion').innerHTML = '';
        }
    </script>
@endsection
