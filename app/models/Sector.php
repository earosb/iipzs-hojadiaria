<?php

class Sector extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sector';

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
	 * Describe la relación uno a muchos 
	 * entre Sector y sus blocks
	 * @return [type] [description]
	 */
	public function blocks()
    {
        return $this->hasMany('Block');
    }

    /**
     * [ramales description]
     * @return [type] [description]
     */
    public function ramales()
    {
        return $this->hasMany('Ramal');
    }


}