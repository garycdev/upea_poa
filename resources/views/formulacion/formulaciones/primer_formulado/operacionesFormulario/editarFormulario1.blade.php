<form id="form_primerFormularioEditar" method="post" autocomplete="off">
    <input type="hidden" name="id_formulario1" value="{{ $formulario1_editar->id }}">
    <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12 py-2">
        <fieldset>
            <legend>Ingrese nombre de la Maxima Autoridad (RECTOR)</legend>
                <input type="text" name="maxima_autoridad_" id="maxima_autoridad_" class="form-control" placeholder="Ingrese el nombre de la Maxima Autoridad de la Universidad Pública de el Alto" value="{{ $formulario1_editar->maxima_autoridad }}">
                <div id="_maxima_autoridad_"></div>
        </fieldset>
    </div>

    <div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <fieldset>
            <legend>Seleccione las Áreas estratégicas a usar</legend>
            <table class="table text-justify" >
                <tbody>
                    @forelse ($areas_estrategicas_editar as $key => $value)
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <input class="form-check-input" type="checkbox" id="{{ $value->id }}" name="areas_estrategicasEditar[]" value="{{ $value->id }}" {{ $formulario1_editar->relacion_areasEstrategicas->contains($value->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $value->id }}">
                                        {{ $value->descripcion }}
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @empty
                    --------
                    @endforelse
                </tbody>
            </table>
        </fieldset>

    </div>
</form>
