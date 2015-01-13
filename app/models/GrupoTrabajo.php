<?php

/**
 *
 * @author earosb
 */
class GrupoTrabajo extends \Eloquent {
	protected $fillable = [];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'grupo_trabajo';

	/**
	 * [trabajadores description]
	 * @return [type] [description]
	 */
	public function trabajadores()
    {
        return $this->hasMany('Trabajador');
    }

    /**
     * [hojasDiarias description]
     * @return [type] [description]
     */
    public function hojasDiarias()
    {
        return $this->hasMany('HojaDiaria');
    }
}