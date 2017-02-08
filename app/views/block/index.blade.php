@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de blocks">
    <meta name="author" content="earosb">
@stop


@section('title')
    Mantención de Blocks
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Mantención de Blocks, <strong> {{ $sector->nombre }} </strong>
                </div>
                <div class="panel-body">
                    <a class="btn btn-primary pull-right" href="{{ URL::route('m.block.create') }}">Nuevo Block</a>
                </div>
                @if( !$blocks->isEmpty() )
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre/Estación</th>
                            <th>Nro. Bien</th>
                            <th>Km Inicio</th>
                            <th>Km Término</th>
                            <th class="col-md-1">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($blocks as $block)
                            <tr>
                                <td>
                                    {{ $block->estacion }}
                                </td>
                                <td>
                                    {{ $block->nro_bien }}
                                </td>
                                <td>
                                    {{ $block->km_inicio }}
                                </td>
                                <td>
                                    {{ $block->km_termino }}
                                </td>
                                <td class="text-center">
                                    <a class="glyphicon glyphicon-list-alt" title="Ver detalles"
                                       href="{{ URL::to('/m/block/'.$block->id) }}"></a>
                                    <a class="glyphicon glyphicon-edit" title="Editar"
                                       href="{{ URL::to('/m/block/'.$block->id.'/edit') }}"></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h4>No existen registros</h4>
                @endif
            </div>
        </div>
    </div>
@stop
