<nav class="side-menu-area style-two">
    <nav class="sidebar-nav" data-simplebar>
        <ul id="sidebar-menu" class="sidebar-menu">
            {{-- <li class="mm-active">
                <a href="#" class="has-arrow box-style d-flex align-items-center">
                    <div class="icon">
                        <img src="{{ asset('plantilla_admin/images/icon/element.svg') }}" alt="element">
                    </div>
                    <span class="menu-title">Inicio</span>
                </a>
                <ul class="sidemenu-nav-second-level">
                    <li>
                        <a href="website-analytics.html">
                            <span class="menu-title">Website Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="hr-management.html">
                            <span class="menu-title">HR Management</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="lms-academy.html">
                            <span class="menu-title">LMS Academy</span>
                        </a>
                    </li>
                </ul>
            </li> --}}

            @can('Menu_inicio')
                <li class="@if ($menu == '1') {{ 'mm-active' }} @endif">
                    <a href="{{ route('inicio') }}" class="box-style d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/element.svg') }}" alt="inicio">
                        </div>
                        <span class="menu-title">INICIO</span>
                    </a>
                </li>
            @endcan

            @can('Menu_admin_usuario')
                <li class="@if ($menu == '2' || $menu == '3' || $menu == '4') {{ 'mm-active' }} @endif">
                    <a href="#" class="has-arrow box-style d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/user-octagon.svg') }}" alt="usuario">
                        </div>
                        <span class="menu-title">ADM. USER</span>
                    </a>

                    <ul class="sidemenu-nav-second-level">
                        @can('usuarios')
                            <li class=" @if ($menu == '2') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_usuario') }}">
                                    <span class="menu-title">Usuarios</span>
                                </a>
                            </li>
                        @endcan
                        @can('roles')
                            <li class=" @if ($menu == '3') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_rol') }}">
                                    <span class="menu-title">Roles</span>
                                </a>
                            </li>
                        @endcan
                        @can('permisos')
                            <li class=" @if ($menu == '4') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_permiso') }}">
                                    <span class="menu-title">Permisos</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            <!--CONFIGURACIÓN-->
            @can('Menu_configuracion')
                <li class="@if ($menu == '6' || $menu == '7' || $menu == '8' || $menu == '9' || $menu == '10') {{ 'mm-active' }} @endif">
                    <a href="#" class="has-arrow box-style d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/setting.svg') }}" alt="usuario">
                        </div>
                        <span class="menu-title">CONFIGURACIÓN</span>
                    </a>

                    <ul class="sidemenu-nav-second-level">
                        @can('cua')
                            <li class="@if ($menu == '10') {{ 'active' }} @endif">
                                <a href="{{ route('adm_cua_admin') }}">
                                    <span class="menu-title">Carreras <br> Unidades Administrativas <br> Areas</span>
                                </a>
                            </li>
                        @endcan
                        @can('fuenteDeFinanciamiento')
                            <li class=" @if ($menu == '6') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_fuenteFinanciamiento') }}">
                                    <span class="menu-title">Fuente de <br> Financiamiento</span>
                                </a>
                            </li>
                        @endcan
                        @can('tipoFormulado')
                            <li class=" @if ($menu == '7') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_formulado') }}">
                                    <span class="menu-title">Tipo de Formulado</span>
                                </a>
                            </li>
                        @endcan
                        @can('tipoPartida')
                            <li class=" @if ($menu == '8') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_partida') }}">
                                    <span class="menu-title">Tipo de Partida</span>
                                </a>
                            </li>
                        @endcan
                        @can('clasificadorTipo')
                            <li class=" @if ($menu == '9') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_clasificador') }}">
                                    <span class="menu-title">Clasificadores <br> Presupuestarios</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('Menu_gestion')
                <li class="@if ($menu == '5') {{ 'mm-active' }} @endif">
                    <a href="{{ route('adm_gestion') }}" class="box-style d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/folder-2.svg') }}" alt="inicio">
                        </div>
                        <span class="menu-title">GESTIÓN</span>
                    </a>
                </li>
            @endcan

            @can('Menu_configuracion_poa')
                {{-- CONFIGURACIÓN DEL POA --}}
                <li class="@if ($menu == '11' || $menu == '12') {{ 'mm-active' }} @endif">
                    <a href="#" class="has-arrow box-style d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/importent.svg') }}" alt="usuario">
                        </div>
                        <span class="menu-title">CONFIGURACIÓN <br> DEL POA</span>
                    </a>

                    <ul class="sidemenu-nav-second-level">
                        @can('asignar_financiamiento')
                            <li class=" @if ($menu == '11') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_asignarFinanciamiento') }}">
                                    {{-- <span class="menu-title">Asignar <br> Financiamiento</span> --}}
                                    <span class="menu-title">Techos <br> Presupuestarios</span>
                                </a>
                            </li>
                        @endcan
                        @can('asignar_formulado')
                            <li class=" @if ($menu == '12') {{ 'active' }} @endif ">
                                <a href="{{ route('adm_formuladoHabiliado') }}">
                                    <span class="menu-title"> Habilitar <br> Reformulado </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- Solo mostrar si tiene unidad asignada --}}
            @if (isset(Auth::user()->id_unidad_carrera))
                @can('Menu_formulacion_del_Poa')
                    {{-- CONFIGURACIÓN DEL POA --}}
                    <li class="@if ($menu == '13') {{ 'mm-active' }} @endif">
                        <a href="#" class="has-arrow box-style d-flex align-items-center">
                            <div class="icon">
                                <img src="{{ asset('plantilla_admin/images/icon/layer.svg') }}" alt="usuario">
                            </div>
                            <span class="menu-title">FORMULACIÓN <br> DEL POA</span>
                        </a>

                        <ul class="sidemenu-nav-second-level">
                            @can('formulacion_poa')
                                <li class=" @if ($menu == '13') {{ 'active' }} @endif ">
                                    <a href="{{ route('poa_formulacion') }}">
                                        <span class="menu-title">Formulación <br> del Plan <br> Operativo Anual</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            @endif
            @can('Menu_formulario_modificacion')
                <li class="@if ($menu == '19' || $menu == '20') {{ 'mm-active' }} @endif">
                    <a href="#" class="has-arrow box-style d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/draft.svg') }}" alt="usuario">
                        </div>
                        <span class="menu-title">PRESUPUESTOS Y<br>MODIFICACIONES<br>PRESUPUESTARIAS</span>
                    </a>

                    <ul class="sidemenu-nav-second-level">
                        @can('formulacion_poa')
                            <li class=" @if ($menu == '19') {{ 'active' }} @endif ">
                                <a href="{{ route('fut_inicio') }}">
                                    <span class="menu-title">Formulario unico<br>de tramite (FUT)</span>
                                </a>
                            </li>
                        @endcan
                    </ul>

                    <ul class="sidemenu-nav-second-level">
                        @can('formulacion_poa')
                            <li class=" @if ($menu == '23') {{ 'active' }} @endif ">
                                <a href="{{ route('mot_inicio') }}">
                                    <span class="menu-title">Restricción modificaciones</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                    <ul class="sidemenu-nav-second-level">
                        @can('formulacion_poa')
                            <li class=" @if ($menu == '20') {{ 'active' }} @endif ">
                                <a href="{{ route('mot_inicio') }}">
                                    <span class="menu-title">Modificaciones<br>presupuestarias (MOT)</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- Solo mostrar si tiene unidad asignada --}}
            @if (isset(Auth::user()->id_unidad_carrera))
                @can('Menu_seguimiento')
                    <li class="@if ($menu == '21' || $menu == '22') {{ 'mm-active' }} @endif">
                        <a href="#" class="has-arrow box-style d-flex align-items-center">
                            <div class="icon">
                                <img src="{{ asset('plantilla_admin/images/icon/eye.svg') }}" alt="usuario">
                            </div>
                            <span class="menu-title">SEGUIMIENTO<br>DEL POA</span>
                        </a>

                        <ul class="sidemenu-nav-second-level">
                            @can('formulacion_poa')
                                <li class=" @if ($menu == '21') {{ 'active' }} @endif ">
                                    <a href="{{ route('fut.inicio') }}">
                                        <span class="menu-title">Formulario unico<br>de tramite (FUT)</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>

                        <ul class="sidemenu-nav-second-level">
                            @can('formulacion_poa')
                                <li class=" @if ($menu == '22') {{ 'active' }} @endif ">
                                    <a href="{{ route('mot.inicio') }}">
                                        <span class="menu-title">Modificaciones<br>presupuestarias (MOT)</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            @endif

            {{-- REPORTES PDF --}}
            @can('reportes_pdf')
                <li class="@if ($menu == '15' || $menu == '16' || $menu == '17' || $menu == '18') {{ 'mm-active' }} @endif">
                    <a href="#" class="has-arrow box-style d-flex align-items-center">
                        <div class="icon">
                            <img src="{{ asset('plantilla_admin/images/icon/book.svg') }}" alt="usuario">
                        </div>
                        <span class="menu-title">REPORTES</span>
                    </a>

                    <ul class="sidemenu-nav-second-level">
                        <li class="@if ($menu == '15') {{ 'active' }} @endif">
                            <a href="{{ route('pdf_pei') }} ">
                                <span class="menu-title">Plan <br> Estratégico<br> Institucional (PEI)</span>
                            </a>
                        </li>
                    </ul>

                    <ul class="sidemenu-nav-second-level">
                        <li class="@if ($menu == '16') {{ 'active' }} @endif">
                            <a href="{{ route('pdf_poa') }}">
                                <span class="menu-title">Formulación<br>del Plan<br> Operativo<br> Anual (POA)</span>
                            </a>
                        </li>
                    </ul>

                    {{-- <ul class="sidemenu-nav-second-level">
                        <li class="@if ($menu == '17') {{ 'active' }} @endif">
                            <a href="{{ route('pdf_poa') }}">
                                <span class="menu-title">Modificaciones<br>presupuestarias (MOT)</span>
                            </a>
                        </li>
                    </ul>

                    <ul class="sidemenu-nav-second-level">
                        <li class="@if ($menu == '18') {{ 'active' }} @endif">
                            <a href="{{ route('pdf_poa') }}">
                                <span class="menu-title">Formulario unico<br>de tramite (FUT)</span>
                            </a>
                        </li>
                    </ul> --}}
                </li>
            @endcan
        </ul>
    </nav>
</nav>
