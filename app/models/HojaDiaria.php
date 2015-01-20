<?php

/**
 *
 * @author earosb
 */
class HojaDiaria extends \Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'hoja_diaria';
	
	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

    /**
     * [materiales description]
     * @return [type] [description]
     */
    public function materialesRetirados()
    {
        return $this->belongsToMany('MaterialRetirado', 'hoja_diaria_material_retirado', 'hoja_diaria_id', 'material_retirado_id');
    }

    /**
     * [detalleMaterialRetirado description]
     * @return [type] [description]
     */
    public function detalleMaterialRetirado()
    {
        return $this->hasMany('DetalleMaterialRetirado');
    }

    /**
     * [detalleHojaDiaria description]
     * @return [type] [description]
     */
    public function detalleHojaDiaria()
    {
        return $this->hasMany('DetalleHojaDiaria');
    }

    /**
     * [grupotrabajo description]
     * @return [type] [description]
     */
    public function grupotrabajo()
    {
        return $this->belongsTo('GrupoTrabajo');
    }
}