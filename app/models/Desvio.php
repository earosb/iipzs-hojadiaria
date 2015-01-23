<?php

/**
 *
 * @author earosb
 */
class Desvio extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'desvio';
	
	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [sector description]
	 * @return [type] [description]
	 */
	public function block()
    {
        return $this->belongsTo('Block');
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
     * [desviadorNorte description]
     * @return [type] [description]
     */
    public function desviadorNorte()
    {
        return $this->hasOne('Desviador');
    }

    /**
     * [desviadorSur description]
     * @return [type] [description]
     */
    public function desviadorSur()
    {
        return $this->hasOne('Desviador');
    }
}