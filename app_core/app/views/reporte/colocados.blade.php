@if( isset($colocados) )
    <div class="col-xs-12 col-md-6">
        <legend><h3> Materiales Colocados </h3></legend>
        <table class="table table-bordered table-striped display">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Material</th>
                <th>Cantidad</th>
                <th>Grupo</th>
            </tr>
            </thead>
            <tbody>
            @forelse($colocados as $colocado)
                <tr>
                    <td>
                        {{ date('d/m/Y', strtotime($colocado->fecha)) }}
                    </td>
                    <td>
                        {{ $colocado->material }}
                    </td>
                    <td>
                        {{ $colocado->cantidad }}
                    </td>
                    <td>
                        {{ $colocado->grupo }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No existen registros</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $colocados->links() }}
    </div>
@endif