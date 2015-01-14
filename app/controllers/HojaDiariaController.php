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
		return View::make('hoja_diaria.create')->with('sectores', $sectores);
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