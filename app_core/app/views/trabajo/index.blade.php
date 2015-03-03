@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de trabajos">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Mantención de Trabajos
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> Todos los Trabajos</div>
                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <a class="btn btn-primary" href="{{ URL::route('m.trabajo.create') }}"> Nuevo Trabajo </a>
                    </div>
                </div>
                @if( !$trabajos->isEmpty() )
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="col-md-1">Valor</th>
                            <th class="col-md-1">Unidad</th>
                            <th class="col-md-1">Form 2-3-4</th>
                            <th class="col-md-2">Mantenimiento</th>
                            <th class="col-md-1">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trabajos as $trabajo)
                            <tr>
                                <td>
                                    {{ $trabajo->nombre }}
                                </td>
                                <td>
                                    {{ $trabajo->valor }}
                                </td>
                                <td>
                                    {{ $trabajo->unidad }}
                                </td>
                                <td>
                                    @if ($trabajo->es_oficial == 1) Si
                                    @else No
                                    @endif
                                </td>
                                <td>
                                    {{ $trabajo->mantenimiento }}
                                </td>
                                <td class="text-center">
                                    <a title="Editar" href="{{ URL::to('/m/trabajo/'.$trabajo->id.'/edit') }}"><span
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
