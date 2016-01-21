<h4>Estimado(a) {{ $user->first_name }}</h4>

<p>Los siguientes <b>{{ $trabajos->count() }} trabajos</b> se encuentran pendientes y están próximos a su fecha de vencimiento.</p>

<table border="1" style="width:100%">
    <tr>
        <th>Causa</th>
        <th>Trabajo</th>
        <th>Km Inicio</th>
        <th>Km Término</th>
        <th>Cantidad</th>
        <th>Vencimiento</th>
    </tr>
    @foreach($trabajos as $trabajo)
        <tr>
            <td>{{ $trabajo->causa }}</td>
            <td>{{ $trabajo->nombre }}</td>
            <td>{{ $trabajo->km_inicio }}</td>
            <td>{{ $trabajo->km_inicio }}</td>
            <td>{{ $trabajo->cantidad }}</td>
            <td style="color: #FF0000;">{{ $trabajo->vencimiento }}</td>
        </tr>
    @endforeach
</table>

<p>--</p>
<p>Este es un correo electrónico generado automáticamente. Por favor no responder.</p>
<a href="http://icilicafalpzs.cl/">http://icilicafalpzs.cl/</a>
<p><small>{{ $time }}</small></p>