@extends('layout.landing')

@section('meta')
    <meta name="description" content="Formulario para la creación de una hoja diaria de trabajo">
    <meta name="author" content="earosb">
@stop

@section('title')
    Editar hoja diaria de trabajo
@stop
@section('css')
    {{ HTML::style('dist/css/hoja-diaria.css') }}

    {{-- Necesario para añadir button eliminar columnas a trabajos y materiales existentes --}}
    {{-- Mala practica :/ --}}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}
    <script>
        function addBtnDlt(id) {
            var tr = $(id);
            $("<td></td>").append(
                    $("<button class='btn btn-xs btn-danger glyphicon glyphicon-remove row-remove center-btn'></button>")
                            .click(function () {
                                $(this).closest("tr").remove();
                            })
            ).appendTo($(tr));
        }

    </script>
@stop
@section('content')
    <div class="row">
        {{ Form::open([
            'url' 		=>	'hd/'.$hoja->id,
            'method' 	=>	'put',
            'id'		=>	'formHojaDiaria',
            'class' 	=> 	'form-horizontal']) }}
        <fieldset>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-md-3">Fecha</th>
                        <th class="col-md-3">Grupo</th>
                        <th class="col-md-3">Sector</th>
                        <th class="col-md-3">Block</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="input-group" id="fecha_div">
                                {{ Form::text('fecha', $hoja->fecha, ['class'=>'form-control', 'placeholder'=>'Ingrese Fecha', 'id'=>'fecha', 'required' => 'required']) }}
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                            <div class="help-block" id="fecha_error"></div>
                        </td>
                        <td>
                            <div id="selectgrupos_div">
                                <div class="controls">
                                    <select name="selectgrupos" id="selectgrupos" class="form-control">
                                        @foreach($grupos as $grupo)
                                            @if($hoja->grupo_trabajo_id == $grupo->id)
                                                <option value="{{ $grupo->id }}"
                                                        selected="selected">{{ $grupo->base }}</option>
                                            @else
                                                <option value="{{ $grupo->id }}">{{ $grupo->base }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    <div class="help-block" id="selectgrupos_error"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div id="selectsector_div">
                                <div class="controls">
                                    <select name="selectsector" id="selectsector" class="form-control">
                                        <option selected="selected" disabled="disabled"> Seleccione un Sector</option>
                                        @foreach($sectores as $sector)
                                            @if($hoja->detalle_hoja_diaria[0]->block->sector_id == $sector->id)
                                                <option selected="selected"
                                                        value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                            @else
                                                <option value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    <div class="help-block" id="selectsector_error"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div id="selectblock_div">
                                <div class="controls">
                                    <select name="selectblock" id="selectblock" class="form-control">
                                        <option selected="selected"
                                                value="{{ $hoja->detalle_hoja_diaria[0]->block->id }}"> {{ $hoja->detalle_hoja_diaria[0]->block->estacion }}</option>
                                    </select>

                                    <div class="help-block" id="selectblock_error"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Tabla trabajos realizados
            ===================================================== --}}
            <div class="col-xs-12 col-md-12">
                <table class="table table-bordered table-striped" id="tab_trabajados">
                    <thead>
                    <tr>
                        <th class="col-md-5">Trabajos Ejecutados</th>
                        <th class="col-md-2">Tipo vía</th>
                        <th>Km inicio</th>
                        <th>Km término</th>
                        <th class="col-md-1">Cantidad</th>
                        <th class="text-center">
                            <a id="add_row_trabajos" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addr0' data-id="0" class="hidden">
                        <td data-name="trabajos" data-tipo="trabajo">
                            <select name="trabajos[0][trabajo]" class="form-control selecttrabajo">
                                <option selected="selected" disabled="disabled"> Seleccione un Trabajo</option>
                                @foreach($tipoMantenimiento as $tMat)
                                    <optgroup label="{{ $tMat->nombre }}">
                                        @foreach($tMat->trabajos as $trabajo)
                                            <option value="{{ $trabajo->id }}">{{ $trabajo->nombre }}
                                                ({{ $trabajo->unidad }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </td>
                        <td data-name="trabajos" data-tipo="ubicacion" data-ubicacion="true">
                            {{ Form::select('trabajos[0][ubicacion]', $blockTodo, null, [ 'class'=>'form-control selectubicacion']) }}
                        </td>
                        <td data-name="trabajos" data-tipo="km_inicio">
                            {{ Form::number('trabajos[0][km_inicio]', null, ['class' => 'form-control km-inicio', 'id' => 'trabajos[0][km_inicio]', 'onblur' => 'onblurKmTermino(this);']) }}
                        </td>
                        <td data-name="trabajos" data-tipo="km_termino">
                            {{ Form::number('trabajos[0][km_termino]', null, ['class' => 'form-control km-termino', 'id' => 'trabajos[0][km_termino]']) }}
                        </td>
                        <td data-name="trabajos" data-tipo="cantidad">
                            {{ Form::number('trabajos[0][cantidad]', null, ['class' => 'form-control', 'min' => '0', 'step' => 'any']) }}
                        </td>
                    </tr>
                    @foreach($hoja->detalle_hoja_diaria as $cont => $detalle)
                        <tr id='addr{{ $cont + 1 }}' data-id="{{ $cont + 1 }}">
                            <td data-name="trabajos" data-tipo="trabajo">
                                <select name="trabajos[{{ ($cont + 1) }}][trabajo]" class="form-control selecttrabajo">
                                    @foreach($tipoMantenimiento as $tMat)
                                        <optgroup label="{{ $tMat->nombre }}">
                                            @foreach($tMat->trabajos as $trabajo)
                                                @if($trabajo->id == $detalle->trabajo_id)
                                                    <option selected="selected"
                                                            value="{{ $trabajo->id }}">{{ $trabajo->nombre }}
                                                        ({{ $trabajo->unidad }})
                                                    </option>
                                                @else
                                                    <option value="{{ $trabajo->id }}">{{ $trabajo->nombre }}
                                                        ({{ $trabajo->unidad }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </td>
                            <td data-name="trabajos" data-tipo="ubicacion" data-ubicacion="true">
                                <select name="trabajos[{{ ($cont + 1) }}][ubicacion]"
                                        class="form-control selectubicacion">
                                    @if($detalle->desvio_id )
                                        <option value="desvio-{{ $detalle->desvio_id }}">{{ $detalle->desvio->nombre }}</option>
                                    @elseif($detalle->desviador_id )
                                        <option value="desviador-{{ $detalle->desviador_id }}">{{ $detalle->desviador->nombre }}</option>
                                    @else
                                        <option value="block-{{ $detalle->block_id }}">Vía Principal</option>
                                    @endif
                                </select>
                            </td>
                            <td data-name="trabajos" data-tipo="km_inicio">
                                {{ Form::number('trabajos[' . ($cont + 1) .'][km_inicio]', $detalle->km_inicio, ['step' => '100', 'class' => 'form-control km-inicio', 'id' => 'trabajos[' . ($cont + 1) .'][km_inicio]']) }}
                            </td>
                            <td data-name="trabajos" data-tipo="km_termino">
                                {{ Form::number('trabajos[' . ($cont + 1) .'][km_termino]', $detalle->km_termino, ['step' => '100', 'class' => 'form-control km-termino', 'id' => 'trabajos[' . ($cont + 1) .'][km_termino]']) }}
                            </td>
                            <td data-name="trabajos" data-tipo="cantidad">
                                {{ Form::number('trabajos[' . ($cont + 1) .'][cantidad]', $detalle->cantidad, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) }}
                            </td>
                            <script>
                                addBtnDlt("#addr{{ ($cont +1)}}");
                            </script>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Tabla materiales colocados
            ===================================================== --}}
            <div class="col-md-12">
                <table class="table table-bordered table-striped" id="tab_material_colocado">
                    <thead>
                    <tr>
                        <th>Materiales Colocados</th>
                        <th>Centro de acopio</th>
                        <th>Reempleo</th>
                        <th class="tdkilometro">Cantidad</th>
                        <th class="text-center">
                            <a id="add_row_matCol" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addrMatCol0' data-id="0" class="hidden">
                        <td data-name="matCol" data-tipo="id">
                            {{ Form::select('matCol[0][id]', $materiales, null, [ 'class'=>'form-control matCol']) }}
                        </td>
                        <td data-name="matCol" data-tipo="deposito">
                            {{ Form::select('matCol[0][deposito]', $depositos, null, [ 'class'=>'form-control']) }}
                        </td>
                        <td data-name="matCol" data-tipo="reempleo">
                            {{ Form::checkbox('matCol[0][reempleo]', 'true', false, ['class' => 'form-control']) }}
                        </td>
                        <td data-name="matCol" data-tipo="cant">
                            {{ Form::number('matCol[0][cant]', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) }}
                        </td>
                    </tr>
                    @foreach($hoja->detalle_material_colocado as $cont => $detalleMatCol)
                        <tr id='addrMatCol{{ $cont +1 }}' data-id="{{ $cont +1 }}">
                            <td data-name="matCol" data-tipo="id">
                                {{ Form::select('matCol['.($cont +1).'][id]', $materiales, $detalleMatCol->material_id, [ 'class'=>'form-control matCol']) }}
                            </td>
                            <td data-name="matCol" data-tipo="deposito">
                                {{ Form::select('matCol['.($cont +1).'][deposito]', $depositos, $detalleMatCol->deposito_id, [ 'class'=>'form-control']) }}
                            </td>
                            <td data-name="matCol" data-tipo="reempleo">
                                {{ Form::checkbox('matCol['.($cont +1).'][reempleo]', 'true', $detalleMatCol->reempleo, ['class' => 'form-control']) }}
                            </td>
                            <td data-name="matCol" data-tipo="cant">
                                {{ Form::number('matCol['.($cont +1).'][cant]', $detalleMatCol->cantidad, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) }}
                            </td>
                        </tr>
                        <script>
                            addBtnDlt("#addrMatCol{{ ($cont +1)}}");
                        </script>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Tabla materiales retirados
            ===================================================== --}}
            <div class="col-md-12">
                <table class="table table-bordered table-striped" id="tab_material_retirado">
                    <thead>
                    <tr>
                        <th class="">Materiales Retirados</th>
                        <th class="col-md-2">Centro de acopio</th>
                        <th class="col-md-1">Reempleo</th>
                        <th class="col-md-1">Cantidad</th>
                        <th class="col-md-1 text-center">
                            <a id="add_row_matRet" class="btn btn-success btn-xs glyphicon glyphicon-plus"></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id='addrMatRet0' data-id="0" class="hidden">
                        <td data-name="matRet" data-tipo="id">
                            {{ Form::select('matRet[0][id]', $materialesRet, null, [ 'class'=>'form-control matRet']) }}
                        </td>
                        <td data-name="matRet" data-tipo="deposito">
                            {{ Form::select('matRet[0][deposito]', $depositos, null, [ 'class'=>'form-control']) }}
                        </td>
                        <td data-name="matRet" data-tipo="reempleo">
                            {{ Form::checkbox('matRet[0][reempleo]', 'true', false, ['class' => 'form-control']) }}
                        </td>
                        <td data-name="matRet" data-tipo="cant">
                            {{ Form::number('matRet[0][cant]', null, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) }}
                        </td>
                    </tr>
                    @foreach($hoja->detalle_material_retirado as $cont => $detalleMatRet)
                        <tr id='addrMatRet{{ ($cont+1) }}' data-id="{{ ($cont+1) }}">
                            <td data-name="matRet" data-tipo="id">
                                {{ Form::select('matRet['.($cont+1).'][id]', $materialesRet, $detalleMatRet->material_retirado_id, [ 'class'=>'form-control matRet']) }}
                            </td>
                            <td data-name="matRet" data-tipo="deposito">
                                {{ Form::select('matRet['.($cont+1).'][deposito]', $depositos, $detalleMatRet->deposito_id, [ 'class'=>'form-control']) }}
                            </td>
                            <td data-name="matRet" data-tipo="reempleo">
                                {{ Form::checkbox('matRet['.($cont+1).'][reempleo]', 'true', $detalleMatRet->reempleo, ['class' => 'form-control']) }}
                            </td>
                            <td data-name="matRet" data-tipo="cant">
                                {{ Form::number('matRet['.($cont+1).'][cant]', $detalleMatRet->cantidad, ['class' => 'form-control', 'min' => '0', 'step' => '0.01']) }}
                            </td>
                        </tr>
                        <script>
                            addBtnDlt("#addrMatRet{{ ($cont +1)}}");
                        </script>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Textarea Observaciones
            ===================================================== --}}
            <div class="col-md-4">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Observaciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ Form::textarea('obs', $hoja->observaciones, ['rows' => '5']) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            {{-- Botones
            ===================================================== --}}
            <div class="col-xs-12 col-md-12">
                {{ Form::submit('Guardar', ['class' => 'btn btn-primary pull-right']) }}
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>
@stop

@section('js')
    {{ HTML::script('dist/js/hoja-diaria.js') }}
@stop

@if (Sentry::getUser()->hasAccess(['editor']))
@section('modals')
    @include('modal.modalEditor')
    @include('modal.formDesviador')
    @include('modal.formDesvio')
    @include('modal.formMaterialColocado')
    @include('modal.formMaterialRetirado')
    @include('modal.formTrabajo')
@stop
@endif