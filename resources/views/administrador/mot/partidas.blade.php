@extends('principal')
@section('titulo', 'Partidas modificación')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h5>PARTIDAS HABILITADAS PARA MODIFICACIÓN</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Mot</li>
                        <li>Partidas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <div class="my-5">
                    <form action="{{ route('mot.partidas.inhabilitar') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="grupo" id="grupo">
                        <div class="row w-75 m-auto">
                            <div class="col-9">
                                <select name="id_partida" id="id_partida" class="col-10 select2_partida"
                                    onchange="seleccionPartida(this)">
                                    <option value="selected" selected disabled>[SELECCIONE LA PARTIDA]</option>
                                    @foreach ($partidasHabilitadas3 as $partida)
                                        <option value="{{ $partida->id }}" data-grupo="3">
                                            {{ $partida->codigo }} - {{ $partida->titulo }}
                                        </option>
                                    @endforeach
                                    @foreach ($partidasHabilitadas4 as $partida)
                                        <option value="{{ $partida->id }}" data-grupo="4">
                                            {{ $partida->codigo }} - {{ $partida->titulo }}
                                        </option>
                                    @endforeach
                                    @foreach ($partidasHabilitadas5 as $partida)
                                        <option value="{{ $partida->id }}" data-grupo="5">
                                            {{ $partida->codigo }} - {{ $partida->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="col-3 btn btn-outline-primary btn-sm" id="btn-agregar-partida"
                                disabled title="Inhabilitar partida para modificaciones">
                                <i class="bx bxs-save" id="icono_rodry"></i>
                                Agregar restriccion
                            </button>
                        </div>
                    </form>
                </div>

                <ul class="nav nav-tabs nav-fill mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link link-secondary active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">PARTIDAS INHABILITADAS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link link-secondary" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab"
                            aria-controls="profile-tab-pane" aria-selected="false">PARTIDAS GRUPO 10000</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle dataTable" style="width: 100%">
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
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($partidas3 as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->titulo }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-partidas-eliminar"
                                                        data-id="{{ $item->id }}" data-grupo="3" title="Habilitar partida para modificaciones">
                                                        <i class="ri ri-toggle-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                        @foreach ($partidas4 as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->titulo }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-partidas-eliminar"
                                                        data-id="{{ $item->id }}" data-grupo="4" title="Habilitar partida para modificaciones">
                                                        <i class="ri ri-toggle-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                        @foreach ($partidas5 as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->titulo }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-partidas-eliminar"
                                                        data-id="{{ $item->id }}" data-grupo="5" title="Habilitar partida para modificaciones">
                                                        <i class="ri ri-toggle-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                        tabindex="0">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle dataTable" style="width: 100%">
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
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($partidas31 as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->titulo }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-partidas-eliminar"
                                                        data-id="{{ $item->id }}" data-grupo="3" title="Habilitar partida para modificaciones">
                                                        <i class="ri ri-toggle-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                        @foreach ($partidas41 as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->titulo }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-partidas-eliminar"
                                                        data-id="{{ $item->id }}" data-grupo="4" title="Habilitar partida para modificaciones">
                                                        <i class="ri ri-toggle-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                        @foreach ($partidas51 as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->codigo }}</td>
                                                <td>{{ $item->titulo }}</td>
                                                <td>{{ $item->descripcion }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-partidas-eliminar"
                                                        data-id="{{ $item->id }}" data-grupo="5" title="Habilitar partida para modificaciones">
                                                        <i class="ri ri-toggle-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
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
            $(document).on('click', '.btn-partidas-eliminar', function() {
                let id = $(this).data('id')
                let grupo = $(this).data('grupo')

                Swal.fire({
                    title: "¿Esta seguro de eliminar la restriccion?",
                    text: "Se habilitara la partida para modificaciones",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, habilitar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('mot.partidas.habilitar') }}",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'PUT',
                                id: id,
                                grupo: grupo
                            },
                            success: function(response) {
                                location.reload()
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        })
                    }
                });
            })
        });

        function seleccionPartida(select) {
            let grupo = $(select).find('option:selected').data('grupo')
            $('#grupo').val(grupo)
            $('#btn-agregar-partida').removeAttr('disabled')
        }
    </script>
@endsection
