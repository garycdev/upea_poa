@extends('principal')
@section('titulo', 'Formulario FUT')
@section('contenido')
    <div class="page">
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h5 class="page-title my-auto">
                        {{ $configuracion->descripcion }}<br>
                        GESTION: {{ $configuracion->gestion }}<br>
                        @if ($carrera)
                            {{ $carrera->nombre_completo }}
                        @else
                            {{ Auth::user()->unidad_carrera->nombre_completo }}
                        @endif
                        <br>CODIGO: {{ $configuracion->codigo }}
                    </h5>
                </div>

                <div class="row">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="col-10 text-center fw-bold mt-3">
                                FORMULARIO DE INICIO/UNICO DE TRAMITE<br>
                                CONTRATACIóN DE BIENES Y/O SERVICIOS Y ACTIVOS FIJOS - FUT
                            </h5>
                            @if (Auth::user()->role[0]->id == 4)
                                <div class="col-2 form-group d-flex align-items-center justify-content-center">
                                    <a href="{{ route('formularioFut', [Crypt::encryptString($formulado->id), Crypt::encryptString($configuracion->gestiones_id), Crypt::encryptString($configuracion->id)]) }}"
                                        class="btn btn-outline-primary">
                                        Nuevo formulario de inicio/unico
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
                                            <th>Nro FUT</th>
                                            <th>Respaldo</th>
                                            <th>Fecha tramite</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($fut) > 0)
                                            @foreach ($fut as $item)
                                                <tr>
                                                    <td>{{ $item->nro }}</td>
                                                    <td>{{ $item->respaldo_tramite }}</td>
                                                    <td>{{ $item->fecha_tramite }}</td>
                                                    <td>{{ $item->importe }}&nbsp;bs.</td>
                                                    @php
                                                        $total1 = 0;
                                                        foreach ($item->total as $value) {
                                                            $total1 += $value->partida_monto;
                                                        }
                                                    @endphp
                                                    <td>
                                                        <span
                                                            class="badge fs-6 bg-{{ $total1 == $item->importe ? 'success' : 'warning' }}">
                                                            {{ $total1 == $item->importe ? 'Valido' : 'Pendiente' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if (Auth::user()->role[0]->id == 4)
                                                            <a href="{{ route('formularFut', $item->id_fut) }}"
                                                                class="btn btn-primary" style="display:inline-block">
                                                                <i class="ri-settings-fill"></i>
                                                            </a>
                                                        @endif
                                                        {{-- <a href="{{ route('pdffut', $item->id_fut) }}"
                                                            class="btn btn-warning" target="_blank"
                                                            style="display:inline-block">
                                                            <i class="ri-pencil-fill"></i>
                                                        </a> --}}
                                                        @if ($total1 == $item->importe)
                                                            <a href="{{ route('pdfFut', $item->id_fut) }}"
                                                                class="btn btn-danger" target="_blank"
                                                                style="display:inline-block">
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
                                @if (Auth::user()->role[0]->id == 4)
                                    <a href="{{ back() }}" class="btn btn-dark">Volver</a>
                                @else
                                    <a href="{{ route('getUnidades') }}" class="btn btn-dark">Volver</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
