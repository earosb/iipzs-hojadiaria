<?php

/**
 *
 * @author earosb
 */
class Desviador extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'desviador';
	
	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * Describe la relación entre block 
	 * y su sector
	 * @return [type] [description]
	 */
	public function block()
    {
        return $this->belongsTo('Block');
    }

    /**
     * [ubucacionTrabajos description]
     * @return [type] [description]
     */
    public function ubucacionTrabajos()
    {
        return $this->hasMany('UbucacionTrabajo');
    }

}