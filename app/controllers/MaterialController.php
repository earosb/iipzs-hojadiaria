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
        //
    }

    /**
     * Show the form for creating a new material
     *
     * @return Response
     */
    public function create()
    {
        //
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
            return Response::json(array(
                                      'error' => true,
                                      'msg'   => $validator->messages()
                                  ));
        }
        $material = new Material();

        $material->nombre = $input['nombre'];
        $material->valor = $input['valor'];
        $material->unidad = $input['unidad'];
        $material->proveedor = $input['proveedor'];
        $material->clase = $input['clase'];
        $material->es_oficial = ($input['es_oficial'] != null) ? true : false;

        $material->save();

        return Response::json(array(
                                  'error'       => false,
                                  'nuevoMatCol' => $material,
                                  'msg'         => 'Nuevo Material creado con éxito'
                              ));
    }

    /**
     * Display the specified material.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $material = Material::findOrFail($id);

        return View::make('materials.show', compact('material'));
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

        return View::make('materials.edit', compact('material'));
    }

    /**
     * Update the specified material in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $material = Material::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Material::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $material->update($data);

        return Redirect::route('materials.index');
    }

    /**
     * Remove the specified material from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Material::destroy($id);

        return Redirect::route('materials.index');
    }

}
