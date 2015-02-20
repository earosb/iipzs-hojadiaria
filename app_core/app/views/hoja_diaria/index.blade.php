@extends('layout.landing')

@section('title')
    Histórico hoja diaria de trabajo
@stop

@section('css')
    {{ HTML::style('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css') }}
    <style type="text/css">
        @media print {
            #div_historico {
                display: none;
            }

            .btn-group {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="col-xs-12 col-md-6 col-lg-4" id="div_historico">
        <legend>Histórico Hojas Diarias</legend>
        <table class="table table-bordered table-hover" id="tab_trabajados">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingresada el</th>
                <th>Ingresada por</th>
                <th>Última edición</th>
                <th class="text-center">Ver</th>
            </tr>
            </thead>
            <tbody>
            @forelse($hojas as $hoja)
                <tr data-id="{{ $hoja->id }}">
                    <td>
                        {{ Carbon\Carbon::parse($hoja->fecha)->format('d-m-Y') }}
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($hoja->created_at)->format('d-m-Y H:i:s') }}
                    </td>
                    <td>
                        {{ $hoja->username }}
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
    {{ HTML::script('//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js') }}
    {{ HTML::script('//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js') }}
    <script>
        $(document).ready(function () {
            $("#tab_trabajados").DataTable({
                paging: true,
                lengthChange: false,
                ordering: false,
                info: false,
                stateSave: false,
                filter: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection