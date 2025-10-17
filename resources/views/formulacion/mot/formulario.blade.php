@extends('principal')
@section('titulo', 'Formulario MOT')
@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                {{-- <form class="row" id="formularioFut"> --}}
                <form class="row" method="POST" action="{{ route('mot.modificacion') }}" id="formularioMot">
                    @csrf
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="col-lg-8 col-12 text-center fw-bold mt-3">
                                FORMULARIO DE MODIFICACIONES<br>
                                PRESUPUESTARIAS - MOT
                            </h5>
                            <div class="col-lg-4 col-12 form-group d-flex align-items-center justify-content-center">
                                <label for="nro_mot" class="form-label mt-3 me-3">
                                    <h5>MOT&nbsp;N°:&nbsp;</h5>
                                </label>
                                <input type="text" class="form-control" id="nro_mot"
                                    value="{{ formatear_con_ceros($nro_mot ? $nro_mot->nro + 1 : 1) }}"
                                    min="{{ formatear_con_ceros($nro_mot ? $nro_mot->nro + 1 : 1) }}" maxlength="4"
                                    name="nro_mot" required>
                                <h5 class="ms-3">{{ $gestion->gestion }}</h5>
                            </div>
                            <input type="hidden" name="id_formulado" id="id_formulado" value="{{ $id_formulado }}">
                            <input type="hidden" name="gestiones_id" id="gestiones_id" value="{{ $gestiones_id }}">
                            <input type="hidden" name="id_conformulado" id="id_conformulado"
                                value="{{ $id_conformulado }}">
                        </div>
                    </div>
                    {{-- @dd($financiamientos) --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="w-50 mx-auto my-5">
                                <select name="select" id="select-financiamiento" class="form-control">
                                    <option value="selected" selected disabled>[SELECCIONE FUENTE DE FINANCIAMIENTO]
                                    </option>
                                    @foreach ($financiamientos as $item)
                                        <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-50 mx-auto my-5">
                                <select name="select" id="select-partida" class="select2_partida" disabled>
                                    <option value="selected" selected disabled>[SELECCIONE PARTIDA PRESUPUESTARIA]
                                    </option>
                                    @foreach ($partidas_formulado3 as $item)
                                        <option value="{{ $item->id }}" class="d-flex"
                                            data-partida="{{ $item->partida }}" data-titulo="{{ $item->titulo_detalle }}"
                                            data-presupuesto="{{ $item->total_presupuesto }}"
                                            data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                            data-financiamiento="{{ $item->sigla }}"
                                            data-form5="{{ $item->formulario5_id }}"
                                            data-id_detalle="{{ $item->id_detalle }}"
                                            {{ $item->descr != null ? 'disabled' : '' }}>
                                            {{ $item->partida }} - {{ $item->titulo_detalle }}
                                            ({{ con_separador_comas($item->total_presupuesto) }})
                                            {{ $item->descr != null ? ' - ' . $item->descr : '' }}
                                        </option>
                                    @endforeach
                                    @foreach ($partidas_formulado4 as $item)
                                        <option value="{{ $item->id }}" class="d-flex"
                                            data-partida="{{ $item->partida }}" data-titulo="{{ $item->titulo_detalle }}"
                                            data-presupuesto="{{ $item->total_presupuesto }}"
                                            data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                            data-financiamiento="{{ $item->sigla }}"
                                            data-form5="{{ $item->formulario5_id }}"
                                            data-id_detalle="{{ $item->id_detalle }}"
                                            {{ $item->descr != null ? 'disabled' : '' }}>
                                            {{ $item->partida }} - {{ $item->titulo_detalle }}
                                            ({{ con_separador_comas($item->total_presupuesto) }})
                                            {{ $item->descr != null ? ' - ' . $item->descr : '' }}
                                        </option>
                                    @endforeach
                                    @foreach ($partidas_formulado5 as $item)
                                        <option value="{{ $item->id }}" class="d-flex"
                                            data-partida="{{ $item->partida }}" data-titulo="{{ $item->titulo_detalle }}"
                                            data-presupuesto="{{ $item->total_presupuesto }}"
                                            data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                            data-financiamiento="{{ $item->sigla }}"
                                            data-form5="{{ $item->formulario5_id }}"
                                            data-id_detalle="{{ $item->id_detalle }}"
                                            {{ $item->descr != null ? 'disabled' : '' }}>
                                            {{ $item->partida }} - {{ $item->titulo_detalle }}
                                            ({{ con_separador_comas($item->total_presupuesto) }})
                                            {{ $item->descr != null ? ' - ' . $item->descr : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <table class="table dataTable" id="tabla-partidas">
                                <thead>
                                    <tr>
                                        <th>Partida</th>
                                        <th>Descripcion</th>
                                        <th>Financiamiento</th>
                                        <th>Saldo presupuesto</th>
                                        <th>Monto a reducir</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                {{-- @dd($partidas_formulado4) --}}
                                {{-- @foreach ($partidas_formulado3 as $item)
                                    <tr>
                                        <td>{{ $item->partida }}</td>
                                        <td>{{ $item->titulo_detalle }}</td>
                                        <td>{{ $item->sigla }}</td>
                                        <td>{{ con_separador_comas($item->total_presupuesto) }} bs.</td>
                                        <td>
                                            <input type="text" class="form-control monto_number validar_maximo"
                                                max="{{ $item->total_presupuesto }}"
                                                value="{{ con_separador_comas($item->total_presupuesto) }}"
                                                id="monto_{{ $item->id }}" data-id="{{ $item->id }}"
                                                name="monto[]">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-check-input finan-suma"
                                                data-sigla="{{ $item->sigla }}" data-id="{{ $item->id }}"
                                                id="monto_{{ $item->id }}" name="check[]">
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </table>
                            <div class="row d-flex align-items-center mt-5">
                                <div class="col-9">
                                    <div class="alert alert-info">
                                        <p class="fw-bold">
                                            Total presupuesto a modificar:
                                        <div class="input-group">
                                            <input type="text" class="form-control readonly" readonly
                                                aria-describedby="basic-addon2" value="0.00" id="total_agregado"
                                                name="monto_poa">
                                            <span class="input-group-text" id="basic-addon2">bs.</span>
                                        </div>
                                        <span id="total_agregado_error" class="text-danger"></span>
                                        </p>
                                        <ul id="finan_agregado"></ul>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="button" id="btn-submit" class="float-end btn btn-outline-primary">
                                        Realizar modificación
                                    </button>
                                </div>
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
            let tabla = $('#tabla-partidas').DataTable()

            let partidasTabla = []
            $("#select-partida").on("change", function() {
                let valor = $(this).val();

                if (valor !== null) {
                    $.ajax({
                        type: "GET",
                        url: `{{ route('mot.operacion_objetivo') }}`,
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_mbs: valor
                        },
                        dataType: "JSON",
                        success: function(response) {
                            let $opcion = $("#select-partida option:selected")

                            let texto = $opcion.text()
                            let partida = $opcion.data('partida')
                            let titulo = $opcion.data('titulo')
                            let presupuesto = parseFloat($opcion.data('presupuesto'))
                            let id_financiamiento = $opcion.data('id_financiamiento')
                            let financiamiento = $opcion.data('financiamiento')
                            let form5 = $opcion.data('form5')
                            let id_detalle = $opcion.data('id_detalle')

                            let ae_id = response.ae_id
                            let oins_id = response.oins_id
                            let op_id = response.op_id

                            if (valor) {
                                $("#select-partida option[value='" + valor + "']").prop(
                                    "disabled", true);

                                $('#select-partida').val("selected").trigger('change');

                                tabla.row.add([
                                    partida,
                                    titulo,
                                    financiamiento,
                                    conSeparadorComas(presupuesto),
                                    `<input type="text" name="monto[]" class="form-control monto_number" max="${conSeparadorComas(presupuesto)}" value="${conSeparadorComas(presupuesto)}">`,
                                    `
                                    <input type="hidden" name="id[]" value="${valor}">
                                    <input type="hidden" name="finan[]" value="${id_financiamiento}">
                                    <input type="hidden" name="form5[]" value="${form5}">
                                    <input type="hidden" name="partidas[]" value="${partida}">
                                    <input type="hidden" name="detalles[]" value="${id_detalle}">
                                    <input type="hidden" name="areas_estrategicas[]" value="${ae_id}">
                                    <input type="hidden" name="objetivo_institucional[]" value="${oins_id}">
                                    <input type="hidden" name="operacion[]" value="${op_id}">
                                    <button type="button" class="btn btn-danger eliminar" data-valor="${valor}">Eliminar</button>
                                    `
                                ]).draw(false);

                                $("#select-financiamiento").attr("disabled", 'disabled');
                            }

                            if (!isNaN(presupuesto)) {
                                let suma = parseFloat($('#total_agregado').val().replace(/,/g,
                                    ""))

                                suma = suma + presupuesto

                                $('#total_agregado').val(conSeparadorComas(suma))
                            }
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                }
            });

            $("#tabla-partidas").on("click", ".eliminar", function() {
                let valor = $(this).data("valor");
                $("#select-partida option[value='" + valor + "']").prop("disabled", false);

                tabla.row($(this).parents("tr")).remove().draw(false);
                $('.monto_number').trigger('change');


                let hayDeshabilitados = $("#select-partida option:disabled")
                    .not('[disabled][value=""]').length > 1;

                if (hayDeshabilitados) {
                    $("#select-financiamiento").attr("disabled", true);
                } else {
                    $("#select-financiamiento").removeAttr("disabled");
                }

                if ($('.monto_number').length == 0) {
                    $('#total_agregado').val('0.00')
                }
            });

            // $('#tabla-partidas tbody').on("input", ".validar_maximo", function() {
            //     let $input = $(this);

            //     let raw = $input.val().replace(/,/g, "");
            //     let valor = parseFloat(raw) || 0;
            //     let max = parseFloat($input.attr("max")) || 0;

            //     if (valor > max) {
            //         valor = max;
            //     }

            //     $input.val(
            //         valor.toLocaleString("en-US", {
            //             minimumFractionDigits: 2,
            //             maximumFractionDigits: 2
            //         })
            //     );
            // });

            $("#tabla-partidas").on("change", ".monto_number", function() {
                let max = parseFloat($(this).attr('max').replace(/,/g, "")) || 0

                if (parseFloat($(this).val().replace(/,/g, "")) > max) {
                    $(this).val(conSeparadorComas(max))
                }

                let suma = 0;

                $(".monto_number").each(function() {
                    let valor = parseFloat($(this).val().replace(/,/g, "")) || 0;
                    suma += valor;
                });

                $('#total_agregado').val(suma.toLocaleString("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            });

            $("#tabla-partidas tbody").on({
                "focus": function(event) {
                    $(event.target).select();
                },
                "keyup": function(event) {
                    $(event.target).val(function(index, value) {
                        return value
                            .replace(/\D/g, "") // quitar no números
                            .replace(/([0-9])([0-9]{2})$/, '$1.$2') // decimales
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ','); // miles
                    });
                }
            }, ".monto_number");

            $(document).on('focus', 'input[type="text"]', function() {
                let input = this;
                setTimeout(function() {
                    let len = input.value.length;
                    input.setSelectionRange(len, len);
                }, 1);
            });

            $('#btn-submit').on('click', function() {
                let total_agregado = parseFloat($('#total_agregado').val());

                if (total_agregado <= 0) {
                    $('#total_agregado_error').text(
                        'El monto no puede ser 0'
                    );
                    return;
                } else {
                    $('#total_agregado_error').text('');
                }

                Swal.fire({
                    title: "¿Esta seguro de registrar la modificación?",
                    text: "Se atribuira el monto para modificaciones",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, registrar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formularioMot').submit();
                    }
                });
            });

            let $allOptions = $('#select-partida option').clone();
            let $placeholder = $allOptions.filter('[disabled]');
            $('#select-financiamiento').on('change', function() {
                $('#select-partida').removeAttr('disabled')

                let selectedFin = $(this).val();

                $('#select-partida').empty();
                $placeholder.clone().appendTo('#select-partida');

                if (selectedFin) {
                    $allOptions
                        .not('[disabled]')
                        .filter(function() {
                            return $(this).data('id_financiamiento') == selectedFin;
                        })
                        .appendTo('#select-partida');
                } else {
                    $allOptions.not('[disabled]').clone().appendTo('#select-partida');
                }

                $('#select-partida').val('selected').trigger('change');
            })
        });
    </script>
@endsection
