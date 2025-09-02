@extends('principal')
@section('titulo', 'Asinar Financiamiento')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>GESTION : {{ $gestion_seleccionada->gestion }}</h5>
                        <h5>TIPO : {{ $tipo_carreraUnidadArea->nombre }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="others-title d-flex align-items-center">
                    <h3>LISTADO DE {{ $tipo_carreraUnidadArea->nombre }}</h3>
                    <div class=" ms-auto position-relative">
                        <form action="{{ route('pdf_asignacion_montos') }}" method="POST" autocomplete="off" target="_blank">
                            @csrf
                            <input type="hidden" name="id_ges" value="{{ $gestion_seleccionada->id }}">
                            <input type="hidden" name="id_tcau" value="{{ $tipo_carreraUnidadArea->id }}">
                            <input type="hidden" name="id_gestiones" value="{{ $gestion_seleccionada->id }}">
                            <button type="submit" class="btn btn-danger">Exportar en PDF</button>
                        </form>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" >
                        <div class="py-3">
                            <input type="text" class="form-control" placeholder="Ingrese nombre completo a buscar" onkeyup="buscador_listado(this.value)">
                        </div>
                    </div>
                </div>
                <div id="listar_tipoCarreraTabla"></div>
            </div>
        </div>
    </div>

    <!-- Modal  editar foda-->
    <div class="modal zoom" id="modal_financiar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="titulo_editar">Asignar Montos</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciar_selectInput()" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_financiamiento" method="POST" autocomplete="off">
                        <input type="hidden" name="id_caja" id="id_caja"  >
                        <input type="hidden" name="unidadCareraArea" id="unidadCareraArea">
                        <input type="hidden" name="gestiones_idSelec" id="gestiones_idSelec" value="{{ $gestion_seleccionada->id }}">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" >
                                <label id="tipo_seleccionado">Seleccione tipo de financiamiento</label>
                                <div class="py-3">
                                    <select name="tipo_de_financiamiento" id="tipo_de_financiamiento" class="form-select" style="font-size: 16px">
                                        <option value="selected" selected disabled>[SELECCIONE TIPO DE FINANCIAMIENTO]</option>
                                        @foreach ($fuente_financiamiento as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->sigla.' : '.$lis->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_tipo_de_financiamiento" ></div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4" >
                                <label id="tipo_seleccionado">Monto a asignar</label>
                                <div class="py-3">
                                    <input type="text" class="form-control monto_number" name="monto" id="monto">
                                    <div id="_monto" ></div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 text-center" >
                                <label id="tipo_seleccionado"></label>
                                <div class="py-3">
                                    <button class="btn btn-outline-primary" id="btn_guardarFinanciamiento">Guardar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 text-center">
                                <div class="py-3">
                                    <input type="file" id="documento_privado" name="documento_privado" class="form-control" accept=".pdf"/>
                                    <div id="error_mensaje"></div>
                                    <div id="_documento_privado"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 text-center">
                                <embed id="vizualizar_pdf" type="application/pdf" width="300" height="300">
                            </div>
                        </div>

                    </form>
                    <div id="listar_cajaFinanciada" >

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script>
        let id_gestiones = {{ $gestion_seleccionada->id }}
        let id_tipo_carreraAreaUnidad = {{ $tipo_carreraUnidadArea->id }}
        function listar_tipoCarreraUnidadArea(id_ges, id_tcau){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listarCua') }}",
                data: {
                    id_ges  :   id_ges,
                    id_tcau :   id_tcau,
                },
                success: function (data) {
                    document.getElementById('listar_tipoCarreraTabla').innerHTML = data;
                }
            });
        }


        listar_tipoCarreraUnidadArea(id_gestiones,id_tipo_carreraAreaUnidad);

        //buscador de listado
        function buscador_listado(nombre){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_buscador_listado') }}",
                data: {
                    id_ges  :   id_gestiones,
                    id_tcau :   id_tipo_carreraAreaUnidad,
                    nombre  :   nombre,
                },
                success: function (data) {
                    document.getElementById('listar_tipoCarreraTabla').innerHTML = data;
                }
            });
        }

        //para asiganr el monto de dinero
        function asignarFinanciamientoCarreraUnidad(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_caja_financiamientoCarrera') }}",
                data: {
                    id:id,
                    id_gestiones:id_gestiones
                },
                success: function (data) {
                    $('#modal_financiar').modal('show');
                    document.getElementById('unidadCareraArea').value = id;
                    document.getElementById('listar_cajaFinanciada').innerHTML=data;
                    document.getElementById('id_caja').value = '';
                    //document.getElementById('gestiones_idSelec').value=id_gestiones;
                }
            });
        }

        //para guardar el monto y el tipo de financiamiento
        $(document).on('click', '#btn_guardarFinanciamiento', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_financiamiento'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_caja_finaCGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciar_errores();
                    if(data.tipo=='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = `<p id="error_in" >`+obj[key]+`</p>`;
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        asignarFinanciamientoCarreraUnidad(data.id_carreraC);
                        vaciar_selectInput();
                        listar_tipoCarreraUnidadArea(id_gestiones,id_tipo_carreraAreaUnidad);
                        vaciar_pdf();
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                        vaciar_selectInput();
                    }
                }
            });
        });
        //vaciar el select y el input
        function vaciar_selectInput(){
            document.getElementById('monto').value = '';
            $("#tipo_de_financiamiento").val('selected').trigger('change');
            document.getElementById('id_caja').value = '';
            vaciar_errores();
            vaciar_pdf();
        }
        //para vaciar los errores
        function vaciar_errores(){
            document.getElementById('_tipo_de_financiamiento').innerHTML = '';
            document.getElementById('_monto').innerHTML = '';
            document.getElementById('_documento_privado').innerHTML = '';
        }

        //para editar elt tipo de financiamiento: saldo
        function editar_financiamientoTipo(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_caja_finanaciadaCEditar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('id_caja').value = data.mensaje.id;
                        document.getElementById('tipo_de_financiamiento').value = data.mensaje.financiamiento_tipo_id;
                        document.getElementById('monto').value = data.monto_rec;

                        let documentoPrivado = data.mensaje.documento_privado;
                        let urlDocumento = "{{ asset('documento_privado/') }}/" + documentoPrivado;
                        document.querySelector('#vizualizar_pdf').setAttribute('src', urlDocumento);
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        document.querySelector('#documento_privado').addEventListener('change', () => {
            let fileInput = document.querySelector('#documento_privado');
            let file = fileInput.files[0];
            let error_mensaje = document.getElementById('error_mensaje');
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    error_mensaje.innerHTML = `<p id="error_in" >El archivo supera el límite de tamaño permitido (2MB).</p>`;
                    fileInput.value = '';
                    return;
                }
                error_mensaje.innerHTML = '';
                // Verificar la extensión del archivo
                if (file.type !== 'application/pdf') {
                    error_mensaje.innerHTML = `<p id="error_in" >Por favor, seleccione un archivo PDF.</p>`;
                    this.value = '';
                    return;
                }
                error_mensaje.innerHTML = '';
                let pdfURL = URL.createObjectURL(file);
                document.querySelector('#vizualizar_pdf').setAttribute('src', pdfURL);
            }
        });


        function vaciar_pdf(){
            document.querySelector('#vizualizar_pdf').setAttribute('src', '');
            document.getElementById('documento_privado').value = '';
        }

    </script>
@endsection
