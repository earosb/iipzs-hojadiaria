<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div style="inline-box-align: ">
    <img src="{{ asset('img/logo_efe.png') }}" alt="Logo Efe" height="53" width="70"/>

    <strong>Formulario de Trabajos Ejecutados</strong>
</div>
<table>
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Estación inicio</th>
        <th>Estación término</th>
        <th>Km Inicio</th>
        <th>Km Término</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sectores as $sector)
        <tr>
            <td>
                {{ $sector->nombre }}
            </td>
            <td>
                {{ $sector->estacion_inicio }}
            </td>
            <td>
                {{ $sector->estacion_termino }}
            </td>
            <td>
                {{ $sector->km_inicio }}
            </td>
            <td>
                {{ $sector->km_termino }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>