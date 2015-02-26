{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 23-02-15
 * Time: 18:48
--}}

@extends('layout.landing')

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
                    <a class="btn btn-info btn-new pull-right" href="#">Nuevo Desviador</a>
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
                                <a class="glyphicon glyphicon-edit"
                                   href="#"></a>
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
                    <a class="btn btn-info btn-new pull-right" href="#">Nuevo Desvío</a>
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
                                <a class="glyphicon glyphicon-edit"
                                   href="#"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                <p>{{ $desvios }}</p>
        </div>
    </div>
@stop