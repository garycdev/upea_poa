
<table class="table table-hover" style="width: 100%; font-size:11px">
    <thead>
        <tr>
            <th>DESCRIPCION BIEN O SERVICIO</th>
            <th>MEDIDA</th>
            <th>CANTIDAD</th>
            <th>PRECIO UNITARIO</th>
            <th>TOTAL PRESUPUESTO</th>
            <th>PARTIDA POR OBJETO DE GASTO</th>
            <th>FUENTE DE FINANCIAMIENTO</th>
            <th>FECHA EN LA QUE SE REQUIERE</th>
        </tr>
    </thead>
    <tbody >
        @foreach ($listar_requerimiento->medida_bien_serviciof5 as $lis)
            <tr>
                @if (count($lis->detalle_tercer_clasificador) > 0)
                <td>{{ $lis->detalle_tercer_clasificador[0]->titulo }}</td>
                @endif

                @if (count($lis->detalle_cuarto_clasificador) > 0)
                <td>{{ $lis->detalle_cuarto_clasificador[0]->titulo }}</td>
                @endif

                @if (count($lis->detalle_quinto_clasificador) > 0)
                <td>{{ $lis->detalle_quinto_clasificador[0]->titulo }}</td>
                @endif

                <td>
                    {{ $lis->medida->nombre }}
                </td>
                <td>
                    {{ $lis->cantidad }}
                </td>
                <td>
                    @if (is_numeric($lis->precio_unitario))
                        {{ con_separador_comas($lis->precio_unitario).' Bs' }}
                    @else
                        {{ $lis->precio_unitario }}
                    @endif

                </td>
                <td>

                    @if (is_numeric($lis->total_presupuesto))
                        {{ con_separador_comas($lis->total_presupuesto).' Bs' }}
                    @else
                        {{ $lis->total_presupuesto }}
                    @endif
                </td>

                @if (count($lis->detalle_tercer_clasificador) > 0)
                <td>{{ $lis->detalle_tercer_clasificador[0]->clasificador_tercero->codigo }}</td>
                @endif

                @if (count($lis->detalle_cuarto_clasificador) > 0)
                <td>{{ $lis->detalle_cuarto_clasificador[0]->clasificador_cuarto->codigo }}</td>
                @endif

                @if (count($lis->detalle_quinto_clasificador) > 0)
                <td>{{ $lis->detalle_quinto_clasificador[0]->clasificador_quinto->codigo }}</td>
                @endif

                <td>
                    {{ $lis->tipo_financiamiento->sigla }}
                </td>
                <td>
                    {{ fecha_literal($lis->fecha_requerida,2) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
