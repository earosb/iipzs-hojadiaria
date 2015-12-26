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

    {{ HTML::style('angular2/bower_components/bootswatch/yeti/bootstrap.min.css') }}
    {{ HTML::style('angular2/bower_components/jqueryui/themes/smoothness/jquery-ui.min.css') }}
    {{ HTML::style('angular2/bower_components/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}
    {{ HTML::style('css/landing.min.css') }}

    <style>
        [ng-cloak].splash {
            display: block !important;
        }
        .splash {
            display: none;
        }
        .splash {
            /*background-color: #428bca;*/
        }
    </style>

</head>
<body>

@include('layout.navbar')

{{-- Container
===================================================== --}}
<div class="container-fluid">

    <!--añadimos aquí el controlador appController ya que será donde mostremos los usuarios-->
    <div class="row" ng-controller="appController">
        <!--aquí es donde cargarán todas las vistas dependiendo de la url-->
        <div ng-view>
            <div class="splash text-center" ng-cloak="">
                <svg width="138px" height="138px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-ring"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><circle cx="50" cy="50" r="30" stroke-dasharray="141.37166941154067 47.12388980384691" stroke="#ff9200" fill="none" stroke-width="30" transform="rotate(354 49.9999 49.9999)"><animateTransform attributeName="transform" type="rotate" values="0 50 50;180 50 50;360 50 50;" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite" begin="0s"></animateTransform></circle></svg>
            </div>
        </div>
    </div>

</div>

{{-- Archivos js --}}
{{ HTML::script('angular2/bower_components/jquery/dist/jquery.min.js') }}
{{ HTML::script('angular2/bower_components/jqueryui/jquery-ui.min.js') }}
{{ HTML::script('angular2/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
{{ HTML::script('angular2/bower_components/angularjs/angular.min.js') }}
{{ HTML::script('angular2/bower_components/angular-route/angular-route.min.js') }}

{{ HTML::script('angular2/js/app.js') }}
{{ HTML::script('angular2/js/controllers.js') }}
{{ HTML::script('js/calendar/calendar.min.js') }}
{{ HTML::script('js/back_to_top.js') }}

{{--<footer class="footer">--}}
{{--<blockquote class="pull-right">--}}
{{--<small>Copyright © 2014 Icil Icafal Proyecto Zona Sur S.A.</small>--}}
{{--</blockquote>--}}
{{--</footer>--}}

</body>
</html>
