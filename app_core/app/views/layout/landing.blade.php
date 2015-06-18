<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="owner" content="Icil-Icafal Proyecto Zona Sur S.A.">

    <!--[if lte IE 9]>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js'></script>
    <![endif]-->

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('img/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    @yield('meta')

    <title>
        @yield('title') - Icil Icafal PZS S.A.
    </title>

    {{ HTML::style('https://maxcdn.bootstrapcdn.com/bootswatch/3.3.4/yeti/bootstrap.min.css') }}
    {{ HTML::style('css/alertify.core.css') }}
    {{ HTML::style('css/alertify.default.css') }}
    {{ HTML::style('css/landing.min.css') }}

    {{-- yield para agregar css en cada página --}}
    @yield('css')
</head>
<body>

@include('layout.navbar')

{{-- Container
===================================================== --}}
<div class="container-fluid">
    <!--[if lte IE 9]>
    <p class="text-danger text-center">Sitio no optimizado para Internet Explorer.</p>
    <![endif]-->
    <p class="text-danger text-center" id="ie" style="display: none;">Hemos detectado que utilizas Internet
        Explorer.</p>
    <noscript>
        <p class="text-danger text-center">Para utilizar las funcionalidades completas de este sitio es necesario tener
            JavaScript habilitado. Aquí están las <a href="http://www.enable-javascript.com/es/" target="_blank">
                instrucciones para habilitar JavaScript en tu navegador web</a>.</p>
    </noscript>
    @if(isset($msg))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p><strong>{{ $msg }}</strong></p>
        </div>
    @endif
    @yield('content')
</div>

{{-- Archivos js --}}
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}
{{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js') }}
{{ HTML::script('js/alertify.min.js') }}
{{ HTML::script('js/back_to_top.js') }}

{{-- yield para agregar scripts en cada página --}}
@yield('js')

{{-- Modals --}}
@yield('modals')

{{-- Footer (si está logueado)
===================================================== --}}
@if(Sentry::check())
    <footer class="footer">
        <blockquote class="pull-right">
            <small>Copyright © 2014 Icil Icafal Proyecto Zona Sur S.A.</small>
        </blockquote>
    </footer>
@endif

</body>
</html>
