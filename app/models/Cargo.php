<?php

/**
 *
 * @author earosb
 */

class Cargo extends \Eloquent {
	protected $fillable = [];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cargo';

	/**
	 * Describe la relación uno a muchos 
	 * entre cargo y sus trabajadores
	 * @return [type] [description]
	 */
	public function trabajadores()
    {
        return $this->hasMany('Trabajador');
    }
}