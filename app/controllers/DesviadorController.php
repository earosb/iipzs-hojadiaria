<?php

class DesviadorController extends \BaseController {

	/**
	 * Guarda un nuevo Desviador
	 * @return [type] [description]
	 */
	public function ajaxCreate()
	{
	    $inputData = array(
	      '_token'					=>	Input::get('_token'),
	      'nombre'					=>  Input::get('nombre'),
	      'km_inicio'  				=>  Input::get('km_inicio'),
	      'selectsectorDesviador'	=>  Input::get('selectsectorDesviador'),
	      'selectblockDesviador'	=>  Input::get('selectblockDesviador'),
	    );
	    /**
	     * Valida que el block sea mayor que cero antes de sonsultar si existe
	     */
	    if ($inputData['selectblockDesviador'] <= 0) {
	    	return Response::json(array(
	            'fail'		=> true,
	            'errors'	=> array(
	            	'selectblockDesviador'	=>	array('Debe seleccionar un Block'))
	        ));
	    }

	    $block = Block::find($inputData['selectblockDesviador']);

	    $rules = array(
	        'nombre'      			=>  'required',
	        'km_inicio'      		=>  'required|numeric|between:'.$block->km_inicio.','.$block->km_termino,
	        'selectsectorDesviador'	=>  'required|numeric',
	        'selectblockDesviador'	=>  'required|numeric',
	    );

	    $validator = Validator::make($inputData, $rules);

	    if ($validator->fails()) {
	    	return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->messages()
	        ));
	    } else {
	    	// Crea el obj y lo guarda
	    	$desviador = new Desviador;

	    	$desviador->nombre		=	$inputData['nombre'];
	    	$desviador->km_inicio	=	$inputData['km_inicio'];
	    	$desviador->block_id 	=	$inputData['selectblockDesviador'];

	    	$desviador->save();

	    	return Response::json(array(
	            'fail' => false,
	        ));
	    }
	}


}