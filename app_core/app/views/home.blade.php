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
                    <p>08/04/2015</p>
                    <ul>
                        <li>Corregido error que muestra materiales de reempleo como nuevos en hoja diaria.</li>
                        <li class="text-success">Edición parcial de hoja diaria.</li>
                        <li>Botón flotante para volver al inicio de cualquier página.</li>
                    </ul>
                    <p>06/04/2015</p>
                    <ul>
                        <li>Formulario 2 para mantenimiento menor.</li>
                    </ul>
                    <p>02/04/2015</p>
                    <ul>
                        <li>Filtro por mes y grupo en histórico hoja diaria.</li>
                        <li>Paginador histórico hoja diaria.</li>
                    </ul>
                    <small>Eduardo. <cite title="Source Title"><a href="mailto:earosb@icafal.cl?Subject=[i-i PZS]"
                                                                  target="_top">¿Dudas?</a></cite></small>
                </blockquote>
            </section>
        </div>
    </div>
@stop