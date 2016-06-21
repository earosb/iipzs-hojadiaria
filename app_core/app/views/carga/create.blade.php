<div class="panel panel-default">
    <div class="panel-heading">Nueva carga {{ $deposito->nombre }}</div>
    <div class="panel-body">
        {{ Form::open(['url' => 'm/carga', 'class' => 'form-horizontal', 'id' => 'causaForm']) }}

        <fieldset>

            <div class="hidden">
                <label class="col-md-4 control-label" for="deposito_id">deposito_id</label>

                <div class="col-md-4">
                    <input id="deposito_id" name="deposito_id" type="number" value="{{ $deposito->id }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="alias">Nombre</label>

                <div class="col-md-4">
                    <input id="alias" name="alias" type="text" class="form-control input-md">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="fecha">Total</label>

                <div class="col-md-4">
                    <input id="fecha" name="fecha" type="date" class="form-control input-md">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="total">Total</label>

                <div class="col-md-4">
                    <input id="total" name="total" type="number" class="form-control input-md" min="0">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="material_id">Material</label>

                <div class="col-md-4">
                    <select name="material_id" id="material_id" class="form-control">
                        @foreach($materiales as $material)
                            <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 pull-right">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                </div>
            </div>

        </fieldset>
        {{ Form::close() }}
    </div>
</div>