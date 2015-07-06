@extends('layout.landing')

@section('angularjs')
    ng-app
@stop

@section('meta')
    <meta name="description" content="Planificación de trabajos">
    <meta name="author" content="earosb">
@stop

@section('css')
    {{--{{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css') }}--}}
    {{ HTML::style('css/awesome-bootstrap-checkbox.min.css') }}
@stop

@section('title')
    Programar Angular
@stop

@section('content')
    <h3>Programar trabajos</h3>

    <div ng-controller="TrabajoController">
        <table class="table">
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" ng-model="formData.causa" placeholder="Causal"
                           required="required">
                    <ul>
                        <li ng-repeat="error in errors">@{{ error.causa }}</li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="form-group">
                    {{ Form::select('trabajo_id', $trabajos, null, ['class' => 'form-control', 'ng-model' => 'formData.trabajo_id', 'required' => 'required']) }}
                    <ul>
                        <li ng-repeat="error in errors">@{{ error.trabajo_id }}</li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" ng-model="formData.km_inicio"
                           placeholder="km inicio"
                           required="required">
                    <ul>
                        <li ng-repeat="error in errors">@{{ error.km_inicio }}</li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" ng-model="formData.km_termino"
                           placeholder="km término"
                           required="required">
                    <ul>
                        <li ng-repeat="error in errors">@{{ error.km_termino }}</li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" ng-model="formData.cantidad"
                           placeholder="Cantidad"
                           required="required">
                    <ul>
                        <li ng-repeat="error in errors">@{{ error.cantidad }}</li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" ng-click="addTrabajo()"
                           value="Agregar"/>
                </div>
            </td>
        </table>

        {{--<p>Total trabajos: @{{ getTotaltrabajos() }}</p>--}}

        <table class="table table-condensed table-bordered table-striped table-hover">
            <tr>
                <th></th>
                <th>Causal</th>
                <th>Trabajo</th>
                <th>Unidad</th>
                <th>Km Inicio</th>
                <th>Km Término</th>
                <th>Cantidad</th>
                <th class="text-center">Herramientas</th>
            </tr>
            <tr ng-repeat="(key, t) in trabajos | orderBy:'km_inicio'" class="@{{ t.status }}"
                ng-click="editModalTrabajo()"
                data-key="@{{ key }}">
                <td class="text-center">
                    <input type="checkbox" name="check" value="@{{ t.id }}">
                </td>
                <td>@{{ t.causa }}</td>
                <td>@{{ t.nombre }}</td>
                <td>@{{ t.unidad }}</td>
                <td>@{{ t.km_inicio }}</td>
                <td>@{{ t.km_termino }}</td>
                <td>@{{ t.cantidad }}</td>
                <td class="text-center">
                    <a ng-click="removeTrabajo()" href=""><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        </table>

        <div class="modal fade" id="modalPlanificarTrabajo" tabindex="-1" role="dialog"
             aria-labelledby="modalPlanificarTrabajoLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><a href="#" class="btn btn-primary btn-xs">Mini button</a></span></button>--}}
                        <h4 class="modal-title" id="modalPlanificarTrabajoLabel">@{{ tAux.nombre }}</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group col-sm-12">
                                <label for="grupo_trabajo">Grupo</label>
                                <select name="grupo_trabajo" id="grupo_trabajo" class="form-control">
                                    <option value="1">Reinaco</option>
                                    <option value="2">Victoria</option>
                                    <option value="3">Temuco</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="causa">Causa</label>
                                <input type="text" name="causa" class="form-control" id="causa"
                                       value="@{{ tAux.causa }}">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" id="cantidad"
                                       value="@{{ tAux.cantidad }}">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="km_inicio">Km inicio</label>
                                <input type="number" name="km_inicio" class="form-control" id="km_inicio"
                                       value="@{{ tAux.km_inicio }}">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="km_termino">Km término</label>
                                <input type="number" name="km_termino" class="form-control" id="km_termino"
                                       value="@{{ tAux.km_termino }}">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="programada">Programada</label>
                                <input type="date" name="programada" class="form-control" id="programada"
                                       value="@{{ tAux.programada }}">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="vencimiento">Vencimiento</label>
                                <input type="date" name="vencimiento" class="form-control" id="vencimiento"
                                       value="@{{ tAux.vencimiento }}">
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="vencimiento">Vencimiento</label>

                                <div class="form-control">
                                    <div class="checkbox checkbox-primary checkbox-inline">
                                        <input type="checkbox" id="inlineCheckboxLun" value="option1" checked="">
                                        <label for="inlineCheckboxLun">Lun 06</label>
                                    </div>
                                    <div class="checkbox checkbox-primary checkbox-inline">
                                        <input type="checkbox" id="inlineCheckboxMar" value="option1" checked="">
                                        <label for="inlineCheckboxMar">Mar 07</label>
                                    </div>
                                    <div class="checkbox checkbox-primary checkbox-inline">
                                        <input type="checkbox" id="inlineCheckboxMie" value="option1" checked="">
                                        <label for="inlineCheckboxMie">Mié 08</label>
                                    </div>
                                    <div class="checkbox checkbox-primary checkbox-inline">
                                        <input type="checkbox" id="inlineCheckboxJuv" value="option1" checked="">
                                        <label for="inlineCheckboxJuv">Juv 09</label>
                                    </div>
                                    <div class="checkbox checkbox-primary checkbox-inline">
                                        <input type="checkbox" id="inlineCheckboxVie" value="option1" checked="">
                                        <label for="inlineCheckboxVie">Vie 10</label>
                                    </div>
                                    <div class="checkbox checkbox-primary checkbox-inline">
                                        <input type="checkbox" id="inlineCheckboxSab" value="option1">
                                        <label for="inlineCheckboxSab">Sab 11</label>
                                    </div>
                                    <div class="checkbox checkbox-primary checkbox-inline">
                                        <input type="checkbox" id="inlineCheckboxDom" value="option1">
                                        <label for="inlineCheckboxDom">Dom 12</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="3"
                                      class="form-control">@{{ tAux | json }}</textarea>
                            </div>

                            <div class="modal-footer">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <input class="btn btn-primary" type="submit" ng-click="" value="Guardar"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop

@section('js')
    {{--{{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.min.js') }}--}}
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.min.js"></script>
    {{--{{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js') }}--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    {{ HTML::script('js/angular/project.js') }}
@stop

{{--
@section('modals')
    @include('modal.formPlanificarTrabajo')
@stop
--}}
