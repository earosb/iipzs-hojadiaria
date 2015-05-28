{{-- Plantilla para crear generadores, ejemplos en docs/plantillas/ --}}

<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
    .cell {
        border: 1px solid #000000;
    }

    td {
        align: center;
    }
</style>

<table>
    <tr>
        <td class="cell">*</td>
        <td class="cell"><h1>TITULO BRIGIDO</h1></td>
        <td class="cell">*</td>
    </tr>
    <tr>
        <td class="cell"><strong>SECTOR</strong></td>
        <td class="cell"><strong>BLOCK</strong></td>
        <td class="cell"><strong>FECHA</strong></td>
    </tr>
    <tr>
        <td class="cell"><strong>{{ $sector }}</strong></td>
        <td class="cell"><strong>{{ $block }}</strong></td>
        <td class="cell"><strong></strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="cell" colspan="2"><strong>LOCALIZACIÓN</strong></td>
        <td class="cell" rowspan="2"><strong>PARTIDA</strong></td>
        <td class="cell" rowspan="2"><strong>UNIDAD</strong></td>
        <td class="cell" rowspan="2"><strong>CANTIDAD</strong></td>
        <td class="cell" rowspan="2"><strong>OBSERVACIONES DE LA ITO</strong></td>
        <td class="cell" rowspan="2"><strong>TOTAL</strong></td>
    </tr>
    <tr>
        <td class="cell"><strong>KM.</strong></td>
        <td class="cell"><strong>KM.</strong></td>
    </tr>
    @foreach($trabajos as $t)
        <tr>
            <td class="cell">{{ $t->km_inicio }}</td>
            <td class="cell">{{ $t->km_termino }}</td>
            <td class="cell">{{ $t->nombre }}</td>
            <td class="cell">{{ $t->unidad }}</td>
            <td class="cell">{{ $t->cantidad }}</td>
            <td class="cell"></td>
            <td class="cell">{{ $t->cantidad }}</td>
        </tr>
    @endforeach
    <tr>
        <td class="cell"></td>
        <td class="cell"></td>
        <td class="cell"></td>
        <td class="cell"></td>
        <td class="cell"></td>
        <td class="cell"><strong>TOTAL</strong></td>
        <td class="cell"></td>
    </tr>

</table>

</html>