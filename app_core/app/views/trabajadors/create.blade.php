@extends('layout.landing')

@section('title')
    Icil-icafal - Nuevo Trabajador
@stop
	
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
		    <legend>Nueva hoja diaria de trabajo     
		    		<input type="text" placeholder="Ingrese Fecha" style="margin:15px;">
		    </legend>
			
			{{ Form::open(array('route' => 'route.name', 'method' => 'POST')) }}
				<ul>
					<li>
						{{ Form::label('rut', 'Rut:') }}
						{{ Form::text('rut') }}
					</li>
					<li>
						{{ Form::label('nombre', 'Nombre:') }}
						{{ Form::text('nombre') }}
					</li>
					<li>
						{{ Form::label('apellido_p', 'Apellido_p:') }}
						{{ Form::text('apellido_p') }}
					</li>
					<li>
						{{ Form::label('apellido_m', 'Apellido_m:') }}
						{{ Form::text('apellido_m') }}
					</li>
					<li>
						{{ Form::label('jefe_grupo', 'Jefe_grupo:') }}
						{{ Form::text('jefe_grupo') }}
					</li>
					<li>
						{{ Form::submit() }}
					</li>
				</ul>
			{{ Form::close() }}
		    
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