<h4>Estimado(a) {{ $user['first_name'] }}</h4>

<p>Los siguientes <b>{{ $programs->count() }} trabajos</b> fueron ingresados desde iipzs-android y se encuentran
    disponibles para programar.</p>

<table border="1" style="width:100%">
    <tr>
        <th>Causa</th>
        <th>Trabajo</th>
        <th>Km Inicio</th>
        <th>Km Término</th>
        <th>Cantidad</th>
        <th>Observación</th>
    </tr>
    @foreach($programs as $program)
        <tr>
            <td>{{ $program->causa }}</td>
            <td>{{ $program->nombre }}</td>
            <td>{{ $program->km_inicio }}</td>
            <td>{{ $program->km_inicio }}</td>
            <td>{{ $program->cantidad }}</td>
            <td>{{ $program->obs }}</td>
        </tr>
    @endforeach
</table>

<p>--</p>
<p>Este es un correo electrónico generado automáticamente. Por favor no responder.</p>
<a href="http://icilicafalpzs.cl/">http://icilicafalpzs.cl/</a>
<p>
    <small>{{ Carbon\Carbon::parse(Carbon\Carbon::now('America/Santiago'))->format('d-m-Y h:i:s'); }}</small>
</p>