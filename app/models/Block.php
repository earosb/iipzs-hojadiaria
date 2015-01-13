<?php

/**
 *
 * @author earosb
 */
class Block extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'block';

	/**
     * Add your validation rules here
     * @var [type]
     */
	public static $rules = [
		// 'title' => 'required'
	];

	/**
     * Cosas que se pueden modificar
     * @var array
     */
	protected $fillable = array('nombre', 'nro_bien', 'km_inicio', 'km_termino');
	
    /**
     * Cosas que no se pueden modificar
     * @var array
     */
	protected $guarded = array('id');

	/**
	 * Describe la relación entre block 
	 * y su sector
	 * @return [type] [description]
	 */
	public function sector()
    {
        return $this->belongsTo('Sector');
    }

    /**
     * [desviadores description]
     * @return [type] [description]
     */
	public function desviadores()
    {
        return $this->hasMany('Desviador');
    }

    /**
     * [desvios description]
     * @return [type] [description]
     */
    public function desvios()
    {
        return $this->hasMany('Desvio');
    }

    /**
     * [desvios description]
     * @return [type] [description]
     */
    public function ubicacionTrabajos()
    {
        return $this->hasMany('UbicacionTrabajo');
    }

}