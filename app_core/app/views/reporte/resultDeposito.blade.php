@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de reporte resumido de trabajos realizados">
    <meta name="author" content="earosb">
@stop

@section('title')
    Reporte centros de acopio
@stop

@section('css')
    {{ HTML::style('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css') }}
    {{ HTML::style('css/reporte.css') }}
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('/') }}">Inicio</a></li>
        <li><a href="{{ URL::to('/r/deposito') }}">Consultas</a></li>
        <li class="active">Reporte centros de acopio</li>
        <div class="pull-right">
            <a class="glyphicon glyphicon-print" title="Imprimir" href="javascript:window.print()"> Imprimir</a>
        </div>
    </ul>
    <div class="col-xs-12 col-md-12">
        <table class="table">
            <legend>Parámetros de búsqueda</legend>
            <thead>
            <tr>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Sector</th>
                <th>Block</th>
                <th>Grupo</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ Request::get('fecha_desde') }}</td>
                <td>{{ Request::get('fecha_hasta') }}</td>
                @if( isset($sector) )
                    <td>{{ $sector->nombre }}</td>
                @else
                    <td>Todos</td>
                @endif
                @if( isset($block) )
                    <td>{{ $block->estacion_inicio }} - {{ $block->estacion_termino }}</td>
                @else
                    <td>Todos</td>
                @endif
                @if( isset($grupo) )
                    <td>{{ $grupo->base }}</td>
                @else
                    <td>Todos</td>
                @endif
            </tr>
            </tbody>
        </table>
    </div>
    @if( isset($depositos) )
        @foreach($depositos as $deposito)
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $deposito->nombre }}</div>
                    @if(!$deposito->colocados->isEmpty())
                        <div class="panel-body">
                            <p>Materiales colocados</p>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Material</th>
                                <th>Cantidad</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deposito->colocados as $material)
                                <tr>
                                    <td>{{ $material->material }}</td>
                                    <td>{{ $material->cantidad }}</td>
                                    <td>{{ $material->grupo }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if(!$deposito->retirados->isEmpty())
                        <div class="panel-body">
                            <p>Materiales retirados</p>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Material</th>
                                <th>Cantidad</th>
                                <th>Grupo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deposito->retirados as $material)
                                <tr>
                                    <td>{{ $material->material }}</td>
                                    <td>{{ $material->cantidad }}</td>
                                    <td>{{ $material->grupo }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
    <div class="col-md-12">
        @if( isset($colocados) )
            <div class="col-xs-12 col-md-6">
                <legend><h3> Materiales Colocados </h3></legend>
                <table class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Centro de acopio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colocados as $colocado)
                        <tr>
                            <td>
                                {{ $colocado->material }}
                            </td>
                            <td>
                                {{ $colocado->cantidad }}
                            </td>
                            <td>
                                {{ $colocado->deposito }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if( isset($retirados) )
            <div class="col-xs-12 col-md-6">
                <legend><h3> Materiales Retirados </h3></legend>
                <table class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Centro de acopio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($retirados as $retirado)
                        <tr>
                            <td>
                                {{ $retirado->material }}
                            </td>
                            <td>
                                {{ $retirado->cantidad }}
                            </td>
                            <td>
                                {{ $retirado->deposito }}
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
@endsection