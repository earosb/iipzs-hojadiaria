<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="owner" content="Icil-Icafal Proyecto Zona Sur S.A.">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
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

{{-- yield para agregar scripts en cada página --}}
@yield('js')

{{-- Modals --}}
@yield('modals')

@if(Sentry::check())
    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright © 2014 Icil Icafal Proyecto Zona Sur S.A. Todos los Derechos Reservados.
                Contacto <a href="mailto:webmaster@icilicafalpzs.cl" target="_top">webmaster@icilicafalpzs.cl</a>
        </div>
    </footer>
@endif

</body>
</html>