@extends('layout.landing')

@section('title')
    Icil-icafal - Hello
@stop

@section('css')
	{{ HTML::style('css/bootstrap-select.min.css') }}
	{{ HTML::style('css/jquery.resizableColumns.css') }}
	
@stop

@section('alert')
	<div class="alert alert-dismissable alert-success">
	  <button type="button" class="close" data-dismiss="alert">×</button>
	  <p>Best check yo self, you're not looking too good. Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, <a href="#" class="alert-link">vel scelerisque nisl consectetur et</a>.</p>
	</div>
@stop

@section('content')
	<div class="row">
        <form class="form-horizontal">
		  <fieldset>
		    <legend>Nueva hoja diaria de trabajo</legend>
		    {{-- Select sector  --}}
	    	<div class="form-group col-md-4">
				<label class="control-label" for="selectsector">Sector</label>
				<div class="controls">
					<select class="selectpicker" id="selectsector" name="selectsector" class="input-xlarge">
						<option>San Rosendo - Victoria</option>
						<option>Victoria - Temuco</option>
						<option>Temuco - Mariquina</option>
						<option>Mariquina - Osorno</option>
						<option>Osorno - La Paloma</option>
					</select>
				</div>
	        </div>
	        {{-- Select block  --}}
	    	<div class="form-group col-md-4">
				<label class="control-label" for="selectblock">Block</label>
				<div class="controls">
					<select class="selectpicker" id="selectblock" name="selectblock" class="input-xlarge">
						<optgroup label="Blocks">
						<option>San Rosendo - Laja</option>
						<option>Laja - Diuqín</option>
						<option>Diuqín - Millantú</option>
						<option>Millantú - Santa Fe</option>
						<option>Santa Fe - Coigue</option>
						<optgroup label="Ramales">
						<option>Coigue - Nacimiento</option>
					</select>
				</div>
	        </div>
	        {{-- Select estación  --}}
	    	<div class="form-group col-md-4">
				<label class="control-label" for="selectestacion">Estación</label>
				<div class="controls">
					<select class="selectpicker" id="selectestacion" name="selectestacion" class="input-xlarge">
						<option>Seleccione</option>
						<option>Victoria - Temuco</option>
						<option>Temuco - Mariquina</option>
						<option>Mariquina - Osorno</option>
						<option>Osorno - La Paloma</option>
					</select>
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
			  			<td><select class="selectpicker" id="selectestacion" name="selectestacion" class="input-xlarge">
								<option>Seleccione</option>
								<optgroup label="Desvíos">
								<option>Local</option>
								<option>Dv 101</option>
								<option>Dv 103</option>
								<optgroup label="Desviadores">
								<option>DVR 101</option>
								<option>DVR 102</option>
								<option>DVR 103</option>
							</select></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  		</tr>
			  		<tr>
			  			<td><input class="form-control input-sm" id="inputEmail" placeholder="" type="text"></td>
			  			<td><select class="selectpicker" id="selectestacion" name="selectestacion" class="input-xlarge">
								<option>Seleccione</option>
								<optgroup label="Desvíos">
								<option>Local</option>
								<option>Dv 101</option>
								<option>Dv 103</option>
								<optgroup label="Desviadores">
								<option>DVR 101</option>
								<option>DVR 102</option>
								<option>DVR 103</option>
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

	        {{-- Tabla materiales
			===================================================== --}}
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

			{{-- Botones
			===================================================== --}}
	        <div class="form-group col-md-12">
	        	<div class="form-group col-md-3 pull-right">
		        	<a href="#" class="btn btn-default ">Guardar y nuevo</a>
					<a href="#" class="btn btn-success pull-right">Guardar</a>
		        </div>
	        </div>

		  </fieldset>
		</form>
    </div>
@stop

@section('js')
	{{ HTML::script('js/bootstrap-select.min.js') }}
	{{ HTML::script('js/store.min.js') }}
	{{ HTML::script('js/jquery.resizableColumns.min.js') }}

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