<?php

class SectorsController extends \BaseController {

	/**
	 * Display a listing of sectors
	 *
	 * @return Response
	 */
	public function index()
	{
		$sectors = Sector::all();

		return View::make('sectors.index', compact('sectors'));
	}

	/**
	 * Show the form for creating a new sector
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sectors.create');
	}

	/**
	 * Store a newly created sector in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Sector::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Sector::create($data);

		return Redirect::route('sectors.index');
	}

	/**
	 * Display the specified sector.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sector = Sector::findOrFail($id);

		return View::make('sectors.show', compact('sector'));
	}

	/**
	 * Show the form for editing the specified sector.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sector = Sector::find($id);

		return View::make('sectors.edit', compact('sector'));
	}

	/**
	 * Update the specified sector in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sector = Sector::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Sector::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$sector->update($data);

		return Redirect::route('sectors.index');
	}

	/**
	 * Remove the specified sector from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Sector::destroy($id);

		return Redirect::route('sectors.index');
	}

}
