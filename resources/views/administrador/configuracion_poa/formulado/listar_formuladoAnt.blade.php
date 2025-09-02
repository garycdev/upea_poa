
@if ($configuracion_formulado_lis->isEmpty())
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>Nota : </strong>Aun no existe Formulados
    </div>

@else
    <div class="table-responsive">
        <table class="table table-hover align-middle" style="width: 100%">
            <thead>
                <tr>
                    <th>ACCIÓN</th>
                    <th>CODIGO</th>
                    <th>FECHA INICIAL</th>
                    <th>FECHA FINAL</th>
                    <th>FORMULADO</th>
                    <th>PARTIDA</th>
                    <th>CLASIFICADOR</th>
                </tr>
            </thead>
            <tbody >

                    @foreach ($configuracion_formulado_lis as $lis)
                        <tr>
                            <td>
                                <a class="btn btn-outline-warning btn-sm" onclick="editar_formuladoPartida('{{ $lis->id }}')"><i class="ri-edit-2-fill"></i></a>
                            </td>
                            <td>{{ $lis->codigo }}</td>
                            <td>{{ fecha_literal($lis->fecha_inicial, 5) }}</td>
                            <td>{{ fecha_literal($lis->fecha_final, 5) }}</td>
                            <td>
                                <span class="badge rounded-pill text-bg-primary">{{ $lis->formulado_tipo->descripcion }}</span>
                            </td>
                            <td>
                                <span class="badge rounded-pill text-bg-success">{{ $lis->partida_tipo[0]->descripcion }}</span>
                            </td>
                            <td>
                                @foreach ($lis->clasificador_primero as $lis1)
                                    <ul>
                                        <li>{{ $lis1->titulo }}</li>
                                    </ul>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endif
