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

        .obs {
            font-size: x-small;
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
            @if($showObs)
                <th colspan="8">Programa</th>
            @else
                <th colspan="7">Programa</th>
            @endif
        </tr>
        <tr>
            <th rowspan="2">#</th>
            @if($showObs)
                <th rowspan="2" width="30%">Descripción del Trabajo</th>
            @else
                <th rowspan="2" width="45%">Descripción del Trabajo</th>
            @endif
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
            @if($showObs)
                <th rowspan="2" width="40%">Observaciones</th>
            @endif
        </tr>
        <tr>
            <th>Inicio</th>
            <th>Final</th>
        </tr>
        @foreach($trabajos as $i => $trabajo)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $trabajo->Trabajo }}</td>
                <td class="center">{{ $trabajo->Km_Inicio }}</td>
                <td class="center">{{ $trabajo->Km_Termino }}</td>
                <td class="center">{{ $trabajo->Unidad }}</td>
                <td class="center">{{ $trabajo->Cantidad }}</td>
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
                @if($showObs)
                    <td class="obs">{{ $trabajo->Observaciones }}</td>
                @endif
            </tr>
        @endforeach
        @foreach($autocontrol as $i => $trabajo)
            <tr>
                <td class="center"></td>
                <td>{{ $trabajo->Trabajo }}</td>
                <td class="center">{{ $trabajo->Km_Inicio }}</td>
                <td class="center">{{ $trabajo->Km_Termino }}</td>
                <td class="center">{{ $trabajo->Unidad }}</td>
                <td class="center">{{ $trabajo->Cantidad }}</td>
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
                @if($showObs)
                    <td class="obs">{{ $trabajo->Observaciones }}</td>
                @endif
            </tr>
        @endforeach
    </table>
</div>
</body>

</html>
