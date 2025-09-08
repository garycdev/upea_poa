@extends('principal')

@section('titulo', 'Formulario FUT')

@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h5 class="page-title my-auto">
                        {{ $configuracion->descripcion }}<br>
                        GESTION: {{ $configuracion->gestion }}<br>
                        {{ Auth::user()->unidad_carrera->nombre_completo }}
                        <br>CODIGO: {{ $configuracion->codigo }}
                        <br>FUT N°: {{ $fut->id_fut }}
                    </h5>
                </div>

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
                                    foreach ($fut->total as $value) {
                                        $total_total += $value->partida_monto;
                                    }
                                @endphp
                                <div class="alert fs-6 alert-info">Monto disponible para cambios:
                                    {{ $fut->importe - $total_total }}&nbsp;bs.</div>
                                <input type="hidden" id="total_total" value="{{ $fut->importe - $total_total }}">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Organismo financiador</th>
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
                                                        @if (count($item->mov) > 0)
                                                            @php
                                                                $total = 0;
                                                            @endphp
                                                            <table class="table table-hovered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Partida</th>
                                                                        <th>Monto</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    @foreach ($item->mov as $mov)
                                                                        <tr>
                                                                            <td>[{{ $mov->partida_codigo }}]
                                                                                {{ $mov->partida_nombre }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $mov->partida_monto }}&nbsp;bs.
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr style="background: #77ff95">
                                                                        <td class="fw-bold" align="right">Total</td>
                                                                        <td class="fw-bold">
                                                                            @php
                                                                                $total += $mov->partida_monto;
                                                                            @endphp
                                                                            {{ $total }}&nbsp;bs.
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            {{-- <ul>
                                                                @foreach ($item->mov as $mov)
                                                                    <li>
                                                                        <span
                                                                            class="fw-bold">[{{ $mov->partida_codigo }}]</span>
                                                                        <span class="badge bg-dark">
                                                                            {{ $mov->partida_monto }}&nbsp;bs.
                                                                        </span>
                                                                    </li>
                                                                    @php
                                                                        $total += $mov->partida_monto;
                                                                    @endphp
                                                                @endforeach
                                                            </ul>
                                                            <p class="badge bg-info fs-6">
                                                                Total compra: {{ $total }}&nbsp;bs.
                                                            </p> --}}
                                                        @else
                                                            Sin cambios
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#partidas"
                                                            onclick="getPartidas({{ $item->formulario5 }} ,{{ $item->organismo_financiador }}, {{ $item->id_fut_pp }})">
                                                            Agregar
                                                        </button>
                                                        {{-- <button class="btn btn-success">
                                                            <i class="ri-file-excel-line"></i>&nbsp;EXCEL
                                                        </button> --}}
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>TOTAL: </td>
                                                <td>
                                                    @php
                                                        $total3 = 0;
                                                        foreach ($financiamientos as $item) {
                                                            foreach ($item->mov as $value) {
                                                                $total3 += $value->partida_monto;
                                                            }
                                                        }
                                                    @endphp
                                                    <span
                                                        class="badge fs-6 bg-{{ $total3 == $fut->importe ? 'success' : 'warning' }}">Total:
                                                        {{ $total3 }}&nbsp;bs.</span>
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
                                <div class="modal fade" id="partidas" tabindex="-1" aria-labelledby="partidasLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('postPartida') }}" method="post" id="agregar_de">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="partidasLabel1">Agregar cambio</h6>
                                                    <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>DE</h6>
                                                    <div class="form-group">
                                                        <label for="partida_de" class="form-label">Partida
                                                            presupuestaria</label>
                                                        <br>
                                                        <select name="id_mbs" id="partida_de"
                                                            class="form-control partidas_de select2_fut"
                                                            onchange="selectPartida(this)" required>
                                                            <option value="">[SELECCIONE OPCION]</option>
                                                        </select>
                                                        <input type="hidden" id="id_fut_pp" name="id_fut_pp" required>
                                                        <input type="hidden" id="id_detalle" name="id_detalle" required>
                                                        <input type="hidden" id="partida_codigo" name="partida_codigo"
                                                            required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="monto_fut" class="form-label">Monto</label>
                                                        <input type="number" class="monto_number form-control"
                                                            id="monto_fut" name="monto_fut" onkeyup="montoNumber(this)"
                                                            step="0.01" min="0.00" required>
                                                        <span class="text-warning" id="monto_max"></span>
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
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <a href="{{ route('listarFormulariosFut', $configuracion->id) }}"
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
                $('#monto_fut').val(max);
                $('#monto_fut').attr('max', max);
                $('#monto_max').text('Monto maximo: ' + max + ' bs.')
            } else {
                $('#monto_fut').val(total);
                $('#monto_fut').attr('max', total);
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

        function getPartidas(formulario5, financiamiento, id_fut_pp) {
            $('#id_fut_pp').val(id_fut_pp);
            $('#monto_max').text('')

            $.ajax({
                type: "POST",
                url: "{{ route('getPartidas') }}",
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
                    //     dropdownParent: $('#partidas')
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
        
        fut_select2('#partidas');
    </script>
@endsection
