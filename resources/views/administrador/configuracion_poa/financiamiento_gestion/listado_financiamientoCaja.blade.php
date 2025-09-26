<div class="py-2 text-center">
    <div class="alert alert-primary" role="alert">
        <h5> {{ $carrera_unidad->nombre_completo }} </h5>
    </div>
</div>
<table class="table table-hover align-middle text-center" style="width: 100%">
    <thead>
        <tr>
            <th>TIPO DE FINANCIAMIENTO </th>
            <th>FECHA</th>
            <th>SALDO</th>
            <th>MONTO</th>
            <th>DOCUMENTO</th>
            <th>ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        @php
            $suma = 0;
            $monto = 0;
        @endphp
        @foreach ($caja_asignadaFinanciada as $lis)
            @php
                $suma = $suma + $lis->saldo;
                $monto = $monto + $lis->monto;
            @endphp
            <tr>
                <td>{{ $lis->financiamiento_tipo->descripcion }}</td>
                <td>{{ fecha_literal($lis->fecha, 4) }}</td>
                <td>{{ con_separador_comas($lis->saldo) }}</td>
                <td>{{ con_separador_comas($lis->monto) }}</td>
                <td>
                    <a class="btn btn-outline-danger btn-sm"
                        href="{{ asset('documento_privado/' . $lis->documento_privado) }}" target="_blank"><i
                            class="ri-file-pdf-line"></i></a>
                </td>
                <td>
                    <button class="btn btn-outline-warning btn-sm"
                        onclick="editar_financiamientoTipo('{{ $lis->id }}')"><i
                            class="ri-edit-2-fill"></i></button>
                </td>
            </tr>
        @endforeach
        <tr class="table-secondary">
            <td>Monto Total</td>
            <td></td>
            <td>{{ con_separador_comas($suma) . ' Bs' }}</td>
            <td>{{ con_separador_comas($monto).' Bs';}}</td>
        </tr>
    </tbody>
</table>
