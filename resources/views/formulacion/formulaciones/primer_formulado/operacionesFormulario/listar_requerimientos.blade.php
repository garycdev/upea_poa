@extends('principal')
@section('titulo', 'Formulario Nº 5')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="page-title">
                        {{-- <h5>TIPO : {{ $tipo_formulado->descripcion }}</h5>
                        <h5>FORMULARIO Nº 5 </h5>
                        <h5>GESTIÓN : {{ $gestiones->gestion }}</h5>
                        <h5>{{ $carrera_unidad->nombre_completo }}</h5>
                        <h5>ÁREA ESTRATÉGICA : {{ $areas_estrategicas->descripcion }}</h5> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">

                <div class="row" >
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                        <div class="alert alert-primary text-center" role="alert">
                            <strong >OPERACIÓN : </strong>
                            <hr>
                            {{ $listar_form5->operacion->descripcion }}
                        </div>
                    </div>
                </div>

                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary">FORMULARIO Nº 5 (Requerimientos)</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-responsive table-hover" style="width: 100%; font-size:12px">
                        <thead>
                            <tr>
                                <th>REMOVER</th>
                                <th>EDITAR</th>
                                <th>DESCRIPCIÓN BIEN O SERVICIO</th>
                                <th>MEDIDA</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO UNITARIO</th>
                                <th>TOTAL PRESUPUESTO</th>
                                <th>PARTIDA POR OBJETO DE GASTO</th>
                                <th>FUENTE DE FINANCIAMIENTO</th>
                                <th>FECHA EN LA QUE SE REQUIERE</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($listar_form5->medida_bien_serviciof5 as $lis)
                                <tr>
                                    <td >
                                        <button class="btn btn-outline-danger btn-sm" onclick="eliminar_registro_req('{{ $listar_form5->id }}','{{ $lis->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm" onclick="editar_registro_req('{{ $listar_form5->id }}','{{ $lis->id }}')"><i class="ri-edit-2-fill"></i></button>
                                    </td>
                                    @if (count($lis->detalle_tercer_clasificador) > 0)
                                    <td>{{ $lis->detalle_tercer_clasificador[0]->titulo }}</td>
                                    @endif

                                    @if (count($lis->detalle_cuarto_clasificador) > 0)
                                    <td>{{ $lis->detalle_cuarto_clasificador[0]->titulo }}</td>
                                    @endif

                                    @if (count($lis->detalle_quinto_clasificador) > 0)
                                    <td>{{ $lis->detalle_quinto_clasificador[0]->titulo }}</td>
                                    @endif

                                    <td>
                                        {{ $lis->medida->nombre }}
                                    </td>
                                    <td>
                                        {{ $lis->cantidad }}
                                    </td>
                                    <td>
                                        @if (is_numeric($lis->precio_unitario))
                                            {{ con_separador_comas($lis->precio_unitario).' Bs' }}
                                        @else
                                            {{ $lis->precio_unitario }}
                                        @endif

                                    </td>
                                    <td>

                                        @if (is_numeric($lis->total_presupuesto))
                                            {{ con_separador_comas($lis->total_presupuesto).' Bs' }}
                                        @else
                                            {{ $lis->total_presupuesto }}
                                        @endif
                                    </td>

                                    @if (count($lis->detalle_tercer_clasificador) > 0)
                                    <td>{{ $lis->detalle_tercer_clasificador[0]->clasificador_tercero->codigo }}</td>
                                    @endif

                                    @if (count($lis->detalle_cuarto_clasificador) > 0)
                                    <td>{{ $lis->detalle_cuarto_clasificador[0]->clasificador_cuarto->codigo }}</td>
                                    @endif

                                    @if (count($lis->detalle_quinto_clasificador) > 0)
                                    <td>{{ $lis->detalle_quinto_clasificador[0]->clasificador_quinto->codigo }}</td>
                                    @endif

                                    <td>
                                        {{ $lis->tipo_financiamiento->sigla }}
                                    </td>
                                    <td>
                                        {{ fecha_literal($lis->fecha_requerida,2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO --}}
    <div class="modal slide" id="editar_requerimiento" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR EL REQUERIMIENTO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModal_requerimiento()"></button>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
                            <fieldset>
                                <legend>BIEN O SERVICIO</legend>
                                <div class="alert alert-primary alert-dismissible fade show text-center" role="alert" id="detalles_clasificador">

                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <fieldset>
                                <legend>MEDIDA</legend>
                                <div class="alert alert-primary alert-dismissible fade show text-center" role="alert" id="medida">

                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                            <fieldset>
                                <legend>FUENTE DE FINANCIAMIENTO</legend>
                                <div class="alert alert-primary alert-dismissible fade show text-center" role="alert" id="fuente_financiamiento">

                                </div>
                                <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="monto_asignacion_sobrante">

                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <form id="form_requerimientos_f5" method="POST" autocomplete="off">

                        <input type="hidden" name="medida_bn_servicio" id="medida_bn_servicio">
                        <input type="hidden" name="monto_asignaion_monto_f4" id="monto_asignaion_monto_f4">

                        <input type="hidden" name="cantidad_ant" id="cantidad_ant">
                        <input type="hidden" name="precio_unitario_ant" id="precio_unitario_ant">
                        <fieldset>
                            <legend> OPCIONES A EDITAR </legend>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <select name="valor" id="valor" class="form-select" onchange="seleccion_opcion(this.value)">
                                            <option value="selected" disabled selected>[SELECCIONE UNA OPCIÓN]</option>
                                            <option value="cantidad">Cantidad</option>
                                            <option value="precio_unitario">Precio Unitario</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type="text" class="form-control" id="cantidad" name="cantidad" onkeyup="cantidad_unitario_edit(this.value)" placeholder="Cantidad" maxlength="10" disabled>
                                        <div id="_cantidad"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                        <input type="text" class="form-control monto_number" id="precio_unitario" name="precio_unitario" onkeyup="precio_unitario_edit(this.value)" placeholder="Precio unitario" disabled>
                                        <div id="_precio_unitario"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-2">
                                    <div class="mb-2">
                                        <label for="total_presupuesto" class="form-label">Total presupuesto</label>
                                        <input type="text" class="form-control monto_number" id="total_presupuesto" name="total_presupuesto" placeholder="Presupuesto total" disabled>
                                        <div id="_total_presupuesto"></div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <input type="hidden" name="total_presupuesto_anterior" id="total_presupuesto_anterior">
                        <input type="hidden" name="total_presupuesto_nuevo" id="total_presupuesto_nuevo">
                        <input type="hidden" name="nuevo_asignacion_monto" id="nuevo_asignacion_monto">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrarModalf4()" >Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarF5_reque" @disabled(true)> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        //para la parte de eliminar registro
        function eliminar_registro_req(id_form5, id_requerimiento){


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de remover el registro?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Remover!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('req_eliminar') }}",
                        data: {
                            id_form5:id_form5,
                            id_requerimiento:id_requerimiento
                        },
                        dataType: "JSON",
                        success: function (data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                window.location = '';
                            }
                            if (data.tipo === 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            });
        }
        //para historial de asignacion de monto
        function editar_registro_req(id_form5, id_requerimiento){
            $.ajax({
                type: "POST",
                url: "{{ route('req_editar') }}",
                data: {
                    id_form5:id_form5,
                    id_requerimiento:id_requerimiento
                },
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    let descripcion_clasificador;
                    let codigo_clasificador;
                    if(data.requerimiento.detalle_tercer_clasificador){
                        if(data.requerimiento.detalle_tercer_clasificador.length > 0){
                            codigo_clasificador         = data.requerimiento.detalle_tercer_clasificador[0].clasificador_tercero.codigo;
                            descripcion_clasificador    = data.requerimiento.detalle_tercer_clasificador[0].titulo;
                        }
                    }

                    if(data.requerimiento.detalle_cuarto_clasificador){
                        if(data.requerimiento.detalle_cuarto_clasificador.length > 0){
                            codigo_clasificador         = data.requerimiento.detalle_cuarto_clasificador[0].clasificador_cuarto.codigo;
                            descripcion_clasificador    = data.requerimiento.detalle_cuarto_clasificador[0].titulo;
                        }
                    }

                    if(data.requerimiento.detalle_quinto_clasificador){
                        if(data.requerimiento.detalle_quinto_clasificador.length > 0){
                            codigo_clasificador         = data.requerimiento.detalle_quinto_clasificador[0].clasificador_quinto.codigo;
                            descripcion_clasificador    = data.requerimiento.detalle_quinto_clasificador[0].titulo;
                        }
                    }

                    $('#editar_requerimiento').modal('show');
                    document.getElementById('detalles_clasificador').innerHTML = `
                        <strong>Clasificador Nº : `+codigo_clasificador+`</strong>
                        <p>`+descripcion_clasificador+`</p>
                    `;
                    document.getElementById('medida').innerHTML = `<strong>`+data.requerimiento.medida.nombre+`</strong>`;
                    document.getElementById('fuente_financiamiento').innerHTML = `<strong>`+data.asignacion_monto_f4.financiamiento_tipo.sigla+`</strong>
                    <p>"`+data.asignacion_monto_f4.financiamiento_tipo.descripcion+`"</p>
                    `;
                    document.getElementById('medida_bn_servicio').value = data.requerimiento.id;

                    //aqui realizamos lo que es de la fuente de financiamiento cuanto tenemos
                    document.getElementById('monto_asignacion_sobrante').innerHTML = `<strong>`+data.monto_asignacion_actual+` Bs</strong>`;

                    //ahora en la parte de cantidad , precio unitario y total presupuesto debemos completar
                    document.getElementById('cantidad_ant').value = data.requerimiento.cantidad;
                    document.getElementById('cantidad').value = data.requerimiento.cantidad;
                    document.getElementById('precio_unitario_ant').value = data.preacio_unitario;
                    document.getElementById('precio_unitario').value = data.preacio_unitario;
                    document.getElementById('total_presupuesto').value = data.total_presupuesto+' Bs';
                    document.getElementById('total_presupuesto_anterior').value = data.total_presupuesto;
                    document.getElementById('monto_asignaion_monto_f4').value = data.asignacion_monto_f4.id;
                }
            });
        }

        //para cerrar el modal
        function cerrarModal_requerimiento(){
            document.getElementById('cantidad').disabled        = true;
            document.getElementById('precio_unitario').disabled = true;
            document.getElementById('valor').value              = 'selected';

            document.getElementById('total_presupuesto_nuevo').value = '';
        }

        //para editar
        function seleccion_opcion(valor){
            let input_cantidad          = document.getElementById('cantidad');
            let input_precio_unitario   = document.getElementById('precio_unitario');

            let input_cantidad_ant          = document.getElementById('cantidad_ant').value;
            let input_precio_unitario_ant   = document.getElementById('precio_unitario_ant').value;

            switch (valor) {
                case 'cantidad':
                    //input_cantidad.value = '';
                    input_cantidad.disabled = false;
                    //input_precio_unitario.value = '';
                    input_precio_unitario.disabled = true;
                break;

                case 'precio_unitario':
                    //input_cantidad.value = '';
                    input_cantidad.disabled = true;
                    //input_precio_unitario.value = '';
                    input_precio_unitario.disabled = false;
                break;
            }
        }

        let btn_para_guardar = document.getElementById('btn_guardarF5_reque');

        //para el precio  unitario
        function cantidad_unitario_edit(valor){
            let id_monto_asignacion_f4 = document.getElementById('monto_asignaion_monto_f4').value;

            let precio_unitario = document.getElementById('precio_unitario').value;
            let total_presupuesto_ant = document.getElementById('total_presupuesto_anterior').value;

            let cantidad_ant = document.getElementById('cantidad_ant').value;

            $.ajax({
                type: "POST",
                url: "{{ route('req_validar') }}",
                data: {
                    valor                   : valor,
                    precio_unitario         : precio_unitario,
                    total_presupuesto_ant   : total_presupuesto_ant,
                    id_monto_asignacion_f4  : id_monto_asignacion_f4,
                },
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    if(data.tipo==='success'){
                        document.getElementById('total_presupuesto').value = data.total_presupuesto_n;
                        document.getElementById('total_presupuesto_nuevo').value = data.total_presupuesto_n;

                        //aqui realizamos lo que es de la fuente de financiamiento cuanto tenemos
                        document.getElementById('monto_asignacion_sobrante').innerHTML = `<strong>`+data.nuevo_saldo_n+` Bs</strong>`;
                        btn_para_guardar.disabled = false;
                        document.getElementById('nuevo_asignacion_monto').value = data.nuevo_saldo_n;
                    }
                    if(data.tipo==='error'){
                        document.getElementById('total_presupuesto').value = data.total_presupuesto_n;
                        document.getElementById('total_presupuesto_nuevo').value = '';
                        document.getElementById('cantidad').value = cantidad_ant;

                        //aqui realizamos lo que es de la fuente de financiamiento cuanto tenemos
                        document.getElementById('monto_asignacion_sobrante').innerHTML = `<strong>`+data.nuevo_saldo_n+` Bs</strong>`;
                        alerta_top('error', 'No puede superar el monto de : '+data.nuevo_saldo_n+' Bs' );

                        document.getElementById('nuevo_asignacion_monto').value = '';
                        btn_para_guardar.disabled = true;
                    }
                }
            });
        }

        function precio_unitario_edit(valor){
            let id_monto_asignacion_f4  = document.getElementById('monto_asignaion_monto_f4').value;

            let cantidad                = document.getElementById('cantidad').value;
            let total_presupuesto_ant   = document.getElementById('total_presupuesto_anterior').value;

            let precio_unitario_ant     = document.getElementById('precio_unitario_ant').value;
            if(valor){
                let monto_validado = monto_validado_enviado(valor);
                $.ajax({
                    type: "POST",
                    url: "{{ route('req_validar1') }}",
                    data: {
                        monto_validado:monto_validado,
                        cantidad:cantidad,
                        id_monto_asignacion_f4:id_monto_asignacion_f4,
                        total_presupuesto_ant:total_presupuesto_ant,
                    },
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data);
                        if(data.tipo==='success'){
                            document.getElementById('total_presupuesto').value          = data.total_presupuesto_n1;
                            document.getElementById('total_presupuesto_nuevo').value    = data.total_presupuesto_n1;

                            //aqui realizamos lo que es de la fuente de financiamiento cuanto tenemos
                            document.getElementById('monto_asignacion_sobrante').innerHTML = `<strong>`+data.nuevo_saldo_n1+` Bs</strong>`;
                            btn_para_guardar.disabled = false;
                            document.getElementById('nuevo_asignacion_monto').value = data.nuevo_saldo_n1;
                        }
                        if(data.tipo==='error'){
                            document.getElementById('total_presupuesto').value          = data.total_presupuesto_n1;
                            document.getElementById('total_presupuesto_nuevo').value    = '';
                            document.getElementById('precio_unitario').value            = precio_unitario_ant;

                            //aqui realizamos lo que es de la fuente de financiamiento cuanto tenemos
                            document.getElementById('monto_asignacion_sobrante').innerHTML = `<strong>`+data.nuevo_saldo_n1+` Bs</strong>`;
                            alerta_top('error', 'No puede superar el monto de : '+data.nuevo_saldo_n1+' Bs' );

                            document.getElementById('nuevo_asignacion_monto').value = '';
                            btn_para_guardar.disabled = true;
                        }
                    }
                });
            }
        }

        //para guardar la funcion
        $(document).on('click','#btn_guardarF5_reque', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_requerimientos_f5'));
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro con los datos ingresados?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Seguro!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('req_guardar_requerimiento_editado') }}",
                        data: datos,
                        dataType: "JSON",
                        cache:false,
                        processData:false,
                        contentType:false,
                        success: function (data) {
                            console.log(data);
                            if(data.tipo=='success'){
                                alerta_top(data.tipo, data.mensaje);
                                setTimeout(() => {
                                    $('#editar_requerimiento').modal('hide');
                                    window.location = '';
                                }, 1500);
                            }
                            if(data.tipo=='error'){
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            })
        });

    </script>
@endsection
