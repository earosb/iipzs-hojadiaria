{{--
 * Created by PhpStorm.
 * User: earosb
 * Date: 04-02-15
 * Time: 22:53
--}}

{{-- Modal form TRABAJO
===================================================== --}}
<div class="modal fade" id="modalTrabajo" tabindex="-1" role="dialog" aria-labelledby="modalTrabajoLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTrabajoLabel">Nuevo Trabajo</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Nombre</label>

                            <div class="col-sm-10">
                                <input type="text" placeholder="Nombre Trabajo" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Oficial</label>

                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"><abbr
                                                title="Quiere decir que será incluido en el Form 2-3-4">¿Qué es
                                            esto?</abbr>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tipo</label>

                            <div class="col-sm-10">
                                <div class="radio">
                                    <label>
                                        <input name="optionsRadios" id="optionsRadios1" value="option1" checked=""
                                               type="radio">
                                        Mantenimiento menor
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="optionsRadios" id="optionsRadios2" value="option2" type="radio">
                                        Mantenimiento mayor
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>