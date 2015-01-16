@extends('layout.landing')

@section('title')
    Icil-icafal - Nueva hoja diaria de trabajo
@stop

@section('css')
	{{ HTML::style('css/bootstrap-select.min.css') }}
	{{ HTML::style('css/hd/create.css') }}
	{{ HTML::style('//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css') }}
	
@stop
@section('alert')
	<div class="alert alert-dismissable alert-success" style="display:none;">
	  <button type="button" class="close" data-dismiss="alert">×</button>
	  <p>La hoja diaria fue ingresada correctamente!, <a href="#" class="alert-link">Ver</a>.</p>
	</div>

	<div id="msg_error" class="alert alert-dismissable alert-danger" style="display:none;">
	  <button type="button" class="close" data-dismiss="alert">×</button>
	  <strong>Error al obtener datos!</strong> Verifique su conexión a Internet.
	</div>
@stop
 
@section('content')
	<div class="row">
        {{ Form::open(array('url' => 'hd', 'method' => 'post', 'class' => 'form-horizontal')) }}
		  <fieldset>
		    <legend>Nueva hoja diaria de trabajo
		    		{{ Form::text('fecha', null, array('class' => 'input-sm', 'placeholder' => 'Ingrese Fecha', 'id' => 'fecha' , 'style' => 'margin:15px;')) }}
		    </legend>

		    {{-- Botón "flotante"
		    ===================================================== --}}
			<div class="btn-group pull-right">
			  <button type="button" class=" btn btn-default dropdown-toggle glyphicon glyphicon-cog " data-toggle="dropdown" aria-expanded="false">
			  </button>
			  <ul class="dropdown-menu" role="menu">
			    <li><a href="#">Nuevo Desviador</a></li>
			    <li><a href="#">Nuevo Desvío</a></li>
			    <li class="divider"></li>
			    <li><a href="#">Nuevo Trabajo</a></li>
			  </ul>
			</div>

		    {{-- Select sector
		    ===================================================== --}}
	    	<div class="form-group col-md-4">
				{{ Form::label('selectsector', 'Sector', array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::select('selectsector', $sectores, null, [ 'class'=>'selectpicker', 'id'=>'selectsector', 'data-size'=>'6']) }}
				</div>
	        </div>

	        {{-- Select block
	        ===================================================== --}}
	    	<div class="form-group col-md-4">
				{{ Form::label('selectblock', 'Block', array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::select('selectblock', [''], null, [ 'class' => 'selectpicker', 'id'=>'selectblock', 'data-live-search'=>'true', 'data-size'=>'6']) }}
				</div>
	        </div>

	        {{-- test
	        ===================================================== --}}
	    	<div class="form-group col-md-4">
				{{ Form::label('test', 'Test', array('class' => 'control-label')) }}
				<div class="controls">
					<p>...</p>
				</div>
			</div>

			{{-- Tabla trabajos realizados
			===================================================== --}}
	        <div class="form-group col-md-12">
			  <table class="table table-bordered table-striped" id="tab_trabajados">
			  	<thead>
			  		<tr>
			  			<th>Trabajos Realizados</th>
			  			<th>Desvío / Desviador</th>
			  			<th>Km inicio</th>
			  			<th>Km término</th>
			  			<th>Unidad</th>
			  			<th>Cantidad</th>
			  			<th class="text-center"><a id="add_row_trabajos" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr id='addr0' data-id="0" class="hidden" >
			  			<td data-name="trabajo[">
			  			
			  			{{ Form::select('selecttrabajo[0]', $trabajos, null, [ 'class'=>'selecttrabajo', 'id'=>'selecttrabajo[0]']) }}</td>
						<td data-name="selectubicacion[">
						{{ Form::select('selectubicacion[0]', ['Seleccione Sector y Block'], null, [ 'class'=>'selectubicacion', 'id'=>'selectubicacion[0]']) }}</td>
			  			<td data-name="km_inicio[">{{ Form::text('km_inicio[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' ,'maxlength' => '6')) }}</td>
			  			<td data-name="km_termino[">{{ Form::text('km_termino[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1','maxlength' => '6' )) }}</td>
			  			<td data-name="unidad[">{{ Form::text('unidad[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' )) }}</td>
			  			<td data-name="cantidad[">{{ Form::text('cantidad[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' )) }}</td>
			  			<td class="text-center" data-name="del"><button nam"del0" class='btn btn-xs glyphicon glyphicon-remove row-remove'></button></td>
			  		</tr>
			  	</tbody>
			  </table>

			  <div class="from-group col-md 6">
			  	{{ Form::label('selectblock', 'Observaciones', array('class' => 'control-label')) }}
			  	<div class="controls">
			  		{{ Form::textarea('observaciones', null, ['size' => '40x3']) }}
		  		</div>
			  </div>
			  
	        </div>

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

	        <legend></legend>

			{{-- Botones
			===================================================== --}}
	        <div class="form-group col-md-12">
	        	<div class="form-group col-md-4 pull-right">
		        	<a href="#" class="btn btn-default ">Guardar y nuevo</a>
					{{ Form::button('Guardar', array('type' => 'submit', 'class' => 'btn btn-success pull-right')) }}
					{{-- Form::submit('Guardar', array('class' => 'btn btn-success')) --}}
		        </div>
	        </div>
		  </fieldset>
		{{ Form::close() }}
    </div>
@stop

@section('js')
	{{ HTML::script('js/bootstrap-select.min.js') }}
	{{ HTML::script('js/hd/create.js') }}
	{{ HTML::script('//code.jquery.com/ui/1.11.2/jquery-ui.js') }}
@stop