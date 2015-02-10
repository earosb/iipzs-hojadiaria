@extends('layout.landing')

@section('title')
    Histórico hoja diaria de trabajo | Icil-icafal
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
                        {{ $hoja->fecha }}
                    </td>
                    <td>
                        {{ $hoja->created_at  }}
                    </td>
                    <td>{{ $hoja->updated_at }}</td>
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

@section('modals')
    @include('modal.viewHojaDiaria')
@stop