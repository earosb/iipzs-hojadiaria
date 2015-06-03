{{-- Plantilla para crear generadores, ejemplos en docs/plantillas/ --}}
<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
    .cell {
        border: 1px solid #000000;
    }

    td {
        alignment: center;
    }
</style>

<table>
    <tr>
        <td class="cell" colspan="2"><strong>PARTIDA</strong></td>
        <td class="cell" colspan="3"><strong>{{ $partida }}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="cell" colspan="2"><strong>SECTOR</strong></td>
        <td class="cell" colspan="2"><strong>BLOCK</strong></td>
        <td class="cell" colspan="2"><strong>FECHA</strong></td>
    </tr>
    <tr>
        <td class="cell" colspan="2"><strong>{{ $sector }}</strong></td>
        <td class="cell" colspan="2"><strong>{{ $block }}</strong></td>
        <td class="cell" colspan="2"><strong>{{ $month }} - {{ $year }}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="cell" colspan="2"><strong>LOCALIZACIÓN</strong></td>
        <td class="cell" rowspan="2"><strong>TIPO VÍA</strong></td>
        <td class="cell" rowspan="2"><strong>UNIDAD</strong></td>
        <td class="cell" rowspan="2"><strong>CANTIDAD</strong></td>
        <td class="cell" colspan="2" rowspan="2"><strong>OBSERVACIONES DE LA ITO</strong></td>
    </tr>
    <tr>
        <td class="cell"><strong>KM.</strong></td>
        <td class="cell"><strong>KM.</strong></td>
    </tr>
    @foreach($trabajos as $t)
        <tr>
            <td class="cell">{{ $t->km_inicio }}</td>
            <td class="cell">{{ $t->km_termino }}</td>
            @if($t->desviador_id)
                <td class="cell">DVR</td>
            @elseif($t->desvio_id)
                <td class="cell">DV</td>
            @else
                <td class="cell">LP</td>
            @endif
            <td class="cell">{{ $t->unidad }}</td>
            <td class="cell">{{ $t->cantidad }}</td>
            <td class="cell" colspan="2"></td>
        </tr>
    @endforeach
{{--

    <tr>
        <td class="cell" colspan="2">____________________</td>
        <td class="cell" colspan="2">____________________</td>
        <td class="cell" colspan="2">____________________</td>
    </tr>
    <tr>
        <td class="cell" colspan="2">NOMBRE T FIRMA CONTRATISTA PZS</td>
        <td class="cell" colspan="2">NOMBRE Y FIRMA  ITO</td>
        <td class="cell" colspan="2">NOMBRE Y FIRMA SUBCONTRATISTA</td>
    </tr>

--}}
</table>

</html>