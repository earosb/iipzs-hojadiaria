@extends('layout.landing')

@section('angularjs')
    ng-app
@stop

@section('meta')
    <meta name="description" content="Planificación de trabajos">
    <meta name="author" content="earosb">
@stop

@section('css')
    {{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css') }}
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

        <h2>Total trabajos: @{{ getTotaltrabajos() }}</h2>

        <table class="table">
            <tr>
                <th>Causal</th>
                <th>Trabajo</th>
                <th>Km Inicio</th>
                <th>Km Término</th>
                <th>Cantidad</th>
            </tr>
            <tr ng-repeat="t in trabajos | orderBy:'km_inicio'" class="@{{ t.status }}">
                <td>@{{ t.causa }}</td>
                <td>@{{ t.nombre }}</td>
                <td>@{{ t.km_inicio }}</td>
                <td>@{{ t.km_termino }}</td>
                <td>@{{ t.cantidad }}</td>
            </tr>
        </table>
    </div>

@stop

@section('js')
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular.min.js') }}
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular-resource.min.js') }}
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.2.13/angular-route.min.js') }}
    {{ HTML::script('https://cdn.firebase.com/js/client/2.0.4/firebase.js') }}
    {{ HTML::script('https://cdn.firebase.com/libs/angularfire/0.9.0/angularfire.min.js') }}
    {{ HTML::script('js/angular/project.js') }}
@stop
