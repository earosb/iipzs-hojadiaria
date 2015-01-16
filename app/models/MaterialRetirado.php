<?php

/**
 *
 * @author earosb
 */

class MaterialRetirado extends \Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'material_retirado';
	
	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [detalleMaterialRetirado description]
	 * @return [type] [description]
	 */
	public function detalleMaterialRetirado()
    {
        return $this->hasMany('DetalleMaterialRetirado');
    }
}