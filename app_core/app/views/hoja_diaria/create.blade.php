@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de una hoja diaria de trabajo">
    <meta name="author" content="earosb">
@stop

@section('title')
    Nueva hoja diaria de trabajo
@stop
@section('css')
    {{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css') }}
    {{ HTML::style('css/hd/create.css') }}
@stop
@section('content')
    <div class="row">
        {{ Form::open([
            'url' 		=>	'hd',
            'method' 	=>	'post',
            'id'		=>	'formHojaDiaria',
            'class' 	=> 	'form-horizontal']) }}
        <fieldset>
            {{-- Datos hoja diaria
            ===================================================== --}}
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-md-3">Fecha</th>
                        <th class="col-md-3">Grupo</th>
                        <th class="col-md-3">Sector</th>
                        <th class="col-md-3">Block</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="input-group" id="fecha_div">
                                {{ Form::text('fecha', null, ['class'=>'form-control', 'placeholder'=>'Ingrese Fecha', 'id'=>'fecha', 'required' => 'required']) }}
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                            <div class="help-block" id="fecha_error"></div>
                        </td>
                        <td>
                            <div id="selectgrupos_div">
                                <div class="controls">
                                    <select name="selectgrupos" id="selectgrupos" class="form-control">
                                        <option selected="selected" disabled="disabled"> Seleccione un Grupo</option>
                                        @foreach($grupos as $grupo)
                                            <option value="{{ $grupo->id }}">{{ $grupo->base }}</option>
                                        @endforeach
                                    </select>

                                    <div class="help-block" id="selectgrupos_error"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div id="selectsector_div">
                                <div class="controls">
                                    <select name="selectsector" id="selectsector" class="form-control">
                                        <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                        @foreach($sectores as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                        @endforeach
                                    </select>

                                    <div class="help-block" id="selectsector_error"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div id="selectblock_div">
                                <div class="controls">
                                    <select name="selectblock" id="selectblock" class="form-control">
                                        <option selected="selected" disabled="disabled" value="null"> Seleccione un
                                            Sector
                                        </option>
                                    </select>

                                    <div class="help-block" id="selectblock_error"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Tabla trabajos realizados
            ===================================================== --}}
            <div class="col-md-12">
                <table class="table table-bordered" id="tab_trabajados">
                    <thead>
                    <tr>
                        <th class="col-md-5">Trabajos Ejecutados</th>
                        <th class="col-md-2">Tipo vía</th>
                        <th class="col-md-2">Km inicio</th>
                        <th class="col-md-2">Km término</th>
                        <th class="col-md-1">Cantidad</th>
                        <th class="tdButton text-center">
                            <a id="add_row_trabajos" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addr0' data-id="0" class="hidden">
                        <td data-name="trabajos" data-tipo="trabajo">
                            <select name="trabajos[0][trabajo]" class="form-control selecttrabajo"
                                    onChange="getMateriales(this)">
                                <option selected="selected" disabled="disabled" value="" style="display:none;">
                                    Seleccione un Trabajo
                                </option>
                                @foreach($tipoMantenimiento as $tMat)
                                    <optgroup label="{{ $tMat->nombre }}">
                                        @foreach($tMat->trabajos as $trabajo)
                                            <option value="{{ $trabajo->id }}">{{ $trabajo->nombre }}
                                                ({{ $trabajo->unidad }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </td>
                        <td data-name="trabajos" data-tipo="ubicacion" data-ubicacion="true">
                            {{ Form::select('trabajos[0][ubicacion]', ['Seleccione Sector'], null, [ 'class'=>'form-control selectubicacion']) }}
                        </td>
                        <td data-name="trabajos" data-tipo="km_inicio">
                            {{ Form::number('trabajos[0][km_inicio]', null, ['class' => 'form-control km-inicio', 'id' => 'trabajos[0][km_inicio]', 'onblur' => 'onblurKmTermino(this);', 'min' => 0]) }}
                        </td>
                        <td data-name="trabajos" data-tipo="km_termino">
                            {{ Form::number('trabajos[0][km_termino]', null, array('class' => 'form-control km-termino', 'id' => 'trabajos[0][km_termino]', 'min' => 0)) }}
                        </td>
                        <td data-name="trabajos" data-tipo="cantidad">
                            {{ Form::number('trabajos[0][cantidad]', null, ['class' => 'form-control', 'min' => '0', 'step' => 'any']) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Tabla materiales colocados
            ===================================================== --}}
            <div class="col-md-12">
                <table class="table table-bordered" id="tab_material_colocado">
                    <thead>
                    <tr>
                        <th>Materiales Colocados</th>
                        <th>Centro de acopio</th>
                        <th>Reempleo</th>
                        <th class="col-md-1">Cantidad</th>
                        <th class="tdButton text-center">
                            <a id="add_row_matCol" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addrMatCol0' data-id="0" class="hidden">
                        <td data-name="matCol" data-tipo="id">
                            {{ Form::select('matCol[0][id]', $materiales, null, [ 'class'=>'form-control matCol']) }}
                        </td>
                        <td data-name="matCol" data-tipo="deposito">
                            <select name="matCol[0][deposito]" id="matCol[0][deposito]" class="form-control">
                                @foreach($depositos as $deposito)
                                    <option value="{{ $deposito->id }}">{{ $deposito->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td data-name="matCol" data-tipo="reempleo">
                            {{ Form::checkbox('matCol[0][reempleo]', 'true', false, ['class' => 'form-control']) }}
                        </td>
                        <td data-name="matCol" data-tipo="cant">
                            {{ Form::number('matCol[0][cant]', null, ['class' => 'form-control', 'min' => '0', 'step' => 'any']) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Tabla materiales retirados
            ===================================================== --}}
            <div class="col-md-12">
                <table class="table table-bordered" id="tab_material_retirado">
                    <thead>
                    <tr>
                        <th>Materiales Retirados</th>
                        <th>Centro de acopio</th>
                        <th>Reempleo</th>
                        <th class="col-md-1">Cantidad</th>
                        <th class="tdButton text-center">
                            <a id="add_row_matRet" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addrMatRet0' data-id="0" class="hidden">
                        <td data-name="matRet" data-tipo="id">
                            {{ Form::select('matRet[0][id]', $materialesRet, null, ['class'=>'form-control matRet']) }}
                        </td>
                        <td data-name="matRet" data-tipo="deposito">
                            <select name="matRet[0][deposito]" id="matRet[0][deposito]" class="form-control">
                                @foreach($depositos as $deposito)
                                    <option value="{{ $deposito->id }}">{{ $deposito->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td data-name="matRet" data-tipo="reempleo">
                            {{ Form::checkbox('matRet[0][reempleo]', 'true', false, ['class' => 'form-control']) }}
                        </td>
                        <td data-name="matRet" data-tipo="cant">
                            {{ Form::number('matRet[0][cant]', null, ['class' => 'form-control', 'min' => '0', 'step' => 'any']) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Textarea Observaciones
            table es innecesaria pero pero utilizó para mantener el formulario homogeneo
            ===================================================== --}}
            <div class="col-md-4">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Observaciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ Form::textarea('obs', null, ['rows' => '5']) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Botones
            ===================================================== --}}
            <div class="col-md-12">
                {{ Form::submit('Guardar', ['class' => 'btn btn-primary pull-right']) }}
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>
@stop

@section('js')
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js') }}
    {{ HTML::script('js/calendar/calendar.min.js') }}

    {{ HTML::script('js/hd/create/table.js') }}
    {{--{{ HTML::script('js/min/1424470502873.min.js') }}--}}

    {{ HTML::script('js/hd/create/create.js') }}
    {{--{{ HTML::script('js/min/1425312083058.min.js') }}--}}

    {{ HTML::script('js/ajaxBlocks.js') }}
    {{--{{ HTML::script('js/min/1425396779231.min.js') }}--}}
@stop

@if (Sentry::getUser()->hasAccess(['editor']))
@section('modals')
    @include('modal.modalEditor')
    @include('modal.formDesviador')
    @include('modal.formDesvio')
    @include('modal.formMaterialColocado')
    @include('modal.formMaterialRetirado')
    @include('modal.formTrabajo')
@stop
@endif