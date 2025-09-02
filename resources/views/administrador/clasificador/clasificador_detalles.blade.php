@extends('principal')
@section('titulo', 'Clasificadores Presupuestarios')

@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>CÓDIGO : {{ $primer_clasificador->codigo }}</h5>
                        <h5>TITULO : {{ $primer_clasificador->titulo }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tabs-wrap">
        <nav class="tabs-button">
            <div class="nav nav-tabs" role="tablist">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#segundo_clasificador" type="button" role="tab" aria-selected="true">
                    SEGUNDO CLASIFICADOR
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tercer_clasificador" type="button" role="tab" aria-selected="false">
                    TERCER CLASIFICADOR
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cuarto_clasificador" type="button" role="tab" aria-selected="false">
                    CUARTO CLASIFICADOR
                </button>

                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quinto_clasificador" type="button" role="tab" aria-selected="false">
                    QUINTO CLASIFICADOR
                </button>
            </div>
        </nav>

        <div class="tabs-content">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="segundo_clasificador" role="tabpanel">
                    <div class="default-table-area" id="ver_segundoClasificador">

                    </div>
                </div>

                <div class="tab-pane fade" id="tercer_clasificador" role="tabpanel">
                    <div class="default-table-area" id="ver_tercerClasificador">

                    </div>
                </div>

                <div class="tab-pane fade" id="cuarto_clasificador" role="tabpanel">
                    <div class="default-table-area" id="ver_cuartoClasificador">

                    </div>
                </div>

                <div class="tab-pane fade" id="quinto_clasificador" role="tabpanel">
                    <div class="default-table-area" id="ver_quintoClasificador">

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL NUEVO DEL SEGUNDO CLASIFICADOR --}}
    <div class="modal slide" id="nuevo_segundoClasificador" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO SEGUNDO CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciarCamposSegundoClasificador()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorSegundo" method="POST" autocomplete="off">
                        <input type="hidden" name="primer_digitoSegundoClasificador" id="primer_digitoSegundoClasificador">
                        <input type="hidden" name="id_primerClasificador" value="{{ $primer_clasificador->id }}">
                        <div class="row">
                            <label for="codigo" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerDigitoSegundoClasificador" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese un codigo" maxlength="4"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingrese un titulo">
                                <div id="_titulo"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese la descripción" rows="8"></textarea>
                                <div id="_descripcion" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciarCamposSegundoClasificador()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarSegundoClasificador"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR SEGUNDO CLASIFICADOR --}}
    <div class="modal slide" id="editar_segundoClasificador" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO SEGUNDO CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorSegundoEditar" method="POST" autocomplete="off">
                        <input type="hidden" name="id_SegundoClasificador" id="id_SegundoClasificador">
                        <input type="hidden" name="primer_digitoSegundoClasificador_edi" id="primer_digitoSegundoClasificador_edi">
                        <input type="hidden" name="id_primerClasificador_edi" value="{{ $primer_clasificador->id }}">
                        <div class="row">
                            <label for="codigo" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerDigitoSegundoClasificador_edi" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo_" name="codigo_" placeholder="Ingrese un codigo" maxlength="4"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo_"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo_" name="titulo_" placeholder="Ingrese un titulo">
                                <div id="_titulo_"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion_" id="descripcion_" placeholder="Ingrese la descripción" rows="8"></textarea>
                                <div id="_descripcion_" ></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_editarGuardarSegundoClasificador"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL NUEVO DEL TERCER CLASIFICADOR --}}
    <div class="modal slide" id="nuevo_tercerClasificador" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO TERCER CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciarCamposModalNuevoTercerClasi()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorTercer" method="POST" autocomplete="off">
                        <input type="hidden" name="primerosDosDigitosEnviar" id="primerosDosDigitosEnviar">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccioneSegundoClasificador" class="form-label">Seleccione el <span class="badge text-bg-primary" style="font-size:12px">Segundo</span>  Clasificador</label>
                                <select name="seleccioneSegundoClasificador" id="seleccioneSegundoClasificador" class="select2" onchange="selectSegundoClasificador2(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE EL SEGUNDO CLASIFICADOR]</option>
                                    @foreach ($segundo_clasificador as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->titulo }}</option>
                                    @endforeach
                                </select>
                                <div id="_seleccioneSegundoClasificador" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="codigo3" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerosDosDigitosVer" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo___" name="codigo___" placeholder="Ingrese un codigo" maxlength="3"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo___"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo___" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo___" name="titulo___" placeholder="Ingrese un titulo">
                                <div id="_titulo___"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion___" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion___" id="descripcion___" placeholder="Ingrese la descripción" rows="8"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciarCamposModalNuevoTercerClasi()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarTercerClasificador"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PARA EDITAR EL TERCER CLASIFICADOR --}}
    <div class="modal slide" id="editar_tercerClasificadorModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR TERCER CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciarCamposModalNuevoTercerClasi()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorTerceroEditar" method="POST" autocomplete="off">
                        <input type="hidden" name="id_tercerClasificador" id="id_tercerClasificador">
                        <input type="hidden" name="primerosDosDigitosEnviar_edi" id="primerosDosDigitosEnviar_edi">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccioneSegundoClasificador" class="form-label">Seleccione el <span class="badge text-bg-primary" style="font-size:12px">Segundo</span>  Clasificador</label>
                                <select name="seleccioneSegundoClasificadorEditar" id="seleccioneSegundoClasificadorEditar" class="select2_segundo" onchange="selectSegundoClasificador2_edit(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE EL SEGUNDO CLASIFICADOR]</option>
                                    @foreach ($segundo_clasificador as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->titulo }}</option>
                                    @endforeach
                                </select>
                                <div id="_seleccioneSegundoClasificadorEditar" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="codigo____" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerosDosDigitosVerEditar" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo____" name="codigo____" placeholder="Ingrese un codigo" maxlength="3"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo____"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo____" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo____" name="titulo____" placeholder="Ingrese un titulo">
                                <div id="_titulo____"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion____" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion____" id="descripcion____" placeholder="Ingrese la descripción" rows="8"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciarCamposModalNuevoTercerClasi()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarTercerClasificador_Edit"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO DEL CUARTO CLASIFICADOR --}}
    <div class="modal slide" id="nuevo_cuartoClasificador" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO CUARTO CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciarCamposModalCuartoClasificador()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorCuarto" method="POST" autocomplete="off">
                        <input type="hidden" name="primerosTresDigitosEnviar" id="primerosTresDigitosEnviar">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarSegundoClasificador_" class="form-label">Seleccione el <span class="badge text-bg-primary" style="font-size:12px">Segundo</span>  Clasificador</label>
                                <select name="seleccionarSegundoClasificador_" id="seleccionarSegundoClasificador_" class="select2_tercero" onchange="listar_tercerClasificador3(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE EL SEGUNDO CLASIFICADOR]</option>
                                    @foreach ($segundo_clasificador as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->titulo }}</option>
                                    @endforeach
                                </select>
                                <div id="_seleccionarSegundoClasificador_" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarTercerClasificador" class="form-label">Seleccione el <span class="badge text-bg-success" style="font-size:12px">Tercer</span>  Clasificador</label>
                                <select name="seleccionarTercerClasificador" id="seleccionarTercerClasificador" class="select2_tercero" onchange="SacarPrimerosDigitosTercerClasificador(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE EL TERCER CLASIFICADOR]</option>
                                </select>
                                <div id="_seleccionarTercerClasificador" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="codigo3" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerosTresDigitosVer" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo_____" name="codigo_____" placeholder="Ingrese un codigo" maxlength="2"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo_____"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo___" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo_____" name="titulo_____" placeholder="Ingrese un titulo">
                                <div id="_titulo_____"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion_____" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion_____" id="descripcion_____" placeholder="Ingrese la descripción" rows="8"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciarCamposModalCuartoClasificador()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarCuartoClasificador"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL EDITAR CUARTO CLASIFICADOR --}}
    <div class="modal slide" id="editar_cuartoClasificador" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR CUARTO CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="vaciarCamposCuartoClasificadorEditar()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorCuartoEditar" method="POST" autocomplete="off">
                        <input type="hidden" name="idCuartoClasificadorEditar" id="idCuartoClasificadorEditar">
                        <input type="hidden" name="primerosTresDigitosEnviar_editar" id="primerosTresDigitosEnviar_editar">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarSegundoClasificador_" class="form-label">Seleccione el <span class="badge text-bg-primary" style="font-size:12px">Segundo</span>  Clasificador</label>
                                <select name="seleccionarSegundoClasificadorEditar" id="seleccionarSegundoClasificadorEditar" class="select2_cuarto">
                                    <option disabled selected>[SELECCIONE EL SEGUNDO CLASIFICADOR]</option>
                                    @foreach ($segundo_clasificador as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->titulo }}</option>
                                    @endforeach
                                </select>
                                <div id="_seleccionarSegundoClasificadorEditar" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarTercerClasificador" class="form-label">Seleccione el <span class="badge text-bg-success" style="font-size:12px">Tercer</span>  Clasificador</label>
                                <select name="seleccionarTercerClasificadorEditar" id="seleccionarTercerClasificadorEditar" class="select2_cuarto">
                                    <option disabled selected>[SELECCIONE EL TERCER CLASIFICADOR]</option>
                                </select>
                                <div id="_seleccionarTercerClasificadorEditar"></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="codigo3" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerosTresDigitosVer_editar" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo______" name="codigo______" placeholder="Ingrese un codigo" maxlength="2"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo______"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo___" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo______" name="titulo______" placeholder="Ingrese un titulo">
                                <div id="_titulo______"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion______" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion______" id="descripcion______" placeholder="Ingrese la descripción" rows="8"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciarCamposCuartoClasificadorEditar()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarCuartoClasificadorEditar"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO DEL QUINTO CLASIFICADOR --}}
    <div class="modal slide" id="nuevo_quintoClasificador" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">NUEVO QUINTO CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciarCamposModalQuintoClasificador()"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorQuinto" method="POST" autocomplete="off">
                        <input type="hidden" name="primerosCuatroDigitosEnviar" id="primerosCuatroDigitosEnviar">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarSegundoClasificador__" class="form-label">Seleccione el <span class="badge text-bg-primary" style="font-size:12px">Segundo</span>  Clasificador</label>
                                <select name="seleccionarSegundoClasificador__" id="seleccionarSegundoClasificador__" class="select2_quinto" onchange="listar_tercerClasificador5(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE EL SEGUNDO CLASIFICADOR]</option>
                                    @foreach ($segundo_clasificador as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->titulo }}</option>
                                    @endforeach
                                </select>
                                <div id="_seleccionarSegundoClasificador__" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarTercerClasificador_" class="form-label">Seleccione el <span class="badge text-bg-success" style="font-size:12px">Tercer</span>  Clasificador</label>
                                <select name="seleccionarTercerClasificador_" id="seleccionarTercerClasificador_" class="select2_quinto" onchange="listarCuartoClasificador(this.value)">
                                    <option value="selected" disabled selected>[SELECCIONE EL TERCER CLASIFICADOR]</option>
                                </select>
                                <div id="_seleccionarTercerClasificador_" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarCuartoClasificador" class="form-label">Seleccione el <span class="badge text-bg-danger" style="font-size:12px">Cuarto</span>  Clasificador</label>
                                <select name="seleccionarCuartoClasificador" id="seleccionarCuartoClasificador" class="select2_quinto">
                                    <option value="selected" disabled selected>[SELECCIONE EL CUARTO CLASIFICADOR]</option>
                                </select>
                                <div id="_seleccionarCuartoClasificador" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="codigo_______" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerosCuatroDigitosVer" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo_______" name="codigo_______" placeholder="Ingrese un codigo" maxlength="1"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo_______"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo_______" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo_______" name="titulo_______" placeholder="Ingrese un titulo">
                                <div id="_titulo_______"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion_______" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion_______" id="descripcion_______" placeholder="Ingrese la descripción" rows="8"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciarCamposModalQuintoClasificador()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarQuintoClasificador"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR EL QUINTO CLASIFICADOR --}}
    <div class="modal slide" id="editar_quintoClasificador" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">EDITAR QUINTO CLASIFICADOR</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <form id="form_clasificadorQuintoEditar" method="POST" autocomplete="off">
                        <input type="hidden" name="idClasificadorQuinto" id="idClasificadorQuinto">
                        <input type="hidden" name="primerosCuatroDigitosEnviarEditar" id="primerosCuatroDigitosEnviarEditar">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarSegundoClasificador___" class="form-label">Seleccione el <span class="badge text-bg-primary" style="font-size:12px">Segundo</span>  Clasificador</label>
                                <select name="seleccionarSegundoClasificador___" id="seleccionarSegundoClasificador___" class="select2_sexto">
                                    <option value="selected" disabled selected>[SELECCIONE EL SEGUNDO CLASIFICADOR]</option>
                                    @foreach ($segundo_clasificador as $lis)
                                        <option value="{{ $lis->id }}">{{ $lis->titulo }}</option>
                                    @endforeach
                                </select>
                                <div id="_seleccionarSegundoClasificador___" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarTercerClasificadorEditar___" class="form-label">Seleccione el <span class="badge text-bg-success" style="font-size:12px">Tercer</span>  Clasificador</label>
                                <select name="seleccionarTercerClasificadorEditar___" id="seleccionarTercerClasificadorEditar___" class="select2_sexto">
                                    <option disabled selected>[SELECCIONE EL TERCER CLASIFICADOR]</option>
                                </select>
                                <div id="_seleccionarTercerClasificadorEditar___" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="seleccionarCuartoClasificadorEditar_" class="form-label">Seleccione el <span class="badge text-bg-danger" style="font-size:12px">Cuarto</span>  Clasificador</label>
                                <select name="seleccionarCuartoClasificadorEditar_" id="seleccionarCuartoClasificadorEditar_" class="select2_sexto">
                                    <option disabled selected>[SELECCIONE EL CUARTO CLASIFICADOR]</option>
                                </select>
                                <div id="_seleccionarCuartoClasificadorEditar_" ></div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="codigo________" class="form-label">Ingrese la Código</label>
                            <div class="mb-3 col-3">
                                <input type="text" class="form-control" id="primerosCuatroDigitosVerEditar" readonly disabled>
                            </div>
                            <div class="mb-3 col-9">
                                <input type="text" class="form-control" id="codigo________" name="codigo________" placeholder="Ingrese un codigo" maxlength="1"
                                onkeypress="return soloNumeros(event)">
                                <div id="_codigo________"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label for="titulo________" class="form-label">Ingrese la Titulo</label>
                                <input type="text" class="form-control" id="titulo________" name="titulo________" placeholder="Ingrese un titulo">
                                <div id="_titulo________"></div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="descripcion________" class="form-label">Ingrese Descripción</label>
                                <textarea class="form-control" name="descripcion________" id="descripcion________" placeholder="Ingrese la descripción" rows="8"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardarQuintoClasificadorEditar"> <i class="bx bxs-save" id="icono_rodry"></i> Guardar Clasificador Presupuestario</button>
                </div>
            </div>
        </div>
    </div>


    {{-- EL PRIMER MODAL PARA EL TERCER CLASIFICADOR --}}
    <div class="modal slide" id="modal_detallesTercerClasificador" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">DETALLES TERCER CLASIFICADOR</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="vaciar_campoDetalleTercerClasificador()"></button>
                </div>
                <div class="modal-body" id="gestiones_datos">

                    <form id="form_detalleTercerClasificador" method="post" autocomplete="off">
                        <div class="text-center">
                            <div class="alert alert-primary" role="alert" id="titulo_descript">

                            </div>
                        </div>
                        <input type="hidden" name="id_tercerClasificadorDetalle_new" id="id_tercerClasificadorDetalle_new">
                        <input type="hidden" name="id_tercerClasificadorDetalle_edi" id="id_tercerClasificadorDetalle_edi">
                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="titulo_detalle" class="form-label">Titulo</label>
                                    <input type="text" class="form-control" id="titulo_detalle" name="titulo_detalle" placeholder="Ingrese un titulo">
                                    <div id="_titulo_detalle"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="descripcion_detalle" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion_detalle" id="descripcion_detalle" rows="2" placeholder="Descripción"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-outline-primary" id="btn_guardartercerClasificadorDetalle">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>TÍTULO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="listar_detallesTercerClasificador_html">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- EL PRIMER MODAL PARA EL CUARTO CLASIFICADOR --}}
    <div class="modal slide" id="modal_detallesCuartoClasificador" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">DETALLES CUARTO CLASIFICADOR</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="vaciar_campoDetalleCuartoClasificador()"></button>
                </div>
                <div class="modal-body" id="gestiones_datos">

                    <form id="form_detalleCuartoClasificador" method="post" autocomplete="off">
                        <div class="text-center">
                            <div class="alert alert-primary" role="alert" id="titulo_descript_cuarto">

                            </div>
                        </div>
                        <input type="hidden" name="id_cuartoClasificadorDetalle_new" id="id_cuartoClasificadorDetalle_new">
                        <input type="hidden" name="id_cuartoClasificadorDetalle_edi" id="id_cuartoClasificadorDetalle_edi">
                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="titulo_detalle" class="form-label">Titulo</label>
                                    <input type="text" class="form-control" id="titulo_detalle_" name="titulo_detalle_" placeholder="Ingrese un titulo">
                                    <div id="_titulo_detalle_"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="descripcion_detalle" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion_detalle_" id="descripcion_detalle_" rows="2" placeholder="Descripción"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-outline-primary" id="btn_guardarcuartoClasificadorDetalle">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>TÍTULO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="listar_detallesCuartoClasificador_html">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- EL PRIMER MODAL PARA EL CUARTO CLASIFICADOR --}}
    <div class="modal slide" id="modal_detallesQuintoClasificador" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">DETALLES QUINTO CLASIFICADOR</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="vaciar_campoDetalleQuintoClasificador()"></button>
                </div>
                <div class="modal-body" id="gestiones_datos">

                    <form id="form_detalleQuintoClasificador" method="post" autocomplete="off">
                        <div class="text-center">
                            <div class="alert alert-primary" role="alert" id="titulo_descript_quinto">

                            </div>
                        </div>
                        <input type="hidden" name="id_quintoClasificadorDetalle_new" id="id_quintoClasificadorDetalle_new">
                        <input type="hidden" name="id_quintoClasificadorDetalle_edi" id="id_quintoClasificadorDetalle_edi">
                        <div class="row text-center d-flex justify-content-center align-items-center">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="titulo_detalle" class="form-label">Titulo</label>
                                    <input type="text" class="form-control" id="titulo_detalle__" name="titulo_detalle__" placeholder="Ingrese un titulo">
                                    <div id="_titulo_detalle__"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="descripcion_detalle" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion_detalle__" id="descripcion_detalle__" rows="2" placeholder="Descripción"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-outline-primary" id="btn_guardarquintoClasificadorDetalle">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>TÍTULO</th>
                                    <th>DESCRIPCIÓN</th>
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="listar_detallesQuintoClasificador_html">

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
        var id_primerClas = {{ $primer_clasificador->id }};

        function listar_segundoClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_segundo_clasificador') }}",
                data: {id:id},
                success: function (data) {
                    document.getElementById('ver_segundoClasificador').innerHTML = data;
                }
            });
        }
        listar_segundoClasificador(id_primerClas);

        //par abrir el modal para el segundo clasificador
        function segundo_clasificadorModal(id){
            $('#nuevo_segundoClasificador').modal('show');
            document.getElementById('primer_digitoSegundoClasificador').value = id;
            document.getElementById('primerDigitoSegundoClasificador').value = id;
            vaciarCamposSegundoClasificador();
        }
        //para vaciar los errores del segundo clasificador
        function vaciarErroresSegundoClasificador(){
            document.getElementById('_codigo').innerHTML = '';
            document.getElementById('_titulo').innerHTML = '';
            document.getElementById('_descripcion').innerHTML = '';
        }
        //para vaciar los campos del moda del segundo clasificador
        function vaciarCamposSegundoClasificador(){
            document.getElementById('codigo').value = '';
            document.getElementById('titulo').value = '';
            document.getElementById('descripcion').value = '';
            vaciarErroresSegundoClasificador();
        }

        //para crear nuevo segundo clasificador
        $(document).on('click', '#btn_guardarSegundoClasificador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorSegundo'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_segundo_clasificadorGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresSegundoClasificador();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        setTimeout(() => {
                            $('#nuevo_segundoClasificador').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //eliminar el segundo clasificador
        function eliminarSegundoClasificador(id){
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
                        url: "{{ route('adm_segundo_clasificadorEliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_segundoClasificador(id_primerClas);
                                listar_tercerClasificador(id_primerClas);
                                listar_cuartoClasificador(id_primerClas);
                                listar_quintoClasificador(id_primerClas);
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

        //PARA LA PARTE DE LA EDICION DE SEGUNDO CLASIFICADOR
        function editarSegundoClasificador(id, primer_digito){
            vaciarErroresModalEditar();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_segundo_clasificadorEditar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        let numero = data.mensaje.codigo;
                        $('#editar_segundoClasificador').modal('show');
                        document.getElementById('primer_digitoSegundoClasificador_edi').value = primer_digito;
                        document.getElementById('id_SegundoClasificador').value = data.mensaje.id;
                        document.getElementById('primerDigitoSegundoClasificador_edi').value = primer_digito;
                        document.getElementById('codigo_').value = numero.toString().substring(numero.toString().length - 4);
                        document.getElementById('titulo_').value = data.mensaje.titulo;
                        document.getElementById('descripcion_').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }

        //para vaciar erroresdel modal para editar segundo clasificador
        function vaciarErroresModalEditar(){
            document.getElementById('_codigo_').innerHTML = '';
            document.getElementById('_titulo_').innerHTML = '';
            document.getElementById('_descripcion_').innerHTML = '';
        }
        //para guardar lo editado del segundo clasificador
        $(document).on('click', '#btn_editarGuardarSegundoClasificador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorSegundoEditar'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_segundo_clasificadorEditarGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresModalEditar();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        setTimeout(() => {
                            $('#editar_segundoClasificador').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        /*PARA EL TERCER CLASIFICADOR*/
        function listar_tercerClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificador') }}",
                data: {id:id},
                success: function (data) {
                    document.getElementById('ver_tercerClasificador').innerHTML  = data;
                }
            });
        }
        listar_tercerClasificador(id_primerClas);

        //para abrir el modal del tercer clasificador
        function modalTercerClasificador(){
            $('#nuevo_tercerClasificador').modal('show');
        }
        select2_rodry('#nuevo_tercerClasificador');
        //para ver los dos primeros digotos del el segundo clasificador
        function selectSegundoClasificador2(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_verificarSegundoClasificador') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('primerosDosDigitosVer').value = data.primerosdosDigitos;
                        document.getElementById('primerosDosDigitosEnviar').value = data.primerosdosDigitos;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }
        //para guardar el tercer clasificador
        $(document).on('click', '#btn_guardarTercerClasificador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorTercer'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificadorGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresModalNuevoTercerClasificador();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        vaciarCamposModalNuevoTercerClasi();
                        setTimeout(() => {
                            $('#nuevo_tercerClasificador').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para vaciar los errores de elo formulario del tercer clasificador
        function vaciarErroresModalNuevoTercerClasificador(){
            document.getElementById('_codigo___').innerHTML = '';
            document.getElementById('_titulo___').innerHTML = '';
            document.getElementById('_seleccioneSegundoClasificador').innerHTML = '';
        }
        //para vaciar los campos de tercer clasificador
        function vaciarCamposModalNuevoTercerClasi(){
            limpiar_campos('form_clasificadorTercer');
            $(".select2").val('selected').trigger('change');
            vaciarErroresModalNuevoTercerClasificador();
        }
        //para eliminar el tercer clasificador
        function eliminar_tercerClasificador(id){
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
                        url: "{{ route('adm_tercer_clasificadorEliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_segundoClasificador(id_primerClas);
                                listar_tercerClasificador(id_primerClas);
                                listar_cuartoClasificador(id_primerClas);
                                listar_quintoClasificador(id_primerClas);
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

        segundo_select2('#editar_tercerClasificadorModal');
        //para editar el tercer clasificador
        function editar_tercerClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificadorEditar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    vaciarErroresModalTercerClasificador();
                    if(data.tipo==='success'){
                        $('#editar_tercerClasificadorModal').modal('show');
                        $('#seleccioneSegundoClasificadorEditar').val(data.mensaje.id_clasificador_segundo).trigger('change');
                        document.getElementById('codigo____').value = data.ultimosTresDigitos;
                        document.getElementById('titulo____').value = data.mensaje.titulo;
                        document.getElementById('descripcion____').value = data.mensaje.descripcion;
                        document.getElementById('id_tercerClasificador').value = data.mensaje.id;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        //para validar o cambiar del select
        function selectSegundoClasificador2_edit(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_verificarSegundoClasificador') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('primerosDosDigitosEnviar_edi').value = data.primerosdosDigitos;
                        document.getElementById('primerosDosDigitosVerEditar').value = data.primerosdosDigitos;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }
        //para guardar lo editado del clasificador tercero
        $(document).on('click', '#btn_guardarTercerClasificador_Edit', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorTerceroEditar'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificadorEdGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresModalTercerClasificador();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        vaciarCamposModalNuevoTercerClasi();
                        setTimeout(() => {
                            $('#editar_tercerClasificadorModal').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //vaciar los campos de errores de cuadno se realza la edicion del tercer clasificador
        function vaciarErroresModalTercerClasificador(){
            document.getElementById('_codigo____').innerHTML = '';
            document.getElementById('_titulo____').innerHTML = '';
            document.getElementById('_seleccioneSegundoClasificadorEditar').innerHTML = '';
        }




        //PARA ADMINISTRACION DE CUARTO CLASIFICADOR
        function listar_cuartoClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificador') }}",
                data: {id:id},
                success: function (data) {
                    document.getElementById('ver_cuartoClasificador').innerHTML = data;
                }
            });
        }
        listar_cuartoClasificador(id_primerClas);

        //para abriel el modal de crear nuevo
        function nuevoModalCuartoClasificador(){
            $('#nuevo_cuartoClasificador').modal('show');
        }
        tercero_select2('#nuevo_cuartoClasificador');

        //para listar los clasificadores teceros
        function listar_tercerClasificador3(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificadorListar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#seleccionarTercerClasificador').empty().append(
                        '<option selected disabled>[SELECCIONE EL TERCER CLASIFICADOR]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#seleccionarTercerClasificador').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }

        //para sacar los primeros digitos del tercer clasificador
        function SacarPrimerosDigitosTercerClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_verificar_tercerclasificador') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('primerosTresDigitosEnviar').value = data.primerostresDigitos;
                        document.getElementById('primerosTresDigitosVer').value = data.primerostresDigitos;
                    }
                    /* if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    } */
                }
            });
        }

        //para el moento en que salga del nodal debe eliminarse los errores y tambien los imputs
        function vaciarCamposModalCuartoClasificador(){
            $(".select2_tercero").val('selected').trigger('change');
            limpiar_campos('form_clasificadorCuarto');
            vaciarCamposConErroresCuartoClasificador();
        }
        //vaciar los errores
        function vaciarCamposConErroresCuartoClasificador(){
            document.getElementById('_seleccionarSegundoClasificador_').innerHTML='';
            document.getElementById('_seleccionarTercerClasificador').innerHTML='';
            document.getElementById('_codigo_____').innerHTML='';
            document.getElementById('_titulo_____').innerHTML='';
        }
        //para guardar el cuarto clasificador
        $(document).on('click', '#btn_guardarCuartoClasificador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorCuarto'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificadorGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarCamposConErroresCuartoClasificador();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        vaciarCamposModalCuartoClasificador();
                        setTimeout(() => {
                            $('#nuevo_cuartoClasificador').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para editar el cuarto clasificador
        function editar_cuartoClasificador(id, idSegundo_clasi){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificadorEditar') }}",
                data: {id:id, idSegundo_clasi:idSegundo_clasi},
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    if(data.tipo==='success'){
                        $('#editar_cuartoClasificador').modal('show');
                        document.getElementById('idCuartoClasificadorEditar').value = data.mensaje.id;
                        $('#seleccionarSegundoClasificadorEditar').val(data.clasificador_terceroSegundoId).trigger('change');
                        //PARA LA PARTE DE SELECCIONAR EL TERCER CLASIFICADOR
                        data.listar_clasificadorTerceroR.forEach(value => {
                            $('#seleccionarTercerClasificadorEditar').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                        $('#seleccionarTercerClasificadorEditar').val(data.mensaje.id_clasificador_tercero).trigger('change');
                        document.getElementById('primerosTresDigitosEnviar_editar').value = data.primerosTresDigitos;
                        document.getElementById('primerosTresDigitosVer_editar').value = data.primerosTresDigitos;
                        document.getElementById('codigo______').value = data.ultimosDosDigitos;
                        document.getElementById('titulo______').value = data.mensaje.titulo;
                        document.getElementById('descripcion______').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        function vaciarCamposCuartoClasificadorEditar(){
            limpiar_campos('form_clasificadorCuartoEditar');
            vaciarErroresCuartoClasificadorEditar();
            $('#seleccionarTercerClasificadorEditar').empty().append(
                '<option selected disabled>[SELECCIONE EL TERCER CLASIFICADOR]</option>'
            );
        }

        //para vaciar los errores del cuarto clasificador a editar
        function vaciarErroresCuartoClasificadorEditar(){
            document.getElementById('_seleccionarSegundoClasificadorEditar').innerHTML = '';
            document.getElementById('_seleccionarTercerClasificadorEditar').innerHTML = '';
            document.getElementById('_codigo______').innerHTML = '';
            document.getElementById('_titulo______').innerHTML = '';
        }
        //para listar ek tercer clasificador
        let select2_seleccionarSegundoClasificadorEditar = $("#seleccionarSegundoClasificadorEditar");
        select2_seleccionarSegundoClasificadorEditar.on('select2:select', function(e){
            let id = select2_seleccionarSegundoClasificadorEditar.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificadorListar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#seleccionarTercerClasificadorEditar').empty().append(
                        '<option selected disabled>[SELECCIONE EL TERCER CLASIFICADOR]</option>'
                    );
                    document.getElementById('primerosTresDigitosEnviar_editar').value = '';
                    document.getElementById('primerosTresDigitosVer_editar').value = '';
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#seleccionarTercerClasificadorEditar').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });

                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });


        //para sacar los tres primeros digitos de el tercer tercer_clasificador

        let select2_seleccionarTercerClasificadorEditar = $("#seleccionarTercerClasificadorEditar");
        select2_seleccionarTercerClasificadorEditar.on('select2:select', function(e){
            e.preventDefault();
            let id = select2_seleccionarTercerClasificadorEditar.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_verificar_tercerclasificador') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('primerosTresDigitosEnviar_editar').value = data.primerostresDigitos;
                        document.getElementById('primerosTresDigitosVer_editar').value = data.primerostresDigitos;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        cuarto_select2('#editar_cuartoClasificador');
        //para guardar el cuarto clasificador editado
        $(document).on('click', '#btn_guardarCuartoClasificadorEditar', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorCuartoEditar'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificadorEGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresCuartoClasificadorEditar();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        setTimeout(() => {
                            vaciarCamposCuartoClasificadorEditar();
                            $('#editar_cuartoClasificador').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });
        //para eliminar el cuartro clasificador
        function eliminar_cuartoClasificador(id){
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
                        url: "{{ route('adm_cuarto_clasificadorEliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_segundoClasificador(id_primerClas);
                                listar_tercerClasificador(id_primerClas);
                                listar_cuartoClasificador(id_primerClas);
                                listar_quintoClasificador(id_primerClas);
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


        //PARA EL QUINTO CLASIFICADOR
        function listar_quintoClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_quinto_clasificador') }}",
                data: {id:id},
                success: function (data) {
                    document.getElementById('ver_quintoClasificador').innerHTML = data;
                }
            });
        }
        listar_quintoClasificador(id_primerClas);

        //para abrir el modal y crear el quinto clasificador
        function nuevoModalquintoClasificador(){
            $('#nuevo_quintoClasificador').modal('show');
        }
        quinto_select2('#nuevo_quintoClasificador');
        //para listar el tercer clasificador
        function listar_tercerClasificador5(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificadorListar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#seleccionarTercerClasificador_').empty().append(
                        '<option selected disabled>[SELECCIONE EL TERCER CLASIFICADOR]</option>'
                    );
                    $('#seleccionarCuartoClasificador').empty().append(
                        '<option selected disabled>[SELECCIONE EL CUARTO CLASIFICADOR]</option>'
                    );
                    document.getElementById('primerosCuatroDigitosEnviar').value = '';
                        document.getElementById('primerosCuatroDigitosVer').value = '';
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#seleccionarTercerClasificador_').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }
        //para listar el cuarto clasificador
        function listarCuartoClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificadorListar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    $('#seleccionarCuartoClasificador').empty().append(
                        '<option selected disabled>[SELECCIONE EL CUARTO CLASIFICADOR]</option>'
                    );
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#seleccionarCuartoClasificador').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        }
        //para sacar los primeros 4 digitos
        let select2_seleccionarCuartoClasificador = $("#seleccionarCuartoClasificador");
        select2_seleccionarCuartoClasificador.on('select2:select', function(e){
            let id = select2_seleccionarCuartoClasificador.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificadorCuatroDigitos') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('primerosCuatroDigitosEnviar').value = data.primerosCuatroDigitos;
                        document.getElementById('primerosCuatroDigitosVer').value = data.primerosCuatroDigitos;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });


        //para vaciar el modal del quinto clasificador
        function vaciarCamposModalQuintoClasificador(){
            limpiar_campos('form_clasificadorQuinto');
            $(".select2_quinto").val('selected').trigger('change');
            vaciarErroresModalQuintoClasificador();
        }
        //para  vaciar los campos de errores del modal quinto clasificador
        function vaciarErroresModalQuintoClasificador(){
            document.getElementById('_seleccionarSegundoClasificador__').innerHTML='';
            document.getElementById('_seleccionarTercerClasificador_').innerHTML='';
            document.getElementById('_seleccionarCuartoClasificador').innerHTML='';
            document.getElementById('_codigo_______').innerHTML='';
            document.getElementById('_titulo_______').innerHTML='';
        }
        //para guardar el quinto clasificador
        $(document).on('click', '#btn_guardarQuintoClasificador', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorQuinto'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_quinto_clasificadorGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresModalQuintoClasificador();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        setTimeout(() => {
                            vaciarCamposModalQuintoClasificador();
                            $('#nuevo_quintoClasificador').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para editar el quinto clasificador
        function editar_quintoClasificador(id, id_segundoClasificador, id_tercerClasificador, id_cuartoClasificador){
            $('#seleccionarTercerClasificadorEditar___').empty().append(
                '<option selected disabled>[SELECCIONE EL TERCER CLASIFICADOR]</option>'
            );
            $('#seleccionarCuartoClasificadorEditar_').empty().append(
                '<option selected disabled>[SELECCIONE EL CUARTO CLASIFICADOR abajo]</option>'
            );
            $.ajax({
                type: "POST",
                url: "{{ route('adm_quinto_clasificadorEditar') }}",
                data: {
                    id:id,
                    id_segundoClasificador:id_segundoClasificador,
                    id_tercerClasificador:id_tercerClasificador,
                    id_cuartoClasificador:id_cuartoClasificador
                },
                dataType: "JSON",
                success: function (data) {
                    vaciarErroresFormularioQuintoClasificadorEditar();
                    if(data.tipo==='success'){
                        $('#editar_quintoClasificador').modal('show');
                        document.getElementById('idClasificadorQuinto').value = data.mensaje.id;
                        $('#seleccionarSegundoClasificador___').val(id_segundoClasificador).trigger('change');
                        //para listar el tercer clasificador
                        data.tercerClasificadorEditar.forEach(value => {
                            $('#seleccionarTercerClasificadorEditar___').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                        $('#seleccionarTercerClasificadorEditar___').val(id_tercerClasificador).trigger('change');
                        //para listar el cuarto clasificador
                        data.cuartoClasificadorEditar.forEach(value => {
                            $('#seleccionarCuartoClasificadorEditar_').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                        $('#seleccionarCuartoClasificadorEditar_').val(id_cuartoClasificador).trigger('change');
                        //complementar los demas datos
                        document.getElementById('primerosCuatroDigitosEnviarEditar').value = data.primerosCuatroDigitos;
                        document.getElementById('primerosCuatroDigitosVerEditar').value = data.primerosCuatroDigitos;
                        document.getElementById('codigo________').value = data.ultimoDigito;
                        document.getElementById('titulo________').value = data.mensaje.titulo;
                        document.getElementById('descripcion________').value = data.mensaje.descripcion;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        }
        sexto_select2('#editar_quintoClasificador');
        //para vaciar los errores que traera el formulario al estar vacio
        function vaciarErroresFormularioQuintoClasificadorEditar(){
            document.getElementById('_seleccionarSegundoClasificador___').innerHTML='';
            document.getElementById('_seleccionarTercerClasificadorEditar___').innerHTML='';
            document.getElementById('_seleccionarCuartoClasificadorEditar_').innerHTML='';
            document.getElementById('_codigo________').innerHTML='';
            document.getElementById('_titulo________').innerHTML='';
        }
        //para listar el tercer clasificador
        let select2_seleccionarSegundoClasificador___ = $("#seleccionarSegundoClasificador___");
        select2_seleccionarSegundoClasificador___.on('select2:select', (e)=>{
            let id = select2_seleccionarSegundoClasificador___.val();
            $('#seleccionarTercerClasificadorEditar___').empty().append(
                '<option selected disabled>[SELECCIONE EL TERCER CLASIFICADOR]</option>'
            );
            $('#seleccionarCuartoClasificadorEditar_').empty().append(
                '<option selected disabled>[SELECCIONE EL CUARTO CLASIFICADOR abajo]</option>'
            );
            document.getElementById('primerosCuatroDigitosEnviarEditar').value = '';
            document.getElementById('primerosCuatroDigitosVerEditar').value = '';
            $.ajax({
                type: "POST",
                url: "{{ route('adm_tercer_clasificadorListar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#seleccionarTercerClasificadorEditar___').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });
        //para listar el cuarto clasificador
        let select2_seleccionarTercerClasificadorEditar___ = $('#seleccionarTercerClasificadorEditar___');
        select2_seleccionarTercerClasificadorEditar___.on('select2:select', ()=>{
            let id = select2_seleccionarTercerClasificadorEditar___.val();
            $('#seleccionarCuartoClasificadorEditar_').empty().append(
                '<option selected disabled>[SELECCIONE EL CUARTO CLASIFICADOR]</option>'
            );
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificadorListar') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        let datos = data.mensaje;
                        datos.forEach(value => {
                            $('#seleccionarCuartoClasificadorEditar_').append('<option value = "' + value.id + '">' + value.titulo + '</option>');
                        });
                    }
                    if(data.tipo==='error'){
                        toastr[data.tipo](data.mensaje);
                    }
                }
            });
        });
        //para colocar los primeros 4 digitos en el quinto clasificador
        let select2_seleccionarCuartoClasificadorEditar_ = $('#seleccionarCuartoClasificadorEditar_');
        select2_seleccionarCuartoClasificadorEditar_.on('select2:select', ()=>{
            let id = select2_seleccionarCuartoClasificadorEditar_.val();
            $.ajax({
                type: "POST",
                url: "{{ route('adm_cuarto_clasificadorCuatroDigitos') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if(data.tipo==='success'){
                        document.getElementById('primerosCuatroDigitosEnviarEditar').value = data.primerosCuatroDigitos;
                        document.getElementById('primerosCuatroDigitosVerEditar').value = data.primerosCuatroDigitos;
                    }
                    if(data.tipo==='error'){
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para guardar el quinto clasificador
        $(document).on('click', '#btn_guardarQuintoClasificadorEditar',(e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_clasificadorQuintoEditar'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_quinto_clasificadorEGuardar') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    vaciarErroresFormularioQuintoClasificadorEditar();
                    if (data.tipo == 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo == 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        listar_segundoClasificador(id_primerClas);
                        listar_tercerClasificador(id_primerClas);
                        listar_cuartoClasificador(id_primerClas);
                        listar_quintoClasificador(id_primerClas);
                        setTimeout(() => {
                            $('#editar_quintoClasificador').modal('hide');
                        }, 1000);
                    }
                    if (data.tipo == 'error') {
                        alerta_top(data.tipo, data.mensaje);
                    }
                }
            });
        });
        //para eliminar el quinto clasificador
        function eliminar_quintoClasificador(id){
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
                        url: "{{ route('adm_quinto_clasificadorEliminar') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                listar_segundoClasificador(id_primerClas);
                                listar_tercerClasificador(id_primerClas);
                                listar_cuartoClasificador(id_primerClas);
                                listar_quintoClasificador(id_primerClas);
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

        //PARA LOS DETALLES DEL TERCER CLASIFICADOR
        function detalles_tercerClasificadorModal(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_ListardetallesTercerClasificador') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        $('#modal_detallesTercerClasificador').modal('show');
                        document.getElementById('id_tercerClasificadorDetalle_new').value = data.mensaje.id;
                        document.getElementById('titulo_descript').innerHTML = `<h5 class="alert-heading">`+data.mensaje.codigo+' '+ data.mensaje.titulo +`</h5>`;
                        let datos = data.mensaje.detalle_tercerclasificador;
                        let cuerpo = "";
                        for (let key in datos) {
                            cuerpo += '<tr>';
                            cuerpo += "<td>" + datos[key]['titulo'] + "</td>";
                            if(datos[key]['descripcion']!= null){
                                cuerpo += "<td width='50%'>" + datos[key]['descripcion'] + "</td>";
                            }else{
                                cuerpo += "<td width='50%'> </td>";
                            }
                            if (datos[key]['estado'] == 'activo') {
                                cuerpo += "<td> <span class='badge text-bg-success'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            } else {
                                cuerpo += "<td> <span class='badge text-bg-danger'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            }
                            cuerpo += `<td>
                                    <button type="button" class="btn btn-outline-warning" onclick="editar_detallesTercerClasificador('${datos[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                                    <button type="button" class="btn btn-outline-primary" onclick="cambiar_estadoDetallesTercerClasificador('${datos[key]['id']}')">Estado</button>
                                </td>`;
                            cuerpo += '</tr>';
                        }
                        document.getElementById('listar_detallesTercerClasificador_html').innerHTML = cuerpo;
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                },
                error: function() {
                    toastr["error"]("Ocurrio un error");
                }
            });
        }

        //para vaciar los errores
        function vaciar_campoDetalleTercerClasificador(){
            limpiar_campos('form_detalleTercerClasificador');
        }
        //para limpirar los errores
        function limpiar_erroresDetalleTercerClasificador(){
            document.getElementById('_titulo_detalle').innerHTML = '';
        }
        //para vaciar los campos de tipo input
        function vaciar_inputTercerClasificador(){
            document.getElementById('id_tercerClasificadorDetalle_edi').value = '';
            document.getElementById('titulo_detalle').value = '';
            document.getElementById('descripcion_detalle').value = '';
        }

        //para guardar los detllaes del tercer clasificador
        $(document).on('click', '#btn_guardartercerClasificadorDetalle', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_detalleTercerClasificador'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_guardardetallesTercerClasificador') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    limpiar_erroresDetalleTercerClasificador();
                    if (data.tipo === 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        detalles_tercerClasificadorModal(data.id_clasificadorTerceroDet);
                        vaciar_inputTercerClasificador();
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //para la parte de la edicion de detalles del clasificador
        function editar_detallesTercerClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editardetallesTercerClasificador') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if (data.tipo === 'success') {
                        document.getElementById('id_tercerClasificadorDetalle_edi').value= data.mensaje.id;
                        document.getElementById('titulo_detalle').value= data.mensaje.titulo;
                        document.getElementById('descripcion_detalle').value= data.mensaje.descripcion;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }
        //para cambiar el estado
        function cambiar_estadoDetallesTercerClasificador(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de cambiar el estado?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Cambiar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_estadodetallesTercerClasificador') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                detalles_tercerClasificadorModal(data.id_tercerClasificador_r);
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

        //PARA LOS DETALLES DEL CUARTO CLASIFICADOR
        function detalles_cuartoClasificadorModal(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listarDetallescuartoClasificador') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        $('#modal_detallesCuartoClasificador').modal('show');
                        document.getElementById('id_cuartoClasificadorDetalle_new').value = data.mensaje.id;
                        document.getElementById('titulo_descript_cuarto').innerHTML = `<h5 class="alert-heading">`+data.mensaje.codigo+' '+ data.mensaje.titulo +`</h5>`;
                        let datos = data.mensaje.detalle_cuarto_clasificador;
                        let cuerpo = "";
                        for (let key in datos) {
                            cuerpo += '<tr>';
                            cuerpo += "<td>" + datos[key]['titulo'] + "</td>";
                            if(datos[key]['descripcion']!= null){
                                cuerpo += "<td width='30%'>" + datos[key]['descripcion'] + "</td>";
                            }else{
                                cuerpo += "<td width='30%'> </td>";
                            }
                            if (datos[key]['estado'] == 'activo') {
                                cuerpo += "<td> <span class='badge text-bg-success'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            } else {
                                cuerpo += "<td> <span class='badge text-bg-danger'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            }
                            cuerpo += `<td width='30%'>
                                    <button type="button" class="btn btn-outline-warning" onclick="editar_detallesCuartoClasificador('${datos[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                                    <button type="button" class="btn btn-outline-primary" onclick="cambiar_estadoDetallesCuartoClasificador('${datos[key]['id']}')">Estado</button>
                                </td>`;
                            cuerpo += '</tr>';
                        }
                        document.getElementById('listar_detallesCuartoClasificador_html').innerHTML = cuerpo;
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                },
                error: function() {
                    toastr["error"]("Ocurrio un error");
                }
            });
        }

        //para vaciar los errores
        function vaciar_campoDetalleCuartoClasificador(){
            limpiar_campos('form_detalleCuartoClasificador');
        }
        //para limpirar los errores
        function limpiar_erroresDetalleCuartoClasificador(){
            document.getElementById('_titulo_detalle_').innerHTML = '';
        }
        //para vaciar los campos de tipo input
        function vaciar_inputCuartoClasificador(){
            document.getElementById('id_cuartoClasificadorDetalle_edi').value = '';
            document.getElementById('titulo_detalle_').value = '';
            document.getElementById('descripcion_detalle_').value = '';
        }

        //para guardar los detllaes del cuarto clasificador
        $(document).on('click', '#btn_guardarcuartoClasificadorDetalle', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_detalleCuartoClasificador'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_guardarDetallescuartoClasificador') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    limpiar_erroresDetalleCuartoClasificador();
                    if (data.tipo === 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        detalles_cuartoClasificadorModal(data.id_clasificadorCuartoDet);
                        vaciar_inputCuartoClasificador();
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //para la parte de la edicion de detalles del clasificador
        function editar_detallesCuartoClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editarDetallescuartoClasificador') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if (data.tipo === 'success') {
                        document.getElementById('id_cuartoClasificadorDetalle_edi').value= data.mensaje.id;
                        document.getElementById('titulo_detalle_').value= data.mensaje.titulo;
                        document.getElementById('descripcion_detalle_').value= data.mensaje.descripcion;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }

        //para cambiar el estado
        function cambiar_estadoDetallesCuartoClasificador(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de cambiar el estado?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Cambiar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_estadodetallesCuartoClasificador') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                detalles_cuartoClasificadorModal(data.id_cuartoClasificador_r);
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


        //PARA LOS DETALLES DEL QUINTO CLASIFICADOR
        function detalles_quintoClasificadorModal(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_listarDetallesquintoClasificador') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.tipo === 'success') {
                        $('#modal_detallesQuintoClasificador').modal('show');
                        document.getElementById('id_quintoClasificadorDetalle_new').value = data.mensaje.id;
                        document.getElementById('titulo_descript_quinto').innerHTML = `<h5 class="alert-heading">`+data.mensaje.codigo+' '+ data.mensaje.titulo +`</h5>`;
                        let datos = data.mensaje.detalle_quinto_clasificador;
                        let cuerpo = "";
                        for (let key in datos) {
                            cuerpo += '<tr>';
                            cuerpo += "<td>" + datos[key]['titulo'] + "</td>";
                            if(datos[key]['descripcion']!= null){
                                cuerpo += "<td width='50%'>" + datos[key]['descripcion'] + "</td>";
                            }else{
                                cuerpo += "<td width='50%'> </td>";
                            }
                            if (datos[key]['estado'] == 'activo') {
                                cuerpo += "<td> <span class='badge text-bg-success'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            } else {
                                cuerpo += "<td> <span class='badge text-bg-danger'>" + datos[key]['estado'] +
                                    "</span> </td>";
                            }
                            cuerpo += `<td>
                                    <button type="button" class="btn btn-outline-warning" onclick="editar_detallesQuintoClasificador('${datos[key]['id']}')"><i class="ri-edit-2-fill"></i></button>
                                    <button type="button" class="btn btn-outline-primary" onclick="cambiar_estadoDetallesQuintoClasificador('${datos[key]['id']}')">Estado</button>
                                </td>`;
                            cuerpo += '</tr>';
                        }
                        document.getElementById('listar_detallesQuintoClasificador_html').innerHTML = cuerpo;
                    }
                    if (data.tipo === 'error') {
                        toastr[data.tipo](data.mensaje);
                    }
                },
                error: function() {
                    toastr["error"]("Ocurrio un error");
                }
            });
        }
        //para vaciar los errores
        function vaciar_campoDetalleQuintoClasificador(){
            limpiar_campos('form_detalleCuartoClasificador');
        }
        //para limpirar los errores
        function limpiar_erroresDetalleQuintoClasificador(){
            document.getElementById('_titulo_detalle__').innerHTML = '';
        }
        //para vaciar los campos de tipo input
        function vaciar_inputQuintoClasificador(){
            document.getElementById('id_quintoClasificadorDetalle_edi').value = '';
            document.getElementById('titulo_detalle__').value = '';
            document.getElementById('descripcion_detalle__').value = '';
        }

        //para guardar los detllaes del cuarto clasificador
        $(document).on('click', '#btn_guardarquintoClasificadorDetalle', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_detalleQuintoClasificador'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_guardarDetallesquintoClasificador') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    limpiar_erroresDetalleQuintoClasificador();
                    if (data.tipo === 'errores') {
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_' + key).innerHTML ='<div id="error_in" >' + objeto[key] + '</div>';
                        }
                    }
                    if (data.tipo === 'success') {
                        alerta_top(data.tipo, data.mensaje);
                        detalles_quintoClasificadorModal(data.id_clasificadorQuintoDet);
                        vaciar_inputQuintoClasificador();
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        });

        //para editar
        function editar_detallesQuintoClasificador(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editarDetallesquintoClasificador') }}",
                data: {id:id},
                dataType: "JSON",
                success: function (data) {
                    if (data.tipo === 'success') {
                        document.getElementById('id_quintoClasificadorDetalle_edi').value= data.mensaje.id;
                        document.getElementById('titulo_detalle__').value= data.mensaje.titulo;
                        document.getElementById('descripcion_detalle__').value= data.mensaje.descripcion;
                    }
                    if (data.tipo === 'error') {
                        alerta_top(data.tipo, data.mensaje)
                    }
                }
            });
        }
        //para cambiar el estado
        function cambiar_estadoDetallesQuintoClasificador(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'NOTA!',
                text: "Esta seguro de cambiar el estado?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si, Cambiar!',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_estadodetallesQuintoClasificador') }}",
                        data: {id: id},
                        dataType: "JSON",
                        success: function(data) {
                            if (data.tipo === 'success') {
                                alerta_top(data.tipo, data.mensaje);
                                detalles_quintoClasificadorModal(data.id_quintoClasificador_r);
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
