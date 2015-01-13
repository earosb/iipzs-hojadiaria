<?php

/**
 *
 * @author earosb
 */
class Ramal extends \Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ramal';
	
	/**
	 * [$fillable description]
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [sector description]
	 * @return [type] [description]
	 */
	public function sector()
    {
        return $this->belongsTo('Sector');
    }
}