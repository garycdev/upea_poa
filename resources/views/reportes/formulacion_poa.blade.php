@extends('principal')
@section('titulo', 'Formulacion del poa')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
    <link rel="stylesheet" href="{{ asset('rodry/formulario.css') }}">
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
    </style>
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>REPORTES PDF DEL PLAN OPERATIVO ANUAL (POA)</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid ">

            <div class="card-box-style ">

                <h3>POR CARRERA, UNIDADES ADMINISTRATIVAS O AREAS</h3>
                <div class="others-title d-flex align-items-center">
                </div>

                <form action="{{ route('matriz_pdf') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        {{-- <div class="mb-3 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                            <fieldset>
                                <legend class="text-center">Gestión</legend>
                                <select name="gestion" id="gestion" class="form-select"
                                    onchange="listar_gestiones_especificas(this.value)" value="{{ old('gestion') }}">
                                    <option value="selected" selected disabled>[SELECCIONE UNA GESTION]</option>
                                    @foreach ($gestion as $lis)
                                        <option value="{{ $lis->id }}">
                                            {{ $lis->inicio_gestion . ' - ' . $lis->fin_gestion }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div> --}}
                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Gestión especifica</legend>
                                <select name="gestion_esp" id="gestion_esp" class="form-select select2_simple1"
                                    onchange="listar_configuracion_formulado(this.value)" style="width: 100%">
                                    <option selected disabled>[SELECCIONE UNA GESTIÓN ESPECIFICA]</option>
                                    @foreach ($gestiones as $lis)
                                        <option value="{{ $lis->id }}">
                                            {{ $lis->gestion }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        {{-- aqui tomamos lo que es el id de configuracion formulado --}}
                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Tipo de Formulado</legend>
                                <select name="tipo_formulado" id="tipo_formulado" class="form-select select2_simple1"
                                    style="width: 100%">
                                    <option value="selected" selected disabled>[SELECCIONE EL TIPO DE FORMULADO]</option>

                                </select>
                            </fieldset>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Tipo</legend>
                                <select name="tipo" id="tipo" class="form-select select2_simple1"
                                    onchange="seleccionar_tipo(this.value)" style="width: 100%">
                                    <option value="selected" selected disabled>[SELECCIONE EL TIPO]</option>
                                    @foreach ($tipo as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->nombre }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend id="legend_leer" style="font-size: 14px">Tipo : </legend>
                                <select name="carrera_unidad" id="carrera_unidad" class="form-select select2_simple1"
                                    onchange="validar_formularios(this.value)" style="width: 100%">
                                    <option selected disabled>[SELECCIONE]</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </form>

                <div id="html_vista_direccionar">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2_simple1').select2({
                theme: "bootstrap-5",
                containerCssClass: "select2--small",
                dropdownCssClass: "select2--small",
            });
        });
        //para listar gestiones especificas
        function listar_gestiones_especificas(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listarGestiones') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('#gestion_esp').empty().append(
                        '<option value="selected"  selected disabled>[SELECCIONE UNA GESTIÓN ESPECIFICA]</option>'
                    );
                    $('#tipo_formulado').empty().append(
                        '<option value="selected"  selected disabled>[SELECCIONE EL TIPO DE FORMULADO]</option>'
                    );
                    document.getElementById('legend_leer').innerHTML = ' Tipo : ';
                    $('#carrera_unidad').empty().append(
                        '<option selected disabled>[SELECCIONE]</option>'
                    );
                    if (data.tipo == 'success') {
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#gestion_esp').append('<option value = "' + value.id + '">' + value
                                .gestion + '</option>');
                        });
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para listar la parte del formulado
        function listar_configuracion_formulado(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('pdf_tipo_formulados_listar') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#tipo_formulado').empty().append(
                        '<option value="selected"  selected disabled>[SELECCIONE EL TIPO DE FORMULADO]</option>'
                    );
                    document.getElementById('legend_leer').innerHTML = ' Tipo : ';
                    $('#carrera_unidad').empty().append(
                        '<option selected disabled>[SELECCIONE]</option>'
                    );
                    if (data.tipo === 'success') {
                        let datos = data.mensaje.configuracion_formulado;
                        datos.forEach(value => {
                            $('#tipo_formulado').append('<option value = "' + value.id + '">' + value
                                .formulado_tipo.descripcion + '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para seleccionar el tipo de carrera
        function seleccionar_tipo(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('pdf_listar_carreraunidad') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        document.getElementById('legend_leer').innerHTML = ' Tipo : ' + data.mensaje.nombre;
                        $('#carrera_unidad').empty().append(
                            '<option selected disabled>[SELECCIONE ' + data.mensaje.nombre + ']</option>'
                        );
                        let datos = data.mensaje.carrera_unidad_area;
                        datos.forEach(value => {
                            $('#carrera_unidad').append('<option value = "' + value.id + '">' + value
                                .nombre_completo + '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para validar los formularios
        function validar_formularios(id) {
            let id_config = document.getElementById('tipo_formulado').value;
            let gestion_especifica = document.getElementById('gestion_esp').value;
            if (id_config !== 'selected') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('pdf_carrera_unidadaarea_formulario') }}",
                    data: {
                        id_carrera: id,
                        id_config: id_config,
                        gestion_especifica: gestion_especifica,
                    },
                    success: function(data) {
                        document.getElementById('html_vista_direccionar').innerHTML = data;
                    }
                });
            } else {
                alerta_top('error', 'Porfavor seleccione el tipo de formulado');
            }

        }
    </script>
@endsection
