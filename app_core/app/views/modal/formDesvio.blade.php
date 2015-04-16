{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 04-02-15
 * Time: 22:46
--}}

{{-- Modal form DESVIO
===================================================== --}}
<div class="modal fade" id="modalDesvio" tabindex="-1" role="dialog" aria-labelledby="modalDesvioLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalDesviadorLabel">Nuevo Desvío</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array(
                'url'		=>	'desvio',
                'method'	=>	'post',
                'id' 		=> 	'formModalDesvio',
                'class' 	=> 	'form-horizontal')) }}
                <fieldset>
                    {{-- Nombre Desvío --}}
                    <div id="nombre_div" class="form-group">
                        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10">
                            {{ Form::text('nombre', null, array('placeholder' => 'Nombre Desvío', 'class' => 'form-control')) }}
                            <div class="help-block" id="nombre_error"></div>
                        </div>
                    </div>
                    {{-- Sector Desvío --}}
                    <div id="selectsectorDesvio_div" class="form-group">
                        {{ Form::label('selectsectorDesvio', 'Sector', array('class' => 'col-sm-2 control-label')) }}
                        <div>
                            <div class="col-sm-10">
                                <div class="controls">
                                    <select name="selectsectorDesvio" id="selectsectorDesvio" class="form-control">
                                        <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                        @foreach($sectores as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                        @endforeach
                                    </select>

                                    <div class="help-block" id="selectsectorDesvio_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Block Desvío --}}
                    <div id="selectblockDesvio_div" class="form-group">
                        {{ Form::label('selectblockDesvio', 'Block', array('class' => 'col-sm-2 control-label')) }}
                        <div>
                            <div class="col-sm-10">
                                <div class="controls">
                                    <select name="selectblockDesvio" id="selectblockDesvio" class="form-control">
                                        <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                    </select>

                                    <div class="help-block" id="selectblockDesvio_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Desviador Norte --}}
                    <div id="selectdesviador_norte_div" class="form-group">
                        {{ Form::label('selectdesviador_norte', 'Desviador Norte', array('class' => 'col-sm-2 control-label')) }}
                        <div>
                            <div class="col-sm-10">
                                <div class="controls">
                                    {{ Form::select('selectdesviador_norte', [], null, [ 'class' => 'form-control', 'id'=>'selectdesviador_norte', 'disabled']) }}
                                    <div class="help-block" id="selectdesviador_norte_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Desviador Sur --}}
                    <div id="selectdesviador_sur_div" class="form-group">
                        {{ Form::label('selectdesviador_sur', 'Desviador Sur', array('class' => 'col-sm-2 control-label')) }}
                        <div>
                            <div class="col-sm-10">
                                <div class="controls">
                                    {{ Form::select('selectdesviador_sur', [], null, [ 'class' => 'form-control', 'id'=>'selectdesviador_sur', 'disabled']) }}
                                    <div class="help-block" id="selectdesviador_sur_error"></div>
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

{{--{{ HTML::script('js/hd/modal/formDesvio.js') }}--}}
{{ HTML::script('js/min/1424470502889.min.js') }}