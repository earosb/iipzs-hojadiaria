<?php

/**
 *
 * @author earosb
 */
class TrabajoController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /trabajo
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /trabajo/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /trabajo
     *
     * @return Response
     */
    public function store()
    {
        $input = array(
            '_token'     => Input::get('_token'),
            'nombre'     => Input::get('nombre'),
            'padre'      => Input::get('padre'),
            'valor'      => Input::get('valor'),
            'unidad'     => Input::get('unidad'),
            'es_oficial' => Input::get('es_oficial'),
            'tMat'       => Input::get('tMat')
        );

        $rules = array(
            'nombre' => 'required',
            'padre'  => ($input['padre'] != 'none') ? 'required|exists:trabajo,id' : 'required',
            'valor'  => 'required|numeric',
            'unidad' => 'required',
            'tMat'   => 'required|exists:tipo_mantenimiento,id',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json(
                array(
                    'error' => true,
                    'msg'   => $validator->messages()
                ));
        }

        $trabajo = new Trabajo();

        $trabajo->nombre = $input['nombre'];
        $trabajo->valor = $input['valor'];
        $trabajo->unidad = $input['unidad'];
        $trabajo->es_oficial = ($input['es_oficial'] != null) ? true : false;
        $trabajo->tipo_mantenimiento_id = $input['tMat'];
        $trabajo->padre_id = ($input['padre'] != 'none') ? $input['padre'] : null;

        $trabajo->save();

        return Response::json(array(
                                  'error'   => false,
                                  'trabajo' => $trabajo,
                                  'msg'     => 'Nuevo Material Retirado creado con éxito'
                              ));
    }

    /**
     * Display the specified resource.
     * GET /trabajo/{id}
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
     * GET /trabajo/{id}/edit
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
     * PUT /trabajo/{id}
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
     * DELETE /trabajo/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}