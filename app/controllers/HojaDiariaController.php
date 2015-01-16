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
		$sectoresArray[0] = '';
		foreach ($sectores as $sector) {
			$sectoresArray[$sector->id] = $sector->nombre;
		}

		$trabajos = array();
		$trabajos[0] = 'Colocación de Balasto';
		$trabajos[1] = 'Sustitución Aislada de Durmientes de Madera';
		$trabajos[2] = 'Sustitución de Durmientes de Puentes';
		$trabajos[3] = 'Sustitución de Durmientes de Desviadores';
		$trabajos[4] = 'Reemplazo Continuo de Rieles';
		$trabajos[5] = 'Sustitución Aislada de Rieles';
		
		return View::make('hoja_diaria.create')
			->with('sectores', $sectoresArray)
			->with('trabajos', $trabajos);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /hojadiaria
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$obj_php = json_encode($input);
		$sector = Sector::find(Input::get('selectsector'));
		$block = Block::find(Input::get('selectblock'));

		$hojaDiaria = new HojaDiaria;
		$hojaDiaria->fecha = Input::get('fecha');
		$hojaDiaria->observaciones = Input::get('observaciones');


		return $hojaDiaria; 
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
		return 'id hoja diaria '.$id;
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