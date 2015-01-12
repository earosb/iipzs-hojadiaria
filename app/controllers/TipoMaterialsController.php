<?php

/**
 *
 * @author earosb
 */

class TipoMaterialsController extends \BaseController {

	/**
	 * Display a listing of tipomaterials
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipomaterials = Tipomaterial::all();

		return View::make('tipomaterials.index', compact('tipomaterials'));
	}

	/**
	 * Show the form for creating a new tipomaterial
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tipomaterials.create');
	}

	/**
	 * Store a newly created tipomaterial in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Tipomaterial::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Tipomaterial::create($data);

		return Redirect::route('tipomaterials.index');
	}

	/**
	 * Display the specified tipomaterial.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tipomaterial = Tipomaterial::findOrFail($id);

		return View::make('tipomaterials.show', compact('tipomaterial'));
	}

	/**
	 * Show the form for editing the specified tipomaterial.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipomaterial = Tipomaterial::find($id);

		return View::make('tipomaterials.edit', compact('tipomaterial'));
	}

	/**
	 * Update the specified tipomaterial in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tipomaterial = Tipomaterial::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Tipomaterial::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$tipomaterial->update($data);

		return Redirect::route('tipomaterials.index');
	}

	/**
	 * Remove the specified tipomaterial from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tipomaterial::destroy($id);

		return Redirect::route('tipomaterials.index');
	}

}
