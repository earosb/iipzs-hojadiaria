<div class="modal fade" id="modalPlanificarTrabajo" tabindex="-1" role="dialog" aria-labelledby="modalPlanificarTrabajoLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalPlanificarTrabajoLabel">Editar trabajo</h4>
            </div>
            <div ng-controller="TrabajoController" class="modal-body">
                <h4>Editar trabajo</h4>
                @{{ tAux }}
                <p>Fin...</p>
            </div>
        </div>
    </div>
</div>