<?php

class SectorController extends \BaseController {

    /**
     * Display a listing of sector
     *
     * @return Response
     */
    public function index() {
        $sectores = Sector::all();

        return View::make('sector.index', compact('sectores'));
    }

    /**
     * Show the form for creating a new sector
     *
     * @return Response
     */
    public function create() {
        return View::make('sector.create');
    }

    /**
     * Store a newly created sector in storage.
     *
     * @return Response
     */
    public function store() {
        $input     = Input::all();
        $validator = Validator::make($input, Sector::$rules);

        if ( $validator->fails() ) {
            //return Redirect::back()->withErrors($validator->messages())->withInput();
            return Redirect::to('m/sector/create')->withInput()->withErrors($validator->messages());
        }

        Sector::create($input);

        return Redirect::route('m.sector.index');
    }

    /**
     * Show the form for editing the specified sector.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id) {
        $sector = Sector::findOrFail($id);

        return View::make('sector.edit', compact('sector'));
    }

    /**
     * Update the specified sector in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) {
        $sector    = Sector::findOrFail($id);
        $input     = Input::all();
        $validator = Validator::make($input, Sector::$rules);

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $sector->nombre           = $input[ 'nombre' ];
        $sector->estacion_inicio  = $input[ 'estacion_inicio' ];
        $sector->estacion_termino = $input[ 'estacion_termino' ];
        $sector->km_inicio        = $input[ 'km_inicio' ];
        $sector->km_termino       = $input[ 'km_termino' ];

        $sector->save();

        return Redirect::route('m.sector.index');
    }

    /**
     * Remove the specified sector from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) {
        Sector::destroy($id);

        //return Redirect::route('sector.index');
        return Response::json(array(
                                  'error' => false
                              ));
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function blocks($id) {

        try {
            /*$blocks = Block::where('sector_id', '=', $id)
                ->join('sector', 'block.sector_id', '=', 'sector.id')
                ->get(array( 'block.id', 'block.nro_bien', 'block.estacion', 'block.km_inicio', 'block.km_termino', 'block.sector_id', 'sector.nombre as sector_nombre' ));*/
            $sector = Sector::find($id);
            $blocks = $sector->blocks;
            return View::make('block.index', compact('blocks', 'sector'));
        } catch ( \Exception $e ) {
            App::abort(404);
        }
    }

}
