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
    public function grupoTrabajo()
    {
        return $this->belongsTo('GrupoTrabajo');
    }

    /**
     * @return mixed
     */
    public function detalleMaterialColocado()
    {
        return $this->hasMany('DetalleMaterialColocado');
    }
}