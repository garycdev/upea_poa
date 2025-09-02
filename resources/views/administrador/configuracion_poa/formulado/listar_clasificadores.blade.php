<fieldset>
    <legend>Clasificadores</legend>
    <table class="table text-justify" >
        <tbody>
            @forelse ($clasificadores as $key => $value)
                @if (!count($value->configuracion_formulado) > 0)
                    <tr>
                        <td>
                            <div class="checkbox">
                                <input class="form-check-input" type="checkbox" id="{{ $value->id }}" name="clasificadores[]" value="{{ $value->id }}" >
                                <label class="form-check-label" for="{{ $value->id }}">
                                    {{ $value->titulo }}
                                </label>
                            </div>
                        </td>
                    </tr>
                @endif
            @empty
            --------
            @endforelse
        </tbody>
    </table>
</fieldset>

{{-- @foreach ($clasificadores as $lis)
    @if (!count($lis->configuracion_formulado) > 0)
        {{ $lis->titulo }}
    @endif
@endforeach --}}
