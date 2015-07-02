@extends('layout.landing')

@section('meta')
    <meta name="description" content="Planificación de trabajos">
    <meta name="author" content="earosb">
@stop

@section('css')
    {{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css') }}
    {{ HTML::style('css/awesome-bootstrap-checkbox.min.css') }}
@stop

@section('title')
    Planificar trabajos
@stop

@section('content')
    <div class="col-md-9">
        <table class="table">
            <thead>
            <tr>
                <th class="col-md-3">Semana</th>
                <th class="col-md-3">Grupo</th>
                <th class="col-md-3">Nuevo</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="input-group" id="fecha_div">
                        {{ Form::text('newsdate', null, ['class'=>'form-control', 'placeholder'=>'Ingrese Fecha', 'id'=>'weekpicker', 'required' => 'required']) }}
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                    <div class="help-block" id="fecha_error"></div>
                </td>
                <td>
                    <div id="selectgrupos_div">
                        <div class="controls">
                            <select name="selectgrupos" id="selectgrupos" class="form-control">
                                <option selected="selected" disabled="disabled"> Seleccione un Grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->base }}</option>
                                @endforeach
                            </select>

                            <div class="help-block" id="selectgrupos_error"></div>
                        </div>
                    </div>
                </td>
                <td>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalPlanificar">Nuevo</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th></th>
                <th class="col-md-1">Causal</th>
                <th>[U] Partida</th>
                <th class="col-md-1">Km inicio</th>
                <th class="col-md-1">Km término</th>
                <th class="col-md-1">Cantidad</th>
                <th class="col-md-1">Vencimiento</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <tr class="danger">
                <td>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="check[]" value="option1" checked="">
                        <label for="check[]"></label>
                    </div>
                </td>
                <td><input class="form-control input-sm" type="text" value="INC"></td>
                <td>[NRO] Sustitución aislada de durmientes de madera</td>
                <td><input class="form-control input-sm" type="number" value="503000"></td>
                <td><input class="form-control input-sm" type="number" value="503100"></td>
                <td><input class="form-control input-sm" type="number" value="23"></td>
                <td><input class="form-control input-sm" type="date" value="21/06/2015"></td>
                <td>Atrasada</td>
            </tr>
            <tr class="active">
                <td>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        {{--<input type="checkbox" id="check[]" value="option1" checked="">
                        <label for="check[]"></label>--}}
                        {{ Form::checkbox('check[]', 'true', false) }}
                        {{ Form::label('check[]') }}
                    </div>
                </td>
                <td><input class="form-control input-sm" type="text" value="INC"></td>
                <td>[MLV] Sanear vía colmatada</td>
                <td><input class="form-control input-sm" type="number" value=""></td>
                <td><input class="form-control input-sm" type="number" value=""></td>
                <td><input class="form-control input-sm" type="number" value=""></td>
                <td><input class="form-control input-sm" type="date" value=""></td>
                <td>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="inlineCheckboxLun" value="option1" checked="">
                        <label for="inlineCheckboxLun">Lun </label>
                    </div>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="inlineCheckboxMar" value="option1" checked="">
                        <label for="inlineCheckboxMar">Mar </label>
                    </div>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="inlineCheckboxMie" value="option1" checked="">
                        <label for="inlineCheckboxMie">Mié </label>
                    </div>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="inlineCheckboxJuv" value="option1" checked="">
                        <label for="inlineCheckboxJuv">Juv </label>
                    </div>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="inlineCheckboxVie" value="option1" checked="">
                        <label for="inlineCheckboxVie">Vie </label>
                    </div>
                </td>
            </tr>
            <tr class="active">
                <td>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="check[]" value="option1" checked="">
                        <label for="check[]"></label>
                    </div>
                </td>
                <td><input class="form-control input-sm" type="text" value="OBS"></td>
                <td>[MLV] Encajonar y perfilar vía</td>
                <td><input class="form-control input-sm" type="number" value="503000"></td>
                <td><input class="form-control input-sm" type="number" value="503100"></td>
                <td><input class="form-control input-sm" type="number" value="23"></td>
                <td><input class="form-control input-sm" type="date" value=""></td>
                <td>Pendiente</td>
            </tr>
            <tr class="success">
                <td>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="check[]" value="option1" checked="">
                        <label for="check[]"></label>
                    </div>
                </td>
                <td><input class="form-control input-sm" type="text" value="OBS"></td>
                <td>[NRO] Sustitución aislada de durmientes de madera</td>
                <td><input class="form-control input-sm" type="number" value="503000"></td>
                <td><input class="form-control input-sm" type="number" value="503100"></td>
                <td><input class="form-control input-sm" type="number" value="23"></td>
                <td>21/06/2015</td>
                <td>Planificado</td>
            </tr>
            <tr class="success">
                <td>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="check[]" value="option1" checked="">
                        <label for="check[]"></label>
                    </div>
                </td>
                <td><input class="form-control input-sm" type="text" value="OBS"></td>
                <td>[NRO] Sustitución aislada de durmientes de madera</td>
                <td><input class="form-control input-sm" type="number" value="503000"></td>
                <td><input class="form-control input-sm" type="number" value="503100"></td>
                <td><input class="form-control input-sm" type="number" value="23"></td>
                <td>21/06/2015</td>
                <td>Planificado</td>
            </tr>
            <tr class="success">
                <td>
                    <div class="checkbox checkbox-primary checkbox-inline">
                        <input type="checkbox" id="check[]" value="option1" checked="">
                        <label for="check[]"></label>
                    </div>
                </td>
                <td><input class="form-control input-sm" type="text" value="OBS"></td>
                <td>[NRO] Apretar pernos rieleros</td>
                <td><input class="form-control input-sm" type="number" value="503000"></td>
                <td><input class="form-control input-sm" type="number" value="503100"></td>
                <td><input class="form-control input-sm" type="number" value="23"></td>
                <td>21/06/2015</td>
                <td>Planificado</td>
            </tr>
            </tbody>
        </table>
        {{-- Botones
            ===================================================== --}}
        <div class="col-md-12">
            {{ Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) }}
        </div>
    </div>
@stop

@section('js')
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js') }}
    {{ HTML::script('js/calendar/calendar.min.js') }}
    <script type="text/javascript">
        $('#modalPlanificar').on('shown.bs.modal');

        $(function () {
            var startDate;
            var endDate;

            var selectCurrentWeek = function () {
                window.setTimeout(function () {
                    $('#weekpicker').datepicker('widget').find('.ui-datepicker-current-day a').addClass('ui-state-active')
                }, 1);
            };

            $('#weekpicker').datepicker({
                showOtherMonths: false,
                selectOtherMonths: false,
                onSelect: function (dateText, inst) {
                    var date = $(this).datepicker('getDate');
                    console.log('date.getDate() ' + date.getDate());
                    console.log('date.getDay() ' + date.getDay());
                    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 1);
                    endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 7);
                    var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
                    $('#weekpicker').val($.datepicker.formatDate(dateFormat, startDate, inst.settings)
                    + ' - ' + $.datepicker.formatDate(dateFormat, endDate, inst.settings));

                    selectCurrentWeek();
                },
                beforeShow: function () {
                    selectCurrentWeek();
                },
                beforeShowDay: function (date) {
                    var cssClass = '';
                    if (date >= startDate && date <= endDate)
                        cssClass = 'ui-datepicker-current-day';
                    return [true, cssClass];
                },
                onChangeMonthYear: function (year, month, inst) {
                    selectCurrentWeek();
                }
            }).datepicker('widget').addClass('ui-weekpicker');

            var aux = '.ui-weekpicker .ui-datepicker-calendar tr';
            var td_a = 'td a';
            $(aux).live('mousemove', function () {
                $(this).find(td_a).addClass('ui-state-hover');
            });
            $(aux).live('mouseleave', function () {
                $(this).find(td_a).removeClass('ui-state-hover');
            });
        });

    </script>
@stop

@section('modals')
    @include('modal.formPlanificarTrabajo')
@stop