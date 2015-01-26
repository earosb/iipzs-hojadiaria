@extends('layout.landing')
@section('title')
Icil-icafal - Nueva hoja diaria de trabajo
@stop
@section('css')
{{ HTML::style('css/hd/create.css') }}
{{ HTML::style('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') }}
@stop
@section('content')
<div class="row">
	{{ Form::open(array(
	'url' 		=> 'hd',
	'method' 	=> 'post',
	'id'		=>	'formHojaDiaria',
	'class' 	=> 'form-horizontal')) }}
	<fieldset>
		<legend style="float:left;">Nueva hoja diaria de trabajo
			<div class="form-group" id="fecha_div">
				{{ Form::text('fecha', null, ['class'=>'input-sm', 'placeholder'=>'Ingrese Fecha', 'id'=>'fecha', 'style'=>'margin:15px;']) }}
				<span class="glyphicon glyphicon-calendar"></span>
				<div class="help-block" id ="fecha_error"></div>
			</div>
			{{-- Botón "flotante"
			===================================================== --}}
			<div class="btn-group pull-right">
				<button type="button" class=" btn btn-default dropdown-toggle glyphicon glyphicon-cog " data-toggle="dropdown" aria-expanded="false">
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
		{{-- Select sector
		===================================================== --}}
		<div id="selectsector_div" class="form-group col-md-4">
			{{ Form::label('selectsector', 'Sector', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::select('selectsector', $sectores, null, ['class'=>'myselect', 'id'=>'selectsector']) }}
				<div class="help-block" id ="selectsector_error"></div>
			</div>
		</div>
		{{-- Select block
		===================================================== --}}
		<div id="selectblock_div" class="form-group col-md-4">
			{{ Form::label('selectblock', 'Block', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::select('selectblock', $blocks, null, [ 'class' => 'myselect', 'id'=>'selectblock' ]) }}
				<div class="help-block" id ="selectblock_error"></div>
			</div>
		</div>
		{{-- Grupo Vía
		===================================================== --}}
		<div id="selectgrupos_div" class="form-group col-md-4">
			{{ Form::label('selectgrupos', 'Grupo Vía', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::select('selectgrupos', $grupos, null, [ 'class' => 'myselect', 'id'=>'selectgrupos' ]) }}
				<div class="help-block" id ="selectgrupos_error"></div>
			</div>
		</div>
		{{-- Tabla trabajos realizados
		===================================================== --}}
		<div class="form-group col-md-12">
			<table class="table table-bordered table-striped" id="tab_trabajados">
				<thead>
					<tr>
						<th>#</th>
						<th>Trabajos Ejecutados</th>
						<th>Desvío / Desviador</th>
						<th>Km inicio</th>
						<th>Km término</th>
						<th>Uni.</th>
						<th>Cant</th>
						<th class="text-center"><a id="add_row_trabajos" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a></th>
					</tr>
				</thead>
				<tbody>
					<tr id='addr0' data-id="0" class="hidden">
						<td data-name="id">0</td>
						<td data-name="selecttrabajo[">
							{{ Form::select('selecttrabajo[0]', $trabajos, null, [ 'class'=>'myselect selecttrabajo']) }}
						</td>
						<td data-name="selectubicacion[">
							{{ Form::select('selectubicacion[0]', ['Seleccione Sector y Block'], null, [ 'class'=>'myselect selectubicacion']) }}
						</td>
						<td data-name="km_inicio[">
							{{ Form::text('km_inicio[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' ,'maxlength' => '6')) }}
						</td>
						<td data-name="km_termino[">
							{{ Form::text('km_termino[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1','maxlength' => '6' )) }}
						</td>
						<td data-name="unidad[">
							{{ Form::text('unidad[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' )) }}
						</td>
						<td data-name="cantidad[">
							{{ Form::text('cantidad[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' )) }}
						</td>
						<td data-name="del">
							<button nam="del0" class='btn btn-xs glyphicon glyphicon-remove row-remove'></button>
						</td>
					</tr>
				</tbody>
			</table>
		{{-- Tabla materiales colocados
		=====================================================
		<div class="form-group col-md-12">
			<div class="form-group col-md-6">
				<table class="table table-bordered table-striped" id="tab_material_colocado">
					<thead>
						<tr>
							<th >Materiales Colocados</th>
							<th >Cantidad</th>
							<th class="text-center"><a id="add_row_matCol" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a></th>
						</tr>
					</thead>
					<tbody>
						<tr id='addrMatCol0' data-id="0" class="hidden">
							<td data-name="matColNom">
								{{ Form::text('matColNom0', null, array('class' => 'form-control', 'id' => 'matColNom0')) }}
							</td>
							<td data-name="matColNum">
								{{ Form::text('matColNum0', null, array('class' => 'form-control', 'id' => 'matColNum0', 'size' => '4')) }}
							</td>
							<td class="text-center" data-name="delMatCol">
								<button nam"delMatCol0" class='btn btn-xs glyphicon glyphicon-remove row-remove'></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div> --}}
			{{-- Tabla materiales retirados
			=====================================================
			<div class="form-group col-md-6 pull-right">
				<table class="table table-bordered table-striped table-sortable">
					<thead>
						<tr>
							<th >Materiales Retirados</th>
							<th >Cantidad</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td data-name="matRetNom">{{ Form::text('matRetNom0', null, array('class' => 'form-control input-sm')) }}</td>
							<td data-name="matRetNum">{{ Form::text('matRetNum0', null, array('class' => 'form-control input-sm', 'size' => '4' )) }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div> --}}
		{{-- Textarea Observaciones
		===================================================== --}}
		<div class="from-group col-md 6">
			{{ Form::label('selectblock', 'Observaciones', array('class' => 'control-label')) }}
			<div class="controls">
				{{ Form::textarea('obs', null, ['size' => '40x3']) }}
			</div>
		</div>
	</div>
	<legend></legend>
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
								{{ Form::select('selectsectorDesviador', $sectores, null, [ 'class'=>'form-control', 'id'=>'selectsectorDesviador']) }}
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
								{{ Form::select('selectblockDesviador', $blocks, null, [ 'class' => 'form-control', 'id'=>'selectblockDesviador']) }}
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
								{{ Form::select('selectsectorDesvio', $sectores, null, [ 'class'=>'form-control', 'id'=>'selectsectorDesvio']) }}
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
								{{ Form::select('selectblockDesvio', $blocks, null, [ 'class' => 'form-control', 'id'=>'selectblockDesvio']) }}
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
{{ HTML::script('js/hd/create/create.js') }}
{{ HTML::script('js/hd/create/ajax.js') }}
{{ HTML::script('js/hd/create/calendar.js') }}
{{ HTML::script('js/hd/create/table.js') }}
{{ HTML::script('js/hd/create/formHojaDiaria.js') }}
@stop