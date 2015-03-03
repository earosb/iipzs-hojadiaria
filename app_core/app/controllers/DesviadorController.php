<?php

class DesviadorController extends \BaseController
{

    /**
     * Show the form for creating a new desviador
     *
     * @return Response
     */
    public function create()
    {
        $sectores = Sector::all(array('id', 'nombre'));
        return View::make('desviador.create', compact('sectores'));
    }

    /**
     * Store a newly created desviador in storage.
     * POST /block
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        /**
         * Valida que el block sea mayor que cero antes de consultar si existe
         */
        if (!isset($input['block'])) {
            if (Request::ajax()) {
                return Response::json(array('fail' => true,
                    'errors' => array('block' => array('Debe seleccionar un Block'))));
            }
            return Redirect::back()->withInput();
        }

        $block = Block::findOrFail($input['block']);

        $rules = array(
            'nombre' => 'required',
            'km_inicio' => 'required|numeric|between:' . $block->km_inicio . ',' . $block->km_termino,
            'sector' => 'required|numeric',
            'block' => 'required|numeric',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            if (Request::ajax()) {
                return Response::json(array('error' => true,
                    'msg' => $validator->messages()));
            }
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            // Crea el obj Desviador y lo guarda
            $desviador = new Desviador;

            $desviador->nombre = $input['nombre'];
            $desviador->km_inicio = $input['km_inicio'];
            $desviador->block_id = $input['block'];

            $desviador->save();
            if (Request::ajax()) {
                return Response::json(array('error' => false,
                    'msg' => 'Nuevo Desviador creado con éxito'));
            }
            return Redirect::to('m/block/' . $desviador->block_id);
        }
    }

    /**
     * Display the specified desviador.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        App::abort(404);
    }

    /**
     * Show the form for editing the specified desviador.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $desviador = Desviador::find($id);

        return View::make('desviador.edit', compact('desviador'));
    }

    /**
     * Update the specified desviador in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $desviador = Desviador::findOrFail($id);
        $input = Input::all();

        $block = Block::findOrFail($input['block']);

        $rules = array(
            'nombre' => 'required',
            'km_inicio' => 'required|numeric|between:' . $block->km_inicio . ',' . $block->km_termino,
            'block' => 'required|numeric',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $desviador->nombre = $input['nombre'];
        $desviador->km_inicio = $input['km_inicio'];
        $desviador->block_id = $input['block'];

        $desviador->save();

        return Redirect::to('m/block/' . $desviador->block_id);
    }

    /**
     * Remove the specified desviador from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Desviador::destroy($id);

        return Response::json(array('error' => false));
    }

    /**
     * Guarda un nuevo Desviador
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxCreate()
    {
        $input = array(
            '_token' => Input::get('_token'),
            'nombre' => Input::get('nombre'),
            'km_inicio' => Input::get('km_inicio'),
            'selectsectorDesviador' => Input::get('selectsectorDesviador'),
            'selectblockDesviador' => Input::get('selectblockDesviador'),
        );
        /**
         * Valida que el block sea mayor que cero antes de consultar si existe
         */
        if ($input['selectblockDesviador'] <= 0) {
            return Response::json(array('fail' => true,
                'errors' => array(
                    'selectblockDesviador' => array('Debe seleccionar un Block'))));
        }

        $block = Block::findOrFail($input['selectblockDesviador']);

        $rules = array(
            'nombre' => 'required',
            'km_inicio' => 'required|numeric|between:' . $block->km_inicio . ',' . $block->km_termino,
            'selectsectorDesviador' => 'required|numeric',
            'selectblockDesviador' => 'required|numeric',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json(array('error' => true,
                'msg' => $validator->messages()));
        } else {
            // Crea el obj Desviador y lo guarda
            $desviador = new Desviador;

            $desviador->nombre = $input['nombre'];
            $desviador->km_inicio = $input['km_inicio'];
            $desviador->block_id = $input['selectblockDesviador'];

            $desviador->save();

            return Response::json(array('error' => false,
                'msg' => 'Nuevo Desviador creado con éxito'));
        }
    }

    /**
     * Retorna los desviadores al sur
     * @param $idNorte
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDesviadoresSur($idNorte)
    {
        try {
            $norte = Desviador::find($idNorte);
            $desviadores = Desviador::where('block_id', '=', $norte->block_id)
                ->where('km_inicio', '>', $norte->km_inicio)
                ->get();
            if ($desviadores->isEmpty()) {
                return Response::json(array('error' => true,
                    'msg' => 'El Desviador seleccionado no tiene Desviadores hacia el Sur'));
            }
            return Response::json(array('error' => false,
                'desviadores' => $desviadores));
        } catch (\Exception $e) {
            return Response::json(array('error' => true,
                'msg' => 'Desviador no encontrado'));
        }

    }


}