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
     * [ubucacionTrabajos description]
     * @return [type] [description]
     */
    public function ubucacionTrabajos()
    {
        return $this->hasMany('UbucacionTrabajo');
    }
}