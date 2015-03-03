@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de reporte detallado de trabajos realizados">
    <meta name="author" content="earosb">
@stop

@section('title')
    Reporte Detallado
@stop
@section('css')
    {{ HTML::style('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css') }}
    {{ HTML::style('css/reporte.min.css') }}
@endsection
@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('/') }}">Inicio</a></li>
        <li><a href="{{ URL::to('/r/param') }}">Consultas</a></li>
        <li class="active">Reporte Detallado</li>
        <div class="pull-right">
            <a class="glyphicon glyphicon-print" title="Imprimir" href="javascript:window.print()"> Imprimir</a>
        </div>
    </ul>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p><strong>Parámetros de búsqueda:</strong></p>

                    <p>Entre los kilómetros {{ Request::get('km_inicio') }} y {{ Request::get('km_termino') }}</p>

                    <p>Desde el {{ Request::get('fecha_desde') }} Hasta el {{ Request::get('fecha_hasta') }}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-12">
            <legend><h3> Trabajos Realizados </h3></legend>
            <table class="table table-bordered table-striped display">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Block</th>
                    <th>Km Inicio</th>
                    <th>Km Término</th>
                    <th>Trabajo</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    @if(Sentry::getUser()->hasAccess(['reporte-avanzado']))
                        <th>Grupo Vía</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($trabajos as $trabajo)
                    <tr>
                        <td>
                            {{ Carbon\Carbon::parse($trabajo->fecha)->format('d/m/Y') }}
                        </td>
                        <td>
                            {{ $trabajo->estacion }}
                        </td>
                        <td>
                            {{ $trabajo->km_inicio }}
                        </td>
                        <td>
                            {{ $trabajo->km_termino }}
                        </td>
                        <td>
                            {{ $trabajo->nombre }}
                        </td>
                        <td>
                            {{ $trabajo->cantidad }}
                        </td>
                        <td>
                            {{ $trabajo->unidad }}
                        </td>
                        @if(Sentry::getUser()->hasAccess(['reporte-avanzado']))
                            <td>
                                {{ $trabajo->base }}
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if( isset($materiales) )
            <div class="col-xs-12 col-md-12">
                <legend><h3> Materiales Colocados </h3></legend>
                <table class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Clase</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($materiales['nuevo'] as $material)
                        <tr>
                            <td>
                                {{ $material->nombre }}
                            </td>
                            <td>
                                {{ $material->cantidad }}
                            </td>
                            <td>
                                {{ $material->unidad }}
                            </td>
                            <td>
                                Nuevo
                            </td>
                        </tr>
                    @endforeach

                    @foreach($materiales['reempleo'] as $material)
                        <tr>
                            <td>
                                {{ $material->nombre }}
                            </td>
                            <td>
                                {{ $material->cantidad }}
                            </td>
                            <td>
                                {{ $material->unidad }}
                            </td>
                            <td>
                                Reempleo
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if( isset($materialesRetirados) )
            <div class="col-xs-12 col-md-12">
                <legend><h3>Materiales Retirados</h3></legend>
                <table class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Clase</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($materialesRetirados['excluido'] as $material)
                        <tr>
                            <td>
                                {{ $material->nombre }}
                            </td>
                            <td>
                                Excluido
                            </td>
                            <td>
                                {{ $material->cantidad }}
                            </td>
                        </tr>
                    @endforeach
                    @foreach($materialesRetirados['reempleo'] as $material)
                        <tr>
                            <td>
                                {{ $material->nombre }}
                            </td>
                            <td>
                                Reempleo
                            </td>
                            <td>
                                {{ $material->cantidad }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
@stop


@section('js')
    {{ HTML::script('//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js') }}
    {{ HTML::script('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js') }}
    <script>
        $(document).ready(function () {
            $('table.display').DataTable({
                paging: false,
                ordering: true,
                info: false,
                stateSave: false,
                filter: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection