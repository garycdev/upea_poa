<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ asset('plantilla_admin/css/bootstrap.min.css') }}" type="text/css"> --}}
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="chartsjs-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card-box-style">
                        <div class="others-title d-flex justify-content-between">
                            <h3>MONTOS POR GESTION</h3>

                            <div class="form-group d-flex align-items-center">
                                <label for="gestions" class="form-label">Gestión:&nbsp;</label>
                                {{-- <select name="gestions" id="gestions" class="form-control">
                                    @foreach ($gestions as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->inicio_gestion }} - {{ $item->fin_gestion }}
                                        </option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                        <img src="{{ $chartUrl }}" style="width:100%;">
                        {{-- <canvas id="chart_gestiones"></canvas> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="chartjs-colors">
        <div class="bg-primary"></div>
        <div class="bg-primary-light"></div>
        <div class="bg-secondary"></div>
        <div class="bg-info"></div>
        <div class="bg-success"></div>
        <div class="bg-success-light"></div>
        <div class="bg-danger"></div>
        <div class="bg-warning"></div>
        <div class="bg-purple"></div>
        <div class="bg-pink"></div>
    </div>
</body>

</html>
