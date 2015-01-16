<?php

/**
 *
 * @author earosb
 */

class DetalleMaterialRetirado extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'detalle_material_retirado';

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
	 * [materialRetirado description]
	 * @return [type] [description]
	 */
	public function materialRetirado()
    {
        return $this->belongsTo('MaterialRetirado');
    }

    /**
     * [hojaDiaria description]
     * @return [type] [description]
     */
    public function hojaDiaria()
    {
        return $this->belongsTo('HojaDiaria');
    }
}