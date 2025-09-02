<div class="table-responsive">
    <table class="table table-hover align-middle" style="width: 100%; font-size:13px">
        <thead>
            <tr>
                <th>#</th>
                <th>NOMBRE COMPLETO</th>
                <th>ESTADO</th>
                <th>{{ $tipo_financiamiento[0]->sigla }}</th>
                <th>{{ $tipo_financiamiento[1]->sigla }}</th>
                <th>{{ $tipo_financiamiento[2]->sigla }}</th>
                <th>{{ $tipo_financiamiento[3]->sigla }}</th>
                <th>TOTAL</th>
                <th>ACCIÓN</th>
            </tr>
        </thead>
        <tbody id="">

            @php
                $suma_total             = 0;
                $suma_total_TGN         = 0;
                $suma_total_COP_TRIB    = 0;
                $suma_total_IDH         = 0;
                $suma_total_REC_PROP    = 0;
                $suma_total_porine      = 0;
            @endphp
            @if ($resultado->isEmpty())
                No se encontraron datos
            @else
                @foreach ($resultado as $lis)
                    @php
                        $suma_total_porine = 0;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lis->nombre_completo }}</td>
                        <td>
                            @if ($lis->relacion_caja->isEmpty())
                                <span class="badge rounded-pill bg-danger">No financiado</span>
                            @else
                                <span class="badge rounded-pill bg-success">Financiado</span>
                            @endif
                        </td>
                        <td>
                            @foreach ($lis->relacion_caja as $lis1)
                                @if ($lis1->financiamiento_tipo->id==1)
                                    {{ con_separador_comas($lis1->saldo).' Bs' }}
                                    @php
                                        $suma_total_TGN = $suma_total_TGN + $lis1->saldo;
                                    @endphp
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($lis->relacion_caja as $lis1)
                                @if ($lis1->financiamiento_tipo->id==2)
                                    {{ con_separador_comas($lis1->saldo).' Bs' }}
                                    @php
                                        $suma_total_COP_TRIB = $suma_total_COP_TRIB + $lis1->saldo;
                                    @endphp
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($lis->relacion_caja as $lis1)
                                @if ($lis1->financiamiento_tipo->id==3)
                                    {{ con_separador_comas($lis1->saldo).' Bs' }}
                                    @php
                                        $suma_total_IDH = $suma_total_IDH + $lis1->saldo;
                                    @endphp
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($lis->relacion_caja as $lis1)
                                @if ($lis1->financiamiento_tipo->id==4)
                                    {{ con_separador_comas($lis1->saldo).' Bs' }}
                                    @php
                                        $suma_total_REC_PROP = $suma_total_REC_PROP + $lis1->saldo;
                                    @endphp
                                @endif
                                @php
                                    $suma_total_porine = $suma_total_porine + $lis1->saldo;
                                @endphp
                            @endforeach
                        </td>
                        <td>
                            {{ con_separador_comas($suma_total_porine).' Bs' }}
                        </td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm" onclick="asignarFinanciamientoCarreraUnidad('{{ $lis->id }}')">Asignar Financiamiento</button>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" >SUMA TOTAL DE MONTOS ASIGNADOS DE {{ $tipo_carrera_unidad->nombre }} </td>
                <td>{{ con_separador_comas($suma_total_TGN).' Bs' }}</td>
                <td>{{ con_separador_comas($suma_total_COP_TRIB).' Bs' }}</td>
                <td>{{ con_separador_comas($suma_total_IDH).' Bs' }}</td>
                <td>{{ con_separador_comas($suma_total_REC_PROP).' Bs' }}</td>
                <td>
                    @php
                        $suma_total_todo = $suma_total_TGN + $suma_total_COP_TRIB + $suma_total_IDH + $suma_total_REC_PROP;
                    @endphp
                    {{ con_separador_comas($suma_total_todo).' Bs' }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
