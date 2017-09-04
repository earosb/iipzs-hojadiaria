@extends('layout.landing')

@section('meta')
    <meta name="description" content="Listado de hojas diarias existentes">
    <meta name="author" content="earosb">
@stop

@section('title')
    Histórico centros de acopio
@stop

@section('css')
    {{ HTML::style('dist/css/dataTables.bootstrap.min.css') }}
@endsection

@section('content')
    <legend>Histórico cargas</legend>
    <div class="col-xs-12 col-md-8">
        <table class="table table-bordered table-striped table-hover" id="tab_trabajados">
            <thead>
            <tr>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Acopio</th>
                <th>Material</th>
                <th>Cantidad</th>
                <th>Observación</th>
                <th class="text-center"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($cargas as $carga)
                <tr>
                    <td>
                        @if($carga->tipo === 'carga') Carga
                        @else Rectificación
                        @endif
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($carga->fecha)->format('d-m-Y') }}
                    </td>
                    <td>
                        @if(isset($carga->deposito)) {{ $carga->deposito->nombre }}
                        @else Acopio eliminado
                        @endif
                    </td>
                    <td>
                        {{ $carga->material->nombre }}
                    </td>
                    <td>
                        {{ $carga->cantidad }}
                    </td>
                    <td>
                        {{ $carga->obs }}
                    </td>
                    <td>
                        <a id="dlt" onclick="destroy({{ $carga->id }})" class="text-danger"><span
                                    class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            {{ $cargas->links() }}
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        function destroy(id) {
            if (confirm("¿Eliminar carga?") === true) {
                $.ajax({
                    type: 'delete',
                    url: '/carga/' + id
                }).error(function () {
                    alert("Error al enviar datos\nPor favor, verifique su conexión a Internet");
                }).done(function (data) {
                    if (data.error) {
                        alert("Se produjo un problema el intentar eliminar la carga");
                        alert(data.msg);
                    }

                    window.location.replace("{{ URL::to('/carga') }}");
                });
            }
        }

    </script>
@stop