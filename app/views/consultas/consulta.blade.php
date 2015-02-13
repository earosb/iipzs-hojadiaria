{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 12-02-15
 * Time: 16:59
--}}

@extends('layout.landing')

@section('title')
    Resultado Consulta
@stop
@section('css')
    <style type="text/css">
        @media print {
            .breadcrumb {
                display: none;
            }

            .glyphicon {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('/') }}">Inicio</a></li>
        <li><a href="{{ URL::to('/s/param') }}">Consultas</a></li>
        <li class="active">Datos</li>
        <div class="pull-right">
            <a class="glyphicon glyphicon-print" title="Imprimir" href="javascript:window.print()"> Imprimir</a>
        </div>
    </ul>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <legend>
                {{--<a class="glyphicon glyphicon-arrow-left" title="Volver" href="javascript:history.back()"></a>--}}
                Trabajos Realizados
            </legend>
            <div>
                <p>Entre los kilómetros {{ Request::get('km_inicio') }} y {{ Request::get('km_termino') }}</p>

                <p>Desde el {{ Request::get('desde') }} Hasta el {{ Request::get('hasta') }}</p>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Block</th>
                    <th>Km Inicio</th>
                    <th>Km Término</th>
                    <th>Trabajo</th>
                    <th>Cantidad [Uni]</th>
                </tr>
                </thead>
                <tbody>
                @forelse($trabajos as $index => $trabajo)
                    <tr>
                        <td>
                            {{ $index + 1}}
                        </td>
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
                            <b class="pull-right" style="margin-right: 15%">
                                [{{ $trabajo->unidad }}]
                            </b>
                        </td>
                    </tr>
                @empty
                    <p><strong>No existen registros</strong></p>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-xs-12 col-md-12">
            <legend>Materiales Colocados</legend>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cantidad [u]</th>
                    <th>Reempleo</th>
                </tr>
                </thead>
                <tbody>
                @forelse($materiales as $index => $material)
                    <tr>
                        <td>
                            {{ $index + 1}}
                        </td>
                        <td>
                            {{ $material->nombre }}
                        </td>
                        <td>
                            {{ $material->cantidad }} [{{ $material->unidad }}]
                        </td>
                        <td>
                            @if($material->reempleo == '1') Reempleo
                            @else Nuevo
                            @endif

                        </td>
                    </tr>
                @empty
                    <p><strong>No existen registros</strong></p>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="well hidden">
            {{ $materiales }}
        </div>
    </div>
@stop