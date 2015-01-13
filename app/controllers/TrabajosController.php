<?php

class TrabajosController extends \BaseController {

	/**
	 * Display a listing of trabajos
	 *
	 * @return Response
	 */
	public function index()
	{
		$trabajos = Trabajo::all();

		return View::make('trabajos.index', compact('trabajos'));
	}

	/**
	 * Show the form for creating a new trabajo
	 *
	 * @return Response
	 */
	public function create()
	{
		$sectores = Sector::all();
		return View::make('trabajos.create')->with('sectores', $sectores);
	}

	/**
	 * Store a newly created trabajo in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Trabajo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Trabajo::create($data);

		return Redirect::route('trabajos.index');
	}

	/**
	 * Display the specified trabajo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$trabajo = Trabajo::findOrFail($id);

		return View::make('trabajos.show', compact('trabajo'));
	}

	/**
	 * Show the form for editing the specified trabajo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$trabajo = Trabajo::find($id);

		return View::make('trabajos.edit', compact('trabajo'));
	}

	/**
	 * Update the specified trabajo in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$trabajo = Trabajo::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Trabajo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$trabajo->update($data);

		return Redirect::route('trabajos.index');
	}

	/**
	 * Remove the specified trabajo from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Trabajo::destroy($id);

		return Redirect::route('trabajos.index');
	}

}
