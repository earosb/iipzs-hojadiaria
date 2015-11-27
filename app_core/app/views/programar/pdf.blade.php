<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        table {
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 3px;
        }

        .center {
            text-align: center;
        }

        .checked {
            background-color: #bdbebd;
        }
    </style>
</head>

<body>
<h3>Programa Semanal de Trabajo </h3>

<div>
    <table>
        <tr>
            <th>Grupo Vía</th>
            @if($grupo == null)
                <td>Todos</td>
            @else
                <td>{{$grupo->base}}</td>
            @endif
            <th>Semana</th>
            <td>{{ $startOfWeek }} al {{ $endOfWeek }}</td>
        </tr>
    </table>
</div>
<br>

<div>
    <table>
        <tr>
            <th colspan="6">Trabajo</th>
            <th colspan="7">Programa</th>
        </tr>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2" width="40%">Descripción del Trabajo</th>
            <th colspan="2">Kilometraje</th>
            <th rowspan="2">Uni.</th>
            <th rowspan="2">Cant.</th>

            <th rowspan="2">Lun</th>
            <th rowspan="2">Mar</th>
            <th rowspan="2">Mié</th>
            <th rowspan="2">Jue</th>
            <th rowspan="2">Vié</th>
            <th rowspan="2">Sáb</th>
            <th rowspan="2">Dom</th>
            {{--<th rowspan="2">Obs.</th>--}}
        </tr>
        <tr>
            <th>Inicio</th>
            <th>Final</th>
        </tr>
        @foreach($trabajos as $i => $trabajo)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $trabajo->nombre }}</td>
                <td class="center">{{ $trabajo->km_inicio }}</td>
                <td class="center">{{ $trabajo->km_termino }}</td>
                <td class="center">{{ $trabajo->unidad }}</td>
                <td class="center">{{ $trabajo->cantidad }}</td>
                @if($trabajo->lun == 'checked')
                    <td class="checked"></td>
                @else
                    <td></td>
                @endif
                @if($trabajo->mar == 'checked')
                    <td class="checked"></td>
                @else
                    <td></td>
                @endif
                @if($trabajo->mie == 'checked')
                    <td class="checked"></td>
                @else
                    <td></td>
                @endif
                @if($trabajo->juv == 'checked')
                    <td class="checked"></td>
                @else
                    <td></td>
                @endif
                @if($trabajo->vie == 'checked')
                    <td class="checked"></td>
                @else
                    <td></td>
                @endif
                @if($trabajo->sab == 'checked')
                    <td class="checked"></td>
                @else
                    <td></td>
                @endif
                @if($trabajo->dom == 'checked')
                    <td class="checked"></td>
                @else
                    <td></td>
                @endif
                {{--<td>{{ $trabajo->observaciones }}</td>--}}
            </tr>
        @endforeach
    </table>
</div>
</body>

</html>
