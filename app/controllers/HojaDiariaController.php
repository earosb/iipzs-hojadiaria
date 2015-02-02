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

        $materialesAll = Material::all(array('id','nombre'));
        foreach ($materialesAll as $material) {
            $materiales[$material->id] = $material->nombre;
        }

        $matRetAll = MaterialRetirado::all(array('id', 'nombre'));
        foreach ($matRetAll as $matRet) {
            $matRetirados[$matRet->id] = $matRet->nombre;
        }

        return View::make('hoja_diaria.create')
            ->with('sectores', $sectores)
            ->with('trabajos', $trabajosArray)
            ->with('grupos', $grupos)
            ->with('materiales', $materiales)
            ->with('materialesRet', $matRetirados);
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
        * Validación de fecha, obs, selectsector, selectblock y selectgrupos
        */
        $input = array(
            '_token' => Input::get('_token'),
            'fecha'  => Input::get('fecha'),
            'obs'    => Input::get('obs'),
            'selectsector' =>   Input::get('selectsector'),
            'selectblock'  =>   Input::get('selectblock'),
            'selectgrupos' =>   Input::get('selectgrupos'),
        );

        $rules = array(
            'fecha'        =>   'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector' =>   'required|exists:sector,id',
            'selectblock'  =>   'required|exists:block,id,sector_id,'.$input['selectsector'],
            'selectgrupos' =>   'required|exists:grupo_trabajo,id'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Response::json(array(
                'fail'   => true,
                'errors' => $validator->messages()
            ));
        }

        $trabajos = Input::get('trabajos');
        $matCol = Input::get('matCol');
        $matRet = Input::get('matRet');

        /**
        * Elimina los datos nulos el input oculto en el formulario
        */
        unset($trabajos[0]);
        unset($matCol[0]);
        unset($matRet[0]);

        /**
        * Validación de los trabajos
        */
/*        $rulesTrabajos = array(
            'cantidad'  =>    'required|exists:sector,id',
            'trabajo'   =>    'required|exists:sector,id',
            'ubicacion' =>    'required|exists:sector,id',
            'km_inicio' =>    'required|exists:sector,id',
            'km_termino' =>   'required|exists:sector,id',
            'cantidad'   =>   'required|exists:sector,id',
        );

        $validator = Validator::make($trabajos, $rulesTrabajos);

        if (!$validator->fails()) {
            return Response::json(array(
                'fail'   => true,
                'errors' => $validator->messages()
            ));
        }
*/
        /**
         * Validación materiales colocados
         */
        $rulesMatCol = array(
            'id'  =>    'required|exists:material,id',
            'cant'  =>  'required|numeric'
        );
        $validatorMatCol = Validator::make($matCol, $rulesMatCol);
        return $validatorMatCol;

        if ($validatorMatCol->fails()) {
            return Response::json(array(
                'fail'   => true,
                'errors' => $validatorMatCol->messages()
            ));
        }


        return 'Todo bene';
        
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
