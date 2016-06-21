@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de trabajos">
    <meta name="author" content="earosb">
@stop

@section('title')
    Mantención de Trabajos
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> Todos los Trabajos</div>
                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <a class="btn btn-primary" href="{{ URL::route('m.trabajo.create') }}"> Nuevo Trabajo </a>
                    </div>
                </div>

                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($mantenimientos as $key => $mantenimiento)
                            @if($key == 0)
                                <li role="presentation" class="active"><a href="#{{ $mantenimiento->id }}"
                                                                          aria-controls="home" role="tab"
                                                                          data-toggle="tab">{{ $mantenimiento->nombre }}</a>
                                </li>
                            @else
                                <li role="presentation"><a href="#{{ $mantenimiento->id }}" aria-controls="profile"
                                                           role="tab" data-toggle="tab">{{ $mantenimiento->nombre }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        @foreach($mantenimientos as $key => $mantenimiento)
                            @if($key == 0)
                                <div role="tabpanel" class="tab-pane active" id="{{ $mantenimiento->id }}">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th class="col-md-1">Valor</th>
                                            <th class="col-md-1">Unidad</th>
                                            <th class="col-md-1">Form 2</th>
                                            <th class="col-md-1">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($mantenimiento->trabajos as $trabajo)
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
                                                    @if ($trabajo->es_oficial == 1) Si (orden {{ $trabajo->orden }})
                                                    @else No
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a title="Editar" href="{{ URL::to('/m/trabajo/'.$trabajo->id.'/edit') }}"><span
                                                                class="glyphicon glyphicon-edit"></span></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <h4>NO EXISTEN REGISTROS</h4>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div role="tabpanel" class="tab-pane"
                                     id="{{ $mantenimiento->id }}">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th class="col-md-1">Valor</th>
                                            <th class="col-md-1">Unidad</th>
                                            <th class="col-md-1">Form 2</th>
                                            <th class="col-md-1">Opciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($mantenimiento->trabajos as $trabajo)
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
                                                    @if ($trabajo->es_oficial == 1) Si (orden {{ $trabajo->orden }})
                                                    @else No
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a title="Editar" href="{{ URL::to('/m/trabajo/'.$trabajo->id.'/edit') }}"><span
                                                                class="glyphicon glyphicon-edit"></span></a>
                                                </td>
                                            </tr>
                                            @empty
                                            <h4>NO EXISTEN REGISTROS</h4>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
