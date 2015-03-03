@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de un grupo de trabajo">
    <meta name="author" content="earosb" >
@stop

@section('title')
    Nuevo Grupo
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <legend>Nuevo Grupo</legend>
            {{ Form::open(array(
                'url'		=>	'/m/grupo-trabajo',
                'method'	=>	'post',
                'class' 	=> 	'form-horizontal')) }}
            <fieldset>

                {{-- Base --}}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="base">Base</label>

                    <div class="col-sm-10">
                        <input id="base" name="base" placeholder="Base" class="form-control" type="text" required="required">

                        <p class="text-danger">{{ $errors->first('base') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                        {{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
                    </div>
                </div>

            </fieldset>
            {{ Form::close() }}

        </div>
    </div>

@stop