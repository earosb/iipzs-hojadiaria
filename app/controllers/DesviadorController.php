<?php

class DesviadorController extends \BaseController {

	/**
	 * Guarda un nuevo Desviador
	 * @return [type] [description]
	 */
	public function ajaxCreate()
	{
	    $input = array(
	      '_token'					=>	Input::get('_token'),
	      'nombre'					=>  Input::get('nombre'),
	      'km_inicio'  				=>  Input::get('km_inicio'),
	      'selectsectorDesviador'	=>  Input::get('selectsectorDesviador'),
	      'selectblockDesviador'	=>  Input::get('selectblockDesviador'),
	    );
	    /**
	     * Valida que el block sea mayor que cero antes de sonsultar si existe
	     */
	    if ($input['selectblockDesviador'] <= 0) {
	    	return Response::json(array(
	            'fail'		=> true,
	            'errors'	=> array(
            	'selectblockDesviador'	=>	array('Debe seleccionar un Block'))
	        ));
	    }

	    $block = Block::findOrFail($input['selectblockDesviador']);

	    $rules = array(
	        'nombre'      			=>  'required',
	        'km_inicio'      		=>  'required|numeric|between:'.$block->km_inicio.','.$block->km_termino,
	        'selectsectorDesviador'	=>  'required|numeric',
	        'selectblockDesviador'	=>  'required|numeric',
	    );

	    $validator = Validator::make($input, $rules);

	    if ($validator->fails()) {
	    	return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->messages()
	        ));
	    } else {
	    	// Crea el obj y lo guarda
	    	$desviador = new Desviador;

	    	$desviador->nombre		=	$input['nombre'];
	    	$desviador->km_inicio	=	$input['km_inicio'];
	    	$desviador->block_id 	=	$input['selectblockDesviador'];

	    	$desviador->save();

	    	return Response::json(array(
	            'fail' => false,
	        ));
	    }
	}

	/**
	 * [ajaxDesviadores description]
	 * @param  [type] $blockId [description]
	 * @return [type]          [description]
	 */
	public function ajaxDesviadores($blockId)
	{
		$desviadores = Desviador::where('block_id', '=', $blockId)->get();
		
		return Response::json(
			array(
				'desviadores' => $desviadores,
			)
		);
	}


}