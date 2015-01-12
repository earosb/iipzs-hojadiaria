<?php

/**
 *
 * @author earosb
 */

class MaterialsController extends \BaseController {

	/**
	 * Display a listing of materials
	 *
	 * @return Response
	 */
	public function index()
	{
		$materials = Material::all();

		return View::make('materials.index', compact('materials'));
	}

	/**
	 * Show the form for creating a new material
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('materials.create');
	}

	/**
	 * Store a newly created material in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Material::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Material::create($data);

		return Redirect::route('materials.index');
	}

	/**
	 * Display the specified material.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$material = Material::findOrFail($id);

		return View::make('materials.show', compact('material'));
	}

	/**
	 * Show the form for editing the specified material.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$material = Material::find($id);

		return View::make('materials.edit', compact('material'));
	}

	/**
	 * Update the specified material in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$material = Material::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Material::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$material->update($data);

		return Redirect::route('materials.index');
	}

	/**
	 * Remove the specified material from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Material::destroy($id);

		return Redirect::route('materials.index');
	}

}
