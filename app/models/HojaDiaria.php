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
	 * [grupoTrabajo description]
	 * @return [type] [description]
	 */
	public function grupoTrabajo()
    {
        return $this->belongsTo('GrupoTrabajo');
    }

    /**
     * [trabajosEjecutados description]
     * @return [type] [description]
     */
    public function trabajosEjecutados()
    {
        return $this->belongsToMany('TrabajoEjecutado', 'hoja_diaria_trabajo_ejecutado', 'hoja_diaria_id', 'trabajo_ejecutado_id');
    }

    /**
     * [materiales description]
     * @return [type] [description]
     */
    public function materiales()
    {
        return $this->belongsToMany('Material', 'hoja_diaria_material', 'hoja_diaria_id', 'material_id');
    }

    /**
     * [materiales description]
     * @return [type] [description]
     */
    public function materialesRetirados()
    {
        return $this->belongsToMany('MaterialRetirado', 'hoja_diaria_material_retirado', 'hoja_diaria_id', 'material_retirado_id');
    }
}