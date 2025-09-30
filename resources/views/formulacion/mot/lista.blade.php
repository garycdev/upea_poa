@extends('principal')
@section('titulo', 'Formulario MOT')
@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h5 class="page-title my-auto">
                        {{ $configuracion->descripcion }}<br>
                        GESTION: {{ $configuracion->gestion }}<br>
                        {{ $carrera->nombre_completo }}
                        <br>CODIGO: {{ $configuracion->codigo }}
                    </h5>
                </div>

                <div class="row">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="col-10 text-center fw-bold mt-3">
                                MODIFICACIONES PRESUPUESTARIAS (MOT)
                            </h5>
                            @if (Auth::user()->id_unidad_carrera == $carrera->id)
                                <div class="col-2 form-group d-flex align-items-center justify-content-center">
                                    <a href="{{ route('mot.formulario', [Crypt::encryptString($formulado->id), Crypt::encryptString($configuracion->gestiones_id), Crypt::encryptString($configuracion->id)]) }}"
                                        class="btn btn-outline-primary">
                                        Nuevo formulario de modificaciones
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div>
                                @if (session('message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('message') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                            </div>
                            <div>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nro MOT</th>
                                            <th>Areas estrategicas</th>
                                            <th>Organismo financiador</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Observaciones</th>
                                            <th>Ejecución</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($mot) > 0)
                                            @foreach ($mot as $item)
                                                <tr>
                                                    <td>{{ formatear_con_ceros($item->nro) }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($item->areas_estrategicas_de() as $ae)
                                                                <li>{{ $ae->descripcion }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($item->motpp as $fuente)
                                                                <li>{{ $fuente->of->descripcion }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>{{ con_separador_comas($item->importe) }}&nbsp;bs.</td>
                                                    {{-- @php
                                                        $total1 = 0;
                                                        foreach ($item->total as $value) {
                                                            $total1 += $value->partida_monto;
                                                        }
                                                    @endphp --}}
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $item->estado == 'ejecutado' ? 'success' : ($item->estado == 'rechazado' ? 'danger' : ($item->estado == 'aprobado' ? 'primary' : 'warning')) }}">
                                                            {{ $item->estado }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $item->observacion }}
                                                    </td>
                                                    <td>
                                                        @can('Validar_seguimiento')
                                                            @if ($item->estado == 'elaborado')
                                                                <button type="button" class="btn btn-primary btn-validar"
                                                                    data-id="{{ $item->id_mot }}">
                                                                    Validar
                                                                </button>
                                                            @endif
                                                        @endcan
                                                        @if ($item->estado == 'aprobado' && Auth::user()->id_unidad_carrera == $item->id_unidad_carrera)
                                                            <button type="button"
                                                                class="btn btn-success btn-modal-ejecutar"
                                                                data-id="{{ $item->id_mot }}">
                                                                Ejecutar compra
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('mot.detalle', $item->id_mot) }}"
                                                            class="btn btn-outline-primary" style="display:inline-block">
                                                            <i class="ri-eye-fill"></i>
                                                        </a>
                                                        {{-- @if (Auth::user()->id_unidad_carrera == $item->id_unidad_carrera) --}}
                                                        <a href="{{ route('mot.pdf', $item->id_mot) }}"
                                                            class="btn btn-outline-warning" target="_blank">
                                                            <i class="ri-file-pdf-line"></i>
                                                        </a>
                                                        {{-- @endif --}}
                                                        {{-- <a href="{{ route('pdfMot', $item->id_mot) }}"
                                                            class="btn btn-warning" target="_blank"
                                                            style="display:inline-block">
                                                            <i class="ri-pencil-fill"></i>
                                                        </a> --}}
                                                        @if ($item->estado == 'ejecutado' || $item->estado == 'aprobado')
                                                            <a href="{{ route('pdfMot', $item->id_mot) }}"
                                                                class="btn btn-outline-danger" target="_blank">
                                                                <i class="ri-file-pdf-line"></i>
                                                            </a>
                                                        @endif
                                                        {{-- <button class="btn btn-success">
                                                            <i class="ri-file-excel-line"></i>&nbsp;EXCEL
                                                        </button> --}}
                                                    </td>
                                                    {{-- <td>
                                                        <button class="btn btn-sm btn-outline-warning"><i
                                                                class="ri-pencil-line"></i>&nbsp;&nbsp;Editar</button>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" align="center">
                                                    Ningun formulario
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 d-flex justify-content-center">
                                @cannot('Validar_seguimiento')
                                    <a href="{{ route('mot.inicio') }}" class="btn btn-dark">Volver</a>
                                @endcannot
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // function abriModal(id) {
        //     $.get("{{ route('mot.modal', ':id') }}".replace(':id', id), function(html) {
        //         $("#modalValidar .modal-body").html(html);
        //     });
        // }
    </script>
@endsection
