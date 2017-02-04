{{-- Botón "flotante"
===================================================== --}}
<div class="btn-group pull-right" style="position: absolute; right: 15px; top: 50px;">
    <button type="button" class="btn btn-default dropdown-toggle glyphicon glyphicon-cog"
            data-toggle="dropdown" aria-expanded="false">
    </button>
    <ul class="dropdown-menu" role="menu">
        <li class="dropdown-header">Ubicaciones</li>
        <li><a data-toggle="modal" data-target="#modalDesviador" href="#">Nuevo desviador</a></li>
        <li><a data-toggle="modal" data-target="#modalDesvio" href="#">Nuevo desvío</a></li>
        <li class="divider"></li>
        <li class="dropdown-header">Trabajos</li>
        <li><a data-toggle="modal" data-target="#modalTrabajo" href="#">Nuevo trabajo</a></li>
        <li class="divider"></li>
        <li class="dropdown-header">Materiales</li>
        <li><a data-toggle="modal" data-target="#modalMaterialCol" href="#">Nuevo material colocado</a>
        </li>
        <li><a data-toggle="modal" data-target="#modalMaterialRet" href="#">Nuevo material retirado</a>
        </li>
    </ul>
</div>