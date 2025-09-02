<div class="container-fluid">
    <div class="card-box-style">
        <div class="others-title d-flex align-items-center">
            <h3>LISTADO DE QUINTO CLASIFICADOR</h3>
            <div class=" ms-auto position-relative">
                <button type="button" class="btn btn-outline-primary" onclick="nuevoModalquintoClasificador()"> <i class="bx bxs-add-to-queue"></i> Nuevo  Quinto Clasificador</button>
            </div>
        </div>
        <div id="table-responsive" >
            <table class="table table-striped table-hover table-sm table-responsive" id="amenaza_tabla" style="width: 100%" >
                <thead >
                    <tr>
                        <th>#</th>
                        <th>CÓDIGO</th>
                        <th>TITULO</th>
                        <th>TERCER CLASIFICADOR &emsp;&emsp;&emsp;&emsp;&emsp; CUARTO CLASIFICADOR &emsp;&emsp;&emsp;&emsp;&emsp;  QUINTO CLASIFICADOR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listar_QuintoClasificador as $lis5)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lis5->codigo }}</td>
                            <td>{{ $lis5->titulo }}</td>
                            <td>
                                <table class="table table-hover" style="width: 100%">
                                    {{-- <thead>
                                        <tr>
                                            <th>CÓDIGO</th>
                                            <th>TITULO</th>
                                            <th>CUARTO CLASIFICADOR</th>
                                        </tr>
                                    </thead> --}}
                                    <tbody>
                                        @foreach ($lis5->clasificador_tercero as $lis)
                                            <tr>
                                                <td>{{ $lis->codigo }}</td>
                                                <td>{{ $lis->titulo }}</td>
                                                <td>
                                                    <table class="table table-hover" style="width: 100%">
                                                        <tbody>
                                                            @foreach ($lis->clasificador_cuarto as $lis1)
                                                                <tr>
                                                                    <td>{{ $lis1->codigo }}</td>
                                                                    <td>{{ $lis1->titulo }}</td>
                                                                    <td>
                                                                        <table class="table table-hover" style="width: 100%">
                                                                            <tbody>
                                                                                @foreach ($lis1->clasificador_quinto as $lis2)
                                                                                    <tr>
                                                                                        <td>{{ $lis2->codigo }}</td>
                                                                                        <td>{{ $lis2->titulo }}</td>
                                                                                        <td>{{ $lis2->descripcion }}</td>
                                                                                        <td width="150">
                                                                                            <button class="btn btn-outline-warning btn-sm" onclick="editar_quintoClasificador('{{ $lis2->id }}', '{{ $lis5->id }}', '{{ $lis->id }}', '{{ $lis1->id }}')" ><i class="ri-edit-2-fill"></i></button>
                                                                                            @can('clasificadorQuinto_eliminar')
                                                                                                <button class="btn btn-outline-danger btn-sm" onclick="eliminar_quintoClasificador('{{ $lis2->id }}')"><i class="ri-delete-bin-7-fill"></i></button>
                                                                                            @endcan
                                                                                            <button class="btn btn-outline-primary btn-sm" onclick="detalles_quintoClasificadorModal('{{ $lis2->id }}')"><i class="ri-settings-3-fill"></i></button>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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
