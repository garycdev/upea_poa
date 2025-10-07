<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <link rel="stylesheet" href="{{ asset('plantilla_admin/css/bootstrap.min.css') }}" type="text/css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 30px auto;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2563eb;
        }

        p {
            color: #333;
            line-height: 1.6;
        }

        footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-primary {
            color: #0d6efd;
        }

        .text-success {
            color: #198754;
        }

        .text-secondary {
            color: #777;
            margin-top: 24px;
            margin-bottom: 24px;
            margin-left: 12px;
            margin-right: 12px;
            font-size: .9em;
        }
    </style>
</head>

<body>
    <div class="container">
        <center>
            <img src="{{ config('app.url') }}/logos/banner-upea.png" alt=" upea" width="200">
        </center>
        <h1 class="{{ $color }}" style="margin-top;7px;">{{ $titulo }}</h1>

        <hr>

        <p>{{ $mensaje }}</p>

        <a href="{{ $url }}" class="btn btn-outline-primary">Ir al detalle del formulario</a>


        <p class="text-secondary">Si el enlace no funciona intentar copiar el siguiente enlace en un navegador <a
                href="{{ $url }}">{{ $url }}</a></p>

        <hr>
        <footer>
            | No responder a este correo electronico |
            <br>
            © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </footer>
    </div>
</body>

</html>
