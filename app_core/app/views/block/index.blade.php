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
        <div class="col-xs-12 col-md-12">
            <legend>Mantención Vías</legend>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Nombre/Estación</th>
                    <th>Nro. Bien</th>
                    <th>Km Inicio</th>
                    <th>Km Término</th>
                    <th>Sector</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blocks as $block)
                    <tr>
                        <td>
                            {{ $block->estacion }}
                        </td>
                        <td>
                            {{ $block->nro_bien }}
                        </td>
                        <td>
                            {{ $block->km_inicio }}
                        </td>
                        <td>
                            {{ $block->km_termino }}
                        </td>
                        <td>
                            {{ $block->sector_nombre }}
                        </td>
                        <td class="text-center">
                            <a class="glyphicon glyphicon-list-alt" href="{{ URL::to('/m/block/'.$block->id) }}"></a>
                            <a class="glyphicon glyphicon-pencil" href="{{ URL::to('/m/block/'.$block->id.'/edit') }}"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
