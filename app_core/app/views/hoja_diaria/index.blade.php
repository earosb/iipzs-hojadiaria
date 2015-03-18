@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de hojas diarias existentes">
    <meta name="author" content="earosb">
@stop

@section('title')
    Histórico hoja diaria de trabajo
@stop

@section('css')
    {{ HTML::style('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css') }}
    <style type="text/css">
        @media print {
            #div_historico {
                display: none;
            }

            .btn-group {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="col-xs-12 col-md-12 col-lg-8" id="div_historico">
        <legend>Histórico Hojas Diarias</legend>
        <table class="table table-bordered table-hover" id="tab_trabajados">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingresada el</th>
                <th>Ingresada por</th>
                <th>Última edición</th>
                <th>Grupo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allHojas as $hoja)
                <tr data-id="{{ $hoja->id }}">
                    <td>
                        {{ Carbon\Carbon::parse($hoja->fecha)->format('d-m-Y') }}
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($hoja->created_at)->format('d-m-Y H:i:s') }}
                    </td>
                    <td>
                        {{ $hoja->user->username }}
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($hoja->updated_at)->format('d-m-Y H:i:s') }}
                    </td>
                    <td>
                        {{ $hoja->grupo_trabajo->base }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $allHojas->links() }}
        </div>
    </div>
@stop

@include('modal.viewHojaDiaria')

@section('js')
    {{ HTML::script('js/hd/index.js') }}
    {{--{{ HTML::script('js/min/1425397825695.min.js') }}--}}
@endsection