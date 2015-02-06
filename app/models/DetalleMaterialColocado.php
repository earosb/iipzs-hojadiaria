<?php

/**
 *
 * @author earosb
 */

class DetalleMaterialColocado extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'detalle_material_colocado';

	/**
	 * Add your validation rules here
	 */
	public static $rules = [
		// 'title' => 'required'
	];

	/**
	 * Don't forget to fill this array
	 */
	protected $fillable = [];

	/**
	 * @return mixed
	 */
	public function material()
	{
		return $this->belongsTo('Material');
	}

	/**
	 * @return mixed
	 */
	public function hojaDiaria()
	{
		return $this->belongsTo('HojaDiaria');
	}
	
}