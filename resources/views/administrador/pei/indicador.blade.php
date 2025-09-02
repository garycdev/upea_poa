@extends('principal')
@section('titulo', 'Indicador')
@section('estilos')
    <link rel="stylesheet" type="text/css" href="{{ asset('plantilla_admin/data_tables/css_botones/buttons.dataTables.min.css') }}"/>
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5 >GESTIÓN : {{ $gestion->inicio_gestion.' - '.$gestion->fin_gestion }}</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administración de Indicadores</li>
                        <li>Indicador</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <h3 class="text-primary">INDICADORES ESTRATÉGICOS</h3>
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_indicador"  ><i class="bx bxs-add-to-queue"></i> Nuevo Indicador</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-responsive  text-center table-hover" id="prueba_tabla" style="width:100%" >
                        <thead>
                            <tr>
                                <th class="imprimir">CÓDIGO</th>
                                <th class="imprimir">DESCRIPCIÓN</th>
                                <th class="imprimir">ESTADO</th>
                                <th >ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider ">
                            @foreach ($indicador as $lis)
                                <tr>
                                    <td class="imprimir">{{ $lis->codigo }}</td>
                                    <td class="imprimir" >{{ $lis->descripcion }}</td>
                                    <td class="imprimir" >
                                        @if ($lis->estado=='activo')
                                            <span class='badge text-bg-success'>{{ $lis->estado }}</span>
                                        @else
                                            <span class='badge text-bg-danger'>{{ $lis->estado }}</span>
                                        @endif
                                    </td>
                                    <td>

                                        <button type="button" class="btn btn-outline-warning" onclick="editar_indicador('{{ $lis->id }}')"><i class="ri-edit-2-fill"></i></button>
                                        @can('indicador_eliminar')
                                            <button class="btn btn-outline-danger btn-sm" onclick="eliminar_indicador('{{ $lis->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  de nuevo indicador-->
    <div class="modal zoom" id="nuevo_indicador" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">INDICADORES ESTRATÉGICOS</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"  onclick="cerrar_modal_indicador()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_indicadores" method="post" autocomplete="off">
                        <input type="hidden" name="gestion_id" id="gestion_id" value="{{ $id_gestion }}" >
                        <div class="row">
                            <div class="mb-3 text-center">
                                <div id="alerta_nota">
                                    <p>! NOTA ¡ : Se recomienda empezar el codigo en {{ $contador_indicador+1 }}!</p>
                                    <p>! NOTA ¡ : Se podra agregar maximo de {{ maximo_agregar() }} registros a la vez!</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label id="tipo_seleccionado">INGRESE LOS INDICADORES</label>
                                <div id="repetir_indicadores">
                                    <div class="form-group">
                                        <div data-repeater-list="repetir_indicadores">
                                            <div data-repeater-item>
                                                <div class="row text-center d-flex justify-content-center align-items-center">
                                                    <div class="col-md-2 col-lg-2 col-xl-2" >
                                                        <label for="" class="form-label"></label>
                                                        <input type="text" class="form-control" name="codigo" id="codigo" onkeypress="return soloNumeros(event)" maxlength="3">
                                                    </div>
                                                    <div class="col-md-8 col-lg-8 col-xl-8" >
                                                        <label for="" class="form-label"></label>
                                                        <textarea name="descripcion" class="form-control" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-2 col-lg-2 col-xl-2 my-1">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-outline-danger mt-3">
                                                            <i class="ri-close-circle-fill"></i> Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:;" data-repeater-create class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="ri-add-line"></i> Agregar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_indicador()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_indicador"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Indicadores</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  de editar el indicador-->
    <div class="modal zoom" id="editar_indicador" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR INDICADOR ESTRATÉGICO</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_indicadores_edi" method="post" autocomplete="off">
                        <input type="hidden" name="gestion_id" id="gestion_id" value="{{ $id_gestion }}" >
                        <input type="hidden" name="id_indicador" id="id_indicador" >
                        <div class="row">
                            <div class="row text-center d-flex justify-content-center align-items-center">
                                <div class="col-md-2 col-lg-2 col-xl-2" >
                                    <label for="" class="form-label">Código</label>
                                    <input type="text" class="form-control" name="codigo" id="codigo_e" onkeypress="return soloNumeros(event)" maxlength="2">
                                    <div id="_codigo" ></div>
                                </div>
                                <div class="col-md-10 col-lg-10 col-xl-10" >
                                    <label for="" class="form-label">Descripción</label>
                                    <textarea name="descripcion" id="descripcion_e" class="form-control" cols="30" rows="3"></textarea>
                                    <div id="_descripcion" ></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_indicador()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_indicador_editado"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Indicador</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('plantilla_admin/data_tables/js_botones/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plantilla_admin/data_tables/js_botones/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('plantilla_admin/data_tables/js_botones/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plantilla_admin/data_tables/js_botones/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plantilla_admin/data_tables/js_botones/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plantilla_admin/data_tables/js_botones/vfs_fonts.js') }}"></script>
    <script>
        repetir_x('#repetir_indicadores');

        function cerrar_modal_indicador(){
            limpiar_campos('form_indicadores');
        }


        let gesti_inicio = {{ $gestion->inicio_gestion }};
        let gesti_fin = {{ $gestion->fin_gestion}};


        $(document).ready(function() {
            let table = $('#prueba_tabla').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        text: 'Exportar a PDF',
                        title: 'INDICADORES ESTRATÉGICOS GESTIÓN '+gesti_inicio+' - '+gesti_fin,
                        exportOptions: {
                            modifier: {
                                selected: true
                            },
                            columns: '.imprimir'
                        }
                    },
                    'selectAll',
                    'selectNone'
                ],
                select: {
                    style: 'multi'
                }
            });

            table.buttons().container().appendTo('#prueba_tabla_wrapper .col-md-6:eq(0)');
        });

        //para guardar indicador
        $(document).on('click', '#btn_guardar_indicador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_indicadores'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_indicador_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#nuevo_indicador').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para editar el indicador
        function editar_indicador(id){
            errores_edicion();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_indicador_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_indicador').modal('show');
                        document.getElementById('codigo_e').value = data.mensaje.codigo;
                        document.getElementById('descripcion_e').value = data.mensaje.descripcion;
                        document.getElementById('id_indicador').value = data.mensaje.id;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //eliminar los errores
        function errores_edicion(){
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_descripcion').innerHTML = '';
        }

        //para guardar el indicador
        $(document).on('click', '#btn_guardar_indicador_editado', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_indicadores_edi'));
            errores_edicion();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_indicador_editar_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            $('#editar_indicador').modal('hide');
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //eliminar indicador
        function eliminar_indicador(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de eliminar el registro?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_indicador_eliminar') }}",
                        data: { id:id },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                setTimeout(() => {
                                    window.location='';
                                }, 1500);
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
    </script>
@endsection
