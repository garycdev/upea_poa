<div class="modal fade" id="modalValidarMot" tabindex="-1" aria-labelledby="modalValidarLabel" aria-hidden="true">
    <form action="{{ route('mot.validar') }}" method="POST" id="formValidarMot">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalValidarLabel">
                        Revisar formulario MOT N°
                        {{ $mot->nro }}
                        <span class="text-muted" style="font-size: .8em">
                            - {{ $mot->configuracion->gestion->gestion }}<br>
                            {{ $mot->unidad_carrera->nombre_completo }}
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
                            @if (count($mot->motpp) > 0)
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($mot->motpp as $key => $item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->of->descripcion }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $item->accion }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (count($item->mov) > 0)
                                                @php
                                                    $total = 0;
                                                @endphp
                                                <table class="table table-hovered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Partida</th>
                                                            <th>Detalle</th>
                                                            <th>Monto</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($item->mov as $mov)
                                                            <tr>
                                                                <td>
                                                                    {{ $mov->partida_codigo }}
                                                                </td>
                                                                <td>{{ $mov->detalle()->titulo }}</td>
                                                                <td>
                                                                    {{ con_separador_comas($mov->partida_monto) }}&nbsp;bs.
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $total += $mov->partida_monto;
                                                            @endphp
                                                        @endforeach
                                                        @if ($item->accion == 'DE')
                                                            @php
                                                                $saldoDisponible = $item->mot_a($item->id_mot)->saldo;
                                                            @endphp

                                                            <tr style="background: #77ff95aa">
                                                                <td class="fw-bold" align="right" colspan="2">
                                                                    Total modificado
                                                                </td>
                                                                <td class="fw-bold" colspan="2">
                                                                    {{ con_separador_comas($total) }}&nbsp;bs.
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr style="background: #77ff95aa">
                                                                <td class="fw-bold" align="right" colspan="2">
                                                                    Total agregado
                                                                </td>
                                                                <td class="fw-bold" colspan="2">
                                                                    {{ con_separador_comas($total) }}&nbsp;bs.
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            @else
                                                Sin cambios
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->accion == 'A' && $saldoDisponible > 0)
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#partidas_a"
                                                    onclick="agregarPartidaA({{ sin_separador_comas($saldoDisponible) }}, {{ $item->id_mot_pp }}, {{ $item->organismo_financiador }})">
                                                    Agregar
                                                </button>
                                            @endif
                                            {{-- <button class="btn btn-success">
                                                <i class="ri-file-excel-line"></i>&nbsp;EXCEL
                                            </button> --}}
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                @php
                                    $total_de = 0;
                                    $total_a = 0;
                                    foreach ($mot->motpp as $item) {
                                        if ($item->accion == 'DE') {
                                            $total_de = $item->mot_a($item->id_mot)->saldo;
                                        } else {
                                            foreach ($item->mov as $value) {
                                                $total_a += $value->partida_monto;
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background: {{ $total_de + $total_a == $mot->importe ? '#77ff95' : '#dc3545' }}"
                                    class="fw-bold">
                                    <td colspan="2" align="right">TOTAL: </td>
                                    <td>
                                        {{ con_separador_comas($total_de + $total_a) }}&nbsp;bs.
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

                    <input type="hidden" name="id_mot" value="{{ $mot->id_mot }}">
                    <input type="hidden" name="estado" id="estado">
                    <div class="form-group mt-3">
                        <label for="respaldo_tramite" class="form-label">
                            Respaldo de tramite :
                        </label>
                        <input type="text" class="form-control"
                            placeholder="HOJA DE TRAMITE RECTORADO N° 0001/{{ substr($fecha_actual, 0, 4) }} Y NOTA INTERNA CITE: UPEA-CS Nª0001/{{ substr($fecha_actual, 0, 4) }}"
                            oninput="this.value = this.value.toUpperCase()" name="respaldo_tramite"
                            id="respaldo_tramite" value="{{ $mot->respaldo_tramite }}" list="sugerencia" required>
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
                                    value="{{ date('Y-m-d', strtotime($mot->fecha_tramite)) }}" required>
                                <span class="text-danger" id="_fecha_actual"></span>
                            </div>
                            <div class="col-lg-6 col-12">
                                <input type="time" class="form-control" value="{{ $hora_actual }}"
                                    name="hora_actual" id="hora_actual"
                                    value="{{ date('H:i', strtotime($mot->fecha_tramite)) }}" required>
                                <span class="text-danger" id="_hora_actual"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="observacion" class="form-label">
                            Observaciones <span class="text-muted">(opcional)</span>:
                        </label>
                        <textarea class="form-control" name="observacion" id="observacion" placeholder="Observaciones" rows="3" required>{{ $mot->observacion ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        @if ($mot->estado == 'verificado')
                            <a href="{{ route('pdfMot', $mot->id_mot) }}" class="btn btn-outline-danger"
                                target="_blank" style="display:inline-block">
                                <i class="ri-file-pdf-line"></i> Formulario
                            </a>
                        @endif
                        @if ($mot->estado != 'pendiente')
                            <a href="{{ route('mot.pdf', $mot->id_mot) }}" class="btn btn-outline-primary"
                                target="_blank" style="display:inline-block">
                                <i class="ri-file-pdf-line"></i> Solicitud
                            </a>
                        @endif
                    </div>
                    <div>
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger btn-modal-submit-mot" data-estado="rechazado">
                            Rechazar formulario
                        </button>
                        {{-- <button type="button" class="btn btn-warning btn-modal-submit-mot" data-estado="aprobado">
                            Aprobar formulario
                        </button> --}}
                        @if (Auth::user()->rol_verifica() == 'planifica')
                            <button type="button" class="btn btn-primary btn-modal-submit-mot"
                                data-estado="verificado">
                                Formulario verificado
                            </button>
                        @endif
                        @if (Auth::user()->rol_verifica() == 'presupuesto')
                            <button type="button" class="btn btn-success btn-modal-submit-mot"
                                data-estado="aprobado">
                                Aprobar formulario
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
