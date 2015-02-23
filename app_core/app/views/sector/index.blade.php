{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 12-02-15
 * Time: 14:11
--}}

@extends('layout.landing')

@section('title')
    Mantención Vías
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <legend>Mantención Vías</legend>

            {{--<div class="btn-group pull-right"><a href="#" class="btn btn-primary">Nuevo Sector</a></div>--}}

            <div class="pull-right">
                <a class="btn btn-info btn-new" href="{{ URL::route('m.sector.create') }}">Nuevo Sector</a>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estación inicio</th>
                    <th>Estación término</th>
                    <th>Km Inicio</th>
                    <th>Km Término</th>
                    <th>Opciones</th>
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
                            <a class="glyphicon glyphicon-list-alt"
                               href="{{ URL::to('/m/sector/'.$sector->id.'/blocks') }}"></a>
                            <a class="glyphicon glyphicon-pencil"
                               href="{{ URL::to('/m/sector/'.$sector->id.'/edit') }}"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
