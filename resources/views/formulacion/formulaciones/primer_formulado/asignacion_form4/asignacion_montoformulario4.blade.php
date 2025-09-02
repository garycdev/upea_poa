
    <table class="table table-hover" style="width: 100%">
        <thead>
            <tr>
                <th>FUENTE DE FINANCIAMIENTO</th>
                <th>MONTO</th>
                <th>FECHA</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @php
                $suma = 0;
            @endphp
            @foreach ($formulario4_asignacion->asignacion_monto_f4 as $lis1)
                <tr>
                    <td> {{ '['.$lis1->financiamiento_tipo->sigla.'] '.$lis1->financiamiento_tipo->descripcion }}</td>
                    <td>{{ con_separador_comas($lis1->monto_asignado) }}</td>
                    @php
                        $suma = $suma + $lis1->monto_asignado;
                    @endphp
                    <td>{{ fecha_literal($lis1->fecha,4) }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning" onclick="editar_financiamiento_f4('{{ $formulario4_asignacion->id }}', '{{ $lis1->id }}')"><i class="ri-edit-2-fill"></i></button>
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td>{{ con_separador_comas($suma). ' Bs' }}</td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

