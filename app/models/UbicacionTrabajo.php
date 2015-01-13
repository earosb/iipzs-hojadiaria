<?php

/**
 *
 * @author earosb
 */
class UbicacionTrabajo extends \Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ubicacion_trabajo';

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
     * [desvios description]
     * @return [type] [description]
     */
    public function desvios()
    {
        return $this->belongsTo('Desvio');
    }

    /**
     * [desviadores description]
     * @return [type] [description]
     */
    public function desviadores()
    {
        return $this->belongsTo('Desviador');
    }

    /**
     * [trabajosEjecutados description]
     * @return [type] [description]
     */
    public function trabajosEjecutados()
    {
        return $this->belongsTo('TrabajoEjecutado');
    }
}