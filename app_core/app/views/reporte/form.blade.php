@extends('layout.landing')

@section('meta')
    <meta name="description" content="Parámetros para la creación de un formulario 2-3-4">
    <meta name="author" content="earosb">
@stop

@section('title')
    Generar formulario 2-3-4
@stop

@section('css')
    @if(Config::get('app.debug'))
        {{ HTML::style('css/awesome-bootstrap-checkbox.min.css') }}
    @else
        {{ HTML::style('https://cdnjs.cloudflare.com/ajax/libs/awesome-bootstrap-checkbox/0.3.5/awesome-bootstrap-checkbox.min.css') }}
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            {{ Form::open(array(
                'url' 		=>	'r/form',
                'method' 	=>	'post',
                'id'		=>	'formParam',
                'class' 	=> 	'form-horizontal')) }}
            <legend>Generar formularios 2-3-4</legend>
            <div class="col-md-12">
                {{-- Mes Inicio --}}
                <div class="col-md-3">
                    {{ Form::label('mes', 'Mes', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::select('mes', trans('form.months'), null, ['class'=>'form-control']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('mes') }}</p>
                </div>
                {{-- Año --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('year', 'Año', array('class' => 'control-label')) }}
                    <div class="input-group">
                        {{ Form::selectYear('year', 2015, $year, $year, ['class'=>'form-control']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <p class="text-danger">{{ $errors->first('year') }}</p>
                </div>
            </div>
            <div class="col-md-12">
                {{-- Select sector --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('sector', 'Sector', ['class' => 'control-label']) }}
                    <div class="controls">
                        {{ Form::select('sector', $sectores, null, ['class' => 'form-control']) }}
                    </div>
                    <p class="text-danger">{{ $errors->first('sector') }}</p>
                </div>
                {{-- tipo_mantenimiento --}}
                <div class="col-xs-12 col-md-3">
                    {{ Form::label('tipo_mantenimiento', 'Tipo mantenimiento', ['class' => 'control-label']) }}
                    <div class="controls">
                        <select name="tipo_mantenimiento" id="tipo_mantenimiento" class="form-control">
                            <option value="" selected="" style="display: none;">Tipo mantenimiento</option>
                            <option value="menor">Mantenimiento menor</option>
                            <option value="mayor">Mantenimiento mayor</option>
                        </select>
                    </div>
                </div>
            </div>
            {{-- Checkboxes generadores --}}
            <div class="col-md-12" id="label_generadores" style="display: none;">
                <div class="col-xs-12 col-md-6">
                    {{ Form::label('g', 'Seleccione los generadores que desea descargar') }}
                </div>
            </div>
            <div class="col-md-12" id="div_gmenor" style="display: none;">
                <div class="col-xs-12 col-md-12">
                    @foreach($tipo_mantenimiento['menor'] as $trabajo)
                        <div class="col-md-3">
                            <div class="checkbox checkbox-primary">
                                {{ Form::checkbox('g_menor[]', $trabajo->id, false, ['id' => 'g'.$trabajo->id]) }}
                                <label for="g{{ $trabajo->id }}"> {{ $trabajo->nombre }} </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12" id="div_gmayor" style="display: none;">
                <div class="col-xs-12 col-md-12">
                    @foreach($tipo_mantenimiento['mayor'] as $trabajo)
                        <div class="col-md-3">
                            <div class="checkbox checkbox-primary">
                                {{ Form::checkbox('g_mayor[]', $trabajo->id, false, ['id' => 'g'.$trabajo->id]) }}
                                <label for="g{{ $trabajo->id }}"> {{ $trabajo->nombre }} </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group">
                    {{ Form::button('Descargar', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>

        {{ Form::close() }}
    </div>
@stop

@section('js')
    <script type="text/javascript">
        $('#tipo_mantenimiento').on('change', function (e) {
            e.preventDefault();
            $('#label_generadores').show();
            var tipo_mantenimiento = e.target.value;
            if (tipo_mantenimiento == 'menor') {
                $('#div_gmenor').show();
                $('#div_gmayor').hide();
                $('#div_gmayor input[type="checkbox"]').prop('checked', false);
            } else if (tipo_mantenimiento == 'mayor') {
                $('#div_gmayor').show();
                $('#div_gmenor').hide();
                $('#div_gmenor input[type="checkbox"]').prop('checked', false);
            } else {
                alert('Opción inválida');
            }
        });
    </script>
@endsection
