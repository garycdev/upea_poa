<div class="text-center" >
    <h5>LISTADO DE LOS PRIMEROS CLASIFICADORES</h5>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-hover" style="width: 100%">
        <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>TITULO</th>
                <th>DESCRIPCIÓN</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody id="listar_areas_estrategicas_html">
            @foreach ($clasificador_primero as $lis)
                <tr>
                    <td>{{ $lis->codigo }}</td>
                    <td>{{ $lis->titulo }}</td>
                    <td>{{ $lis->descripcion }}</td>
                    <td>
                        @if ($lis->estado =='activo')
                            <span class='badge text-bg-success'>{{ $lis->estado }}</span>
                        @else
                            <span class='badge text-bg-danger'>{{ $lis->estado }}</span>
                        @endif
                    </td>
                    <td width='250'>
                        <button class="btn btn-outline-warning btn-sm" onclick="editar_clasificadorPrimero('{{ $lis->id }}')" ><i class="ri-edit-2-fill"></i></button>
                        @can('clasificadorPrimero_eliminar')
                            <button class="btn btn-outline-danger btn-sm" onclick="eliminar_clasificadorPrimero('{{ $lis->id }}', '{{ $lis->id_clasificador_tipo }}')"><i class="ri-delete-bin-7-fill"></i></button>
                        @endcan
                        <a href="{{ route('adm_clasificador_segundo', ['id'=> encriptar($lis->id) ]) }}" class="btn btn-outline-secondary btn-sm"><i class="ri-settings-3-fill"></i></a>
                        <button class="btn btn-outline-primary btn-sm" onclick="estado_clasificadorPrimero('{{ $lis->id }}', '{{ $lis->id_clasificador_tipo }}')" >Estado</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
