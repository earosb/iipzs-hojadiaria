<h4>Estimado(a) {{ $user['first_name'] }}</h4>

<p>Se detectaron los siguientes errores ingresando una nueva inspección desde iipzs-android.</p>

<table border="1" style="width:100%">
    <tr>
        <th>Trabajo</th>
        <th>Km Inicio</th>
        <th>Km Término</th>
        <th>Error</th>
    </tr>
    @foreach($errors as $error)
        <tr>
            <td>{{ $error['trabajo'] }}</td>
            <td>{{ $error['km_inicio'] }}</td>
            <td>{{ $error['km_termino'] }}</td>
            <td>{{ $error['msg'] }}</td>
        </tr>
    @endforeach
</table>

<p>--</p>
<p>Este es un correo electrónico generado automáticamente. Por favor no responder.</p>
<a href="http://icilicafalpzs.cl/">http://icilicafalpzs.cl/</a>
<p>
    <small>{{ Carbon\Carbon::parse(Carbon\Carbon::now('America/Santiago'))->format('d-m-Y h:i:s'); }}</small>
</p>