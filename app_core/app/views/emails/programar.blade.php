<h4>Estimado(a) {{ $user->first_name }}</h4>

<p>Los siguientes trabajos se encuentran pendientes y están proximos a su fecha de vencimiento.</p>

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
            <td>{{ $trabajo->vencimiento }}</td>
        </tr>
    @endforeach
</table>

<p>Este es un correo electrónico generado automáticamente. Por favor no responder.</p>