@extends('principal')
@section('titulo', 'Asinar Financiamiento')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>ASIGNAR FINANCIAMIENTO</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Configuración</li>
                        <li>Asignar financiamiento</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style text-center">
                <div class="row text-center d-flex justify-content-center">
                    {{-- <div class="mb-3 col-6">
                        <label for="sigla" class="form-label">Seleccine una gestión</label>
                        <select name="gestion" id="gestion" class="form-select" onchange="listar_gestionesEspecificas(this.value)">
                            <option value="selected" selected disabled >[SELECCIONE UNA GESTIÓN]</option>
                            @foreach ($gestion as $lis)
                                <option value="{{ $lis->id }}">{{ $lis->inicio_gestion.' - '.$lis->fin_gestion }}</option>
                            @endforeach
                        </select>
                        <div id="_gestion"></div>
                    </div> --}}
                    <div class="mb-3 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <fieldset>
                            <legend>Seleccoine una gestión especifica</legend>
                            <select name="gestion_especifica" id="gestion_especifica" class="form-select"
                                onchange="listarTipoCarreraUnidadArea(this.value)">
                                <option value="selected" selected disabled>[SELECCIONE UNA GESTIÓN ESPECÍFICA]</option>
                                @foreach ($gestiones as $lis)
                                    <option value="{{ $lis->id }}">{{ $lis->gestion }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="_gestion_especifica"></div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12" id="mostrar_tipoCarreraUnidad">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        //para listar las gestiones especificas
        function listar_gestionesEspecificas(id) {
            document.getElementById('mostrar_tipoCarreraUnidad').innerHTML = '';
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listarGestiones') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#gestion_especifica').empty().append(
                        '<option value="selected" selected disabled >[SELECCIONE UNA GESTIÓN ESPECÍFICA]</option>'
                    );
                    if (data.tipo === 'success') {
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#gestion_especifica').append('<option value = "' + value.id + '">' +
                                value.gestion + '</option>');
                        });
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }

        //para listar el tipo de carrea y tambien
        function listarTipoCarreraUnidadArea(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listar_CarreraUnidad') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    document.getElementById('mostrar_tipoCarreraUnidad').innerHTML = data;
                }
            });
        }
    </script>
@endsection
