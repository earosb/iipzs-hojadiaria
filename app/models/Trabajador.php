<?php

/**
 *
 * @author earosb
 */
class Trabajador extends \Eloquent {
	protected $fillable = [];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trabajador';

	/**
	 * Describe la relación entre cargo 
	 * y trabajdor
	 * @return [type] [description]
	 */
	public function cargo()
    {
        return $this->belongsTo('Cargo');
    }

    /**
     * [grupo_trabajo description]
     * @return [type] [description]
     */
    public function grupoTrabajo()
    {
        return $this->belongsTo('GrupoTrabajo');
    }
}