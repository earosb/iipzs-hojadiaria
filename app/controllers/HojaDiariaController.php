<?php

use Carbon\Carbon;

class HojaDiariaController extends \BaseController
{

    /**
     * Show the form for creating a new resource.
     * GET /hd/create
     *
     * @return Response
     */
    public function create()
    {
        $sectores = Sector::all(array('id', 'nombre'));

        $trabajosCollection = Trabajo::all(array('id', 'nombre'));
        $trabajos = array();
        foreach ($trabajosCollection as $trabajo) {
            $trabajos[$trabajo->id] = $trabajo->nombre;
        }

        $grupos = GrupoTrabajo::all(array('id', 'base'));

        $materialesCollection = Material::all(array('id', 'nombre'));
        foreach ($materialesCollection as $material) {
            $materiales[$material->id] = $material->nombre;
        }

        $matRetCollection = MaterialRetirado::all(array('id', 'nombre'));
        foreach ($matRetCollection as $matRet) {
            $matRetirados[$matRet->id] = $matRet->nombre;
        }

        return View::make('hoja_diaria.create')
            ->with('sectores', $sectores)
            ->with('trabajos', $trabajos)
            ->with('grupos', $grupos)
            ->with('materiales', $materiales)
            ->with('materialesRet', $matRetirados);
    }

    /**
     * Display a listing of the resource.
     * GET /hd
     *
     * @return Response
     */
    public function index()
    {
        $hojasCollection = HojaDiaria::all();

        return View::make('hoja_diaria.index')
            ->with('hojas', $hojasCollection);
    }

    /**
     * Store a newly created resource in storage.
     * El formulario se valida en dos partes!
     * POST /hojadiaria
     *
     * @return Response
     */
    public function store()
    {
        /**
         * extrae todos los campos excepto los ocultos en el formulario
         */
        $input = Input::except('trabajos.0', 'matCol.0', 'matRet.0');
        /**
         * reglas de validación
         * @var array
         */
        $rules = array(
            'fecha'        => 'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector' => 'required|exists:sector,id',
            'selectblock'  => 'required|exists:block,id,sector_id,' . $input['selectsector'],
            'selectgrupos' => 'required|exists:grupo_trabajo,id',
        );
        /**
         * agrega reglas de validación si es que existen campos
         * @var [type]
         */
        foreach ($input['trabajos'] as $key => $value) {
            // explode() simil de función split()
            list($tipo, $id) = explode('-', $value['ubicacion']);
            switch ($tipo) {
                case 'block':
                    $block = Block::find($id);
                    $min = $block->km_inicio;
                    $max = $block->km_termino;
                    $rules['trabajos.' . $key . '.km_inicio'] = 'required|numeric|between:' . $min . ',' . $max;
                    $rules['trabajos.' . $key . '.km_termino'] = 'required|numeric|between:' . $min . ',' . $max;
                    break;
                case 'desvio':
                    $desvio = Desvio::find($id);
                    $min = $desvio->block->km_inicio;
                    $max = $desvio->block->km_termino;
                    $rules['trabajos.' . $key . '.km_inicio'] = 'required|numeric|between:' . $min . ',' . $max;
                    break;
                case 'desviador':
                    //$rules['trabajos.' . $key . '.ubicacion'] = 'required|exists:desviador,'.$id;
                    break;
            }
            $rules['trabajos.' . $key . '.ubicacion'] = 'required';
            $rules['trabajos.' . $key . '.trabajo'] = 'required|exists:trabajo,id';
            $rules['trabajos.' . $key . '.cantidad'] = 'required|numeric';

        }
        foreach ($input['matCol'] as $key => $value) {
            $rules['matCol.' . $key . '.id'] = 'required|exists:material,id';
            $rules['matCol.' . $key . '.cant'] = 'required|numeric';
        }
        foreach ($input['matRet'] as $key => $value) {
            $rules['matRet.' . $key . '.id'] = 'required|exists:material_retirado,id';
            $rules['matRet.' . $key . '.cant'] = 'required|numeric';
        }
        /**
         * lleva la validación acabo
         * @var [type]
         */
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json(
                array(
                    'fail'   => true,
                    'errors' => $validator->messages()
                ));
        }

        /**
         * Sin errores, listo para guardar
         */
        $dateFlag = Carbon::parse($input['fecha']);

        $hojaDiaria = new HojaDiaria();
        $hojaDiaria->fecha = $dateFlag->toDateString();
        $hojaDiaria->observaciones = $input['obs'];
        $hojaDiaria->grupo_via_id = $input['selectgrupos'];

        $hojaDiaria->save();

        foreach ($input['trabajos'] as $key => $value) {
            $trabajo = Trabajo::find($value['trabajo']);

            $detHojaDiaria = new DetalleHojaDiaria();
            $detHojaDiaria->trabajo_id = $trabajo->id;
            $detHojaDiaria->cantidad = $value['cantidad'];
            $detHojaDiaria->hoja_diaria_id = $hojaDiaria->id;
            switch ($tipo) {
                case 'block':
                    $block = Block::find($id);
                    $detHojaDiaria->block_id = $block->id;
                    $detHojaDiaria->km_inicio = $value['km_inicio'];
                    $detHojaDiaria->km_termino = $value['km_termino'];
                    break;
                case 'desvio':
                    $desvio = Desvio::find($id);
                    $detHojaDiaria->block_id = $desvio->block->id;
                    $detHojaDiaria->desvio_id = $desvio->id;
                    $detHojaDiaria->km_inicio = $value['km_inicio'];
                    $detHojaDiaria->km_termino = $value['km_termino'];
                    break;
                case 'desviador':
                    $desviador = Desviador::find($id);
                    $detHojaDiaria->block_id = $desviador->block->id;
                    $detHojaDiaria->desviador_id = $desviador->id;
                    $detHojaDiaria->km_inicio = $desviador->km_inicio;
                    break;
            }
            $detHojaDiaria->save();
        }

        foreach ($input['matCol'] as $key => $value) {
            $material = Material::find($value['id']);

            $detMatCol = new DetalleMaterialColocado();
            $detMatCol->cantidad = $value['cant'];
            $detMatCol->material_id = $material->id;
            $detMatCol->hoja_diaria_id = $hojaDiaria->id;

            $detMatCol->save();
        }

        foreach ($input['matRet'] as $key => $value) {
            $matRet = MaterialRetirado::find($value['id']);

            $detMatRet = new DetalleMaterialRetirado();
            $detMatRet->cantidad = $value['cant'];
            $detMatRet->material_retirado_id = $matRet->id;
            $detMatRet->hoja_diaria_id = $hojaDiaria->id;

            $detMatRet->save();
        }

        return Response::json(
            array(
                'fail'       => false,
                'input'      => $input,
                'hojaDiaria' => $hojaDiaria,
                'detMatCol'  => $detMatCol,
                'detMatRet'  => $detMatRet,
            ));

    }

    /**
     * Display the specified resource.
     * GET /hd/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $hojaDiaria = HojaDiaria::find($id);
        } catch (\Exception $e) {
            return Response::json(
                array(
                    'error' => true,
                    'msg'   => 'La hoja diaria seleccionada no fue encontrada'
                ));
        }

        $hojaDiaria->grupoTrabajo();

        $hojaDiaria->detalleMaterialRetirado;
        foreach ($hojaDiaria->detalleMaterialRetirado as $materialRet) {
            $materialRet->materialRetirado;
        }

        $hojaDiaria->detalleMaterialColocado;
        foreach ($hojaDiaria->detalleMaterialColocado as $materialCol) {
            $materialCol->material;
        }

        $hojaDiaria->detalleHojaDiaria;
        foreach ($hojaDiaria->detalleHojaDiaria as $trabajo)
        {
            $trabajo->trabajo;
        }

        return Response::json(
            array(
                'error'         => false,
                'hojaDiaria'    => $hojaDiaria,
            ));

    }

    /**
     * Show the form for editing the specified resource.
     * GET /hd/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /hd/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /hd/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
