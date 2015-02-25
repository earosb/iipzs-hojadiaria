{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 12-02-15
 * Time: 14:11
--}}

@extends('layout.landing')

@section('title')
    Mantención de Sectores
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> Todos los Sectores</div>
                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <a class="btn btn-info btn-new" href="{{ URL::route('m.sector.create') }}">Nuevo Sector</a>
                    </div>
                </div>
                @if( !$sectores->isEmpty() )
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estación inicio</th>
                            <th>Estación término</th>
                            <th>Km Inicio</th>
                            <th>Km Término</th>
                            <th class="col-md-1">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sectores as $sector)
                            <tr>
                                <td>
                                    {{ $sector->nombre }}
                                </td>
                                <td>
                                    {{ $sector->estacion_inicio }}
                                </td>
                                <td>
                                    {{ $sector->estacion_termino }}
                                </td>
                                <td>
                                    {{ $sector->km_inicio }}
                                </td>
                                <td>
                                    {{ $sector->km_termino }}
                                </td>
                                <td class="text-center">
                                    <a title="Ver detalles"
                                       href="{{ URL::to('/m/sector/'.$sector->id.'/blocks') }}"><span
                                                class="glyphicon glyphicon-list-alt"></span></a>
                                    <a title="Editar" href="{{ URL::to('/m/sector/'.$sector->id.'/edit') }}"><span
                                                class="glyphicon glyphicon-edit"></span></a>
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
