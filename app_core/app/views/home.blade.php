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
                    @if (Sentry::getUser()->hasAccess(['reporte']))
                        <p>17/04/2015</p>
                        <p><strong>Versión candidata</strong></p>
                        <ul>
                            <li class="text-success">Corregido error al sumar materiales en reportes detallado y resumido.</li>
                            @if (Sentry::getUser()->hasAccess(['reporte-avanzado']))
                                <li class="text-success">Corregido error al sumar materiales en formularios 2, 3 y 4.</li>
                            @endif
                        </ul>
                    @endif

                    @if (Sentry::getUser()->hasAccess(['hoja-diaria']))
                        <p>13/04/2015</p>
                        <ul>
                            <li>Despliega materiales requeridos por cada trabajo seleccionado en formulario hoja
                                diaria (requiere configuración en mantención de trabajos).
                            </li>
                            <li>Trabajos se muestran por orden alfabético en formulario hoja diaria.</li>
                            @if (Sentry::getUser()->hasAccess(['mantencion']))
                                <li>Interfaz de mantenimiento de trabajos con lista de materiales existentes.</li>
                            @endif
                        </ul>
                    @endif

                    @if (Sentry::getUser()->hasAccess(['hoja-diaria']))
                        <p>10/04/2015</p>
                        <ul>
                            <li class="text-success">Copia el km de inicio y suma 100 en km de término al ingresar un km
                                de inicio en trabajos hd.
                            </li>
                        </ul>
                    @endif

                    <p>08/04/2015</p>
                    <ul>
                        @if (Sentry::getUser()->hasAccess(['hoja-diaria']))
                            <li>Corregido error que muestra materiales de reempleo como nuevos en hoja diaria.</li>
                            <li class="text-success">Edición parcial de hoja diaria.</li>
                        @endif
                        <li>Botón flotante para volver al inicio de cualquier página.</li>
                    </ul>
                    @if (Sentry::getUser()->hasAccess(['form2-3-4']))
                        <p>06/04/2015</p>
                        <ul>
                            <li>Formulario 2 para mantenimiento menor.</li>
                        </ul>
                    @endif
                    @if (Sentry::getUser()->hasAccess(['hoja-diaria']))
                        <p>02/04/2015</p>
                        <ul>
                            <li>Filtro por mes y grupo en histórico hoja diaria.</li>
                            <li>Paginador histórico hoja diaria.</li>
                        </ul>
                    @endif
                    <p>30/03/2015</p>
                    <ul>
                        <li>Advertencia de incompatibilidad si el usuario utiliza Internet Explorer.</li>
                    </ul>
                    <small>Eduardo. <cite title="Source Title"><a href="mailto:earosb@icafal.cl?Subject=[i-i PZS]"
                                                                  target="_top">¿Dudas?</a></cite></small>
                </blockquote>
            </section>
        </div>
    </div>
@stop