@extends('principal')
@section('titulo', 'PDU')
@section('contenido')
<div class="page-title-area">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6 col-sm-6">
                <div class="page-title">
                    <h3 class="text-primary">PLAN DE DESARROLLO UNIVERSITARIO (PDU)</h3>
                    <h3 class="text-success">GESTIÓN {{ $gestion->inicio_gestion.' - '.$gestion->fin_gestion }}</h3>
                </div>
            </div>

            <div class="col-lg-6 col-sm-6">
                <ul class="page-title-list">
                    <li>Administracion de PDU</li>
                    <li>PDU</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="default-table-area">
    <div class="container-fluid">
        <div class="card-box-style">
            <div class="table-responsive" >
                <table class="table table-responsive text-center" style="width:100%" >
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>FODA</th>
                            <th>POLITICA DE DESARROLLO</th>
                            <th>OBJETIVO ESTRATEGICO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas_estrategicas as $lis)
                            <tr>
                                <td>{{ $lis->codigo_areas_estrategicas }}</td>
                                <td>{{ $lis->descripcion }}</td>
                                <td>
                                    <a href="{{ route('adm_listar_foda',['id_area_estrategica'=>encriptar($lis->id), 'id_tipo_plan'=>encriptar($tipo_plan)]) }}" class="btn btn-outline-primary btn-sm"><i class="ri-question-answer-fill"></i></a>
                                </td>
                                <td>
                                    <button class="btn btn-outline-info btn-sm" onclick="politica_desarrollo('{{ $lis->id }}')"><i class="ri-chat-poll-fill"></i></button>
                                </td>
                                <td>
                                    <a href="{{ route('adm_objetivo_estrategico', ['id'=>encriptar($lis->id)]) }}" class="btn btn-outline-secondary btn-sm" ><i class="ri-hard-drive-fill"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- POLITICAS DE DESARROLLO -->
    <div class="modal slide" id="modal_politica_desarroollo" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">POLITICA DE DESARROLLO</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="vaciar_campos_cerrar()"></button>
                </div>
                <div class="modal-body">

                    <form id="form_politica_desarrollo" method="post" autocomplete="off">
                        <input type="hidden" name="id_area_estrategica" id="id_area_estrategica">
                        <input type="hidden" name="id_politica_desarrollo" id="id_politica_desarrollo">
                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                        placeholder="Ingrese una gestión inicial" maxlength="2"
                                        onkeypress="return soloNumeros(event)">
                                    <div id="_codigo"></div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" rows="2" placeholder="Descripción"></textarea>
                                    <div id="_descripcion"></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-outline-primary" id="btn_guardar_politica_desarrollo">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="listar_politica_desarrollo_html">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        //abrit el modal y listar las politicas de desarrollo
        function politica_desarrollo(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listar_politica_desarrollo') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('id_area_estrategica').value = id;
                        $('#modal_politica_desarroollo').modal('show');
                        let datos = data.mensaje;
                        let cuerpo = "";
                        for (let key in datos) {
                            cuerpo += '<tr>';
                                cuerpo += "<td>" + datos[key]['codigo'] + "</td>";
                                cuerpo += "<td>" + datos[key]['descripcion'] + "</td>";
                                cuerpo += `<td>
                                    <button type="button" class="btn btn-outline-danger" onclick="eliminar_politica_desarrollo('${datos[key]['id']}','${datos[key]['id_area_estrategica']}')" ><i class="ri-delete-bin-2-fill"></i></button>
                                    <button type="button" class="btn btn-outline-warning" onclick="editar_politica_desarrollo('${datos[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                                </td>`;
                            cuerpo += '</tr>';
                        }
                        document.getElementById('listar_politica_desarrollo_html').innerHTML = cuerpo;
                    }
                    if(data.tipo==='error'){
                        document.getElementById('listar_politica_desarrollo_html').innerHTML = '<p style="text-center" > No hay registros aun</p>';
                    }
                }
            });
        }

        //para guardar politica de desarrollo
        $(document).on('click', '#btn_guardar_politica_desarrollo', (e)=>{
            e.preventDefault();
            vaciar_errores();
            let datos = new FormData(document.getElementById('form_politica_desarrollo'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_politica_desarrollo_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if (data.tipo === 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + obj[key] + '</div>';
                        }
                    }
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        politica_desarrollo(data.id_area_estrategica);
                        vaciar_campos_cerrar();
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para el momento de cerrar
        function vaciar_campos_cerrar(){
            document.getElementById('id_politica_desarrollo').value ='';
            document.getElementById('codigo').value ='';
            document.getElementById('descripcion').value ='';
            vaciar_errores();
        }

        //funcion para vaciar errores
        function vaciar_errores(){
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_descripcion').innerHTML = '';
        }

        //para la parte de la edicion
        function editar_politica_desarrollo(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_politica_desarrollo_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('id_politica_desarrollo').value = data.mensaje.id;
                        document.getElementById('codigo').value = data.mensaje.codigo;
                        document.getElementById('descripcion').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        vaciar_campos_cerrar();
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        //para eliminar la politica de desarrollo
        function eliminar_politica_desarrollo(id, id_area_estrategica){
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
                        url: "{{ route('adm_politica_desarrollo_eliminar') }}",
                        data: {id: id, id_area_estrategica:id_area_estrategica},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                vaciar_campos_cerrar();
                                alerta_top(data.tipo, data.mensaje);
                                politica_desarrollo(id_area_estrategica);
                            }
                            if (data.tipo === 'error') {
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr["error"]("Se cancelo!");
                }
            })
        }

    </script>
@endsection
