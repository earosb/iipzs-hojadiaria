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
    {{--{{ HTML::style('//cdn.datatables.net/1.10.5/css/jquery.dataTables.css') }}--}}
    {{ HTML::style('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css') }}
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
            <table class="table table-bordered table-striped display">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Block</th>
                    <th>Km Inicio</th>
                    <th>Km Término</th>
                    <th>Trabajo</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    @if(Sentry::getUser()->hasAccess(['consultas-avanzadas']))
                        <th>Grupo Vía</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse($trabajos as $trabajo)
                    <tr>
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
                        </td>
                        <td>
                            {{ $trabajo->unidad }}
                        </td>
                        @if(Sentry::getUser()->hasAccess(['consultas-avanzadas']))
                            <td>
                                {{ $trabajo->base }}
                            </td>
                        @endif
                    </tr>
                @empty
                    <p><strong>No existen registros</strong></p>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-xs-12 col-md-12">
            <legend>Materiales Colocados</legend>
            <table class="table table-bordered table-striped display">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Clase</th>
                </tr>
                </thead>
                <tbody>
                @forelse($materiales as $material)
                    <tr>
                        <td>
                            {{ $material->nombre }}
                        </td>
                        <td>
                            {{ $material->cantidad }}
                        </td>
                        <td>
                            {{ $material->unidad }}
                        </td>
                        <td>
                            @if($material->reempleo == '1') Reempleo
                            @else Nuevo
                            @endif
                            {{--{{ $material->reempleo }}--}}
                        </td>
                    </tr>
                @empty
                    <p><strong>No existen registros</strong></p>
                @endforelse
                </tbody>
            </table>
        </div>
        <div>
            <p>{{ $materiales }}</p>

            <p>{{ $matReempleo }}</p>
        </div>
    </div>
@stop


@section('js')
    {{ HTML::script('//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js') }}
    {{ HTML::script('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js') }}
    <script>
        $(document).ready(function () {
            $('table.display').DataTable({
                paging: false,
                ordering: true,
                info: false,
                stateSave: false,
                filter: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection