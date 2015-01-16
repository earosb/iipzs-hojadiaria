<?php

/**
 *
 * @author earosb
 */

class DetalleHojaDiaria extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'detalle_hoja_diaria';

	/**
	 * Add your validation rules here
	 */
	public static $rules = [
		// 'title' => 'required'
	];

	/**
	 * Don't forget to fill this array
	 */
	protected $fillable = [];

	/**
	 * [hojaDiaria description]
	 * @return [type] [description]
	 */
	public function hojaDiaria()
    {
        return $this->belongsTo('HojaDiaria');
    }

    /**
     * [trabajo description]
     * @return [type] [description]
     */
    public function trabajo()
    {
        return $this->belongsTo('Trabajo');
    }

    /**
     * [block description]
     * @return [type] [description]
     */
    public function block()
    {
        return $this->belongsTo('Block');
    }

    /**
     * [desviador description]
     * @return [type] [description]
     */
    public function desviador()
    {
        return $this->belongsTo('Desviador');
    }
	
    /**
     * [desvio description]
     * @return [type] [description]
     */
	public function desvio()
    {
        return $this->belongsTo('Desvio');
    }
}