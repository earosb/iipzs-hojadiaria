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

            #div_filter {
                display: none;
            }

            .btn-group {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <legend>Histórico Hojas Diarias</legend>
    <div class="col-xs-12 col-md-8" id="div_historico">
        <table class="table table-bordered table-hover" id="tab_trabajados">
            <thead>
            <tr>
                <th>Fecha</th>
                <th class="hidden-xs">Ingresada el</th>
                <th>Ingresada por</th>
                <th class="hidden-xs">Última edición</th>
                <th>Grupo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allHojas as $hoja)
                <tr data-id="{{ $hoja->id }}">
                    <td>
                        {{ Carbon\Carbon::parse($hoja->fecha)->format('d-m-Y') }}
                    </td>
                    <td class="hidden-xs">
                        {{ Carbon\Carbon::parse($hoja->created_at)->format('d-m-Y H:i:s') }}
                    </td>
                    <td>
                        {{ $hoja->user->username }}
                    </td>
                    <td class="hidden-xs">
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
    <div class="col-xs-12 col-md-4" id="div_filter">
        {{ Form::open(array(
        'url'		=>	'/hd',
        'method'	=>	'get')) }}
        <div class="panel panel-default filterable">
            <div class="panel-heading clearfix">
                {{ Form::select('paginate', array('20' => '20', '30' => '30', '40' => '40', '50' => '50'), Input::get('paginate')) }}
                <div class="btn-group pull-right">
                    {{ Form::submit('Aplicar', array('class' => 'btn btn-primary btn-xs')) }}
                </div>
                <h3 class="panel-title pull-left" style="padding-top: 5px;">Filtrar</h3>
            </div>
            <div class="panel-body">
                @foreach($grupos as $grupo)
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox('grupos['.$grupo->id.']', $grupo->id, (Input::get('grupos.'.$grupo->id) == $grupo->id)) }}
                            {{ $grupo->base }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        {{ Form::close() }}
    </div>
@stop

@include('modal.viewHojaDiaria')

@section('js')
    {{ HTML::script('js/hd/index.js') }}
    {{--{{ HTML::script('js/min/1425397825695.min.js') }}--}}
@endsection