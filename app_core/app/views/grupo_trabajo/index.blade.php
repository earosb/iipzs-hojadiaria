@extends('layout.landing')

@section('title')
    Grupos de Trabajo
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"> Todos </div>
                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <a class="btn btn-info btn-new" href="{{ URL::route('m.grupo-trabajo.create') }}">Nuevo Grupo</a>
                    </div>
                </div>
                @if( !$grupos->isEmpty() )
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Base</th>
                            <th class="col-md-1">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($grupos as $grupo)
                            <tr>
                                <td>
                                    {{ $grupo->base }}
                                </td>
                                <td class="text-center">
                                    <a title="Editar" href="{{ URL::to('/m/grupo-trabajo/'.$grupo->id.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a>
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
