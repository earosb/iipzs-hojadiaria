@extends('layout.landing')

@section('title')
    Histórico hoja diaria de trabajo
@stop

@section('content')
    <div class="col-xs-12 col-md-6 col-lg-4">
        <legend>Histórico Hojas Diarias</legend>
        <table class="table table-bordered table-striped" id="tab_trabajados">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingresada el</th>
                <th>Última edición</th>
                <th class="text-center">Ver</th>
            </tr>
            </thead>
            <tbody>
            @forelse($hojas as $hoja)
                <tr>
                    <td>
                        {{ Carbon\Carbon::parse($hoja->fecha)->format('d-m-Y') }}
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($hoja->created_at)->format('d-m-Y H:i:s') }}
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($hoja->updated_at)->format('d-m-Y H:i:s') }}
                    </td>
                    <td class="text-center">
                        <a class="glyphicon glyphicon-eye-open" title="Ver" href="#"
                           onclick="verHojaDiaria({{ $hoja->id }});return false;"></a>
                    </td>
                </tr>
            @empty
                <h4>No existen registros</h4>
            @endforelse
            </tbody>
        </table>
    </div>

    <div id="div_detalle" class="col-xs-12 col-md-6 col-lg-8"></div>

@stop

@section('js')
    {{ HTML::script('js/hd/index.js') }}
@endsection