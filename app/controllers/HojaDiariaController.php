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
		$sectores = Sector::all();
		$sectoresArray = array();
		foreach ($sectores as $sector) {
			$sectoresArray[$sector->id] = $sector->nombre;
		}

		$blocks = Block::where('sector_id', '=', '1')->get();
		//$ramal = Ramal::where('sector_id', '=', '1')->get();
		$blocksArray = array();
		foreach ($blocks as $block) {
			$blocksArray[$block->id] = $block->estacion;
		}

		$trabajos = Trabajo::all();
		$trabajosArray = array();
		foreach ($trabajos as $trabajo) {
			$trabajosArray[$trabajo->id] = $trabajo->nombre;
		}

		$grupos = GrupoTrabajo::all();
		foreach ($grupos as $grupo) {
			$gruposArray[$grupo->id] = $grupo->base;
		}
				
		return View::make('hoja_diaria.create')
			->with('sectores', $sectoresArray)
			->with('blocks', $blocksArray)
			->with('trabajos', $trabajosArray)
			->with('grupos', $gruposArray);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /hojadiaria
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = array(
			'_token'	=>	Input::get('_token'),
			'fecha'		=> 	Input::get('fecha'),
			'obs'		=>	Input::get('obs'),

			'selectsector'	=>	Input::get('selectsector'),
			'selectblock'	=>	Input::get('selectblock'),
			'selectgrupos'	=>	Input::get('selectgrupos'),

			'selecttrabajo'		=>	Input::get('selecttrabajo'),
			'selectubicacion'	=>	Input::get('selectubicacion'),
			'km_inicio'			=>	Input::get('km_inicio'),
			'km_termino'		=>	Input::get('km_termino'),
			'unidad'			=>	Input::get('unidad'),
			'cantidad'			=>	Input::get('cantidad'),
		);
		/**
		 * Elimina los datos nulos el input oculto del formulario
		 */
		unset($input['selecttrabajo'][0]);
		unset($input['selectubicacion'][0]);
		unset($input['km_inicio'][0]);
		unset($input['km_termino'][0]);
		unset($input['unidad'][0]);
		unset($input['cantidad'][0]);

		$sector = Sector::findOrFail(Input::get('selectsector'));
		$block = Block::findOrFail(Input::get('selectblock'));

		$hoja = new HojaDiaria;
		$hoja->fecha = $input['fecha'];
		$hoja->observaciones = $input['obs'];

		$rules = array(
            'fecha'			=>	'required|date_format:d/m/Y|before:"now +1 day"',
            'selectsector'	=>	'required|exists:sector,id',
            'selectblock'	=>	'required|exists:block,id,sector_id,'.$input['selectsector'],
            'selectgrupos'	=>	'required|exists:grupo_trabajo,id',
            'selecttrabajo'	=>	'required|exists:trabajo,id',
            
        );

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->messages()
	        ));
		}

		return $input; 
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