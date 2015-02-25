{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 23-02-15
 * Time: 18:48
--}}

@extends('layout.landing')

@section('title')
    Mantención Vías
@stop

@section('content')
    <div class="row">
        {{-- Desviadores --}}
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Desviadores</div>
                <div class="panel-body">
                    {{--<a class="btn btn-info btn-new pull-right" href="{{ URL::route('m.block.create') }}">Nuevo Desviador</a>--}}
                    <a class="btn btn-info btn-new pull-right" data-toggle="modal" data-target="#modalDesviador" href="#">Nuevo Desviador</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Km Inicio</th>
                        <th class="col-md-1">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($desviadores as $desviador)
                        <tr>
                            <td>
                                {{ $desviador->nombre }}
                            </td>
                            <td>
                                {{ $desviador->km_inicio }}
                            </td>
                            <td class="text-center">
                                <a class="glyphicon glyphicon-pencil"
                                   href="{{ URL::to('/m/block/'.$desviador->id.'/edit') }}"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Desvíos --}}
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Desvíos
                </div>
                <div class="panel-body">
                    <a class="btn btn-info btn-new pull-right" href="{{ URL::route('m.block.create') }}">Nuevo
                        Desvío</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Desviador norte</th>
                        <th>Desviador sur</th>
                        <th class="col-md-1">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($desvios as $desvio)
                        <tr>
                            <td>
                                {{ $desviop->nombre }}
                            </td>
                            <td>
                                {{ $desvio->desviador_norte_id }}
                            </td>
                            <td>
                                {{ $desvio->desviador_sur_id }}
                            </td>
                            <td class="text-center">
                                <a class="glyphicon glyphicon-pencil"
                                   href="{{ URL::to('/m/block/'.$desvio->id.'/edit') }}"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

<script>
    $(document).ready(function () {
        $('#modalDesviador').on('shown.bs.modal');
        $('#modalDesvio').on('shown.bs.modal');
    });
</script>

@section('modals')
    @include('modal.formDesviador')
    @include('modal.formDesvio')
@stop