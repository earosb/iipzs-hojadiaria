@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de bienvenida">
    <meta name="author" content="earosb">
@stop

@section('title')
    Bienvenido
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Bienvenido a Icil Icafal Proyecto Zona Sur S.A.</h2>
            <section>
                <blockquote>
                    <p>Historial de cambios:</p>
                    <ul>
                        <li class="text-success">Edición parcial de hoja diaria.</li>
                        <li>Botón flotante para volver al inicio de cualquier página</li>
                        <li>Formulario 2 para mantenimiento menor</li>
                        <li>Paginador y filtros por mes y grupo en histórico hoja diaria</li>
                    </ul>
                </blockquote>
            </section>
        </div>
    </div>
@stop