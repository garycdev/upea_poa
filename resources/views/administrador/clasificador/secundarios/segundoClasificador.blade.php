<div class="container-fluid">
    <div class="card-box-style">
        <div class="others-title d-flex align-items-center">
            <h3>LISTADO DE SEGUNDO CLASIFICADOR</h3>
            <div class=" ms-auto position-relative">
                <button type="button" class="btn btn-outline-primary" onclick="segundo_clasificadorModal('{{ $codigo_ini }}')"> <i class="bx bxs-add-to-queue"></i>Nuevo segundo clasificador</button>
            </div>
        </div>
        <div class="table-responsive" >
            <table class="table table-hover" id="fortaleza_tabla" style="width: 100%" >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>CÓDIGO</th>
                        <th>TITULO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listarSegundoClasificador as $lis2)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lis2->codigo }}</td>
                            <td>{{ $lis2->titulo }}</td>
                            <td>{{ $lis2->descripcion }}</td>
                            <td width='150'>
                                <button class="btn btn-outline-warning btn-sm" onclick="editarSegundoClasificador('{{ $lis2->id }}', '{{ $codigo_ini }}')"><i class="ri-edit-2-fill"></i></button>
                                @can('clasificadorSegundo_eliminar')
                                    <button class="btn btn-outline-danger btn-sm" onclick="eliminarSegundoClasificador('{{ $lis2->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


