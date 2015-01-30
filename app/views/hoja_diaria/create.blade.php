@extends('layout.landing')
@section('title')
Icil-icafal - Nueva hoja diaria de trabajo
@stop
@section('css')
{{ HTML::style('css/hd/create.min.css') }}
{{ HTML::style('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') }}
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
				<button type="button" class="btn btn-default dropdown-toggle glyphicon glyphicon-cog" data-toggle="dropdown" aria-expanded="false">
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
					<li><a data-toggle="modal" data-target="#modalMaterial" href="#">Nuevo Material Colocado</a></li>
					<li><a data-toggle="modal" data-target="#modalMaterialRet" href="#">Nuevo Material Retirado</a></li>
				</ul>
			</div>
		</legend>
		<div class="col-md-12">
			<div id="fecha_div">
				{{ Form::text('fecha', null, ['class'=>'input-sm', 'placeholder'=>'Ingrese Fecha', 'id'=>'fecha']) }}
				<span class="glyphicon glyphicon-calendar"></span>
				<div class="help-block" id ="fecha_error"></div>
			</div>
		</div>
		<div class="col-md-12">
			{{-- Select sector
			===================================================== --}}
			<div id="selectsector_div" class="form-group col-xs-12 col-md-4">
				{{ Form::label('selectsector', 'Sector', array('class' => 'control-label')) }}
				<div class="controls">
					<select name="selectsector" id="selectsector" class="myselect">
						<option selected="selected" disabled="disabled"> Seleccione un Sector </option>
						@foreach($sectores as $sector)
						<option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
						@endforeach
					</select>
					<div class="help-block" id ="selectsector_error"></div>
				</div>
			</div>
			{{-- Select block
			===================================================== --}}
			<div id="selectblock_div" class="form-group col-xs-12 col-md-4">
				{{ Form::label('selectblock', 'Block', array('class' => 'control-label')) }}
				<div class="controls">
					<select name="selectblock" id="selectblock" class="myselect">
						<option selected="selected" disabled="disabled"> Seleccione un Sector </option>
					</select>
					<div class="help-block" id ="selectblock_error"></div>
				</div>
			</div>
			{{-- Grupo Vía
			===================================================== --}}
			<div id="selectgrupos_div" class="form-group col-xs-12 col-md-4">
				{{ Form::label('selectgrupos', 'Grupo Vía', array('class' => 'control-label')) }}
				<div class="controls">
					<select name="selectgrupos" id="selectgrupos" class="myselect">
						<option selected="selected" disabled="disabled"> Seleccione un Grupo </option>
						@foreach($grupos as $grupo)
						<option value="{{ $grupo->id }}">{{ $grupo->base }}</option>
						@endforeach
					</select>
					<div class="help-block" id ="selectgrupos_error"></div>
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
						<th class="text-center"><a id="add_row_trabajos" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a></th>
					</tr>
				</thead>
				<tbody>
					<tr id='addr0' data-id="0" class="hidden">
						<td data-name="trabajoRealizado" data-tipo="trabajo">
							{{ Form::select('trabajoRealizado[0][trabajo]', $trabajos, null, [ 'class'=>'form-control selecttrabajo']) }}
						</td>
						<td data-name="trabajoRealizado" data-tipo="ubicacion" data-ubicacion="true">
							{{ Form::select('trabajoRealizado[0][ubicacion]', ['Seleccione Sector y Block'], null, [ 'class'=>'form-control selectubicacion']) }}
						</td>
						<td data-name="trabajoRealizado" data-tipo="km_inicio">
							{{ Form::text('trabajoRealizado[0][km_inicio]', null, array('placeholder' => '', 'class' => 'form-control' ,'maxlength' => '7')) }}
						</td>
						<td data-name="trabajoRealizado" data-tipo="km_termino">
							{{ Form::text('trabajoRealizado[0][km_termino]', null, array('placeholder' => '', 'class' => 'form-control','maxlength' => '7' )) }}
						</td>
						<td data-name="trabajoRealizado" data-tipo="cantidad">
							{{ Form::text('trabajoRealizado[0][cantidad]', null, array('placeholder' => '', 'class' => 'form-control' )) }}
						</td>
					</tr>
				</tbody>
			</table>
			{{-- Tabla materiales colocados
			===================================================== --}}
			<div class="form-group col-md-12">
				<div class="form-group col-md-6">
					<table class="table table-bordered table-striped" id="tab_material_colocado">
						<thead>
							<tr>
								<th >Materiales Colocados</th>
								<th class="tdkilometro">Cantidad</th>
								<th class="text-center"><a id="add_row_matCol" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a></th>
							</tr>
						</thead>
						<tbody>
							<tr id='addrMatCol0' data-id="0" class="hidden">
								<td data-name="matCol" data-tipo="id">
									{{ Form::select('matCol[0][id]', $materiales, null, [ 'class'=>'form-control']) }}
								</td>
								<td data-name="matCol" data-tipo="cant">
									{{ Form::text('matCol[0][cant]', null, array('class' => 'form-control', 'id' => 'matColNum0', 'size' => '4')) }}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
{{-- Tabla materiales retirados
===================================================== --}}
<div class="form-group col-md-6">
<table class="table table-bordered table-striped" id="tab_material_retirado">
<thead>
	<tr>
		<th >Materiales Retirados</th>
		<th class="tdkilometro">Cantidad</th>
		<th class="text-center"><a id="add_row_matRet" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a></th>
	</tr>
</thead>
<tbody>
	<tr id='addrMatRet0' data-id="0" class="hidden">
		<td data-name="matRet" data-tipo="id">
			{{ Form::text('matRet[0][id]', null, array('class' => 'form-control input-sm')) }}
		</td>
		<td data-name="matRet" data-tipo="cant">
			{{ Form::text('matRet[0][cant]', null, array('class' => 'form-control input-sm', 'size' => '4' )) }}
		</td>
	</tr>
</tbody>
</table>
</div>
			</div>
			{{-- Textarea Observaciones
			===================================================== --}}
			<div class="col-md-6">
				{{ Form::label('obs', 'Observaciones', array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::textarea('obs', null, ['rows' => '3']) }}
				</div>
			</div>
		</div>
		{{-- Botones
		===================================================== --}}
		<div class="col-md-4 pull-right">
			{{-- <a href="#" class="btn btn-default ">Guardar y nuevo</a> --}}
			{{-- Form::button('Guardar', array('type' => 'submit', 'class' => 'btn btn-primary pull-right')) --}}
			{{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
		</div>
	</fieldset>
	{{ Form::close() }}
</div>
@stop
@section('modals')
{{-- Modal form DESVIADOR
===================================================== --}}
<div class="modal fade" id="modalDesviador" tabindex="-1" role="dialog" aria-labelledby="modalDesviadorLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalDesviadorLabel">Nuevo Desviador</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array(
				'url'		=>	'/desviador/ajax-create',
				'method'	=>	'post',
				'id' 		=> 	'formModalDesviador',
				'class' 	=> 	'form-horizontal')) }}
				<fieldset>
					{{-- Nombre Desviador --}}
					<div id="nombre_div" class="form-group">
						{{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('nombre', null, array('placeholder' => 'Nombre Desviador', 'class' => 'form-control')) }}
							<div class="help-block" id ="nombre_error"></div>
						</div>
					</div>
					{{-- Ubicación Desviador --}}
					<div id="km_inicio_div" class="form-group">
						{{ Form::label('km_inicio', 'Ubicación', array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('km_inicio', null, array('placeholder' => 'Kilómetro de ubicación', 'class' => 'form-control' )) }}
							<div class="help-block" id ="km_inicio_error"></div>
						</div>
					</div>
					{{-- Sector Desviador --}}
					<div id ="selectsectorDesviador_div" class="form-group">
						{{ Form::label('selectsectorDesviador', 'Sector', array('class' => 'col-sm-2 control-label')) }}
						<div >
							<div class="col-sm-10">
								<div class="controls">
									<select name="selectsectorDesviador" id="selectsectorDesviador" class="form-control">
										<option selected="selected" disabled="disabled"> Seleccione un Sector </option>
										@foreach($sectores as $sector)
										<option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
										@endforeach
									</select>
									<div class="help-block" id ="selectsectorDesviador_error"></div>
								</div>
							</div>
						</div>
					</div>
					{{-- Block Desviador --}}
					<div id ="selectblockDesviador_div" class="form-group">
						{{ Form::label('selectblockDesviador', 'Block', array('class' => 'col-sm-2 control-label')) }}
						<div >
							<div class="col-sm-10">
								<div class="controls">
									<select name="selectblockDesviador" id="selectblockDesviador" class="form-control">
										<option selected="selected" disabled="disabled"> Seleccione un Sector </option>
									</select>
									<div class="help-block" id ="selectblockDesviador_error"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						{{Form::submit('Guardar', array('class'=>'btn btn-primary'))}}
					</div>
				</fieldset>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
{{-- Modal form DESVIO
===================================================== --}}
<div class="modal fade" id="modalDesvio" tabindex="-1" role="dialog" aria-labelledby="modalDesvioLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalDesviadorLabel">Nuevo Desvío</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array(
				'url'		=>	'/desvio/ajax-create',
				'method'	=>	'post',
				'id' 		=> 	'formModalDesvio',
				'class' 	=> 	'form-horizontal')) }}
				<fieldset>
					{{-- Nombre Desvío --}}
					<div id="nombre_div" class="form-group">
						{{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
						<div class="col-sm-10">
							{{ Form::text('nombre', null, array('placeholder' => 'Nombre Desvío', 'class' => 'form-control')) }}
							<div class="help-block" id ="nombre_error"></div>
						</div>
					</div>
					{{-- Sector Desvío --}}
					<div id ="selectsectorDesvio_div" class="form-group">
						{{ Form::label('selectsectorDesvio', 'Sector', array('class' => 'col-sm-2 control-label')) }}
						<div >
							<div class="col-sm-10">
								<div class="controls">
									<select name="selectsectorDesvio" id="selectsectorDesvio" class="form-control">
										<option selected="selected" disabled="disabled"> Seleccione un Sector </option>
										@foreach($sectores as $sector)
										<option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
										@endforeach
									</select>
									<div class="help-block" id ="selectsectorDesvio_error"></div>
								</div>
							</div>
						</div>
					</div>
					{{-- Block Desvío --}}
					<div id ="selectblockDesvio_div" class="form-group">
						{{ Form::label('selectblockDesvio', 'Block', array('class' => 'col-sm-2 control-label')) }}
						<div >
							<div class="col-sm-10">
								<div class="controls">
									<select name="selectblockDesvio" id="selectblockDesvio" class="form-control">
										<option selected="selected" disabled="disabled"> Seleccione un Sector </option>
									</select>
									<div class="help-block" id ="selectblockDesvio_error"></div>
								</div>
							</div>
						</div>
					</div>
					{{-- Desviador Norte --}}
					<div id ="selectdesvio_norte_div" class="form-group">
						{{ Form::label('selectdesvio_norte', 'Desviador Norte', array('class' => 'col-sm-2 control-label')) }}
						<div >
							<div class="col-sm-10">
								<div class="controls">
									{{ Form::select('selectdesvio_norte', [], null, [ 'class' => 'form-control', 'id'=>'selectdesvio_norte', 'disabled']) }}
									<div class="help-block" id ="selectdesvio_norte_error"></div>
								</div>
							</div>
						</div>
					</div>
					{{-- Desviador Sur --}}
					<div id ="selectdesvio_sur_div" class="form-group">
						{{ Form::label('selectdesvio_sur', 'Desviador Sur', array('class' => 'col-sm-2 control-label')) }}
						<div >
							<div class="col-sm-10">
								<div class="controls">
									{{ Form::select('selectdesvio_sur', [], null, [ 'class' => 'form-control', 'id'=>'selectdesvio_sur', 'disabled']) }}
									<div class="help-block" id ="selectdesvio_sur_error"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						{{Form::submit('Guardar', array('class'=>'btn btn-primary'))}}
					</div>
				</fieldset>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
{{-- Modal form TRABAJO
=====================================================
<div class="modal fade" id="modalTrabajo" tabindex="-1" role="dialog" aria-labelledby="modalTrabajoLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalTrabajoLabel">Nuevo Trabajo</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<fieldset>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="textinput">Nombre</label>
							<div class="col-sm-10">
								<input type="text" placeholder="Nombre Trabajo" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="textinput">Oficial</label>
							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox"><abbr title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es esto?</abbr>
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tipo</label>
							<div class="col-sm-10">
								<div class="radio">
									<label>
										<input name="optionsRadios" id="optionsRadios1" value="option1" checked="" type="radio">
										Mantenimiento menor
									</label>
								</div>
								<div class="radio">
									<label>
										<input name="optionsRadios" id="optionsRadios2" value="option2" type="radio">
										Mantenimiento mayor
									</label>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div> --}}
{{-- Modal form Material Colocado
=====================================================
<div class="modal fade" id="modalMaterial" tabindex="-1" role="dialog" aria-labelledby="modalMaterialLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalMaterialLabel">Nuevo Material</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<fieldset>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="textinput">Nombre</label>
							<div class="col-sm-10">
								<input type="text" placeholder="Nombre Material" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="textinput">Código</label>
							<div class="col-sm-4">
								<input type="text" placeholder="Código del Material" class="form-control">
							</div>
							<label class="col-sm-2 control-label" for="textinput">Proveedor</label>
							<div class="col-sm-4">
								<input type="text" placeholder="Proveedor del Material" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="textinput">Unidad</label>
							<div class="col-sm-4">
								<input type="text" placeholder="Unidad del Material" class="form-control">
							</div>
							<label class="col-sm-2 control-label" for="textinput">Clase</label>
							<div class="col-sm-4">
								<input type="text" placeholder="Clase del Material" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="textinput">Oficial</label>
							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox"><abbr title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es esto?</abbr>
									</label>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>--}}
@stop
@section('js')
{{ HTML::script('//code.jquery.com/ui/1.11.2/jquery-ui.js') }}
{{ HTML::script('js/hd/create/calendar.min.js') }}
{{ HTML::script('js/hd/create/table.js') }}
{{ HTML::script('js/hd/create/create.js') }}
{{ HTML::script('js/hd/create/ajax.js') }}
{{ HTML::script('js/hd/create/formHojaDiaria.js') }}
{{ HTML::script('js/hd/create/formModalDesviador.js') }}
@stop