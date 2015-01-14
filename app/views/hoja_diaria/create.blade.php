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
						{{-- <option></option> --}}
						{{-- <option value=""></option> --}}
					</select>
				</div>
	        </div>

	        {{-- test
	        ===================================================== --}}
	    	<div class="form-group col-md-4">
				{{ Form::label('test', 'test', array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::text('test', null, array('placeholder' => 'test', 'class' => 'form-control input-sm')) }}
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
			  			<th data-resizable-column-id="7">Observaciones</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr>
			  			<td>{{ Form::text('trabajo_realizado', null, array('placeholder' => 'Trabajo N°1', 'class' => 'form-control input-sm')) }}</td>
			  			<td><select class="selectpicker" data-style="btn-inverse" id="selectubicacion" name="selectubicacion" data-live-search="true">
								{{-- <option></option> --}}
								{{-- <option value=""></option> --}}
							</select></td>

			  			<td>{{ Form::text('km_inicio', null, array('placeholder' => '', 'class' => 'form-control input-sm')) }}</td>
			  			<td>{{ Form::text('km_termino', null, array('placeholder' => '', 'class' => 'form-control input-sm')) }}</td>
			  			<td>{{ Form::text('unidad', null, array('placeholder' => '', 'class' => 'form-control input-sm')) }}</td>
			  			<td>{{ Form::text('cantidad', null, array('placeholder' => '', 'class' => 'form-control input-sm')) }}</td>
			  			<td>{{ Form::textarea('observaciones', null, ['size' => '20x2']) }}</td>
			  		</tr>
			  	</tbody>
			  </table>
	        </div>

	        {{-- Tabla materiales colocados
			===================================================== 
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
			  	</tbody>
			  </table>
	        </div> --}}

	        {{-- Tabla materiales retirados
			===================================================== 
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
					{{ Form::submit('Guardar') }}
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