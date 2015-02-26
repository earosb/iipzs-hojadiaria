<?php

/**
 *
 * @author earosb
 */
class MaterialController extends \BaseController {

    /**
     * Display a listing of materials
     *
     * @return Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new material
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created material in storage.
     * POST /material-colocado
     * @return Response
     */
    public function store() {
        $input = Input::except('_token');

        $validator = Validator::make($input, Material::$rules);

        if ( $validator->fails() ) {
            return Response::json(array( 'error' => true,
                                         'msg'   => $validator->messages() ));
        }
        $material = new Material();

        $material->nombre = $input[ 'nombre' ];
        $material->valor = $input[ 'valor' ];
        $material->unidad = $input[ 'unidad' ];
        $material->proveedor = $input[ 'proveedor' ];
        $material->es_oficial = (isset($input[ 'es_oficial' ])) ? true : false;

        $material->save();

        return Response::json(array( 'error'       => false,
                                     'nuevoMatCol' => $material,
                                     'msg'         => 'Nuevo Material creado con éxito' ));
    }

    /**
     * Display the specified material.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified material.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified material in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified material from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
