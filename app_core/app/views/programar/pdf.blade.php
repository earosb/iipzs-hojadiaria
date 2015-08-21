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
<h3>Hoja Semanal de Trabajo </h3>

<div>
    <table>
        <tr>
            <th>Grupo Vía</th>
            <td>{{$grupo->base}}</td>
            <th>Semana</th>
            <td>{{$semana}}</td>
        </tr>
    </table>
</div>
<br>

<div>
    <table>
        <tr>
            <th></th>
            <th colspan="5">Programa Semanal</th>
            <th colspan="7">Trabajo Ejecutado</th>
        </tr>
        <tr>
            <th rowspan="2">#</th>
            <th width="40%" rowspan="2">Descripción Trabajo</th>
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
            </tr>
        @endforeach
    </table>
</div>
</body>

</html>
