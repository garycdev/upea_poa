@extends('principal')
@section('titulo', 'Cua')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
@endsection

@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>TIPO</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Configuración</li>
                        <li>TIPO</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <h3></h3>
                <div class="others-title d-flex align-items-center">
                    {{-- <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_tipoCarreraUnidad"> <i class="bx bxs-add-to-queue"></i>Nuevo Tipo</button>
                    </div> --}}
                </div>

                <div class="ag-courses_box">
                    @foreach ($listar_tipo_c as $lis)
                        <div class="ag-courses_item">

                            <a href="{{ route('adm_cua_adminlistar', ['id'=>encriptar($lis->id)]) }}" class="ag-courses-item_link">
                                <div class="ag-courses-item_bg" ></div>
                                <div class="ag-courses-item_title" id="img_carreras">
                                    {{ $lis->nombre }}
                                </div>
                            </a>
                        </div>
                        {{-- <button class="btn btn-outline-danger" onclick="editarTipoCarreraUnidadad('{{ $lis->id }}')" >Editar</button> --}}
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <!--MODAL PARA CREAR NUEVO TIPO-->
    <div class="modal slide" id="nuevo_tipoCarreraUnidad" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO TIPO DE FORMULADO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciar_errores()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_nuevo_tipoCarreraUnidad" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo" class="form-label">Ingrese Titulo</label>
                                <input type="text" name="titulo" id="titulo" class="form-control">
                                <div id="_titulo" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciar_errores()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_Tipo"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Tipo</button>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL PARA EDITAR TIPO-->
    <div class="modal slide" id="editar_tipoCarreraUnidad" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO TIPO DE FORMULADO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciar_errores()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_editar_tipoCarreraUnidad" method="POST" autocomplete="off">
                        <input type="hidden" name="id_tipoCarrera" id="id_tipoCarrera">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo_" class="form-label">Ingrese Titulo</label>
                                <input type="text" name="titulo_" id="titulo_" class="form-control">
                                <div id="_titulo_" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciar_errores()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_TipoEditar"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Tipo</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        //para guardar el tipo de carrea unidades administrativas
        $(document).on('click', '#btn_guardar_Tipo', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_nuevo_tipoCarreraUnidad'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cua_adminGuardar') }}",
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
                            $('#nueva_foda').modal('hide');
                            window.location='';
                        }, 1000);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para vaciar los datos y elo errores
        function vaciar_errores(){
            limpiar_campos('form_nuevo_tipoCarreraUnidad');
            document.getElementById('_titulo').innerHTML = '';
        }
        //para la parte de la edicion
        function editarTipoCarreraUnidadad(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cua_adminEditar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_tipoCarreraUnidad').modal('show');
                        document.getElementById('id_tipoCarrera').value = data.mensaje.id;
                        document.getElementById('titulo_').value = data.mensaje.nombre;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para guardar lo editado
        $(document).on('click', '#btn_guardar_TipoEditar', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_editar_tipoCarreraUnidad'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cua_adminEguardar') }}",
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
                            $('#editar_tipoCarreraUnidad').modal('hide');
                            window.location='';
                        }, 1000);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

    </script>
@endsection
