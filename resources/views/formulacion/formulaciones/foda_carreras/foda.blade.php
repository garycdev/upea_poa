@extends('principal')
@section('titulo', '3er Formulario')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>TIPO : TERCER FORMULADO</h5>
                        <h5>{{ $carrera->nombre_completo }}</h5>
                        <h5>GESTIÓN : {{ $gestiones->gestion }}</h5>
                        <h5>FODA</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tabs-wrap">
        <nav class="tabs-button">
            <div class="nav nav-tabs" role="tablist">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#fortaleza_c" type="button"
                    role="tab" aria-selected="true">
                    FORTALEZAS
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#oportunidades_c" type="button"
                    role="tab" aria-selected="false">
                    OPORTUNIDADES
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#debilidad_c" type="button" role="tab"
                    aria-selected="false">
                    DEBILIDADES
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#amenaza_c" type="button" role="tab"
                    aria-selected="false">
                    AMENAZAS
                </button>
            </div>
        </nav>

        <div class="default-table-area">
            <div class="container-fluid">
                <div class="others-title d-flex align-items-center">
                    <a class="btn btn-outline-secondary"
                        href="{{ route('poa_formulacionPOA', [encriptar($configuracion_formulado->id), encriptar($gestiones->id)]) }}">
                        <i class="bx bx-arrow-back"></i>
                        Inicio
                    </a>
                    <h3 class="text-primary"></h3>
                    <div class=" ms-auto position-relative">
                        <form action="{{ route('pdf_form3') }}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="id_carreraunidad" value="{{ $carrera->id }}">
                            <input type="hidden" name="id_configuracion" value="{{ $configuracion_formulado->id }}">
                            <input type="hidden" name="id_gestion" value="{{ $gestiones->id }}">
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#nuevo_carreraUnidadArea"><i class="ri-file-pdf-line"></i> Imprimir
                                PDF</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-content">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="fortaleza_c" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>FORTALEZAS</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()"> <i
                                                class="bx bxs-add-to-queue"></i> Nueva Foda</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="fortaleza_tabla_c" style="width: 100%">
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

                <div class="tab-pane fade" id="oportunidades_c" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>OPORTUNIDADES</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()"> <i
                                                class="bx bxs-add-to-queue"></i> Nuevo Foda</button>
                                    </div>
                                </div>
                                <div id="table-responsive">
                                    <table class="table table-hover" id="oportunidad_tabla_c" style="width: 100%">
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

                <div class="tab-pane fade" id="debilidad_c" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>DEBILIDADES</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()">
                                            <i class="bx bxs-add-to-queue"></i> Nuevo Foda</button>
                                    </div>
                                </div>
                                <div id="table-responsive">
                                    <table class="table table-hover" id="debilidad_tabla_c" style="width: 100%">
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

                <div class="tab-pane fade" id="amenaza_c" role="tabpanel">
                    <div class="default-table-area">
                        <div class="container-fluid">
                            <div class="card-box-style">
                                <div class="others-title d-flex align-items-center">
                                    <h3>AMENAZAS</h3>
                                    <div class=" ms-auto position-relative">
                                        <button type="button" class="btn btn-outline-primary" onclick="abrir_modal()">
                                            <i class="bx bxs-add-to-queue"></i> Nuevo Foda</button>
                                    </div>
                                </div>
                                <div id="table-responsive">
                                    <table class="table table-hover table-sm" id="amenaza_tabla_c" style="width: 100%">
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
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <a class="me-2"
                href="{{ route('poa_formulario2', ['formulario1_id' => encriptar($formulario1->id), 'formuladoTipo_id' => encriptar($configuracion_formulado->formulado_id)]) }}">
                <button type="submit" class="btn btn-primary">
                    Form N°2
                    <i class="bx bx-arrow-to-left"></i>
                </button>
            </a>
            <a class=""
                href="{{ route('poa_form4', ['formulario1_id' => encriptar($formulario1->id), 'formuladoTipo_id' => encriptar($configuracion_formulado->formulado_id)]) }}">
                <button type="submit" class="btn btn-primary">
                    Form N°4
                    <i class="bx bx-arrow-to-right"></i>
                </button>
            </a>
        </div>
    </div>


    <!-- Modal  nuevo foda-->
    <div class="modal zoom" id="nueva_fodaC" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">CREAR FODA</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="cerrar_modal_foda_c()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_foda" method="post" autocomplete="off">
                        <input type="hidden" name="gestion_id" value="{{ $gestiones->id }}">
                        <div class="row">
                            <div class="mb-3">
                                <label for="tipo_foda" class="form-label">Seleccione tipo de FODA</label>
                                <select name="tipo_foda" id="tipo_foda" class="form-select form-control"
                                    onchange="seleccionar_foda_c(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE TIPO DE FODA]</option>
                                    @foreach ($tipo_foda as $lis)
                                        <option value="{{ $lis->id }}"> {{ $lis->nombre }} </option>
                                    @endforeach
                                </select>
                                <div id="_tipo_foda"></div>
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
                                                    <div class="col-sm-10 col-md-9 col-lg-10 col-xl-10">
                                                        <label for="" class="form-label"></label>
                                                        <textarea name="descripcion" class="form-control" data-kt-autosize="true" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-sm-2 col-md-3 col-lg-2 col-xl-2 my-1">
                                                        <a href="javascript:;" data-repeater-delete
                                                            class="btn btn-sm btn-outline-danger mt-3">
                                                            <i class="ri-close-circle-fill"></i> Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:;" data-repeater-create
                                            class="btn btn-outline-primary btn-sm mt-2">
                                            <i class="ri-add-line"></i> Agregar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="cerrar_modal_foda_c()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_fodaC"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar FODA</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  editar foda-->
    <div class="modal zoom" id="editar_foda_modalc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="titulo_editar"></h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_foda_edi" method="post" autocomplete="off">
                        <input type="hidden" name="id_fodaEdi" id="id_fodaEdi">
                        <div class="row">
                            <div class="mb-3">
                                <label>DESCRIPCIÓN</label>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <textarea name="descripcion_" id="descripcion_" class="form-control" data-kt-autosize="true" cols="30"
                                        rows="5"></textarea>
                                </div>
                                <div id="_descripcion_"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"
                        onclick="cerrar_modal_foda()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_foda_editadoC"> <i
                            class="bx bxs-save" id="icono_rodry"></i> Guardar FODA</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        /* setTimeout(() => {
                                                    document.getElementById('primero').style.display = 'none';
                                                    document.getElementById('segundo').style.display = 'block';
                                                }, 3000);

                                                function btn_recargarPagina(){
                                                    window.location='';
                                                } */

        repetir_x('#repetir_foda');
        //para abrir modal
        function abrir_modal() {
            $('#nueva_fodaC').modal('show');
        }

        function cerrar_modal_foda_c() {
            limpiar_campos("form_foda");
            document.getElementById('tipo_seleccionado').innerHTML = 'DESCRIPCIÓN DE :';
            document.getElementById('_tipo_foda').innerHTML = '';
        }
        //para guardar el foda
        $(document).on('click', '#btn_guardar_fodaC', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_foda'));
            $.ajax({
                type: "POST",
                url: "{{ route('fodac_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    document.getElementById('_tipo_foda').innerHTML = '';
                    if (data.tipo == 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = `<p id="error_in" >` + obj[
                                key] + `</p>`;
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        destroy_tablas();
                        setTimeout(() => {
                            $('#nueva_fodaC').modal('hide');
                            cerrar_modal_foda_c();
                        }, 1400);
                        console.log(data);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        //para seleccionde tipo de foda
        function seleccionar_foda_c(id) {
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
        //funciton para destruir tablas
        function destroy_tablas() {
            $('#fortaleza_tabla_c').DataTable().destroy();
            listar_fortaleza_c();
            $('#oportunidad_tabla_c').DataTable().destroy();
            listar_oportunidad_c();
            $('#debilidad_tabla_c').DataTable().destroy();
            listar_debilidad_c();
            $('#amenaza_tabla_c').DataTable().destroy();
            listar_amenaza_c();
        }
        //la gestiones
        let id_gestiones = {{ $gestiones->id }};
        //listar_fortaleza
        function listar_fortaleza_c() {
            $.ajax({
                type: "POST",
                url: "{{ route('fodac_listarFoda') }}",
                data: {
                    id_gestiones: id_gestiones,
                    tipo_foda: 1
                },
                dataType: "JSON",
                success: function(data) {
                    let i = 1;
                    $("#fortaleza_tabla_c").DataTable({
                        'data': data.mensaje,
                        'columns': [{
                                "render": function() {
                                    return a = i++;
                                }
                            },
                            {
                                "data": 'descripcion'
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    let a = `
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_fodac('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_fodac('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                    return a;
                                }
                            },
                        ]
                    });
                }
            });
        }
        listar_fortaleza_c();

        function listar_oportunidad_c() {
            $.ajax({
                type: "POST",
                url: "{{ route('fodac_listarFoda') }}",
                data: {
                    id_gestiones: id_gestiones,
                    tipo_foda: 2
                },
                dataType: "JSON",
                success: function(data) {
                    let i = 1;
                    $("#oportunidad_tabla_c").DataTable({
                        'data': data.mensaje,
                        'columns': [{
                                "render": function() {
                                    return a = i++;
                                }
                            },
                            {
                                "data": 'descripcion'
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    let a = `
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_fodac('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_fodac('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                    return a;
                                }
                            },
                        ]
                    });
                }
            });
        }
        listar_oportunidad_c();

        function listar_debilidad_c() {
            $.ajax({
                type: "POST",
                url: "{{ route('fodac_listarFoda') }}",
                data: {
                    id_gestiones: id_gestiones,
                    tipo_foda: 3
                },
                dataType: "JSON",
                success: function(data) {
                    let i = 1;
                    $("#debilidad_tabla_c").DataTable({
                        'data': data.mensaje,
                        'columns': [{
                                "render": function() {
                                    return a = i++;
                                }
                            },
                            {
                                "data": 'descripcion'
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    let a = `
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_fodac('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_fodac('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                    return a;
                                }
                            },
                        ]
                    });
                }
            });
        }
        listar_debilidad_c();

        function listar_amenaza_c() {
            $.ajax({
                type: "POST",
                url: "{{ route('fodac_listarFoda') }}",
                data: {
                    id_gestiones: id_gestiones,
                    tipo_foda: 4
                },
                dataType: "JSON",
                success: function(data) {
                    let i = 1;
                    $("#amenaza_tabla_c").DataTable({
                        'data': data.mensaje,
                        'columns': [{
                                "render": function() {
                                    return a = i++;
                                }
                            },
                            {
                                "data": 'descripcion'
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    let a = `
                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_fodac('${row.id}')" ><i class="ri-edit-2-fill"></i></button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminar_fodac('${row.id}')"><i class="ri-delete-bin-7-fill"></i></button>
                                `;
                                    return a;
                                }
                            },
                        ]
                    });
                }
            });
        }
        listar_amenaza_c();
        //para editar el foda
        function editar_fodac(id) {
            document.getElementById('_descripcion_').innerHTML = '';
            $.ajax({
                type: "POST",
                url: "{{ route('fodac_editarFoda') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        $('#editar_foda_modalc').modal('show');
                        document.getElementById('titulo_editar').innerHTML = 'EDITAR ' + data.tipo_foda.nombre;
                        document.getElementById('id_fodaEdi').value = data.foda_unidadCarrera.id;
                        document.getElementById('descripcion_').value = data.foda_unidadCarrera.descripcion;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para guardar lo editado
        $(document).on('click', '#btn_guardar_foda_editadoC', (e) => {
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_foda_edi'));
            $.ajax({
                type: "POST",
                url: "{{ route('fodac_editarFoda_guardar') }}",
                data: datos,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    document.getElementById('_descripcion_').innerHTML = '';
                    if (data.tipo == 'errores') {
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_' + key).innerHTML = `<p id="error_in" >` + obj[
                                key] + `</p>`;
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        destroy_tablas();
                        setTimeout(() => {
                            $('#editar_foda_modalc').modal('hide');
                        }, 1400);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });

        function eliminar_fodac(id) {
            console.log('prgil');
        }
    </script>
@endsection
