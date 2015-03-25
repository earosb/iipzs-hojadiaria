<?php

/**
 *
 * @author earosb
 */
class MaterialController extends \BaseController
{

    /**
     * Display a listing of materials
     *
     * @return Response
     */
    public function index()
    {
        $materiales = Material::all();
        $matRetirados = MaterialRetirado::all();
        return View::make('material.index', compact('materiales', 'matRetirados'));
    }

    /**
     * Show the form for creating a new material
     *
     * @return Response
     */
    public function create()
    {
        return View::make('material.create');
    }

    /**
     * Store a newly created material in storage.
     * POST /material-colocado
     * @return Response
     */
    public function store()
    {
        $input = Input::except('_token');

        $validator = Validator::make($input, Material::$rules);

        if ($validator->fails()) {
            if (Request::ajax()) {
                return Response::json(array('error' => true,
                    'msg' => $validator->messages()));
            }
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $material = new Material();

        $material->nombre = $input['nombre'];
        $material->valor = $input['valor'];
        $material->unidad = $input['unidad'];
        $material->proveedor = $input['proveedor'];
        $material->es_oficial = (isset($input['es_oficial'])) ? true : false;

        $material->save();
        if (Request::ajax()) {

            return Response::json(array('error' => false,
                'nuevoMatCol' => $material,
                'msg' => 'Nuevo Material creado con éxito'));
        }
        return Redirect::to('m/material');
    }

    /**
     * Display the specified material.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        App::abort(404);
    }

    /**
     * Show the form for editing the specified material.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $material = Material::find($id);
        return View::make('material.edit', compact('material'));
    }

    /**
     * Update the specified material in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $material = Material::find($id);

        $input = Input::except('_token');

        $validator = Validator::make($input, Material::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $material->nombre = $input['nombre'];
        $material->valor = $input['valor'];
        $material->unidad = $input['unidad'];
        $material->proveedor = $input['proveedor'];
        $material->es_oficial = (isset($input['es_oficial'])) ? true : false;

        $material->save();

        return Redirect::to('m/material');
    }

    /**
     * Remove the specified material from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Material::destroy($id);
        } catch (\Exception $e) {
            return Response::json(array('error' => true,
                'msg' => $e->getMessage()));
        }
        return Response::json(array('error' => false));
    }

}
