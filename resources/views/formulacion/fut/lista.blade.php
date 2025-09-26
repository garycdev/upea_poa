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
                        {{ $carrera->nombre_completo }}
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
                            @if (Auth::user()->id_unidad_carrera == $carrera->id)
                                <div class="col-2 form-group d-flex align-items-center justify-content-center">
                                    <a href="{{ route('fut.formulario', [Crypt::encryptString($formulado->id), Crypt::encryptString($configuracion->gestiones_id), Crypt::encryptString($configuracion->id)]) }}"
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
                                            <th>Areas estrategicas</th>
                                            <th>Organismo financiador</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($fut) > 0)
                                            @foreach ($fut as $item)
                                                <tr>
                                                    <td>{{ formatear_con_ceros($item->nro) }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($item->areas_estrategicas() as $ae)
                                                                <li>{{ $ae->descripcion }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($item->futpp as $fuente)
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
                                                        <a href="{{ route('fut.detalle', $item->id_fut) }}"
                                                            class="btn btn-outline-primary" style="display:inline-block">
                                                            <i class="ri-eye-fill"></i>
                                                        </a>
                                                        {{-- @if (Auth::user()->id_unidad_carrera == $item->id_unidad_carrera) --}}
                                                        <a href="{{ route('fut.pdf', $item->id_fut) }}"
                                                            class="btn btn-outline-warning" target="_blank"
                                                            style="display:inline-block">
                                                            <i class="ri-file-pdf-line"></i>
                                                        </a>
                                                        {{-- @endif --}}
                                                        {{-- <a href="{{ route('pdffut', $item->id_fut) }}"
                                                            class="btn btn-warning" target="_blank"
                                                            style="display:inline-block">
                                                            <i class="ri-pencil-fill"></i>
                                                        </a> --}}
                                                        @if ($item->estado == 'ejecutado')
                                                            <a href="{{ route('pdfFut', $item->id_fut) }}"
                                                                class="btn btn-outline-danger" target="_blank"
                                                                style="display:inline-block">
                                                                <i class="ri-file-pdf-line"></i>
                                                            </a>
                                                        @endif
                                                        @can('Validar_seguimiento')
                                                            @if ($item->estado != 'ejecutado' && $item->estado != 'rechazado')
                                                                <button type="button"
                                                                    class="ms-2 mt-2 btn btn-outline-primary d-inline"
                                                                    id="btn-validar" data-id="{{ $item->id_fut }}"
                                                                    data-bs-toggle="modal" data-bs-target="#modalValidar">
                                                                    Validar
                                                                </button>
                                                            @endif
                                                        @endcan
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
                                <a href="{{ route('fut.inicio') }}" class="btn btn-dark">Volver</a>
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
        $(document).ready(function() {
            $(document).on('click', '.btn-submit', function(e) {
                e.preventDefault()
                let estado = $(this).data('estado')

                $('#estado').val(estado)

                if (validarErrores()) {
                    Swal.fire({
                        title: "¿Esta seguro de validar el formulario?",
                        text: "Esta accion no se puede deshacer",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, validar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#formValidar').submit()

                            // Swal.fire({
                            //     title: "Enviado",
                            //     text: "El formulario a sido validado con exito",
                            //     icon: "success"
                            // });

                            // location.reload()
                        }
                    });
                }
            })
        })

        function validarErrores() {
            resetErrores()

            let respaldo_tramite = $('#respaldo_tramite').val()
            let fecha_actual = $('#fecha_actual').val()
            let hora_actual = $('#hora_actual').val()

            if (respaldo_tramite != '' && fecha_actual != '' && hora_actual != '') {
                return true
            } else {
                if (respaldo_tramite == '') {
                    $('#_respaldo_tramite').html('El respaldo del tramite es requerido')
                }
                if (fecha_actual == '') {
                    $('#_fecha_actual').html('La fecha del tramite es requerido')
                }
                if (hora_actual == '') {
                    $('#_hora_actual').html('La hora del tramite es requerido')
                }

                return false
            }
        }

        function resetErrores() {
            $('#_respaldo_tramite').html('')
            $('#_fecha_actual').html('')
            $('#_hora_actual').html('')
        }

        function abriModal(id) {
            $.get("{{ route('fut.modal', ':id') }}".replace(':id', id), function(html) {
                $("#modalValidar .modal-body").html(html);
            });
        }
    </script>
@endsection
