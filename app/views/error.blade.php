@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de error">
    <meta name="author" content="earosb">
@stop

@section('title')
    Error!
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 col-md-offset-2 col-md-6">
            <h1> {{ $code }}
                <a class="text-danger pull-right"><span class="glyphicon glyphicon-fire"></span></a>
            </h1>

            <div class="well">
                <p>{{ $message }}</p>

                <p>Para solicitar ayuda escriba a: <a href="mailto:webmaster@icilicafalpzs.cl"
                                                      target="_top">webmaster@icilicafalpzs.cl</a></p>
            </div>
            <code>
                {{ $exception }}
            </code>
        </div>
    </div>

@stop