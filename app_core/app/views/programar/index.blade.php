<!DOCTYPE html>
<html lang="es" ng-app="app">
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

    <title> Programar trabajos - Icil Icafal PZS S.A. </title>

    @if(Config::get('app.debug'))
        {{ HTML::style('angular2/bower_components/bootswatch/yeti/bootstrap.min.css') }}
        {{ HTML::style('angular2/bower_components/jqueryui/themes/smoothness/jquery-ui.min.css') }}
        {{ HTML::style('angular2/bower_components/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}
    @else
        {{ HTML::style('https://maxcdn.bootstrapcdn.com/bootswatch/3.3.4/yeti/bootstrap.min.css') }}
        {{ HTML::style('https//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.min.css') }}
        {{ HTML::style('https://cdnjs.cloudflare.com/ajax/libs/awesome-bootstrap-checkbox/0.3.5/awesome-bootstrap-checkbox.min.css') }}
    @endif
    {{ HTML::style('css/landing.min.css') }}

</head>
<body>

@include('layout.navbar')

{{-- Container
===================================================== --}}
<div class="container-fluid">

    <!--añadimos aquí el controlador appController ya que será donde mostremos los usuarios-->
    <div class="row" ng-controller="appController">
        <!--aquí es donde cargarán todas las vistas dependiendo de la url-->
        <div ng-view></div>
    </div>

</div>

{{-- Archivos js --}}
@if(Config::get('app.debug'))
    {{ HTML::script('angular2/bower_components/angularjs/angular.min.js') }}
    {{ HTML::script('angular2/bower_components/angular-route/angular-route.min.js') }}
    {{ HTML::script('angular2/bower_components/jquery/dist/jquery.min.js') }}
    {{ HTML::script('angular2/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
    {{ HTML::script('angular2/bower_components/jqueryui/jquery-ui.min.js') }}
@else
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js') }}
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-route.min.js') }}
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js') }}
    {{ HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js') }}
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js') }}
@endif
{{ HTML::script('angular2/js/app.js') }}
{{ HTML::script('angular2/js/controllers.js') }}
{{ HTML::script('js/calendar/calendar.min.js') }}
{{ HTML::script('js/back_to_top.js') }}

<footer class="footer">
    <blockquote class="pull-right">
        <small>Copyright © 2014 Icil Icafal Proyecto Zona Sur S.A.</small>
    </blockquote>
</footer>

</body>
</html>
