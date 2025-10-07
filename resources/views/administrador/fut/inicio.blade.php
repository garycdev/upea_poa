@extends('principal')
@section('titulo', 'FUT')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12 col-sm-12">
                    <div class="page-title">
                        <h5>FORMULARIO UNICO DE TRAMITE (FUT)</h5>
                        @if (isset(Auth::user()->id_unidad_carrera))
                            <h5>{{ $carrera_unidad[0]->nombre_completo }}</h5>
                        @endif
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
                            {{-- <legend>Seleccione una Unidad / Carrera</legend>
                            <select name="id_unidad_carrera" id="id_unidad_carrera" class="select2_partida"
                                onchange="selectGestion()">
                                <option value="selected" selected disabled>[SELECCIONE UNA UNIDAD / CARRERA]</option>
                                @foreach ($unidades as $uni)
                                    <option value="{{ $uni->id }}">
                                        {{ $uni->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="id_unidad_carrera"></div> --}}
                            <legend>Ingrese el Nro FUT</legend>
                            <input type="text" id="nro" class="form-control" maxlength="4"
                                placeholder="Nro FUT, ej: 0001" inputmode="numeric" pattern="\d{4}">
                            <div id="_nro"></div>
                        </fieldset>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto">
                        <fieldset>
                            <legend>Seleccione una gestión especifica</legend>
                            <select name="gestion" id="gestion" class="form-select">
                                <option value="0" selected>[SELECCIONE UNA GESTION ESPECIFICA]</option>
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
                <div>
                    <table class="table dataTable" id="tablaFut">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Unidad / Carrrera</th>
                                <th>Gestion</th>
                                <th>Formulado</th>
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Ejecución</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let tabla = $('#tablaFut').DataTable();

            $(document).on('keyup change', '#nro, #gestion', function() {
                let id_gestion = $('#gestion').val();
                // let id_unidad_carrera = $('#id_unidad_carrera').val();
                let nro = $('#nro').val();

                $.ajax({
                    url: "{{ route('fut.buscar') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_gestion: id_gestion,
                        nro: nro
                    },
                    success: function(response) {
                        // console.log(response);
                        tabla.clear().draw();
                        const detalleUrlTemplate =
                            "{{ route('fut.detalle', ['id_fut' => ':ELEMENT_ID']) }}";
                        // const pdfUrlTemplate =
                        //     "{{ route('pdfFut', ['id_fut' => ':ELEMENT_ID']) }}"
                        const pdfSolicitudTemplate =
                            "{{ route('fut.pdf', ['id_fut' => ':ELEMENT_ID']) }}"
                        const carreraUrlTemplate =
                            "{{ route('fut.listar', ['id_conformulado' => ':CONFIG_ID', 'id_carrera' => ':CARRERA_ID']) }}"

                        let fut = response.data
                        fut.forEach(element => {
                            const urlDetalle = detalleUrlTemplate.replace(
                                ':ELEMENT_ID',
                                element.id_encriptado);
                            // const urlPdf = pdfUrlTemplate.replace(
                            //     ':ELEMENT_ID',
                            //     element.id_fut);
                            const urlPdfSolicitud = pdfSolicitudTemplate.replace(
                                ':ELEMENT_ID',
                                element.id_encriptado);
                            const urlCarrera = carreraUrlTemplate.replace(
                                    ':CONFIG_ID',
                                    element.id_config_encriptado)
                                .replace(
                                    ':CARRERA_ID',
                                    element.id_cua_encriptado)

                            tabla.row.add([
                                formatearConCeros(element.nro),
                                `<a href="${urlCarrera}" target="_blank">${element.carrera}</a>`,
                                element.gestion,
                                `<span class="badge bg-dark">${element.formulado}</span>`,
                                `${conSeparadorComas(element.importe)} bs.`,
                                `<span
                                    class="badge bg-${element.estado == 'aprobado' ? 'success' : (element.estado == 'rechazado' ? 'danger' : (element.estado == 'verificado' ? 'primary' : element.estado == 'elaborado' ? 'info' : 'warning'))} text-${element.estado == 'elaborado' ? 'dark' : 'light'}">
                                    ${element.estado}
                                </span>`,
                                `<button type="button" class="btn btn-outline-primary btn-validar" data-id="${element.id_fut}" style="display:${element.estado == 'elaborado' && response.rol == 'planifica' ? 'inline-block' : 'none'}">
                                    Formulario verificado
                                </button>
                                <button type="button" class="btn btn-outline-success btn-validar" data-id="${element.id_fut}" style="display:${element.estado == 'verificado' && response.rol == 'presupuesto' ? 'inline-block' : 'none'}">
                                    Aprobar compra
                                </button>`,
                                `<a href="${urlDetalle}" target="_blank" class="btn btn-outline-primary">
                                    <i class="ri-eye-fill"></i>
                                </a>
                                <a href="${urlPdfSolicitud}" class="btn btn-outline-danger" target="_blank">
                                    <i class="ri-file-pdf-line"></i>
                                </a>`
                            ]).draw(false);

                            // ACA PONE EL ID
                        });
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            })
        })
    </script>
@endsection
