<?php

class DesvioController extends \BaseController {

    /**
     * Display a listing of the resource.
     * GET /desvio
     *
     * @return Response
     */
    public function index() {
        App::abort(404);
    }

    /**
     * Show the form for creating a new resource.
     * GET /desvio/create
     *
     * @return Response
     */
    public function create() {
        $sectores = Sector::all();
        return View::make('desvio.create', compact('sectores'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /desvio
     *
     * @return Response
     */
    public function store() {
        $input = array(
            '_token'                => Input::get('_token'),
            'nombre'                => Input::get('nombre'),
            'selectsectorDesvio'    => Input::get('selectsectorDesvio'),
            'selectblockDesvio'     => Input::get('selectblockDesvio'),
            'selectdesviador_norte' => Input::get('selectdesviador_norte'),
            'selectdesviador_sur'   => Input::get('selectdesviador_sur'),
        );

        $desvio = new Desvio();

        $validator = Validator::make($input, $desvio->getRules());

        if ( $validator->fails() ) {
            if ( Request::ajax() ) {
                return Response::json(array( 'error' => true,
                                             'msg'   => $validator->messages() ));
            }
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $desvio->nombre = $input[ 'nombre' ];
            $desvio->block_id = $input[ 'selectblockDesvio' ];
            if ( $input[ 'selectdesviador_norte' ] )
                $desvio->desviador_norte_id = $input[ 'selectdesviador_norte' ];
            if ( $input[ 'selectdesviador_sur' ] )
                $desvio->desviador_sur_id = $input[ 'selectdesviador_sur' ];

            $desvio->save();

            if ( Request::ajax() ) {
                return Response::json(array( 'error' => false,
                                             'msg'   => 'Nuevo Desvío creado con éxito' ));
            }
            return Redirect::to('m/block/' . $desvio->block_id);
        }

    }

    /**
     * Display the specified resource.
     * GET /desvio/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) {
        App::abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /desvio/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $desvio = Desvio::find($id);
        $sectores = Sector::all();
        return View::make('desvio.edit', compact('desvio', 'sectores'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /desvio/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /desvio/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        Desvio::destroy($id);

        return Response::json(array( 'error' => false ));
    }

}