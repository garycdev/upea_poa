@extends('principal')
@section('titulo', 'Inicio')
@section('contenido')

    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h3>INICIO</h3>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Admin</li>
                        <li>inicio</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="overview-content-area">
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
    </div>


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


@endsection

@section('scripts')
    <script src="{{ asset('plantilla_admin/js/chart-js/chartjs.min.js') }}"></script>
    {{-- <script src="{{ asset('plantilla_admin/js/chart-js/chartjs-custom.js') }}"></script> --}}

    <script>
        'use strict';
        $(document).ready(function () {
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
                    success: function (res) {
                        console.log(res);
                        console.log(res.tipo_carrera);
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
                                datasets: [
                                    {
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
                                    }
                                ]
                            },
                            options: {
                                legend: { display: false },
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
                    success: function (res) {
                        console.log(res);
                        new Chart(element, {
                            type: 'bar',
                            data: {
                                labels: ['FORMULARIO Nº 1', 'FORMULARIO Nº 2', 'FORMULARIO Nº 4', 'FORMULARIO Nº 5'],
                                datasets: [
                                    {
                                        label: "fORMULARIOS",
                                        backgroundColor: [
                                            colors.primary,
                                            colors.secondary,
                                            colors.success,
                                            colors.warning,
                                            colors.info,
                                            colors.purple,
                                            colors.pink,
                                        ],
                                        data: [res.formulario1,res.formulario2,res.formulario4, res.formulario5]
                                    }
                                ]
                            },
                            options: {
                                legend: { display: false },
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
