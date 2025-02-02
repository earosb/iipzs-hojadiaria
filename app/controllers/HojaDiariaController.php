<?php

use Carbon\Carbon;

class HojaDiariaController extends \BaseController
{

    /**
     * Show the form for creating a new resource.
     * GET /hd/create
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $sectores = Sector::all([ 'id', 'nombre' ]);

        $tipoMantenimiento = TipoMantenimiento::All([ 'id', 'nombre' ]);
        foreach ($tipoMantenimiento as $tMat) {
            $tMat->trabajos();
        }

        $grupos = GrupoTrabajo::orderBy('base', 'asc')->get([ 'id', 'base' ]);

        $materialesCollection = Material::orderBy('nombre')->get([ 'id', 'nombre', 'unidad' ]);
        $materiales           = [ ];
        foreach ($materialesCollection as $material) {
            $materiales[$material->id] = $material->nombre . ' (' . $material->unidad . ')';
        }

        $matRetCollection = MaterialRetirado::orderBy('nombre')->get([ 'id', 'nombre' ]);
        $matRetirados     = [ ];
        foreach ($matRetCollection as $matRet) {
            $matRetirados[$matRet->id] = $matRet->nombre;
        }

        $depositos = Deposito::orderBy('nombre')->get([ 'id', 'nombre' ]);

        return View::make('hoja_diaria.create')->with('sectores', $sectores)->with('grupos',
            $grupos)->with('materiales', $materiales)->with('materialesRet', $matRetirados)->with('depositos',
            $depositos)->with('tipoMantenimiento', $tipoMantenimiento);
    }


    /**
     * Display a listing of the resource.
     * GET /hd
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $paginate = ( Input::has('paginate') ? Input::get('paginate') : 20 );

        if (Input::has('month') && Input::has('year')) {
            if (Input::has('group')) {
                $allHojas = HojaDiaria::whereIn('grupo_trabajo_id', Input::get('group'))->whereMonth('fecha', '=',
                    Input::get('month'))->whereYear('fecha', '=', Input::get('year'))->orderBy('fecha',
                    'desc')->paginate($paginate);
            } else {
                $allHojas = HojaDiaria::whereMonth('fecha', '=', Input::get('month'))->whereYear('fecha', '=',
                    Input::get('year'))->orderBy('fecha', 'desc')->paginate($paginate);
            }
        } else {
            $allHojas = HojaDiaria::orderBy('fecha', 'desc')->paginate($paginate);
        }

        foreach ($allHojas as $hoja) {
            $hoja->user('username');
            $hoja->grupoTrabajo('base');
        }

        $grupos = GrupoTrabajo::orderBy('base', 'asc')->get([ 'id', 'base' ]);

        $year = Carbon::today()->year;

        return View::make('hoja_diaria.index')->with('allHojas',
            $allHojas->appends(Input::except('page')))->with('year', $year)->with('grupos', $grupos);
    }


    /**
     * Store a newly created resource in storage.
     * El formulario se valida en dos partes!
     * POST /hojadiaria
     *
     * @return \Illuminate\Http\JsonResponse
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
        $rules    = [
            'fecha'        => 'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector' => 'required|exists:sector,id',
            'selectblock'  => 'required|exists:block,id,sector_id,' . $input['selectsector'],
            'selectgrupos' => 'required|exists:grupo_trabajo,id',
        ];
        $messages = [
            'before' => 'Debe seleccionar una fecha anterior al día de hoy.',
        ];

        /**
         * agrega reglas de validación si es que existen campos
         * @var [type]
         */
        foreach ($input['trabajos'] as $key => $value) {
            // explode() simil de función split()
            list( $tipo, $id ) = explode('-', $value['ubicacion']);
            switch ($tipo) {
                case 'block':
                    $block                                     = Block::find($id);
                    $min                                       = $block->km_inicio;
                    $max                                       = $block->km_termino;
                    $rules['trabajos.' . $key . '.km_inicio']  = 'required|numeric|between:' . $min . ',' . $value['km_termino'];
                    $rules['trabajos.' . $key . '.km_termino'] = 'required|numeric|between:' . $value['km_inicio'] . ',' . $max;
                    break;
                case 'desvio':
                    $desvio                                   = Desvio::find($id);
                    $min                                      = $desvio->block->km_inicio;
                    $max                                      = $desvio->block->km_termino;
                    $rules['trabajos.' . $key . '.km_inicio'] = 'required|numeric|between:' . $min . ',' . $max;
                    break;
                case 'desviador':
                    $desviador = Desviador::find($id);
                    $min       = $desviador->km_inicio;
                    // Rango de 100 mts a cada lado por si las moscas los viejos ponen datos malos, en teoría debería ser un km exacto
                    $rules['trabajos.' . $key . '.km_inicio'] = 'required|numeric|between:' . ( $min - 100 ) . ',' . ( $min + 100 );
                    break;
            }
            $rules['trabajos.' . $key . '.ubicacion'] = 'required';
            $rules['trabajos.' . $key . '.trabajo']   = 'required|exists:trabajo,id';
            $rules['trabajos.' . $key . '.cantidad']  = 'required|numeric|min:0';

        }

        foreach ($input['matCol'] as $key => $value) {
            $rules['matCol.' . $key . '.id']       = 'required|exists:material,id';
            $rules['matCol.' . $key . '.deposito'] = 'required|exists:deposito,id';
            $rules['matCol.' . $key . '.cant']     = 'required|numeric|min:0';
        }

        foreach ($input['matRet'] as $key => $value) {
            $rules['matRet.' . $key . '.id']       = 'required|exists:material_retirado,id';
            $rules['matRet.' . $key . '.deposito'] = 'required|exists:deposito,id';
            $rules['matRet.' . $key . '.cant']     = 'required|numeric|min:0';
        }

        /**
         * lleva la validación acabo
         * @var [type]
         */
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'msg'   => $validator->messages()
            ]);
        }

        /**
         * Sin errores, listo para guardar
         */
        $dateFlag = Carbon::createFromFormat('d/m/Y', $input['fecha']);

        $hojaDiaria                   = new HojaDiaria();
        $hojaDiaria->fecha            = $dateFlag->toDateString();
        $hojaDiaria->observaciones    = $input['obs'];
        $hojaDiaria->grupo_trabajo_id = $input['selectgrupos'];
        $hojaDiaria->user_id          = Sentry::getUser()->id;

        $hojaDiaria->save();

        foreach ($input['trabajos'] as $key => $value) {
            list( $tipo, $id ) = explode('-', $value['ubicacion']);

            $trabajo = Trabajo::find($value['trabajo']);

            $detHojaDiaria                 = new DetalleHojaDiaria();
            $detHojaDiaria->trabajo_id     = $trabajo->id;
            $detHojaDiaria->cantidad       = $value['cantidad'];
            $detHojaDiaria->hoja_diaria_id = $hojaDiaria->id;
            switch ($tipo) {
                case 'block':
                    $block                     = Block::find($id);
                    $detHojaDiaria->block_id   = $block->id;
                    $detHojaDiaria->km_inicio  = $value['km_inicio'];
                    $detHojaDiaria->km_termino = $value['km_termino'];
                    $detHojaDiaria->tipo_via   = 'LP'; // Linea principal
                    break;
                case 'desvio':
                    $desvio                    = Desvio::find($id);
                    $detHojaDiaria->block_id   = $desvio->block->id;
                    $detHojaDiaria->desvio_id  = $desvio->id;
                    $detHojaDiaria->km_inicio  = $value['km_inicio'];
                    $detHojaDiaria->km_termino = $value['km_termino'];
                    $detHojaDiaria->tipo_via   = $desvio->nombre; // Nombre del desvio
                    break;
                case 'desviador':
                    $desviador                   = Desviador::find($id);
                    $detHojaDiaria->block_id     = $desviador->block->id;
                    $detHojaDiaria->desviador_id = $desviador->id;
                    $detHojaDiaria->km_inicio    = $value['km_inicio']; // $desviador->km_inicio;
                    $detHojaDiaria->km_termino   = $value['km_inicio'];
                    $detHojaDiaria->tipo_via     = $desviador->nombre; // Nombre del desviador
                    break;
            }
            $detHojaDiaria->save();
        }

        $lastSaldo = DepositoHistorico::orderBy('created_at', 'desc')->first()->saldo;
        $depHistoricos = array();

        foreach ($input['matCol'] as $key => $value) {
            $detMatCol                 = new DetalleMaterialColocado();
            $detMatCol->cantidad       = $value['cant'];
            $detMatCol->reempleo       = ( array_key_exists('reempleo', $value) ) ? true : false;
            $detMatCol->material_id    = $value['id'];
            $detMatCol->hoja_diaria_id = $hojaDiaria->id;
            $detMatCol->deposito_id    = $value['deposito'];

            $detMatCol->save();

            $lastSaldo -= $detMatCol->cantidad;
            $depHistoricos[] = [
                'ingreso' => null,
                'egreso' => $detMatCol->cantidad,
                'descripcion' => null,
                'saldo' => $lastSaldo,
                'deposito_id' => $detMatCol->deposito_id,
                'material_id' => $detMatCol->material_id,
                'material_retirado_id' => null,
                'hoja_diaria_id' => $hojaDiaria->id,
            ];
        }

        foreach ($input['matRet'] as $key => $value) {
            $detMatRet                       = new DetalleMaterialRetirado();
            $detMatRet->cantidad             = $value['cant'];
            $detMatRet->reempleo             = ( array_key_exists('reempleo', $value) ) ? true : false;
            $detMatRet->material_retirado_id = $value['id'];
            $detMatRet->hoja_diaria_id       = $hojaDiaria->id;
            $detMatRet->deposito_id          = $value['deposito'];

            $detMatRet->save();

            $lastSaldo += $detMatRet->cantidad;
            $depHistoricos[] = [
                'ingreso' => $detMatRet->cantidad,
                'egreso' => null,
                'descripcion' => null,
                'saldo' => $lastSaldo,
                'deposito_id' => $detMatCol->deposito_id,
                'material_id' => $detMatCol->material_id,
                'material_retirado_id' => null,
                'hoja_diaria_id' => $hojaDiaria->id,
            ];
        }

        DepositoHistorico::create(array('name' => 'John'));

        return Response::json([
            'error' => false,
            'msg'   => 'Hoja Diaria creada con éxito'
        ]);

    }


    /**
     * Display the specified resource.
     * GET /hd/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        try {
            $hojaDiaria = HojaDiaria::find($id);
        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'msg'   => 'La hoja diaria seleccionada no fue encontrada'
            ]);
        }

        $hojaDiaria->fecha = Carbon::parse($hojaDiaria->fecha)->format('d-m-Y');

        $hojaDiaria->grupoTrabajo;

        $hojaDiaria->detalleMaterialColocado;
        foreach ($hojaDiaria->detalleMaterialColocado as $materialCol) {
            $materialCol->material;
            $materialCol->deposito;
        }

        $hojaDiaria->detalleMaterialRetirado;
        foreach ($hojaDiaria->detalleMaterialRetirado as $materialRet) {
            $materialRet->materialRetirado;
            $materialRet->deposito;
        }

        $hojaDiaria->detalleHojaDiaria;
        foreach ($hojaDiaria->detalleHojaDiaria as $trabajo) {
            $trabajo->trabajo;
            $trabajo->block;
            $trabajo->desvio;
            $trabajo->desviador;
        }

        return Response::json([
            'error'      => false,
            'hojaDiaria' => $hojaDiaria,
        ]);

    }


    /**
     * Show the form for editing the specified resource.
     * GET /hd/{id}/edit
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hoja        = HojaDiaria::findOrFail($id);
        $hoja->fecha = Carbon::parse($hoja->fecha)->format('d/m/Y');

        $hoja->detalleMaterialColocado;
        foreach ($hoja->detalleMaterialColocado as $materialCol) {
            $materialCol->material;
            $materialCol->deposito;
        }

        $hoja->detalleMaterialRetirado;
        foreach ($hoja->detalleMaterialRetirado as $materialRet) {
            $materialRet->materialRetirado;
            $materialRet->deposito;
        }

        $hoja->detalleHojaDiaria;
        foreach ($hoja->detalleHojaDiaria as $trabajo) {
            $trabajo->trabajo;
            $trabajo->block;
            $trabajo->desvio;
            $trabajo->desviador;
        }

        $sectores = Sector::all([ 'id', 'nombre' ]);

        $tipoMantenimiento = TipoMantenimiento::All([ 'id', 'nombre' ]);
        foreach ($tipoMantenimiento as $tMat) {
            $tMat->trabajos;
        }

        $grupos = GrupoTrabajo::orderBy('base', 'asc')->get([ 'id', 'base' ]);

        $materialesCollection = Material::orderBy('nombre')->get([ 'id', 'nombre', 'unidad' ]);
        $materiales           = [ ];
        foreach ($materialesCollection as $material) {
            $materiales[$material->id] = $material->nombre . ' (' . $material->unidad . ')';
        }

        $matRetCollection = MaterialRetirado::orderBy('nombre')->get([ 'id', 'nombre' ]);
        $matRetirados     = [ ];
        foreach ($matRetCollection as $matRet) {
            $matRetirados[$matRet->id] = $matRet->nombre;
        }

        $depositosCollection = Deposito::orderBy('nombre')->get([ 'id', 'nombre' ]);
        $depositos           = [ ];
        foreach ($depositosCollection as $dep) {
            $depositos[$dep->id] = $dep->nombre;
        }

        $idBlock     = $hoja->detalleHojaDiaria[0]->block_id;
        $block       = Block::find($idBlock);
        $desvios     = Block::find($idBlock)->desvios;
        $desviadores = Block::find($idBlock)->desviadores;

        $blockTodo = [ "block-" . $idBlock => "Vía principal" ];
        foreach ($desvios as $desvio) {
            $blockTodo += [ "desvio-" . $desvio->id => $desvio->nombre ];
        }
        foreach ($desviadores as $desviador) {
            $blockTodo += [ "desviador-" . $desviador->id => $desviador->nombre ];
        }

        return View::make('hoja_diaria.edit', compact('hoja'))->with('sectores', $sectores)->with('grupos',
            $grupos)->with('materiales', $materiales)->with('materialesRet', $matRetirados)->with('depositos',
            $depositos)->with('tipoMantenimiento', $tipoMantenimiento)->with('blockTodo', $blockTodo);
    }


    /**
     * Update the specified resource in storage.
     * PUT /hd/{id}
     *
     * @param  int $idHoja
     *
     * @return Response
     */
    public function update($idHoja)
    {
        /**
         * extrae todos los campos excepto los ocultos en el formulario
         */
        $input = Input::except('trabajos.0', 'matCol.0', 'matRet.0');
        /**
         * reglas de validación
         * @var array
         */
        $rules    = [
            'fecha'        => 'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector' => 'required|exists:sector,id',
            'selectblock'  => 'required|exists:block,id,sector_id,' . $input['selectsector'],
            'selectgrupos' => 'required|exists:grupo_trabajo,id',
        ];
        $messages = [
            'before' => 'Debe seleccionar una fecha anterior a hoy.',
        ];
        /**
         * agrega reglas de validación si es que existen campos
         * @var [type]
         */
        foreach ($input['trabajos'] as $key => $value) {
            // explode() simil de función split()
            list( $tipo, $id ) = explode('-', $value['ubicacion']);
            switch ($tipo) {
                case 'block':
                    $block                                     = Block::find($id);
                    $min                                       = $block->km_inicio;
                    $max                                       = $block->km_termino;
                    $rules['trabajos.' . $key . '.km_inicio']  = 'required|numeric|between:' . $min . ',' . $value['km_termino'];
                    $rules['trabajos.' . $key . '.km_termino'] = 'required|numeric|between:' . $value['km_inicio'] . ',' . $max;
                    break;
                case 'desvio':
                    $desvio                                   = Desvio::find($id);
                    $min                                      = $desvio->block->km_inicio;
                    $max                                      = $desvio->block->km_termino;
                    $rules['trabajos.' . $key . '.km_inicio'] = 'required|numeric|between:' . $min . ',' . $max;
                    break;
                case 'desviador':
                    $desviador = Desviador::find($id);
                    $min       = $desviador->km_inicio;
                    // Rango de 100 mts a cada lado por si las moscas los viejos ponen datos malos, en teoría debería ser un km exacto
                    $rules['trabajos.' . $key . '.km_inicio'] = 'required|numeric|between:' . ( $min - 100 ) . ',' . ( $min + 100 );
                    break;
            }
            $rules['trabajos.' . $key . '.ubicacion'] = 'required';
            $rules['trabajos.' . $key . '.trabajo']   = 'required|exists:trabajo,id';
            $rules['trabajos.' . $key . '.cantidad']  = 'required|numeric|min:0';

        }
        foreach ($input['matCol'] as $key => $value) {
            $rules['matCol.' . $key . '.id']   = 'required|exists:material,id';
            $rules['matCol.' . $key . '.deposito']   = 'required|exists:deposito,id';
            $rules['matCol.' . $key . '.cant'] = 'required|numeric|min:0';
        }
        foreach ($input['matRet'] as $key => $value) {
            $rules['matRet.' . $key . '.id']       = 'required|exists:material_retirado,id';
            $rules['matRet.' . $key . '.deposito'] = 'required|exists:deposito,id';
            $rules['matRet.' . $key . '.cant']     = 'required|numeric|min:0';
        }
        /**
         * lleva la validación acabo
         * @var [type]
         */
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'msg'   => $validator->messages()
            ]);
        }

        $hojaDiaria = HojaDiaria::find($idHoja);
        $hojaDiaria->touch();

        $hojaDiaria->detalleHojaDiaria()->forceDelete();
        $hojaDiaria->detalleMaterialColocado()->forceDelete();
        $hojaDiaria->detalleMaterialRetirado()->forceDelete();
        //$hojaDiaria->forceDelete();

        /**
         * Sin errores, listo para guardar
         */
        $dateFlag = Carbon::createFromFormat('d/m/Y', $input['fecha']);

        $hojaDiaria->fecha            = $dateFlag->toDateString();
        $hojaDiaria->observaciones    = $input['obs'];
        $hojaDiaria->grupo_trabajo_id = $input['selectgrupos'];
        $hojaDiaria->user_id          = Sentry::getUser()->id;
        $hojaDiaria->save();

        foreach ($input['trabajos'] as $key => $value) {
            list( $tipo, $id ) = explode('-', $value['ubicacion']);

            $trabajo = Trabajo::find($value['trabajo']);

            $detHojaDiaria                 = new DetalleHojaDiaria();
            $detHojaDiaria->trabajo_id     = $trabajo->id;
            $detHojaDiaria->cantidad       = $value['cantidad'];
            $detHojaDiaria->hoja_diaria_id = $hojaDiaria->id;
            switch ($tipo) {
                case 'block':
                    $block                     = Block::find($id);
                    $detHojaDiaria->block_id   = $block->id;
                    $detHojaDiaria->km_inicio  = $value['km_inicio'];
                    $detHojaDiaria->km_termino = $value['km_termino'];
                    $detHojaDiaria->tipo_via   = 'LP'; // Linea principal
                    break;
                case 'desvio':
                    $desvio                    = Desvio::find($id);
                    $detHojaDiaria->block_id   = $desvio->block->id;
                    $detHojaDiaria->desvio_id  = $desvio->id;
                    $detHojaDiaria->km_inicio  = $value['km_inicio'];
                    $detHojaDiaria->km_termino = $value['km_termino'];
                    $detHojaDiaria->tipo_via   = $desvio->nombre; // Nombre del desvio
                    break;
                case 'desviador':
                    $desviador                   = Desviador::find($id);
                    $detHojaDiaria->block_id     = $desviador->block->id;
                    $detHojaDiaria->desviador_id = $desviador->id;
                    $detHojaDiaria->km_inicio    = $value['km_inicio']; // $desviador->km_inicio;
                    $detHojaDiaria->km_termino   = $value['km_inicio'];
                    $detHojaDiaria->tipo_via     = $desviador->nombre; // Nombre del desviador
                    break;
            }
            $detHojaDiaria->save();
        }

        foreach ($input['matCol'] as $key => $value) {
            $material = Material::find($value['id']);

            $detMatCol                 = new DetalleMaterialColocado();
            $detMatCol->cantidad       = $value['cant'];
            $detMatCol->reempleo       = ( array_key_exists('reempleo', $value) ) ? true : false;
            $detMatCol->material_id    = $material->id;
            $detMatCol->hoja_diaria_id = $hojaDiaria->id;

            $detMatCol->save();
        }

        foreach ($input['matRet'] as $key => $value) {
            $matRet = MaterialRetirado::find($value['id']);

            $detMatRet                       = new DetalleMaterialRetirado();
            $detMatRet->cantidad             = $value['cant'];
            $detMatRet->reempleo             = ( array_key_exists('reempleo', $value) ) ? true : false;
            $detMatRet->material_retirado_id = $matRet->id;
            $detMatRet->hoja_diaria_id       = $hojaDiaria->id;
            $detMatRet->deposito_id          = $value['deposito'];

            $detMatRet->save();
        }

        return Response::json([
            'error' => false,
            'edit'  => true
        ]);

    }


    /**
     * Remove the specified resource from storage.
     * DELETE /hd/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $hojaDiaria = HojaDiaria::find($id);

            $hojaDiaria->detalleHojaDiaria()->forceDelete();
            $hojaDiaria->detalleMaterialColocado()->forceDelete();
            $hojaDiaria->detalleMaterialRetirado()->forceDelete();
            $hojaDiaria->forceDelete();

            return Response::json([ 'error' => false, ]);

        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'msg'   => 'Ocurrió un error al intentar eliminar la hoja diaria',
            ]);
        }
    }

}
