<?php

/**
 *
 * @author earosb
 */

class TipoMantenimiento extends \Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tipo_mantenimiento';

	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [trabajos description]
	 * @return [type] [description]
	 */
	public function trabajos()
    {
        return $this->hasMany('Trabajo');
    }
}