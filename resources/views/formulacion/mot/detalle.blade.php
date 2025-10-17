@extends('principal')

@section('titulo', 'Formulario MOT')

@section('contenido')
    <div class="container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header row">
            <h5 class="page-title my-auto col-md-9 col-12">
                {{ $configuracion->descripcion }}<br>
                GESTION: {{ $configuracion->gestion }}<br>
                {{ $mot->unidad_carrera->nombre_completo }}
                <br>CODIGO: {{ $configuracion->codigo }}
                <br>MOT N°: {{ formatear_con_ceros($mot->nro) }}
            </h5>
            <div class="page-title my-auto col-md-3 col-12">
                <div
                    class="alert alert-{{ $mot->estado == 'aprobado' ? 'success' : ($mot->estado == 'rechazado' ? 'danger' : ($mot->estado == 'verificado' ? 'primary' : ($mot->estado == 'elaborado' ? 'info' : 'warning'))) }}">
                    <p>Estado: <strong>{{ $mot->estado }}</strong></p>
                    @if (isset($mot->observacion))
                        <p>Observacion: {{ $mot->observacion }}</p>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-evenly">
                    @can('Validar_seguimiento')
                        @if ($mot->estado == 'elaborado' && Auth::user()->rol_verifica() == 'planifica')
                            <button type="button" class="btn btn-primary d-inline btn-validar-mot" data-id="{{ $mot->id_mot }}">
                                Formulario verificado
                            </button>
                        @endif
                        @if ($mot->estado == 'verificado' && Auth::user()->rol_verifica() == 'presupuesto')
                            <button type="button" class="btn btn-success d-inline btn-validar-mot"
                                data-id="{{ $mot->id_mot }}">
                                Aprobar modificaciones
                            </button>
                        @endif
                    @endcan
                    @if ($mot->estado != 'pendiente')
                        <a href="{{ route('mot.pdf', encriptar($mot->id_mot)) }}" class="btn btn-danger" target="_blank"
                            style="display:inline-block">
                            <i class="ri-file-pdf-line"></i> Solicitud
                        </a>
                    @endif
                    {{-- @if ($mot->estado == 'aprobado' || $mot->estado == 'ejecutado')
                        <a href="{{ route('pdfMot', $mot->id_mot) }}" class="btn btn-danger" target="_blank"
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
                    {{-- <div class="alert fs-6 alert-info">Monto disponible para cambios:
                        {{ $mot->importe - $total_total }}&nbsp;bs.</div>
                    <input type="hidden" id="total_total" value="{{ $mot->importe - $total_total }}"> --}}
                    @if ($mot->estado == 'rechazado')
                        @php
                            $total_total = 0;
                            foreach ($mot->total as $value) {
                                if ($value->descripcion == 'eliminado') {
                                    $total_total += $value->partida_monto;
                                }
                            }
                        @endphp
                        <div class="alert fs-6 alert-danger">
                            <strong>
                                Monto revertido :
                                {{ con_separador_comas($total_total) }}&nbsp;bs.
                            </strong>
                        </div>
                    @elseif (Auth::user()->id_unidad_carrera == $mot->id_unidad_carrera &&
                            ($mot->estado == 'elaborado' || $mot->estado == 'pendiente'))
                        @php
                            $total_total = 0;
                            foreach ($mot->total as $value) {
                                if ($value->descripcion == 'incrementa') {
                                    $total_total += $value->partida_monto;
                                }
                            }
                        @endphp
                        <div class="alert fs-5 alert-primary">
                            <strong>
                                Monto disponible para modificaciones:
                                {{ con_separador_comas($mot->mot_a()->saldo) }}&nbsp;bs.
                            </strong>
                        </div>
                    @elseif ($mot->estado == 'aprobado')
                        @php
                            $total_total = 0;
                            foreach ($mot->total as $value) {
                                if ($value->descripcion == 'aprobado') {
                                    $total_total += $value->partida_monto;
                                }
                            }
                        @endphp
                        <div class="alert fs-6 alert-primary">
                            <strong>
                                Monto aprobado :
                                {{ con_separador_comas($total_total) }}&nbsp;bs.
                            </strong>
                        </div>
                    @elseif ($mot->estado == 'ejecutado')
                        @php
                            $total_total = 0;
                            foreach ($mot->total as $value) {
                                if ($value->descripcion == 'incrementa') {
                                    $total_total += $value->partida_monto;
                                }
                            }
                        @endphp
                        <div class="alert fs-6 alert-success">
                            <strong>
                                Monto ejecutado exitosamente :
                                {{ con_separador_comas($total_total) }}&nbsp;bs.
                            </strong>
                        </div>
                    @endif
                    {{-- <input type="hidden" id="total_total" value="{{ $mot->importe }}"> --}}
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Organismo financiador</th>
                                <th>Acción</th>
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
                                            <span class="badge bg-primary">
                                                {{ $item->accion }}
                                            </span>
                                        </td>
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
                                                        @php
                                                            $movsDe = 0;
                                                        @endphp
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
                                                                    @if (Auth::user()->id_unidad_carrera == $mot->id_unidad_carrera &&
                                                                            ($mov->motpp->mot->estado == 'elaborado' || $mov->motpp->mot->estado == 'pendiente'))
                                                                        @if ($item->accion == 'DE')
                                                                            @if ($item->saldo == $item->mot_a($item->id_mot)->saldo)
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-warning"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#movimiento"
                                                                                    onclick="editarMonto({{ $mov->id_mot_mov }}, {{ $mov->id_mbs }}, {{ $mov->partida_monto }}, {{ $mov->mbs->total_presupuesto }}, '{{ $item->accion }}')">
                                                                                    <i class="ri-pencil-line"></i>
                                                                                </button>
                                                                                @if (count($item->mov) > 1)
                                                                                    <button type="button"
                                                                                        class="btn btn-outline-danger"
                                                                                        onclick="eliminarMonto({{ $mov->id_mot_mov }}, '{{ $item->accion }}')">
                                                                                        <i class="ri-delete-bin-line"></i>
                                                                                    </button>
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            {{-- <button type="submit"
                                                                                class="btn btn-outline-warning"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#movimiento"
                                                                                onclick="editarMonto({{ $mov->id_mot_mov }},{{ $mov->id_mbs }}, {{ $mov->partida_monto }}, {{ $saldoDisponible }}, '{{ $item->accion }}')">
                                                                                <i class="ri-pencil-line"></i>
                                                                            </button> --}}
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger"
                                                                                onclick="eliminarMonto({{ $mov->id_mot_mov }}, '{{ $item->accion }}')">
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
                                                        @if ($item->accion == 'DE')
                                                            @php
                                                                $saldoDisponible = $item->mot_a($item->id_mot)->saldo;
                                                            @endphp

                                                            <tr style="background: #77ff95aa">
                                                                <td class="fw-bold" align="right" colspan="2">
                                                                    Total modificado
                                                                </td>
                                                                <td class="fw-bold" colspan="2">
                                                                    {{ con_separador_comas($total) }}&nbsp;bs.
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr style="background: #77ff95aa">
                                                                <td class="fw-bold" align="right" colspan="2">
                                                                    Total agregado
                                                                </td>
                                                                <td class="fw-bold" colspan="2">
                                                                    {{ con_separador_comas($total) }}&nbsp;bs.
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            @else
                                                Sin cambios
                                            @endif
                                        </td>
                                        <td>
                                            @if (Auth::user()->id_unidad_carrera == $mot->id_unidad_carrera && $item->accion == 'A' && $saldoDisponible > 0)
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#partidas_a"
                                                    onclick="agregarPartidaA({{ sin_separador_comas($saldoDisponible) }}, {{ $item->id_mot_pp }}, {{ $item->organismo_financiador }})">
                                                    Agregar
                                                </button>
                                            @endif
                                            {{-- <button class="btn btn-success">
                                                <i class="ri-file-excel-line"></i>&nbsp;EXCEL
                                            </button> --}}
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                @php
                                    $total_de = 0;
                                    $total_a = 0;
                                    foreach ($financiamientos as $item) {
                                        if ($item->accion == 'DE') {
                                            $total_de = $item->mot_a($item->id_mot)->saldo;
                                        } else {
                                            foreach ($item->mov as $value) {
                                                $total_a += $value->partida_monto;
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background: {{ $total_a == $mot->importe ? '#77ff95' : '#dc3545' }}"
                                    class="fw-bold text-light">
                                    <td colspan="2" align="right">TOTAL: </td>
                                    <td>
                                        {{ con_separador_comas($total_a) }}&nbsp;bs.
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
                            <form action="{{ route('mot.editar.monto') }}" method="POST">
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
                                        <input type="hidden" name="accion" id="accion">
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


                    {{-- lista oculta de partidas existentes, no borrar --}}
                    <select name="select" id="select-partida" class="select2_mot" style="visibility:hidden">
                        <option value="selected" selected disabled>[SELECCIONE PARTIDA
                            PRESUPUESTARIA]
                        </option>
                        @foreach ($partidas_formulado3 as $item)
                            <option value="{{ $item->id }}" class="d-flex" data-partida="{{ $item->partida }}"
                                data-titulo="{{ $item->titulo_detalle }}"
                                data-presupuesto="{{ $item->total_presupuesto }}"
                                data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                data-financiamiento="{{ $item->sigla }}" data-form5="{{ $item->formulario5_id }}"
                                data-id_detalle="{{ $item->id_detalle }}">
                                {{ $item->partida }} - {{ $item->titulo_detalle }}
                            </option>
                        @endforeach
                        @foreach ($partidas_formulado4 as $item)
                            <option value="{{ $item->id }}" class="d-flex" data-partida="{{ $item->partida }}"
                                data-titulo="{{ $item->titulo_detalle }}"
                                data-presupuesto="{{ $item->total_presupuesto }}"
                                data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                data-financiamiento="{{ $item->sigla }}" data-form5="{{ $item->formulario5_id }}"
                                data-id_detalle="{{ $item->id_detalle }}">
                                {{ $item->partida }} - {{ $item->titulo_detalle }}
                            </option>
                        @endforeach
                        @foreach ($partidas_formulado5 as $item)
                            <option value="{{ $item->id }}" class="d-flex" data-partida="{{ $item->partida }}"
                                data-titulo="{{ $item->titulo_detalle }}"
                                data-presupuesto="{{ $item->total_presupuesto }}"
                                data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                data-financiamiento="{{ $item->sigla }}" data-form5="{{ $item->formulario5_id }}"
                                data-id_detalle="{{ $item->id_detalle }}">
                                {{ $item->partida }} - {{ $item->titulo_detalle }}
                            </option>
                        @endforeach
                    </select>

                    <div class="modal fade" id="partidas_a" tabindex="-1" aria-labelledby="partidasALabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form id="agregar_a">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="partidasALabel1">Agregar movimiento</h6>
                                        <button type="reset" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" id="id_mot_pp" name="id_mot_pp">
                                        <input type="hidden" id="organismo_financiador" name="organismo_financiador">
                                        <input type="hidden" id="partida" name="partida">
                                        <div class="alert alert-info">
                                            Monto disponible:
                                            <div class="input-group">
                                                <input type="text" class="form-control readonly" readonly
                                                    aria-describedby="basic-addon2" value="0.00" id="total_disp">
                                                <span class="input-group-text" id="basic-addon2">bs.</span>
                                            </div>
                                        </div>
                                        <h6>A</h6>
                                        <div class="form-group">
                                            <label for="partida_de" class="form-label">Partida
                                                presupuestaria</label>
                                            <br>
                                            <select name="partida_a" id="select-partida-a" class="select2_mot_a">
                                                <option value="" selected disabled>[SELECCIONE PARTIDA
                                                    PRESUPUESTARIA]
                                                </option>
                                                @foreach ($partidas3 as $item)
                                                    <option value="{{ $item->id }}" class="d-flex"
                                                        data-partida="{{ $item->partida }}"
                                                        data-titulo="{{ $item->titulo_detalle }}">
                                                        {{ $item->partida }} - {{ $item->titulo_detalle }}
                                                    </option>
                                                @endforeach
                                                @foreach ($partidas4 as $item)
                                                    <option value="{{ $item->id }}" class="d-flex"
                                                        data-partida="{{ $item->partida }}"
                                                        data-titulo="{{ $item->titulo_detalle }}">
                                                        {{ $item->partida }} - {{ $item->titulo_detalle }}
                                                    </option>
                                                @endforeach
                                                @foreach ($partidas5 as $item)
                                                    <option value="{{ $item->id }}" class="d-flex"
                                                        data-partida="{{ $item->partida }}"
                                                        data-titulo="{{ $item->titulo_detalle }}">
                                                        {{ $item->partida }} - {{ $item->titulo_detalle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text _partida_a"></span>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6 form-group">
                                                <label for="medida" class="form-label">Medida</label>
                                                <select name="medida" id="medida" class="form-control">
                                                    <option value="">[SELECCIONE MEDIDA]</option>
                                                    @foreach ($medidas as $med)
                                                        <option value="{{ $med->id }}">
                                                            {{ $med->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text _medida"></span>
                                            </div>
                                            <div class="col-6 form-group">
                                                <label for="cantidad" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control sumar_total" id="cantidad"
                                                    name="cantidad" value="1">
                                                <span class="text-danger error-text _cantidad"></span>
                                            </div>
                                            <div class="col-6 form-group mt-3">
                                                <label for="precio" class="form-label">Precio</label>
                                                <input type="text" class="form-control monto_number sumar_total"
                                                    id="precio" name="precio_unitario">
                                                <span class="text-danger error-text _precio_unitario"></span>
                                            </div>
                                            <div class="col-6 form-group mt-3">
                                                <label for="total" class="form-label">Total</label>
                                                <input type="text" class="form-control monto_number" id="total"
                                                    name="total_presupuesto" value="0.00" readonly>
                                                <span class="text-danger error-text _total_presupuesto"></span>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="fecha_requerida" class="form-label">Fecha
                                                requerida</label>
                                            <input type="date" class="form-control" id="fecha_requerida"
                                                name="fecha_requerida">
                                            <span class="text-danger error-text _fecha_requerida"></span>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="objetivo_gestion" class="form-label">Objetivo gestion</label>
                                            <select class="form-control select2_objetivo_gestion" id="objetivo_gestion"
                                                name="objetivo_gestion">
                                                <option value="selected" selected disabled>[SELECCION OBJETIVO GESTION]
                                                </option>
                                            </select>
                                            <span class="text-danger error-text _objetivo_gestion"></span>
                                        </div>
                                        <div class="row mt-3 mx-3">
                                            <div class="alert alert-info col-6" id="ae_descripcion">-</div>
                                            <div class="alert alert-info col-6" id="oins_descripcion">-</div>
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
                    {{-- @dd($mot) --}}
                    @cannot('Validar_seguimiento')
                        @if (isset(Auth::user()->id_unidad_carrera))
                            <a href="{{ route('mot.listar', encriptar($configuracion->id)) }}"
                                class="btn btn-dark">Volver</a>
                        @else
                            <a href="{{ route('mot.listar', [encriptar($configuracion->id), encriptar($mot->id_unidad_carrera)]) }}"
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

            $(document).on('change', '#objetivo_gestion', function() {
                let $selected = $(this).find('option:selected');

                $('#ae_descripcion').html($selected.data('ae'))
                $('#oins_descripcion').html($selected.data('oins'))
            })
            $(document).on('change', '#select-partida-a', function() {
                let $selected = $(this).find('option:selected');

                $('#partida').val($selected.data('partida'))
            })

            $(document).on('submit', '#agregar_a', function(e) {
                e.preventDefault()

                let form = this;

                $.ajax({
                    type: "POST",
                    url: "{{ route('mot.agregar') }}",
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.reload()
                    },
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $(form).find('span._' + key).text(value[0]);
                            });
                        }
                    }
                });
            })

            $(document).on('change', '.sumar_total', function() {
                const monto = $('#precio').val().replace(/,/g, "")
                const cantidad = $('#cantidad').val()
                const total = monto * cantidad;
                const max = $('#total_disp').val().replace(/,/g, "");

                $('#total').val(conSeparadorComas(total));
                if (total > max) {
                    $('#total_error').text('El monto sobrepasa al maximo presupuesto.')
                    $('#btn-a').attr('disabled', 'disabled');
                } else {
                    $('#total_error').text('')
                    $('#btn-a').removeAttr('disabled');
                }
            })
        });

        function editarMonto(id, id_mbs, monto, saldo, accion) {
            let max = monto + saldo;

            $('#monto_maximo').html('Monto maximo disponible: <b>' + conSeparadorComas(max) + ' bs.</b>')
            $('#id').val(id)
            $('#id_mbs').val(id_mbs)
            $('#monto').val(conSeparadorComas(monto))
            $('#monto_actual').val(conSeparadorComas(monto))
            $('#monto').attr('max', max)
            $('#accion').val(accion)
        }

        function eliminarMonto(id, accion) {
            console.log(id, accion);

            Swal.fire({
                title: "¿Esta seguro de eliminar el monto?",
                text: "Se eliminara la atribucion del monto previsto",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('mot.eliminar.monto') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                            id: id,
                            accion: accion
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

        // function montoNumber(el) {
        //     $(el).val(function(index, value) {
        //         return value.replace(/\D/g, "")
        //             .replace(/([0-9])([0-9]{2})$/, '$1.$2')
        //     });
        // }

        function agregarPartidaA(monto, id_mot_pp, organismo_financiador, id_mot) {
            $('#total_disp').val(conSeparadorComas(monto))
            $('#id_mot_pp').val(id_mot_pp)
            $('#organismo_financiador').val(organismo_financiador)


            let forms5 = [];
            $('#select-partida option').each(function(index) {
                if (index === 0) return;
                forms5.push($(this).data('form5'));
            });

            let unicosForms5 = [...new Set(forms5)];

            $.ajax({
                url: "{{ route('mot.objetivos') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    form5: unicosForms5,
                },
                success: function(resp) {
                    $('#objetivo_gestion').empty()
                    $('#objetivo_gestion').append(
                        '<option value="selected" selected disabled>[SELECCION OBJETIVO GESTION]</option>')

                    resp.forEach(element => {
                        $('#objetivo_gestion').append(
                            `<option value="${element.id}"
                                data-ae="${element.ae_descripcion}"
                                data-oins="${element.oins_descripcion}">
                                ${element.op_descripcion}
                            </option>`)
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        // mot_de_select2('#partidas');
        mot_a_select2('#partidas_a');
        objetivo_gestion_select2('#partidas_a')
    </script>
@endsection
