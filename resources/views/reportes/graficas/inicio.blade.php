@extends('principal')
@section('titulo', 'Formulacion del poa')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
    <link rel="stylesheet" href="{{ asset('rodry/formulario.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        /* Aplicar estilos de Bootstrap a Select2 */
        .select2_simple1 {
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
        }

        .custom-btn {
            width: 130px;
            height: 40px;
            color: #fff;
            border-radius: 5px;
            padding: 10px 25px;
            font-family: 'Lato', sans-serif;
            font-weight: 500;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            box-shadow: inset 2px 2px 2px 0px rgba(255, 255, 255, .5),
                7px 7px 20px 0px rgba(0, 0, 0, .1),
                4px 4px 5px 0px rgba(0, 0, 0, .1);
            outline: none;
        }

        /* 10 */
        .btn-10 {
            background: rgb(22, 9, 240);
            background: linear-gradient(0deg, rgba(22, 9, 240, 1) 0%, rgba(49, 110, 244, 1) 100%);
            color: #fff;
            border: none;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .btn-10:after {
            position: absolute;
            content: " ";
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            transition: all 0.3s ease;
            -webkit-transform: scale(.1);
            transform: scale(.1);
        }

        .btn-10:hover {
            color: #007a83;
            border: none;
            background: transparent;
        }

        .btn-10:hover:after {
            background: rgb(0, 3, 255);
            background: linear-gradient(0deg, rgba(2, 126, 251, 1) 0%, rgba(0, 3, 255, 1)100%);
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .filtrar-opcion {
            display: none;
        }

        .opciones {
            display: none;
        }
    </style>
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>REPORTES PDF DE GASTOS Y SALDOS (POA)</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid ">
            <div class="card-box-style ">
                <center>
                    <h4>Seleccione opciones de filtrado</h4>
                </center>
                <div class="others-title d-flex align-items-center"></div>

                <form action="{{ route('pdf.generar') }}" method="POST" autocomplete="off" target="_blank">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Generar por</legend>
                                <select name="filtrar" id="filtrar" class="form-select select2_simple1"
                                    style="width: 100%" onchange="selectOpcion(this)">
                                    <option value="" selected>[SELECCIONE UNA OPCION]</option>
                                    <option value="2">Por gestion especifica</option>
                                    <option value="1">Por gestion</option>
                                    <option value="3">Gastos por periodo</option>
                                    <option value="4">Gastos por rango de fechas</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 opciones" id="opcion1">
                            <fieldset>
                                <legend>Por gestion</legend>
                                <select name="gestion" id="gestion" class="form-select select2_simple1 opcion"
                                    style="width: 100%">
                                    <option value="" selected>[SELECCIONE UNA GESTIÓN]</option>
                                    @foreach ($gestion as $lis)
                                        <option value="{{ $lis->id }}">
                                            {{ $lis->inicio_gestion }} - {{ $lis->fin_gestion }}
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 opciones" id="opcion2">
                            <fieldset>
                                <legend>Por gestión especifica</legend>
                                <select name="gestion_esp" id="gestion_esp" class="form-select select2_simple1 opcion"
                                    style="width: 100%">
                                    <option value="" selected>[SELECCIONE UNA GESTIÓN ESPECIFICA]
                                    </option>
                                    @foreach ($gestiones as $lis)
                                        <option value="{{ $lis->id }}">
                                            {{ $lis->gestion }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 opciones" id="opcion3">
                            <fieldset>
                                <legend>Por periodo</legend>
                                <select name="periodos" id="periodos" class="form-select select2_simple1 opcion"
                                    style="width: 100%">
                                    <option value="" selected>[SELECCIONE UN PERIODO]
                                    </option>
                                    <option value="1">Ultimos 7 dias</option>
                                    <option value="2">Ultimos 30 dias</option>
                                    <option value="3">Ultimos 3 meses</option>
                                    <option value="4">Ultimos 6 meses</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 opciones" id="opcion4">
                            <fieldset>
                                <legend>Por rango de fechas</legend>
                                <input class="form-control opcion" type="text" id="rango" name="rango"
                                    value="{{ now()->subMonth()->format('d-m-Y') }} - {{ date('d-m-Y') }}" />
                            </fieldset>
                        </div>

                        <div class="mb-5 col-12 d-flex justify-content-center">
                            <button class="btn btn-secondary" type="button" id="btn-reset"
                                onclick="resetFormu()">Reset</button>
                        </div>

                        <div class="filtrar-opcion">
                            <div class="d-flex justify-content-center">
                                <h4>Filtrar por: </h4>&nbsp;<span class="text-muted">(Opcionales)</span>
                            </div>
                        </div>

                        <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 filtrar-opcion">
                            <fieldset>
                                <legend>Por carrera/unidad/area</legend>
                                <select name="cua" id="cua" class="form-select select2_simple1"
                                    style="width: 100%">
                                    <option value="0" selected>TODAS</option>
                                    @foreach ($cua as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->nombre_completo }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="mt-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 filtrar-opcion">
                            <fieldset>
                                <legend>Por Fuente de financiamiento</legend>
                                <select name="fuente_fin" id="fuente_fin" class="form-select select2_simple1"
                                    style="width: 100%">
                                    <option value="0" selected>TODAS</option>
                                    @foreach ($fuente as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->descripcion }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-12 col-sm-3"></div>
                        <div class="mb-3 col-12 col-sm-6 filtrar-opcion">
                            <fieldset>
                                <legend>Opciones extra (puede tardar en generar el PDF)</legend>
                                <div class="d-flex flex-column justify-content-center">
                                    <div class="ms-5 form-check form-switch">
                                        <label class="form-check-label" for="partidas">
                                            Mostrar datos por partidas
                                        </label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="partidas"
                                            name="partidas" checked>
                                    </div>
                                    <div class="ms-5 form-check form-switch">
                                        <label class="form-check-label" for="graficos">
                                            Mostrar graficos
                                        </label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="graficos"
                                            name="graficos">
                                    </div>

                                    {{-- <div class="ms-5 form-check form-switch">
                                        <label class="form-check-label" for="fut">
                                            Mostrar gastos FUT
                                        </label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="fut"
                                            name="fut">
                                    </div>

                                    <div class="ms-5 form-check form-switch">
                                        <label class="form-check-label" for="mot">
                                            Mostrar modificaciones MOT
                                        </label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="mot"
                                            name="mot">
                                    </div> --}}
                                </div>
                            </fieldset>
                        </div>

                        <div class="filtrar-opcion">
                            <div class="col-12 d-flex justify-content-center">
                                <button class="btn btn-danger btn-lg" type="submit" id="btn-reset">
                                    <i class="ri-file-pdf-line"></i> Generar PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2_simple1').select2({
                theme: "bootstrap-5",
                containerCssClass: "select2--small",
                dropdownCssClass: "select2--small",
            });

            $(function() {
                $('input[name="rango"]').daterangepicker({
                    opens: 'left',
                    "autoApply": true,
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') +
                        ' to ' + end.format('YYYY-MM-DD'));
                });
            });

            $(document).on('change', '.opcion', function() {
                mostrarOpciones()
            })
        });

        function selectOpcion(sel) {
            const opcion = $(sel).val()

            $('.opciones').css('display', 'none')
            $('.opcion').val('')
            $('#opcion' + opcion).css('display', 'block')

            resetFormu()
            mostrarOpciones()
        }

        function mostrarOpciones() {
            const gestion = $('#gestion').val()
            const gestion_esp = $('#gestion_esp').val()
            const periodos = $('#periodos').val()
            const rango = $('#rango').val()

            if (gestion != '' || gestion_esp != '' || periodos != '' || rango != '') {
                $('.filtrar-opcion').css('display', 'block')
                $('#btn-reset').removeAttr('disabled')
            } else {
                $('.filtrar-opcion').css('display', 'none')
                $('#btn-reset').attr('disabled', 'disabled')
            }
        }

        function resetFormu() {
            // $('#filtrar').val('').trigger('change')

            $('#gestion').val('').trigger('change')
            $('#gestion_esp').val('').trigger('change')
            $('#periodos').val('').trigger('change')
            $('#rango').val('').trigger('change')

            $('#fuente_fin').val('0').trigger('change')
            $('#cua').val('0').trigger('change')
        }
    </script>
@endsection
