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
    {{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css') }}
    <style>
        .dp-highlight .ui-state-default {
            background: #0079a1;
            color: #FFF;
        }
    </style>
@stop

@section('title')
    Programar Angular
@stop

@section('content')
    <h3>Programar trabajos</h3>

    <div ng-controller="TrabajoController">
        <form novalidate>
            <div class="form-group col-md-2">
                <input type="text" class="form-control" ng-model="programa.causa" placeholder="Causa"
                       required="required">
            </div>
            <div class="form-group col-md-3">
                {{ Form::select('trabajo_id', $trabajos, null, ['class' => 'form-control', 'ng-model' => 'programa.trabajo_id', 'required' => 'required']) }}
            </div>
            <div class="form-group col-md-2">
                <input type="number" class="form-control" ng-model="programa.km_inicio"
                       placeholder="km inicio"
                       required="required">
            </div>
            <div class="form-group col-md-2">
                <input type="number" class="form-control" ng-model="programa.km_termino"
                       placeholder="km término"
                       required="required">
            </div>
            <div class="form-group col-md-2">
                <input type="number" class="form-control" ng-model="programa.cantidad"
                       placeholder="Cantidad"
                       required="required">
            </div>
            <div class="form-group col-md-1">
                <input class="btn btn-primary" type="submit" ng-click="addTrabajo(programa)"
                       value="Agregar"/>
            </div>
        </form>

        {{--<p>Total trabajos: @{{ getTotaltrabajos() }}</p>--}}

        <div>
            <h4>Filtrar</h4>

            <form>
                <div class="form-group col-md-2">
                    <select name="" id="" class="form-control">
                        <option value="">Renaico</option>
                        <option value="">Temuco</option>
                        <option value="">Victoria</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" placeholder="Semana" required="required">
                </div>
                <div class="form-group col-md-1">
                    <input class="btn btn-primary" type="submit" value="Filtrar"/>
                </div>
            </form>
        </div>

        <table class="table table-condensed table-bordered table-striped table-hover">
            <tr>
                <th></th>
                <th>Causa</th>
                <th>Trabajo</th>
                <th>Unidad</th>
                <th>Km Inicio</th>
                <th>Km Término</th>
                <th>Cantidad</th>
                <th>Días</th>
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
                <td>
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
                </td>
                <td class="text-center">
                    <a ng-click="removeTrabajo()" href=""><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
        </table>

        <div>
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalCausa">Nueva
                causa
            </button>
        </div>

        <div class="modal fade" id="modalPlanificarTrabajo" tabindex="-1" role="dialog"
             aria-labelledby="modalPlanificarTrabajoLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalPlanificarTrabajoLabel">@{{ tAux.nombre }}</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group col-sm-4">
                                <label for="grupo_trabajo">Grupo</label>
                                {{ Form::select('grupo_trabajo', $grupos, null, ['class' => 'form-control', 'ng-model' => 'tAux.grupo_trabajo_id', 'required' => 'required']) }}
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="km_inicio">Km inicio</label>
                                <input type="number" class="form-control"
                                       ng-model="tAux.km_inicio" value="@{{ tAux.km_inicio }}">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="km_termino">Km término</label>
                                <input type="number" class="form-control"
                                       ng-model="tAux.km_termino" value="@{{ tAux.km_termino }}">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="causa">Causa</label>
                                <input type="text" class="form-control"
                                       ng-model="tAux.causa" value="@{{ tAux.causa }}">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="cantidad">Cantidad</label>
                                <input type="text" class="form-control"
                                       ng-model="tAux.cantidad" value="@{{ tAux.cantidad }}">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="programada">Programada</label>
                                {{--<input type="text" name="programada" class="form-control" id="programada" value="@{{ tAux.programada }}">--}}
                                <div id="programada"></div>
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="fecha_inicio"><b>To:</b></label>
                                <input type="text" id="fecha_inicio" class="form-control" ng-model="tAux.fecha_inicio"
                                       value="@{{ tAux.fecha_inicio }}">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="fecha_termino"><b>From:</b></label>
                                <input type="text" id="fecha_termino" class="form-control" ng-model="tAux.fecha_termino"
                                       value="@{{ tAux.fecha_termino }}">
                            </div>

                            {{--
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
                            --}}

                            <div class="form-group col-sm-12">
                                <label for="caca">Caca</label>
                                <input id="caca" type="text" ng-model="tAux.caca">
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="3"
                                      class="form-control">@{{ tAux | json }}</textarea>
                            </div>

                            <div class="modal-footer">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <input class="btn btn-primary" type="submit" ng-click="editTrabajo(tAux)"
                                           value="Guardar"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalCausa" tabindex="-1" role="dialog"
             aria-labelledby="modalCausaLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalCausaLabel">Nueva causa</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group col-sm-6">
                                <label for="causa">Causa</label>
                                <input ng-model="causa.causa" type="text" name="causa" class="form-control" id="causa">
                            </div>

                            <div class="form-group col-sm-2">
                                <label for="version">Versión</label>
                                <input ng-model="causa.version" type="number" name="version" class="form-control"
                                       id="version">
                            </div>

                            <div class="form-group col-sm-4">
                                <label for="vencimiento">Vencimiento</label>
                                <input ng-model="causa.vencimiento" type="date" name="vencimiento" class="form-control"
                                       id="vencimiento">
                            </div>

                            <div class="modal-footer">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <input class="btn btn-primary" type="submit" ng-click="addCausa(causa)"
                                           value="Guardar"/>
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
    {{ HTML::script('js/angular/ui-bootstrap-0.13.1.min.js') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js') }}
    {{ HTML::script('js/calendar/calendar.min.js') }}

    <script>
        $(document).ready(function () {

            /**
             * Lanza calendario
             */
            $("#programada").datepicker({
                numberOfMonths: 1,
                showAnim: "slideDown",
                beforeShow: function () {
                    $(".ui-datepicker")
                },
                beforeShowDay: function (date) {
                    var date1 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#fecha_inicio").val());
                    var date2 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#fecha_termino").val());
                    return [true, date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)) ? "dp-highlight" : ""];
                },
                onSelect: function (dateText, inst) {
                    var date1 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#fecha_inicio").val());
                    var date2 = $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#fecha_termino").val());
                    var selectedDate = $.datepicker.parseDate($.datepicker._defaults.dateFormat, dateText);

                    if (!date1 || date2) {
                        $("#fecha_inicio").val(dateText);
                        $("#fecha_termino").val("");
                        $(this).datepicker();
                    } else if (selectedDate < date1) {
                        $("#input2").val($("#fecha_inicio").val());
                        $("#fecha_inicio").val(dateText);
                        $(this).datepicker();
                    } else {
                        $("#fecha_termino").val(dateText);
                        $(this).datepicker();
                    }
                }
            }).css('font-size', 12);
        });
    </script>
@stop

{{--
@section('modals')
    @include('modal.formPlanificarTrabajo')
@stop
--}}
