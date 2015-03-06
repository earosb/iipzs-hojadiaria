<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="owner" content="Icil-Icafal Proyecto Zona Sur S.A.">

    {{--<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>--}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/icon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/icon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/icon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/icon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/icon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/icon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/icon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/icon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/icon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/icon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/icon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/icon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/icon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    @yield('meta')

    <title>
        @yield('title') - Icil Icafal PZS S.A.
    </title>

    {{ HTML::style('//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/yeti/bootstrap.min.css') }}
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
    @if(isset($msg))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p><strong>{{ $msg }}</strong></p>
        </div>
    @endif
    @yield('content')
</div>
{{-- Footer
===================================================== --}}
<div class="footer">
    @yield('footer')
</div>
{{-- Archivos js --}}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}
{{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js') }}
{{ HTML::script('js/alertify.min.js') }}

<script type="text/javascript">
    $(document).ready(function () {
        $('.dropdown').hover(function () {
            $('.dropdown-toggle', this).trigger('click');
        });
    });
</script>

{{-- yield para agregar scripts en cada página --}}
@yield('js')

{{-- Modals --}}
@yield('modals')

@if(Sentry::check())
    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright © 2014 Icil Icafal Proyecto Zona Sur S.A. Todos los Derechos Reservados.</p>
            {{--Contacto <a href="mailto:webmaster@icilicafalpzs.cl" target="_top">webmaster@icilicafalpzs.cl</a>--}}
        </div>
    </footer>
@endif

</body>
</html>