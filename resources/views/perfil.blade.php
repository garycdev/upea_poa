@extends('principal')
@section('titulo', 'Perfil')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h3>PERFIL</h3>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Perfil</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card-box-style">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="profile-info d-flex align-items-center">
                    @if (Auth::user()->perfil != null)
                        <img class="w-25 rounded-4" src="{{ asset('perfil/' . Auth::user()->perfil) }}" alt="profile-img"
                            loading="lazy">
                    @else
                        <img class="w-25 rounded-4" src="{{ asset('logos/upea_logo.png') }}" alt="profile-img"
                            loading="lazy">
                    @endif


                    <div class="profile-name ms-4">
                        <h4>{{ Auth::user()->nombre . ' ' . Auth::user()->apellido }}</h4>
                        <span>{{ Auth::user()->email }}</span>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#nuevo_perfil">Agregar foto de perfil</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <h3 class="text-center">ROLES</h3>
                <div class="row justify-content-center">
                    @if (!empty(Auth::user()->roles))
                        @foreach (Auth::user()->roles as $rolNombre)
                            <div class="col-lg-3 col-md-3 col-sm-6">
                                <div class="profile-activity">
                                    <span class="badge rounded-pill text-bg-light">{{ $rolNombre->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="profile-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="edit-profile-content card-box-style">
                        <h3>Perfil</h3>

                        <form method="POST" autocomplete="off" id="form_perfil">
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>CI</label>
                                        <input type="text" class="form-control" placeholder="CI" name="ci"
                                            value="{{ Auth::user()->ci_persona }}" readonly>
                                        <div id="_ci"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nombres</label>
                                        <input type="text" class="form-control" placeholder="Nombres" name="nombres"
                                            value="{{ Auth::user()->nombre }}">
                                        <div id="_nombres"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Apellido</label>
                                        <input type="text" class="form-control" placeholder="Apellidos" name="apellido"
                                            value="{{ Auth::user()->apellido }}">
                                        <div id="_apellido"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Correo <span class="text-muted" style="font-size:.8em">(Recibira
                                                notificaciones)</span></label>
                                        <input type="text" class="form-control" placeholder="Email" name="email"
                                            value="{{ Auth::user()->email }}">
                                        <div id="_email"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Numero de celular </label>
                                        <input type="text" class="form-control" placeholder="Numero de celular"
                                            name="celular" value="{{ Auth::user()->celular }}">
                                        <div id="_celular"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nombre de usuario </label>
                                        <input type="text" class="form-control" placeholder="Nombre de usuario"
                                            name="usuario" value="{{ Auth::user()->usuario }}">
                                        <div id="_usuario"></div>
                                    </div>
                                </div>

                                <div class="save-update text-center">
                                    <button class="btn btn-outline-primary me-2" id="btn_guardar_perfil">Guardar
                                        Perfil</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="edit-profile-content card-box-style">
                        <h3>Password</h3>
                        <form method="POST" id="form_password" autocomplete="off">
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Nuevo Password</label>
                                        <input type="password" name="password" class="form-control">
                                        <div id="_password"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Confirmar Password</label>
                                        <input type="password" class="form-control" name="confirmar_password">
                                        <div id="_confirmar_password"></div>
                                    </div>
                                </div>

                                <div class="save-update text-center">
                                    <button class="btn btn-outline-primary me-2" id="guardar_password">Guardar
                                        Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal nuevo-->
    <div class="modal zoom" id="nuevo_perfil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Nuevo Usuario</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12 text-center">
                            @if (Auth::user()->perfil != null)
                                <img class="rounded-pill" src="{{ asset('perfil/' . Auth::user()->perfil) }}"
                                    alt="" id="preview" style="max-width: 300px; max-height: 300px;">
                            @else
                                <img class="rounded-pill" src="{{ asset('logos/no_img.webp') }}" alt=""
                                    id="preview" style="max-width: 300px; max-height: 300px;">
                            @endif

                        </div>
                        <form id="form_perfil_imagen" method="post" autocomplete="off">
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <input type="hidden" class="form-control" name="img_ant"
                                value="{{ Auth::user()->perfil }}">

                            <div class="mb-3 col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                <label for="nombre" class="form-label">Seleccione una imagen</label>
                                <input type="file" class="form-control " name="perfil"
                                    onchange="previewImage(event)" accept="image/*">
                                <div id="error_img"></div>
                                <div id="_perfil"></div>
                            </div>
                        </form>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_perfil_imagen"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar Perfil</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function previewImage(event) {
            let input = event.target;
            let preview = document.getElementById('preview');

            let file = input.files[0];
            let reader = new FileReader();

            // Comprobamos el tamaño del archivo
            if (file.size > 2 * 1024 * 1024) {
                document.getElementById('error_img').innerHTML = '<p id="error_in" >No puede se mas de 2Mgs</p>';
                input.value = '';
                return;
            } else {
                reader.onload = () => {
                    const image = new Image();
                    image.src = reader.result;
                    image.onload = () => {
                        preview.src = reader.result;
                    };
                    document.getElementById('error_img').innerHTML = '';
                };
            }
            reader.readAsDataURL(file);
        }


        //para guardar perfil
        $(document).on('click', '#btn_guardar_perfil_imagen', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_perfil_imagen'));
            document.getElementById('_perfil').innerHTML = '';
            $.ajax({
                type: "POST",
                url: "{{ route('adm_perfil_imagen') }}",
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

                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location = '';
                        }, 1500);
                    }
                }
            });
        });

        function vaciar_campos_u() {
            document.getElementById('_ci').innerHTML = '';
            document.getElementById('_nombres').innerHTML = '';
            document.getElementById('_apellido').innerHTML = '';
            document.getElementById('_email').innerHTML = '';

            document.getElementById('_password').innerHTML = '';
            document.getElementById('_confirmar_password').innerHTML = '';
        }

        $(document).on('click', '#btn_guardar_perfil', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_perfil'));
            vaciar_campos_u();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_perfil_guardar') }}",
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
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location = '';
                        }, 1500);
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        $(document).on('click', '#guardar_password', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_password'));
            vaciar_campos_u();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_perfil_password') }}",
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
                    if (data.tipo === 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: data.tipo,
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        setTimeout(() => {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('salir') }}",
                                dataType: "JSON",
                                success: function(data) {
                                    window.location = '';
                                }
                            });
                        }, 3100);
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
    </script>
@endsection
