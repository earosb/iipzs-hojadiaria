{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 04-02-15
 * Time: 23:14
--}}

{{-- Modal form Material Retirado
===================================================== --}}
<div class="modal fade" id="modalMaterialRet" tabindex="-1" role="dialog" aria-labelledby="modalMaterialRetLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalMaterialRetLabel">Nuevo Material Retirado</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array(
                'url'		=>	'/material-retirado',
                'method'	=>	'post',
                'id' 		=> 	'formMaterialRetirado',
                'class' 	=> 	'form-horizontal')) }}
                <fieldset>
                    {{-- Nombre del material --}}
                    <div id="nombre_div" class="form-group">
                        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10">
                            {{ Form::text('nombre', null, array('placeholder' => 'Nombre Material', 'class' => 'form-control')) }}
                            <div class="help-block" id="nombre_error"></div>
                        </div>
                    </div>

                    {{-- Checkbox esOficial --}}
                    <div id="es_oficial_div" class="form-group">
                        {{ Form::label('es_oficial', 'Form 4', array('class' => 'col-sm-2 control-label')) }}
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('es_oficial', 'true'); }}
                                    <abbr title="Quiere decir que será incluido en Formulario 4">¿Qué es esto?</abbr>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        {{ Form::submit('Guardar', array('class'=>'btn btn-primary')) }}
                    </div>

                </fieldset>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

{{ HTML::script('dist/js/formmaterialret.js') }}