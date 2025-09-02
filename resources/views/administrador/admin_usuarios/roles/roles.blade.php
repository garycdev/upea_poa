@extends('principal')
@section('titulo', 'Roles')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h3>ROLES </h3>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administración de usuarios</li>
                        <li>Roles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="default-table-area">
        <div class="container-fluid">
            <div class="card-box-style">
                <h3></h3>
                <div class="others-title d-flex align-items-center">
                    <div class=" ms-auto position-relative">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_rol" > <i class="bx bxs-add-to-queue" ></i> Nuevo Rol</button>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @if ($roles->count() > 0)
                        @foreach ($roles as $lis)
                            <div class="col-lg-3 col-sm-6">
                                <div class="single-pricing-style-three active">
                                    <ul class="py-2">
                                        @foreach ($lis->permissions as $i)
                                            <li>
                                                <i class="ri-check-double-line"></i>
                                                <p style="font-size: 12px" >{{ $i->name }}</p>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <span class="best-price">{{ $lis->name }}</span>
                                    <hr>
                                    {{-- <button class="btn btn-outline-danger" onclick="eliminar_rol('{{ $lis->id }}')" > <i class="ri-delete-bin-7-fill" ></i> Eliminar</button> --}}
                                    <button class="btn btn-outline-primary" onclick="editar_rol('{{ $lis->id }}')"> <i class="ri-edit-2-fill"></i> Editar</button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal nuevo-->
    <div class="modal zoom" id="nuevo_rol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Nuevo Rol</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciar_campo_rol()" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_rol"  method="post" autocomplete="off">
                        <div class="row">
                            <div class="mb-3">
                                <label for="nombre_rol" class="form-label">Nombre del rol</label>
                                <input type="text" class="form-control" id="nombre_rol" name="rol" placeholder="Ingrese un rol">
                                <div id="_rol" ></div>
                            </div>
                            <hr>
                            <div class="mb-3 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-check">
                                    <input type="checkbox" id="marcar_des" class="form-check-input"  onclick="marcar_desmarcar(this);" />
                                    <label class="form-check-label" for="marcar_des">Marcar o Desmarcar</label>
                                </div>
                            </div>
                            <hr>
                            <div class="col-sm-12 col-md-12 col-lg-12" >
                                <table class="table" >
                                    <tbody>
                                        @forelse ($permisos as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <input class="form-check-input" type="checkbox" id="{{ $value->id }}" name="permisos[]" value="{{ $value->id }}" >
                                                        <label class="form-check-label" for="{{ $value->id }}">
                                                            {{ $value->name }}
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                        --------
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciar_campo_rol()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_rol"> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar Rol</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal nuevo-->
    <div class="modal zoom" id="editar_rol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Editar Rol</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  ></button>
                </div>
                <div class="modal-body" id="view_editar_rol">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_edit_rol"> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar Rol</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>


        let _rol = document.getElementById('_rol');

        //para guardar
        document.getElementById('btn_guardar_rol').addEventListener('click', (e)=>{
            e.preventDefault();
            let datos = new FormData(document.getElementById('form_rol'));
            _rol.innerHTML = '';
            $.ajax({
                type: "POST",
                url: "{{ route('adm_guardar_rol') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo=='errores'){
                        let obj = data.mensaje
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = '<p style="color:red" >'+obj[key]+'</p>';
                        }
                    }
                    if(data.tipo=='success'){
                        $('#nuevo_rol').modal('hide');
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location='';
                        }, 1600);
                    }
                }
            });
        });

        //eliminar Rol
        function eliminar_rol(id){
            const swalWithBootstrapButtons =  Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                    title: 'NOTA!',
                    text: "Esta seguro de eliminar el registro?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Eliminar!',
                    cancelButtonText: 'No, Cancelar!',
                    reverseButtons: false
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('adm_eliminar_rol') }}",
                        data: {id:id},
                        dataType: "JSON",
                        success: function (data) {
                            if(data.tipo==='success'){
                                alerta_top(data.tipo, data.mensaje);
                                setTimeout(() => {
                                    window.location='';
                                }, 1600);
                            }
                            if(data.tipo==='error'){
                                alerta_top(data.tipo, data.mensaje);
                            }
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    alerta_top('error', 'Se cancelo');
                }
            })
        }


        //editar rol
        function editar_rol(id){
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editar_rol') }}",
                data: {id:id},
                success: function (data) {
                    $('#editar_rol').modal('show');
                    document.getElementById('view_editar_rol').innerHTML = data;
                }
            });
        }

        //para guardar lo editado
        $(document).on('click','#btn_guardar_edit_rol', (e)=>{
            e.preventDefault();
            $('_role').html('');
            let datos = new FormData(document.getElementById('form_rol_edi'));
            $.ajax({
                type: "POST",
                url: "{{ route('adm_editar_guardar_rol') }}",
                data: datos,
                dataType: "JSON",
                cache:false,
                processData:false,
                contentType:false,
                success: function (data) {
                    if(data.tipo==='errores'){
                        let obj = data.mensaje;
                        for (let key in obj) {
                            document.getElementById('_'+key).innerHTML = '<p style="color:red" >'+obj[key]+'</p>'
                        }
                    }
                    if(data.tipo==='success'){
                        $('#editar_rol').modal('hide');
                        alerta_top(data.tipo, data.mensaje);
                        setTimeout(() => {
                            window.location='';
                        }, 1600);
                    }
                }
            });
        });

        //para vaciar campos
        function vaciar_campo_rol(){
            limpiar_campos('form_rol');
            $('_rol').html('');
        }
        function vaciar_campo_rol_edi(){
            $('_role').html('');
        }
    </script>
@endsection
