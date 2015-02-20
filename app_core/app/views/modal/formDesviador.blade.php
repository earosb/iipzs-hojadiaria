{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 04-02-15
 * Time: 22:51
--}}

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
                                    <select name="selectsectorDesviador" id="selectsectorDesviador" class="form-control">
                                        <option selected="selected" disabled="disabled"> Seleccione un Sector </option>
                                        @foreach($sectores as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                        @endforeach
                                    </select>
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
                                    <select name="selectblockDesviador" id="selectblockDesviador" class="form-control">
                                        <option selected="selected" disabled="disabled"> Seleccione un Sector </option>
                                    </select>
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

{{ HTML::script('js/hd/modal/formDesviador.js') }}