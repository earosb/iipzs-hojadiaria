@extends('layout.landing')

@section('title')
    Icil-icafal - Nueva hoja diaria de trabajo
@stop

@section('css')
	{{ HTML::style('css/bootstrap-select.min.css') }}
	{{ HTML::style('css/jquery.resizableColumns.css') }}
	{{ HTML::style('css/trabajos/create.css') }}
	
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
        {{ Form::open(array('url' => 'trabajos/store', 'method' => 'post', 'class' => 'form-horizontal')) }}
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
						<option class="special" value="empty">Seleccione un sector</option>
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
						{{-- <option value=""></option> --}}
					</select>
				</div>
	        </div>

	        {{-- Div para imprimir pruebas
	        ===================================================== --}}
	    	<div class="form-group col-md-4">
				{{ Form::label('test', '', array('class' => 'control-label')) }}
				<div class="controls">
					
				</div>
	        </div>

			{{-- Tabla trabajos realizados
			===================================================== --}}
	        <div class="form-group col-md-12">
			  <table class="table table-bordered table-striped" data-resizable-columns-id="trabajos-table">
			  	<thead>
			  		<tr>
			  			<th data-resizable-column-id="1">Trabajos Realizados</th>
			  			<th data-resizable-column-id="2">Desvío / Desviador</th>
			  			<th data-resizable-column-id="3">Km inicio</th>
			  			<th data-resizable-column-id="4">Km término</th>
			  			<th data-resizable-column-id="5">Unidad</th>
			  			<th data-resizable-column-id="6">Cantidad</th>
			  			<th data-resizable-column-id="7">Comentarios</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><select class="selectpicker" data-style="btn-inverse" id="selectestacion" name="selectestacion" class="input-xlarge">
								<option>Vía Principal</option>
								<optgroup label="Desvíos">
								<option>Local</option>
								<option>Dv 101</option>
								<option>Dv 103</option>
								<optgroup label="Desviadores">
								<option>DVR 101</option>
								<option>DVR 102</option>
								<option>DVR 103</option>
								<optgroup label="Ramales">
								<option>Coigue - Nacimiento</option>
							</select></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><select class="selectpicker" data-style="btn-inverse" id="selectestacion" name="selectestacion" class="input-xlarge">
								<option>Vía Principal</option>
								<optgroup label="Desvíos">
								<option>Local</option>
								<option>Dv 101</option>
								<option>Dv 103</option>
								<optgroup label="Desviadores">
								<option>DVR 101</option>
								<option>DVR 102</option>
								<option>DVR 103</option>
								<optgroup label="Ramales">
								<option>Coigue - Nacimiento</option>
							</select></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  	</tbody>
			  </table>
	        </div>

	        {{-- Tabla materiales colocados
			===================================================== --}}
			<div class="form-group col-md-12">
	        <div class="form-group col-md-6">
			  <table class="table table-bordered table-striped" data-resizable-columns-id="materiales-table">
			  	<thead>
			  		<tr>
			  			<th data-resizable-column-id="1">Materiales Colocados</th>
			  			<th data-resizable-column-id="2">Cantidad</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  	</tbody>
			  </table>
	        </div>

	        {{-- Tabla materiales retirados
			===================================================== --}}
	        <div class="form-group col-md-6 pull-right">
			  <table class="table table-bordered table-striped" data-resizable-columns-id="materiales-retirados-table">
			  	<thead>
			  		<tr>
			  			<th data-resizable-column-id="1">Materiales Retirados</th>
			  			<th data-resizable-column-id="2">Cantidad</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  	</tbody>
			  </table>
	        </div>
	        </div>

	        {{-- Tabla Asistencia trabajadores
			===================================================== --}}
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
	        </div>

			{{-- Botones
			===================================================== --}}
	        <div class="form-group col-md-12">
	        	<div class="form-group col-md-4 pull-right">
		        	<a href="#" class="btn btn-default ">Guardar y nuevo</a>
					<a href="#" class="btn btn-success pull-right">Guardar</a>
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
	{{ HTML::script('js/trabajos/create.js') }}

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