<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
        <div class="alert alert-primary text-center" role="alert">
            <h6 class="alert-heading">{{ '[ '.$asignacion_formulario4->financiamiento_tipo->sigla.' ]' }}</h6>
            <h6 class="alert-heading">{{ $asignacion_formulario4->financiamiento_tipo->descripcion }}</h6>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
        <div class="alert alert-danger text-center" role="alert">
            <h6 class="alert-heading">Monto Asignado</h6>
            <h6 class="alert-heading">{{ con_separador_comas($asignacion_formulario4->monto_asignado).' Bs' }}</h6>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
        <div class="alert alert-danger text-center" role="alert">
            <h6 class="alert-heading">Monto en caja</h6>
            <h6 class="alert-heading">{{ con_separador_comas($caja_actual[0]->saldo).' Bs' }}</h6>
        </div>
    </div>
</div>

<form id="form_asignarformulario4_asignacionEditar" method="post" autocomplete="off">
    <div class="row text-center d-flex justify-content-center align-items-center">
        <input type="hidden" id="asignacionf4_id" name="asignacionf4_id" value="{{ $asignacion_formulario4->id }}">
        <input type="hidden" id="monto_asignado_f4_edi" name="monto_asignado_f4_edi" value="{{ con_separador_comas($asignacion_formulario4->monto_asignado) }}">
        <input type="hidden" id="monto_actual_en_caja_edi" name="monto_actual_en_caja_edi" value="{{ con_separador_comas($caja_actual[0]->saldo) }}">
        <input type="hidden" id="id_caja" name="id_caja" value="{{ $caja_actual[0]->id }}">

        <input type="hidden" id="id_formulario4_enviado" name="id_formulario4_enviado" value="{{ $id_formulario4_enviado }}">
        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <div class="mb-3">
                <label for="monto_asignar_" class="form-label">Acción</label>
                <div class="input-group">
                    <select name="accion_" id="accion_" class="form-select" onchange="accion_usar(this.value)">
                        <option value="selected" disabled selected>[ACCIÓN]</option>
                        <option value="sumar"> Sumar</option>
                        <option value="restar"> Restar</option>
                    </select>
                    <div id="_accion_"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <div class="mb-3">
                <label for="monto_asignar__" class="form-label" id="monto_ver_nn">Monto: </label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Bs</span>
                    <input type="text" name="monto_asignar__" id="monto_asignar__" class="form-control monto_fig" onkeyup="solo_decimadinero(this.value)" @disabled(true)>
                    <div id="_monto_asignar__"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <div class="mb-3">
                <label for="monto_asignar_env" class="form-label">Monto Asignado</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Bs</span>
                    <input type="text" class="form-control" id="monto_asignar_env" name="monto_asignar_env" readonly disabled>
                    <div id="_monto_asignar_env" ></div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <div class="mb-3">
                <label for="monto_sobrante_ver__" class="form-label">Monto Sobrante</label>
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Bs</span>
                    <input type="text" class="form-control" id="monto_sobrante_ver__" name="monto_sobrante_ver__" readonly disabled>
                    <div id="_monto_sobrante_ver__" ></div>
                </div>
            </div>
        </div>
        <input type="hidden" name="monto_asignar_env__" id="monto_asignar_env__">
        <input type="hidden" name="monto_sobrante_env__" id="monto_sobrante_env__">
        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <div class="mb-3">
                <button class="btn btn-outline-primary" id="btn_guardarasignacionf4_asignacionEditar" disabled>Guardar</button>
            </div>
        </div>
    </div>
</form>



