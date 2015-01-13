<?php

/**
 *
 * @author earosb
 */

class TrabajoEjecutado extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trabajo_ejecutado';

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
        return $this->belongsToMany('HojaDiaria', 'hoja_diaria_trabajo_ejecutado', 'id_trabajo_ejecutado', 'id_hoja_diaria');
    }

    /**
     * [trabajos description]
     * @return [type] [description]
     */
    public function trabajos()
    {
        return $this->belongsTo('Trabajo');
    }

    /**
     * [ubicacionesTrabajos description]
     * @return [type] [description]
     */
    public function ubicacionesTrabajos()
    {
        return $this->hasMany('UbicacionTrabajo');
    }
}