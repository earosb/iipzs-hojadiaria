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
     * @var array con reglas de validación
     */
    public static $rules = array(
        'nombre' => 'required',
        'selectsectorDesvio' => 'required|numeric|exists:sector,id',
        'selectblockDesvio' => 'required|numeric|exists:block,id',
        'selectdesviador_norte' => 'numeric|exists:desviador,id',
        'selectdesviador_sur' => 'numeric|exists:desviador,id',
    );

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