@extends('layout.landing')

@section('title')
    Icil-icafal - Nueva hoja diaria de trabajo
@stop

@section('css')
	{{ HTML::style('css/bootstrap-select.min.css') }}
	{{ HTML::style('css/jquery.resizableColumns.css') }}
	{{ HTML::style('css/hd/create.css') }}
	
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
		    		<input type="text" placeholder="Ingrese Fecha" style="margin:15px;">
		    </legend>

		    {{-- Select sector
		    ===================================================== --}}
	    	<div class="form-group col-md-4">
				{{ Form::label('selectsector', 'Sector', array('class' => 'control-label')) }}
				<div class="controls">
					<select class="selectpicker" id="selectsector" name="selectsector" data-size="6">
						<option value="empty"></option>
						@foreach ($sectores as $sector)
			              @if ($sector)
			                <option value={{ $sector->id }}
			                	data-subtext="{{ $sector->estacion_inicio }} - {{ $sector->estacion_termino }}">
			                	{{ $sector->nombre }}
		                	</option>
			              @endif
			            @endforeach
					</select>
				</div>
	        </div>

	        {{-- Select block
	        ===================================================== --}}
	    	<div class="form-group col-md-4">
				{{ Form::label('selectblock', 'Block', array('class' => 'control-label')) }}
				<div class="controls">
					<select class="selectpicker" id="selectblock" name="selectblock" data-live-search="true" data-size="6">
						{{-- <option></option> --}}
						{{-- <option value=""></option> --}}
					</select>
				</div>
	        </div>

	        {{-- test
	        ===================================================== 
	    	<div class="form-group col-md-4">
				{{ Form::label('test', 'test', array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::text('test', null, array('placeholder' => 'test', 'class' => 'form-control input-sm')) }}
				</div>
	        </div>--}}

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
			  			<th>Observaciones</th>
			  			<th class="text-center"><a id="add_row_trabajos" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr id='addr0' data-id="0" class="hidden" >
			  			<td data-name="trabajo[">{{ Form::text('trabajo[0]', null, array('placeholder' => 'Trabajo N°1', 'class' => 'form-control')) }}</td>

						<td data-name="selectubicacion[">{{ Form::select('selectubicacion[0]', ['Seleccione Sector y Block'], null, [ 'class' => 'selectubicacion']) }}</td>
			  			<td data-name="km_inicio[">{{ Form::text('km_inicio[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' ,'maxlength' => '6')) }}</td>
			  			<td data-name="km_termino[">{{ Form::text('km_termino[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1','maxlength' => '6' )) }}</td>
			  			<td data-name="unidad[">{{ Form::text('unidad[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' )) }}</td>
			  			<td data-name="cantidad[">{{ Form::text('cantidad[0]', null, array('placeholder' => '', 'class' => 'form-control', 'size' => '1' )) }}</td>
			  			<td data-name="obs[">{{ Form::textarea('obs[0]', null, ['size' => '20x2']) }}</td>
			  			<td class="text-center" data-name="del"><button nam"del0" class='btn btn-xs glyphicon glyphicon-remove row-remove'></button></td>
			  		</tr>
			  	</tbody>
			  </table>
			  
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

	        {{-- Tabla Asistencia trabajadores
			===================================================== 
	        <div class="form-group col-md-12 " style="display:block;">
				<h3>Asistencia</h3>
			  <table class="table table-bordered table-striped" data-resizable-columns-id="asistencia-table">
			  	<thead>
			  		<tr>
			  			<th data-resizable-column-id="1">Nombre</th>
			  			<th data-resizable-column-id="2">Cargo</th>
			  			<th data-resizable-column-id="3">Entrada</th>
			  			<th data-resizable-column-id="4">Salida</th>
			  			<th data-resizable-column-id="5">Horas extra</th>
			  			<th data-resizable-column-id="6">Obs Asistencia</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><select class="">
								<option>Operador</option>
								<option>Jefe</option>
								<option>Obrero</option>
								<option>etc...</option>
							</select></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><select class="">
								<option>Operador</option>
								<option>Jefe</option>
								<option>Obrero</option>
								<option>etc...</option>
							</select></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  	</tbody>
			  </table>
	        </div>--}}

			{{-- Botones
			===================================================== --}}
	        <div class="form-group col-md-12">
	        	<div class="form-group col-md-4 pull-right">
		        	<a href="#" class="btn btn-default ">Guardar y nuevo</a>
					{{-- Form::button('Guardar', array('type' => 'submit', 'class' => 'btn btn-success pull-right')) --}}
					{{ Form::submit('Guardar', array('class' => 'btn btn-success')) }}
		        </div>
	        </div>
		  </fieldset>
		{{ Form::close() }}
    </div>
@stop

@section('js')
	{{ HTML::script('js/bootstrap-select.min.js') }}
	{{ HTML::script('js/store.min.js') }}
	{{ HTML::script('js/jquery.resizableColumns.min.js') }}
	{{ HTML::script('js/hd/create.js') }}

	<script type="text/javascript">
	    init()
	    function init() {
	        if (!store.enabled) {
	            alert('Local storage is not supported by your browser. Please disable "Private Mode", or upgrade to a modern browser.')
	            return
	        }
	        var user = store.get('user')
	        // ... and so on ...
	    }
	    $(function(){
			$("table").resizableColumns({
				store: store
			});
		});
	</script>

@stop