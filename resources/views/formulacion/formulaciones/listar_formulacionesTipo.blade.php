<div class="ag-courses_box">
    @foreach ($configuracion_poa as $lis)
        <div class="ag-courses_item">
            <a href="{{ route('poa_formulacionPOA', ['formuladoConf_id'=> encriptar($lis->id), 'gestiones_id'=> encriptar($gestiones->id)]) }}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title text-center">
                {{ $lis->formulado_tipo->descripcion }}
                <p>Fecha Inicio : {{ fecha_literal($lis->fecha_inicial, 4) }} </p>
                <p>Fecha Final :  {{ fecha_literal($lis->fecha_final, 4) }}</p>
                </div>
            </a>
        </div>
    @endforeach
</div>
