@extends('layout.landing')

@section('meta')
    <meta name="description" content="Página de reporte resumido de trabajos realizados">
    <meta name="author" content="earosb">
@stop

@section('title')
    Reporte centros de acopio
@stop

@section('css')
    {{ HTML::style('dist/css/reporte.css') }}
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('/') }}">Inicio</a></li>
        <li><a href="{{ URL::to('/r/deposito') }}">Consultas</a></li>
        <li class="active">Reporte centros de acopio</li>
        <div class="pull-right">
            <a class="glyphicon glyphicon-print" title="Imprimir" href="javascript:window.print()"> Imprimir</a>
        </div>
    </ul>
    <div class="col-xs-12 col-md-12">
            {{-- Deposito --}}
            <div class="col-xs 4 col-md-3">
                {{ Form::label('deposito', 'Depósito', ['class' => 'control-label']) }}
                <div class="input-group" id="deposito_div">
                    {{--<legend><h3>{{ $deposito->nombre }}</h3></legend>--}}
                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                    <span class="form-control">{{ $deposito->nombre }}</span>
                </div>
            </div>
            {{-- Fecha Inicio --}}
            <div class="col-xs 4 col-md-3">
                {{ Form::label('fecha_desde', 'Desde', ['class' => 'control-label']) }}
                <div class="input-group" id="fecha_desde_div">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <span class="form-control">{{ Request::get('fecha_desde') }}</span>
                </div>
            </div>
            {{-- Fecha término --}}
            <div class="col-xs 4 col-md-3">
                {{ Form::label('fecha_hasta', 'Hasta', ['class' => 'control-label']) }}
                <div class="input-group" id="fecha_hasta_div">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <span class="form-control">{{ Request::get('fecha_hasta') }}</span>
                </div>
            </div>
    </div>
    <div class="col-md-12">
        @if( isset($colocados) )
            <div class="col-xs-12 col-md-6">
                <legend><h3> Materiales Colocados </h3></legend>
                <table class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Grupo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colocados as $colocado)
                        <tr>
                            <td>
                                {{ date('d/m/Y', strtotime($colocado->fecha)) }}
                            </td>
                            <td>
                                {{ $colocado->material }}
                            </td>
                            <td>
                                {{ $colocado->cantidad }}
                            </td>
                            <td>
                                {{ $colocado->grupo }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--{{ $colocados->links() }}--}}
            </div>
        @endif
        @if( isset($retirados) )
            <div class="col-xs-12 col-md-6">
                <legend><h3> Materiales Retirados </h3></legend>
                <table class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Grupo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($retirados as $retirado)
                        <tr>
                            <td>
                                {{ date('d/m/Y', strtotime($retirado->fecha)) }}
                            </td>
                            <td>
                                {{ $retirado->material }}
                            </td>
                            <td>
                                {{ $retirado->cantidad }}
                            </td>
                            <td>
                                {{ $retirado->grupo }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--{{ $retirados->links() }}--}}
            </div>
        @endif
    </div>
@stop


@section('js')
    {{ HTML::script('dist/js/reportes.js') }}
    <script>
        $(document).ready(function () {
            $('table.display').DataTable({
                paging: true,
                ordering: true,
                info: false,
                stateSave: false,
                filter: false,
                language: {
                    url: "dist/json/Spanish.json"
                }
            });
        });
    </script>
@endsection