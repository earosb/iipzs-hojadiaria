<?php

/**
 *
 * @author earosb
 */

class TipoMaterialRetirado extends \Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tipo_material_retirado';
	
	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [materiales description]
	 * @return [type] [description]
	 */
	public function materiales()
    {
        return $this->hasMany('MaterialRetirado');
    }
}