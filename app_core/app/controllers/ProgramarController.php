<?php

class ProgramarController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /programar
     *
     * @return Response
     */
    public function index()
    {
        //\Debugbar::disable();
        $trabajos = Trabajo::lists('nombre', 'id');
        return View::make('programar.index-angular')
            ->with('trabajos', $trabajos);
    }

    /**
     * Display a listing of the resource.
     * GET /programar/list
     *
     * @return Response
     */
    public function listJson()
    {
        $trabajos = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
            ->get();
        return Response::json($trabajos);
    }

    /**
     * Store a newly created resource in storage.
     * POST /programar
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validator = Validator::make($input, Programar::$rules);

        if ($validator->fails()) {
            return Response::json(
                array('error' => true, 'msg' => $validator->messages()));
        }

        $t = Programar::create($input);
        $trabajo = Programar::join('trabajo', 'trabajo.id', '=', 'trabajo_id')
            ->where('programar.id', '=', $t->id)
            ->first();

        return Response::json(
            array('error' => false, 't' => $trabajo));

    }

    /**
     * Display the specified resource.
     * GET /programar/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /programar/{id}/edit
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
     * PUT /programar/{id}
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
     * DELETE /programar/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}