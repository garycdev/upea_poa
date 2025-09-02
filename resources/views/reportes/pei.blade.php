@extends('principal')
@section('titulo', 'Formulacion del poa')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
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
            box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
            7px 7px 20px 0px rgba(0,0,0,.1),
            4px 4px 5px 0px rgba(0,0,0,.1);
            outline: none;
        }
        /* 10 */
        .btn-10 {
            background: rgb(22,9,240);
            background: linear-gradient(0deg, rgba(22,9,240,1) 0%, rgba(49,110,244,1) 100%);
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
            background: rgb(0,3,255);
            background: linear-gradient(0deg, rgba(2,126,251,1) 0%,  rgba(0,3,255,1)100%);
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
                        <h5>REPORTES PDF DEL PLAN ESTRATÉGICO INSTITUCIONAL (PEI)</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid ">

            <div class="card-box-style ">

                <h3>MATRIZ DE PLANIFICACIÓN</h3>
                <div class="others-title d-flex align-items-center">
                </div>

                <form action="{{ route('matriz_pdf') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <fieldset>
                                <legend>Gestión</legend>
                                    <select name="gestion" id="gestion" class="form-select" onchange="listar_areasEstrategicas(this.value)" value="{{ old('gestion') }}">
                                        <option value="" selected disabled >[SELECCIONE UNA GESTION]</option>
                                        @foreach ($gestion as $lis)
                                            <option value="{{ $lis->id }}" {{ old('gestion') == $lis->id ? 'selected' : '' }}>{{ $lis->inicio_gestion.' - '.$lis->fin_gestion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_gestion">
                                        @error('gestion')
                                            <p id="error_in" >{{ $message }}</p>
                                        @enderror
                                    </div>
                            </fieldset>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <fieldset>
                                <legend>Áreas Estratégicas</legend>
                                    <select name="area_estrategica" id="area_estrategica" class="form-select select2_simple1" value="{{ old('area_estrategica') }}" style="width: 100%">
                                        <option value="" selected disabled >[SELECCIONE UNA AREA ESTRATÉGICA]</option>
                                    </select>
                                    <div id="_area_estrategica">
                                        @error('area_estrategica')
                                            <p id="error_in" >{{ $message }}</p>
                                        @enderror
                                    </div>
                            </fieldset>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                            <div class="d-flex justify-content-center align-items-center py-4" >
                                <button type="submit" class="btn btn-primary" id="btn_guardarPDF" target="_blank">Generar PDF</button>
                            </div>
                        </div>
                    </div>
                </form>
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
        //para listar las areas estrategicas
        function listar_areasEstrategicas(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listar_areas_estrategicas') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#area_estrategica').empty().append(
                        '<option value="" selected disabled>[SELECCIONE UNA AREA ESTRATÉGICA]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje.relacion_areas_estrategicas;
                        if(datos.length === 0){
                            document.getElementById('_area_estrategica').innerHTML = `<p id="error_in" >No existe registros de áreas estratégicas</p>`;
                        }else{
                            document.getElementById('_area_estrategica').innerHTML = '';
                            datos.forEach(value => {
                                $('#area_estrategica').append('<option value = "' + value.id + '" {{ old("gestion") == $lis->id ? "selected" : '' }} >' +' [ '+value.codigo_areas_estrategicas+' ] '+value.descripcion + '</option>');
                            });
                        }
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
    </script>
@endsection
