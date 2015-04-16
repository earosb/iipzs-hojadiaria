@extends('layout.landing')

@section('meta')
    <meta name="description" content="Muestra los elementos contenidos en un block (desvíos, desviadores)">
    <meta name="author" content="earosb">
@stop


@section('title')
    Mantención Vías
@stop

@section('content')
    <div class="row">
        {{-- Desviadores --}}
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Desviadores</div>
                <div class="panel-body">
                    <a class="btn btn-primary pull-right" href="{{ URL::route('m.desviador.create') }}">Nuevo
                        Desviador</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Km Inicio</th>
                        <th class="col-md-1">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($desviadores as $desviador)
                        <tr>
                            <td>
                                {{ $desviador->nombre }}
                            </td>
                            <td>
                                {{ $desviador->km_inicio }}
                            </td>
                            <td class="text-center">
                                <a class="glyphicon glyphicon-edit" title="Editar"
                                   href="{{ URL::to('/m/desviador/'.$desviador->id.'/edit') }}"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Desvíos --}}
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Desvíos
                </div>
                <div class="panel-body">
                    <a class="btn btn-primary pull-right" href="{{ URL::route('m.desvio.create') }}">Nuevo Desvío</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Desviador norte</th>
                        <th>Desviador sur</th>
                        <th class="col-md-1">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($desvios as $desvio)
                        <tr>
                            <td>
                                {{ $desvio->nombre }}
                            </td>
                            <td>
                                @if($desvio->desviador_norte_id) {{ $desvio->desviador_norte_id }}
                                @else N/A
                                @endif
                            </td>
                            <td>
                                @if($desvio->desviador_sur_id) {{ $desvio->desviador_sur_id }}
                                @else N/A
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="glyphicon glyphicon-edit" title="Editar"
                                   href="{{ URL::to('/m/desvio/'.$desvio->id.'/edit') }}"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop