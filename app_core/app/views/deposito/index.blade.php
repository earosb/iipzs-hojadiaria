@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de depósitos/centros de acopio">
    <meta name="author" content="earosb">
@stop

@section('title')
    Centros de acopio
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Centros de acopio</div>
                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <a class="btn btn-primary" href="{{ URL::route('m.deposito.create') }}">Nuevo</a>
                    </div>
                </div>
                @if( $depositos->isEmpty() )
                    <h4>No existen registros</h4>
                @else
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="col-md-2">Opciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($depositos as $deposito)
                            <tr>
                                <td>
                                    {{ $deposito->nombre }}
                                </td>
                                <td class="text-center">
                                    {{--<a title="Ver cargas" href="#cargas" onclick="getCargas({{$deposito->id}})" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-list-alt"></span></a>--}}
                                    <a title="Editar" href="{{ URL::to('m/deposito/'.$deposito->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-md-6" id="cargas"></div>
    </div>
@stop

@section('js')
    <script>
        function getCargas(id) {
            $("#cargas").html("<p>Cargando...</p>");
            $.get("deposito/" + id, function (data) {
                $("#cargas").html(data.html);
            });
        }
        function getCargasForm(id) {
            $("#cargas").html("<p>Cargando...</p>");
            $.get("carga/create?d=" + id, function (data) {
                $("#cargas").html(data.html);
            });
        }
    </script>
@stop
