@extends('principal')
@section('titulo', 'Formulario FUT')
@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                {{-- <form class="row" id="formularioFut"> --}}
                <form class="row" method="POST" action="{{ route('fut.compra') }}" id="formularioFut">
                    @csrf
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="col-lg-8 col-12 text-center fw-bold mt-3">
                                FORMULARIO DE INICIO/UNICO DE TRAMITE<br>
                                CONTRATACIóN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS - FUT
                            </h5>
                            <div class="col-lg-4 col-12 form-group d-flex align-items-center justify-content-center">
                                <label for="nro_fut" class="form-label mt-3 me-3">
                                    <h5>FUT&nbsp;N°:&nbsp;</h5>
                                </label>
                                <input type="text" class="form-control" id="nro_fut"
                                    value="{{ formatear_con_ceros($nro_fut ? $nro_fut->nro + 1 : 1) }}"
                                    min="{{ formatear_con_ceros($nro_fut ? $nro_fut->nro + 1 : 1) }}" maxlength="4"
                                    name="nro_fut" required>
                                <h5 class="ms-3">{{ $gestion->gestion }}</h5>
                            </div>
                            <input type="hidden" name="id_formulado" id="id_formulado" value="{{ $id_formulado }}">
                            <input type="hidden" name="gestiones_id" id="gestiones_id" value="{{ $gestiones_id }}">
                            <input type="hidden" name="id_conformulado" id="id_conformulado"
                                value="{{ $id_conformulado }}">
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="w-50 mx-auto my-5">
                                <select name="select" id="select-partida" class="select2_partida">
                                    <option value="selected" selected disabled>[SELECCIONE PARTIDA PRESUPUESTARIA]
                                    </option>
                                    @foreach ($partidas_formulado3 as $item)
                                        <option value="{{ $item->id }}" class="d-flex"
                                            data-partida="{{ $item->partida }}" data-titulo="{{ $item->titulo_detalle }}"
                                            data-presupuesto="{{ $item->total_presupuesto }}"
                                            data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                            data-financiamiento="{{ $item->sigla }}"
                                            data-form5="{{ $item->formulario5_id }}"
                                            data-id_detalle="{{ $item->id_detalle }}">
                                            {{ $item->partida }} - {{ $item->titulo_detalle }}
                                        </option>
                                    @endforeach
                                    @foreach ($partidas_formulado4 as $item)
                                        <option value="{{ $item->id }}" class="d-flex"
                                            data-partida="{{ $item->partida }}" data-titulo="{{ $item->titulo_detalle }}"
                                            data-presupuesto="{{ $item->total_presupuesto }}"
                                            data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                            data-financiamiento="{{ $item->sigla }}"
                                            data-form5="{{ $item->formulario5_id }}"
                                            data-id_detalle="{{ $item->id_detalle }}">
                                            {{ $item->partida }} - {{ $item->titulo_detalle }}
                                        </option>
                                    @endforeach
                                    @foreach ($partidas_formulado5 as $item)
                                        <option value="{{ $item->id }}" class="d-flex"
                                            data-partida="{{ $item->partida }}" data-titulo="{{ $item->titulo_detalle }}"
                                            data-presupuesto="{{ $item->total_presupuesto }}"
                                            data-id_financiamiento="{{ $item->tipo_financiamiento_id }}"
                                            data-financiamiento="{{ $item->sigla }}"
                                            data-form5="{{ $item->formulario5_id }}"
                                            data-id_detalle="{{ $item->id_detalle }}">
                                            {{ $item->partida }} - {{ $item->titulo_detalle }}
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
                                        <th>Monto a usar</th>
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
                                            Total presupuesto agregado:
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
                                        Realizar compra
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

            $("#select-partida").on("change", function() {
                let valor = $(this).val();

                if (valor !== null) {
                    $.ajax({
                        type: "GET",
                        url: `{{ route('fut.operacion_objetivo') }}`,
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

                if ($('.monto_number').length == 0) {
                    $('#total_agregado').val(conSeparadorComas(0))
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
                    title: "¿Esta seguro de registrar compra?",
                    text: "Se atribuira el monto para gasto",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, registrar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formularioFut').submit();
                    }
                });
            });
        });

        // $(document).ready(function() {
        //     $(document).on("input", ".monto_number.validar_maximo", function() {
        //         let max = parseFloat($(this).attr("max")) || 0;
        //         let id = $(this).attr("data-id");

        //         let valor = parseFloat($(this).val().replace(/,/g, "")) || 0;

        //         if (valor > max) {
        //             $(this).val(
        //                 max.toLocaleString("en-US", {
        //                     minimumFractionDigits: 2,
        //                     maximumFractionDigits: 2
        //                 })
        //             );
        //         }
        //     });

        //     $(document).on('change', '#check_all', function() {
        //         var isChecked = $(this).prop('checked');

        //         $('.finan-suma').prop('checked', isChecked).trigger('change');
        //     })

        //     $(document).on('focus', 'input[type="text"]', function() {
        //         let input = this;
        //         setTimeout(function() {
        //             let len = input.value.length;
        //             input.setSelectionRange(len, len);
        //         }, 1);
        //     });

        // function numeroATexto(numero) {
        //     const unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        //     const especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciseis', 'diecisiete',
        //         'dieciocho', 'diecinueve'
        //     ];
        //     const decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta',
        //         'noventa'
        //     ];
        //     const centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos',
        //         'setecientos', 'ochocientos', 'novecientos'
        //     ];
        //     const miles = ['', 'mil', 'millón', 'mil millones', 'billón', 'mil billones', 'trillón', 'mil trillones'];
        //     if (numero.value === 0) {
        //         return 'cero';
        //     }
        //     let texto = '';
        //     let num = numero.value;
        //     for (let i = miles.length - 1; i >= 0; i--) {
        //         const divisor = Math.pow(10, i * 3);
        //         const segmento = Math.floor(num / divisor);
        //         num -= segmento * divisor;
        //         if (segmento) {
        //             const centena = Math.floor(segmento / 100);
        //             const decena = Math.floor((segmento % 100) / 10);
        //             const unidad = segmento % 10;
        //             if (centena) {
        //                 texto += centenas[centena] + ' ';
        //             }
        //             if (decena === 1) {
        //                 texto += especiales[unidad] + ' ';
        //             } else {
        //                 texto += decenas[decena] + ' ';
        //                 texto += unidades[unidad] + ' ';
        //             }
        //             texto += miles[i] + ' ';
        //         }
        //     }
        //     if (texto.trim().toUpperCase()) {
        //         $('#monto_poa_literal').val('(SON ' + texto.trim().toUpperCase() + ' BOLIVIANOS 00/100)');
        //     } else {
        //         $('#monto_poa_literal').val('');
        //     }
        // }

        // function formatoProgmatica(prog) {
        //     var input = $(prog).val();
        //     var formattedInput = '';

        //     input = input.replace(/\D/g, '');

        //     if (input.length > 0) {
        //         formattedInput = input.substring(0, 2) + '-';
        //         if (input.length > 2) {
        //             formattedInput += input.substring(2, 6) + '-';
        //             if (input.length > 6) {
        //                 formattedInput += input.substring(6, 11);
        //             }
        //         }
        //     }
        //     $(prog).val(formattedInput);
        // }

        // let fuenteFin = {}

        // function cambiarAreaEstrategica(select) {
        //     $('#monto_habilitado').val(0);
        //     $('#financiamientos').empty()

        //     if (select.value == 0) {
        //         $('#area').val('')
        //         $('#id_area').val('')

        //         $('#select-objetivoGestion').empty()
        //         $('#select-objetivoGestion').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
        //         $('#objetivo').val('')
        //         $('#select-tareaProyecto').empty()
        //         $('#select-tareaProyecto').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
        //         $('#tarea').val('')

        //         $('#monto_poa').val('')
        //         $('#monto_poa').removeAttr('max')
        //         numeroATexto(0)
        //     } else {
        //         $('#area').val(select.value)
        //         $('#id_area').val(select.options[select.selectedIndex].getAttribute('data-id'))

        //         $('#select-tareaProyecto').empty()
        //         $('#select-tareaProyecto').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
        //         $('#tarea').val('')

        //         $.ajax({
        //             url: "{{ route('getObjetivoInstitucionalFut') }}",
        //             type: "POST",
        //             dataType: "json",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 id_area: $('#id_area').val(),
        //                 id_formulado: $('#id_formulado').val()
        //             },
        //             dataType: "json",
        //             success: function(response) {
        //                 console.log(response);
        //                 $('#select-objetivoGestion').empty()
        //                 $('#select-objetivoGestion').append(
        //                     '<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')

        //                 response.forEach(element => {
        //                     $('#select-objetivoGestion').append(
        //                         `<option value="${element.codigo}" data-id="${element.id}" data-formulario2="${element.f2_id}">[${element.codigo}] ${element.descripcion}</option>`
        //                     )
        //                 })
        //                 // $('#select-objetivoGestion2').empty()
        //                 // $('#select-objetivoGestion2').append(
        //                 //     '<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
        //             },
        //             error: function(error) {
        //                 console.log(error)
        //             }
        //         });
        //     }
        // }

        // function cambiarObjetivoGestion(select) {
        //     $('#monto_habilitado').val(0);
        //     $('#financiamientos').empty()

        //     if (select.value == 0) {
        //         $('#objetivo').val('')

        //         $('#select-tareaProyecto').empty()
        //         $('#select-tareaProyecto').append('<option value="">[SELECCIONE OBJETIVO DE GESTION]</option>')
        //         $('#tarea').val('')
        //     } else {
        //         $('#objetivo').val(`${$('#area').val()}.${select.value}`);
        //         const formulario2 = $('#select-objetivoGestion option:selected').attr('data-formulario2');
        //         const id = $('#select-objetivoGestion option:selected').attr('data-id');
        //         $('#og_id').val(id);
        //         $.ajax({
        //             type: "POST",
        //             url: "{{ route('getTareaProyectoFut') }}",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 formulario2: formulario2,
        //                 objetivo: id
        //             },
        //             dataType: "JSON",
        //             success: function(response) {
        //                 console.log(response);
        //                 $('#select-tareaProyecto').empty();
        //                 $('#select-tareaProyecto').append(
        //                     '<option value="">[SELECCIONE TAREA O PROYECTO]</option>');
        //                 response.forEach(element => {
        //                     $('#select-tareaProyecto').append(
        //                         `<option value="${element.id}" data-value="${element.f5_id}">[${element.id}] ${element.descripcion}</option>`
        //                     )
        //                 })
        //             },
        //             error: function(error) {
        //                 console.log(error)
        //             }
        //         });
        //     }
        // }

        // function cambiarTareaProyecto(select) {
        //     $('#monto_habilitado').val(0);
        //     if (select.value == 0) {
        //         $('#tarea').val('')
        //     } else {
        //         $('#tarea').val(`${$('#objetivo').val()}.${select.value}`);
        //         const formulario5 = $('#select-tareaProyecto option:selected').attr('data-value')

        //         $.ajax({
        //             type: "POST",
        //             url: "{{ route('getSaldoFut') }}",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 formulario5: formulario5
        //             },
        //             dataType: "JSON",
        //             success: function(response) {
        //                 let montoAEDisp = 0
        //                 let montoAE = 0
        //                 let fin = 0 // Filtrar por fuente de financiamiento

        //                 $('#financiamientos').empty()

        //                 if (response.length > 0) {
        //                     response.forEach(element => {
        //                         if (fin == 0) {
        //                             $('#financiamientos').append(
        //                                 `<div class="form-group row mt-3">
    //                                 <div class="col-3 d-flex align-items-center">
    //                                     Categoria Progmatica :
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="text" class="form-control" name="categoria_progmatica${element.tipo_financiamiento_id}"
    //                                     id="categoria_progmatica${element.tipo_financiamiento_id}" placeholder="11-1111-111" oninput="formatoProgmatica(this)" maxlength="11">
    //                                 </div>
    //                             </div>
    //                             <div class="form-group row mt-3">
    //                                 <div class="col-3">
    //                                     Organismo financiador :
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <input type="text" class="form-control" id="orgfin${element.tipo_financiamiento_id}" value="${element.codigo}" readonly>
    //                                 </div>
    //                                 <div class="col-4">
    //                                     <input type="text" class="form-control" name="financiamiento_${element.tipo_financiamiento_id}"
    //                                         id="financiamiento_${element.tipo_financiamiento_id}"
    //                                         value="[${element.codigo}] ${element.descripcion}" readonly>
    //                                 </div>
    //                                 <div class="col-1 fw-bold">
    //                                     <label for="fin_${element.tipo_financiamiento_id}">Habilitar: </label>
    //                                     <input class="form-check-input" type="checkbox" role="switch"
    //                                         id="fuente_${element.tipo_financiamiento_id}"
    //                                         name="fuente_${element.tipo_financiamiento_id}"
    //                                         data-value="${element.tipo_financiamiento_id}" data-value-id="${element.formulario5_id}"
    //                                         onchange="checkFinanciamiento(this, ${element.tipo_financiamiento_id})">
    //                                     <input type="hidden" name="formulario5_${element.tipo_financiamiento_id}" id="formulario5_${element.tipo_financiamiento_id}" value="${element.formulario5_id}">
    //                                 </div>
    //                                 <div class="col-2 fw-bold alert alert-primary" id="monto_fin${element.tipo_financiamiento_id}"></div>
    //                             </div>
    //                             <div id="finan_${element.tipo_financiamiento_id}"></div>`
        //                             )
        //                             fin = element.tipo_financiamiento_id
        //                             montoAEDisp = parseFloat(element.total_presupuesto)
        //                             montoAE += parseFloat(element.total_presupuesto)
        //                             $('#monto_fin' + element.tipo_financiamiento_id).text(
        //                                 `Monto disponible: ${montoAEDisp} bs.`)

        //                             $('#fuente_' + element.tipo_financiamiento_id).attr('data-monto',
        //                                 montoAEDisp);
        //                         } else {
        //                             if (fin == element.tipo_financiamiento_id) {
        //                                 montoAEDisp += parseFloat(element.total_presupuesto)
        //                                 montoAE += parseFloat(element.total_presupuesto)
        //                                 $('#monto_fin' + element.tipo_financiamiento_id).text(
        //                                     `Monto disponible: ${montoAEDisp} bs.`)

        //                                 $('#fuente_' + element.tipo_financiamiento_id).attr(
        //                                     'data-monto',
        //                                     montoAEDisp);
        //                             } else {
        //                                 $('#financiamientos').append(`<div class="form-group row mt-3">
    //                                 <div class="col-3 d-flex align-items-center">
    //                                     Categoria Progmatica :
    //                                 </div>
    //                                 <div class="col-3">
    //                                     <input type="text" class="form-control" name="categoria_progmatica${element.tipo_financiamiento_id}"
    //                                     id="categoria_progmatica${element.tipo_financiamiento_id}" placeholder="11-1111-111" oninput="formatoProgmatica(this)" maxlength="11">
    //                                 </div>
    //                             </div>
    //                             <div class="form-group row mt-3">
    //                                 <div class="col-3">
    //                                     Organismo financiador :
    //                                 </div>
    //                                 <div class="col-2">
    //                                     <input type="text" class="form-control" id="orgfin${element.tipo_financiamiento_id}" readonly value="${element.codigo}">
    //                                 </div>
    //                                 <div class="col-4">
    //                                     <input class="form-control" name="financiamiento_${element.tipo_financiamiento_id}"
    //                                         id="financiamiento_${element.tipo_financiamiento_id}"
    //                                         value="[${element.codigo}] ${element.descripcion}" readonly>
    //                                 </div>
    //                                 <div class="col-1 fw-bold">
    //                                     <label for="fin_${element.tipo_financiamiento_id}">Habilitar: </label>
    //                                     <input class="form-check-input" type="checkbox" role="switch"
    //                                         id="fuente_${element.tipo_financiamiento_id}"
    //                                         name="fuente_${element.tipo_financiamiento_id}"
    //                                         data-value="${element.tipo_financiamiento_id}" data-value-id="${element.formulario5_id}" onchange="checkFinanciamiento(this, ${element.tipo_financiamiento_id})">
    //                                     <input type="hidden" name="formulario5_${element.tipo_financiamiento_id}" id="formulario5_${element.tipo_financiamiento_id}" value="${element.formulario5_id}">
    //                                 </div>
    //                                 <div class="col-2 fw-bold alert alert-primary" id="monto_fin${element.tipo_financiamiento_id}"></div>
    //                             </div>
    //                             <div id="finan_${element.tipo_financiamiento_id}"></div>`)
        //                                 fin = element.tipo_financiamiento_id
        //                                 montoAEDisp = parseFloat(element.total_presupuesto)
        //                                 montoAE += parseFloat(element.total_presupuesto)
        //                                 $('#monto_fin' + element.tipo_financiamiento_id).text(
        //                                     `Monto disponible: ${montoAEDisp} bs.`)

        //                                 $('#fuente_' + element.tipo_financiamiento_id).attr(
        //                                     'data-monto',
        //                                     montoAEDisp);
        //                             }
        //                         }
        //                     })
        //                     $('#monto_poa').val(montoAE)
        //                     $('#monto_poa').attr('max', montoAE)
        //                     $('#monto_poa').trigger('change')
        //                 } else {
        //                     // Alerta de que no hay montos disponibles
        //                     $('#financiamientos').append(
        //                         `<br>
    //                         <div class="alert alert-warning" role="alert">
    //                             <b>NO EXISTE MONTO DISPONIBLE PARA LA TAREA O PROYECTO SELECCIONADO.</b>
    //                         </div>`
        //                     )
        //                 }
        //             },
        //             error: function(error) {
        //                 console.log(error)
        //             }
        //         });
        //     }
        // }

        // let partidas_global;
        // let c_partidas_global = 0;

        // function habilitarFinanciamiento(check, id_fin) {
        //     if (check.checked) {
        //         $.ajax({
        //             type: "POST",
        //             url: "{{ route('getSaldoPartidasFut') }}",
        //             data: {
        //                 _token: '{{ csrf_token() }}',
        //                 caja_id: $('#id_caja' + id_fin).val(),
        //                 id_formulado: $('#id_formulado').val(),
        //                 gestiones_id: $('#gestiones_id').val()
        //             },
        //             dataType: "json",
        //             success: function(response) {
        //                 partidas_global = response
        //                 console.log(partidas_global);
        //                 $('#finan_' + id_fin).empty()
        //                 $('#finan_' + id_fin).append(`
    //                                 <div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}0">
    //                                     <div class="col-3 d-flex align-items-center">
    //                                         Partidas presupuestarias de descripcion :
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <input type="text" class="form-control" id="partida_codigo_${id_fin}0"
    //                                             readonly name="partida_${id_fin}0" required>
    //                                         <input type="hidden" id="id_mbs${id_fin}0" name="id_mbs${id_fin}0">
    //                                         <input type="hidden" id="detalle_${id_fin}0"  name="detalle_${id_fin}0">
    //                                     </div>
    //                                     <div class="col-4">
    //                                         <select class="partidas_formulado_${id_fin}0 form-control"
    //                                             onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}0">
    //                                             <option value="">[SELECCIONE OPCION]</option>
    //                                         </select>
    //                                         <span class="text-danger" id="message_${id_fin}0"
    //                                             style="display:none;font-size:12px">Debe
    //                                             seleccionar una opcion.</span>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <span class="text-info" style="font-size:12px">Monto disponible: <span
    //                                                 id="monto_max_${id_fin}0"></span>&nbsp;bs</span>
    //                                         <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01"
    //                                             min="0.00" placeholder="0.00" id="presupuesto_${id_fin}0"
    //                                             onchange="validarMontoMaximo('#presupuesto_${id_fin}0')" readonly name="partida_monto_${id_fin}0" required>
    //                                         <span class="text-danger" id="msg_pres_${id_fin}0" style="font-size:12px"></span>
    //                                     </div>
    //                                     <div class="col-1 d-flex align-items-center">
    //                                         <button type="button" class="btn btn-sm btn-outline-primary" onclick="crearPartida(${id_fin})"
    //                                             id="btn-crear${id_fin}">Agregar</button>
    //                                     </div>
    //                                 </div>`)
        //                 $('#finan_' + id_fin).after(`<div class="mt-3">
    //                                 <div class="row d-flex align-items-center">
    //                                     <div class="col-8"></div>
    //                                     <div class="col-1">TOTAL: </div>
    //                                     <div class="col-2">
    //                                         <input type="hidden" name="cont${id_fin}" id="cont${id_fin}" value="0">
    //                                         <input type="number" class="form-control border-primary" onkeyup="montoNumber(this)"
    //                                             step="0.01" min="0.00" placeholder="0.00" readonly
    //                                             id="total${id_fin}" name="total${id_fin}" onchange="obtenerTotal(${id_fin})">
    //                                     </div>
    //                                     <div class="col-1 d-flex align-items-center">
    //                                     </div>
    //                                 </div>
    //                             </div>`)

        //                 $('.partidas_formulado_' + id_fin + '0').empty()
        //                 $('.partidas_formulado_' + id_fin + '0').append(
        //                     '<option value="">[SELECCIONE OPCION]</option>')
        //                 let monto_totalDisp = 0
        //                 response[0].forEach(element => {
        //                     $('.partidas_formulado_' + id_fin + '0').append(
        //                         `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                     )
        //                     c_partidas_global++
        //                     monto_totalDisp += parseFloat(element.total_presupuesto)
        //                 });
        //                 response[1].forEach(element => {
        //                     $('.partidas_formulado_' + id_fin + '0').append(
        //                         `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                     )
        //                     c_partidas_global++
        //                     monto_totalDisp += parseFloat(element.total_presupuesto)
        //                 });
        //                 response[2].forEach(element => {
        //                     $('.partidas_formulado_' + id_fin + '0').append(
        //                         `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                     )
        //                     c_partidas_global++
        //                     monto_totalDisp += parseFloat(element.total_presupuesto)
        //                 });
        //                 $('#monto_max_' + id_fin + '0').text(monto_totalDisp);
        //                 $('.partidas_formulado_' + id_fin + '0').select2();
        //             },
        //             error: function(error) {
        //                 console.log(error)
        //             }
        //         })
        //     }
        // }

        // function checkFinanciamiento(check, id_fin) {
        //     let monto = parseFloat($('#monto_habilitado').val());

        //     if (check.checked) {
        //         $('#monto_habilitado').val(monto + parseFloat($(check).data('monto')));
        //         // $('#categoria_progmatica' + id_fin).attr('required', 'true');
        //     } else {
        //         $('#monto_habilitado').val(monto - parseFloat($(check).data('monto')));
        //         // $('#categoria_progmatica' + id_fin).removeAttr('required');
        //     }
        // }

        // let partidas_select1 = []
        // let partidas_select2 = []
        // let partidas_select3 = []
        // let partidas_select4 = []
        // let cont1 = 0;
        // let cont2 = 0;
        // let cont3 = 0;
        // let cont4 = 0;

        // function quitarPartida(id, id_fin) {
        //     switch (id_fin) {
        //         case 1:
        //             $('#ppd_' + id_fin + id).remove()
        //             cont1--
        //             $('#btn-crear' + id_fin).attr('style', 'display:block')
        //             $('#partidas_formulado_' + id_fin + (cont1)).removeAttr('disabled')
        //             $('#presupuesto_' + id_fin + cont1).removeAttr('readonly');
        //             $('#btn-eliminar_' + id_fin + (cont1)).attr('style', 'display:block')
        //             $('#cont1').val(cont1)
        //             partidas_select1.pop()
        //             obtenerTotal(id_fin)
        //             break;
        //         case 2:
        //             $('#ppd_' + id_fin + id).remove()
        //             cont2--
        //             $('#btn-crear' + id_fin).attr('style', 'display:block')
        //             $('#partidas_formulado_' + id_fin + (cont2)).removeAttr('disabled')
        //             $('#presupuesto_' + id_fin + cont2).removeAttr('readonly');
        //             $('#btn-eliminar_' + id_fin + (cont2)).attr('style', 'display:block')
        //             $('#cont2').val(cont2)
        //             partidas_select2.pop()
        //             obtenerTotal(id_fin)
        //             break;
        //         case 3:
        //             $('#ppd_' + id_fin + id).remove()
        //             cont3--
        //             $('#btn-crear' + id_fin).attr('style', 'display:block')
        //             $('#partidas_formulado_' + id_fin + (cont3)).removeAttr('disabled')
        //             $('#presupuesto_' + id_fin + cont3).removeAttr('readonly');
        //             $('#btn-eliminar_' + id_fin + (cont3)).attr('style', 'display:block')
        //             $('#cont3').val(cont3)
        //             partidas_select3.pop()
        //             obtenerTotal(id_fin)
        //             break;
        //         case 4:
        //             $('#ppd_' + id_fin + id).remove()
        //             cont4--
        //             $('#btn-crear' + id_fin).attr('style', 'display:block')
        //             $('#partidas_formulado_' + id_fin + (cont4)).removeAttr('disabled')
        //             $('#presupuesto_' + id_fin + cont4).removeAttr('readonly');
        //             $('#btn-eliminar_' + id_fin + (cont4)).attr('style', 'display:block')
        //             $('#cont4').val(cont4)
        //             partidas_select4.pop()
        //             obtenerTotal(id_fin)
        //             break;
        //     }
        // }

        // function cambiarPartida(select, id_fin) {
        //     let presupuesto_total
        //     let id_mbs
        //     let detalle
        //     let titulo
        //     switch (id_fin) {
        //         case 1:
        //             $('#partida_codigo_' + id_fin + cont1).val(select.value)
        //             $('#message_' + id_fin + cont1).attr('style', 'display:none')

        //             titulo = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
        //                 'data-text')
        //             partidas_select1[cont1] = titulo

        //             presupuesto_total = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
        //                 'data-value2')
        //             $('#presupuesto_' + id_fin + cont1).val(presupuesto_total);
        //             $('#monto_max_' + id_fin + cont1).text(presupuesto_total);

        //             id_mbs = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
        //                 'data-value-id')
        //             $('#id_mbs' + id_fin + cont1).val(id_mbs)

        //             detalle = $('#partidas_formulado_' + id_fin + cont1 + ' option:selected').attr(
        //                 'data-id-detalle')
        //             $('#detalle_' + id_fin + cont1).val(detalle)

        //             $('#presupuesto_' + id_fin + cont1).removeAttr('readonly');
        //             $('#presupuesto_' + id_fin + cont1).attr('max', presupuesto_total);
        //             obtenerTotal(id_fin)
        //             console.log(partidas_select1);
        //             break;
        //         case 2:
        //             $('#partida_codigo_' + id_fin + cont2).val(select.value)
        //             $('#message_' + id_fin + cont2).attr('style', 'display:none')

        //             titulo = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
        //                 'data-text')
        //             partidas_select2[cont2] = titulo

        //             presupuesto_total = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
        //                 'data-value2')
        //             $('#presupuesto_' + id_fin + cont2).val(presupuesto_total);
        //             $('#monto_max_' + id_fin + cont2).text(presupuesto_total);

        //             id_mbs = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
        //                 'data-value-id')
        //             $('#id_mbs' + id_fin + cont2).val(id_mbs)

        //             detalle = $('#partidas_formulado_' + id_fin + cont2 + ' option:selected').attr(
        //                 'data-id-detalle')
        //             $('#detalle_' + id_fin + cont2).val(detalle)

        //             $('#presupuesto_' + id_fin + cont2).removeAttr('readonly');
        //             $('#presupuesto_' + id_fin + cont2).attr('max', presupuesto_total);
        //             obtenerTotal(id_fin)
        //             console.log(partidas_select2);
        //             break;
        //         case 3:
        //             $('#partida_codigo_' + id_fin + cont3).val(select.value)
        //             $('#message_' + id_fin + cont3).attr('style', 'display:none')

        //             titulo = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
        //                 'data-text')
        //             partidas_select3[cont3] = titulo

        //             presupuesto_total = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
        //                 'data-value3')
        //             $('#presupuesto_' + id_fin + cont3).val(presupuesto_total);
        //             $('#monto_max_' + id_fin + cont3).text(presupuesto_total);

        //             id_mbs = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
        //                 'data-value-id')
        //             $('#id_mbs' + id_fin + cont3).val(id_mbs)

        //             detalle = $('#partidas_formulado_' + id_fin + cont3 + ' option:selected').attr(
        //                 'data-id-detalle')
        //             $('#detalle_' + id_fin + cont3).val(detalle)

        //             $('#presupuesto_' + id_fin + cont3).removeAttr('readonly');
        //             $('#presupuesto_' + id_fin + cont3).attr('max', presupuesto_total);
        //             obtenerTotal(id_fin)
        //             console.log(partidas_select3);
        //             break;
        //         case 4:
        //             $('#partida_codigo_' + id_fin + cont4).val(select.value)
        //             $('#message_' + id_fin + cont4).attr('style', 'display:none')

        //             titulo = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
        //                 'data-text')
        //             partidas_select4[cont4] = titulo

        //             presupuesto_total = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
        //                 'data-value4')
        //             $('#presupuesto_' + id_fin + cont4).val(presupuesto_total);
        //             $('#monto_max_' + id_fin + cont4).text(presupuesto_total);

        //             id_mbs = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
        //                 'data-value-id')
        //             $('#id_mbs' + id_fin + cont4).val(id_mbs)

        //             detalle = $('#partidas_formulado_' + id_fin + cont4 + ' option:selected').attr(
        //                 'data-id-detalle')
        //             $('#detalle_' + id_fin + cont4).val(detalle)

        //             $('#presupuesto_' + id_fin + cont4).removeAttr('readonly');
        //             $('#presupuesto_' + id_fin + cont4).attr('max', presupuesto_total);
        //             obtenerTotal(id_fin)
        //             console.log(partidas_select4);
        //             break;
        //     }
        // }

        // function obtenerTotal(id_fin) {
        //     let total = 0.00
        //     let presupuesto = 0.00
        //     switch (id_fin) {
        //         case 1:
        //             for (let i = 0; i <= cont1; i++) {
        //                 presupuesto = $('#presupuesto_' + id_fin + i).val()
        //                 total = total + parseFloat(presupuesto)
        //             }
        //             if (total == NaN || total == 0 || total == null) {
        //                 $('#total' + id_fin).val('0.00')
        //             } else {
        //                 $('#total' + id_fin).val(total)
        //             }
        //             break;
        //         case 2:
        //             for (let i = 0; i <= cont2; i++) {
        //                 presupuesto = $('#presupuesto_' + id_fin + i).val()
        //                 total = total + parseFloat(presupuesto)
        //             }
        //             if (total == NaN || total == 0 || total == null) {
        //                 $('#total' + id_fin).val('0.00')
        //             } else {
        //                 $('#total' + id_fin).val(total)
        //             }
        //             break;
        //         case 3:
        //             for (let i = 0; i <= cont3; i++) {
        //                 presupuesto = $('#presupuesto_' + id_fin + i).val()
        //                 total = total + parseFloat(presupuesto)
        //             }
        //             if (total == NaN || total == 0 || total == null) {
        //                 $('#total' + id_fin).val('0.00')
        //             } else {
        //                 $('#total' + id_fin).val(total)
        //             }
        //             break;
        //         case 4:
        //             for (let i = 0; i <= cont4; i++) {
        //                 presupuesto = $('#presupuesto_' + id_fin + i).val()
        //                 total = total + parseFloat(presupuesto)
        //             }
        //             if (total == NaN || total == 0 || total == null) {
        //                 $('#total' + id_fin).val('0.00')
        //             } else {
        //                 $('#total' + id_fin).val(total)
        //             }
        //             break;
        //     }
        // }

        // function crearPartida(id_fin) {
        //     switch (id_fin) {
        //         case 1:
        //             if (validarMontoMaximo('#presupuesto_' + id_fin + cont1)) {
        //                 if (c_partidas_global > cont1 && $('#partida_codigo_' + id_fin + cont1).val() != '') {
        //                     cont1++
        //                     if (c_partidas_global - 1 == cont1) {
        //                         $('#btn-crear' + id_fin).attr('style', 'display:none')
        //                     }
        //                     let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont1}">
    //                                     <div class="col-3"></div>
    //                                     <div class="col-2">
    //                                         <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont1}" readonly name="partida_${id_fin}${cont1}" required>
    //                                         <input type="hidden" name="id_mbs${id_fin}${cont1}" id="id_mbs${id_fin}${cont1}">
    //                                         <input type="hidden" name="detalle_${id_fin}${cont1}" id="detalle_${id_fin}${cont1}">
    //                                     </div>
    //                                     <div class="col-4">
    //                                         <select class="partidas_formulado_${id_fin}${cont1} form-control"
    //                                             onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont1}">
    //                                             <option value="">[SELECCIONE OPCION]</option>`
        //                     partidas_global[0].forEach(element => {
        //                         if (!partidas_select1.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[1].forEach(element => {
        //                         if (!partidas_select1.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[2].forEach(element => {
        //                         if (!partidas_select1.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}" data-text="${element.titulo_detalle}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     newOption = newOption + `</select>
    //                                         <span class="text-danger" id="message_${id_fin}${cont1}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <span class="text-info" style="font-size:12px">Monto total disponible: <span
    //                                                 id="monto_max_${id_fin}${cont1}"></span>&nbsp;bs</span>
    //                                         <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
    //                                             placeholder="0.00" id="presupuesto_${id_fin}${cont1}"
    //                                             onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont1}')" readonly name="partida_monto_${id_fin}${cont1}" required>
    //                                         <span class="text-danger" id="msg_pres_${id_fin}${cont1}" style="font-size:12px"></span>
    //                                     </div>
    //                                     <div class="col-1 d-flex align-items-center">
    //                                         <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont1}', ${id_fin})" id="btn-eliminar_${id_fin}${cont1}">Quitar</button>
    //                                     </div>
    //                                 </div>`
        //                     $('#finan_' + id_fin).append(newOption);
        //                     $('.partidas_formulado_' + id_fin + cont1).select2()

        //                     $('#partidas_formulado_' + id_fin + (cont1 - 1)).attr('disabled', true)
        //                     $('#btn-eliminar_' + id_fin + (cont1 - 1)).attr('style', 'display:none')
        //                     $('#presupuesto_' + id_fin + (cont1 - 1)).attr('readonly', 'readonly')
        //                     $('#message_' + id_fin + cont1).attr('style', 'display:none')
        //                     $('#cont1').val(cont1)
        //                 } else {
        //                     $('#message_' + id_fin + cont1).attr('style', 'display:block')
        //                 }
        //             } else {
        //                 alert('Error')
        //             }
        //             break;
        //         case 2:
        //             if (validarMontoMaximo('#presupuesto_' + id_fin + cont2)) {
        //                 if (c_partidas_global > cont2 && $('#partida_codigo_' + id_fin + cont2).val() != '') {
        //                     cont2++
        //                     if (c_partidas_global - 1 == cont2) {
        //                         $('#btn-crear' + id_fin).attr('style', 'display:none')
        //                     }
        //                     let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont2}">
    //                                     <div class="col-3"></div>
    //                                     <div class="col-2">
    //                                         <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont2}" readonly name="partida_${id_fin}${cont2}" required>
    //                                         <input type="hidden" name="id_mbs${id_fin}${cont2}" id="id_mbs${id_fin}${cont2}">
    //                                         <input type="hidden" name="detalle_${id_fin}${cont2}" id="detalle_${id_fin}${cont2}">
    //                                     </div>
    //                                     <div class="col-4">
    //                                         <select class="partidas_formulado_${id_fin}${cont2} form-control"
    //                                             onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont2}">
    //                                             <option value="">[SELECCIONE OPCION]</option>`
        //                     partidas_global[0].forEach(element => {
        //                         if (!partidas_select2.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[1].forEach(element => {
        //                         if (!partidas_select2.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[2].forEach(element => {
        //                         if (!partidas_select2.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     newOption = newOption + `</select>
    //                                         <span class="text-danger" id="message_${id_fin}${cont2}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <span class="text-info" style="font-size:12px">Monto total disponible: <span
    //                                                 id="monto_max_${id_fin}${cont2}"></span>&nbsp;bs</span>
    //                                         <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
    //                                             placeholder="0.00" id="presupuesto_${id_fin}${cont2}"
    //                                             onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont2}')" readonly name="partida_monto_${id_fin}${cont2}" required>
    //                                         <span class="text-danger" id="msg_pres_${id_fin}${cont2}" style="font-size:12px"></span>
    //                                     </div>
    //                                     <div class="col-1 d-flex align-items-center">
    //                                         <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont2}', ${id_fin})" id="btn-eliminar_${id_fin}${cont2}">Quitar</button>
    //                                     </div>
    //                                 </div>`
        //                     $('#finan_' + id_fin).append(newOption);
        //                     $('.partidas_formulado_' + id_fin + cont2).select2()

        //                     $('#partidas_formulado_' + id_fin + (cont2 - 1)).attr('disabled', true)
        //                     $('#btn-eliminar_' + id_fin + (cont2 - 1)).attr('style', 'display:none')
        //                     $('#presupuesto_' + id_fin + (cont2 - 1)).attr('readonly', 'readonly')
        //                     $('#message_' + id_fin + cont2).attr('style', 'display:none')
        //                     $('#cont2').val(cont2)
        //                 } else {
        //                     $('#message_' + id_fin + cont2).attr('style', 'display:block')
        //                 }
        //             } else {
        //                 alert('Error')
        //             }
        //             break;
        //         case 3:
        //             if (validarMontoMaximo('#presupuesto_' + id_fin + cont3)) {
        //                 if (c_partidas_global > cont3 && $('#partida_codigo_' + id_fin + cont3).val() != '') {
        //                     cont3++
        //                     if (c_partidas_global - 1 == cont3) {
        //                         $('#btn-crear' + id_fin).attr('style', 'display:none')
        //                     }
        //                     let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont3}">
    //                                     <div class="col-3"></div>
    //                                     <div class="col-2">
    //                                         <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont3}" readonly name="partida_${id_fin}${cont3}" required>
    //                                         <input type="hidden" name="id_mbs${id_fin}${cont3}" id="id_mbs${id_fin}${cont3}">
    //                                         <input type="hidden" name="detalle_${id_fin}${cont3}" id="detalle_${id_fin}${cont3}">
    //                                     </div>
    //                                     <div class="col-4">
    //                                         <select class="partidas_formulado_${id_fin}${cont3} form-control"
    //                                             onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont3}">
    //                                             <option value="">[SELECCIONE OPCION]</option>`
        //                     partidas_global[0].forEach(element => {
        //                         if (!partidas_select3.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[1].forEach(element => {
        //                         if (!partidas_select3.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[2].forEach(element => {
        //                         if (!partidas_select3.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     newOption = newOption + `</select>
    //                                         <span class="text-danger" id="message_${id_fin}${cont3}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <span class="text-info" style="font-size:12px">Monto total disponible: <span
    //                                                 id="monto_max_${id_fin}${cont3}"></span>&nbsp;bs</span>
    //                                         <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
    //                                             placeholder="0.00" id="presupuesto_${id_fin}${cont3}"
    //                                             onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont3}')" readonly name="partida_monto_${id_fin}${cont3}" required>
    //                                         <span class="text-danger" id="msg_pres_${id_fin}${cont3}" style="font-size:12px"></span>
    //                                     </div>
    //                                     <div class="col-1 d-flex align-items-center">
    //                                         <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont3}', ${id_fin})" id="btn-eliminar_${id_fin}${cont3}">Quitar</button>
    //                                     </div>
    //                                 </div>`
        //                     $('#finan_' + id_fin).append(newOption);
        //                     $('.partidas_formulado_' + id_fin + cont3).select2()

        //                     $('#partidas_formulado_' + id_fin + (cont3 - 1)).attr('disabled', true)
        //                     $('#btn-eliminar_' + id_fin + (cont3 - 1)).attr('style', 'display:none')
        //                     $('#presupuesto_' + id_fin + (cont3 - 1)).attr('readonly', 'readonly')
        //                     $('#message_' + id_fin + cont3).attr('style', 'display:none')
        //                     $('#cont3').val(cont3)
        //                 } else {
        //                     $('#message_' + id_fin + cont3).attr('style', 'display:block')
        //                 }
        //             } else {
        //                 alert('Error')
        //             }
        //             break;
        //         case 4:
        //             if (validarMontoMaximo('#presupuesto_' + id_fin + cont4)) {
        //                 if (c_partidas_global > cont4 && $('#partida_codigo_' + id_fin + cont4).val() != '') {
        //                     cont4++
        //                     if (c_partidas_global - 1 == cont4) {
        //                         $('#btn-crear' + id_fin).attr('style', 'display:none')
        //                     }
        //                     let newOption = `<div class="form-group row mt-3 d-flex align-items-center" id="ppd_${id_fin}${cont4}">
    //                                     <div class="col-3"></div>
    //                                     <div class="col-2">
    //                                         <input type="text" class="form-control" id="partida_codigo_${id_fin}${cont4}" readonly name="partida_${id_fin}${cont4}" required>
    //                                         <input type="hidden" name="id_mbs${id_fin}${cont4}" id="id_mbs${id_fin}${cont4}">
    //                                         <input type="hidden" name="detalle_${id_fin}${cont4}" id="detalle_${id_fin}${cont4}">
    //                                     </div>
    //                                     <div class="col-4">
    //                                         <select class="partidas_formulado_${id_fin}${cont4} form-control"
    //                                             onchange="cambiarPartida(this, ${id_fin})" id="partidas_formulado_${id_fin}${cont4}">
    //                                             <option value="">[SELECCIONE OPCION]</option>`
        //                     partidas_global[0].forEach(element => {
        //                         if (!partidas_select4.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc3}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[1].forEach(element => {
        //                         if (!partidas_select4.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc4}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     partidas_global[2].forEach(element => {
        //                         if (!partidas_select4.includes(element.titulo_detalle)) {
        //                             newOption = newOption +
        //                                 `<option value="${element.partida}" data-value2="${element.total_presupuesto}" data-value-id="${element.id_mbs}" data-id-detalle="${element.id_dc5}">[${element.partida}] ${element.titulo_detalle}</option>`
        //                         }
        //                     })
        //                     newOption = newOption + `</select>
    //                                         <span class="text-danger" id="message_${id_fin}${cont4}" style="display:none;font-size:12px">Debe seleccionar una opcion.</span>
    //                                     </div>
    //                                     <div class="col-2">
    //                                         <span class="text-info" style="font-size:12px">Monto total disponible: <span
    //                                                 id="monto_max_${id_fin}${cont4}"></span>&nbsp;bs</span>
    //                                         <input type="number" class="form-control" onkeyup="montoNumber(this)" step="0.01" min="0.00"
    //                                             placeholder="0.00" id="presupuesto_${id_fin}${cont4}"
    //                                             onchange="validarMontoMaximo('#presupuesto_${id_fin}${cont4}')" readonly name="partida_monto_${id_fin}${cont4}" required>
    //                                         <span class="text-danger" id="msg_pres_${id_fin}${cont4}" style="font-size:12px"></span>
    //                                     </div>
    //                                     <div class="col-1 d-flex align-items-center">
    //                                         <button type="button" class="btn btn-sm btn-outline-danger" onclick="quitarPartida('${cont4}', ${id_fin})" id="btn-eliminar_${id_fin}${cont4}">Quitar</button>
    //                                     </div>
    //                                 </div>`
        //                     $('#finan_' + id_fin).append(newOption);
        //                     $('.partidas_formulado_' + id_fin + cont4).select2()

        //                     $('#partidas_formulado_' + id_fin + (cont4 - 1)).attr('disabled', true)
        //                     $('#btn-eliminar_' + id_fin + (cont4 - 1)).attr('style', 'display:none')
        //                     $('#presupuesto_' + id_fin + (cont4 - 1)).attr('readonly', 'readonly')
        //                     $('#message_' + id_fin + cont4).attr('style', 'display:none')
        //                     $('#cont4').val(cont4)
        //                 } else {
        //                     $('#message_' + id_fin + cont4).attr('style', 'display:block')
        //                 }
        //             } else {
        //                 alert('Error')
        //             }
        //             break;
        //     }
        // }

        // function validarMontoMaximo(id) {
        //     const monto = parseFloat($(id).val())
        //     const maximo = parseFloat($(id).attr('max'))
        //     if (monto > maximo) {
        //         $('#msg_pres_' + id.charAt(id.length - 1)).text('El monto supera el maximo presupuesto')
        //         return false
        //     } else {
        //         $('#msg_pres_' + id.charAt(id.length - 1)).text('')
        //         obtenerTotal(id.charAt(id.length - 2, 1))
        //         return true
        //     }
        // }



        // function montoNumber(el) {
        //     $(el).val(function(index, value) {
        //         return value.replace(/\D/g, "")
        //             .replace(/([0-9])([0-9]{2})$/, '$1.$2')
        //     });
        // }
    </script>
@endsection
