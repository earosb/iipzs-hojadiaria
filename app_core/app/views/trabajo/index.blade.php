{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 23-02-15
 * Time: 16:31
--}}

@extends('layout.landing')

@section('title')
    Mantención Trabajos
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <legend>Mantención Trabajos</legend>

            <div class="pull-right">
                <a class="btn btn-info btn-new" href="{{ URL::route('m.sector.create') }}">Nuevo Trabajo</a>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Valor</th>
                    <th>Unidad</th>
                    <th>Form 2-3-4</th>
                    <th>T. mant.</th>
                    <th>Materiales</th>
                    <th>Editar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($trabajos as $trabajo)
                    <tr>
                        <td>
                            {{ $trabajo->nombre }}
                        </td>
                        <td>
                            {{ $trabajo->valor }}
                        </td>
                        <td>
                            {{ $trabajo->unidad }}
                        </td>
                        <td>
                            @if ($trabajo->es_oficial == 1) Si
                            @else No
                            @endif
                        </td>
                        <td>
                            {{ $trabajo->tipo_mantencion }}
                        </td>
                        <td>
                            {{ $trabajo->ide }}
                        </td>
                        <td class="text-center">
                            <a class="glyphicon glyphicon-pencil"
                               href="{{ URL::to('/m/trabajo/') }}"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
