@extends('layout.landing')

@section('title')
    Icil-icafal - Hello
@stop

@section('css')
	{{ HTML::style('css/bootstrap-select.min.css') }}
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
		    <!--Select sector-->
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
	        <!--Select block-->
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
	        <!--Select estación-->
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

	        <!--Select sector-->
	    	<div class="form-group col-md-4">
				<label class="control-label" for="selectsector">Desvío</label>
				<div class="controls">
					<select class="selectpicker" id="selectsector" name="selectsector" class="input-xlarge">
						<option>Seleccione</option>
						<option>Local</option>
						<option>Dv 1</option>
						<option>Dv 2</option>
					</select>
				</div>
	        </div>
	        <!--Select desviador-->
	    	<div class="form-group col-md-4">
				<label class="control-label" for="selectblock">Desviador</label>
				<div class="controls">
					<select class="selectpicker" id="selectblock" name="selectblock" class="input-xlarge">
						<optgroup label="Blocks">
						<option>Seleccione</option>
						<option>DVR 101</option>
						<option>DVR 102</option>
					</select>
				</div>
	        </div>

	        <!--col vacía-->
	    	<div class="form-group col-md-4">
				<label class="control-label" for="selectblock">Desviador</label>
				<div class="controls">
					<select class="selectpicker" id="selectblock" name="selectblock" class="input-xlarge">
						<optgroup label="Blocks">
						<option>Seleccione</option>
						<option>DVR 101</option>
						<option>DVR 102</option>
					</select>
				</div>
	        </div>

		    <div class="form-group">
		      <label for="inputEmail" class="col-lg-2 control-label">Email</label>
		      <div class="col-lg-10">
		        <input class="form-control" id="inputEmail" placeholder="Email" type="text">
		      </div>
		    </div>
		    <div class="form-group">
		      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
		      <div class="col-lg-10">
		        <input class="form-control" id="inputPassword" placeholder="Password" type="password">
		        <div class="checkbox">
		          <label>
		            <input type="checkbox"> Checkbox
		          </label>
		        </div>
		      </div>
		    </div>
		    <div class="form-group">
		      <label for="textArea" class="col-lg-2 control-label">Textarea</label>
		      <div class="col-lg-10">
		        <textarea class="form-control" rows="3" id="textArea"></textarea>
		        <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-lg-2 control-label">Radios</label>
		      <div class="col-lg-10">
		        <div class="radio">
		          <label>
		            <input name="optionsRadios" id="optionsRadios1" value="option1" checked="" type="radio">
		            Option one is this
		          </label>
		        </div>
		        <div class="radio">
		          <label>
		            <input name="optionsRadios" id="optionsRadios2" value="option2" type="radio">
		            Option two can be something else
		          </label>
		        </div>
		      </div>
		    </div>
		    <div class="form-group">
		      <label for="select" class="col-lg-2 control-label">Selects</label>
		      <div class="col-lg-10">
		        <select class="form-control" id="select">
		          <option>1</option>
		          <option>2</option>
		          <option>3</option>
		          <option>4</option>
		          <option>5</option>
		        </select>
		        <br>
		        <select multiple="" class="form-control">
		          <option>1</option>
		          <option>2</option>
		          <option>3</option>
		          <option>4</option>
		          <option>5</option>
		        </select>
		      </div>
		    </div>
		    <div class="form-group">
		      <div class="col-lg-10 col-lg-offset-2">
		        <button class="btn btn-default">Cancel</button>
		        <button type="submit" class="btn btn-primary">Submit</button>
		      </div>
		    </div>
		  </fieldset>
		</form>
    </div>
@stop

@section('js')
	{{ HTML::script('js/bootstrap-select.min.js') }}
@stop