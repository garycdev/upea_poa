@extends('principal')
@section('titulo', 'FODA')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>ÁREA ESTRATÉGICA : "{{ $area_estrategica->descripcion }}"  </h5>
                        <h5>GESTIÓN {{ $gestion->inicio_gestion.' - '.$gestion->fin_gestion }} ({{ $tipo_plan->nombre }})</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administracion de FODA</li>
                        <li>{{ $tipo_plan->nombre }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="tabs-wrap">
        <nav class="tabs-button">
            <div class="nav nav-tabs" role="tablist">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#fortaleza" type="button" role="tab" aria-selected="true">
                    FORTALEZAS
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#oportunidades" type="button" role="tab" aria-selected="false">
                    OPORTUNIDADES
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#debilidad" type="button" role="tab" aria-selected="false">
                    DEBILIDADES
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#amenaza" type="button" role="tab" aria-selected="false">
                    AMENAZAS
                </button>
            </div>
        </nav>

        <div class="tabs-content">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="fortaleza" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>FORTALEZAS</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()"> <i class="bx bxs-add-to-queue"></i> Nuevo Foda</button>
                                    </div>
                                </div>
                                <div class="table-responsive" >
                                    <table class="table table-hover" id="fortaleza_tabla" style="width: 100%" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="oportunidades" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>OPORTUNIDADES</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()"> <i class="bx bxs-add-to-queue"></i> Nuevo Foda</button>
                                    </div>
                                </div>
                                <div id="table-responsive" >
                                    <table class="table table-hover" id="oportunidad_tabla" style="width: 100%" >
                                        <thead class="text-center">
                                            <tr>
                                                <th>#</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="debilidad" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>DEBILIDADES</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()"> <i class="bx bxs-add-to-queue"></i> Nuevo Foda</button>
                                    </div>
                                </div>
                                <div id="table-responsive" >
                                    <table class="table table-hover" id="debilidad_tabla" style="width: 100%" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="amenaza" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>AMENAZAS</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()"> <i class="bx bxs-add-to-queue"></i> Nuevo Foda</button>
                                    </div>
                                </div>
                                <div id="table-responsive" >
                                    <table class="table table-striped table-hover table-sm" id="amenaza_tabla" style="width: 100%" >
                                        <thead >
                                            <tr>
                                                <th>#</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  nuevo foda-->
    <div class="modal zoom" id="nueva_foda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">CREAR FODA</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="cerrar_modal_foda()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_foda" method="post" autocomplete="off">
                        <input type="hidden" value="{{ $id_area_estrategica }}" name="area_estrategica">
                        <input type="hidden" value="{{  $id_tipo_plan }}" name="tipo_plan">
                        <div class="row">
                            <div class="mb-3">
                                <label for="gestion_id" class="form-label">Seleccione tipo de FODA</label>
                                <select name="tipo_foda" id="tipo_foda" class="form-select form-control" onchange="seleccionar_foda(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE TIPO DE FODA]</option>
                                    @foreach ($foda as $lis)
                                        <option value="{{ $lis->id }}"> {{ $lis->nombre }} </option>
                                    @endforeach
                                </select>
                                <div id="_tipo_foda" ></div>
                            </div>
                            <div class="mb-3 text-center">
                                <div id="alerta_nota">
                                    <p> NOTA : Se podra agregar maximo de {{ maximo_agregar() }} registros a la vez!</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label id="tipo_seleccionado">DESCRIPCIÓN DE : </label>
                                <div id="repetir_foda">
                                    <div class="form-group">
                                        <div data-repeater-list="repetir_foda">
                                            <div data-repeater-item>
                                                <div class="form-group row">
                                                    <div class="col-sm-10 col-md-9 col-lg-10 col-xl-10" >
                                                        <label for="" class="form-label"></label>
                                                        <textarea name="descripcion" class="form-control" data-kt-autosize="true" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-sm-2 col-md-3 col-lg-2 col-xl-2 my-1">
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
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_foda()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_foda"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar FODA</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  editar foda-->
    <div class="modal zoom" id="editar_foda_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="titulo_editar"></h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_foda_edi" method="post" autocomplete="off">
                        <input type="hidden" name="id_foda" id="id_foda" >
                        <div class="row">
                            <div class="mb-3">
                                <label id="tipo_seleccionado">DESCRIPCIÓN</label>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                                    <textarea name="descripcion_" id="descripcion_" class="form-control" data-kt-autosize="true" cols="30" rows="5"></textarea>
                                </div>
                                <div id="_descripcion_" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="cerrar_modal_foda()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_foda_editado"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar FODA</button>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        var area_estrategica = {{ $id_area_estrategica }};
        var tipo_plan = {{ $id_tipo_plan }};
        repetir_x('#repetir_foda');
        function cerrar_modal_foda(){
            limpiar_campos("form_foda");
            document.getElementById('tipo_seleccionado').innerHTML='DESCRIPCIÓN DE :';
            document.getElementById('_tipo_foda').innerHTML='';
        }

        function abrir_modal(){
            $('#nueva_foda').modal('show');
        }

        function listar_fortaleza(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_foda_listar') }}",
                data: {area_estrategica:area_estrategica, tipo_plan:tipo_plan, tipo_foda:1},
                dataType: "JSON",
                success: function (data) {
                    let i=1;
                    $("#fortaleza_tabla").DataTable({
                        'data':data.foda,
                        'columns':[
                            {"render":function(){
                                return a = i++;
                            }},
                            {"data":'descripcion'},
                            {"render": function(data, type, row, meta){
                                let a=`
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_foda('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_foda('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                return a;
                            }},
                        ]
                    });
                }
            });
        }
        listar_fortaleza();

        function listar_oportunidad(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_foda_listar') }}",
                data: {area_estrategica:area_estrategica, tipo_plan:tipo_plan, tipo_foda:2},
                dataType: "JSON",
                success: function (data) {
                    let i=1;
                    $("#oportunidad_tabla").DataTable({
                        'data':data.foda,
                        'columns':[
                            {"render":function(){
                                return a = i++;
                            }},
                            {"data":'descripcion'},
                            {"render": function(data, type, row, meta){
                                let a=`
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_foda('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_foda('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                return a;
                            }},
                        ]
                    });
                }
            });
        }
        listar_oportunidad();

        function listar_debilidad(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_foda_listar') }}",
                data: {area_estrategica:area_estrategica, tipo_plan:tipo_plan, tipo_foda:3},
                dataType: "JSON",
                success: function (data) {
                    let i=1;
                    $("#debilidad_tabla").DataTable({
                        'data':data.foda,
                        'columns':[
                            {"render":function(){
                                return a = i++;
                            }},
                            {"data":'descripcion'},
                            {"render": function(data, type, row, meta){
                                let a=`
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_foda('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_foda('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                return a;
                            }},
                        ]
                    });
                }
            });
        }
        listar_debilidad();

        function listar_amenaza(){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_foda_listar') }}",
                data: {area_estrategica:area_estrategica, tipo_plan:tipo_plan, tipo_foda:4},
                dataType: "JSON",
                success: function (data) {
                    let i=1;
                    $("#amenaza_tabla").DataTable({
                        'data':data.foda,
                        'columns':[
                            {"render":function(){
                                return a = i++;
                            }},
                            {"data":'descripcion'},
                            {"render": function(data, type, row, meta){
                                let a=`
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_foda('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_foda('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                return a;
                            }},
                        ]
                    });
                }
            });
        }
        listar_amenaza();


        //para seleccionde tipo de foda
        function seleccionar_foda(id){
            let tipo_foda = document.getElementById('tipo_seleccionado');
            switch (id) {
                case '1':
                    tipo_foda.innerHTML = 'DESCRIPCIÓN DE : FORTALEZAS';
                    break;
                case '2':
                    tipo_foda.innerHTML = 'DESCRIPCIÓN DE : OPORTUNIDADES';
                break;
                case '3':
                    tipo_foda.innerHTML = 'DESCRIPCIÓN DE : DEBILIDADES';
                break;
                case '4':
                    tipo_foda.innerHTML = 'DESCRIPCIÓN DE : AMENAZAS';
                break;
                default:
                    tipo_foda.innerHTML = 'DESCRIPCIÓN DE :';
                    break;
            }
        }

        //PARA GUARDAR FODA
        $(document).on('click', '#btn_guardar_foda', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_foda'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_foda_guardar') }}",
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
                        destroy_tablas();
                        setTimeout(() => {
                            $('#nueva_foda').modal('hide');
                            cerrar_modal_foda();
                        }, 1400);
                    }
                    if(data.tipo=='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //funciton para destruir tablas
        function destroy_tablas(){
            $('#fortaleza_tabla').DataTable().destroy();
            listar_fortaleza();
            $('#oportunidad_tabla').DataTable().destroy();
            listar_oportunidad();
            $('#debilidad_tabla').DataTable().destroy();
            listar_debilidad();
            $('#amenaza_tabla').DataTable().destroy();
            listar_amenaza();
        }

        //para editar foda
        function editar_foda(id){
            document.getElementById('_descripcion_').innerHTML='';
            $.ajax({
                type: "POST",
                url: "{{ route('adm_foda_editar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        $('#editar_foda_modal').modal('show');
                        document.getElementById('titulo_editar').innerHTML = 'EDITAR '+data.mensaje.reversa_relacion_tipo_foda_foda_descripcion.nombre;
                        document.getElementById('id_foda').value = data.mensaje.id;
                        document.getElementById('descripcion_').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }

        //eliminar foda
        function eliminar_foda(id){
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
                        url: "{{ route('adm_foda_eliminar') }}",
                        data: { id:id },
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                destroy_tablas();
                                alerta_top(data.tipo, data.mensaje);
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


        //para guardar lo editado foda
        $(document).on('click','#btn_guardar_foda_editado', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_foda_edi'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_foda_editar_guardar') }}",
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
                    if(data.tipo==='success'){
                        alerta_top(data.tipo, data.mensaje);
                        destroy_tablas();
                        setTimeout(() => {
                            $('#editar_foda_modal').modal('hide');
                        }, 1400);
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });


    </script>
@endsection
