@extends('principal')
@section('titulo', 'Usuarios')
@section('contenido')

    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h3>USUARIOS</h3>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administracion de usuarios</li>
                        <li>Usuarios</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card-box-style">

        <ul class="nav nav-tabs nav-fill mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link link-secondary active" id="home-tab" data-bs-toggle="tab"
                    data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                    aria-selected="true">USUARIOS ACTIVOS</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link link-secondary" id="profile-tab" data-bs-toggle="tab"
                    data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                    aria-selected="false">USUARIOS INACTIVOS</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">
                <h3></h3>
                <div class="others-title d-flex align-items-center">
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#nuevo_usuario"> <i class="bx bxs-add-to-queue"></i> Nuevo Usuario</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-sm dataTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PERFIL</th>
                                <th>CI</th>
                                <th>NOMBRES</th>
                                <th>ROL</th>
                                <th>CORREO</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($us_activos as $lis)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td></td>
                                    <td>{{ $lis->ci_persona }}</td>
                                    <td>{{ $lis->nombre . ' ' . $lis->apellido }}</td>
                                    <td>
                                        @if (!empty($lis->getRoleNames()))
                                            @foreach ($lis->getRoleNames() as $rolNombre)
                                                <span class="badge rounded-pill text-bg-primary">{{ $rolNombre }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $lis->email }}</td>
                                    <td>
                                        <div class="form-check form-switch ">
                                            @if ($lis->estado == 'activo')
                                                <input class="form-check-input" type="checkbox"
                                                    onclick="estado_usuario('{{ $lis->id }}')" checked="checked" />
                                            @else
                                                <input class="form-check-input " type="checkbox"
                                                    onclick="estado_usuario('{{ $lis->id }}')" />
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm"
                                            onclick="reset_usuario('{{ $lis->id }}')"><i
                                                class="ri-lock-unlock-line"></i></button>
                                        <button class="btn btn-outline-warning btn-sm"
                                            onclick="editar_usuario_e('{{ $lis->id }}')"><i
                                                class="ri-edit-2-fill"></i></button>
                                        <button class="btn btn-outline-danger btn-sm"
                                            onclick="eliminar_usuario('{{ $lis->id }}')"><i
                                                class="ri-delete-bin-7-fill"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm dataTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PERFIL</th>
                                <th>CI</th>
                                <th>NOMBRES</th>
                                <th>ROL</th>
                                <th>CORREO</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($us_inactivos as $lis)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td></td>
                                    <td>{{ $lis->ci_persona }}</td>
                                    <td>{{ $lis->nombre . ' ' . $lis->apellido }}</td>
                                    <td>
                                        @if (!empty($lis->getRoleNames()))
                                            @foreach ($lis->getRoleNames() as $rolNombre)
                                                <span class="badge rounded-pill text-bg-primary">{{ $rolNombre }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $lis->email }}</td>
                                    <td>
                                        <div class="form-check form-switch ">
                                            @if ($lis->estado == 'activo')
                                                <input class="form-check-input" type="checkbox"
                                                    onclick="estado_usuario('{{ $lis->id }}')" checked="checked" />
                                            @else
                                                <input class="form-check-input " type="checkbox"
                                                    onclick="estado_usuario('{{ $lis->id }}')" />
                                            @endif
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

    <!-- Modal nuevo-->
    <div class="modal zoom" id="nuevo_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Nuevo Usuario</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_usuario" method="post" autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="ci" class="form-label">CI</label>
                                <input type="text" class="form-control" id="ci" name="ci"
                                    placeholder="Ingrese ci" onkeyup="validar_us(this.value)" maxlength="10">
                                <div id="_ci"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Ingrese un nombre" disabled>
                                <div id="_nombre"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido"
                                    placeholder="Ingrese un apellido" disabled>
                                <div id="_apellido"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="email" class="form-label">Email <span class="text-muted"
                                        style="font-size:.8em">(Recibira notificaciones)</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Ingrese un correo valido" disabled>
                                <div id="_email"></div>
                            </div>


                            {{-- <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <table class="table" >
                                    <tbody>
                                        @forelse ($roles as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <input class="form-check-input" type="checkbox" id="{{ $value->id }}" name="rol[]" value="{{ $value->id }}" >
                                                        <label class="form-check-label" for="{{ $value->id }}">
                                                            {{ $value->name }}
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                        --------
                                        @endforelse
                                    </tbody>
                                </table>
                            </div> --}}
                            <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <label for="rol" class="form-label">Seleccione un rol</label>
                                <select name="rol" id="rol" class="form-select"
                                    onchange="verificar_roles(this.value)">
                                    <option selected disabled>[SELECCIONE ROL]</option>
                                    @foreach ($roles as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <label for="tipo" class="form-label">Seleccione Tipo</label>
                                <select name="tipo" id="tipo" class="select2" onchange="listar_cua(this.value)">
                                    <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                </select>
                            </div>

                            <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <label for="carrera" class="form-label" id="tipo_seleccionado">Seleccione:</label>
                                <select name="carrera" id="carrera" class="select2" disabled>
                                    <option value="selected" selected disabled>[SELECCIONE]</option>
                                </select>
                            </div>

                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario"
                                    placeholder="Ingrese un usuario" disabled>
                                <div id="_usuario"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    placeholder="Ingrese un password" disabled>
                                <div id="_password"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_usuario" disabled> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Usuario</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal reset-->
    <div class="modal zoom" id="Modal_usuario_reset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Reset Usuario</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="vaciar_campo_reset()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_usuario_reset" method="post" autocomplete="off">
                        <input type="hidden" name="id_us" id="id_us">
                        <div class="row">
                            <div id="alerta"></div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="usuario_r" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario_r" name="usuario_r"
                                    placeholder="Ingrese usuario" maxlength="15">
                                <div id="_usuario_r"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="nombre" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password_r" name="password_r"
                                    placeholder="Ingrese password">
                                <div id="_password_r"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="vaciar_campo_reset()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_usuario_reset"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Usuario y contraseña</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal nuevo-->email
    <div class="modal zoom" id="editar_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Editar usuario</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_usuario_editar" method="post" autocomplete="off">
                        <input type="hidden" name="us_id_ed" id="us_id_ed">
                        <div class="row">
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="ci" class="form-label">CI</label>
                                <input type="text" class="form-control" id="ci_e" name="ci_e"
                                    placeholder="Ingrese ci" maxlength="10" readonly>
                                <div id="_ci_e"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_e" name="nombre_e"
                                    placeholder="Ingrese un nombre">
                                <div id="_nombre_e"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido_e" name="apellido_e"
                                    placeholder="Ingrese un apellido">
                                <div id="_apellido_e"></div>
                            </div>
                            <div class="mb-3 col-xl-6 col-md-6 col-lg-6 col-sm-12">
                                <label for="email" class="form-label">Email <span class="text-muted"
                                        style="font-size:.8em">(Recibira notificaciones)</span></label>
                                <input type="email" class="form-control" id="email_e" name="email_e"
                                    placeholder="Ingrese un correo valido">
                                <div id="_email_e"></div>
                            </div>
                            <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <label for="roles_edi" class="form-label">Seleccione un rol</label>
                                <select name="roles_edi" id="roles_edi" class="select2_segundo">
                                    <option selected disabled>[SELECCIONE ROL]</option>
                                    @foreach ($roles as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <label for="tipo" class="form-label">Seleccione Tipo</label>
                                <select name="tipo_" id="tipo_" class="select2_segundo">
                                    <option value="selected" selected disabled>[SELECCIONE TIPO]</option>
                                </select>
                            </div>

                            <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <label for="carrera" class="form-label" id="tipo_seleccionado_">Seleccione:</label>
                                <select name="carrera_" id="carrera_" class="select2_segundo" disabled>
                                    <option value="selected" selected disabled>[SELECCIONE]</option>
                                </select>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_usuario_edi"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Usuario</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
    <script>
        function validar_us(ci) {
            if (ci.length > 4) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('adm_validar_ci') }}",
                    data: {
                        ci: ci
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.tipo === 'error') {
                            bloquear();
                            document.getElementById('_ci').innerHTML = '<p style="color:red" >' + data.mensaje +
                                '</p>';
                        }
                        if (data.tipo === 'success') {
                            habilitar();
                            document.getElementById('usuario').value = 'Us_' + ci;
                            document.getElementById('password').value = ci;
                        }
                    }
                });
            } else {
                bloquear();
                document.getElementById('_ci').innerHTML = '';
            }
        }


        function habilitar() {
            document.getElementById('nombre').disabled = false;
            document.getElementById('apellido').disabled = false;
            document.getElementById('email').disabled = false;
            document.getElementById('usuario').disabled = false;
            document.getElementById('password').disabled = false;
            document.getElementById('_ci').innerHTML = '';
            document.getElementById('btn_guardar_usuario').disabled = false;
        }

        function bloquear() {
            document.getElementById('nombre').disabled = true;
            document.getElementById('apellido').disabled = true;
            document.getElementById('email').disabled = true;
            document.getElementById('usuario').disabled = true;
            document.getElementById('password').disabled = true;
            document.getElementById('btn_guardar_usuario').disabled = true;
            document.getElementById('usuario').value = '';
            document.getElementById('password').value = '';
            vaciar_errores();
        }
        //vaciar errores
        function vaciar_errores() {
            document.getElementById('_ci').innerHTML = '';
            document.getElementById('_nombre').innerHTML = '';
            document.getElementById('_apellido').innerHTML = '';
            document.getElementById('_email').innerHTML = '';
            document.getElementById('_usuario').innerHTML = '';
            document.getElementById('_password').innerHTML = '';
        }

        //para guardar usuario
        $(document).on('click', '#btn_guardar_usuario', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_usuario'));
            vaciar_errores();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_guardar_usuario') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.tipo === 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = '<p id="error_in" >' + obj[
                                key] + '</p>';
                        }
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }

                    if (data.tipo === 'success') {
                        $('#nuevo_usuario').modal('hide');
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location = '';
                        }, 1600);
                    }

                }
            });
        });

        select2_rodry('#nuevo_usuario');
        //para la parte de los roles
        function verificar_roles(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_usuario_cua') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#tipo').empty().append(
                        '<option selected disabled>[SELECCIONE TIPO]</option>'
                    );
                    $('#carrera').empty().append(
                        '<option selected disabled>[SELECCIONE]</option>'
                    );
                    let tipo_cua = document.getElementById('tipo');
                    let lista_cua = document.getElementById('carrera');
                    if (data.tipo === 'error') {
                        tipo_cua.disabled = true;
                        lista_cua.disabled = true;
                    }
                    if (data.tipo === 'success') {
                        tipo_cua.disabled = false;
                        lista_cua.disabled = true;
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#tipo').append('<option value = "' + value.id + '">' + value.nombre +
                                '</option>');
                        });
                    }
                }
            });
        }

        //para listar
        function listar_cua(id) {
            let lista_cua = document.getElementById('carrera');
            let tipo_seleccionado = document.getElementById('tipo_seleccionado');
            $.ajax({
                type: "POST",
                url: "{{ route('adm_usuario_listar_cua') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#carrera').empty().append(
                        '<option selected disabled>[SELECCIONE]</option>'
                    );
                    if (data.tipo === 'success') {
                        lista_cua.disabled = false;
                        tipo_seleccionado.innerHTML = 'Seleccione : ' + data.tipo_cua.nombre;
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#carrera').append('<option value = "' + value.id + '">' + value
                                .nombre_completo + '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        lista_cua.disabled = true;
                        tipo_seleccionado.innerHTML = '';
                    }
                }
            });
        }

        //eliminar uusairo
        function eliminar_usuario(id) {
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
                        url: "{{ route('adm_eliminar_usuario') }}",
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
                    alerta_top('error', 'Se cancelo');
                }
            })
        }

        //reset usuario
        function reset_usuario(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_reset_usuario') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        $('#Modal_usuario_reset').modal('show');
                        document.getElementById('alerta').innerHTML =
                            `<div class="alert alert-primary" role="alert">Usuario : <a href="#" class="alert-link">` +
                            data.mensaje.nombre + ' ' + data.mensaje.apellido + `</a></div>`;
                        document.getElementById('id_us').value = data.mensaje.id;
                        document.getElementById('usuario_r').value = data.mensaje.ci_persona;
                        document.getElementById('password_r').value = 'Res_' + data.mensaje.ci_persona;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para guardar uusario reseteado
        $(document).on('click', '#btn_guardar_usuario_reset', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_usuario_reset'));
            vaciar_campo_reset();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_reset_usuario_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.tipo === 'errores') {
                        let obj = data.mensaje;
                        for (const key in obj) {
                            document.getElementById('_' + key).innerHTML = '<p id="error_in" >' + obj[
                                key] + '</p>';
                        }
                    }
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#Modal_usuario_reset').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //vaciar campos errores
        function vaciar_campo_reset() {
            document.getElementById('_usuario_r').innerHTML = '';
            document.getElementById('_password_r').innerHTML = '';
        }

        segundo_select2('#editar_usuario');
        //editar usuario
        function editar_usuario_e(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editar_usuario') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);

                    $('#editar_usuario').modal('show');
                    document.getElementById('us_id_ed').value = data.usuario.id;
                    document.getElementById('ci_e').value = data.usuario.ci_persona;
                    document.getElementById('nombre_e').value = data.usuario.nombre;
                    document.getElementById('apellido_e').value = data.usuario.apellido;
                    document.getElementById('email_e').value = data.usuario.email;
                    $('#roles_edi').val(data.usuario.roles[0].id).trigger('change');

                    $('#tipo_').empty().append(
                        '<option selected disabled>[SELECCIONE TIPO]</option>'
                    );
                    $('#carrera_').empty().append(
                        '<option selected disabled>[SELECCIONE]</option>'
                    );

                    let tipo_ = document.getElementById('tipo_');
                    let carrera_ = document.getElementById('carrera_');
                    // if (data.carreras != null) {
                    tipo_.disabled = false;
                    data.tipo_cua_.forEach(value => {
                        $('#tipo_').append('<option value = "' + value.id + '">' + value.nombre +
                            '</option>');
                    });
                    if (data.carreras) {
                        $('#tipo_').val(data.carreras.tipo__carrera__unidada_area.id).trigger('change');

                        carrera_.disabled = false;
                        data.lis_carrera.forEach(value => {
                            $('#carrera_').append('<option value = "' + value.id + '">' + value
                                .nombre_completo + '</option>');
                        });
                        $('#carrera_').val(data.usuario.id_unidad_carrera).trigger('change');
                    }
                    // } else {
                    //     tipo_.disabled = true;
                    //     carrera_.disabled = true;
                    // }
                }
            });
        }

        //para la para la parte de los roles
        let select2_roles_edi = $("#roles_edi");
        select2_roles_edi.on('select2:select', function(e) {
            let id = select2_roles_edi.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_usuario_cua') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#tipo_').empty().append(
                        '<option selected disabled>[SELECCIONE TIPO]</option>'
                    );
                    $('#carrera_').empty().append(
                        '<option selected disabled>[SELECCIONE]</option>'
                    );
                    let tipo_cua = document.getElementById('tipo_');
                    let lista_cua = document.getElementById('carrera_');
                    if (data.tipo === 'error') {
                        tipo_cua.disabled = true;
                        lista_cua.disabled = true;
                    }
                    if (data.tipo === 'success') {
                        tipo_cua.disabled = false;
                        lista_cua.disabled = true;
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#tipo_').append('<option value = "' + value.id + '">' + value
                                .nombre + '</option>');
                        });
                    }
                }
            });
        });

        let select2_tipo_ = $("#tipo_");
        select2_tipo_.on('select2:select', function(e) {
            let id = select2_tipo_.val();
            let lista_cua = document.getElementById('carrera_');
            let tipo_seleccionado = document.getElementById('tipo_seleccionado_');
            $.ajax({
                type: "POST",
                url: "{{ route('adm_usuario_listar_cua') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#carrera_').empty().append(
                        '<option selected disabled>[SELECCIONE]</option>'
                    );
                    if (data.tipo === 'success') {
                        lista_cua.disabled = false;
                        tipo_seleccionado.innerHTML = 'Seleccione : ' + data.tipo_cua.nombre;
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#carrera_').append('<option value = "' + value.id + '">' + value
                                .nombre_completo + '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        lista_cua.disabled = true;
                        tipo_seleccionado.innerHTML = '';
                    }
                }
            });
        });



        //para guardar editado
        $(document).on('click', '#btn_guardar_usuario_edi', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_usuario_editar'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editar_usuario_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.tipo === 'errores') {
                        let obj = data.mensaje;
                        for (const key in obj) {
                            document.getElementById('_' + key).innerHTML = '<p id="error_in" >' + obj[
                                key] + '</p>';
                        }
                    }
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#editar_usuario').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para estado de usuario
        function estado_usuario(id) {


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
                        url: "{{ route('adm_usuario_estado') }}",
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
                    alerta_top('error', 'Se cancelo');
                }
            })
        }
    </script>
@endsection
