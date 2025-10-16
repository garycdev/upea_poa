@extends('principal')

@section('titulo', 'Formulario FUT')

@section('contenido')
    <div class="container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header row">
            <h5 class="page-title my-auto col-md-9 col-12">
                {{ $configuracion->descripcion }}<br>
                GESTION: {{ $configuracion->gestion }}<br>
                {{ $fut->unidad_carrera->nombre_completo }}
                <br>CODIGO: {{ $configuracion->codigo }}
                <br>FUT N°: {{ formatear_con_ceros($fut->nro) }}
            </h5>
            <div class="page-title my-auto col-md-3 col-12">
                <div
                    class="alert alert-{{ $fut->estado == 'aprobado' ? 'success' : ($fut->estado == 'rechazado' ? 'danger' : ($fut->estado == 'verificado' ? 'primary' : 'warning')) }}">
                    <p>Estado: <strong>{{ $fut->estado }}</strong></p>
                    @if (isset($fut->observacion))
                        <p>Observacion: {{ $fut->observacion }}</p>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-evenly">
                    @can('Validar_seguimiento')
                        @if ($fut->estado == 'elaborado' && Auth::user()->rol_verifica() == 'planifica')
                            <button type="button" class="btn btn-primary d-inline btn-validar-fut" data-id="{{ $fut->id_fut }}">
                                Verifica formulario
                            </button>
                        @endif
                        @if ($fut->estado == 'verificado' && Auth::user()->rol_verifica() == 'presupuesto')
                            <button type="button" class="btn btn-success d-inline btn-validar-fut"
                                data-id="{{ $fut->id_fut }}">
                                Aprobar compra
                            </button>
                        @endif
                    @endcan
                    {{-- @if ($fut->estado == 'aprobado' && Auth::user()->id_unidad_carrera == $fut->id_unidad_carrera)
                        <button type="button" class="btn btn-success btn-modal-ejecutar-fut" data-id="{{ $fut->id_fut }}">
                            Ejecutar compra
                        </button>
                    @endif --}}
                    <a href="{{ route('fut.pdf', encriptar($fut->id_fut)) }}" class="btn btn-danger" target="_blank"
                        style="display:inline-block">
                        <i class="ri-file-pdf-line"></i> Solicitud
                    </a>
                    {{-- @if ($fut->estado == 'verificado' || $fut->estado == 'aprobado')
                        <a href="{{ route('pdfFut', $fut->id_fut) }}" class="btn btn-danger" target="_blank"
                            style="display:inline-block">
                            <i class="ri-file-pdf-line"></i> Formulario
                        </a>
                    @endif --}}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div>
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <strong>{{ session('message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    {{-- <div class="alert fs-6 alert-info">Monto disponible para cambios:
                        {{ $fut->importe - $total_total }}&nbsp;bs.</div>
                    <input type="hidden" id="total_total" value="{{ $fut->importe - $total_total }}"> --}}
                    @if ($fut->estado == 'rechazado')
                        <div class="alert fs-6 alert-danger">
                            <strong>
                                Monto revertido :
                                {{ con_separador_comas($total_total) }}&nbsp;bs.
                            </strong>
                        </div>
                    @elseif (Auth::user()->id_unidad_carrera == $fut->id_unidad_carrera && $fut->estado == 'elaborado')
                        <div class="alert fs-6 alert-info">
                            <strong>
                                Monto disponible para cambios:
                                {{ con_separador_comas($fut->getTotalPresupuestoAttribute()) }}&nbsp;bs.
                            </strong>
                        </div>
                    @elseif ($fut->estado == 'aprobado')
                        <div class="alert fs-6 alert-primary">
                            <strong>
                                Monto aprobado :
                                {{ con_separador_comas($total_total) }}&nbsp;bs.
                            </strong>
                        </div>
                    @elseif ($fut->estado == 'ejecutado')
                        <div class="alert fs-6 alert-success">
                            <strong>
                                Monto ejecutado exitosamente :
                                {{ con_separador_comas($total_total) }}&nbsp;bs.
                            </strong>
                        </div>
                    @endif
                    {{-- <input type="hidden" id="total_total" value="{{ $fut->importe }}"> --}}
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Organismo financiador</th>
                                <th>Partidas</th>
                                {{-- <th>Acciones</th> --}}
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
                                                            <th>Detalle</th>
                                                            <th>Monto</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($item->mov as $mov)
                                                            <tr>
                                                                <td>
                                                                    {{ $mov->partida_codigo }}
                                                                </td>
                                                                <td>{{ $mov->detalle()->titulo }}</td>
                                                                <td>
                                                                    {{ con_separador_comas($mov->partida_monto) }}&nbsp;bs.
                                                                </td>
                                                                <td>
                                                                    @if (Auth::user()->id_unidad_carrera == $fut->id_unidad_carrera && $mov->futpp->fut->estado == 'elaborado')
                                                                        <button type="submit"
                                                                            class="btn btn-outline-warning"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#movimiento"
                                                                            onclick="editarMonto({{ $mov->id_fut_mov }},{{ $mov->id_mbs }}, {{ $mov->partida_monto }}, {{ $mov->mbs->total_presupuesto }})">
                                                                            <i class="ri-pencil-line"></i>
                                                                        </button>
                                                                        @if (count($item->mov) > 1)
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger"
                                                                                onclick="eliminarMonto({{ $mov->id_fut_mov }})">
                                                                                <i class="ri-delete-bin-line"></i>
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $total += $mov->partida_monto;
                                                            @endphp
                                                        @endforeach
                                                        <tr style="background: #77ff95aa">
                                                            <td class="fw-bold" align="right" colspan="2">Total
                                                            </td>
                                                            <td class="fw-bold" colspan="2">
                                                                {{ con_separador_comas($total) }}&nbsp;bs.
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @else
                                                Sin cambios
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#partidas" onclick="agregarMonto({{ $fut->id_fut }})">
                                                Agregar
                                            </button>
                                            <button class="btn btn-success">
                                                <i class="ri-file-excel-line"></i>&nbsp;EXCEL
                                            </button>
                                        </td> --}}
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                @php
                                    $total3 = 0;
                                    foreach ($financiamientos as $item) {
                                        foreach ($item->mov as $value) {
                                            $total3 += $value->partida_monto;
                                        }
                                    }
                                @endphp
                                <tr style="background: {{ $total3 == $fut->importe ? '#77ff95' : '#dc3545' }}"
                                    class="fw-bold">
                                    <td colspan="2" align="right">TOTAL: </td>
                                    <td>
                                        {{ con_separador_comas($total3) }}&nbsp;bs.
                                    </td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" align="center">
                                        Ningun gasto registrado
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="modal fade" id="movimiento" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('fut.editar.monto') }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar
                                            monto
                                        </h1>
                                        <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info" id="monto_maximo"></div>
                                        <input type="hidden" name="id" id="id">
                                        <input type="hidden" name="id_mbs" id="id_mbs">
                                        <input type="hidden" name="monto_actual" id="monto_actual">
                                        <div class="form-group">
                                            <label for="monto" class="form-label">Monto</label>
                                            <input type="text" class="form-control monto_number" name="monto"
                                                id="monto" value="{{ con_separador_comas($mov->partida_monto) }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="mt-3 d-flex justify-content-center">
                    @cannot('Validar_seguimiento')
                        @if (isset(Auth::user()->id_unidad_carrera))
                            <a href="{{ route('fut.listar', encriptar($configuracion->id)) }}"
                                class="btn btn-dark">Volver</a>
                        @else
                            <a href="{{ route('fut.listar', [encriptar($configuracion->id), encriptar($fut->id_unidad_carrera)]) }}"
                                class="btn btn-dark">
                                Volver
                            </a>
                        @endif
                    @endcannot
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('focus', 'input[type="text"]', function() {
                let input = this;
                setTimeout(function() {
                    let len = input.value.length;
                    input.setSelectionRange(len, len);
                }, 1);
            });

            $(document).on("change", ".monto_number", function() {
                let max = parseFloat($(this).attr('max'))
                let monto = parseFloat($(this).val().replace(/,/g, ""))

                if (monto > max) {
                    $(this).val(conSeparadorComas(max))
                }
            });
        });

        function editarMonto(id, id_mbs, monto, saldo) {
            let max = monto + saldo;

            $('#monto_maximo').html('Monto maximo disponible: <b>' + conSeparadorComas(max) + ' bs.</b>')
            $('#id').val(id)
            $('#id_mbs').val(id_mbs)
            $('#monto').val(conSeparadorComas(monto))
            $('#monto_actual').val(conSeparadorComas(monto))
            $('#monto').attr('max', max)
        }

        function eliminarMonto(id) {
            Swal.fire({
                title: "¿Esta seguro de eliminar el monto?",
                text: "Se eliminara la atribucion del monto previsto",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, registrar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('fut.eliminar.monto') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                            id: id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            location.reload()
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        }

        function montoNumber(el) {
            $(el).val(function(index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
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

        // fut_select2('#partidas');
    </script>
@endsection
