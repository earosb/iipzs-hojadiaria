<?php

/**
 *
 * @author earosb
 */
class MaterialRetiradoController extends \BaseController
{
    /**
     * Display a listing of the resource.
     * GET /materialretirado
     *
     * @return Response
     */
    public function index()
    {
        App::abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * GET /materialretirado/create
     *
     * @return Response
     */
    public function create()
    {
        return Response::view('material.createRetirado');
    }

    /**
     * Store a newly created resource in storage.
     * POST /materialretirado
     *
     * @return Response
     */
    public function store()
    {
        $input = array(
            '_token' => Input::get('_token'),
            'nombre' => Input::get('nombre'),
            'clase' => Input::get('clase'),
            'es_oficial' => Input::get('es_oficial'),
        );

        $validator = Validator::make($input, MaterialRetirado::$rules);

        if ($validator->fails()) {
            if (Request::ajax()) {
                return Response::json(array('error' => true,
                    'msg' => $validator->messages()));
            }
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $matRet = new MaterialRetirado();

        $matRet->nombre = $input['nombre'];
        if ($input['es_oficial'])
            $matRet->es_oficial = true;
        else
            $matRet->es_oficial = false;
        $matRet->save();

        if (Request::ajax()) {
            return Response::json(array('error' => false,
                'nuevoMatRet' => $matRet,
                'msg' => 'Nuevo Material Retirado creado con éxito'));
        }
        return Redirect::to('m/material');
    }

    /**
     * Display the specified resource.
     * GET /materialretirado/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        App::abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /materialretirado/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $matRet = MaterialRetirado::find($id);
        return View::make('material.editRetirado', compact('matRet'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /materialretirado/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $matRet = MaterialRetirado::find($id);

        $input = array(
            '_token' => Input::get('_token'),
            'nombre' => Input::get('nombre'),
            'es_oficial' => Input::get('es_oficial'),
        );

        $validator = Validator::make($input, MaterialRetirado::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $matRet->nombre = $input['nombre'];
        $matRet->es_oficial = (isset($input['es_oficial'])) ? true : false;

        $matRet->save();

        return Redirect::to('m/material');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /materialretirado/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            MaterialRetirado::destroy($id);
        } catch (\Exception $e) {
            return Response::json(array('error' => true,
                'msg' => $e->getMessage()));
        }
        return Response::json(array('error' => false));
    }

    public function ajaxList()
    {
        $matRetAll = MaterialRetirado::all(array('id', 'nombre'));

        return Response::json(array('error' => false,
            'matRetirados' => $matRetAll));
    }

}