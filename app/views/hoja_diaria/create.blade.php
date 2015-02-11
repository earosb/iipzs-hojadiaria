@extends('layout.landing')
@section('title')
    Icil-icafal - Nueva hoja diaria de trabajo
@stop
@section('css')
    {{ HTML::style('css/jquery-ui.min.css') }}
    {{ HTML::style('css/hd/create.min.css') }}
@stop
@section('content')
    <div class="row">
        {{ Form::open(array(
        'url' 		=>	'hd',
        'method' 	=>	'post',
        'id'		=>	'formHojaDiaria',
        'class' 	=> 	'form-horizontal')) }}
        <fieldset>
            <legend>Nueva hoja diaria de trabajo
                {{-- Botón "flotante"
                ===================================================== --}}
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle glyphicon glyphicon-cog"
                            data-toggle="dropdown" aria-expanded="false">
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-header">Ubicaciones</li>
                        <li><a data-toggle="modal" data-target="#modalDesviador" href="#">Nuevo Desviador</a></li>
                        <li><a data-toggle="modal" data-target="#modalDesvio" href="#">Nuevo Desvío</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Trabajos</li>
                        <li><a data-toggle="modal" data-target="#modalTrabajo" href="#">Nuevo Trabajo</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Materiales</li>
                        <li><a data-toggle="modal" data-target="#modalMaterialCol" href="#">Nuevo Material Colocado</a>
                        </li>
                        <li><a data-toggle="modal" data-target="#modalMaterialRet" href="#">Nuevo Material Retirado</a>
                        </li>
                    </ul>
                </div>
            </legend>
            <div class="col-md-12">
                <div id="fecha_div">
                    {{ Form::text('fecha', null, ['class'=>'input-sm', 'placeholder'=>'Ingrese Fecha', 'id'=>'fecha']) }}
                    <span class="glyphicon glyphicon-calendar"></span>

                    <div class="help-block" id="fecha_error"></div>
                </div>
            </div>
            <div class="col-md-12">
                {{-- Select sector
                ===================================================== --}}
                <div id="selectsector_div" class="form-group col-xs-12 col-md-4">
                    {{ Form::label('selectsector', 'Sector', array('class' => 'control-label')) }}
                    <div class="controls">
                        <select name="selectsector" id="selectsector" class="myselect">
                            <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                            @foreach($sectores as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                            @endforeach
                        </select>

                        <div class="help-block" id="selectsector_error"></div>
                    </div>
                </div>
                {{-- Select block
                ===================================================== --}}
                <div id="selectblock_div" class="form-group col-xs-12 col-md-4">
                    {{ Form::label('selectblock', 'Block', array('class' => 'control-label')) }}
                    <div class="controls">
                        <select name="selectblock" id="selectblock" class="myselect">
                            <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                        </select>

                        <div class="help-block" id="selectblock_error"></div>
                    </div>
                </div>
                {{-- Grupo Vía
                ===================================================== --}}
                <div id="selectgrupos_div" class="form-group col-xs-12 col-md-4">
                    {{ Form::label('selectgrupos', 'Grupo Vía', array('class' => 'control-label')) }}
                    <div class="controls">
                        <select name="selectgrupos" id="selectgrupos" class="myselect">
                            <option selected="selected" disabled="disabled"> Seleccione un Grupo</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->base }}</option>
                            @endforeach
                        </select>

                        <div class="help-block" id="selectgrupos_error"></div>
                    </div>
                </div>
            </div>
            {{-- Tabla trabajos realizados
            ===================================================== --}}
            <div class="col-md-12">
                <table class="table table-bordered table-striped" id="tab_trabajados">
                    <thead>
                    <tr>
                        <th>Trabajos Ejecutados</th>
                        <th>Desvío / Desviador</th>
                        <th class="tdkilometro">Km inicio</th>
                        <th class="tdkilometro">Km término</th>
                        <th class="tdkilometro">Cantidad</th>
                        <th class="text-center">
                            <a id="add_row_trabajos" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addr0' data-id="0" class="hidden">
                        <td data-name="trabajos" data-tipo="trabajo">
                            {{--{{ Form::select('trabajos[0][trabajo]', $tipoMantenimiento, null, [ 'class'=>'form-control selecttrabajo']) }}--}}
                            <select name="trabajos[0][trabajo]" class="form-control selecttrabajo">
                                <option selected="selected" disabled="disabled"> Seleccione un Trabajo</option>
                                @foreach($tipoMantenimiento as $tMat)
                                    <optgroup label="{{ $tMat->nombre }}">
                                        @foreach($tMat->trabajos as $trabajo)
                                            <option value="{{ $trabajo->id }}">{{ $trabajo->nombre }}
                                                [{{ $trabajo->unidad }}]
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </td>
                        <td data-name="trabajos" data-tipo="ubicacion" data-ubicacion="true">
                            {{ Form::select('trabajos[0][ubicacion]', ['Seleccione Sector y Block'], null, [ 'class'=>'form-control selectubicacion']) }}
                        </td>
                        <td data-name="trabajos" data-tipo="km_inicio">
                            {{ Form::text('trabajos[0][km_inicio]', null, array('placeholder' => '', 'class' => 'form-control' ,'maxlength' => '7')) }}
                        </td>
                        <td data-name="trabajos" data-tipo="km_termino">
                            {{ Form::text('trabajos[0][km_termino]', null, array('placeholder' => '', 'class' => 'form-control','maxlength' => '7' )) }}
                        </td>
                        <td data-name="trabajos" data-tipo="cantidad">
                            {{ Form::text('trabajos[0][cantidad]', null, array('placeholder' => '', 'class' => 'form-control' )) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Tabla materiales colocados
            ===================================================== --}}
            <div class="col-md-12">
                <div class="col-xs-12 col-md-6 form-group">
                    <table class="table table-bordered table-striped" id="tab_material_colocado">
                        <thead>
                        <tr>
                            <th>Materiales Colocados</th>
                            <th>Reempleo</th>
                            <th class="tdkilometro">Cantidad</th>
                            <th class="text-center">
                                <a id="add_row_matCol" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id='addrMatCol0' data-id="0" class="hidden">
                            <td data-name="matCol" data-tipo="id">
                                {{ Form::select('matCol[0][id]', $materiales, null, [ 'class'=>'form-control matCol']) }}
                            </td>
                            <td data-name="matCol" data-tipo="reempleo">
                                {{ Form::checkbox('matCol[0][reempleo]') }}
                            </td>
                            <td data-name="matCol" data-tipo="cant">
                                {{ Form::text('matCol[0][cant]', null, array('class' => 'form-control', 'size' => '4')) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                {{-- Tabla materiales retirados
                ===================================================== --}}
                <div class="col-xs-12 col-md-6">
                    <table class="table table-bordered table-striped" id="tab_material_retirado">
                        <thead>
                        <tr>
                            <th>Materiales Retirados</th>
                            <th class="tdkilometro">Cantidad</th>
                            <th class="text-center">
                                <a id="add_row_matRet" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id='addrMatRet0' data-id="0" class="hidden">
                            <td data-name="matRet" data-tipo="id">
                                {{ Form::select('matRet[0][id]', $materialesRet, null, [ 'class'=>'form-control matRet']) }}
                            </td>
                            <td data-name="matRet" data-tipo="cant">
                                {{ Form::text('matRet[0][cant]', null, array('class' => 'form-control', 'size' => '4' )) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Textarea Observaciones
            ===================================================== --}}
            <div class="col-xs-12 col-md-6">
                {{ Form::label('obs', 'Observaciones', array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::textarea('obs', null, ['rows' => '3']) }}
                </div>
            </div>
            {{-- Botones
            ===================================================== --}}
            <div class="col-xs-12 col-md-12">
                {{-- <a href="#" class="btn btn-default ">Guardar y nuevo</a> --}}
                {{-- Form::button('Guardar', array('type' => 'submit', 'class' => 'btn btn-primary pull-right')) --}}
                {{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>
@stop

@section('js')
    {{ HTML::script('js/jquery-ui.min.js') }}
    {{ HTML::script('js/hd/create/calendar.min.js') }}
    {{ HTML::script('js/hd/create/table.js') }}
    {{ HTML::script('js/hd/create/create.js') }}
    {{ HTML::script('js/hd/create/ajax.js') }}
    {{ HTML::script('js/hd/create/formHojaDiaria.js') }}
@stop

@section('modals')
    @include('modal.formDesviador')
    @include('modal.formDesvio')
    @include('modal.formMaterialColocado')
    @include('modal.formMaterialRetirado')
    @include('modal.formTrabajo')
@stop
