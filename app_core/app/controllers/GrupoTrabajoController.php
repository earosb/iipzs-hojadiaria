<?php

class GrupoTrabajoController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /grupo-trabajo
     *
     * @return Response
     */
    public function index()
    {
        $grupos = GrupoTrabajo::orderBy('base', 'asc')->get(array('id', 'base'));

        if (Request::ajax()) {
            return Response::json($grupos);
        }

        return View::make('grupo_trabajo.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /grupo-trabajo/create
     *
     * @return Response
     */
    public function create()
    {
        return Response::view('grupo_trabajo.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /grupo-trabajo
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();

        $validator = Validator::make($input, GrupoTrabajo::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        // Crea el grupo mágicamente :O
        GrupoTrabajo::create($input);

        return Redirect::to('m/grupo-trabajo');
    }

    /**
     * Display the specified resource.
     * GET /grupo-trabajo/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return Response::view('404');
    }

    /**
     * Show the form for editing the specified resource.
     * GET /grupo-trabajo/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $grupo = GrupoTrabajo::find($id);
        return View::make('grupo_trabajo.edit', compact('grupo'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /grupo-trabajo/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();

        $validator = Validator::make($input, GrupoTrabajo::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Actualiza mágicamente :/
        GrupoTrabajo::find($id)->update($input);

        return Redirect::to('m/grupo-trabajo');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /grupo-trabajo/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            GrupoTrabajo::destroy($id);
        } catch (\Exception $e) {
            return Response::json(array('error' => true,
                'msg' => $e->getMessage()));
        }
        return Response::json(array('error' => false));
    }

}