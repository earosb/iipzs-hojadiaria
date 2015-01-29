<?php

/**
 *
 * @author earosb
 */

class Material extends \Eloquent {

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'material';
	
	/**
	 * Add your validation rules here
	 * @var [type]
	 */
	public static $rules = [
		// 'title' => 'required'
	];

	/**
	 * Don't forget to fill this array
	 * @var [type]
	 */
	protected $fillable = [];

	/**
	 * [trabajo description]
	 * @return [type] [description]
	 */
	public function trabajo()
    {
        return $this->belongsTo('Trabajo');
    }

}