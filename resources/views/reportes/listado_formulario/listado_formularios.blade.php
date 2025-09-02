<div class="mb-3 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
    <fieldset>
        <legend>Sacar reporte de Formularios</legend>

        <div class="container_rodry">
            @if ($formulario1=='existe')
                <form action="{{ route('pdf_form1') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="id_carreraunidad" value="{{ $id_carreraunidad }}">
                    <input type="hidden" name="id_configuracion" value="{{ $id_configuracion }}">
                    <input type="hidden" name="id_gestion" value="{{ $id_gestion_especifica }}">
                    <button type="submit" class="card2" href="#">
                        <h3 id="titulo_h3">FORM. Nº 1</h3>
                        <div class="go-corner-pdf" href="#">
                            <div class="go-arrow"><i class="ri-file-pdf-fill"></i></i></div>
                        </div>
                    </button>
                </form>

            @endif

            @if ($formulario2=='existe')
                <form action="{{ route('pdf_form2') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="id_carreraunidad" value="{{ $id_carreraunidad }}">
                    <input type="hidden" name="id_configuracion" value="{{ $id_configuracion }}">
                    <input type="hidden" name="id_gestion" value="{{ $id_gestion_especifica }}">
                    <button type="submit" class="card2" href="#">
                        <h3 id="titulo_h3">FORM. Nº 2</h3>
                        <div class="go-corner-pdf" href="#">
                            <div class="go-arrow"><i class="ri-file-pdf-fill"></i></i></div>
                        </div>
                    </button>
                </form>
            @endif

            @if ($formulario3=='existe')
                <form action="{{ route('pdf_form3') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="id_carreraunidad" value="{{ $id_carreraunidad }}">
                    <input type="hidden" name="id_configuracion" value="{{ $id_configuracion }}">
                    <input type="hidden" name="id_gestion" value="{{ $id_gestion_especifica }}">
                    <button type="submit" class="card2" href="#">
                        <h3 id="titulo_h3">FORM. Nº 3</h3>
                        <div class="go-corner-pdf" href="#">
                            <div class="go-arrow"><i class="ri-file-pdf-fill"></i></i></div>
                        </div>
                    </button>
                </form>
            @endif

            @if ($formulario4=='existe')
                <form action="{{ route('pdf_form4') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="id_carreraunidad" value="{{ $id_carreraunidad }}">
                    <input type="hidden" name="id_configuracion" value="{{ $id_configuracion }}">
                    <input type="hidden" name="id_gestion" value="{{ $id_gestion_especifica }}">
                    <button type="submit" class="card2" href="#">
                        <h3 id="titulo_h3">FORM. Nº 4</h3>
                        <div class="go-corner-pdf" href="#">
                            <div class="go-arrow"><i class="ri-file-pdf-fill"></i></i></div>
                        </div>
                    </button>
                </form>
            @endif

            @if ($formulario5=='existe')
                <form action="{{ route('pdf_form5') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="id_carreraunidad" value="{{ $id_carreraunidad }}">
                    <input type="hidden" name="id_configuracion" value="{{ $id_configuracion }}">
                    <input type="hidden" name="id_gestion" value="{{ $id_gestion_especifica }}">
                    <button type="submit" class="card2" href="#">
                        <h3 id="titulo_h3">FORM. Nº 5</h3>
                        <div class="go-corner-pdf" href="#">
                            <div class="go-arrow"><i class="ri-file-pdf-fill"></i></i></div>
                        </div>
                    </button>
                </form>

                <form action="{{ route('pdf_form6') }}" method="post" target="_blank">
                    @csrf
                    <input type="hidden" name="id_carreraunidad" value="{{ $id_carreraunidad }}">
                    <input type="hidden" name="id_configuracion" value="{{ $id_configuracion }}">
                    <input type="hidden" name="id_gestion" value="{{ $id_gestion_especifica }}">
                    <button type="submit" class="card2" href="#">
                        <h3 id="titulo_h3">FORM. Nº 6</h3>
                        <div class="go-corner-pdf" href="#">
                            <div class="go-arrow"><i class="ri-file-pdf-fill"></i></i></div>
                        </div>
                    </button>
                </form>
            @endif
        </div>
    </fieldset>
</div>
