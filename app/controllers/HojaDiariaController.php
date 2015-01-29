<?php

class HojaDiariaController extends \BaseController {

    /**
    * Display a listing of the resource.
    * GET /hd
    *
    * @return Response
    */
    public function index()
    {
        //
    }

    /**
    * Show the form for creating a new resource.
    * GET /hd/create
    *
    * @return Response
    */
    public function create()
    {
        $sectores = Sector::all(array('id','nombre'));

        $trabajos = Trabajo::all();
        $trabajosArray = array();
        foreach ($trabajos as $trabajo) {
            if (!$trabajo->materiales() != null) { //   ESTO NO FUNCIONA :(
                foreach ($trabajo->materiales as $material) {
                    $trabajosArray[$trabajo->id] = $trabajo->nombre." [".$material->unidad."]";
                }
            }else{
                $trabajosArray[$trabajo->id] = $trabajo->nombre;
            }
        }

        $grupos = GrupoTrabajo::all(array('id','base'));

        return View::make('hoja_diaria.create')
            ->with('sectores', $sectores)
            ->with('trabajos', $trabajosArray)
            ->with('grupos', $grupos);
    }

    /**
    * Store a newly created resource in storage.
    * El formulario se valida en dos partes!
    * POST /hojadiaria
    *
    * @return Response
    */
    public function store()
    {
        /**
        * Validación de fecha, obs, selectsector, selectblock y selectgrupos son válidos
        */
        $input = array(
            '_token' =>	Input::get('_token'),
            'fecha'  => Input::get('fecha'),
            'obs'    =>	Input::get('obs'),

            'selectsector' =>	Input::get('selectsector'),
            'selectblock'  =>	Input::get('selectblock'),
            'selectgrupos' =>	Input::get('selectgrupos')
        );

        $rules = array(
            'fecha'        =>	'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector' =>	'required|exists:sector,id',
            'selectblock'  =>	'required|exists:block,id,sector_id,'.$input['selectsector'],
            'selectgrupos' =>	'required|exists:grupo_trabajo,id',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'fail'   =>	true,
                'errors' =>	$validator->messages()
            ));
        }
        /**
        * Validación de los trabajos
        */
        $trabajos = array(
            'selecttrabajo'   =>	Input::get('selecttrabajo'),
            'selectubicacion' =>	Input::get('selectubicacion'),
            'km_inicio'       =>	Input::get('km_inicio'),
            'km_termino'      =>	Input::get('km_termino'),
            'unidad'          =>	Input::get('unidad'),
            'cantidad'        =>	Input::get('cantidad')
        );
        /**
        * Elimina los datos nulos el input oculto del formulario
        */
        unset($trabajos['selecttrabajo'][0]);
        unset($trabajos['selectubicacion'][0]);
        unset($trabajos['km_inicio'][0]);
        unset($trabajos['km_termino'][0]);
        unset($trabajos['unidad'][0]);
        unset($trabajos['cantidad'][0]);

        $rules = null;



        return array(
            'fail'     =>	false,
            'data'     =>	$input,
            'trabajos' =>	$trabajos
        );
    }

    /**
    * Display the specified resource.
    * GET /hd/{id}
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
        return 'show id hoja diaria '.$id;
    }

    /**
    * Show the form for editing the specified resource.
    * GET /hd/{id}/edit
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    * PUT /hd/{id}
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    * DELETE /hd/{id}
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        //
    }

}
