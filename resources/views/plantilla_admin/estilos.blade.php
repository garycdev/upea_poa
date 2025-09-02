<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Link Of CSS -->
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/remixicon.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/boxicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/iconsax.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/metismenu.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/simplebar.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/calendar.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/jbox.all.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/editor.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/loaders.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/sidebar-menu.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/footer.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('plantilla_admin/css/responsive.css') }}">

<link rel="stylesheet" href="{{ asset('plantilla_admin/toastr/toastr.min.css') }}">


<link rel="stylesheet" type="text/css" href="{{ asset('plantilla_admin/data_tables/datatables.min.css') }}"/>


<!-- Styles -->
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/> --}}

<link rel="stylesheet" href="{{ asset('plantilla_admin/rodry/select2/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('plantilla_admin/rodry/select2/css/select2-bootstrap-5-theme.min.css') }}"/>



<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('logos/upea_logo.png') }}">
<!-- Title -->
<title>Admin | @yield('titulo') </title>
<link rel="stylesheet" href="{{ asset('loader/css.css') }}">

<link rel="stylesheet" href="{{ asset('plantilla_admin/css/editor.css') }}">

<style>
    .swal2-actions button + button {
        margin-left: 10px; /* Ajustar el espacio entre los botones */
    }

    .active.link-secondary{
        font-weight: bold;
        color:#fff;
    }
    .nav-item button:active{
        background-color: rgba(137, 245, 245, 0.486);
    }

    #error_in{
        color:red;
        font-size:13px;
    }

    .form-check-input{
        font-size: 20px;
    }

    #alerta_nota{
        background-color: rgba(207, 24, 0, 0.87);
        border-radius: 10px;
    }
    #alerta_nota > p{
        color: #fff;
        font-weight: bold;
    }

    /*Para el fieldset*/
    fieldset {
        border: 2px solid #2178e8;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 30px;
    }

    fieldset legend {
        background: #2178e8;
        color: #fff;
        font-size: 18px;
        padding: 2px 5px ;
        border-radius: 10px;
        box-shadow: 0 0 0 5px #fff;
        margin-top: -35px;
    }

    .linea_arriba{
        border-top: #2178e8 solid;
        padding-top: 10px;
    }
    #verticalText {
        writing-mode: vertical-lr;
        transform: rotate(180deg);
    }

    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px;
    }

    .dataTables_wrapper .dt-buttons .btn {
        margin-right: 5px;
        min-width: 120px; /* Ajusta el ancho del botón según tu preferencia */
    }
    /* Estilos personalizados para el botón de exportación de PDF */
    .dataTables_wrapper .dt-buttons .buttons-pdf {
        background-color: #a1010f;
        color: #fff;
        border-color: #c40000;
        width: 25%;
    }

    .dataTables_wrapper .dt-buttons .buttons-pdf:hover {
    background-color: #db0000;
    border-color: #da0000;
    }

</style>
