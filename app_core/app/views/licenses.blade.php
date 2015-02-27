@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de error">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Error!
@stop

@section('content')

    <div class="row">
        <div class="col-md-offset-2 col-md-6">
            <h1> {{ $code }}<span class="glyphicon glyphicon-fire"></span></h1>

            <div class="well">
                {{ $message }}
            </div>
        </div>
    </div>

@stop