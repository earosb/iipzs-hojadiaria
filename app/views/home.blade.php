@extends('layout.landing')

@section('title')
    Icil-icafal - Hello
@stop

@section('alert')
    <div class="alert alert-dismissable alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <p>Bienvenido, has ingresado correctamente.</p>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Bienvenido</h2>

            <p>Bienvenido al sistema de gestión bla bla bla de <strong>Icil Icafal Proyecto Zona Sur S.A.</strong>.
            </p>

            <p>Usted podrá ver... descripción de la aplicación.</p>
        </div>
    </div>
@stop