@extends('layout.landing')

@section('title')
    Histórico hoja diaria de trabajo | Icil-icafal
@stop

@section('css')
    {{ HTML::style('css/jquery-ui.min.css') }}
    {{ HTML::style('css/hd/create.min.css') }}
@stop

@section('content')
    <legend>Histórico Hojas Diarias</legend>
    <div class="col-xs-12 col-md-4">
        <table class="table table-bordered table-striped" id="tab_trabajados">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingresada el</th>
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
                    <td class="text-center">
                        <a class="glyphicon glyphicon-eye-open" title="Ver" href="#"
                           onclick="verHojaDiaria({{ $hoja->id }});return false;"></a>
                        <a class="glyphicon glyphicon-pencil" title="Editar" href="#"
                           onclick="editarHojaDiaria({{ $hoja->id }});return false;"></a>
                        <a class="glyphicon glyphicon-trash" title="Borrar" href="#"
                           onclick="borrarHojaDiaria({{ $hoja->id }});return false;"></a>
                        <a class="glyphicon glyphicon-download-alt" title="Descargar como PDF" href="#" onclick=""></a>
                        <a class="glyphicon glyphicon-print" title="Imprimir" href="#" onclick=""></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('js')
    {{ HTML::script('js/hd/index.js') }}
@endsection

@section('modals')
    @include('modal.viewHojaDiaria')
@stop