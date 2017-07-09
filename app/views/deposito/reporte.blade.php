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
        <li><a href="{{ URL::to('/r/depositos') }}">Centros de acopio</a></li>
        <li class="active">Reporte</li>
        <div class="pull-right">
            <a class="glyphicon glyphicon-print" title="Imprimir" href="javascript:window.print()"> Imprimir</a>
        </div>
    </ul>
    <div class="row">

        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-default">
                {{--<div class="panel-heading">--}}
                    {{--<h4 class="panel-title">Parámetros de búsqueda</h4>--}}
                {{--</div>--}}
                <div class="panel-body">
                    {{--<p><strong>Parámetros de búsqueda:</strong></p>--}}

                    <table class="table show-table">
                        <thead class="show-table-header">
                        <tr>
                            <td class="show-table-label">Parámetros de búsqueda</td>
                            <td class="show-table-data"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="show-table-label">A la fecha</td>
                            <td class="show-table-data">{{ $fecha }}</td>
                        </tr>
                        <tr>
                            <td class="show-table-label">Acopio</td>
                            <td class="show-table-data">{{ $acopio  }}</td>
                        </tr>
                        <tr>
                            <td class="show-table-label">Material</td>
                            <td class="show-table-data">{{ $material }}</td>
                        </tr>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-10">
            {{--<legend><h3> Trabajos Realizados </h3></legend>--}}
            <table class="table table-bordered table-striped display" id="reportTable">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                {{--*/ $total = 0 /*--}}
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{ $item->fecha }}
                        </td>
                        <td>
                            {{ $item->tipo }}
                        </td>
                        <td>
                            @if(is_float($item->cantidad)) {{ $item->cantidad }}
                            @else {{ intval( $item->cantidad ) }}
                            @endif
                        </td>
                        <td>
                            {{--*/ $total += $item->cantidad /*--}}
                            {{ $total }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
{{--            {{ $items->links() }}--}}
        </div>

    </div>
@stop


@section('js')
    {{ HTML::script('dist/js/reportes.js') }}
    <script>
        $(document).ready(function () {

            var table = $('#reportTable').DataTable({
                paging: true,
                pageLength: 25,
                // displayStart: 25,
                ordering: false,
                info: false,
                stateSave: false,
                filter: false,
                language: {
                    url: "/dist/json/Spanish.json"
                }
            });

            setTimeout(function(){
                table.page( 'last' ).draw('page');
                $('#reportTable_length').hide();
            }, 1000);


        });
    </script>
@endsection