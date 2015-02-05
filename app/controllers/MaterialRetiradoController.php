<?php

/**
 *
 * @author earosb
 */

class MaterialRetiradoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /materialretirado
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /materialretirado/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /materialretirado
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = array(
			'_token' => Input::get('_token'),
			'nombre' => Input::get('nombre'),
			'clase' => Input::get('clase'),
			'codigo' => Input::get('codigo'),
			'es_oficial' => Input::get('es_oficial'),
		);

		$rules = array(
			'nombre' => 'required',
			'clase' => 'required',
			'codigo' => 'required',
		);

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Response::json(array(
				'error' => true,
				'msg' => $validator->messages()
			));
		}else{
			$matRet = new MaterialRetirado();

			$matRet->codigo = $input['codigo'];
			$matRet->nombre = $input['nombre'];
			$matRet->clase = $input['clase'];
			if($input['es_oficial'])
				$matRet->es_oficial = true;
			else
				$matRet->es_oficial = false;
			$matRet->save();

			return Response::json(array(
				'error' => false,
				'nuevoMatRet' => $matRet,
				'msg' => 'Nuevo Material Retirado creado con éxito'
			));
		}

	}

	/**
	 * Display the specified resource.
	 * GET /materialretirado/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /materialretirado/{id}/edit
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
	 * PUT /materialretirado/{id}
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
	 * DELETE /materialretirado/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function ajaxList(){
		$matRetAll = MaterialRetirado::all(array('id', 'nombre'));

		return Response::json(array(
			'error' => false,
			'matRetirados' => $matRetAll
		));
	}

}