<?php

class CausasController extends \BaseController
{
    /**
     * Display a listing of the resource.
     * GET /causa
     *
     * @return Response
     */
    public function index()
    {
        //$causas = Causa::all();
        $causas = Causa::join('causa_version', 'causa_version.causa_id', '=', 'causa.id')
            ->get(array('causa.id', 'causa', 'vencimiento', 'version'));
        return Response::json($causas);
    }

    /**
     * Store a newly created resource in storage.
     * POST /causa
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /causa/{id}
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
     * GET /causa/{id}/edit
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
     * PUT /causa/{id}
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
     * DELETE /causa/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}