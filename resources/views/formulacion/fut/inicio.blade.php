@extends('principal')
@section('titulo', 'FUT')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12 col-sm-12">
                    <div class="page-title">
                        <h5>FORMULARIO UNICO DE TRAMITE (FUT)</h5>
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
                    {{-- <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                        <fieldset>
                            <legend>Seleccione una gestión</legend>
                            <select name="id_gestion" id="id_gestion" class="form-select" onchange="selectGestiones(this)">
                                <option value="selected" selected disabled>[SELECCIONE UNA GESTION]</option>
                                @foreach ($gestion as $ges)
                                    <option value="{{ $ges->id }}">
                                        {{ $ges->inicio_gestion . ' - ' . $ges->fin_gestion }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="_gestion"></div>
                        </fieldset>
                    </div> --}}
                    <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                        <fieldset>
                            <legend>Seleccione una gestión especifica</legend>
                            <select name="gestion" id="gestion" class="form-select" onchange="selectGestion(this)">
                                <option value="selected" selected disabled>[SELECCIONE UNA GESTION ESPECIFICA]</option>
                                @foreach ($gestiones as $ges)
                                    <option value="{{ $ges->id }}">
                                        {{ $ges->gestion }}
                                    </option>
                                @endforeach
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
        // $(document).ready(function() {
        function selectGestiones(id_gestion) {
            let gestion = id_gestion.value;
            $.ajax({
                url: "{{ route('obtenerGestionesFut') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_gestion: gestion
                },
                success: function(response) {
                    $('#gestion').empty();
                    $('#gestion').append('<option value="">[SELECCIONE UNA GESTION ESPECIFICA]</option>');

                    response.forEach(element => {
                        $('#gestion').append('<option value="' + element.id + '">' + element.gestion +
                            '</option>');
                    });
                },
                error: function(error) {
                    toastr[data.tipo](data.mensaje);
                    console.log(error)
                }
            });
        }

        function selectGestion(gestion) {
            let id_gestion = gestion.value;
            $.ajax({
                url: "{{ route('getFormulados') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_gestion: id_gestion,
                    id_unidad_carrera: '{{ Auth::user()->id_unidad_carrera }}'
                },
                success: function(response) {
                    $('#ListadoGestionesFormulados').empty();

                    let $box = $('<div class="ag-courses_box"></div>');

                    if (response.length > 0) {
                        response.forEach(function(element) {
                            let $item = $(`
                                <div class="ag-courses_item">
                                    <a href="{{ route('fut.listar', ['id_conformulado' => 'ELEMENT_ID']) }}" class="ag-courses-item_link">
                                        <div class="ag-courses-item_bg"></div>
                                        <div class="ag-courses-item_title text-center">
                                            ${element.descripcion}
                                            <p>Fecha inicio : ${fecha_literal(element.fecha_inicial, 4)}</p>
                                            <p>Fecha fin : ${fecha_literal(element.fecha_final, 4)}</p>
                                        </div>
                                    </a>
                                </div>
                            `);

                            $item.find('a').attr('href', function() {
                                return this.href.replace('ELEMENT_ID', element.id);
                            });

                            $box.append($item);
                        });
                    } else {
                        let ges = gestion.options[gestion.selectedIndex].text;
                        $box.append(
                            `<div class="alert alert-warning"><b>Nota: </b>A la gestión <b>${ges}</b> no se le asignó ningún tipo de formulado.</div>`
                        );
                    }

                    $('#ListadoGestionesFormulados').append($box);
                },

                error: function(error) {
                    console.log(error)
                }
            });

        }
        // })
    </script>
@endsection
