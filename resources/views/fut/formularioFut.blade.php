@extends('principal')
@section('titulo', 'Formulario FUT')
@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                {{-- <form class="row" id="formularioFut"> --}}
                <form class="row" method="POST" action="{{ route('postFormulario') }}" id="formularioFut">
                    @csrf
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="col-10 text-center fw-bold mt-3">
                                FORMULARIO DE INICIO/UNICO DE TRAMITE<br>
                                CONTRATACIóN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS - FUT
                            </h5>
                            <div class="col-2 form-group d-flex align-items-center justify-content-center">
                                <label for="nro_fut" class="form-label mt-3">
                                    <h5>FUT&nbsp;N°:&nbsp;</h5>
                                </label>
                                <input type="number" class="form-control" id="nro_fut"
                                    value="{{ $nro_fut ? $nro_fut->nro + 1 : 1 }}" name="nro_fut" required>
                            </div>
                            <input type="hidden" name="id_formulado" id="id_formulado" value="{{ $id_formulado }}">
                            <input type="hidden" name="gestiones_id" id="gestiones_id" value="{{ $gestiones_id }}">
                            <input type="hidden" name="id_conformulado" id="id_conformulado"
                                value="{{ $id_conformulado }}">
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div id="modificaciones">
                                <div class="modificacion row mb-3">
                                    <div class="col-3">
                                        <p>Area estrategica (F-1): </p>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="area" readonly>
                                        <input type="text" class="form-control" id="id_area" readonly>
                                    </div>
                                    <div class="col-6">
                                        <select name="area_estrategica" id="select-area" class="form-control"
                                            onchange="cambiarAreaEstrategica(this)" required>
                                            <option value="">[SELECCIONE AREA ESTRATEGICA]</option>
                                            @foreach ($areas_formulado as $ae)
                                                <option value="{{ $ae->codigo_areas_estrategicas }}"
                                                    data-id="{{ $ae->areEstrategica_id }}">
                                                    [{{ $ae->codigo_areas_estrategicas }}]
                                                    {{ strtoupper($ae->descripcion) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modificacion row mb-3">
                                    <div class="col-3">
                                        <p>Objetivo de Gestión (F-2): </p>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="objetivo" readonly>
                                    </div>
                                    <div class="col-6">
                                        <select name="objetivo_gestion" id="select-objetivoGestion" class="form-control"
                                            onchange="cambiarObjetivoGestion(this)" required>
                                            <option value="">[SELECCIONE OBJETIVO DE GESTION]</option>
                                        </select>
                                        <input type="hidden" name="og_id" id="og_id">
                                    </div>
                                </div>
                                <div class="modificacion row mb-3">
                                    <div class="col-3">
                                        <p>Tarea o Proyecto (F-3; F3A): </p>
                                    </div>
                                    <div class="col-3 d-flex align-items-center">
                                        <label for="">CODIGO:&nbsp; </label>
                                        <input type="text" class="form-control" id="tarea" readonly>
                                    </div>
                                    <div class="col-6">
                                        <select name="tarea_proyecto" id="select-tareaProyecto" class="form-control"
                                            onchange="cambiarTareaProyecto(this)" required>
                                            <option value="">[SELECCIONE TAREA O PROYECTO]</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modificacion row mb-3">
                                    <div class="col-3">
                                        <p>
                                            <b>Monto Programado POA Bs. :</b><br>
                                            (disponible a la fecha de tramite)
                                        </p>
                                    </div>
                                    <div class="col-2">
                                        <input type="number" class="form-control" min="0.00" step="0.01"
                                            id="monto_poa" name="monto_poa" onkeyup="montoNumber(this)"
                                            onchange="numeroATexto(this)" onload="numeroATexto(this)">
                                    </div>
                                    <div class="col-7">
                                        <input type="text" name="" id="monto_poa_literal" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div id="de-a">
                                <div class="item">
                                    <div class="form-group row">
                                        <div class="col-6 d-flex align-items-center">
                                            <b>Fuente de financiamiento</b>
                                        </div>
                                        <div class="col-3 d-flex align-items-center">
                                            <b>Monto habilitado para uso (Bs) :</b>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" id="monto_habilitado" name="monto_habilitado"
                                                class="form-control w-50" value="0" readonly>
                                            <span class="text-danger" id="monto_habilitado_error"></span>
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
                                <div class="col-3">
                                    <input type="date" class="form-control border-info" value="{{ $fecha_actual }}"
                                        name="fecha_actual" required>
                                </div>
                                <div class="col-3">
                                    <input type="time" class="form-control border-info" value="{{ $hora_actual }}"
                                        name="hora_actual" required>
                                </div>
                                <div class="col-2 d-flex align-items-center">
                                    Numero preventivo :
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control border-info" name="nro_preventivo"
                                        placeholder="Numero preventivo" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <a href="{{ route('listarFormulariosFut', $id_conformulado) }}"
                                    class="btn btn-dark me-3">Cancelar</a>
                                <button type="submit" class="btn btn-success" id="btn-submit">Guardar</button>
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
            $('#formularioFut').submit(function(e) {
                e.preventDefault();

                let monto_poa = parseFloat($('#monto_poa').val());
                let monto_habilitado = parseFloat($('#monto_habilitado').val());

                if (monto_habilitado > monto_poa) {
                    $('#monto_habilitado_error').text(
                        'El monto programado POA no puede ser mayor al monto habilitado para uso.'
                    );
                    return;
                } else {
                    if (monto_habilitado <= 0) {
                        $('#monto_habilitado_error').text(
                            'Debe habilitar un monto para uso.'
                        );
                        return;
                    } else {
                        $('#monto_habilitado_error').text('');
                    }
                }

                this.submit();
            });
        });

        function numeroATexto(numero) {
            const unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
            const especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete',
                'dieciocho', 'diecinueve'
            ];
            const decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta',
                'noventa'
            ];
            const centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos',
                'setecientos', 'ochocientos', 'novecientos'
            ];
            const miles = ['', 'mil', 'millón', 'mil millones', 'billón', 'mil billones', 'trillón', 'mil trillones'];
            if (numero.value === 0) {
                return 'cero';
            }
            let texto = '';
            let num = numero.value;
            for (let i = miles.length - 1; i >= 0; i--) {
                const divisor = Math.pow(10, i * 3);
                const segmento = Math.floor(num / divisor);
                num -= segmento * divisor;
                if (segmento) {
                    const centena = Math.floor(segmento / 100);
                    const decena = Math.floor((segmento % 100) / 10);
                    const unidad = segmento % 10;
                    if (centena) {
                        texto += centenas[centena] + ' ';
                    }
                    if (decena === 1) {
                        texto += especiales[unidad] + ' ';
                    } else {
                        texto += decenas[decena] + ' ';
                        texto += unidades[unidad] + ' ';
                    }
                    texto += miles[i] + ' ';
                }
            }
            if (texto.trim().toUpperCase()) {
                $('#monto_poa_literal').val('(SON ' + texto.trim().toUpperCase() + ' BOLIVIANOS 00/100)');
            } else {
                $('#monto_poa_literal').val('');
            }
        }

        function formatoProgmatica(prog) {
            var input = $(prog).val();
            var formattedInput = '';

            input = input.replace(/\D/g, '');

            if (input.length > 0) {
                formattedInput = input.substring(0, 2) + '-';
                if (input.length > 2) {
                    formattedInput += input.substring(2, 6) + '-';
                    if (input.length > 6) {
                        formattedInput += input.substring(6, 11);
                    }
                }
            }
            $(prog).val(formattedInput);
        }

        let fuenteFin = {}

        function cambiarAreaEstrategica(select) {
            $('#monto_habilitado').val(0);
            $('#financiamientos').empty()

            if (select.value == 0) {
                $('#area').val('')
                $('#id_area').val('')

                $('#select-objetivoGestion').empty()
                $('#select-objetivoGestion').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
                $('#objetivo').val('')
                $('#select-tareaProyecto').empty()
                $('#select-tareaProyecto').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
                $('#tarea').val('')

                $('#monto_poa').val('')
                $('#monto_poa').removeAttr('max')
                numeroATexto(0)
            } else {
                $('#area').val(select.value)
                $('#id_area').val(select.options[select.selectedIndex].getAttribute('data-id'))

                $('#select-tareaProyecto').empty()
                $('#select-tareaProyecto').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
                $('#tarea').val('')

                $.ajax({
                    url: "{{ route('getObjetivoInstitucionalFut') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_area: $('#id_area').val(),
                        id_formulado: $('#id_formulado').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#select-objetivoGestion').empty()
                        $('#select-objetivoGestion').append(
                            '<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')

                        response.forEach(element => {
                            $('#select-objetivoGestion').append(
                                `<option value="${element.codigo}" data-id="${element.id}" data-formulario2="${element.f2_id}">[${element.codigo}] ${element.descripcion}</option>`
                            )
                        })
                        // $('#select-objetivoGestion2').empty()
                        // $('#select-objetivoGestion2').append(
                        //     '<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        }

        function cambiarObjetivoGestion(select) {
            $('#monto_habilitado').val(0);
            $('#financiamientos').empty()

            if (select.value == 0) {
                $('#objetivo').val('')

                $('#select-tareaProyecto').empty()
                $('#select-tareaProyecto').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
                $('#tarea').val('')
            } else {
                $('#objetivo').val(`${$('#area').val()}.${select.value}`);
                const formulario2 = $('#select-objetivoGestion option:selected').attr('data-formulario2');
                const id = $('#select-objetivoGestion option:selected').attr('data-id');
                $('#og_id').val(id);
                $.ajax({
                    type: "POST",
                    url: "{{ route('getTareaProyectoFut') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        formulario2: formulario2,
                        objetivo: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        $('#select-tareaProyecto').empty();
                        $('#select-tareaProyecto').append(
                            '<option value="">[SELECCIONE TAREA O PROYECTO]</option>');
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

        function cambiarTareaProyecto(select) {
            $('#monto_habilitado').val(0);
            if (select.value == 0) {
                $('#tarea').val('')
            } else {
                $('#tarea').val(`${$('#objetivo').val()}.${select.value}`);
                const formulario5 = $('#select-tareaProyecto option:selected').attr('data-value')

                $.ajax({
                    type: "POST",
                    url: "{{ route('getSaldoFut') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        formulario5: formulario5
                    },
                    dataType: "JSON",
                    success: function(response) {
                        let montoAEDisp = 0
                        let montoAE = 0
                        let fin = 0 // Filtrar por fuente de financiamiento

                        $('#financiamientos').empty()

                        if (response.length > 0) {
                            response.forEach(element => {
                                if (fin == 0) {
                                    $('#financiamientos').append(
                                        `<div class="form-group row mt-3">
                                        <div class="col-3 d-flex align-items-center">
                                            Categoria Progmatica :
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" name="categoria_progmatica${element.tipo_financiamiento_id}"
                                            id="categoria_progmatica${element.tipo_financiamiento_id}" placeholder="11-1111-111" oninput="formatoProgmatica(this)" maxlength="11">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-3">
                                            Organismo financiador :
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="orgfin${element.tipo_financiamiento_id}" value="${element.codigo}" readonly>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" name="financiamiento_${element.tipo_financiamiento_id}"
                                                id="financiamiento_${element.tipo_financiamiento_id}"
                                                value="[${element.codigo}] ${element.descripcion}" readonly>
                                        </div>
                                        <div class="col-1 fw-bold">
                                            <label for="fin_${element.tipo_financiamiento_id}">Habilitar: </label>
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="fuente_${element.tipo_financiamiento_id}"
                                                name="fuente_${element.tipo_financiamiento_id}"
                                                data-value="${element.tipo_financiamiento_id}" data-value-id="${element.formulario5_id}"
                                                onchange="checkFinanciamiento(this, ${element.tipo_financiamiento_id})">
                                            <input type="hidden" name="formulario5_${element.tipo_financiamiento_id}" id="formulario5_${element.tipo_financiamiento_id}" value="${element.formulario5_id}">
                                        </div>
                                        <div class="col-2 fw-bold alert alert-primary" id="monto_fin${element.tipo_financiamiento_id}"></div>
                                    </div>
                                    <div id="finan_${element.tipo_financiamiento_id}"></div>`
                                    )
                                    fin = element.tipo_financiamiento_id
                                    montoAEDisp = parseFloat(element.total_presupuesto)
                                    montoAE += parseFloat(element.total_presupuesto)
                                    $('#monto_fin' + element.tipo_financiamiento_id).text(
                                        `Monto disponible: ${montoAEDisp} bs.`)

                                    $('#fuente_' + element.tipo_financiamiento_id).attr('data-monto',
                                        montoAEDisp);
                                } else {
                                    if (fin == element.tipo_financiamiento_id) {
                                        montoAEDisp += parseFloat(element.total_presupuesto)
                                        montoAE += parseFloat(element.total_presupuesto)
                                        $('#monto_fin' + element.tipo_financiamiento_id).text(
                                            `Monto disponible: ${montoAEDisp} bs.`)

                                        $('#fuente_' + element.tipo_financiamiento_id).attr(
                                            'data-monto',
                                            montoAEDisp);
                                    } else {
                                        $('#financiamientos').append(`<div class="form-group row mt-3">
                                        <div class="col-3 d-flex align-items-center">
                                            Categoria Progmatica :
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" name="categoria_progmatica${element.tipo_financiamiento_id}"
                                            id="categoria_progmatica${element.tipo_financiamiento_id}" placeholder="11-1111-111" oninput="formatoProgmatica(this)" maxlength="11">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-3">
                                            Organismo financiador :
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control" id="orgfin${element.tipo_financiamiento_id}" readonly value="${element.codigo}">
                                        </div>
                                        <div class="col-4">
                                            <input class="form-control" name="financiamiento_${element.tipo_financiamiento_id}"
                                                id="financiamiento_${element.tipo_financiamiento_id}"
                                                value="[${element.codigo}] ${element.descripcion}" readonly>
                                        </div>
                                        <div class="col-1 fw-bold">
                                            <label for="fin_${element.tipo_financiamiento_id}">Habilitar: </label>
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="fuente_${element.tipo_financiamiento_id}"
                                                name="fuente_${element.tipo_financiamiento_id}"
                                                data-value="${element.tipo_financiamiento_id}" data-value-id="${element.formulario5_id}" onchange="checkFinanciamiento(this, ${element.tipo_financiamiento_id})">
                                            <input type="hidden" name="formulario5_${element.tipo_financiamiento_id}" id="formulario5_${element.tipo_financiamiento_id}" value="${element.formulario5_id}">
                                        </div>
                                        <div class="col-2 fw-bold alert alert-primary" id="monto_fin${element.tipo_financiamiento_id}"></div>
                                    </div>
                                    <div id="finan_${element.tipo_financiamiento_id}"></div>`)
                                        fin = element.tipo_financiamiento_id
                                        montoAEDisp = parseFloat(element.total_presupuesto)
                                        montoAE += parseFloat(element.total_presupuesto)
                                        $('#monto_fin' + element.tipo_financiamiento_id).text(
                                            `Monto disponible: ${montoAEDisp} bs.`)

                                        $('#fuente_' + element.tipo_financiamiento_id).attr(
                                            'data-monto',
                                            montoAEDisp);
                                    }
                                }
                            })
                            $('#monto_poa').val(montoAE)
                            $('#monto_poa').attr('max', montoAE)
                            $('#monto_poa').trigger('change')
                        } else {
                            // Alerta de que no hay montos disponibles
                            $('#financiamientos').append(
                                `<br>
                                <div class="alert alert-warning" role="alert">
                                    <b>NO EXISTE MONTO DISPONIBLE PARA LA TAREA O PROYECTO SELECCIONADO.</b>
                                </div>`
                            )
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        }

        let partidas_global;
        let c_partidas_global = 0;

        function habilitarFinanciamiento(check, id_fin) {
            if (check.checked) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('getSaldoPartidasFut') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        caja_id: $('#id_caja' + id_fin).val(),
                        id_formulado: $('#id_formulado').val(),
                        gestiones_id: $('#gestiones_id').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        partidas_global = response
                        console.log(partidas_global);
                        $('#finan_' + id_fin).empty()
                        $('#finan_' + id_fin).append(`
                                        <div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}0">
                                            <div class="col-3 d-flex align-items-center">
                                                Partidas presupuestarias de descripcion :
                                            </div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="partida_codigo_${id_fin}0"
                                                    readonly name="partida_${id_fin}0" required>
                                                <input type="hidden" id="id_mbs${id_fin}0" name="id_mbs${id_fin}0">
                                                <input type="hidden" id="detalle_${id_fin}0"  name="detalle_${id_fin}0">
                                            </div>
                                            <div class="col-4">
                                                <select class="partidas_formulado_${id_fin}0 form-control"
                                                    onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}0">
                                                    <option value="">[SELECCIONE OPCION]</option>
                                                </select>
                                                <span class="text-danger" id="message_${id_fin}0"
                                                    style="display:none;font-size:12px">Debe
                                                    seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <span class="text-info" style="font-size:12px">Monto disponible: <span
                                                        id="monto_max_${id_fin}0"></span>&nbsp;bs</span>
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01"
                                                    min="0.00" placeholder="0.00" id="presupuesto_${id_fin}0"
                                                    onchange="validarMontoMaximo('#presupuesto_${id_fin}0')" readonly name="partida_monto_${id_fin}0" required>
                                                <span class="text-danger" id="msg_pres_${id_fin}0" style="font-size:12px"></span>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="crearPartida(${id_fin})"
                                                    id="btn-crear${id_fin}">Agregar</button>
                                            </div>
                                        </div>`)
                        $('#finan_' + id_fin).after(`<div class="mt-3">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8"></div>
                                            <div class="col-1">TOTAL: </div>
                                            <div class="col-2">
                                                <input type="hidden" name="cont${id_fin}" id="cont${id_fin}" value="0">
                                                <input type="number" class="form-control border-primary" onkeyup="montoNumber(this)"
                                                    step="0.01" min="0.00" placeholder="0.00" readonly
                                                    id="total${id_fin}" name="total${id_fin}" onchange="obtenerTotal(${id_fin})">
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                            </div>
                                        </div>
                                    </div>`)

                        $('.partidas_formulado_' + id_fin + '0').empty()
                        $('.partidas_formulado_' + id_fin + '0').append(
                            '<option value="">[SELECCIONE OPCION]</option>')
                        let monto_totalDisp = 0
                        response[0].forEach(element => {
                            $('.partidas_formulado_' + id_fin + '0').append(
                                `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                            )
                            c_partidas_global++
                            monto_totalDisp += parseFloat(element.total_presupuesto)
                        });
                        response[1].forEach(element => {
                            $('.partidas_formulado_' + id_fin + '0').append(
                                `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                            )
                            c_partidas_global++
                            monto_totalDisp += parseFloat(element.total_presupuesto)
                        });
                        response[2].forEach(element => {
                            $('.partidas_formulado_' + id_fin + '0').append(
                                `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                            )
                            c_partidas_global++
                            monto_totalDisp += parseFloat(element.total_presupuesto)
                        });
                        $('#monto_max_' + id_fin + '0').text(monto_totalDisp);
                        $('.partidas_formulado_' + id_fin + '0').select2();
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            }
        }

        function checkFinanciamiento(check, id_fin) {
            let monto = parseFloat($('#monto_habilitado').val());

            if (check.checked) {
                $('#monto_habilitado').val(monto + parseFloat($(check).data('monto')));
                // $('#categoria_progmatica' + id_fin).attr('required', 'true');
            } else {
                $('#monto_habilitado').val(monto - parseFloat($(check).data('monto')));
                // $('#categoria_progmatica' + id_fin).removeAttr('required');
            }
        }

        let partidas_select1 = []
        let partidas_select2 = []
        let partidas_select3 = []
        let partidas_select4 = []
        let cont1 = 0;
        let cont2 = 0;
        let cont3 = 0;
        let cont4 = 0;

        function quitarPartida(id, id_fin) {
            switch (id_fin) {
                case 1:
                    $('#ppd_' + id_fin + id).remove()
                    cont1--
                    $('#btn-crear' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (cont1)).removeAttr('disabled')
                    $('#presupuesto_' + id_fin + cont1).removeAttr('readonly');
                    $('#btn-eliminar_' + id_fin + (cont1)).attr('style', 'display:block')
                    $('#cont1').val(cont1)
                    partidas_select1.pop()
                    obtenerTotal(id_fin)
                    break;
                case 2:
                    $('#ppd_' + id_fin + id).remove()
                    cont2--
                    $('#btn-crear' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (cont2)).removeAttr('disabled')
                    $('#presupuesto_' + id_fin + cont2).removeAttr('readonly');
                    $('#btn-eliminar_' + id_fin + (cont2)).attr('style', 'display:block')
                    $('#cont2').val(cont2)
                    partidas_select2.pop()
                    obtenerTotal(id_fin)
                    break;
                case 3:
                    $('#ppd_' + id_fin + id).remove()
                    cont3--
                    $('#btn-crear' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (cont3)).removeAttr('disabled')
                    $('#presupuesto_' + id_fin + cont3).removeAttr('readonly');
                    $('#btn-eliminar_' + id_fin + (cont3)).attr('style', 'display:block')
                    $('#cont3').val(cont3)
                    partidas_select3.pop()
                    obtenerTotal(id_fin)
                    break;
                case 4:
                    $('#ppd_' + id_fin + id).remove()
                    cont4--
                    $('#btn-crear' + id_fin).attr('style', 'display:block')
                    $('#partidas_formulado_' + id_fin + (cont4)).removeAttr('disabled')
                    $('#presupuesto_' + id_fin + cont4).removeAttr('readonly');
                    $('#btn-eliminar_' + id_fin + (cont4)).attr('style', 'display:block')
                    $('#cont4').val(cont4)
                    partidas_select4.pop()
                    obtenerTotal(id_fin)
                    break;
            }
        }

        function cambiarPartida(select, id_fin) {
            let presupuesto_total
            let id_mbs
            let detalle
            let titulo
            switch (id_fin) {
                case 1:
                    $('#partida_codigo_' + id_fin + cont1).val(select.value)
                    $('#message_' + id_fin + cont1).attr('style', 'display:none')

                    titulo = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
                        'data-text')
                    partidas_select1[cont1] = titulo

                    presupuesto_total = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
                        'data-value2')
                    $('#presupuesto_' + id_fin + cont1).val(presupuesto_total);
                    $('#monto_max_' + id_fin + cont1).text(presupuesto_total);

                    id_mbs = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
                        'data-value-id')
                    $('#id_mbs' + id_fin + cont1).val(id_mbs)

                    detalle = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#detalle_' + id_fin + cont1).val(detalle)

                    $('#presupuesto_' + id_fin + cont1).removeAttr('readonly');
                    $('#presupuesto_' + id_fin + cont1).attr('max', presupuesto_total);
                    obtenerTotal(id_fin)
                    console.log(partidas_select1);
                    break;
                case 2:
                    $('#partida_codigo_' + id_fin + cont2).val(select.value)
                    $('#message_' + id_fin + cont2).attr('style', 'display:none')

                    titulo = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
                        'data-text')
                    partidas_select2[cont2] = titulo

                    presupuesto_total = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
                        'data-value2')
                    $('#presupuesto_' + id_fin + cont2).val(presupuesto_total);
                    $('#monto_max_' + id_fin + cont2).text(presupuesto_total);

                    id_mbs = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
                        'data-value-id')
                    $('#id_mbs' + id_fin + cont2).val(id_mbs)

                    detalle = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#detalle_' + id_fin + cont2).val(detalle)

                    $('#presupuesto_' + id_fin + cont2).removeAttr('readonly');
                    $('#presupuesto_' + id_fin + cont2).attr('max', presupuesto_total);
                    obtenerTotal(id_fin)
                    console.log(partidas_select2);
                    break;
                case 3:
                    $('#partida_codigo_' + id_fin + cont3).val(select.value)
                    $('#message_' + id_fin + cont3).attr('style', 'display:none')

                    titulo = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
                        'data-text')
                    partidas_select3[cont3] = titulo

                    presupuesto_total = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
                        'data-value3')
                    $('#presupuesto_' + id_fin + cont3).val(presupuesto_total);
                    $('#monto_max_' + id_fin + cont3).text(presupuesto_total);

                    id_mbs = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
                        'data-value-id')
                    $('#id_mbs' + id_fin + cont3).val(id_mbs)

                    detalle = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#detalle_' + id_fin + cont3).val(detalle)

                    $('#presupuesto_' + id_fin + cont3).removeAttr('readonly');
                    $('#presupuesto_' + id_fin + cont3).attr('max', presupuesto_total);
                    obtenerTotal(id_fin)
                    console.log(partidas_select3);
                    break;
                case 4:
                    $('#partida_codigo_' + id_fin + cont4).val(select.value)
                    $('#message_' + id_fin + cont4).attr('style', 'display:none')

                    titulo = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
                        'data-text')
                    partidas_select4[cont4] = titulo

                    presupuesto_total = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
                        'data-value4')
                    $('#presupuesto_' + id_fin + cont4).val(presupuesto_total);
                    $('#monto_max_' + id_fin + cont4).text(presupuesto_total);

                    id_mbs = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
                        'data-value-id')
                    $('#id_mbs' + id_fin + cont4).val(id_mbs)

                    detalle = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
                        'data-id-detalle')
                    $('#detalle_' + id_fin + cont4).val(detalle)

                    $('#presupuesto_' + id_fin + cont4).removeAttr('readonly');
                    $('#presupuesto_' + id_fin + cont4).attr('max', presupuesto_total);
                    obtenerTotal(id_fin)
                    console.log(partidas_select4);
                    break;
            }
        }

        function obtenerTotal(id_fin) {
            let total = 0.00
            let presupuesto = 0.00
            switch (id_fin) {
                case 1:
                    for (let i = 0; i <= cont1; i++) {
                        presupuesto = $('#presupuesto_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total' + id_fin).val('0.00')
                    } else {
                        $('#total' + id_fin).val(total)
                    }
                    break;
                case 2:
                    for (let i = 0; i <= cont2; i++) {
                        presupuesto = $('#presupuesto_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total' + id_fin).val('0.00')
                    } else {
                        $('#total' + id_fin).val(total)
                    }
                    break;
                case 3:
                    for (let i = 0; i <= cont3; i++) {
                        presupuesto = $('#presupuesto_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total' + id_fin).val('0.00')
                    } else {
                        $('#total' + id_fin).val(total)
                    }
                    break;
                case 4:
                    for (let i = 0; i <= cont4; i++) {
                        presupuesto = $('#presupuesto_' + id_fin + i).val()
                        total = total + parseFloat(presupuesto)
                    }
                    if (total == NaN || total == 0 || total == null) {
                        $('#total' + id_fin).val('0.00')
                    } else {
                        $('#total' + id_fin).val(total)
                    }
                    break;
            }
        }

        function crearPartida(id_fin) {
            switch (id_fin) {
                case 1:
                    if (validarMontoMaximo('#presupuesto_' + id_fin + cont1)) {
                        if (c_partidas_global > cont1 && $('#partida_codigo_' + id_fin + cont1).val() != '') {
                            cont1++
                            if (c_partidas_global - 1 == cont1) {
                                $('#btn-crear' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont1}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont1}" readonly name="partida_${id_fin}${cont1}" required>
                                                <input type="hidden" name="id_mbs${id_fin}${cont1}" id="id_mbs${id_fin}${cont1}">
                                                <input type="hidden" name="detalle_${id_fin}${cont1}" id="detalle_${id_fin}${cont1}">
                                            </div>
                                            <div class="col-4">
                                                <select class="partidas_formulado_${id_fin}${cont1} form-control"
                                                    onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont1}">
                                                    <option value="">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select1.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select1.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select1.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_${id_fin}${cont1}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <span class="text-info" style="font-size:12px">Monto total disponible: <span
                                                        id="monto_max_${id_fin}${cont1}"></span>&nbsp;bs</span>
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto_${id_fin}${cont1}"
                                                    onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont1}')" readonly name="partida_monto_${id_fin}${cont1}" required>
                                                <span class="text-danger" id="msg_pres_${id_fin}${cont1}" style="font-size:12px"></span>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont1}', ${id_fin})" id="btn-eliminar_${id_fin}${cont1}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#finan_' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + cont1).select2()

                            $('#partidas_formulado_' + id_fin + (cont1 - 1)).attr('disabled', true)
                            $('#btn-eliminar_' + id_fin + (cont1 - 1)).attr('style', 'display:none')
                            $('#presupuesto_' + id_fin + (cont1 - 1)).attr('readonly', 'readonly')
                            $('#message_' + id_fin + cont1).attr('style', 'display:none')
                            $('#cont1').val(cont1)
                        } else {
                            $('#message_' + id_fin + cont1).attr('style', 'display:block')
                        }
                    } else {
                        alert('Error')
                    }
                    break;
                case 2:
                    if (validarMontoMaximo('#presupuesto_' + id_fin + cont2)) {
                        if (c_partidas_global > cont2 && $('#partida_codigo_' + id_fin + cont2).val() != '') {
                            cont2++
                            if (c_partidas_global - 1 == cont2) {
                                $('#btn-crear' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont2}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont2}" readonly name="partida_${id_fin}${cont2}" required>
                                                <input type="hidden" name="id_mbs${id_fin}${cont2}" id="id_mbs${id_fin}${cont2}">
                                                <input type="hidden" name="detalle_${id_fin}${cont2}" id="detalle_${id_fin}${cont2}">
                                            </div>
                                            <div class="col-4">
                                                <select class="partidas_formulado_${id_fin}${cont2} form-control"
                                                    onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont2}">
                                                    <option value="">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select2.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select2.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select2.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_${id_fin}${cont2}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <span class="text-info" style="font-size:12px">Monto total disponible: <span
                                                        id="monto_max_${id_fin}${cont2}"></span>&nbsp;bs</span>
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto_${id_fin}${cont2}"
                                                    onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont2}')" readonly name="partida_monto_${id_fin}${cont2}" required>
                                                <span class="text-danger" id="msg_pres_${id_fin}${cont2}" style="font-size:12px"></span>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont2}', ${id_fin})" id="btn-eliminar_${id_fin}${cont2}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#finan_' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + cont2).select2()

                            $('#partidas_formulado_' + id_fin + (cont2 - 1)).attr('disabled', true)
                            $('#btn-eliminar_' + id_fin + (cont2 - 1)).attr('style', 'display:none')
                            $('#presupuesto_' + id_fin + (cont2 - 1)).attr('readonly', 'readonly')
                            $('#message_' + id_fin + cont2).attr('style', 'display:none')
                            $('#cont2').val(cont2)
                        } else {
                            $('#message_' + id_fin + cont2).attr('style', 'display:block')
                        }
                    } else {
                        alert('Error')
                    }
                    break;
                case 3:
                    if (validarMontoMaximo('#presupuesto_' + id_fin + cont3)) {
                        if (c_partidas_global > cont3 && $('#partida_codigo_' + id_fin + cont3).val() != '') {
                            cont3++
                            if (c_partidas_global - 1 == cont3) {
                                $('#btn-crear' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont3}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont3}" readonly name="partida_${id_fin}${cont3}" required>
                                                <input type="hidden" name="id_mbs${id_fin}${cont3}" id="id_mbs${id_fin}${cont3}">
                                                <input type="hidden" name="detalle_${id_fin}${cont3}" id="detalle_${id_fin}${cont3}">
                                            </div>
                                            <div class="col-4">
                                                <select class="partidas_formulado_${id_fin}${cont3} form-control"
                                                    onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont3}">
                                                    <option value="">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select3.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select3.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select3.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_${id_fin}${cont3}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <span class="text-info" style="font-size:12px">Monto total disponible: <span
                                                        id="monto_max_${id_fin}${cont3}"></span>&nbsp;bs</span>
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto_${id_fin}${cont3}"
                                                    onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont3}')" readonly name="partida_monto_${id_fin}${cont3}" required>
                                                <span class="text-danger" id="msg_pres_${id_fin}${cont3}" style="font-size:12px"></span>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont3}', ${id_fin})" id="btn-eliminar_${id_fin}${cont3}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#finan_' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + cont3).select2()

                            $('#partidas_formulado_' + id_fin + (cont3 - 1)).attr('disabled', true)
                            $('#btn-eliminar_' + id_fin + (cont3 - 1)).attr('style', 'display:none')
                            $('#presupuesto_' + id_fin + (cont3 - 1)).attr('readonly', 'readonly')
                            $('#message_' + id_fin + cont3).attr('style', 'display:none')
                            $('#cont3').val(cont3)
                        } else {
                            $('#message_' + id_fin + cont3).attr('style', 'display:block')
                        }
                    } else {
                        alert('Error')
                    }
                    break;
                case 4:
                    if (validarMontoMaximo('#presupuesto_' + id_fin + cont4)) {
                        if (c_partidas_global > cont4 && $('#partida_codigo_' + id_fin + cont4).val() != '') {
                            cont4++
                            if (c_partidas_global - 1 == cont4) {
                                $('#btn-crear' + id_fin).attr('style', 'display:none')
                            }
                            let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont4}">
                                            <div class="col-3"></div>
                                            <div class="col-2">
                                                <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont4}" readonly name="partida_${id_fin}${cont4}" required>
                                                <input type="hidden" name="id_mbs${id_fin}${cont4}" id="id_mbs${id_fin}${cont4}">
                                                <input type="hidden" name="detalle_${id_fin}${cont4}" id="detalle_${id_fin}${cont4}">
                                            </div>
                                            <div class="col-4">
                                                <select class="partidas_formulado_${id_fin}${cont4} form-control"
                                                    onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont4}">
                                                    <option value="">[SELECCIONE OPCION]</option>`
                            partidas_global[0].forEach(element => {
                                if (!partidas_select4.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[1].forEach(element => {
                                if (!partidas_select4.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            partidas_global[2].forEach(element => {
                                if (!partidas_select4.includes(element.titulo_detalle)) {
                                    newOption = newOption +
                                        `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}">[${element.partida}] ${element.titulo_detalle}</option>`
                                }
                            })
                            newOption = newOption + `</select>
                                                <span class="text-danger" id="message_${id_fin}${cont4}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
                                            </div>
                                            <div class="col-2">
                                                <span class="text-info" style="font-size:12px">Monto total disponible: <span
                                                        id="monto_max_${id_fin}${cont4}"></span>&nbsp;bs</span>
                                                <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
                                                    placeholder="0.00" id="presupuesto_${id_fin}${cont4}"
                                                    onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont4}')" readonly name="partida_monto_${id_fin}${cont4}" required>
                                                <span class="text-danger" id="msg_pres_${id_fin}${cont4}" style="font-size:12px"></span>
                                            </div>
                                            <div class="col-1 d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont4}', ${id_fin})" id="btn-eliminar_${id_fin}${cont4}">Quitar</button>
                                            </div>
                                        </div>`
                            $('#finan_' + id_fin).append(newOption);
                            $('.partidas_formulado_' + id_fin + cont4).select2()

                            $('#partidas_formulado_' + id_fin + (cont4 - 1)).attr('disabled', true)
                            $('#btn-eliminar_' + id_fin + (cont4 - 1)).attr('style', 'display:none')
                            $('#presupuesto_' + id_fin + (cont4 - 1)).attr('readonly', 'readonly')
                            $('#message_' + id_fin + cont4).attr('style', 'display:none')
                            $('#cont4').val(cont4)
                        } else {
                            $('#message_' + id_fin + cont4).attr('style', 'display:block')
                        }
                    } else {
                        alert('Error')
                    }
                    break;
            }
        }

        function validarMontoMaximo(id) {
            const monto = parseFloat($(id).val())
            const maximo = parseFloat($(id).attr('max'))
            if (monto > maximo) {
                $('#msg_pres_' + id.charAt(id.length - 1)).text('El monto supera el maximo presupuesto')
                return false
            } else {
                $('#msg_pres_' + id.charAt(id.length - 1)).text('')
                obtenerTotal(id.charAt(id.length - 2, 1))
                return true
            }
        }



        function montoNumber(el) {
            $(el).val(function(index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
            });
        }
    </script>
@endsection
