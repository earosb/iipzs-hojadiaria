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
            <h1> Error 404 <span class="glyphicon glyphicon-fire"></span></h1>

            <div class="well">
                <p>Ups...! La página solicitada no existe.</p>
            </div>
        </div>
    </div>

@stop