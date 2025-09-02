@extends('principal')
@section('titulo', 'Formulacion del poa')

@section('estilos')
    <link rel="stylesheet" href="{{ asset('rodry/estilo_error.css') }}">
@endsection
@section('contenido')

    <section id="not-found">
        <div class="circles">
            <p>{{ $tipo_error }}<br>
            <small>{{ $mensaje }}</small>
            </p>
            <span class="circle big"></span>
            <span class="circle med"></span>
            <span class="circle small"></span>
        </div>
    </section>

@endsection
