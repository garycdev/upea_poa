<div class="text-center" >
    <div class="alert alert-primary" role="alert">
      <h4 class="alert-heading">Gestión: {{ $gestiones_lis->gestion }} </h4>
    </div>
</div>
<div class="ag-courses_box">
    @foreach ($tipoCarreraUnidadArea as $lis)
        <div class="ag-courses_item">

            <a href="{{ route('adm_asignar_financiamiento', ['id1'=>encriptar($lis->id), 'id2'=>encriptar($gestiones_lis->id)]) }}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title" id="img_carreras">
                {{ $lis->nombre }}
                </div>
            </a>
        </div>
    @endforeach
</div>
