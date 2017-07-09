@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de hojas diarias existentes">
    <meta name="author" content="earosb">
@stop

@section('title')
    Histórico hoja diaria de trabajo
@stop

@section('css')
    {{ HTML::style('dist/css/dataTables.bootstrap.min.css') }}
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
        <table class="table table-bordered table-striped table-hover" id="tab_trabajados">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Grupo</th>
                <th>Ingresada por</th>
                <th>Observaciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allHojas as $hoja)
                <tr data-id="{{ $hoja->id }}">
                    <td>
                        {{ Carbon\Carbon::parse($hoja->fecha)->format('d-m-Y') }}
                    </td>
                    <td>
                        {{ $hoja->grupo_trabajo->base }}
                    </td>
                    <td>
                        {{ $hoja->user->username }}
                    </td>
                    <td>
                        {{ $hoja->observaciones }}
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
        'method'	=>	'get',
        'class' =>  'form-horizontal')) }}
        <div class="panel panel-default filterable">
            <div class="panel-heading clearfix">
                {{ Form::select('paginate', array('20' => '20', '30' => '30', '40' => '40', '50' => '50'), Input::get('paginate')) }}
                <div class="btn-group pull-right">
                    {{ Form::submit('Aplicar', array('class' => 'btn btn-primary btn-xs')) }}
                </div>
                <h3 class="panel-title pull-left" style="padding-top: 5px;padding-right: 15px;">Filtrar</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ Form::label('month', 'Mes', array('class' => 'col-xs-2 control-label')) }}
                    <div class="col-xs-6">
                        {{ Form::select('month', trans('form.months'), Input::get('month'), ['class'=>'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{-- Año --}}
                    {{ Form::label('year', 'Año', array('class' => 'col-xs-2 control-label')) }}
                    <div class="col-xs-6">
                        {{ Form::selectYear('year', 2015, $year, $year, ['class'=>'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('group', 'Grupos', array('class' => 'col-xs-2 control-label')) }}

                    <div class="col-xs-6">
                        @foreach($grupos as $grupo)
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('group['.$grupo->id.']', $grupo->id, (Input::get('group.'.$grupo->id) == $grupo->id)) }}
                                    {{ $grupo->base }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@stop

@include('modal.viewHojaDiaria')

@section('js')
    {{ HTML::script('dist/js/index_hoja-diaria.js') }}
@endsection