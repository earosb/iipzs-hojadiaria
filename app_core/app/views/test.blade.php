@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de pruebas">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Test
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Página de pruebas</h2>
        </div>
        @if(isset($test))
            <div class="well">
                {{ $test }}
            </div>
        @endif
    </div>
@stop