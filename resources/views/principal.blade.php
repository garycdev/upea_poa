<!doctype html>
<html lang="es">

<head>
    @include('plantilla_admin.estilos')
    @yield('estilos')
</head>

<body class="body-bg-f8faff">
    <!-- Start Preloader Area -->
    {{-- <div class="preloader">
            <img src="{{ asset('logos/upea_logo.png') }}" alt="Logo" width="70">
        </div> --}}
    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start All Section Area -->
    <div class="all-section-area">
        <!-- Header -->
        @include('plantilla_admin.header')
        <!-- Header -->
        <!-- Menu -->
        @include('plantilla_admin.menu')
        <!-- Menu -->
        <!-- Contenido -->
        <main class="main-content-wrap style-two">

            @yield('contenido')

            <div class="flex-grow-1"></div>
            @include('plantilla_admin.footer')
        </main>
    </div>



    <!-- Start Go Top Area -->
    <div class="go-top">
        <i class="ri-arrow-up-s-fill"></i>
        <i class="ri-arrow-up-s-fill"></i>
    </div>
    <!-- End Go Top Area -->

    @include('plantilla_admin.scripts')
    @yield('scripts')
</body>

</html>
