<?php

class BlockController extends \BaseController
{

    /**
     * Display a listing of block
     *
     * @return Response
     */
    public function index()
    {
        $blocks = Block::all();

        return View::make('block.index', compact('blocks'));
    }

    /**
     * Show the form for creating a new block
     *
     * @return Response
     */
    public function create()
    {
        $sectores = Sector::all(array('id', 'nombre'));
        return View::make('block.create', compact('sectores'));
    }

    /**
     * Store a newly created block in storage.
     * POST /block
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $sector = Sector::find($input['sector_id']);

        $rules = array(
            'sector_id' => 'required|exists:sector,id',
            'estacion' => 'required',
            'nro_bien' => 'required|max:10',
            'km_inicio' => 'required|numeric|between:' . $sector->km_inicio . ',' . $sector->km_termino,
            'km_termino' => 'required|numeric|between:' . $input['km_inicio'] . ',' . $sector->km_termino,
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Block::create($input);

        return Redirect::to('m/sector/' . $input['sector_id'] . '/blocks');
    }

    /**
     * Display the specified block.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $block = Block::findOrFail($id);
            $desvios = Block::find($id)->desvios;
            /*$desvios = Desvio::join('desviador', 'desviador.id', '=', 'desvio.desviador_norte_id')
                ->join('desviador', 'desviador.id', '=', 'desvio.desviador_sur_id')
                ->where('desvio.block_id', '=', $id)
                ->get('desvio.id', 'desvio.nombre', 'desvio.block_id', 'desvio.desviador_norte_id', 'desvio.desviador_sur_id');*/

            $desviadores = Block::find($id)->desviadores;

            return View::make('block.show')
                ->with('block', $block)
                ->with('desvios', $desvios)
                ->with('desviadores', $desviadores);
        } catch (\Exception $e) {
            return App::abort(404);
        }
    }

    /**
     * Show the form for editing the specified block.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $block = Block::find($id);

        return View::make('block.edit', compact('block'));
    }

    /**
     * Update the specified block in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $block = Block::find($id);

        $input = Input::all();

        $sector = Sector::find($block->sector_id);

        $rules = array(
            'sector_id' => 'required|exists:sector,id',
            'estacion' => 'required',
            'nro_bien' => 'required|max:10',
            'km_inicio' => 'required|numeric|between:' . $sector->km_inicio . ',' . $sector->km_termino,
            'km_termino' => 'required|numeric|between:' . $input['km_inicio'] . ',' . $sector->km_termino,
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $block->estacion = $input['estacion'];
        $block->nro_bien = $input['nro_bien'];
        $block->km_inicio = $input['km_inicio'];
        $block->km_termino = $input['km_termino'];

        $block->save();

        return Redirect::to('m/sector/' . $block->sector_id . '/blocks');
    }

    /**
     * Remove the specified block from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Block::destroy($id);
        } catch (\Exception $e) {
            return Response::json(array('error' => true,
                'msg' => $e->getMessage()));
        }
        return Response::json(array('error' => false));
    }

    /**
     * Retorna blocks de un sector.
     *
     * @param  int $sectorId
     * @return Response
     */
    public function ajaxBlocks($sectorId)
    {
        $blocks = Block::where('sector_id', '=', $sectorId)
            ->join('sector', 'block.sector_id', '=', 'sector.id')
            ->get(array('block.id', 'block.estacion', 'block.km_inicio', 'block.km_termino', 'block.sector_id', 'sector.km_inicio as sector_km_inicio', 'sector.km_termino as sector_km_termino'));

        //$ramales = Ramal::where('sector_id', '=', $sectorId)->get();

        return Response::json(
            array(
                'error' => false,
                'blocks' => $blocks,
                //'ramales' => $ramales
            )
        );
    }

    /**
     * Retorna todo lo que hay dentro de un block.
     * desvios y desviadores y datos del mismo block
     *
     * @param  int $idBlock
     * @return Response
     */
    public function ajaxBlockTodo($idBlock)
    {
        $block = Block::find($idBlock);
        $desvios = Block::find($idBlock)->desvios;
        $desviadores = Block::find($idBlock)->desviadores;

        return Response::json(
            array(
                'block' => $block,
                'desvios' => $desvios,
                'desviadores' => $desviadores,
            )
        );
    }

    /**
     * [ajaxGetLimites description]
     * @return json
     */
    public function ajaxGetLimites($data)
    {
        // explode() simil de función split()
        list($tipo, $id) = explode('-', $data);

        switch ($tipo) {
            case 'block':
                $block = Block::find($id);
                return Response::json(array(
                    'error' => false,
                    'tipo' => 'block',
                    'km_inicio' => $block->km_inicio,
                    'km_termino' => $block->km_termino
                ));
                break;
            case 'desvio':
                $desvio = Desvio::find($id);
                return Response::json(array(
                    'error' => false,
                    'tipo' => 'desvio',
                    'km_inicio' => $desvio->block->km_inicio,
                    'km_termino' => $desvio->block->km_termino
                ));
                break;
            case 'desviador':
                $desviador = Desviador::find($id);
                return Response::json(array(
                    'error' => false,
                    'tipo' => 'desviador',
                    'km_inicio' => $desviador->block->km_inicio,
                ));
                break;

            default:
                return Response::json(array(
                    'error' => true,
                    'msg' => 'Tipo de vía desconocido'
                ));
                break;
        }

    }

    /**
     * Retorna los desviadores existentes en el block
     * GET /block/{id}/desviadores
     * @param $id
     * @return json
     */
    public function getDesviadores($id)
    {
        try {
            $desviadores = Block::find($id)->desviadores;
            if ($desviadores->isEmpty()) {
                return Response::json(array(
                    'error' => true,
                    'msg' => 'El Block seleccionado no posee Desviadores',
                ));
            }
            return Response::json(array(
                'error' => false,
                'desviadores' => $desviadores,
            ));
        } catch (\Exception $e) {
            return Response::json(array(
                'error' => true,
                'msg' => 'Block no encontrado. Por favor, verifique su conexión a Internet'
            ));
        }
    }

}
