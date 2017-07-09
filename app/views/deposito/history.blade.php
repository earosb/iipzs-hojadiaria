@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de hojas diarias existentes">
    <meta name="author" content="earosb">
@stop

@section('title')
    Histórico
@stop

@section('content')
    <legend>Histórico centros de acopio</legend>
    <div class="col-xs-12 col-md-4 col-md-push-8">
        {{ Form::open(array(
        'url'		=>	'/depositos',
        'method'	=>	'get',
        'class' =>  'form-horizontal')) }}
        <div class="panel panel-default filterable">
            <div class="panel-heading clearfix">
                {{--{{ Form::select('paginate', array('20' => '20', '30' => '30', '40' => '40', '50' => '50'), Input::get('paginate')) }}--}}
                <div class="btn-group pull-right">
                    {{ Form::submit('Aplicar', array('class' => 'btn btn-primary btn-xs')) }}
                </div>
                <h3 class="panel-title pull-left" style="padding-top: 5px;padding-right: 15px;">Filtrar</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ Form::label('material', 'Material', array('class' => 'col-xs-2 control-label')) }}
                    <div class="col-xs-8 col-md-8">
                        <select name="material" id="material" class="form-control">
                            <optgroup label="Material">
                                @foreach($materiales as $material)
                                    @if(Input::get('material') == $material->nombre)
                                        <option value="{{ $material->nombre }}"
                                                selected>{{ $material->nombre }}</option>
                                    @else
                                        <option value="{{ $material->nombre }}">{{ $material->nombre }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Retirados">
                                @foreach($materialesRet as $material)
                                    <option value="{{ $material->nombre }}">{{ $material->nombre }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('acopio', 'Acopio', array('class' => 'col-xs-2 control-label')) }}
                    <div class="col-xs-8 col-md-8">
                        <select name="acopio" id="acopio" class="form-control">
                            @foreach($depositos as $deposito)
                                @if(Input::get('acopio') == $deposito->id)
                                    <option value="{{ $deposito->id }}" selected>{{ $deposito->nombre }}</option>
                                @else
                                    <option value="{{ $deposito->id }}">{{ $deposito->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <div class="col-xs-12 col-md-8 col-md-pull-4">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Acopio</th>
                <th>Material</th>
                <th>Cantidad</th>
                @if($total)
                    <th>Total</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($result as $item)
                <tr>
                    <td>
                        {{ Carbon\Carbon::parse($item['fecha'])->format('d-m-Y') }}
                    </td>
                    <td>
                        {{ $item['tipo'] }}
                    </td>
                    <td>
                        {{ $item['acopio'] }}
                    </td>
                    <td>
                        {{ $item['material'] }}
                    </td>
                    <td>
                        @if(is_float($item['cantidad'])) {{ $item['cantidad'] }}
                        @else {{ intval( $item['cantidad'] ) }}
                        @endif
                    </td>
                    @if($total)
                        <td>
                            {{ $item['total'] }}
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{--{{ $results->appends(Input::except('page'))->links() }}--}}
        </div>
    </div>
@stop
