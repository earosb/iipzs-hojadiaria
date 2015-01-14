<?php

class BlocksController extends \BaseController {

	/**
	 * Display a listing of blocks
	 *
	 * @return Response
	 */
	public function index()
	{
		$blocks = Block::all();

		return View::make('blocks.index', compact('blocks'));
	}

	/**
	 * Show the form for creating a new block
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('blocks.create');
	}

	/**
	 * Store a newly created block in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Block::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Block::create($data);

		return Redirect::route('blocks.index');
	}

	/**
	 * Display the specified block.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$block = Block::findOrFail($id);

		return View::make('blocks.show', compact('block'));
	}

	/**
	 * Show the form for editing the specified block.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$block = Block::find($id);

		return View::make('blocks.edit', compact('block'));
	}

	/**
	 * Update the specified block in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$block = Block::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Block::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$block->update($data);

		return Redirect::route('blocks.index');
	}

	/**
	 * Remove the specified block from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Block::destroy($id);

		return Redirect::route('blocks.index');
	}

	/**
	 * Retorna blocks de un sector.
	 *
	 * @param  int  $sectorId
	 * @return Response
	 */
	public function ajaxBlocks($sectorId)
	{
		$blocks = Block::where('sector_id', '=', $sectorId)->get();
		$ramales = Ramal::where('sector_id', '=', $sectorId)->get();
		return Response::json(array('blocks' => $blocks, 'ramales' => $ramales));
		// return Response::json($blocks);
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
				'block' => $block,
				'desvios' => $desvios, 
				'desviadores' => $desviadores
				)
			);
	}

}
