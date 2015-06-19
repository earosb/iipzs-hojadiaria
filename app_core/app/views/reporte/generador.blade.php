{{-- Plantilla para crear generadores, ejemplos en docs/plantillas/ --}}
<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
    .cell {
        border: 1px solid #000000;
        height: 16px;
    }

    td {
        text-align: center;
        vertical-align: middle;
    }
</style>

<table>
    <tr>
        <td class="cell" colspan="2">PARTIDA</td>
        <td class="cell" colspan="4"><strong>{{ $trabajosMeta['nombre'] }}</strong></td>
    </tr>
    <tr>
        <td class="cell" colspan="2">FECHA</td>
        <td class="cell" colspan="4"><strong>{{ $trabajosMeta['fecha'] }}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="cell" colspan="2">SECTOR</td>
        <td class="cell" colspan="4"><strong>{{ $trabajosMeta['sector'] }}</strong></td>
    </tr>
    <tr>
        <td class="cell" colspan="2">BLOCK</td>
        <td class="cell" colspan="4"><strong>{{ $block }}</strong></td>
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
        <td class="cell" rowspan="2"><strong>OBSERVACIONES DE LA ITO</strong></td>
    </tr>
    <tr>
        <td class="cell"><strong>KM.</strong></td>
        <td class="cell"><strong>KM.</strong></td>
    </tr>
    @foreach($trabajos as $trabajo)
        <tr>
            <td class="cell">{{ $trabajo['km_inicio'] }}</td>
            <td class="cell">{{ $trabajo['km_termino'] }}</td>
            <td class="cell">{{ $trabajo['tipo_via'] }}</td>
            <td class="cell">{{ $trabajo['unidad'] }}</td>
            <td class="cell">{{ $trabajo['cantidad'] }}</td>
            <td class="cell"></td>
        </tr>
    @endforeach
    <tr>
        <td class="cell"></td>
        <td class="cell"></td>
        <td class="cell"></td>
        <td class="cell"><strong>TOTAL</strong></td>
        <td class="cell"><strong>{{ $trabajosMeta['total'] }}</strong></td>
        <td class="cell"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">____________________</td>
        <td colspan="2">____________________</td>
        <td colspan="2">____________________</td>
    </tr>
    <tr>
        <td colspan="2">NOMBRE T FIRMA CONTRATISTA PZS</td>
        <td colspan="2">NOMBRE Y FIRMA ITO</td>
        <td colspan="2">NOMBRE Y FIRMA SUBCONTRATISTA</td>
    </tr>

</table>

</html>