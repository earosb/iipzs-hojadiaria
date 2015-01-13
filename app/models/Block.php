<?php

class Block extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Cosas que se pueden modificar
	protected $fillable = array('nombre', 'nro_bien', 'km_inicio', 'km_termino');
	// Cosas que no se pueden modificar
	protected $guarded = array('id', 'id_sector');

}