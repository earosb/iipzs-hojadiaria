<div class="panel panel-default">
    <div class="panel-heading">Cargas {{ $deposito->nombre }}</div>
    <div class="panel-body">
        <div class="btn-group pull-right">
            <span class="btn btn-primary" onclick="getCargasForm({{$deposito->id}})">Nuevo</span>
        </div>
    </div>
    @if($cargas->isEmpty())
        <div class="panel-body">
            <p>No existen cargas</p>
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Material</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Borrar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cargas as $carga)
                <tr>
                    <td>
                        {{ $carga->material }}
                    </td>
                    <td>
                        {{ $carga->fecha }}
                    </td>
                    <td>
                        {{ $carga->total }}
                    </td>
                    <td>
                        <a title="Borrar" href="{{ URL::to('m/deposito/') }}"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>