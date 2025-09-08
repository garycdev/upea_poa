<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logos/upea_logo.png') }}">
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href="{{ asset('login_front/main.css') }}">
    <script src="{{ asset('login_front/main.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('rodry/estilo_capcha.css') }}">
</head>

<body>
    <div class="lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

    <div class="login-box">
        <h2>
            <img src="{{ asset('logos/upea-banner.png') }}" alt="upea" width="250">
        </h2>

        <div style="text-align: center; padding-bottom:10px;" id="respuesta"></div>
        <form id="inicio_sesion" method="POST" autocomplete="off">
            <div class="user-box">
                <input type="text" name="usuario" id="usuario" required="" autocomplete="off">
                <label> <i class="fa fa-user" aria-hidden="true"> </i> Usuario</label>
                <div id="_usuario"></div>
            </div>
            <div class="user-box">
                <input type="password" name="password" id="password" required="" autocomplete="off">
                <label> <i class="fa fa-lock" aria-hidden="true"> </i> Contraseña</label>
                <div id="_password"></div>
            </div>

            <div class="captcha">
                <div class="captcha-container">
                    <div class="rectangulo"></div>
                    <span class="captcha-text" id="optener_cap"></span>
                </div>
                <p class="btn-refrescar" onclick="inicio()"> <i class="fa fa-refresh" aria-hidden="true"></i></p>
            </div>

            <div class="user-box">
                <input type="text" name="captcha" id="captcha" required="" autocomplete="off"
                    onkeydown="if(event.key === 'Enter'){ event.preventDefault(); document.getElementById('btn_ingresar').click(); }">
                <label> Ingrese el captcha</label>
                <div id="_captcha"></div>
            </div>

            <input type="hidden" id="captcha_validar" name="captcha_validar">

            <div class="centrar">
                <a href="#" id="btn_ingresar">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Ingresar
                </a>
            </div>
        </form>
    </div>
    <script src="{{ asset('plantilla_admin/js/jquery.min.js') }}"></script>
    <script>
        let usuario = document.getElementById('_usuario');
        let password = document.getElementById('_password');
        let capcha = document.getElementById('_captcha');

        document.getElementById('btn_ingresar').addEventListener('click', async (e) => {
            e.preventDefault();
            let datos = Object.fromEntries(new FormData(document.getElementById('inicio_sesion')).entries());
            try {
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let respuesta = await fetch('{{ route('ingresar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos)
                });
                let data = await respuesta.json();
                if (data) {
                    console.log(data);
                    usuario.innerHTML = '';
                    password.innerHTML = '';
                    capcha.innerHTML = '';
                    if (data.tipo === 'validacion') {
                        for (let key in data.mensaje) {
                            document.getElementById('respuesta').innerHTML = '<p style="color:red">' + data
                                .mensaje + '</p>'
                        }
                    }
                    if (data.tipo == 'error') {
                        document.getElementById('respuesta').innerHTML = '<p style="color:red">' + data
                            .mensaje + '</p>'
                    }
                    if (data.tipo == 'success') {
                        document.getElementById('respuesta').innerHTML = '<p style="color:#ffff">' + data
                            .mensaje + '</p>';
                        setTimeout(() => {
                            window.location = '';
                        }, 1500);
                    }
                }
            } catch (error) {
                console.log(error);
            }
        });


        $(document).on("ready", inicio());

        function inicio() {
            $.get("{{ route('captcha') }}", function(data) {
                $('#optener_cap').html(data);
                $('#captcha_validar').val(data);
            });
        }
    </script>
</body>

</html>
