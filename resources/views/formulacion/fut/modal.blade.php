<div class="modal fade" id="modalValidar" tabindex="-1" aria-labelledby="modalValidarLabel" aria-hidden="true">
    <form action="{{ route('fut.validar') }}" method="POST" id="formValidar">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalValidarLabel">
                        Revisar formulario FUT N°
                        {{ $fut->nro }}
                        <span class="text-muted" style="font-size: .8em">
                            - {{ $fut->configuracion->gestion->gestion }}<br>
                            {{ $fut->unidad_carrera->nombre_completo }}
                        </span>
                    </h1>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-striped" style="font-size:.75em">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Organismo financiador</th>
                                <th>Partidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($fut->futpp) > 0)
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($fut->futpp as $key => $futpp)
                                    <tr>
                                        <td>{{ $i }}
                                        </td>
                                        <td>{{ $futpp->of->descripcion }}
                                        </td>
                                        <td>
                                            @if (count($futpp->mov) > 0)
                                                @php
                                                    $total = 0;
                                                @endphp
                                                <table class="table table-hovered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Partida
                                                            </th>
                                                            <th>Detalle
                                                            </th>
                                                            <th>Monto
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($futpp->mov as $mov)
                                                            <tr>
                                                                <td>
                                                                    {{ $mov->partida_codigo }}
                                                                </td>
                                                                <td>{{ $mov->detalle()->titulo }}
                                                                </td>
                                                                <td>
                                                                    {{ con_separador_comas($mov->partida_monto) }}&nbsp;bs.
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $total += $mov->partida_monto;
                                                            @endphp
                                                        @endforeach
                                                        <tr style="background: #77ff95aa">
                                                            <td class="fw-bold" align="right" colspan="2">
                                                                Total
                                                            </td>
                                                            <td class="fw-bold" colspan="2">
                                                                {{ con_separador_comas($total) }}&nbsp;bs.
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @else
                                                Sin cambios
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                @php
                                    $total3 = 0;
                                    foreach ($fut->futpp as $futpp) {
                                        foreach ($futpp->mov as $value) {
                                            $total3 += $value->partida_monto;
                                        }
                                    }
                                @endphp
                                <tr style="background: {{ $total3 == $fut->importe ? '#77ff95' : '#dc3545' }}"
                                    class="fw-bold">
                                    <td colspan="2" align="right">TOTAL:
                                    </td>
                                    <td>
                                        {{ con_separador_comas($total3) }}&nbsp;bs.
                                    </td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5" align="center">
                                        Ningun gasto registrado
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <input type="hidden" name="id_fut" value="{{ $fut->id_fut }}">
                    <input type="hidden" name="estado" id="estado">
                    <div class="form-group mt-3">
                        <label for="respaldo_tramite" class="form-label">
                            Respaldo de tramite :
                        </label>
                        <input type="text" class="form-control"
                            placeholder="HOJA DE TRAMITE RECTORADO N° 0001/{{ substr($fecha_actual, 0, 4) }} Y NOTA INTERNA CITE: UPEA-CS Nª0001/{{ substr($fecha_actual, 0, 4) }}"
                            oninput="this.value = this.value.toUpperCase()" name="respaldo_tramite"
                            id="respaldo_tramite" value="{{ $fut->respaldo_tramite }}" list="sugerencia" required>
                        <datalist id="sugerencia">
                            <option
                                value="HOJA DE TRAMITE RECTORADO N° 0000/{{ substr($fecha_actual, 0, 4) }} Y NOTA INTERNA CITE: UPEA-CS Nª 0000/{{ substr($fecha_actual, 0, 4) }}">
                        </datalist>
                        <span class="text-danger" id="_respaldo_tramite"></span>
                    </div>
                    <div class="form-group mt-3">
                        <div class="d-flex align-items-center">
                            Fecha de inicio de tramite :
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <input type="date" class="form-control" value="{{ $fecha_actual }}"
                                    name="fecha_actual" id="fecha_actual"
                                    value="{{ date('Y-m-d', strtotime($fut->fecha_tramite)) }}" required>
                                <span class="text-danger" id="_fecha_actual"></span>
                            </div>
                            <div class="col-lg-6 col-12">
                                <input type="time" class="form-control" value="{{ $hora_actual }}"
                                    name="hora_actual" id="hora_actual"
                                    value="{{ date('H:i', strtotime($fut->fecha_tramite)) }}" required>
                                <span class="text-danger" id="_hora_actual"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nro_preventivo" class="form-label">
                            Numero preventivo <span class="text-muted">(opcional)</span>:
                        </label>
                        <input type="text" class="form-control" name="nro_preventivo" id="nro_preventivo"
                            placeholder="Numero preventivo" value="{{ $fut->nro_preventivo }}" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="observacion" class="form-label">
                            Observaciones <span class="text-muted">(opcional)</span>:
                        </label>
                        <textarea class="form-control" name="observacion" id="observacion" placeholder="Observaciones" rows="3" required>{{ $fut->observacion ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        {{-- @if ($fut->estado == 'verificado')
                            <a href="{{ route('pdfFut', $fut->id_fut) }}" class="btn btn-outline-danger"
                                target="_blank" style="display:inline-block">
                                <i class="ri-file-pdf-line"></i> Formulario
                            </a>
                        @endif --}}
                        @if ($fut->estado != 'pendiente')
                            <a href="{{ route('fut.pdf', encriptar($fut->id_fut)) }}" class="btn btn-outline-primary"
                                target="_blank" style="display:inline-block">
                                <i class="ri-file-pdf-line"></i> Solicitud
                            </a>
                        @endif
                    </div>
                    <div>
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger btn-modal-submit-fut" data-estado="rechazado">
                            Rechazar formulario
                        </button>
                        {{-- <button type="button" class="btn btn-warning btn-modal-submit" data-estado="aprobado">
                            Aprobar formulario
                        </button> --}}
                        @if ($fut->estado == 'elaborado' && Auth::user()->rol_verifica() == 'planifica')
                            <button type="button" class="btn btn-primary btn-modal-submit" data-estado="verificado">
                                Formulario verificado
                            </button>
                        @endif
                        @if ($fut->estado == 'verificado' && Auth::user()->rol_verifica() == 'presupuesto')
                            <button type="button" class="btn btn-success btn-modal-submit" data-estado="aprobado">
                                Aprobar compra
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
