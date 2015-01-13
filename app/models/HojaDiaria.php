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
        return $this->belongsToMany('TrabajoEjecutado', 'hoja_diaria_trabajo_ejecutado', 'id_hoja_diaria', 'id_trabajo_ejecutado');
    }

    /**
     * [materiales description]
     * @return [type] [description]
     */
    public function materiales()
    {
        return $this->belongsToMany('Material', 'hoja_diaria_material', 'id_hoja_diaria', 'id_material');
    }

    /**
     * [materiales description]
     * @return [type] [description]
     */
    public function materialesRetirados()
    {
        return $this->belongsToMany('MaterialRetirado', 'hoja_diaria_material_retirado', 'id_hoja_diaria', 'id_material_retirado');
    }
}