<form id="form_rol_edi"  method="post" autocomplete="off">
    <input type="hidden" name="id" value="{{ $id }}">
    <div class="row">
        <div class="mb-3">
            <label for="nombre_rol" class="form-label">Nombre del rol</label>
            <input type="text" class="form-control" id="nombre_rol" name="role" value="{{ $roles->name }}" placeholder="Ingrese un rol">
            <div id="_role" ></div>
        </div>
        <hr>
        <div class="mb-3 col-sm-12 col-md-12 col-lg-12">
            <div class="form-check">
                <input type="checkbox" id="marcar_des" class="form-check-input"  onclick="marcar_desmarcar_e(this);" />
                <label class="form-check-label" for="marcar_des">Marcar o Desmarcar</label>
            </div>
        </div>
        <hr>
        <div class="col-sm-12 col-md-12 col-lg-12" >
            <table class="table" >
                <tbody>
                    @forelse ($permiso as $id => $value)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $id }}" name="permisos_edi[]" value="{{ $id }}" {{ $roles->permissions->contains($id) ? 'checked' : '' }}  >
                                    <label class="form-check-label" for="{{ $id }}">
                                        {{ $value }}
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
