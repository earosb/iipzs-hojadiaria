<?php

class BlockController extends \BaseController {

	/**
	 * Display a listing of block
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new block
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created block in storage.
	 * POST /block
	 * @return Response
	 */
	public function store()
	{
//		$validator = Validator::make($data = Input::all(), Block::$rules);
//
//		if ($validator->fails())
//		{
//			return Redirect::back()->withErrors($validator)->withInput();
//		}
//
//		Block::create($data);
//
//		return Redirect::route('block.index');
	}

	/**
	 * Display the specified block.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
//		$block = Block::findOrFail($id);
//
//		return View::make('block.show', compact('block'));
	}

	/**
	 * Show the form for editing the specified block.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
//		$block = Block::find($id);
//
//		return View::make('block.edit', compact('block'));
	}

	/**
	 * Update the specified block in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
//		$block = Block::findOrFail($id);
//
//		$validator = Validator::make($data = Input::all(), Block::$rules);
//
//		if ($validator->fails())
//		{
//			return Redirect::back()->withErrors($validator)->withInput();
//		}
//
//		$block->update($data);
//
//		return Redirect::route('block.index');
	}

	/**
	 * Remove the specified block from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
//		Block::destroy($id);
//
//		return Redirect::route('block.index');
	}

	/**
	 * Retorna blocks de un sector.
	 *
	 * @param  int  $sectorId
	 * @return Response
	 */
	public function ajaxBlocks($sectorId)
	{
		$blocks = Block::where('sector_id', '=', $sectorId)
			->join('sector', 'block.sector_id', '=', 'sector.id')
			->get(array('block.id', 'block.estacion', 'block.km_inicio', 'block.km_termino', 'block.sector_id', 'sector.km_inicio as sector_km_inicio', 'sector.km_termino as sector_km_termino'));
		$ramales = Ramal::where('sector_id', '=', $sectorId)->get();

		return Response::json(
			array(
				'blocks' => $blocks,
				'ramales' => $ramales
			)
		);
	}

	/**
	 * Retorna todo lo que hay dentro de un block.
	 * desvios y desviadores y datos del mismo block
	 *
	 * @param  int  $idBlock
	 * @return Response
	 */
	public function ajaxBlockTodo($idBlock)
	{
		$block = Block::find($idBlock);
		$desvios = Block::find($idBlock)->desvios;
		$desviadores = Block::find($idBlock)->desviadores;

		return Response::json(
			array(
				'block'			=> $block,
				'desvios'		=> $desvios,
				'desviadores'	=> $desviadores,
				)
			);
	}

	/**
	 * [ajaxGetLimites description]
	 * @return json
	 */
	public function ajaxGetLimites($data)
	{
		// explode() simil de función split()
		list($tipo, $id) = explode('-', $data);

		switch ($tipo) {
			case 'block':
				$block = Block::find($id);
				return Response::json(array(
					'tipo' => 'block',
					'km_inicio' =>	$block->km_inicio,
					'km_termino' => $block->km_termino
					));
				break;
			case 'desvio':
				$desvio = Desvio::find($id);
				return Response::json(array(
					'tipo' => 'desvio',
					'km_inicio' =>	$desvio->block->km_inicio,
					'km_termino' => $desvio->block->km_termino
					));
				break;
			case 'desviador':
				$desviador = Desviador::find($id);
				return Response::json(array(
					'tipo' => 'desviador',
					'km_inicio' =>	$desviador->block->km_inicio,
					));
				break;

			default:
				return "tipo ".$tipo." id ".$id;
				break;
		}

	}

	/**
	 * Retorna los desviadores existentes en el block
	 * GET /block/{id}/desviadores
	 * @param $id
	 * @return json
	 */
	public function getDesviadores($id)
	{
		try{
			$desviadores = Block::find($id)->desviadores;
			if($desviadores->isEmpty()){
				return Response::json(array(
					'error' => true,
					'msg' => 'El Block seleccionado no posee Desviadores',
				));
			}
			return Response::json(array(
				'error' => false,
				'desviadores' => $desviadores,
			));
		}
		catch (\Exception $e){
			return Response::json(array(
				'error' => true,
				'msg'	=>	'Block no encontrado. Por favor, verifique su conexión a Internet'
			));
		}
	}

}
