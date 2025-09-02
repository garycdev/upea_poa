@extends('principal')
@section('titulo', 'Habilitar reformulados')
@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_carrera.css') }}">
@endsection
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>HABILITAR REFORMULADO</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Configuración del Poa</li>
                        <li> Formulado</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style ">
                <form id="form_habilitarFormulado" method="post" autocomplete="off">


                    <div class="row text-center">
                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Seleccione una gestión</legend>
                                    <select name="gestion" id="gestion" class="form-select" onchange="listar_gestionesEspecificas(this.value)">
                                        <option value="selected" selected disabled >[SELECCIONE UNA GESTIÓN]</option>
                                        @foreach ($gestion as $lis)
                                            <option value="{{ $lis->id }}">{{ $lis->inicio_gestion.' - '.$lis->fin_gestion }}</option>
                                        @endforeach
                                    </select>
                                    <div id="_gestion"></div>
                            </fieldset>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Seleccione una gestión específica</legend>
                                <select name="gestion_especifica" id="gestion_especifica" class="form-select" onchange="verificar_formPartida(this.value)">
                                    <option value="selected" selected disabled >[SELECCIONE UNA GESTIÓN ESPECÍFICA]</option>
                                </select>
                                <div id="_gestion_especifica"></div>
                            </fieldset>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                            <fieldset>
                                <legend>Ingrese un código</legend>
                                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingrese codigo" maxlength="5" onkeypress="return soloNumeros(event)">
                                <div id="_codigo"></div>
                            </fieldset>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                            <fieldset>
                                <legend>Fecha inicial</legend>
                                <input type="date" name="fecha_inicial" id="fecha_inicial" class="form-control" onchange="validar_fechaFin(this.value)">
                                <div id="_fecha_inicial"></div>
                            </fieldset>
                        </div>
                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                            <fieldset>
                                <legend>Fecha final</legend>
                                <input type="date" name="fecha_final" id="fecha_final" class="form-control" disabled>
                                <div id="_fecha_final"></div>
                            </fieldset>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Seleccione el tipo de formulado</legend>
                                <select name="tipo_formulado" id="tipo_formulado" class="form-select">
                                    <option value="selected" selected disabled >[SELECCIONE EL TIPO DE FORMULADO]</option>
                                </select>
                                <div id="_tipo_formulado"></div>
                            </fieldset>
                        </div>

                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <fieldset>
                                <legend>Seleccione el tipo de partida</legend>
                                <select name="tipo_partida" id="tipo_partida" class="form-select" onchange="mostrar_clasificadores(this.value)">
                                    <option value="selected" selected disabled >[SELECCIONE EL TIPO DE PARTIDA]</option>
                                </select>
                                <div id="_tipo_partida"></div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-6 mx-auto" id="listado_Clasificadores">

                        </div>
                    </div>

                </form>
                <div class="text-center" >
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_configuracionFormulado"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar configuración del formulado</button>
                </div>
                <div class="row py-4">
                    <div class="mb-3 col-12 " id="mostrar_formulado_ant" >

                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- Modal  editar foda-->
        <div class="modal zoom" id="editarFormuladoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="titulo_editar"></h3>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrar_modal_editar()"></button>
                    </div>
                    <div class="modal-body">
                            <form id="form_config_edi" method="post" autocomplete="off">
                                <input type="hidden" name="id_configForm" id="id_configForm" >
                                <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <fieldset>
                                        <legend>Ingrese un código</legend>
                                        <input type="text" class="form-control" name="codigo_" id="codigo_" placeholder="Ingrese codigo" maxlength="5" onkeypress="return soloNumeros(event)">
                                        <div id="_codigo_"></div>
                                    </fieldset>
                                </div>

                                <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <fieldset>
                                        <legend>Fecha inicial</legend>
                                        <input type="date" name="fecha_inicial_" id="fecha_inicial_" class="form-control" onchange="validar_fechaAc(this.value)">
                                        <div id="_fecha_inicial_"></div>
                                    </fieldset>
                                </div>
                                <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <fieldset>
                                        <legend>Fecha final</legend>
                                        <input type="date" name="fecha_final_" id="fecha_final_" class="form-control">
                                        <div id="_fecha_final_"></div>
                                    </fieldset>
                                </div>
                            </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_editar()">Cerrar</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_conf_editado"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Configuración</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script>
        //para listar las gestiones especificas
        function listar_gestionesEspecificas(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listarGestiones') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    vaciar_errores();
                    document.getElementById('listado_Clasificadores').innerHTML = '';
                    document.getElementById('mostrar_formulado_ant').innerHTML = '';
                    $('#tipo_formulado').empty().append(
                        '<option value="selected" selected disabled >[SELECCIONE EL TIPO DE FORMULADO]</option>'
                    );
                    $('#tipo_partida').empty().append(
                        '<option value="selected" selected disabled >[SELECCIONE EL TIPO DE PARTIDA]</option>'
                    );
                    $('#gestion_especifica').empty().append(
                        '<option value="selected" selected disabled >[SELECCIONE UNA GESTIÓN ESPECÍFICA]</option>'
                    );

                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#gestion_especifica').append('<option value = "' + value.id + '">' + value.gestion + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }
        //para verificar el tipo de formulado y el tipo de partida
        function verificar_formPartida(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_verificar_formuladoPartida') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    vaciar_errores();
                    document.getElementById('listado_Clasificadores').innerHTML = '';
                    document.getElementById('mostrar_formulado_ant').innerHTML = '';
                    $('#tipo_formulado').empty().append(
                        '<option value="selected" selected disabled >[SELECCIONE EL TIPO DE FORMULADO]</option>'
                    );
                    $('#tipo_partida').empty().append(
                        '<option value="selected" selected disabled >[SELECCIONE EL TIPO DE PARTIDA]</option>'
                    );
                    let fomulado_datos = data.formulado;
                    fomulado_datos.forEach(value => {
                        if(!value.configuracion_formulado.length > 0){
                            $('#tipo_formulado').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        }
                    });
                    let partida_datos = data.partida_tipo;
                    partida_datos.forEach(value => {
                        if(!value.configuracion_formulado.length > 0){
                            $('#tipo_partida').append('<option value = "' + value.id + '">' + value.descripcion + '</option>');
                        }
                    });
                }
            });
        }
        //otra funcin para mostrar si ya hubo formulacion o no
        let gestion_especifica = $('#gestion_especifica');
        gestion_especifica.on('change', function (e) {
            e.preventDefault();
            let id = gestion_especifica.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_mostrar_formuladoAnt') }}",
                data: {id:id},
                success: function (data) {
                    document.getElementById('mostrar_formulado_ant').innerHTML = data;
                }
            });
        });
        //para mostrar los clasificadores
        function mostrar_clasificadores(id_partida){
            let id_gestion = document.getElementById('gestion_especifica').value;
            $.ajax({
                type: "POST",
                url: "{{ route('adm_mostrar_clasificador') }}",
                data: {
                    id_partida:id_partida,
                    id_gestiones:id_gestion
                },
                success: function (data) {
                    document.getElementById('listado_Clasificadores').innerHTML = data;
                }
            });
        }
        //para guardar la configuracion
        $(document).on('click', '#btn_guardar_configuracionFormulado', function(e){
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_habilitarFormulado'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_guardar_conFormulado') }}",
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
                        setTimeout(() => {
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para vaciar los errores que te manda
        function vaciar_errores(){
            document.getElementById('_gestion').innerHTML = '';
            document.getElementById('_gestion_especifica').innerHTML = '';
            document.getElementById('_tipo_formulado').innerHTML = '';
            document.getElementById('_tipo_partida').innerHTML = '';
            document.getElementById('_fecha_inicial').innerHTML = '';
            document.getElementById('_fecha_final').innerHTML = '';
        }
        //para validar laas fechas
        function validar_fechaFin(fecha){
            let fechaFinal  = document.getElementById('fecha_final');
            fechaFinal.disabled = false;
            fechaFinal.setAttribute('min', fecha);
        }
        //para editar el formulado
        function editar_formuladoPartida(id){
            $.ajax({
                type: "POST",
                url: "{{ route('editarFormulado') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    if(data.tipo==='success'){
                        $('#editarFormuladoModal').modal('show');
                        document.getElementById('id_configForm').value  = data.mensaje.id;
                        document.getElementById('codigo_').value        = data.mensaje.codigo;
                        document.getElementById('fecha_inicial_').value = data.mensaje.fecha_inicial;
                        document.getElementById('fecha_final_').value   = data.mensaje.fecha_final;
                        document.getElementById('fecha_final_').setAttribute('min', data.mensaje.fecha_inicial)
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para la parte de las fechas
        function validar_fechaAc(fecha){
            let fechaFinal  = document.getElementById('fecha_final_');
            fechaFinal.value = '';
            fechaFinal.setAttribute('min', fecha);
        }

        //para vaciar erorres
        function cerrar_modal_editar(){
            document.getElementById('_codigo_').innerHTML = '';
            document.getElementById('_fecha_inicial_').innerHTML = '';
            document.getElementById('_fecha_final_').innerHTML = '';
        }
        //para guardar lo editado
        $(document).on('click', '#btn_guardar_conf_editado', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_config_edi'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editarFormuladoGuardar') }}",
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
                        $('#editarFormuladoModal').modal('hide');
                        setTimeout(() => {
                            window.location = '';
                        }, 1500);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
    </script>
@endsection
