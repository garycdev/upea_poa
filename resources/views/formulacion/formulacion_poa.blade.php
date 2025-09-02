@extends('principal')
@section('titulo', 'Formulacion del poa')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>FORMULACIÓN DEL PLAN OPERATIVO ANUAL</h5>
                        <h5>{{ $carrera_unidad[0]->nombre_completo }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style ">
                <div class="row text-center">
                    <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                        <fieldset>
                            <legend>Seleccione una gestión</legend>
                                <select name="gestion" id="gestion" class="form-select" onchange="listar_gestionesEsp(this.value)">
                                    <option value="selected" selected disabled >[SELECCIONE UNA GESTION]</option>
                                    @foreach ($gestion as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->inicio_gestion.' - '.$lis->fin_gestion }}</option>
                                    @endforeach
                                </select>
                                <div id="_gestion"></div>
                        </fieldset>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                        <fieldset>
                            <legend>Seleccione una gestión especifica</legend>
                                <select name="gestiones" id="gestiones" class="form-select" onchange="listar_gestionesAsignacionForm(this.value)">
                                    <option value="selected" selected disabled >[SELECCIONE UNA GESTION ESPECIFICA]</option>
                                </select>
                                <div id="_gestiones"></div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12" id="ListadoGestionesFormulados">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

        function listar_gestionesEsp(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listarGestiones') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    document.getElementById('ListadoGestionesFormulados').innerHTML = '';
                    $('#gestiones').empty().append(
                        '<option value="selected" selected disabled >[SELECCIONE UNA GESTION ESPECÍFICA]</option>'
                    );

                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#gestiones').append('<option value = "' + value.id + '">' + value.gestion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }
        //para
        function listar_gestionesAsignacionForm(id){
            $.ajax({
                type: "POST",
                url: "{{ route('poa_listarGestionesSP') }}",
                data: {id:id},
                success: function (data) {
                    document.getElementById('ListadoGestionesFormulados').innerHTML = data;
                }
            });
        }
    </script>
@endsection
