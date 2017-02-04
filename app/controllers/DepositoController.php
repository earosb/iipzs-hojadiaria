<?php

class DepositoController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /deposito
     *
     * @return Response
     */
    public function index()
    {
        $depositos = Deposito::orderBy('nombre')->get([ 'id', 'nombre' ]);

        return View::make('deposito.index', compact('depositos'));
    }


    /**
     * Show the form for creating a new resource.
     * GET /deposito/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make('deposito.create');
    }


    /**
     * GET /deposito/id
     *
     * @param $id
     *
     * @return Response
     */
    public function show($id)
    {
        $deposito = Deposito::findOrFail($id);
        $cargas   = Carga::join('material', 'material.id', '=', 'material_id')
            ->where('deposito_id', '=', $deposito->id)
            ->orderBy('carga.fecha', 'desc')
            ->get([
                'carga.fecha',
                'carga.total',
                'carga.obs',
                'material.nombre as material'
            ]);

        $html = View::make('deposito.show', compact('deposito', 'cargas'))->render();
        if (Request::ajax()) {
            return Response::json([ 'html' => $html ]);
        }

        return App::abort(404);
    }


    /**
     * Store a newly created resource in storage.
     * POST /deposito
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $validator = Validator::make($input, Deposito::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Deposito::create($input);

        return Redirect::to('m/deposito');
    }


    /**
     * Show the form for editing the specified resource.
     * GET /deposito/{id}/edit
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $deposito = Deposito::find($id);

        return View::make('deposito.edit', compact('deposito'));
    }


    /**
     * Update the specified resource in storage.
     * PUT /deposito/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        $validator = Validator::make($input, Deposito::$rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Deposito::find($id)->update($input);

        return Redirect::to('m/deposito');
    }


    /**
     * Remove the specified resource from storage.
     * DELETE /deposito/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Deposito::destroy($id);
        } catch (\Exception $e) {
            return Response::json([
                'error' => true,
                'msg'   => $e->getMessage()
            ]);
        }

        return Response::json([ 'error' => false ]);
    }

}