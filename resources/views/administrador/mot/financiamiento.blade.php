@extends('principal')
@section('titulo', 'Formulario MOT')
@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                @if (session('message'))
                                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                        <strong>{{ session('message') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @php
                                    $total_total = 0;
                                    foreach ($mot->total as $value) {
                                        if ($value->descripcion == 'MODIFICA') {
                                            $total_total += $value->partida_monto;
                                        }
                                    }
                                @endphp
                                <div class="alert fs-6 alert-info">Monto disponible para cambios:
                                    {{ $mot->tp_a_importe - $total_total }}&nbsp;bs.</div>
                                <input type="hidden" id="total_total" value="{{ $mot->tp_a_importe - $total_total }}">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Organismo financiador</th>
                                            <th>Accion</th>
                                            <th>Partidas</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($financiamientos) > 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($financiamientos as $key => $item)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $item->of->descripcion }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $item->accion == 'DE' ? 'danger' : 'success' }} fs-6">
                                                            {{ $item->accion }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if (count($item->mov) > 0)
                                                            @php
                                                                $total = 0;
                                                            @endphp
                                                            <ul>
                                                                @foreach ($item->mov as $mov)
                                                                    <li>
                                                                        <span class="fw-bold">[{{ $mov->partida_codigo }}]</span>
                                                                        <span class="badge bg-outline-info">
                                                                            {{ $mov->partida_monto }}&nbsp;bs.
                                                                        </span>
                                                                    </li>
                                                                    @php
                                                                        $total += $mov->partida_monto;
                                                                    @endphp
                                                                @endforeach
                                                            </ul>
                                                            @if ($item->accion == 'DE')
                                                                @php
                                                                    $total2 = $total;
                                                                    foreach (
                                                                        $financiamientos[$key + 1]->mov
                                                                        as $value
                                                                    ) {
                                                                        $total2 -= $value->partida_monto;
                                                                    }
                                                                @endphp
                                                                <p class="badge bg-outline-danger fs-6">
                                                                    Total disponible: {{ $total }}&nbsp;bs.
                                                                </p>
                                                                <input type="hidden"
                                                                    id="monto_disp_{{ $item->id_mot_pp }}"
                                                                    value="{{ $total2 }}">
                                                            @else
                                                                <p
                                                                    class="badge bg-outline-{{ $total2 == 0 ? 'success' : 'warning' }} fs-6">
                                                                    Total usado: {{ $total }}&nbsp;bs.
                                                                </p>
                                                                <input type="hidden"
                                                                    id="monto_disp_{{ $item->id_mot_pp }}"
                                                                    value="{{ $total }}">
                                                            @endif
                                                        @else
                                                            Sin cambios
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#partidas{{ $item->accion }}"
                                                            onclick="getPartidas{{ $item->accion }}({{ $item->formulario5 }} ,{{ $item->organismo_financiador }}, {{ $item->id_mot_pp }})">
                                                            Agregar
                                                        </button>
                                                        {{-- <button class="btn btn-success">
                                                            <i class="ri-file-excel-line"></i>&nbsp;EXCEL
                                                        </button> --}}
                                                    </td>
                                                    {{-- <td>
                                                        <button class="btn btn-sm btn-outline-warning"><i
                                                                class="ri-pencil-line"></i>&nbsp;&nbsp;Editar</button>
                                                    </td> --}}
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td></td>
                                                <td>TOTAL: </td>
                                                <td>
                                                    @php
                                                        $total3 = 0;
                                                        $total4 = 0;
                                                        foreach ($financiamientos as $item) {
                                                            foreach ($item->mov as $value) {
                                                                if ($value->descripcion == 'MODIFICA') {
                                                                    $total3 += $value->partida_monto;
                                                                } else {
                                                                    $total4 += $value->partida_monto;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <span
                                                        class="badge fs-6 bg-{{ $total3 == $total4 ? 'success' : 'warning' }}">Total:
                                                        {{ $total4 }}&nbsp;bs.</span>
                                                </td>
                                                <td></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" align="center">
                                                    Ninguna modificacion presupuestaria
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="modal fade" id="partidasDE" tabindex="-1" aria-labelledby="partidasDELabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('postPartidaDe') }}" method="post" id="agregar_de">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="partidasDELabel1">Agregar cambio</h6>
                                                    <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>DE</h6>
                                                    <div class="form-group">
                                                        <label for="partida_de" class="form-label">Partida
                                                            presupuestaria</label>
                                                        <select name="partida_presupuestaria_de" id="partida_de"
                                                            class="form-control partidas_de select2_mot_de" onchange="selectPartida(this)"
                                                            required>
                                                            <option value="">[SELECCIONE OPCION]</option>
                                                        </select>
                                                        <input type="hidden" id="id_mot_pp" name="id_mot_pp" required>
                                                        <input type="hidden" id="id_detalle" name="id_detalle" required>
                                                        <input type="hidden" id="partida_codigo" name="partida_codigo"
                                                            required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="monto_de" class="form-label">Monto</label>
                                                        <input type="number" class="monto_number form-control"
                                                            id="monto_de" name="monto_de" onkeyup="montoNumber(this)"
                                                            step="0.01" min="0.00" required>
                                                        <span class="text-danger" id="monto_max"></span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-dark"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary" id="btn-de"
                                                        disabled>Agregar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal fade" id="partidasA" tabindex="-1" aria-labelledby="partidasALabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('postPartidaA') }}" method="post">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="partidasALabel1">Agregar cambio</h6>
                                                    <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>A</h6>
                                                    <div class="alert alert-danger fs-6">Monto disponible: <span
                                                            id="monto_disp" class="fw-bold"></span>&nbsp;bs.</div>
                                                    <input type="hidden" id="total_disp">
                                                    <div class="form-group">
                                                        <label for="partida" class="form-label">Partida
                                                            presupuestaria</label>
                                                        <select name="id_detalle" id="partida_a"
                                                            class="form-control partidas_a select2_mot_a"
                                                            onchange="selectPartidaA(this)" required>
                                                            <option value="">[SELECCIONE OPCION]</option>
                                                        </select>
                                                        <input type="hidden" name="id_mot_pp_a" id="id_mot_pp_a"
                                                            required>
                                                        <input type="hidden" name="partida_codigo_a"
                                                            id="partida_codigo_a" required>
                                                        <input type="hidden" name="formulario5" id="formulario5"
                                                            required>
                                                        <input type="hidden" name="financiamiento" id="financiamiento"
                                                            required>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-6 form-group">
                                                            <label for="medida" class="form-label">Medida</label>
                                                            <select name="medida" id="medida" class="form-control"
                                                                required>
                                                                <option value="0">[SELECCIONE MEDIDA]</option>
                                                                @foreach ($medidas as $med)
                                                                    <option value="{{ $med->id }}">
                                                                        {{ $med->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6 form-group">
                                                            <label for="cantidad" class="form-label">Cantidad</label>
                                                            <input type="number" class="form-control" id="cantidad"
                                                                name="cantidad" min="0" value="0"
                                                                onchange="eventoSumar()" required>
                                                        </div>
                                                        <div class="col-6 form-group mt-3">
                                                            <label for="precio" class="form-label">Precio</label>
                                                            <input type="number" class="form-control" id="precio"
                                                                name="precio_unitario" onkeyup="montoNumber(this)"
                                                                step="0.01" min="0.00" onchange="sumarTotal(this)"
                                                                required>
                                                        </div>
                                                        <div class="col-6 form-group mt-3">
                                                            <label for="total" class="form-label">Total</label>
                                                            <input type="number" class="form-control monto_number"
                                                                id="total" name="total_presupuesto" readonly required>
                                                            <span class="text-danger" id="total_error"></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="fecha_requerida" class="form-label">Fecha
                                                            requerida</label>
                                                        <input type="date" class="form-control monto_number"
                                                            id="fecha_requerida" name="fecha_requerida" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-dark"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary" id="btn-a"
                                                        disabled>Agregar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <a href="{{ route('listarFormularios', $configuracion->id) }}"
                                    class="btn btn-dark">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function montoNumber(el) {
            $(el).val(function(index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
            });
        }

        function selectPartida(partida_de) {
            const max = $('#partida_de option:selected').attr('data-max')
            const total = $('#total_total').val()

            if (max <= total) {
                $('#monto_de').val(max);
                $('#monto_de').attr('max', max);
                $('#monto_max').text('Monto maximo: ' + max + ' bs.')
            } else {
                $('#monto_de').val(total);
                $('#monto_de').attr('max', total);
                $('#monto_max').text('Monto maximo: ' + total + ' bs.')
            }
            if (total > 0) {
                $('#btn-de').removeAttr('disabled');
            } else {
                $('#btn-de').attr('disabled', 'disabled');
            }
            $('#partida_codigo').val($('#partida_de option:selected').attr('data-partida'))
            $('#id_detalle').val($('#partida_de option:selected').attr('data-detalle'))
        }

        function getPartidasDE(formulario5, financiamiento, id_mot_pp) {
            $('#id_mot_pp').val(id_mot_pp);
            $('#monto_max').text('')

            $.ajax({
                type: "POST",
                url: "{{ route('getPartidasDe') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    formulario5: formulario5,
                    financiamiento: financiamiento
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    $('.partidas_de').empty()
                    $('.partidas_de').append(
                        '<option value="">[SELECCIONE OPCION]</option>')
                    response[0].forEach(element => {
                        $('.partidas_de').append(
                            `<option value="${element.id}" data-max="${element.total_presupuesto}" data-partida="${element.partida}" data-detalle="${element.id_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                        )
                    })
                    response[1].forEach(element => {
                        $('.partidas_de').append(
                            `<option value="${element.id}" data-max="${element.total_presupuesto}" data-partida="${element.partida}" data-detalle="${element.id_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                        )
                    })
                    response[2].forEach(element => {
                        $('.partidas_de').append(
                            `<option value="${element.id}" data-max="${element.total_presupuesto}" data-partida="${element.partida}" data-detalle="${element.id_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
                        )
                    })
                    // $('.partidas_de').select2({
                    //     dropdownParent: $('#partidasDE')
                    // });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function selectPartidaA(partida_a) {
            $('#partida_codigo_a').val($('#partida_a option:selected').attr('data-partida'))
        }

        function getPartidasA(formulario5, financiamiento, id_mot_pp) {
            const monto = $('#monto_disp_' + (id_mot_pp - 1)).val()
            if (monto) {
                $('#monto_disp').text(monto)
                $('#total_disp').val(monto)
            } else {
                $('#monto_disp').text(0)
                $('#total_disp').val(0)
            }

            $('#formulario5').val(formulario5);
            $('#financiamiento').val(financiamiento);
            $('#id_mot_pp_a').val(id_mot_pp);
            $.ajax({
                type: "POST",
                url: "{{ route('getPartidasA') }}",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    $('#partida_a').empty()
                    $('#partida_a').append(
                        '<option value="">[SELECCIONE OPCION]</option>')
                    response[0].forEach(element => {
                        $('#partida_a').append(
                            `<option value="${element.id}" data-partida="${element.partida}">[${element.partida}] ${element.titulo_detalle}</option>`
                        )
                    })
                    response[1].forEach(element => {
                        $('#partida_a').append(
                            `<option value="${element.id}" data-partida="${element.partida}">[${element.partida}] ${element.titulo_detalle}</option>`
                        )
                    })
                    response[2].forEach(element => {
                        $('#partida_a').append(
                            `<option value="${element.id}" data-partida="${element.partida}">[${element.partida}] ${element.titulo_detalle}</option>`
                        )
                    })
                    // $('.partidas_a').select2({
                    //     dropdownParent: $('#partidasA')
                    // });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function eventoSumar() {
            $('#precio').trigger('change');
        }

        function sumarTotal(monto) {
            const total = monto.value * $('#cantidad').val()
            $('#total').val(total);
            if (total > $('#total_disp').val()) {
                $('#total_error').text('El monto sobrepasa al maximo presupuesto.')
                $('#btn-a').attr('disabled', 'disabled');
            } else {
                $('#total_error').text('')
                $('#btn-a').removeAttr('disabled');
            }
        }

        motDe_select2('#partidasDe');
        motA_select2('#partidasA');
    </script>
@endsection
