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
				
		return View::make('hoja_diaria.create')
			->with('sectores', $sectoresArray)
			->with('blocks', $blocksArray)
			->with('trabajos', $trabajosArray);
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