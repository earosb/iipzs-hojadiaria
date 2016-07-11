@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de materiales colocaros y retirados">
    <meta name="author" content="earosb">
@stop

@section('title')
    Materiales
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"> Materiales Colocados</div>
                <div class="panel-body">
                    <a class="btn btn-primary pull-right" href="{{ URL::route('m.material.create') }}"> Nuevo </a>
                </div>
                @if( ! $materiales->isEmpty() )
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="col-md-1">Unidad</th>
                            <th class="col-md-2">Form 3</th>
                            <th class="col-md-2">Pos. en form 3</th>
                            <th class="col-md-1">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($materiales as $material)
                            <tr>
                                <td>{{ $material->nombre }}</td>
                                <td>{{ $material->unidad }}</td>
                                <td>
                                    @if($material->es_oficial) Si
                                    @else No
                                    @endif
                                </td>
                                <td>
                                    @if($material->orden)
                                        {{ $material->orden }}
                                    @else
                                        No asignado
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="glyphicon glyphicon-edit" title="Editar"
                                       href="{{ URL::to('/m/material/'.$material->id.'/edit') }}"></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else <p>No existen registros</p>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"> Materiales Retirados</div>
                <div class="panel-body">
                    <a class="btn btn-primary pull-right" href="{{ URL::route('m.material-retirado.create') }}">
                        Nuevo </a>
                </div>
                @if( ! $matRetirados->isEmpty() )
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Form 4</th>
                            <th>Pos. en form 4</th>
                            <th class="col-md-1">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matRetirados as $matReti)
                            <tr>
                                <td>{{ $matReti->nombre }}</td>
                                <td>
                                    @if($matReti->es_oficial) Si
                                    @else No
                                    @endif
                                </td>
                                <td>
                                    @if($matReti->orden)
                                        {{ $matReti->orden }}
                                    @else
                                        No asignado
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a class="glyphicon glyphicon-edit" title="Editar"
                                       href="{{ URL::to('/m/material-retirado/'.$matReti->id.'/edit') }}"></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else <p>No existen registros</p>
                @endif
            </div>
        </div>
    </div>
@stop