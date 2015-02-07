@extends('layout.landing')

@section('title')
    Histórico hoja diaria de trabajo | Icil-icafal
@stop

@section('content')
    <div class="col-xs-12 col-md-6">
    <legend>Histórico Hojas Diarias</legend>
        <table class="table table-bordered table-striped" id="tab_trabajados">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingresada el</th>
                <th>Última edición</th>
                <th class="text-center">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hojas as $hoja)
                <tr>
                    <td>
                        {{ $hoja->fecha }}
                    </td>
                    <td>
                        {{ $hoja->created_at  }}
                    </td>
                    <td>{{ $hoja->updated_at }}</td>
                    <td class="text-center">
                        <a class="glyphicon glyphicon-eye-open" title="Ver" href="#"
                           onclick="verHojaDiaria({{ $hoja->id }});return false;"></a>
                        <a class="glyphicon glyphicon-download-alt" title="Descargar como PDF" href="#" onclick=""></a>
                        <a class="glyphicon glyphicon-print" title="Imprimir" href="#" onclick=""></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div id="div_detalle" class="col-xs-12 col-md-6"></div>

@stop

@section('js')
    {{ HTML::script('js/hd/index.js') }}
@endsection

@section('modals')
    @include('modal.viewHojaDiaria')
@stop