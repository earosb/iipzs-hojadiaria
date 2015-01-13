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
	 * [hojasDiarias description]
	 * @return [type] [description]
	 */
	public function hojasDiarias()
    {
        return $this->belongsToMany('HojaDiaria', 'hoja_diaria_material_retirado', 'id_material_retirado', 'id_hoja_diaria');
    }

    /**
     * [tipoMaterial description]
     * @return [type] [description]
     */
    public function tipoMaterial()
    {
        return $this->belongsTo('TipoMaterialRetirado');
    }
}