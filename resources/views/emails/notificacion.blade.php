<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
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

        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 10px 18px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
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
    </style>
</head>

<body>
    <div class="container">
        <h1 class="{{ $color }}">{{ $titulo }}</h1>

        <p>{{ $mensaje }}</p>

        <a href="{{ $url }}" class="button">Ir al detalle del formulario</a>

        <footer>
            © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </footer>
    </div>
</body>

</html>
