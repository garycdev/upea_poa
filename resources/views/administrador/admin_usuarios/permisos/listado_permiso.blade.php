@extends('principal')
@section('titulo', 'Permisos')
@section('contenido')
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h3>PERMISOS </h3>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <ul class="page-title-list">
                        <li>Administración de usuarios</li>
                        <li>Permisos</li>
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
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nuevo_permiso" > <i class="bx bxs-add-to-queue" ></i> Nuevo Permiso</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-sm " style="width:100%" id="tabla_permiso">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal nuevo-->
    <div class="modal zoom" id="nuevo_permiso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Nuevo Permiso</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciar_permiso()" ></button>
                </div>
                <div class="modal-body">
                    <form id="form_permiso"  method="post" autocomplete="off">
                        <div class="row">
                            <div class="mb-3">
                                <label for="nombre_permiso" class="form-label">Nombre del Permiso</label>
                                <input type="text" class="form-control" id="nombre_permiso" name="permiso" placeholder="Ingrese un permiso">
                                <div id="_permiso" ></div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciar_permiso()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_permiso"> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar Permiso</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar -->
    <div class="modal slide" id="editar_permiso" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Editar Permiso</h3>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="vaciar_permiso()"></button>
                </div>
                <div class="modal-body">
                    <form id="form_permiso_edi"  method="post" autocomplete="off">
                        <input type="hidden" id="id_permiso" name="id_permiso">
                        <div class="row">
                            <div class="mb-3">
                                <label for="permiso_edi" class="form-label">Nombre del Permiso</label>
                                <input type="text" class="form-control" id="permiso_edi" name="permiso_e" placeholder="Ingrese un permiso">
                                <div id="_permiso_e" ></div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" onclick="vaciar_permiso()">Cerrar</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_guardar_permiso_edi"> <i class="bx bxs-save" id="icono_rodry" ></i> Guardar Permiso</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>

        let modal_nuevo_permiso = new bootstrap.Modal(document.getElementById('nuevo_permiso'), {
            keyboard: false
        });

        let modal_editar_permiso = new bootstrap.Modal(document.getElementById('editar_permiso'), {
            keyboard: false
        });

        //PARA VACIAR CAMPOS
        let _permiso = document.getElementById('_permiso');
        let _permiso_e = document.getElementById('_permiso_e');
        function vaciar_permiso(){
            limpiar_campos('form_permiso');
            _permiso.innerHTML='';
            limpiar_campos('form_permiso_edi');
            _permiso_e.innerHTML='';
        }


        //para guardar nuevo permiso
        document.getElementById('btn_guardar_permiso').addEventListener('click', async (e)=>{
            e.preventDefault();
            let datos = Object.fromEntries(new FormData(document.getElementById('form_permiso')).entries());
            _permiso.innerHTML='';
            try {
                let respuesta = await fetch("{{ route('adm_crear_permiso') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos),
                });

                let data = await respuesta.json();
                if(data){
                    if(data.tipo=='errores'){
                        let objeto = data.mensaje;
                        for (const key in objeto) {
                            document.getElementById('_'+key).innerHTML = '<p style="color:red" >'+objeto[key]+'</p>';
                        }
                    }
                    if(data.tipo=='success'){
                        alerta_top(data.tipo, data.mensaje);
                        $('#tabla_permiso').DataTable().destroy();
                        listar_permiso();
                        modal_nuevo_permiso.hide();
                        vaciar_permiso();
                    }
                    if(data.tipo=='error'){ alerta_top(data.tipo, data.mensaje) }
                }else{
                    console.log('ocurio un error');
                }
            } catch (error) {
                console.log(error);
            }
        });

        //para listar
        function listar_permiso(){
            fetch("{{ route('adm_listar_permiso') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
            })
            .then(response => response.json())
            .then(data =>{
                let i = 1;
                $('#tabla_permiso').DataTable({
                    'data':data.datos,
                    'columns':[
                        {'render':function(){
                            return a = i++;
                        }},
                        {'data':'name'},
                        {'render':function(data, type, row, meta){
                            let a = `
                                <button class="btn btn-outline-warning btn-sm" onclick="editar_permiso('${row.id}')"><i class="ri-edit-2-fill"></i></button>
                                <button class="btn btn-outline-danger btn-sm" onclick="eliminar_permiso('${row.id}')"><i class="ri-delete-bin-7-fill" ></i></button>
                            `;
                            return a;
                        }}
                    ],
                });
            })

        }
        listar_permiso();

        //eliminar el permiso
        function eliminar_permiso(id){
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
                    fetch("{{ route('adm_eliminar_permiso') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({id:id}),
                    })
                    .then(response => response.json())
                    .then(data=>{
                        if(data.tipo=='success'){
                            alerta_top(data.tipo, data.mensaje);
                            $('#tabla_permiso').DataTable().destroy();
                            listar_permiso();
                        }
                        if(data.tipo=='error'){
                            alerta_top(data.tipo, data.mensaje);
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    alerta_top('error', 'Se cancelo');
                }
            })
        }
        //editar permiso
        async function editar_permiso(id){
            //modal_editar_permiso.show();
            try {
                let respuesta = await fetch("{{ route('adm_editar_permiso') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({id:id}),
                });

                let data = await respuesta.json();
                if(data.tipo=='success'){
                    modal_editar_permiso.show();
                    document.getElementById('id_permiso').value = data.mensaje.id;
                    document.getElementById('permiso_edi').value = data.mensaje.name;
                }
                if(data.tipo=='error'){alerta_top('error', data.mensaje);}
            } catch (error) {
                console.log(error);
            }
        }

        //para guardar lo editado
        document.getElementById('btn_guardar_permiso_edi').addEventListener('click', async (e)=>{
            try {
                e.preventDefault();
                _permiso_e.innerHTML='';
                let datos = Object.fromEntries(new FormData(document.getElementById('form_permiso_edi')).entries());
                let respuesta = await fetch("{{ route('adm_guardar_edi_permiso') }}", {
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(datos),
                });
                let data = await respuesta.json();
                if(data.tipo==='success'){
                    alerta_top(data.tipo, data.mensaje);
                    $('#tabla_permiso').DataTable().destroy();
                    listar_permiso();
                    modal_editar_permiso.hide();
                }
                if(data.tipo==='errores'){
                    let objeto = data.mensaje;
                    for (const key in objeto) {
                        document.getElementById('_'+key).innerHTML = '<p style="color:red" >'+objeto[key]+'</p>';
                    }
                }
                if(data.tipo==='error'){ alerta_top(data.tipo, data.mensaje) }
            } catch (error) {
                console.log(error);
            }
        });
    </script>
@endsection
