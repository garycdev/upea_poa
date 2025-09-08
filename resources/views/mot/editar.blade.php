@extends('principal')
@section('titulo', 'Formulario MOT')
@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1 class="page-title my-auto">Formulario de modificacion</h1>
                    <div>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Inicio</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">MOT</li>
                        </ol>
                    </div>
                </div>

                {{-- <form class="row" id="formularioMot"> --}}
                <form class="row" method="POST" action="{{ route('postModificacion', $mot->id_mot) }}"
                    id="formularioMot">
                    @csrf
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="col-10 text-center fw-bold mt-3">
                                FORMULARIO DE MODIFICACION POA - PRESUPUESTO<br>
                                DE OBJETIVOS Y/O TAREAS (ACTIVIDADES-OPERACIONES) - MOT
                            </h5>
                            <div class="col-2 form-group d-flex align-items-center justify-content-center">
                                <label for="nro_mot" class="form-label mt-3">
                                    <h5>MOT&nbsp;N°:&nbsp;</h5>
                                </label>
                                <input type="number" class="form-control" id="nro_mot"
                                    value="{{ $nro_mot ? $nro_mot->nro + 1 : 1 }}" name="nro_mot" required>
                            </div>
                        </div>
                        <input type="text" name="id_formulado" id="id_formulado" value="{{ $id_formulado }}">
                        <input type="text" name="gestiones_id" id="gestiones_id" value="{{ $gestiones_id }}">
                        <input type="text" name="id_conformulado" id="id_conformulado" value="{{ $id_conformulado }}">
                    </div>
                    {{-- @dd($areas_formulado) --}}
                    <div class="card">
                        <div class="card-body">
                            <div id="modificaciones">
                                <div class="modificacion row mb-3">
                                    <div class="col-2">
                                        <p>Area estrategica (F-1): </p>
                                    </div>
                                    <div class="col-1">
                                        <p class="bg-danger p-2 text-center" style="color:#fff;">MODIFICA</p>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="area1" readonly>
                                    </div>
                                    <div class="col-4">
                                        <select name="area_estrategica_de" id="select-area1" class="form-control"
                                            onchange="cambiarAreaEstrategica(this)" required>
                                            <option value="0">[SELECCIONE AREA ESTRATEGICA]</option>
                                            @foreach ($areas_formulado as $ae)
                                                <option value="{{ $ae->codigo_areas_estrategicas }}"
                                                    data-value="{{ $ae->formulario1_id }}">
                                                    [{{ $ae->codigo_areas_estrategicas }}]
                                                    {{ strtoupper($ae->descripcion) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">IMPORTE:&nbsp; </label>
                                        {{-- <input type="text" class="form-control"> --}}
                                        <input type="number" placeholder="0.00" class="form-control montos-input"
                                            onkeyup="montoNumber(this)" step="0.01" min="0.00" name="ae_de_importe"
                                            id="ae_de_importe" required>

                                    </div>
                                    {{-- <div class="col-1 d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-sm btn-danger">Quitar</button>
                                    </div> --}}
                                </div>
                                <div class="modificacion row mb-3">
                                    <div class="col-2">
                                        <p>Area estrategica (F-1): </p>
                                    </div>
                                    <div class="col-1">
                                        <p class="bg-danger p-2 text-center" style="color:#fff;">INCREMENTA</p>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="area2" readonly>
                                    </div>
                                    <div class="col-4">
                                        <select name="area_estrategica_a" id="select-area2" class="form-control"
                                            onchange="cambiarAreaEstrategica2(this)" required>
                                            <option value="0">[SELECCIONE AREA ESTRATEGICA]</option>
                                            @foreach ($areas_formulado as $ae)
                                                <option value="{{ $ae->codigo_areas_estrategicas }}"
                                                    data-value="{{ $ae->formulario1_id }}">
                                                    [{{ $ae->codigo_areas_estrategicas }}]
                                                    {{ strtoupper($ae->descripcion) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">IMPORTE:&nbsp; </label>
                                        <input type="number" step="0.01" min="0.00" placeholder="0.00"
                                            class="form-control montos-input" onkeyup="montoNumber(this)"
                                            name="ae_a_importe" id="ae_a_importe" required>
                                    </div>
                                </div>
                                <div class="modificacion row mb-3">
                                    <div class="col-2">
                                        <p>Objetivo de Gestión (F-2): </p>
                                    </div>
                                    <div class="col-1">
                                        <p class="bg-danger p-2 text-center" style="color:#fff;">MODIFICA</p>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="objetivo1" readonly>
                                    </div>
                                    <div class="col-4">
                                        <select name="objetivo_gestion_de" id="select-objetivoGestion"
                                            class="form-control" onchange="cambiarObjetivoGestion(this)" required>
                                            <option value="0">[SELECCIONE OBJETIVO DE GESTION]</option>
                                        </select>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">IMPORTE:&nbsp; </label>
                                        <input type="number" step="0.01" min="0.00" placeholder="0.00"
                                            class="form-control montos-input" onkeyup="montoNumber(this)"
                                            name="og_de_importe" id="og_de_importe" required>
                                    </div>
                                </div>
                                <div class="modificacion row mb-3">
                                    <div class="col-2">
                                        <p>Objetivo de Gestión (F-2): </p>
                                    </div>
                                    <div class="col-1">
                                        <p class="bg-danger p-2 text-center" style="color:#fff;">INCREMENTA</p>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="objetivo2" readonly>
                                    </div>
                                    <div class="col-4">
                                        <select name="objetivo_gestion_a" id="select-objetivoGestion2"
                                            class="form-control" onchange="cambiarObjetivoGestion2(this)" required>
                                            <option value="0">[SELECCIONE OBJETIVO DE GESTION]</option>
                                        </select>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">IMPORTE:&nbsp; </label>
                                        <input type="number" step="0.01" min="0.00" placeholder="0.00"
                                            class="form-control montos-input" onkeyup="montoNumber(this)"
                                            name="og_a_importe" id="og_a_importe" required>
                                    </div>
                                </div>
                                <div class="modificacion row mb-3">
                                    <div class="col-2">
                                        <p>Tarea o Proyecto (F-3; F3A): </p>
                                    </div>
                                    <div class="col-1">
                                        <p class="bg-danger p-2 text-center" style="color:#fff;">MODIFICA</p>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="tarea1">
                                    </div>
                                    <div class="col-4">
                                        <select name="tarea_proyecto_de" id="select-tareaProyecto" class="form-control"
                                            required onchange="cambiarTareaProyecto(this)">
                                            <option value="0">[SELECCIONE TAREA O PROYECTO]</option>
                                        </select>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">IMPORTE:&nbsp; </label>
                                        <input type="number" step="0.01" min="0.00" placeholder="0.00"
                                            class="form-control montos-input" onkeyup="montoNumber(this)"
                                            name="tp_de_importe" id="tp_de_importe" required>
                                    </div>
                                </div>
                                <div class="modificacion row mb-3">
                                    <div class="col-2">
                                        <p>Tarea o Proyecto (F-3; F-3A): </p>
                                    </div>
                                    <div class="col-1">
                                        <p class="bg-danger p-2 text-center" style="color:#fff;">INCREMENTA</p>
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="tarea2">
                                    </div>
                                    <div class="col-4">
                                        <select name="tarea_proyecto_a" id="select-tareaProyecto2" class="form-control"
                                            required onchange="cambiarTareaProyecto2(this)">
                                            <option value="0">[SELECCIONE TAREA O PROYECTO]</option>
                                        </select>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">IMPORTE:&nbsp; </label>
                                        <input type="number" step="0.01" min="0.00" placeholder="0.00"
                                            class="form-control montos-input" onkeyup="montoNumber(this)"
                                            name="tp_a_importe" id="tp_a_importe" required>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-outline-primary" onclick="agregarFila()">Agregar</button>
                            </div> --}}
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div id="de-a">
                                <div class="item">
                                    <div class="form-group row">
                                        <div class="col-3 d-flex align-items-center">
                                            Fuente de financiamiento :
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control w-50">
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control w-50">
                                        </div>
                                    </div>
                                    <div id="financiamientos"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row d-flex align-items-center justify-content-center">
                                <div class="col-2 d-flex align-items-center">
                                    Respaldo de tramite :
                                </div>
                                {{-- <div class="col-2">
                                    HOJA DE TRAMITE
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control border-info"
                                        placeholder="RECTORADO 0001/{{ substr($fecha_actual, 0, 4) }}"
                                        oninput="this.value = this.value.toUpperCase()" name="respaldo_tramite_1">
                                </div>
                                <div class="col-2">
                                    Y NOTA INTERNA
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control border-info"
                                        placeholder="UPEA-CS-CITE-INT-Nª001/{{ substr($fecha_actual, 0, 4) }}"
                                        oninput="this.value = this.value.toUpperCase()" name="respaldo_tramite_2">
                                </div> --}}
                                <div class="col-10">
                                    <input type="text" class="form-control border-info"
                                        placeholder="HOJA DE TRAMITE RECTORADO N° 0001/{{ substr($fecha_actual, 0, 4) }} Y NOTA INTERNA CITE: UPEA-CS Nª0001/{{ substr($fecha_actual, 0, 4) }}"
                                        oninput="this.value = this.value.toUpperCase()" name="respaldo_tramite" required>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-2 d-flex align-items-center">
                                    Fecha de inicio de tramite :
                                </div>
                                <div class="col-5">
                                    <input type="date" class="form-control border-info" value="{{ $fecha_actual }}"
                                        name="fecha_actual" required>
                                </div>
                                <div class="col-5">
                                    <input type="time" class="form-control border-info" value="{{ $hora_actual }}"
                                        name="hora_actual" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <a href="{{ route('listarFormulariosFut', $id_conformulado) }}"
                                    class="btn btn-dark me-3">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                                {{-- <button type="button" class="btn btn-success" onclick="validarFormulario()">Guardar</button> --}}
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
        let fuenteFin = {}

        function cambiarAreaEstrategica(select) {
            if (select.value == 0) {
                $('#area1').val('')
                $('#select-objetivoGestion').empty()
                $('#select-objetivoGestion').append(
                    '<option value="0">[SELECCIONE OBJETIVO DE GESTION]</option>')
                $('#objetivo1').val('')
                $('#select-tareaProyecto').empty()
                $('#select-tareaProyecto').append(
                    '<option value="0">[SELECCIONE TAREA O PROYECTO]</option>')
                $('#tarea1').val('')

                $('#ae_de_importe').val(parseFloat(0.00).toFixed(2))
                $('#ae_a_importe').val(parseFloat(0.00).toFixed(2))
                $('#og_de_importe').val(parseFloat(0.00).toFixed(2))
                $('#og_a_importe').val(parseFloat(0.00).toFixed(2))
                $('#tp_de_importe').val(parseFloat(0.00).toFixed(2))
                $('#tp_a_importe').val(parseFloat(0.00).toFixed(2))
                $('#ae_de_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#ae_a_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#og_de_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#og_a_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#tp_de_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#tp_a_importe').attr('max', parseFloat(0.00).toFixed(2))
            } else {
                $('#area1').val(select.value)
                const formulario1 = $('#select-area1 option:selected').attr('data-value')

                $.ajax({
                    url: "{{ route('getObjetivoInstitucional') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_area: $('#area1').val(),
                        formulario1: formulario1,
                        gestiones_id: $('#gestiones_id').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#select-objetivoGestion').empty()
                        $('#select-objetivoGestion').append(
                            '<option value="0">[SELECCIONE OBJETIVO DE GESTION]</option>')

                        response.forEach(element => {
                            $('#select-objetivoGestion').append(
                                `<option value="${element.codigo}" data-value="${element.f2_id}" data-value-id="${element.id}">[${element.codigo}] ${element.descripcion}</option>`
                            )
                        })

                        // let montoAEdisp = 0
                        // let montoAE = 0
                        // let finan = 0; // Variable para agrupar las fuentes de financiamiento por su id
                        // $('#financiamientos').empty();
                        // response[1].forEach(element => {
                        //     if (finan == 0) {
                        //         $('#financiamientos').append(`<div class="form-group mt-3" id="financiamiento_${element.id_financiamiento}">
                    //                 <div class="row">
                    //                     <div class="col-3 d-flex align-items-center">
                    //                         Organismo financiador :
                    //                     </div>
                    //                     <div class="col-1">
                    //                         <input type="text" class="form-control" id="orgfin1" readonly value="${element.codigo}">
                    //                     </div>
                    //                     <input type="hidden" value="${element.id_financiamiento}" name="organismo_financiador_${element.id_financiamiento}">
                    //                     <div class="col-4">
                    //                         <input type="text" class="form-control" value="${element.descripcion}" readonly>
                    //                     </div>
                    //                     <div class="col-2 fw-bold">
                    //                         <label class="form-label" for="financiamiento_${element.id_financiamiento}">Modificar: </label>
                    //                         <input type="checkbox" name="financiamiento_${element.id_financiamiento}" id="financiamiento_${element.id_financiamiento}" class="form-check-input" style="zoom: 1.5;" onchange="habilitarFinanciamiento(this)" data-value="${element.id_financiamiento}">
                    //                         <input type="hidden" id="id_caja_${element.id_financiamiento}" value="${element.id_caja}" name="id_caja_${element.id_financiamiento}">
                    //                     </div>
                    //                     <div class="col-2 fw-bold" id="finan_monto_${element.id_financiamiento}"></div>
                    //                 </div>
                    //                 <div id="fin_${element.id_financiamiento}"></div>
                    //             </div>`)
                        //         finan = element.id_financiamiento
                        //         montoAEdisp = parseFloat(element.total_presupuesto)
                        //         montoAE += parseFloat(element.total_presupuesto)
                        //         $('#finan_monto_' + element.id_financiamiento).empty()
                        //         $('#finan_monto_' + element.id_financiamiento).append(
                        //             `<div class="alert alert-primary">Monto disponible: ${montoAEdisp}&nbsp;bs.</div>
                    //             <input type="hidden" value="${montoAEdisp}" id="finan_maximo_${element.id_financiamiento}">`
                        //         )
                        //     } else {
                        //         if (finan == element.id_financiamiento) {
                        //             montoAEdisp += parseFloat(element.total_presupuesto)
                        //             montoAE += parseFloat(element.total_presupuesto)
                        //             $('#finan_monto_' + element.id_financiamiento).empty()
                        //             $('#finan_monto_' + element.id_financiamiento).append(
                        //                 `<div class="alert alert-primary">Monto disponible: ${montoAEdisp}&nbsp;bs.</div>
                    //                 <input type="hidden" value="${montoAEdisp}" id="finan_maximo_${element.id_financiamiento}">`
                        //             )
                        //         } else {
                        //             $('#financiamientos').append(`<hr><div class="form-group mt-5" id="financiamiento_${element.id_financiamiento}">
                    //                 <div class="row">
                    //                     <div class="col-3 d-flex align-items-center">
                    //                         Organismo financiador :
                    //                     </div>
                    //                     <div class="col-1">
                    //                         <input type="text" class="form-control" id="orgfin1" readonly value="${element.codigo}">
                    //                     </div>
                    //                     <input type="hidden" value="${element.id_financiamiento}" name="organismo_financiador_${element.id_financiamiento}">
                    //                     <div class="col-4">
                    //                         <input type="text" class="form-control" value="${element.descripcion}" readonly>
                    //                     </div>
                    //                     <div class="col-2 fw-bold">
                    //                         <label class="form-label" for="financiamiento_${element.id_financiamiento}">Modificar: </label>
                    //                         <input type="checkbox" name="financiamiento_${element.id_financiamiento}" id="financiamiento_${element.id_financiamiento}" class="form-check-input" style="zoom: 1.5;" onchange="habilitarFinanciamiento(this)" data-value="${element.id_financiamiento}">
                    //                         <input type="hidden" id="id_caja_${element.id_financiamiento}" value="${element.id_caja}" name="id_caja_${element.id_financiamiento}">
                    //                     </div>
                    //                     <div class="col-2 fw-bold" id="finan_monto_${element.id_financiamiento}"></div>
                    //                     <div id="fin_${element.id_financiamiento}"></div>
                    //                 </div>
                    //             </div>`)
                        //             finan = element.id_financiamiento
                        //             montoAEdisp = parseFloat(element.total_presupuesto)
                        //             montoAE += parseFloat(element.total_presupuesto)
                        //             $('#finan_monto_' + element.id_financiamiento).empty()
                        //             $('#finan_monto_' + element.id_financiamiento).append(
                        //                 `<div class="alert alert-primary">Monto disponible: ${montoAEdisp}&nbsp;bs.</div>
                    //             <input type="hidden" value="${montoAEdisp}" id="finan_maximo_${element.id_financiamiento}">`
                        //             )
                        //         }
                        //     }
                        // })





                        // $('#ae_de_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#ae_a_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#og_de_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#og_a_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#tp_de_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#tp_a_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#ae_de_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#ae_a_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#og_de_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#og_a_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#tp_de_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#tp_a_importe').attr('max', parseFloat(montoAE).toFixed(2))
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        }

        function cambiarAreaEstrategica2(select) {
            if (select.value == 0) {
                $('#area2').val('')

                $('#select-objetivoGestion2').empty()
                $('#select-objetivoGestion2').append(
                    '<option value="0">[SELECCIONE OBJETIVO DE GESTION]</option>')
                $('#objetivo2').val('')
                $('#select-tareaProyecto2').empty()
                $('#select-tareaProyecto2').append(
                    '<option value="0">[SELECCIONE OBJETIVO DE GESTION]</option>')
                $('#tarea2').val('')

                $('#ae_de_importe').val(parseFloat(0.00).toFixed(2))
                $('#ae_a_importe').val(parseFloat(0.00).toFixed(2))
                $('#og_de_importe').val(parseFloat(0.00).toFixed(2))
                $('#og_a_importe').val(parseFloat(0.00).toFixed(2))
                $('#tp_de_importe').val(parseFloat(0.00).toFixed(2))
                $('#tp_a_importe').val(parseFloat(0.00).toFixed(2))
                $('#ae_de_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#ae_a_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#og_de_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#og_a_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#tp_de_importe').attr('max', parseFloat(0.00).toFixed(2))
                $('#tp_a_importe').attr('max', parseFloat(0.00).toFixed(2))
            } else {
                $('#area2').val(select.value)
                const formulario1 = $('#select-area2 option:selected').attr('data-value')

                $.ajax({
                    url: "{{ route('getObjetivoInstitucional') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_area: $('#area2').val(),
                        formulario1: formulario1,
                        gestiones_id: $('#gestiones_id').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#select-objetivoGestion2').empty()
                        $('#select-objetivoGestion2').append(
                            '<option value="0">[SELECCIONE OBJETIVO DE GESTION]</option>')

                        response.forEach(element => {
                            $('#select-objetivoGestion2').append(
                                `<option value="${element.codigo}" data-value="${element.f2_id}" data-value-id="${element.id}">[${element.codigo}] ${element.descripcion}</option>`
                            )
                        })
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        }

        function cambiarObjetivoGestion(select) {
            if (select.value == 0) {
                $('#objetivo1').val('')
            } else {
                $('#objetivo1').val(`${$('#area1').val()}.${select.value}`);

                const objetivo = $('#select-objetivoGestion option:selected').attr('data-value-id');
                const f2 = $('#select-objetivoGestion option:selected').attr('data-value');

                $.ajax({
                    type: "POST",
                    url: "{{ route('getTareaProyecto') }}",
                    data: {
                        formulario2: f2,
                        objetivo: objetivo,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        $('#select-tareaProyecto').empty()
                        $('#select-tareaProyecto').append(
                            '<option value="0">[SELECCIONE TAREA O PROYECTO]</option>')

                        response.forEach(element => {
                            $('#select-tareaProyecto').append(
                                `<option value="${element.id}" data-value="${element.f5_id}">[${element.id}] ${element.descripcion}</option>`
                            )
                        })
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        }

        function cambiarObjetivoGestion2(select) {
            if (select.value == 0) {
                $('#objetivo2').val('');
            } else {
                $('#objetivo2').val(`${$('#area2').val()}.${select.value}`);

                const objetivo = $('#select-objetivoGestion2 option:selected').attr('data-value-id');
                const f2 = $('#select-objetivoGestion2 option:selected').attr('data-value');

                $.ajax({
                    type: "POST",
                    url: "{{ route('getTareaProyecto') }}",
                    data: {
                        formulario2: f2,
                        objetivo: objetivo,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        $('#select-tareaProyecto2').empty()
                        $('#select-tareaProyecto2').append(
                            '<option value="0">[SELECCIONE TAREA O PROYECTO]</option>')

                        response.forEach(element => {
                            $('#select-tareaProyecto2').append(
                                `<option value="${element.id}" data-value="${element.f5_id}">[${element.id}] ${element.descripcion}</option>`
                            )
                        })
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        }

        function cambiarTareaProyecto(select) {
            if (select.value == 0) {
                $('#tarea1').val('')
            } else {
                $('#tarea1').val(`${$('#objetivo1').val()}.${select.value}`);
                const formulario5 = $('#select-tareaProyecto option:selected').attr('data-value')

                $.ajax({
                    type: "POST",
                    url: "{{ route('getSaldo') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        formulario5: formulario5
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);

                        let montoAEdisp = 0
                        let montoAE = 0
                        let finan = 0; // Variable para agrupar las fuentes de financiamiento por su id
                        let total = 0
                        $('#financiamientos').empty();
                        response.forEach(element => {
                            if (finan == 0) {
                                $('#financiamientos').append(`<div class="form-group mt-3" id="financiamiento_${element.tipo_financiamiento_id}">
                                    <div class="row">
                                        <div class="col-3 d-flex align-items-center">
                                            Organismo financiador :
                                        </div>
                                        <div class="col-1">
                                            <input type="text" class="form-control" id="orgfin1" readonly value="${element.codigo}">
                                        </div>
                                        <input type="hidden" value="${element.tipo_financiamiento_id}" name="organismo_financiador_${element.tipo_financiamiento_id}">
                                        <div class="col-4">
                                            <input type="text" class="form-control" value="${element.descripcion}" readonly>
                                        </div>
                                        <div class="col-2 fw-bold">
                                            <label class="form-label" for="financiamiento_${element.tipo_financiamiento_id}">Modificar: </label>
                                            <div class="form-check form-switch mb-0">
                                                <label class="form-check-label" for="financiamiento_${element.tipo_financiamiento_id}">Habilitar</label>
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="financiamiento_${element.tipo_financiamiento_id}"
                                                    name="financiamiento_${element.tipo_financiamiento_id}"
                                                    data-value="${element.tipo_financiamiento_id}" data-value-id="${element.formulario5_id}">
                                                <input type="text" name="formulario5_${element.tipo_financiamiento_id}" value="${element.formulario5_id}">
                                            </div>
                                        </div>
                                        <div class="col-2 fw-bold" id="finan_monto_${element.tipo_financiamiento_id}"></div>
                                    </div>
                                    <div id="fin_${element.tipo_financiamiento_id}"></div>
                                </div>`)
                                finan = element.tipo_financiamiento_id
                                montoAEdisp = parseFloat(element.total_presupuesto)
                                montoAE += parseFloat(element.total_presupuesto)
                                total += montoAE
                                $('#finan_monto_' + element.tipo_financiamiento_id).empty()
                                $('#finan_monto_' + element.tipo_financiamiento_id).append(
                                    `<div class="alert alert-primary">Monto disponible: ${montoAEdisp}&nbsp;bs.</div>
                                <input type="hidden" value="${montoAEdisp}" id="finan_maximo_${element.tipo_financiamiento_id}">`
                                )
                            } else {
                                if (finan == element.tipo_financiamiento_id) {
                                    montoAEdisp += parseFloat(element.total_presupuesto)
                                    montoAE += parseFloat(element.total_presupuesto)
                                    total += montoAE
                                    $('#finan_monto_' + element.tipo_financiamiento_id).empty()
                                    $('#finan_monto_' + element.tipo_financiamiento_id).append(
                                        `<div class="alert alert-primary">Monto disponible: ${montoAEdisp}&nbsp;bs.</div>
                                    <input type="hidden" value="${montoAEdisp}" id="finan_maximo_${element.tipo_financiamiento_id}">`
                                    )
                                } else {
                                    $('#financiamientos').append(`<div class="form-group mt-5" id="financiamiento_${element.tipo_financiamiento_id}">
                                    <div class="row">
                                        <div class="col-3 d-flex align-items-center">
                                            Organismo financiador :
                                        </div>
                                        <div class="col-1">
                                            <input type="text" class="form-control" id="orgfin1" readonly value="${element.codigo}">
                                        </div>
                                        <input type="hidden" value="${element.tipo_financiamiento_id}" name="organismo_financiador_${element.tipo_financiamiento_id}">
                                        <div class="col-4">
                                            <input type="text" class="form-control" value="${element.descripcion}" readonly>
                                        </div>
                                        <div class="col-2 fw-bold">
                                            <label class="form-label" for="financiamiento_${element.tipo_financiamiento_id}">Modificar: </label>
                                            <div class="form-check form-switch mb-0">
                                                <label class="form-check-label" for="financiamiento_${element.tipo_financiamiento_id}">Habilitar</label>
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="financiamiento_${element.tipo_financiamiento_id}"
                                                    name="financiamiento_${element.tipo_financiamiento_id}"
                                                    data-value="${element.tipo_financiamiento_id}" data-value-id="${element.formulario5_id}">
                                                <input type="text" name="formulario5_${element.tipo_financiamiento_id}" value="${element.formulario5_id}">
                                            </div>
                                        </div>
                                        <div class="col-2 fw-bold" id="finan_monto_${element.tipo_financiamiento_id}"></div>
                                        <div id="fin_${element.tipo_financiamiento_id}"></div>
                                    </div>
                                </div>`)
                                    finan = element.tipo_financiamiento_id
                                    montoAEdisp = parseFloat(element.total_presupuesto)
                                    montoAE += parseFloat(element.total_presupuesto)
                                    total += montoAE
                                    $('#finan_monto_' + element.tipo_financiamiento_id).empty()
                                    $('#finan_monto_' + element.tipo_financiamiento_id).append(
                                        `<div class="alert alert-primary">Monto disponible: ${montoAEdisp}&nbsp;bs.</div>
                                <input type="hidden" value="${montoAEdisp}" id="finan_maximo_${element.tipo_financiamiento_id}">`
                                    )
                                }
                            }
                        })





                        // $('#ae_de_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#ae_a_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#og_de_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#og_a_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#tp_de_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#tp_a_importe').val(parseFloat(montoAE).toFixed(2))
                        // $('#ae_de_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#ae_a_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#og_de_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#og_a_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#tp_de_importe').attr('max', parseFloat(montoAE).toFixed(2))
                        // $('#tp_a_importe').attr('max', parseFloat(montoAE).toFixed(2))
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        }

        function cambiarTareaProyecto2(select) {
            if (select.value == 0) {
                $('#tarea2').val('');
            } else {
                $('#tarea2').val(`${$('#objetivo2').val()}.${select.value}`);
            }
        }

        let partidas_de_global;
        let c_partidas_de_global = 0;
        let partidas_global;
        let c_partidas_global = 0;

        function habilitarFinanciamiento(check) {
            if (check.checked) {
                const id = $(check).attr('data-value');
                const formulario5 = $(check).attr('data-value-id');
                $.ajax({
                    type: "POST",
                    url: "{{ route('getSaldoPartidas') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        // caja_id: $('#id_caja_' + id).val(),
                        id_formulado: $('#id_formulado').val(),
                        formulario5: formulario5,
                        gestiones_id: $('#gestiones_id').val(),
                        id_area_estrategica: $('#area1').val(),
                        financiamiento: id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        partidas_global = response

                        $('#fin_' + id).empty()
                        $('#fin_' + id).append(`<div class="row mt-3">
                                        <div class="col-3 d-flex justify-content-end">DE</div>
                                    </div>

                                    <div id="ppd-de-all${id}">
                                        <div class="form-group row mt-3 d-flex align-items-center" id="ppd-de_${id}0">
                                            <div class="col-3 d-flex align-items-center">
                                                Partidas presupuestarias de descripcion :
                                            </div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="de-partida_codigo_${id}0"
                                                    readonly name="de_partida_${id}0">
                                                <input type="hidden" id="de_detalle_${id}0" name="de_detalle_${id}0">
                                            </div>
                                            <div class="col-4">
                                                <select class="partidas_formulado_${id}0 form-control"
                                                    onchange="cambiarPartidaDe(this, ${id})" id="partidas_formulado_${id}0" required>
                                                    <option value="0">[SELECCIONE OPCION]</option>
                                                </select>
                                                <span class="text-danger" id="message_de_${id}0"
                                                    style="display:none;font-size:12px">Debe
                                                    seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <span class="text-info" style="font-size:12px">Monto maximo: <span
                                                        id="monto_max_${id}0"></span>&nbsp;bs</span>
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01"
                                                    min="0.00" placeholder="0.00" id="presupuesto-de_${id}0"
                                                    onchange="validarMontoMaximo('#presupuesto-de_${id}0')" readonly name="de_partida_monto_${id}0" required>
                                                <input type="hidden" name="de_partida_monto_id_mbs_${id}0" id="de_partida_monto_id_mbs_${id}0">
                                                <span class="text-danger" id="msg_pres_${id}0" style="font-size:12px"></span>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="crearPartidaDe(${id})"
                                                    id="btn-crear-de${id}">Agregar</button>
                                                {{-- <button type="button" class="btn btn-sm btn-danger">Quitar</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8"></div>
                                            <div class="col-1">TOTAL: </div>
                                            <div class="col-2">
                                                <input type="hidden" name="contDe${id}" id="contDe${id}" value="0">
                                                <input type="number" class="form-control border-primary" onkeyup="montoNumber(this)"
                                                    step="0.01" min="0.00" placeholder="0.00" readonly
                                                    id="total_de${id}" name="total_de${id}" onchange="obtenerTotalA(${id})">
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                {{-- <button type="button" class="btn btn-sm btn-primary">Agregar</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3 d-flex justify-content-end">A</div>
                                    </div>
                                    <div id="ppd-a-all${id}">
                                        <div class="form-group row mt-3" id="ppd-a_${id}0">
                                            <div class="col-3 d-flex align-items-center">
                                                Partidas presupuestarias de descripcion :
                                            </div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="a-partida_codigo_${id}0"
                                                    readonly>
                                                <input type="hidden" id="a_detalle_${id}0" name="a_detalle_${id}0">
                                            </div>
                                            <div class="col-4">
                                                <select class="partidas_${id}0 form-control" name="a_partida_${id}0"
                                                    onchange="cambiarPartidaA(this, ${id})" id="partidas_${id}0" required>
                                                    <option value="0">[SELECCIONE OPCION]</option>
                                                </select>
                                                <span class="text-danger" id="message_a_${id}0"
                                                    style="font-size:12px"></span>
                                            </div>
                                            <div class="col-2">
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01"
                                                    min="0.00" placeholder="0.00" id="presupuesto-a_${id}0"
                                                    onchange="obtenerTotalA(${id})" readonly name="a_partida_monto_${id}0" required>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="crearPartidaA(${id})"
                                                    id="btn-crear-a${id}">Agregar</button>
                                                {{-- <button type="button" class="btn btn-sm btn-danger">Quitar</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8"></div>
                                            <div class="col-1">TOTAL: </div>
                                            <div class="col-2">
                                                <input type="hidden" name="contA${id}" id="contA${id}" value="0">
                                                <input type="number" class="form-control border-primary" onkeyup="montoNumber(this)"
                                                    step="0.01" min="0.00" placeholder="0.00" readonly
                                                    id="total_a${id}" name="total_a${id}">
                                                <span class="text-danger" id="message_total_a${id}"
                                                    style="font-size:12px"></span>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                {{-- <button type="button" class="btn btn-sm btn-primary">Agregar</button> --}}
                                            </div>
                                        </div>
                                    </div>`)



                        $('.partidas_formulado_' + id + '0').empty()
                        $('.partidas_formulado_' + id + '0').append(
                            '<option value="0">[SELECCIONE OPCION]</option>')
                        response[3].forEach(element => {
                            $('.partidas_formulado_' + id + '0').append(
                                `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}" data-value-fin="${id}" data-id-detalle="${element.id_dc3}">
                                    [${element.partida}] ${element.titulo_detalle}
                                </option>`
                            )
                            c_partidas_global++
                        });
                        response[4].forEach(element => {
                            $('.partidas_formulado_' + id + '0').append(
                                `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id}" data-id-detalle="${element.id_dc4}">
                                    [${element.partida}] ${element.titulo_detalle}
                                </option>`
                            )
                            c_partidas_global++
                        });
                        response[5].forEach(element => {
                            $('.partidas_formulado_' + id + '0').append(
                                `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id}" data-id-detalle="${element.id_dc5}">
                                    [${element.partida}] ${element.titulo_detalle}
                                </option>`
                            )
                            c_partidas_global++
                        });
                        $('.partidas_formulado_' + id + '0').select2();

                        $('.partidas_' + id + '0').empty()
                        $('.partidas_' + id + '0').append('<option value="0">[SELECCIONE OPCION]</option>')
                        response[0].forEach(element => {
                            $('.partidas_' + id + '0').append(
                                `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                            )
                            c_partidas_de_global++
                        });
                        response[1].forEach(element => {
                            $('.partidas_' + id + '0').append(
                                `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                            )
                            c_partidas_de_global++
                        });
                        response[2].forEach(element => {
                            $('.partidas_' + id + '0').append(
                                `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                            )
                            c_partidas_de_global++
                        });
                        $('.partidas_' + id + '0').select2();
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            } else {
                const id = $(check).attr('data-value');
                $('#fin_' + id).empty()
            }
        }

        function habilitarFin(check) {
            if (check.checked) {
                const id = $(check).attr('data-value');
                const formulario5 = $(check).attr('data-value-id');
                $('$formulario5_' + id).val(formulario5)
            }
        }

        let partidas_select1 = []
        let partidas_select2 = []
        let partidas_select3 = []
        let partidas_select4 = []
        let contDe1 = 0;
        let contDe2 = 0;
        let contDe3 = 0;
        let contDe4 = 0;

        function crearPartidaDe(id_fin) {
            switch (id_fin) {
                case 1:
                    if (validarMontoMaximo('#presupuesto-de_' + id_fin + contDe1)) {
                        if (c_partidas_global > contDe1 && $('#de-partida_codigo_' + id_fin + contDe1).val() != '') {
                            contDe1++
                            if (c_partidas_global - 1 == contDe1) {
                                $('#btn-crear-de' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-de_${id_fin}${contDe1}">
                                        <div class="col-3"></div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="de-partida_codigo_${id_fin}${contDe1}" readonly name="de_partida_${id_fin}${contDe1}]">
                                            <input type="hidden" id="de_detalle_${id_fin}${contDe1}" name="de_detalle_${id_fin}${contDe1}">
                                        </div>
                                        <div class="col-4">
                                            <select class="partidas_formulado_${id_fin}${contDe1} form-control"
                                                onchange="cambiarPartidaDe(this, ${id_fin})" id="partidas_formulado_${id_fin}${contDe1}">
                                                <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[3].forEach(element => {
                                if (!partidas_select1.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc3}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[4].forEach(element => {
                                if (!partidas_select1.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc4}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[5].forEach(element => {
                                if (!partidas_select1.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc5}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            newOption = newOption + `</select>
                                            <span class="text-danger" id="message_de_${id_fin}${contDe1}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                        </div>
                                        <div class="col-2">
                                            <span class="text-info" style="font-size:12px">Monto maximo: <span
                                                    id="monto_max_${id_fin}${contDe1}"></span>&nbsp;bs</span>
                                            <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                placeholder="0.00" id="presupuesto-de_${id_fin}${contDe1}"
                                                onchange="validarMontoMaximo('#presupuesto-de_${id_fin}${contDe1}')" readonly name="de_partida_monto_${id_fin}${contDe1}">
                                            <input type="hidden" name="de_partida_monto_id_mbs_${id_fin}${contDe1}" id="de_partida_monto_id_mbs_${id_fin}${contDe1}">
                                            <span class="text-danger" id="msg_pres_${id_fin}${contDe1}" style="font-size:12px"></span>
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaDe('${contDe1}', ${id_fin})" id="btn-eliminar_de_${id_fin}${contDe1}">Quitar</button>
                                        </div>
                                    </div>`
                            $('#ppd-de-all' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + contDe1).select2()

                            $('#partidas_formulado_' + id_fin + (contDe1 - 1)).attr('disabled', true)
                            $('#btn-eliminar_de_' + id_fin + (contDe1 - 1)).attr('style', 'display:none')
                            $('#presupuesto-de_' + id_fin + (contDe1 - 1)).attr('readonly', 'readonly')
                            $('#message_de_' + id_fin + contDe1).attr('style', 'display:none')
                            $('#contDe1').val(contDe1)
                        } else {
                            $('#message_de_' + id_fin + contDe1).attr('style', 'display:block')
                        }
                    }
                    break;
                case 2:
                    if (validarMontoMaximo('#presupuesto-de_' + id_fin + contDe2)) {
                        if (c_partidas_global > contDe2 && $('#de-partida_codigo_' + id_fin + contDe2).val() != '') {
                            contDe2++
                            if (c_partidas_global - 1 == contDe2) {
                                $('#btn-crear-de' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-de_${id_fin}${contDe2}">
                                        <div class="col-3"></div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="de-partida_codigo_${id_fin}${contDe2}" readonly name="de_partida_${id_fin}${contDe2}">
                                            <input type="hidden" id="de_detalle_${id_fin}${contDe2}" name="de_detalle_${id_fin}${contDe2}">
                                        </div>
                                        <div class="col-4">
                                            <select class="partidas_formulado_${id_fin}${contDe2} form-control"
                                                onchange="cambiarPartidaDe(this, ${id_fin})" id="partidas_formulado_${id_fin}${contDe2}">
                                                <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[3].forEach(element => {
                                if (!partidas_select2.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc3}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[4].forEach(element => {
                                if (!partidas_select2.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc4}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[5].forEach(element => {
                                if (!partidas_select2.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc5}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            newOption = newOption + `</select>
                                            <span class="text-danger" id="message_de_${id_fin}${contDe2}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                        </div>
                                        <div class="col-2">
                                            <span class="text-info" style="font-size:12px">Monto maximo: <span
                                                    id="monto_max_${id_fin}${contDe2}"></span>&nbsp;bs</span>
                                            <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                placeholder="0.00" id="presupuesto-de_${id_fin}${contDe2}"
                                                onchange="validarMontoMaximo('#presupuesto-de_${id_fin}${contDe2}')" readonly name="de_partida_monto_${id_fin}${contDe2}">
                                            <input type="hidden" name="de_partida_monto_id_mbs_${id_fin}${contDe2}" id="de_partida_monto_id_mbs_${id_fin}${contDe2}">
                                            <span class="text-danger" id="msg_pres_${id_fin}${contDe2}" style="font-size:12px"></span>
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaDe('${contDe2}', ${id_fin})" id="btn-eliminar_de_${id_fin}${contDe2}">Quitar</button>
                                        </div>
                                    </div>`
                            $('#ppd-de-all' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + contDe2).select2()

                            $('#partidas_formulado_' + id_fin + (contDe2 - 1)).attr('disabled', true)
                            $('#btn-eliminar_de_' + id_fin + (contDe2 - 1)).attr('style', 'display:none')
                            $('#presupuesto-de_' + id_fin + (contDe2 - 1)).attr('readonly', 'readonly')
                            $('#message_de_' + id_fin + contDe2).attr('style', 'display:none')
                            $('#contDe2').val(contDe2)
                        } else {
                            $('#message_de_' + id_fin + contDe2).attr('style', 'display:block')
                        }
                    }
                    break;
                case 3:
                    if (validarMontoMaximo('#presupuesto-de_' + id_fin + contDe3)) {
                        if (c_partidas_global > contDe3 && $('#de-partida_codigo_' + id_fin + contDe3).val() != '') {
                            contDe3++
                            if (c_partidas_global - 1 == contDe3) {
                                $('#btn-crear-de' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-de_${id_fin}${contDe3}">
                                        <div class="col-3"></div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="de-partida_codigo_${id_fin}${contDe3}" readonly name="de_partida_${id_fin}${contDe3}">
                                            <input type="hidden" id="de_detalle_${id_fin}${contDe3}" name="de_detalle_${id_fin}${contDe3}">
                                        </div>
                                        <div class="col-4">
                                            <select class="partidas_formulado_${id_fin}${contDe3} form-control"
                                                onchange="cambiarPartidaDe(this, ${id_fin})" id="partidas_formulado_${id_fin}${contDe3}">
                                                <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[3].forEach(element => {
                                if (!partidas_select3.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc3}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[4].forEach(element => {
                                if (!partidas_select3.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc4}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[5].forEach(element => {
                                if (!partidas_select3.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc5}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            newOption = newOption + `</select>
                                            <span class="text-danger" id="message_de_${id_fin}${contDe3}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                        </div>
                                        <div class="col-2">
                                            <span class="text-info" style="font-size:12px">Monto maximo: <span
                                                    id="monto_max_${id_fin}${contDe3}"></span>&nbsp;bs</span>
                                            <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                placeholder="0.00" id="presupuesto-de_${id_fin}${contDe3}"
                                                onchange="validarMontoMaximo('#presupuesto-de_${id_fin}${contDe3}')" readonly name="de_partida_monto_${id_fin}${contDe3}">
                                            <input type="hidden" name="de_partida_monto_id_mbs_${id_fin}${contDe3}" id="de_partida_monto_id_mbs_${id_fin}${contDe3}">
                                            <span class="text-danger" id="msg_pres_${id_fin}${contDe3}" style="font-size:12px"></span>
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaDe('${contDe3}', ${id_fin})" id="btn-eliminar_de_${id_fin}${contDe3}">Quitar</button>
                                        </div>
                                    </div>`
                            $('#ppd-de-all' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + contDe3).select2()

                            $('#partidas_formulado_' + id_fin + (contDe3 - 1)).attr('disabled', true)
                            $('#btn-eliminar_de_' + id_fin + (contDe3 - 1)).attr('style', 'display:none')
                            $('#presupuesto-de_' + id_fin + (contDe3 - 1)).attr('readonly', 'readonly')
                            $('#message_de_' + id_fin + contDe3).attr('style', 'display:none')
                            $('#contDe3').val(contDe3)
                        } else {
                            $('#message_de_' + id_fin + contDe3).attr('style', 'display:block')
                        }
                    }
                    break;
                case 4:
                    if (validarMontoMaximo('#presupuesto-de_' + id_fin + contDe4)) {
                        if (c_partidas_global > contDe4 && $('#de-partida_codigo_' + id_fin + contDe4).val() != '') {
                            contDe4++
                            if (c_partidas_global - 1 == contDe4) {
                                $('#btn-crear-de' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-de_${id_fin}${contDe4}">
                                        <div class="col-3"></div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="de-partida_codigo_${id_fin}${contDe4}" readonly name="de_partida_${id_fin}${contDe4}">
                                            <input type="hidden" id="de_detalle_${id_fin}${contDe4}" name="de_detalle_${id_fin}${contDe4}">
                                        </div>
                                        <div class="col-4">
                                            <select class="partidas_formulado_${id_fin}${contDe4} form-control"
                                                onchange="cambiarPartidaDe(this${id_fin})" id="partidas_formulado_${id_fin}${contDe4}">
                                                <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[3].forEach(element => {
                                if (!partidas_select4.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc3}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[4].forEach(element => {
                                if (!partidas_select4.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc4}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            partidas_global[5].forEach(element => {
                                if (!partidas_select4.includes(element.id)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id}"  data-value-fin="${id_fin}"
                                        data-id-detalle="${element.id_dc5}">
                                            [${element.partida}] ${element.titulo_detalle}
                                        </option>`
                                }
                            })
                            newOption = newOption + `</select>
                                            <span class="text-danger" id="message_de_${id_fin}${contDe4}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                        </div>
                                        <div class="col-2">
                                            <span class="text-info" style="font-size:12px">Monto maximo: <span
                                                    id="monto_max_${id_fin}${contDe4}"></span>&nbsp;bs</span>
                                            <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                placeholder="0.00" id="presupuesto-de_${id_fin}${contDe4}"
                                                onchange="validarMontoMaximo('#presupuesto-de_${id_fin}${contDe4}')" readonly name="de_partida_monto_${id_fin}${contDe4}">
                                            <input type="hidden" name="de_partida_monto_id_mbs_${id_fin}${contDe4}" id="de_partida_monto_id_mbs_${id_fin}${contDe4}">
                                            <span class="text-danger" id="msg_pres_${id_fin}${contDe4}" style="font-size:12px"></span>
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaDe('${contDe4}', ${id_fin})" id="btn-eliminar_de_${id_fin}${contDe4}">Quitar</button>
                                        </div>
                                    </div>`
                            $('#ppd-de-all' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + contDe4).select2()

                            $('#partidas_formulado_' + id_fin + (contDe4 - 1)).attr('disabled', true)
                            $('#btn-eliminar_de_' + id_fin + (contDe4 - 1)).attr('style', 'display:none')
                            $('#presupuesto-de_' + id_fin + (contDe4 - 1)).attr('readonly', 'readonly')
                            $('#message_de_' + id_fin + contDe4).attr('style', 'display:none')
                            $('#contDe4').val(contDe4)
                        } else {
                            $('#message_de_' + id_fin + contDe4).attr('style', 'display:block')
                        }
                    }
                    break;
            }
        }

        function quitarPartidaDe(id, id_fin) {
            switch (id_fin) {
                case 1:
                    $('#ppd-de_' + id_fin + id).remove()
                    contDe1--
                    $('#btn-crear-de' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (contDe1)).removeAttr('disabled')
                    $('#presupuesto-de_' + id_fin + contDe1).removeAttr('readonly');
                    $('#btn-eliminar_de_' + id_fin + (contDe1)).attr('style', 'display:block')
                    $('#contDe1').val(contDe1)
                    partidas_select1.pop()
                    obtenerTotalDe(id_fin)
                    break;
                case 2:
                    $('#ppd-de_' + id_fin + id).remove()
                    contDe2--
                    $('#btn-crear-de' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (contDe2)).removeAttr('disabled')
                    $('#presupuesto-de_' + id_fin + contDe2).removeAttr('readonly');
                    $('#btn-eliminar_de_' + id_fin + (contDe2)).attr('style', 'display:block')
                    $('#contDe2').val(contDe2)
                    partidas_select2.pop()
                    obtenerTotalDe(id_fin)
                    break;
                case 3:
                    $('#ppd-de_' + id_fin + id).remove()
                    contDe3--
                    $('#btn-crear-de' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (contDe3)).removeAttr('disabled')
                    $('#presupuesto-de_' + id_fin + contDe3).removeAttr('readonly');
                    $('#btn-eliminar_de_' + id_fin + (contDe3)).attr('style', 'display:block')
                    $('#contDe3').val(contDe3)
                    partidas_select3.pop()
                    obtenerTotalDe(id_fin)
                    break;
                case 4:
                    $('#ppd-de_' + id_fin + id).remove()
                    contDe4--
                    $('#btn-crear-de' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (contDe4)).removeAttr('disabled')
                    $('#presupuesto-de_' + id_fin + contDe4).removeAttr('readonly');
                    $('#btn-eliminar_de_' + id_fin + (contDe4)).attr('style', 'display:block')
                    $('#contDe4').val(contDe4)
                    partidas_select4.pop()
                    obtenerTotalDe(id_fin)
                    break;
            }
        }

        function cambiarPartidaDe(select, id_fin) {
            let presupuesto_total_de
            let de_partida_monto
            let id_mbs
            let id_detalle
            if (select.value != 0) {
                switch (id_fin) {
                    case 1:
                        $('#de-partida_codigo_' + id_fin + contDe1).val(select.value)
                        $('#message_de_' + id_fin + contDe1).attr('style', 'display:none')

                        id_mbs = $('#partidas_formulado_' + id_fin + contDe1 + ' option:selected').attr(
                            'data-value-id')
                        partidas_select1[contDe1] = parseInt(id_mbs)

                        id_detalle = $('#partidas_formulado_' + id_fin + contDe1 + ' option:selected').attr(
                            'data-id-detalle')
                        $('#de_detalle_' + id_fin + contDe1).val(id_detalle)

                        presupuesto_total_de = $('#partidas_formulado_' + id_fin + contDe1 + ' option:selected').attr(
                            'data-value2')
                        $('#presupuesto-de_' + id_fin + contDe1).val(presupuesto_total_de);

                        de_partida_monto = $('#partidas_formulado_' + id_fin + contDe1 + ' option:selected').attr(
                            'data-value-id')
                        $('#de_partida_monto_id_mbs_' + id_fin + contDe1).val(de_partida_monto);

                        $('#monto_max_' + id_fin + contDe1).text(presupuesto_total_de);

                        $('#presupuesto-de_' + id_fin + contDe1).removeAttr('readonly');
                        $('#presupuesto-de_' + id_fin + contDe1).attr('max', presupuesto_total_de);
                        obtenerTotalDe(id_fin)
                        obtenerTotalA(id_fin)
                        break;
                    case 2:
                        $('#de-partida_codigo_' + id_fin + contDe2).val(select.value)
                        $('#message_de_' + id_fin + contDe2).attr('style', 'display:none')

                        id_mbs = $('#partidas_formulado_' + id_fin + contDe2 + ' option:selected').attr(
                            'data-value-id')
                        partidas_select2[contDe2] = parseInt(id_mbs)

                        id_detalle = $('#partidas_formulado_' + id_fin + contDe2 + ' option:selected').attr(
                            'data-id-detalle')
                        $('#de_detalle_' + id_fin + contDe2).val(id_detalle)

                        presupuesto_total_de = $('#partidas_formulado_' + id_fin + contDe2 + ' option:selected').attr(
                            'data-value2')
                        $('#presupuesto-de_' + id_fin + contDe2).val(presupuesto_total_de);
                        de_partida_monto = $('#partidas_formulado_' + id_fin + contDe2 + ' option:selected').attr(
                            'data-value-id')
                        $('#de_partida_monto_id_mbs_' + id_fin + contDe2).val(de_partida_monto);
                        $('#monto_max_' + id_fin + contDe2).text(presupuesto_total_de);

                        $('#presupuesto-de_' + id_fin + contDe2).removeAttr('readonly');
                        $('#presupuesto-de_' + id_fin + contDe2).attr('max', presupuesto_total_de);
                        obtenerTotalDe(id_fin)
                        obtenerTotalA(id_fin)
                        break;
                    case 3:
                        $('#de-partida_codigo_' + id_fin + contDe3).val(select.value)
                        $('#message_de_' + id_fin + contDe3).attr('style', 'display:none')

                        id_mbs = $('#partidas_formulado_' + id_fin + contDe3 + ' option:selected').attr(
                            'data-value-id')
                        partidas_select3[contDe3] = parseInt(id_mbs)

                        id_detalle = $('#partidas_formulado_' + id_fin + contDe3 + ' option:selected').attr(
                            'data-id-detalle')
                        $('#de_detalle_' + id_fin + contDe3).val(id_detalle)

                        presupuesto_total_de = $('#partidas_formulado_' + id_fin + contDe3 + ' option:selected').attr(
                            'data-value2')
                        $('#presupuesto-de_' + id_fin + contDe3).val(presupuesto_total_de);
                        de_partida_monto = $('#partidas_formulado_' + id_fin + contDe3 + ' option:selected').attr(
                            'data-value-id')
                        $('#de_partida_monto_id_mbs_' + id_fin + contDe3).val(de_partida_monto);
                        $('#monto_max_' + id_fin + contDe3).text(presupuesto_total_de);

                        $('#presupuesto-de_' + id_fin + contDe3).removeAttr('readonly');
                        $('#presupuesto-de_' + id_fin + contDe3).attr('max', presupuesto_total_de);
                        obtenerTotalDe(id_fin)
                        obtenerTotalA(id_fin)
                        break;
                    case 4:
                        $('#de-partida_codigo_' + id_fin + contDe4).val(select.value)
                        $('#message_de_' + id_fin + contDe4).attr('style', 'display:none')

                        id_mbs = $('#partidas_formulado_' + id_fin + contDe4 + ' option:selected').attr(
                            'data-value-id')
                        partidas_select4[contDe4] = parseInt(id_mbs)

                        id_detalle = $('#partidas_formulado_' + id_fin + contDe4 + ' option:selected').attr(
                            'data-id-detalle')
                        $('#de_detalle_' + id_fin + contDe4).val(id_detalle)

                        presupuesto_total_de = $('#partidas_formulado_' + id_fin + contDe4 + ' option:selected').attr(
                            'data-value2')
                        $('#presupuesto-de_' + id_fin + contDe4).val(presupuesto_total_de);
                        de_partida_monto = $('#partidas_formulado_' + id_fin + contDe4 + ' option:selected').attr(
                            'data-value-id')
                        $('#de_partida_monto_id_mbs_' + id_fin + contDe4).val(de_partida_monto);
                        $('#monto_max_' + id_fin + contDe4).text(presupuesto_total_de);

                        $('#presupuesto-de_' + id_fin + contDe4).removeAttr('readonly');
                        $('#presupuesto-de_' + id_fin + contDe4).attr('max', presupuesto_total_de);
                        obtenerTotalDe(id_fin)
                        obtenerTotalA(id_fin)
                        break;
                }
            }
            console.log(partidas_select1);
            console.log(partidas_select2);
            console.log(partidas_select3);
            console.log(partidas_select4);
        }

        function obtenerTotalDe(id_fin) {
            let total = 0.00
            let presupuesto = 0.00
            switch (id_fin) {
                case 1:
                    total = 0.00
                    presupuesto = 0.00
                    for (let i = 0; i <= contDe1; i++) {
                        presupuesto = $('#presupuesto-de_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_de' + id_fin).val('0.00')
                    } else {
                        $('#total_de' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
                case 2:
                    total = 0.00
                    presupuesto = 0.00
                    for (let i = 0; i <= contDe2; i++) {
                        presupuesto = $('#presupuesto-de_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_de' + id_fin).val('0.00')
                    } else {
                        $('#total_de' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
                case 3:
                    total = 0.00
                    presupuesto = 0.00
                    for (let i = 0; i <= contDe3; i++) {
                        presupuesto = $('#presupuesto-de_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_de' + id_fin).val('0.00')
                    } else {
                        $('#total_de' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
                case 4:
                    total = 0.00
                    presupuesto = 0.00
                    for (let i = 0; i <= contDe4; i++) {
                        presupuesto = $('#presupuesto-de_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_de' + id_fin).val('0.00')
                    } else {
                        $('#total_de' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
            }
        }

        let partidas_select_a1 = []
        let partidas_select_a2 = []
        let partidas_select_a3 = []
        let partidas_select_a4 = []
        let contA1 = 0;
        let contA2 = 0;
        let contA3 = 0;
        let contA4 = 0;

        function crearPartidaA(id_fin) {
            switch (id_fin) {
                case 1:
                    if (validarMontoMaximo('#presupuesto-a_' + id_fin + contA1)) {
                        if (c_partidas_global > contA1 && $('#a-partida_codigo_' + id_fin + contA1).val() != '') {
                            contA1++
                            if (c_partidas_global - 1 == contA1) {
                                $('#btn-crear-a').attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-a_${id_fin}${contA1}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="a-partida_codigo_${id_fin}${contA1}" readonly name="a_partida_${id_fin}${contA1}">
                                                <input type="hidden" id="a_detalle_${id_fin}${contA1}" name="a_detalle_${id_fin}${contA1}">
                                            </div>
                                            <div class="col-4">
                                                <select class="a_partida_${id_fin}${contA1} form-control"
                                                    onchange="cambiarPartidaA(this, ${id_fin})" id="partidas_${id_fin}${contA1}">
                                                    <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select_a1.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select_a1.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select_a1.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_a_${id_fin}${contA1}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto-a_${id_fin}${contA1}"
                                                    onchange="obtenerTotalA(${id_fin})" readonly name="a_partida_monto_${id_fin}${contA1}">
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaA('${contA1}', ${id_fin})" id="btn-eliminar_a_${id_fin}${contA1}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#ppd-a-all' + id_fin).append(newOption);
                            $('.a_partida_' + id_fin + contA1).select2()

                            $('#a_partida_' + id_fin + (contA1 - 1)).attr('disabled', true)
                            $('#btn-eliminar_a_' + id_fin + (contA1 - 1)).attr('style', 'display:none')
                            $('#presupuesto-a_' + id_fin + (contA1 - 1)).attr('readonly', 'readonly')
                            $('#message_a_' + id_fin + contA1).attr('style', 'display:none')
                            $('#contA1').val(contA1)
                        } else {
                            $('#message_a_' + id_fin + contA1).attr('style', 'display:block')
                        }
                    }
                    break;
                case 2:
                    if (validarMontoMaximo('#presupuesto-a_' + id_fin + contA2)) {
                        if (c_partidas_global > contA2 && $('#a-partida_codigo_' + id_fin + contA2).val() != '') {
                            contA2++
                            if (c_partidas_global - 1 == contA2) {
                                $('#btn-crear-a').attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-a_${id_fin}${contA2}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="a-partida_codigo_${id_fin}${contA2}" readonly name="a_partida_${id_fin}${contA2}">
                                                <input type="hidden" id="a_detalle_${id_fin}${contA2}" name="a_detalle_${id_fin}${contA2}">
                                            </div>
                                            <div class="col-4">
                                                <select class="a_partida_${id_fin}${contA2} form-control"
                                                    onchange="cambiarPartidaA(this, ${id_fin})" id="partidas_${id_fin}${contA2}">
                                                    <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select_a2.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select_a2.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select_a2.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_a_${id_fin}${contA2}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto-a_${id_fin}${contA2}"
                                                    onchange="obtenerTotalA(${id_fin})"readonly name="a_partida_monto_${id_fin}${contA2}">
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaA('${contA2}', ${id_fin})" id="btn-eliminar_a_${id_fin}${contA2}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#ppd-a-all' + id_fin).append(newOption);
                            $('.a_partida_' + id_fin + contA2).select2()

                            $('#a_partida_' + id_fin + (contA2 - 1)).attr('disabled', true)
                            $('#btn-eliminar_a_' + id_fin + (contA2 - 1)).attr('style', 'display:none')
                            $('#presupuesto-a_' + id_fin + (contA2 - 1)).attr('readonly', 'readonly')
                            $('#message_a_' + id_fin + contA2).attr('style', 'display:none')
                            $('#contA2').val(contA2)
                        } else {
                            $('#message_a_' + id_fin + contA2).attr('style', 'display:block')
                        }
                    }
                    break;
                case 3:
                    if (validarMontoMaximo('#presupuesto-a_' + id_fin + contA3)) {
                        if (c_partidas_global > contA3 && $('#a-partida_codigo_' + id_fin + contA3).val() != '') {
                            contA3++
                            if (c_partidas_global - 1 == contA3) {
                                $('#btn-crear-a').attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-a_${id_fin}${contA3}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="a-partida_codigo_${id_fin}${contA3}" readonly name="a_partida_${id_fin}${contA3}">
                                                <input type="hidden" id="a_detalle_${id_fin}${contA3}" name="a_detalle_${id_fin}${contA3}">
                                            </div>
                                            <div class="col-4">
                                                <select class="a_partida_${id_fin}${contA3} form-control"
                                                    onchange="cambiarPartidaA(this, ${id_fin})" id="partidas_${id_fin}${contA3}">
                                                    <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select_a3.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select_a3.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select_a3.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_a_${id_fin}${contA3}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto-a_${id_fin}${contA3}"
                                                    onchange="obtenerTotalA(${id_fin})" readonly name="a_partida_monto_${id_fin}${contA3}">
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaA('${contA3}', ${id_fin})" id="btn-eliminar_a_${id_fin}${contA3}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#ppd-a-all' + id_fin).append(newOption);
                            $('.a_partida_' + id_fin + contA3).select2()

                            $('#a_partida_' + id_fin + (contA3 - 1)).attr('disabled', true)
                            $('#btn-eliminar_a_' + id_fin + (contA3 - 1)).attr('style', 'display:none')
                            $('#presupuesto-a_' + id_fin + (contA3 - 1)).attr('readonly', 'readonly')
                            $('#message_a_' + id_fin + contA3).attr('style', 'display:none')
                            $('#contA3').val(contA3)
                        } else {
                            $('#message_a_' + id_fin + contA3).attr('style', 'display:block')
                        }
                    }
                    break;
                case 4:
                    if (validarMontoMaximo('#presupuesto-a_' + id_fin + contA4)) {
                        if (c_partidas_global > contA4 && $('#a-partida_codigo_' + id_fin + contA4).val() != '') {
                            contA4++
                            if (c_partidas_global - 1 == contA4) {
                                $('#btn-crear-a').attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd-a_${id_fin}${contA4}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="a-partida_codigo_${id_fin}${contA4}" readonly name="a_partida_${id_fin}${contA4}">
                                                <input type="hidden" id="a_detalle_${id_fin}${contA4}" name="a_detalle_${id_fin}${contA4}">
                                            </div>
                                            <div class="col-4">
                                                <select class="a_partida_${id_fin}${contA4} form-control"
                                                    onchange="cambiarPartidaA(this, ${id_fin})" id="partidas_${id_fin}${contA4}">
                                                    <option value="0">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select_a4.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select_a4.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select_a4.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value-id="${element.titulo_detalle}" data-id-detalle="${element.id}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_a_${id_fin}${contA4}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto-a_${id_fin}${contA4}"
                                                    onchange="obtenerTotalA(${id_fin})" readonly name="a_partida_monto_${id_fin}${contA4}">
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartidaA('${contA4}', ${id_fin})" id="btn-eliminar_a_${id_fin}${contA4}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#ppd-a-all' + id_fin).append(newOption);
                            $('.a_partida_' + id_fin + contA4).select2()

                            $('#a_partida_' + id_fin + (contA4 - 1)).attr('disabled', true)
                            $('#btn-eliminar_a_' + id_fin + (contA4 - 1)).attr('style', 'display:none')
                            $('#presupuesto-a_' + id_fin + (contA4 - 1)).attr('readonly', 'readonly')
                            $('#message_a_' + id_fin + contA4).attr('style', 'display:none')
                            $('#contA4').val(contA4)
                        } else {
                            $('#message_a_' + id_fin + contA4).attr('style', 'display:block')
                        }
                    }
                    break;
            }
        }

        function quitarPartidaA(id, id_fin) {
            switch (id_fin) {
                case 1:
                    $('#ppd-a_' + id_fin + id).remove()
                    contA1--
                    $('#btn-crear-a' + id_fin).attr('style', 'display:block')
                    $('#a_partida_' + id_fin + (contA1)).removeAttr('disabled')
                    $('#presupuesto-a_' + id_fin + contA1).removeAttr('readonly');
                    $('#btn-eliminar_a_' + id_fin + (contA1)).attr('style', 'display:block')
                    $('#contA1').val(contA1)
                    partidas_select_a1.pop()
                    obtenerTotalDe(id_fin)
                    obtenerTotalA(id_fin)
                    break;
                case 2:
                    $('#ppd-a_' + id_fin + id).remove()
                    contA2--
                    $('#btn-crear-a' + id_fin).attr('style', 'display:block')
                    $('#a_partida_' + id_fin + (contA2)).removeAttr('disabled')
                    $('#presupuesto-a_' + id_fin + contA2).removeAttr('readonly');
                    $('#btn-eliminar_a_' + id_fin + (contA2)).attr('style', 'display:block')
                    $('#contA2').val(contA2)
                    partidas_select_a2.pop()
                    obtenerTotalDe(id_fin)
                    obtenerTotalA(id_fin)
                    break;
                case 3:
                    $('#ppd-a_' + id_fin + id).remove()
                    contA3--
                    $('#btn-crear-a' + id_fin).attr('style', 'display:block')
                    $('#a_partida_' + id_fin + (contA3)).removeAttr('disabled')
                    $('#presupuesto-a_' + id_fin + contA3).removeAttr('readonly');
                    $('#btn-eliminar_a_' + id_fin + (contA3)).attr('style', 'display:block')
                    $('#contA3').val(contA3)
                    partidas_select_a3.pop()
                    obtenerTotalDe(id_fin)
                    obtenerTotalA(id_fin)
                    break;
                case 4:
                    $('#ppd-a_' + id_fin + id).remove()
                    contA4--
                    $('#btn-crear-a' + id_fin).attr('style', 'display:block')
                    $('#a_partida_' + id_fin + (contA4)).removeAttr('disabled')
                    $('#presupuesto-a_' + id_fin + contA4).removeAttr('readonly');
                    $('#btn-eliminar_a_' + id_fin + (contA4)).attr('style', 'display:block')
                    $('#contA4').val(contA4)
                    partidas_select_a4.pop()
                    obtenerTotalDe(id_fin)
                    obtenerTotalA(id_fin)
                    break;
            }
        }

        function cambiarPartidaA(select, id_fin) {
            let detalle_titulo
            let id_detalle
            switch (id_fin) {
                case 1:
                    detalle_titulo = $('#partidas_' + id_fin + contA1 + ' option:selected').attr(
                        'data-value-id')
                    partidas_select_a1[contA1] = detalle_titulo

                    id_detalle = $('#partidas_' + id_fin + contA1 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#a_detalle_' + id_fin + contA1).val(id_detalle)

                    $('#a-partida_codigo_' + id_fin + contA1).val(select.value)
                    $('#message_a_' + id_fin + contA1).attr('style', 'display:none')
                    $('#presupuesto-a_' + id_fin + contA1).removeAttr('readonly');
                    obtenerTotalA(id_fin)
                    break;
                case 2:
                    detalle_titulo = $('#partidas_' + id_fin + contA2 + ' option:selected').attr(
                        'data-value-id')
                    partidas_select_a2[contA2] = detalle_titulo

                    id_detalle = $('#partidas_' + id_fin + contA2 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#a_detalle_' + id_fin + contA2).val(id_detalle)

                    $('#a-partida_codigo_' + id_fin + contA2).val(select.value)
                    $('#message_a_' + id_fin + contA2).attr('style', 'display:none')
                    $('#presupuesto-a_' + id_fin + contA2).removeAttr('readonly');
                    obtenerTotalA(id_fin)
                    break;
                case 3:
                    detalle_titulo = $('#partidas_' + id_fin + contA3 + ' option:selected').attr(
                        'data-value-id')
                    partidas_select_a3[contA3] = detalle_titulo

                    id_detalle = $('#partidas_' + id_fin + contA3 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#a_detalle_' + id_fin + contA3).val(id_detalle)

                    $('#a-partida_codigo_' + id_fin + contA3).val(select.value)
                    $('#message_a_' + id_fin + contA3).attr('style', 'display:none')
                    $('#presupuesto-a_' + id_fin + contA3).removeAttr('readonly');
                    obtenerTotalA(id_fin)
                    break;
                case 4:
                    detalle_titulo = $('#partidas_' + id_fin + contA4 + ' option:selected').attr(
                        'data-value-id')
                    partidas_select_a4[contA4] = detalle_titulo

                    id_detalle = $('#partidas_' + id_fin + contA4 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#a_detalle_' + id_fin + contA4).val(id_detalle)

                    $('#a-partida_codigo_' + id_fin + contA4).val(select.value)
                    $('#message_a_' + id_fin + contA4).attr('style', 'display:none')
                    $('#presupuesto-a_' + id_fin + contA4).removeAttr('readonly');
                    obtenerTotalA(id_fin)
                    break;
            }
        }

        function obtenerTotalA(id_fin) {
            let total = 0.00
            let presupuesto = 0.00
            switch (id_fin) {
                case 1:
                    for (let i = 0; i <= contA1; i++) {
                        presupuesto = $('#presupuesto-a_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_a' + id_fin).val('0.00')
                    } else {
                        $('#total_a' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
                case 2:
                    for (let i = 0; i <= contA2; i++) {
                        presupuesto = $('#presupuesto-a_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_a' + id_fin).val('0.00')
                    } else {
                        $('#total_a' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
                case 3:
                    for (let i = 0; i <= contA3; i++) {
                        presupuesto = $('#presupuesto-a_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_a' + id_fin).val('0.00')
                    } else {
                        $('#total_a' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
                case 4:
                    for (let i = 0; i <= contA4; i++) {
                        presupuesto = $('#presupuesto-a_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total_a' + id_fin).val('0.00')
                    } else {
                        $('#total_a' + id_fin).val(total)
                    }
                    validarTotal(id_fin)
                    break;
            }
        }

        function validarMontoMaximo(id) {
            const monto = parseFloat($(id).val())
            const maximo = parseFloat($(id).attr('max'))
            if (monto > maximo) {
                $('#msg_pres_' + id.charAt(id.length - 2)).text('El monto supera el maximo presupuesto')
                return false
            } else {
                $('#msg_pres_' + id.charAt(id.length - 2)).text('')
                obtenerTotalDe(id.charAt(id.length - 2), 1)
                obtenerTotalA(id.charAt(id.length - 2), 1)
                return true
            }
        }

        function validarTotal(id_fin) {
            let totalDe = $('#total_de' + id_fin).val()
            let totalA = $('#total_a' + id_fin).val()

            if (totalA > totalDe) {
                $('#message_total_a' + id_fin).text('No se puede sobrepasar el total anterior')
            } else {
                $('#message_total_a' + id_fin).text('')
            }
        }

        function montoNumber(el) {
            $(el).val(function(index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
            });
        }

        function validarFormulario() {
            let form = $('#formularioMot').serialize();
            $.ajax({
                type: "POST",
                url: '{{ route('postModificacion') }}',
                data: form,
                success: function(response) {
                    // window.location.href = '{{ route('inicio') }}';
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    </script>
@endsection
