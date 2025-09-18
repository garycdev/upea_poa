@extends('principal')
@section('titulo', 'Inicio')
@section('contenido')
    @php
        $colores = ['primary', 'success', 'danger', 'warning', 'info', 'dark'];
        $styleIndex = 0;
    @endphp

    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-10 col-sm-10">
                    <div class="page-title">
                        <h4>
                            SISTEMA DE FORMULACIÓN Y SEGUIMIENTO DEL PLAN OPERATIVO ANUAL (POA - UPEA)
                        </h4>
                        <h5 class="text-muted">
                            BIENVENIDO/A {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}<br>
                        </h5>
                        <h6 class="text-muted">
                            {{ Auth::user()->id_unidad_carrera ? Auth::user()->unidad_carrera->nombre_completo : strtoupper(Auth::user()->role[0]->name) }}
                        </h6>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-2">
                    <ul class="page-title-list">
                        <li>Admin</li>
                        <li>inicio</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="overview-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="single-audience d-flex justify-content-between align-items-center">
                        <div class="audience-content">
                            <h5>Total Carreras, Unidades Administrativas y Areas</h5>
                            <h4>{{ $carreras_u }}<span>100%</span></h4>
                        </div>
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/note-2.svg') }}" alt="white-profile-2user">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="single-audience d-flex justify-content-between align-items-center">
                        <div class="audience-content">
                            <h5>Usuarios Activos</h5>
                            <h4> {{ $usuarios_activos }} <span> 100%</span></h4>
                        </div>
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/user-2.svg') }}" alt="eye">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="single-audience d-flex justify-content-between align-items-center">
                        <div class="audience-content">
                            <h5>Usuarios Inactivos</h5>
                            <h4> {{ $usuarios_inactivos }} <span> 0 %</span></h4>
                        </div>
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/people.svg') }}" alt="timer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="overview-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                    <div class="single-audience d-flex justify-content-between align-items-center">
                        <div class="audience-content">
                            <h5>
                                {{ Auth::user()->role[0]->name == 'usuario' ? 'Usuarios unidad/carrera' : 'Total Carreras, Unidades Administrativas y Areas' }}
                            </h5>
                            <h3>
                                {{ Auth::user()->role[0]->name == 'usuario' ? count($usuarios) : count($unidad_carrera) }}
                            </h3>
                        </div>
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/user-octagon-2.svg') }}"
                                alt="white-profile-2user">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                    <div class="single-audience d-flex justify-content-between align-items-center">
                        <div class="audience-content">
                            <h5>Formulados&nbsp;{{ Auth::user()->role[0]->name == 'usuario' ? '' : 'totales' }}</h5>
                            <h3 class="mb-0 text-dark fw-semibold">{{ count($formulados) }}</h3>
                        </div>
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/note-2.svg') }}" alt="eye">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                    <div class="single-audience d-flex justify-content-between align-items-center">
                        <div class="audience-content">
                            <h5 class="fw-normal">Modificaciones&nbsp;MOT</h5>
                            <h3 class="mb-0 text-dark fw-semibold">{{ count($mots) }}</h3>
                        </div>
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/note-2.svg') }}" alt="timer">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
                    <div class="single-audience d-flex justify-content-between align-items-center">
                        <div class="audience-content">
                            <h5 class="fw-normal">Formularios&nbsp;FUT</h5>
                            <h3 class="mb-0 text-dark fw-semibold">{{ count($futs) }}</h3>
                        </div>
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/note-2.svg') }}" alt="timer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->role[0]->name != 'usuario')
        <div class="chartsjs-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card-box-style">
                            <div class="others-title">
                                <h3>Carreras, Unidades Administrativas y Areas</h3>
                            </div>
                            <canvas id="basic_bar_chart"></canvas>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card-box-style">
                            <div class="others-title">
                                <h3>FORMULARIOS</h3>
                            </div>

                            <canvas id="basic_bar_chart1"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-7 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title fw-semibold">
                            Formulados recientes
                            <span class="float-end text-muted">Total: {{ count($formulados) }}</span>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <ul class="task-list">
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($formulados as $for)
                                @php
                                    if ($cont == 5) {
                                        break;
                                    }
                                @endphp
                                <li class="d-sm-flex align-items-center">
                                    <div class="icon me-4">
                                        <img src="{{ asset('plantilla_admin/images/icon/fatrows.svg') }}" alt="fatrow">
                                    </div>
                                    <div>
                                        @php
                                            $styleIndex = ($styleIndex + 1) % count($colores);
                                        @endphp
                                        <h6 class="fw-semibold">{{ $for->unidad_carrera->nombre_completo }}
                                            <span class="text-muted mx-2 fw-normal">{{ $for->gestion->gestion }}</span>
                                        </h6>
                                        <p class="text-muted mb-0">
                                            <span class="fw-semibold text-primary text-center">
                                                {{ $for->configuracion->codigo }}
                                            </span>
                                            - {{ $for->maxima_autoridad }}
                                        </p>
                                    </div>
                                    {{-- <div class="ms-auto d-md-flex">
                                                <span aria-label="anchor" class="text-muted">
                                                    <h5 class="d-inline-block">5</h5> formulados
                                                </span>
                                            </div> --}}
                                    @php
                                        $cont++;
                                    @endphp
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xxl-5 col-md-12">
                @if (Auth::user()->role[0]->name == 'usuario')
                    <div class="card">
                        <div class="card-header">
                            @php
                                $styleIndex = 0;
                                $totalG = 0;
                                foreach ($gestiones as $ges) {
                                    $totalG += count($ges->formulados);
                                }
                                // $total = 100 / $totalG;
                            @endphp
                            <h4 class="card-title fw-semibold">
                                Formulados Gestión
                                <span class="float-end text-muted">Total: {{ $totalG }}</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($gestiones as $gestion)
                                @if (count($gestion->formulados) > 0)
                                    @php
                                        if ($cont == 5) {
                                            break;
                                        }
                                    @endphp
                                    <div class="browser-stats">
                                        <div class="row mb-3">
                                            <div class="col-sm-2 col-lg-3 col-xl-3 col-xxl-2 mb-sm-0 mb-3">
                                                <img src="{{ asset('logos/upea_logo.png') }}" class="img-fluid"
                                                    alt="img">
                                            </div>
                                            <div class="col-sm-10 col-lg-9 col-xl-9 col-xxl-10 ps-sm-0">
                                                <div class="d-flex align-items-end justify-content-between mb-1">
                                                    <h5 class="mb-1 fw-semibold">{{ $gestion->gestion }}</h5>
                                                    <h6 class="fw-semibold mb-1">
                                                        {{ count($gestion->formulados) }}/{{ count($forms) }}&nbsp;formulados
                                                        <span class="text-success"></span>
                                                    </h6>
                                                </div>
                                                <div class="progress progress-sm mb-3">
                                                    <div class="progress-bar bg-{{ $colores[$styleIndex] }}"
                                                        style="width: {{ count($gestion->formulados) * (100 / count($forms)) }}%;">
                                                    </div>
                                                </div>
                                                @php
                                                    $styleIndex = ($styleIndex + 1) % count($colores);
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $cont++;
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            @php
                                $styleIndex = 0;
                                $totalG = 0;
                                $max = 0;
                                foreach ($gestiones as $ges) {
                                    $totalG += count($ges->formuladosAll);
                                    if (count($ges->formuladosAll) > $max) {
                                        $max = count($ges->formuladosAll);
                                    }
                                }
                                // $total = 100 / $totalG;
                            @endphp
                            <h4 class="card-title fw-semibold">
                                Formulados Gestión
                                <span class="float-end text-muted">Total: {{ $totalG }}</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            @php
                                $cont = 0;
                            @endphp
                            @foreach ($gestiones as $gestion)
                                @if (count($gestion->formuladosAll) > 0)
                                    @php
                                        if ($cont == 5) {
                                            break;
                                        }
                                    @endphp
                                    <div class="browser-stats">
                                        <div class="row mb-3">
                                            <div class="col-sm-2 col-lg-3 col-xl-3 col-xxl-2 mb-sm-0 mb-3">
                                                <img src="{{ asset('logos/upea_logo.png') }}" class="img-fluid"
                                                    alt="img">
                                            </div>
                                            <div class="col-sm-10 col-lg-9 col-xl-9 col-xxl-10 ps-sm-0">
                                                <div class="d-flex align-items-end justify-content-between mb-1">
                                                    <h5 class="mb-1 fw-bold">{{ $gestion->gestion }}</h5>
                                                    <h6 class="fw-semibold mb-1">
                                                        {{ count($gestion->formuladosAll) }}&nbsp;formulados
                                                    </h6>
                                                </div>
                                                <div class="progress progress-sm mb-3">
                                                    <div class="progress-bar bg-{{ $colores[$styleIndex] }}"
                                                        style="width: {{ count($gestion->formuladosAll) * (100 / $max) }}%;">
                                                    </div>
                                                </div>
                                                @php
                                                    $styleIndex = ($styleIndex + 1) % count($colores);
                                                @endphp
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $cont++;
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plantilla_admin/js/chart-js/chartjs.min.js') }}"></script>
    {{-- <script src="{{ asset('plantilla_admin/js/chart-js/chartjs-custom.js') }}"></script> --}}

    <script>
        'use strict';
        $(document).ready(function() {
            var colors = {
                primary: $('.chartjs-colors .bg-primary').css('background-color'),
                secondary: $('.chartjs-colors .bg-secondary').css('background-color'),
                info: $('.chartjs-colors .bg-info').css('background-color'),
                success: $('.chartjs-colors .bg-success').css('background-color'),
                danger: $('.chartjs-colors .bg-danger').css('background-color'),
                warning: $('.chartjs-colors .bg-warning').css('background-color'),
                purple: $('.chartjs-colors .bg-purple').css('background-color'),
                pink: $('.chartjs-colors .bg-pink').css('background-color'),
                primaryLight: $('.chartjs-colors .bg-primary-light').css('background-color'),
                successLight: $('.chartjs-colors .bg-success-light').css('background-color'),
            };

            basic_bar_chart();

            function basic_bar_chart() {
                var element = document.getElementById("basic_bar_chart");
                element.height = 100;

                $.ajax({
                    type: "POST",
                    url: "{{ route('ver_carreras_unidades') }}",
                    dataType: "JSON",
                    success: function(res) {
                        // console.log(res);
                        // console.log(res.tipo_carrera);

                        var array_nombre = [];
                        var array_cantidad = [];
                        res.tipo_carrera.forEach(val => {
                            array_nombre.push(val.nombre);
                            array_cantidad.push(val.carrera_unidad_area_count);
                        });
                        new Chart(element, {
                            type: 'bar',
                            data: {
                                labels: array_nombre,
                                datasets: [{
                                    label: "Cantidad",
                                    backgroundColor: [
                                        colors.primary,
                                        colors.secondary,
                                        colors.success,
                                        colors.warning,
                                        colors.info,
                                        colors.purple,
                                    ],
                                    data: array_cantidad
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Predicted world population (millions) in 2050'
                                }
                            }
                        });
                    }
                });
            }

            basic_bar_chart1();

            function basic_bar_chart1() {
                var element = document.getElementById("basic_bar_chart1");
                element.height = 100;

                $.ajax({
                    type: "POST",
                    url: "{{ route('ver_formularios_can') }}",
                    dataType: "JSON",
                    success: function(res) {
                        // console.log(res);

                        new Chart(element, {
                            type: 'bar',
                            data: {
                                labels: [
                                    'FORMULARIO Nº 1',
                                    'FORMULARIO Nº 2',
                                    'FORMULARIO Nº 4',
                                    'FORMULARIO Nº 5'
                                ],
                                datasets: [{
                                    label: "FORMULARIOS",
                                    backgroundColor: [
                                        colors.warning,
                                        colors.primary,
                                        colors.danger,
                                        colors.success,
                                        colors.info,
                                        colors.pink,
                                        colors.purple,
                                        colors.secondary,
                                    ],
                                    data: [
                                        res.formulario1,
                                        res.formulario2,
                                        res.formulario4,
                                        res.formulario5
                                    ]
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Predicted world population (millions) in 2050'
                                }
                            }
                        });
                    }
                });
            }
        });
    </script>

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
@endsection
