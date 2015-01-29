<?php

/**
 *
 * @author earosb
 */

class Trabajo extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trabajo';

	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [tipoMantenimiento description]
	 * @return [type] [description]
	 */
	public function tipoMantenimiento()
    {
        return $this->belongsTo('TipoMantenimiento');
    }

    /**
     * [trabajosEjecutados description]
     * @return [type] [description]
     */
    public function detalleHojaDiaria()
    {
        return $this->hasMany('DetalleHojaDiaria');
    }

    /**
     * [alias description]
     * @return [type] [description]
     */
    public function alias()
    {
        return $this->belongsTo('Trabajo', 'padre_id');
    }
    /**
     * [nombreOficial description]
     * @return [type] [description]
     */
    public function nombreOficial()
    {
        return $this->hasMany('Trabajo', 'padre_id');
    }
    /**
     * [material description]
     * @return [type] [description]
     */
    public function materiales()
    {
        return $this->hasMany('Material');
    }
}