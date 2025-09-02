<div class="container-fluid">
    <div class="card-box-style">
        <div class="others-title d-flex align-items-center">
            <h3>LISTADO DE TERCER CLASIFICADOR</h3>
            <div class=" ms-auto position-relative">
                <button type="button" class="btn btn-outline-primary" onclick="modalTercerClasificador()"> <i class="bx bxs-add-to-queue"></i> Nuevo Tercer Clasificador</button>
            </div>
        </div>
        <div id="table-responsive" >
            <table class="table table-hover table-striped" style="width: 100%" >
                <thead >
                    <tr >
                        <th>#</th>
                        <th>CÓDIGO</th>
                        <th>TITULO</th>
                        <th class="text-center" >TERCER CLASIFICADOR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listarTercerClasificador as $lis3)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lis3->codigo }}</td>
                            <td>{{ $lis3->titulo }}</td>
                            <td>
                                <table class="table table-hover" style="width: 100%">
                                    <thead style="font-size: 10px">
                                        <tr>
                                            <th>CÓDIGO</th>
                                            <th>TITULO</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lis3->clasificador_tercero as $lis)
                                            <tr>
                                                <td>{{ $lis->codigo }}</td>
                                                <td>{{ $lis->titulo }}</td>
                                                <td>{{ $lis->descripcion }}</td>
                                                <td width="150">
                                                    <button class="btn btn-outline-warning btn-sm" onclick="editar_tercerClasificador('{{ $lis->id }}')" ><i class="ri-edit-2-fill"></i></button>
                                                    @can('clasificadorTercero_eliminar')
                                                        <button class="btn btn-outline-danger btn-sm" onclick="eliminar_tercerClasificador('{{ $lis->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                                    @endcan
                                                    <button class="btn btn-outline-primary btn-sm" onclick="detalles_tercerClasificadorModal('{{ $lis->id }}')"><i class="ri-settings-3-fill"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
